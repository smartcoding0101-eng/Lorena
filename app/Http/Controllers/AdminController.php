<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\GardenMedia;
use App\Models\GardenPost;
use App\Models\GardenProfile;
use App\Models\GardenQuizQuestion;
use App\Models\GardenQuizSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function usersIndex()
    {
        $users = User::orderBy('id')->paginate(20);
        return response()->json(['users' => $users]);
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);
        return response()->json(['user' => $user], 201);
    }

    public function usersUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        $user->update($validated);
        return response()->json(['user' => $user]);
    }

    public function usersDestroy(User $user)
    {
        if ($user->id === 1) {
            return response()->json(['message' => 'No se puede eliminar al administrador principal.'], 403);
        }
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }

    public function usersToggleAdmin(User $user)
    {
        if ($user->id === 1) {
            return response()->json(['message' => 'No se puede modificar al administrador principal.'], 403);
        }
        $user->is_admin = !$user->is_admin;
        $user->save();
        return response()->json(['user' => $user]);
    }

    public function profile()
    {
        $profile = GardenProfile::with('user')->firstOrNew(['user_id' => 1]);
        return response()->json(['profile' => $profile->load('user')]);
    }

    public function updateProfile(Request $request)
    {
        $profile = GardenProfile::firstOrCreate(['user_id' => 1]);

        $validated = $request->validate([
            'profession' => 'nullable|string|max:160',
            'biography' => 'nullable|string|max:5000',
            'education' => 'nullable|string|max:10000',
            'experience' => 'nullable|string|max:10000',
            'achievements' => 'nullable|string|max:10000',
            'interests' => 'nullable|string|max:10000',
            'additional_info' => 'nullable|string|max:10000',
        ]);

        $profile->update($validated);
        return response()->json(['profile' => $profile]);
    }

    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'featured_photo' => 'required|file|image|max:10240',
        ]);

        $profile = GardenProfile::firstOrCreate(['user_id' => 1]);

        if ($profile->featured_photo_path) {
            Storage::disk('garden_private')->delete($profile->featured_photo_path);
        }

        $path = $request->file('featured_photo')->store('profiles/' . auth()->id(), 'garden_private');
        $profile->update(['featured_photo_path' => $path]);

        return response()->json(['profile' => $profile]);
    }

    public function deleteProfilePhoto()
    {
        $profile = GardenProfile::firstOrCreate(['user_id' => 1]);

        if ($profile->featured_photo_path) {
            Storage::disk('garden_private')->delete($profile->featured_photo_path);
            $profile->update(['featured_photo_path' => null]);
        }

        return response()->json(['profile' => $profile]);
    }

    public function publishProfile()
    {
        $profile = GardenProfile::firstOrCreate(['user_id' => 1]);
        $profile->update(['status' => 'published']);
        return response()->json(['profile' => $profile]);
    }

    public function unpublishProfile()
    {
        $profile = GardenProfile::firstOrCreate(['user_id' => 1]);
        $profile->update(['status' => 'draft']);
        return response()->json(['profile' => $profile]);
    }

    public function postsIndex(Request $request)
    {
        $query = GardenPost::with('user')->orderByDesc('created_at');

        if ($request->filled('kind')) {
            $query->where('kind', $request->kind);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('body', 'like', "%{$request->search}%");
            });
        }

        $posts = $query->paginate(20);
        return response()->json(['posts' => $posts]);
    }

    public function postsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:160',
            'body' => 'required|string|max:30000',
            'kind' => 'required|in:blog,diary',
            'category' => 'nullable|string|max:80',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        $validated['user_id'] = auth()->id();
        $post = GardenPost::create($validated);

        return response()->json(['post' => $post], 201);
    }

    public function postsUpdate(Request $request, GardenPost $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:160',
            'body' => 'sometimes|string|max:30000',
            'category' => 'nullable|string|max:80',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'sometimes|in:draft,published',
        ]);

        $post->update($validated);
        return response()->json(['post' => $post]);
    }

    public function postsDestroy(GardenPost $post)
    {
        $post->delete();
        return response()->json(['message' => 'Publicación eliminada']);
    }

    public function postsPublish(GardenPost $post)
    {
        $post->update(['status' => 'published']);
        return response()->json(['post' => $post]);
    }

    public function postsUnpublish(GardenPost $post)
    {
        $post->update(['status' => 'draft']);
        return response()->json(['post' => $post]);
    }

    public function quizQuestionsIndex()
    {
        $questions = GardenQuizQuestion::orderBy('id')->get();
        return response()->json(['questions' => $questions]);
    }

    public function quizQuestionsStore(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer_variants' => 'required|array|min:1|max:8',
            'answer_variants.*' => 'string|max:200',
            'is_active' => 'boolean',
        ]);

        $question = GardenQuizQuestion::create([
            'question' => $validated['question'],
            'answer_hashes' => array_map([GardenQuizQuestion::class, 'hashAnswer'], $validated['answer_variants']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json(['question' => $question], 201);
    }

    public function quizQuestionsUpdate(Request $request, GardenQuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'sometimes|string|max:500',
            'answer_variants' => 'sometimes|array|min:1|max:8',
            'answer_variants.*' => 'string|max:200',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = [];
        if (isset($validated['question'])) {
            $data['question'] = $validated['question'];
        }
        if (isset($validated['answer_variants'])) {
            $data['answer_hashes'] = array_map([GardenQuizQuestion::class, 'hashAnswer'], $validated['answer_variants']);
        }
        if (isset($validated['is_active'])) {
            $data['is_active'] = $validated['is_active'];
        }

        $question->update($data);
        return response()->json(['question' => $question]);
    }

    public function quizQuestionsDestroy(GardenQuizQuestion $question)
    {
        $question->delete();
        return response()->json(['message' => 'Pregunta eliminada']);
    }

    public function quizQuestionsToggle(GardenQuizQuestion $question)
    {
        $question->update(['is_active' => !$question->is_active]);
        return response()->json(['question' => $question]);
    }

    public function quizSettings()
    {
        $settings = GardenQuizSettings::firstOrNew(['id' => 1]);
        return response()->json([
            'settings' => $settings,
            'reward_ready' => $settings->exists && $settings->reward_image_path && Storage::disk('garden_private')->exists($settings->reward_image_path),
        ]);
    }

    public function updateQuizSettings(Request $request)
    {
        $validated = $request->validate([
            'rate_limit_attempts' => 'sometimes|integer|min:1|max:100',
            'rate_limit_window' => 'sometimes|integer|min:1|max:24',
            'questions_required' => 'sometimes|integer|min:1|max:50',
        ]);

        $settings = GardenQuizSettings::firstOrCreate(['id' => 1]);
        $settings->update($validated);

        return response()->json(['settings' => $settings]);
    }

    public function uploadQuizReward(Request $request)
    {
        $request->validate([
            'reward_image' => 'required|file|image|max:10240',
            'reward_authorized' => 'required|accepted',
        ]);

        $settings = GardenQuizSettings::firstOrCreate(['id' => 1]);

        if ($settings->reward_image_path) {
            Storage::disk('garden_private')->delete($settings->reward_image_path);
        }

        $path = $request->file('reward_image')->store('quiz/reward', 'garden_private');
        $settings->update([
            'reward_image_path' => $path,
            'reward_authorized_at' => now(),
        ]);

        return response()->json(['settings' => $settings]);
    }

    public function deleteQuizReward()
    {
        $settings = GardenQuizSettings::firstOrCreate(['id' => 1]);

        if ($settings->reward_image_path) {
            Storage::disk('garden_private')->delete($settings->reward_image_path);
            $settings->update([
                'reward_image_path' => null,
                'reward_authorized_at' => null,
            ]);
        }

        return response()->json(['settings' => $settings]);
    }

    public function albumsIndex()
    {
        $albums = Album::withCount('photos')->orderByDesc('created_at')->paginate(20);
        return response()->json(['albums' => $albums]);
    }

    public function albumsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string|max:4000',
        ]);

        $album = auth()->user()->albums()->create($validated);
        return response()->json(['album' => $album], 201);
    }

    public function albumsUpdate(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:120',
            'description' => 'nullable|string|max:4000',
        ]);

        $album->update($validated);
        return response()->json(['album' => $album]);
    }

    public function albumsDestroy(Album $album)
    {
        foreach ($album->photos as $photo) {
            if ($photo->path) {
                Storage::disk('garden_private')->delete($photo->path);
            }
        }
        $album->delete();
        return response()->json(['message' => 'Álbum eliminado']);
    }

    public function albumPhotosIndex(Album $album, Request $request)
    {
        $photos = $album->photos()->orderBy('created_at')->paginate(50);
        return response()->json(['photos' => $photos]);
    }

    public function albumPhotosStore(Request $request, Album $album)
    {
        $request->validate([
            'photo' => 'required|file|image|max:10240',
            'title' => 'required|string|max:120',
            'description' => 'nullable|string|max:4000',
        ]);

        $path = $request->file('photo')->store('albums/' . $album->id, 'garden_private');

        $photo = $album->photos()->create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $path,
            'file_size' => $request->file('photo')->getSize(),
            'mime_type' => $request->file('photo')->getMimeType(),
        ]);

        return response()->json(['photo' => $photo], 201);
    }

    public function albumPhotosUpdate(Request $request, AlbumPhoto $photo)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:120',
            'description' => 'nullable|string|max:4000',
        ]);

        $photo->update($validated);
        return response()->json(['photo' => $photo]);
    }

    public function albumPhotosDestroy(AlbumPhoto $photo)
    {
        if ($photo->path) {
            Storage::disk('garden_private')->delete($photo->path);
        }
        $photo->delete();
        return response()->json(['message' => 'Foto eliminada']);
    }

    public function toggleFavorite(AlbumPhoto $photo)
    {
        $photo->update(['is_favorite' => !$photo->is_favorite]);
        return response()->json(['photo' => $photo]);
    }

    public function mediaIndex(Request $request)
    {
        $query = GardenMedia::with('user')->orderByDesc('created_at');

        if ($request->filled('source_type')) {
            $query->where('source_type', $request->source_type);
        }
        if ($request->filled('media_type')) {
            $query->where('media_type', $request->media_type);
        }

        $media = $query->paginate(20);
        return response()->json(['media' => $media]);
    }

    public function mediaStore(Request $request)
    {
        $request->validate([
            'source_type' => 'required|in:upload,youtube,external_audio',
            'media_type' => 'required|in:audio,video',
            'title' => 'required|string|max:160',
            'description' => 'nullable|string|max:4000',
            'file' => 'required_if:source_type,upload|file|max:102400',
            'source_url' => 'required_if:source_type,youtube,external_audio|url|max:2048',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'source_type' => $request->source_type,
            'media_type' => $request->media_type,
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->source_type === 'upload') {
            $file = $request->file('file');
            $path = $file->store('media/' . auth()->id(), 'garden_private');
            $data['file_path'] = $path;
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        } else {
            $data['source_url'] = $request->source_url;
            if ($request->source_type === 'youtube') {
                $data['youtube_embed_url'] = $this->getYoutubeEmbedUrl($request->source_url);
            }
        }

        $media = GardenMedia::create($data);
        return response()->json(['media' => $media], 201);
    }

    public function mediaUpdate(Request $request, GardenMedia $media)
    {
        $request->validate([
            'title' => 'sometimes|string|max:160',
            'description' => 'nullable|string|max:4000',
            'media_type' => 'sometimes|in:audio,video',
        ]);

        $data = $request->only(['title', 'description', 'media_type']);
        $media->update($data);

        return response()->json(['media' => $media]);
    }

    public function mediaDestroy(GardenMedia $media)
    {
        if ($media->file_path) {
            Storage::disk('garden_private')->delete($media->file_path);
        }
        $media->delete();
        return response()->json(['message' => 'Media eliminado']);
    }

    public function settings()
    {
        return response()->json([
            'quiz_rate_limit_attempts' => config('garden.quiz.rate_limit_attempts', 10),
            'quiz_rate_limit_window' => config('garden.quiz.rate_limit_window', 1),
            'quiz_questions_required' => config('garden.quiz.questions_required', 10),
            'max_upload_size_mb' => config('garden.upload.max_size_mb', 100),
            'allowed_image_types' => config('garden.upload.allowed_image_types', ['jpg', 'jpeg', 'png', 'webp']),
            'allowed_video_types' => config('garden.upload.allowed_video_types', ['mp4', 'webm', 'mov']),
            'allowed_audio_types' => config('garden.upload.allowed_audio_types', ['mp3', 'm4a', 'wav', 'ogg']),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'quiz_rate_limit_attempts' => 'sometimes|integer|min:1|max:100',
            'quiz_rate_limit_window' => 'sometimes|integer|min:1|max:24',
            'quiz_questions_required' => 'sometimes|integer|min:1|max:50',
            'max_upload_size_mb' => 'sometimes|integer|min:1|max:500',
        ]);

        $configPath = config_path('garden.php');

        if (!file_exists($configPath)) {
            $content = "<?php\n\nreturn [\n    'quiz' => [\n        'rate_limit_attempts' => 10,\n        'rate_limit_window' => 1,\n        'questions_required' => 10,\n    ],\n    'upload' => [\n        'max_size_mb' => 100,\n        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],\n        'allowed_video_types' => ['mp4', 'webm', 'mov'],\n        'allowed_audio_types' => ['mp3', 'm4a', 'wav', 'ogg'],\n    ],\n];\n";
            file_put_contents($configPath, $content);
        }

        $config = include $configPath;
        $config['quiz']['rate_limit_attempts'] = $validated['quiz_rate_limit_attempts'] ?? $config['quiz']['rate_limit_attempts'];
        $config['quiz']['rate_limit_window'] = $validated['quiz_rate_limit_window'] ?? $config['quiz']['rate_limit_window'];
        $config['quiz']['questions_required'] = $validated['quiz_questions_required'] ?? $config['quiz']['questions_required'];
        $config['upload']['max_size_mb'] = $validated['max_upload_size_mb'] ?? $config['upload']['max_size_mb'];

        $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        file_put_contents($configPath, $content);

        return response()->json(['message' => 'Configuración guardada', 'config' => $config]);
    }

    private function getYoutubeEmbedUrl(string $url): string
    {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }
        return $url;
    }
}