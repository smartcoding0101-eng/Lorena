<?php

namespace Tests\Feature;

use App\Models\GardenQuizQuestion;
use App\Models\GardenQuizSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenQuizTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('garden_private');
        RateLimiter::clear('garden-quiz-start:127.0.0.1');
    }

    public function test_public_visitors_receive_only_questions_and_start_requires_ten_questions_and_authorized_reward(): void
    {
        $this->postJson(route('garden-quiz.start'))
            ->assertStatus(503)
            ->assertJsonMissingPath('question');

        $this->createQuestions(10);
        $this->postJson(route('garden-quiz.start'))
            ->assertStatus(503);

        $this->prepareReward();
        $this->postJson(route('garden-quiz.start'))
            ->assertOk()
            ->assertJsonCount(2, 'question')
            ->assertJsonStructure(['game_token', 'total', 'completed', 'question' => ['id', 'question']])
            ->assertJsonMissingPath('question.answer_hashes')
            ->assertJsonMissingPath('answer_hashes');

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Respuesta privada marcador')
            ->assertDontSee('answer_hashes');
    }

    public function test_ten_correct_answers_unlock_the_private_reward_and_a_wrong_answer_does_not(): void
    {
        $this->createQuestions(12);
        $this->prepareReward();

        $game = $this->postJson(route('garden-quiz.start'))->assertOk()->json();
        $token = $game['game_token'];
        $question = $game['question'];

        $this->get(route('garden-quiz.reward', $token))->assertNotFound();

        for ($index = 0; $index < 10; $index++) {
            $answer = $this->postJson(route('garden-quiz.answer'), [
                'game_token' => $token,
                'question_id' => $question['id'],
                'answer' => 'Respuesta privada marcador',
            ]);

            if ($index < 9) {
                $answer->assertOk()->assertJsonPath('status', 'correct');
                $question = $answer->json('question');
            } else {
                $answer->assertOk()
                    ->assertJsonPath('status', 'passed')
                    ->assertJsonPath('completed', 10);
            }
        }

        $reward = $this->get(route('garden-quiz.reward', $token))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertSame('authorized image bytes', $reward->streamedContent());

        $this->postJson(route('garden-quiz.answer'), [
            'game_token' => $token,
            'question_id' => $question['id'],
            'answer' => 'Respuesta privada marcador',
        ])->assertStatus(410);

        $failedGame = $this->postJson(route('garden-quiz.start'))->assertOk()->json();
        $failedQuestion = $failedGame['question'];
        $wrongAnswer = $this->postJson(route('garden-quiz.answer'), [
            'game_token' => $failedGame['game_token'],
            'question_id' => $failedQuestion['id'],
            'answer' => 'Respuesta que no coincide',
        ])->assertOk()
            ->assertJsonPath('status', 'failed')
            ->assertJsonMissing(['answer' => 'Respuesta privada marcador']);

        $this->assertStringNotContainsString('Respuesta privada marcador', $wrongAnswer->getContent());
        $this->get(route('garden-quiz.reward', $failedGame['game_token']))->assertNotFound();
    }

    public function test_start_is_limited_to_ten_attempts_per_hour_per_ip(): void
    {
        $this->createQuestions(10);
        $this->prepareReward();

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $this->postJson(route('garden-quiz.start'))->assertOk();
        }

        $this->postJson(route('garden-quiz.start'))
            ->assertStatus(429)
            ->assertJsonMissingPath('game_token');
        $this->assertDatabaseCount('garden_quiz_sessions', 10);
    }

    public function test_only_authenticated_owner_can_manage_questions_and_reward(): void
    {
        $this->postJson(route('garden-quiz.questions.store'), [
            'question' => 'Pregunta privada',
            'answer_variants' => ['Respuesta privada marcador'],
            'is_active' => true,
        ])->assertUnauthorized();

        $this->post(route('garden-quiz.reward.upload'), [
            'reward_image' => UploadedFile::fake()->image('reward.jpg'),
            'reward_authorized' => '1',
        ])->assertRedirect(route('login'));

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($owner);
        $response = $this->postJson(route('garden-quiz.questions.store'), [
            'question' => '¿Cuál es la respuesta secreta?',
            'answer_variants' => ['  Respuesta privada marcador  ', 'otra variante'],
            'is_active' => true,
        ])->assertCreated()
            ->assertJsonPath('question.variants_count', 2)
            ->assertJsonMissing(['answer_hashes']);

        $question = GardenQuizQuestion::query()->sole();
        $this->assertNotSame(
            GardenQuizQuestion::normalizeAnswer('Respuesta privada marcador'),
            $question->answer_hashes[0],
        );
        $this->assertTrue($question->acceptsAnswer('respuesta PRIVADA, marcador!'));

        $this->putJson(route('garden-quiz.questions.update', $question), [
            'question' => 'Pregunta editada correctamente',
            'is_active' => false,
        ])->assertOk()->assertJsonPath('question.is_active', false);
        $this->assertTrue($question->fresh()->acceptsAnswer('Respuesta privada marcador'));

        $this->putJson(route('garden-quiz.questions.update', $question), [
            'question' => 'Pregunta editada nuevamente',
            'is_active' => true,
            'answer_variants' => ['Nueva respuesta privada'],
        ])->assertOk()->assertJsonPath('question.variants_count', 1);
        $this->assertFalse($question->fresh()->acceptsAnswer('Respuesta privada marcador'));
        $this->assertTrue($question->fresh()->acceptsAnswer('Nueva respuesta privada'));

        $this->deleteJson(route('garden-quiz.questions.destroy', $question))
            ->assertOk();
        $this->assertDatabaseCount('garden_quiz_questions', 0);

        $this->actingAs($otherUser)
            ->postJson(route('garden-quiz.questions.store'), [
                'question' => 'Pregunta de otra cuenta',
                'answer_variants' => ['Respuesta'],
                'is_active' => true,
            ])
            ->assertForbidden();
        $this->assertDatabaseCount('garden_quiz_questions', 0);
    }

    public function test_reward_upload_requires_explicit_authorization_and_is_stored_privately(): void
    {
        $owner = User::factory()->create();

        $this->actingAs($owner)->from(route('home').'#conociendo-carla')
            ->post(route('garden-quiz.reward.upload'), [
                'reward_image' => UploadedFile::fake()->image('reward.jpg'),
            ])
            ->assertSessionHasErrors('reward_authorized');
        $this->assertDatabaseCount('garden_quiz_settings', 0);
        $this->assertSame([], Storage::disk('garden_private')->allFiles());

        $this->post(route('garden-quiz.reward.upload'), [
            'reward_image' => UploadedFile::fake()->image('reward.jpg'),
            'reward_authorized' => '1',
        ])->assertRedirect(route('home').'#conociendo-carla');

        $settings = GardenQuizSettings::query()->findOrFail(1);
        $this->assertNotNull($settings->reward_authorized_at);
        Storage::disk('garden_private')->assertExists($settings->reward_image_path);
        $this->assertStringStartsWith('quiz/reward/', $settings->reward_image_path);
    }

    private function createQuestions(int $count): void
    {
        for ($index = 1; $index <= $count; $index++) {
            GardenQuizQuestion::query()->create([
                'question' => "Pregunta de prueba número {$index}",
                'answer_hashes' => [GardenQuizQuestion::hashAnswer('Respuesta privada marcador')],
                'is_active' => true,
            ]);
        }
    }

    private function prepareReward(): void
    {
        Storage::disk('garden_private')->put('quiz/reward/authorized.jpg', 'authorized image bytes');
        GardenQuizSettings::query()->create([
            'id' => 1,
            'reward_image_path' => 'quiz/reward/authorized.jpg',
            'reward_authorized_at' => now(),
        ]);
    }
}
