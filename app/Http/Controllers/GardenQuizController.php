<?php

namespace App\Http\Controllers;

use App\Models\GardenQuizQuestion;
use App\Models\GardenQuizSession;
use App\Models\GardenQuizSettings;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class GardenQuizController extends Controller
{
    private const QUESTIONS_PER_GAME = 10;

    private const STARTS_PER_HOUR = 10;

    public function start(Request $request): JsonResponse
    {
        $settings = GardenQuizSettings::query()->find(1);
        $disk = Storage::disk('garden_private');

        if (
            GardenQuizQuestion::active()->count() < self::QUESTIONS_PER_GAME
            || ! $settings?->reward_authorized_at
            || ! $settings->reward_image_path
            || ! $disk->exists($settings->reward_image_path)
        ) {
            return response()->json([
                'message' => 'El reto estará disponible cuando Carla prepare sus preguntas y su foto de recompensa.',
            ], 503);
        }

        $limiterKey = 'garden-quiz-start:'.$request->ip();

        if (RateLimiter::tooManyAttempts($limiterKey, self::STARTS_PER_HOUR)) {
            return response()->json([
                'message' => 'Has alcanzado el límite de partidas por ahora. Inténtalo más tarde.',
                'retry_after' => RateLimiter::availableIn($limiterKey),
            ], 429);
        }

        $questions = GardenQuizQuestion::active()
            ->inRandomOrder()
            ->take(self::QUESTIONS_PER_GAME)
            ->get(['id', 'question', 'answer_hashes']);

        if ($questions->count() !== self::QUESTIONS_PER_GAME) {
            return response()->json([
                'message' => 'El reto no está disponible por el momento.',
            ], 503);
        }

        $token = bin2hex(random_bytes(32));
        $snapshot = $questions->map(fn (GardenQuizQuestion $question): array => [
            'id' => $question->id,
            'question' => $question->question,
            'answer_hashes' => $question->answer_hashes,
        ])->all();

        GardenQuizSession::query()->where('expires_at', '<', now())->delete();
        GardenQuizSession::query()->create([
            'token_hash' => hash('sha256', $token),
            'questions_snapshot' => $snapshot,
            'current_index' => 0,
            'expires_at' => now()->addHour(),
        ]);

        RateLimiter::hit($limiterKey, 3600);

        return response()->json([
            'game_token' => $token,
            'total' => self::QUESTIONS_PER_GAME,
            'completed' => 0,
            'question' => $this->publicQuestion($snapshot[0]),
        ]);
    }

    public function answer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'game_token' => ['required', 'string', 'size:64', 'regex:/\A[a-f0-9]{64}\z/'],
            'question_id' => ['required', 'integer', 'min:1'],
            'answer' => ['required', 'string', 'min:1', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Escribe una respuesta para continuar.',
                'errors' => $validator->errors()->only(['answer']),
            ], 422);
        }

        $validated = $validator->validated();
        $tokenHash = hash('sha256', $validated['game_token']);

        $result = DB::transaction(function () use ($validated, $tokenHash): array {
            $game = GardenQuizSession::query()
                ->whereKey($tokenHash)
                ->lockForUpdate()
                ->first();

            if (
                ! $game
                || $game->expires_at->isPast()
                || $game->failed_at
                || $game->passed_at
            ) {
                return ['status' => 'unavailable'];
            }

            $question = $game->questions_snapshot[$game->current_index] ?? null;

            if (! is_array($question) || (int) $question['id'] !== (int) $validated['question_id']) {
                return ['status' => 'stale'];
            }

            $candidateHash = GardenQuizQuestion::hashAnswer($validated['answer']);
            $isCorrect = false;

            foreach ($question['answer_hashes'] ?? [] as $knownAnswerHash) {
                if (is_string($knownAnswerHash) && hash_equals($knownAnswerHash, $candidateHash)) {
                    $isCorrect = true;
                    break;
                }
            }

            if (! $isCorrect) {
                $game->update(['failed_at' => now()]);

                return ['status' => 'failed'];
            }

            $nextIndex = $game->current_index + 1;
            $game->update([
                'current_index' => $nextIndex,
                'passed_at' => $nextIndex === self::QUESTIONS_PER_GAME ? now() : null,
            ]);

            if ($nextIndex === self::QUESTIONS_PER_GAME) {
                return [
                    'status' => 'passed',
                    'completed' => self::QUESTIONS_PER_GAME,
                ];
            }

            return [
                'status' => 'correct',
                'completed' => $nextIndex,
                'question' => $this->publicQuestion($game->questions_snapshot[$nextIndex]),
            ];
        });

        return match ($result['status']) {
            'failed' => response()->json([
                'status' => 'failed',
                'message' => 'Esta respuesta no coincide. No revelaremos las respuestas; puedes volver a intentarlo en otra partida.',
            ]),
            'correct' => response()->json($result),
            'passed' => response()->json([
                'status' => 'passed',
                'completed' => $result['completed'],
                'message' => '¡Lo lograste! Acertaste las diez preguntas.',
                'reward_url' => route('garden-quiz.reward', ['token' => $validated['game_token']]),
            ]),
            'stale' => response()->json([
                'message' => 'La pregunta ya cambió. Continúa con la partida actual.',
            ], 409),
            default => response()->json([
                'message' => 'Esta partida ya terminó o ha caducado. Puedes iniciar otra.',
            ], 410),
        };
    }

    public function reward(string $token): StreamedResponse
    {
        abort_unless(preg_match('/\A[a-f0-9]{64}\z/', $token) === 1, 404);

        $game = GardenQuizSession::query()
            ->whereKey(hash('sha256', $token))
            ->whereNotNull('passed_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
        $settings = GardenQuizSettings::query()->findOrFail(1);
        abort_unless($settings->reward_authorized_at && $settings->reward_image_path, 404);

        $disk = Storage::disk('garden_private');
        abort_unless($disk->exists($settings->reward_image_path), 404);
        $extension = pathinfo($settings->reward_image_path, PATHINFO_EXTENSION);

        return $disk->response($settings->reward_image_path, 'recompensa-carla.'.$extension, [
            'Content-Type' => $disk->mimeType($settings->reward_image_path),
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'no-referrer',
        ], 'inline');
    }

    public function storeQuestion(Request $request): JsonResponse
    {
        $this->authorizeManager($request);
        $validated = $this->validatedQuestion($request, true);
        $question = GardenQuizQuestion::query()->create([
            'question' => trim($validated['question']),
            'answer_hashes' => $this->hashAnswerVariants($validated['answer_variants']),
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'message' => 'Pregunta guardada.',
            'question' => $this->adminQuestion($question),
        ], 201);
    }

    public function updateQuestion(Request $request, GardenQuizQuestion $question): JsonResponse
    {
        $this->authorizeManager($request);
        $validated = $this->validatedQuestion($request, false);
        $changes = [
            'question' => trim($validated['question']),
            'is_active' => $validated['is_active'],
        ];

        if (isset($validated['answer_variants']) && $validated['answer_variants'] !== []) {
            $changes['answer_hashes'] = $this->hashAnswerVariants($validated['answer_variants']);
        }

        $question->update($changes);

        return response()->json([
            'message' => 'Pregunta actualizada.',
            'question' => $this->adminQuestion($question->fresh()),
        ]);
    }

    public function destroyQuestion(Request $request, GardenQuizQuestion $question): JsonResponse
    {
        $this->authorizeManager($request);
        $question->delete();

        return response()->json(['message' => 'Pregunta eliminada.']);
    }

    public function uploadReward(Request $request): RedirectResponse
    {
        $this->authorizeManager($request);
        $validated = $request->validate([
            'reward_image' => ['required', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max(10240)],
            'reward_authorized' => ['required', 'accepted'],
        ]);

        $upload = $validated['reward_image'];
        $extension = $upload->guessExtension();

        if (! $extension) {
            abort(422, 'No se pudo determinar el formato de la imagen.');
        }

        $disk = Storage::disk('garden_private');
        $path = 'quiz/reward/'.Str::uuid().'.'.$extension;
        $storedPath = $disk->putFileAs(dirname($path), $upload, basename($path));

        if (! is_string($storedPath)) {
            throw new \RuntimeException('No se pudo guardar la imagen privada de recompensa.');
        }

        $oldPath = GardenQuizSettings::query()->find(1)?->reward_image_path;

        try {
            DB::transaction(fn () => GardenQuizSettings::query()->updateOrCreate(
                ['id' => 1],
                [
                    'reward_image_path' => $storedPath,
                    'reward_authorized_at' => now(),
                ],
            ));
        } catch (Throwable $exception) {
            $disk->delete($storedPath);
            throw $exception;
        }

        if ($oldPath && $oldPath !== $storedPath) {
            $disk->delete($oldPath);
        }

        return redirect()->to(route('home').'#conociendo-carla')
            ->with('status', 'La foto de recompensa autorizada quedó guardada en almacenamiento privado.');
    }

    public function deleteReward(Request $request): RedirectResponse
    {
        $this->authorizeManager($request);
        $settings = GardenQuizSettings::query()->find(1);

        if ($settings) {
            $oldPath = $settings->reward_image_path;
            $settings->update([
                'reward_image_path' => null,
                'reward_authorized_at' => null,
            ]);

            if ($oldPath) {
                Storage::disk('garden_private')->delete($oldPath);
            }
        }

        return redirect()->to(route('home').'#conociendo-carla')
            ->with('status', 'La foto de recompensa se retiró; el reto quedó pausado.');
    }

    private function validatedQuestion(Request $request, bool $creating): array
    {
        $rules = [
            'question' => ['required', 'string', 'min:5', 'max:500'],
            'is_active' => ['required', 'boolean'],
            'answer_variants' => [$creating ? 'required' : 'sometimes', 'array', 'min:'.($creating ? '1' : '0'), 'max:8'],
            'answer_variants.*' => ['required', 'string', 'min:1', 'max:160'],
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request, $creating): void {
            $variants = $request->input('answer_variants');

            if (! is_array($variants)) {
                return;
            }

            $normalized = array_map(
                GardenQuizQuestion::normalizeAnswer(...),
                array_filter($variants, 'is_string'),
            );
            $normalized = array_values(array_filter($normalized));

            if ($creating && $normalized === []) {
                $validator->errors()->add('answer_variants', 'Añade al menos una respuesta válida.');
            }

            if (count(array_unique($normalized)) !== count($normalized)) {
                $validator->errors()->add('answer_variants', 'Quita las variantes que equivalen a una misma respuesta.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Revisa la pregunta y sus respuestas.',
                'errors' => $validator->errors(),
            ], 422)->throwResponse();
        }

        return $validator->validated();
    }

    private function authorizeManager(Request $request): void
    {
        $ownerId = User::query()->orderBy('id')->value('id');

        abort_unless($ownerId !== null && (int) $request->user()->id === (int) $ownerId, 403);
    }

    private function hashAnswerVariants(array $variants): array
    {
        return collect($variants)
            ->map(fn (string $variant): string => GardenQuizQuestion::hashAnswer($variant))
            ->unique()
            ->values()
            ->all();
    }

    private function publicQuestion(array $question): array
    {
        return [
            'id' => $question['id'],
            'question' => $question['question'],
        ];
    }

    private function adminQuestion(GardenQuizQuestion $question): array
    {
        return [
            'id' => $question->id,
            'question' => $question->question,
            'is_active' => $question->is_active,
            'variants_count' => count($question->answer_hashes ?? []),
        ];
    }
}
