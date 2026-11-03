<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\GardenHeroPhoto;
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

    protected function resolveAdminProfile(): GardenProfile
    {
        $user = auth()->user()
            ?? User::where('is_admin', true)->first()
            ?? User::first();

        if (! $user) {
            abort(404, 'No se encontró un usuario administrador registrado en el sistema.');
        }

        return GardenProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'status' => 'draft',
            ]
        );
    }

    public function profile()
    {
        $profile = $this->resolveAdminProfile();
        return response()->json(['profile' => $profile->load('user')]);
    }

    public function updateProfile(Request $request)
    {
        $profile = $this->resolveAdminProfile();

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
        return response()->json(['profile' => $profile->fresh()->load('user')]);
    }

    public function uploadProfilePhoto(Request $request)
    {
        $request->validate([
            'featured_photo' => 'required|file|image|max:10240',
        ]);

        $profile = $this->resolveAdminProfile();

        if ($profile->featured_photo_path) {
            Storage::disk('garden_private')->delete($profile->featured_photo_path);
        }

        $userId = $profile->user_id;
        $path = $request->file('featured_photo')->store('profiles/' . $userId, 'garden_private');
        $profile->update(['featured_photo_path' => $path]);

        // Sincronizar también con la galería del hero
        GardenHeroPhoto::firstOrCreate(
            ['user_id' => $userId, 'photo_path' => $path],
            [
                'caption' => 'Retrato principal',
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        return response()->json([
            'profile' => $profile->fresh()->load('user'),
            'photo_url' => $profile->fresh()->featured_photo_url,
        ]);
    }

    public function deleteProfilePhoto()
    {
        $profile = $this->resolveAdminProfile();

        if ($profile->featured_photo_path) {
            Storage::disk('garden_private')->delete($profile->featured_photo_path);
            $profile->update(['featured_photo_path' => null]);
        }

        return response()->json(['profile' => $profile->fresh()->load('user')]);
    }

    public function publishProfile()
    {
        $profile = $this->resolveAdminProfile();
        $profile->update(['status' => 'published']);
        return response()->json(['profile' => $profile->fresh()->load('user')]);
    }

    public function unpublishProfile()
    {
        $profile = $this->resolveAdminProfile();
        $profile->update(['status' => 'draft']);
        return response()->json(['profile' => $profile->fresh()->load('user')]);
    }

    public function heroPhotosIndex()
    {
        $photos = GardenHeroPhoto::orderBy('sort_order')->orderByDesc('id')->get();
        return response()->json(['photos' => $photos]);
    }

    public function heroPhotosStore(Request $request)
    {
        $request->validate([
            'photos' => 'nullable|array|max:50',
            'photos.*' => 'file|image|max:20480',
            'hero_photos' => 'nullable|array|max:50',
            'hero_photos.*' => 'file|image|max:20480',
            'photo' => 'nullable|file|image|max:20480',
            'caption' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id() ?? User::where('is_admin', true)->first()?->id ?? 1;
        $files = [];

        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
        } elseif ($request->hasFile('hero_photos')) {
            $files = $request->file('hero_photos');
        } elseif ($request->hasFile('photo')) {
            $files = [$request->file('photo')];
        }

        if (empty($files)) {
            return response()->json(['message' => 'No se enviaron fotografías válidas.'], 422);
        }

        $maxOrder = GardenHeroPhoto::max('sort_order') ?? 0;
        $uploaded = [];

        foreach ($files as $index => $file) {
            $path = $file->store('hero/' . $userId, 'garden_private');
            $heroPhoto = GardenHeroPhoto::create([
                'user_id' => $userId,
                'photo_path' => $path,
                'caption' => $request->input('caption'),
                'sort_order' => $maxOrder + $index + 1,
                'is_active' => true,
            ]);
            $uploaded[] = $heroPhoto;
        }

        // Si el perfil no tiene fotografía destacada aún, asignar la primera
        $profile = $this->resolveAdminProfile();
        if (! $profile->featured_photo_path && count($uploaded) > 0) {
            $profile->update(['featured_photo_path' => $uploaded[0]->photo_path]);
        }

        return response()->json([
            'message' => count($uploaded) . ' fotografía(s) agregada(s) al hero principal con éxito.',
            'photos' => $uploaded,
        ], 201);
    }

    public function heroPhotosDestroy(GardenHeroPhoto $heroPhoto)
    {
        if ($heroPhoto->photo_path) {
            Storage::disk('garden_private')->delete($heroPhoto->photo_path);
        }
        $heroPhoto->delete();
        return response()->json(['message' => 'Fotografía eliminada del hero']);
    }

    public function heroPhotosToggle(GardenHeroPhoto $heroPhoto)
    {
        $heroPhoto->update(['is_active' => ! $heroPhoto->is_active]);
        return response()->json(['photo' => $heroPhoto]);
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

    // ==========================================
    // GALERÍA DE ARTE Y MOMENTOS (DINÁMICA)
    // ==========================================
    public function galleryIndex()
    {
        $items = \App\Models\GardenGalleryItem::orderBy('sort_order')->orderByDesc('id')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'category' => $item->category,
                'pill' => $item->pill,
                'tag_label' => $item->tag_label,
                'quote' => $item->quote,
                'image_path' => $item->image_path,
                'image_url' => $item->image_url,
                'video_url' => $item->video_url,
                'sort_order' => $item->sort_order,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),
            ];
        });

        return response()->json(['items' => $items]);
    }

    public function galleryStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:foto,video,familia,amigos,especiales',
            'pill' => 'nullable|string|max:100',
            'tag_label' => 'nullable|string|max:100',
            'quote' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:20480',
            'image_url' => 'nullable|string|max:1000',
            'video_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);

        $imagePath = $request->input('image_url');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $imagePath = $path;
        }

        if (empty($imagePath)) {
            return response()->json(['message' => 'Debes proporcionar una imagen o enlace.'], 422);
        }

        $item = \App\Models\GardenGalleryItem::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'pill' => $request->pill ?: 'Colección Carla',
            'tag_label' => $request->tag_label ?: 'FOTOGRAFÍA BOTÁNICA',
            'quote' => $request->quote,
            'image_path' => $imagePath,
            'video_url' => $request->video_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Obra agregada a la galería con éxito',
            'item' => $item->fresh(),
        ], 201);
    }

    public function galleryUpdate(Request $request, \App\Models\GardenGalleryItem $item)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|in:foto,video,familia,amigos,especiales',
            'pill' => 'nullable|string|max:100',
            'tag_label' => 'nullable|string|max:100',
            'quote' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:20480',
            'image_url' => 'nullable|string|max:1000',
            'video_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'category', 'pill', 'tag_label', 'quote', 'video_url', 'sort_order', 'is_active']);

        if ($request->hasFile('image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image_path'] = $request->input('image_url');
        }

        $item->update($data);

        return response()->json([
            'message' => 'Obra actualizada correctamente',
            'item' => $item->fresh(),
        ]);
    }

    public function galleryDestroy(\App\Models\GardenGalleryItem $item)
    {
        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }
        $item->delete();

        return response()->json(['message' => 'Obra eliminada de la galería']);
    }

    // ==========================================
    // DESTINOS & SUEÑOS (DINÁMICOS)
    // ==========================================
    public function destinationsIndex()
    {
        $destinations = \App\Models\GardenDestination::orderBy('sort_order')->orderByDesc('id')->get()->map(function ($d) {
            return [
                'id' => $d->id,
                'title' => $d->title,
                'location_tag' => $d->location_tag,
                'description' => $d->description,
                'image_path' => $d->image_path,
                'image_url' => $d->image_url,
                'sort_order' => $d->sort_order,
                'is_active' => $d->is_active,
            ];
        });

        return response()->json(['destinations' => $destinations]);
    }

    public function destinationsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location_tag' => 'required|string|max:120',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|max:20480',
            'image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);

        $imagePath = $request->input('image_url');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('destinations', 'public');
        }

        if (empty($imagePath)) {
            return response()->json(['message' => 'Debes proporcionar una imagen o enlace para el destino.'], 422);
        }

        $destination = \App\Models\GardenDestination::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'location_tag' => $request->location_tag,
            'description' => $request->description,
            'image_path' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Destino agregado al mapa de sueños',
            'destination' => $destination->fresh(),
        ], 201);
    }

    public function destinationsUpdate(Request $request, \App\Models\GardenDestination $destination)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'location_tag' => 'sometimes|required|string|max:120',
            'description' => 'sometimes|required|string|max:1000',
            'image' => 'nullable|image|max:20480',
            'image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'location_tag', 'description', 'sort_order', 'is_active']);

        if ($request->hasFile('image')) {
            if ($destination->image_path && Storage::disk('public')->exists($destination->image_path)) {
                Storage::disk('public')->delete($destination->image_path);
            }
            $data['image_path'] = $request->file('image')->store('destinations', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image_path'] = $request->input('image_url');
        }

        $destination->update($data);

        return response()->json([
            'message' => 'Destino actualizado con éxito',
            'destination' => $destination->fresh(),
        ]);
    }

    public function destinationsDestroy(\App\Models\GardenDestination $destination)
    {
        if ($destination->image_path && Storage::disk('public')->exists($destination->image_path)) {
            Storage::disk('public')->delete($destination->image_path);
        }
        $destination->delete();

        return response()->json(['message' => 'Destino eliminado del mapa de sueños']);
    }

    // ==========================================
    // POEMAS & PERGAMINOS (DINÁMICOS)
    // ==========================================
    public function poemsIndex()
    {
        $poems = \App\Models\GardenPoem::orderBy('sort_order')->orderBy('id')->get();
        return response()->json(['poems' => $poems]);
    }

    public function poemsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'mood' => 'nullable|string|max:255',
            'stanza1' => 'required|string',
            'stanza2' => 'nullable|string',
            'signature' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $poem = \App\Models\GardenPoem::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'mood' => $request->mood ?: 'Para leer con calma y una sonrisa',
            'stanza1' => $request->stanza1,
            'stanza2' => $request->stanza2,
            'signature' => $request->signature ?: 'Escrito con amor para Carla Lorena',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Poema agregado al pergamino',
            'poem' => $poem,
        ], 201);
    }

    public function poemsUpdate(Request $request, \App\Models\GardenPoem $poem)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'mood' => 'nullable|string|max:255',
            'stanza1' => 'sometimes|required|string',
            'stanza2' => 'nullable|string',
            'signature' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $poem->update($request->only(['title', 'mood', 'stanza1', 'stanza2', 'signature', 'sort_order', 'is_active']));

        return response()->json([
            'message' => 'Poema actualizado correctamente',
            'poem' => $poem,
        ]);
    }

    public function poemsDestroy(\App\Models\GardenPoem $poem)
    {
        $poem->delete();
        return response()->json(['message' => 'Poema eliminado']);
    }

}
