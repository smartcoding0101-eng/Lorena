<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumPhotoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\GardenPostController;
use App\Http\Controllers\GardenProfileController;
use App\Http\Controllers\GardenHeroPhotoController;
use App\Http\Controllers\GardenMediaController;
use App\Http\Controllers\GardenHomeCardController;
use App\Http\Controllers\GardenNoteController;
use App\Http\Controllers\GardenQuizController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreferenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/blog/{slug}', [GardenPostController::class, 'show'])
    ->where('slug', '[A-Za-z0-9-]+')
    ->name('blog.show');
Route::get('/profiles/{profile}/featured-photo', [GardenProfileController::class, 'featuredPhoto'])
    ->whereNumber('profile')
    ->name('profiles.featured-photo');
Route::get('/hero-photos/{heroPhoto}/image', [GardenHeroPhotoController::class, 'show'])
    ->whereNumber('heroPhoto')
    ->name('hero-photos.show');
Route::post('/games/conociendo-a-carla/start', [GardenQuizController::class, 'start'])
    ->middleware('throttle:20,1')
    ->name('garden-quiz.start');
Route::post('/games/conociendo-a-carla/answer', [GardenQuizController::class, 'answer'])
    ->middleware('throttle:60,1')
    ->name('garden-quiz.answer');
Route::get('/games/conociendo-a-carla/reward/{token}', [GardenQuizController::class, 'reward'])
    ->where('token', '[a-f0-9]{64}')
    ->name('garden-quiz.reward');

// ── Dedicatorias de Amigos para Carla Lorena ──
Route::get('/friend-dedications', [\App\Http\Controllers\FriendDedicationController::class, 'index'])->name('friend-dedications.index');
Route::post('/friend-dedications', [\App\Http\Controllers\FriendDedicationController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('friend-dedications.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/personal-stats', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        $albums = $user->albums()->with('photos')->get();
        $photosCount = max($user->photos()->count(), $albums->sum(fn ($a) => $a->photos->count()));

        return response()->json([
            'success' => true,
            'stats' => [
                'albums' => $albums->count(),
                'photos' => $photosCount,
                'favorites' => $user->photos()->where('is_favorite', true)->count(),
                'diary' => $user->gardenPosts()->where('kind', 'diary')->count(),
                'capsules' => $user->timeCapsules()->count(),
                'drafts' => $user->gardenPosts()->where('kind', 'blog')->where('status', 'draft')->count(),
                'media' => $user->gardenMedia()->count(),
            ],
        ]);
    })->name('personal-stats');

    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::post('/entertainment', [GardenMediaController::class, 'store'])->name('garden-media.store');
    Route::get('/entertainment/{media}/stream', [GardenMediaController::class, 'stream'])->name('garden-media.stream');
    Route::delete('/entertainment/{media}', [GardenMediaController::class, 'destroy'])->name('garden-media.destroy');

    // ── Cápsulas del Tiempo & Cartas Secretas ──
    Route::get('/time-capsules', [\App\Http\Controllers\TimeCapsuleController::class, 'index'])->name('time-capsules.index');
    Route::post('/time-capsules', [\App\Http\Controllers\TimeCapsuleController::class, 'store'])->name('time-capsules.store');
    Route::patch('/time-capsules/{capsule}/open', [\App\Http\Controllers\TimeCapsuleController::class, 'markOpened'])->name('time-capsules.open');
    Route::delete('/time-capsules/{capsule}', [\App\Http\Controllers\TimeCapsuleController::class, 'destroy'])->name('time-capsules.destroy');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    Route::delete('/friend-dedications/{friendDedication}', [\App\Http\Controllers\FriendDedicationController::class, 'destroy'])->name('friend-dedications.destroy');

    Route::post('/albums/{album}/photos', [AlbumPhotoController::class, 'store'])->name('albums.photos.store');
    Route::get('/photos/{photo}', [AlbumPhotoController::class, 'show'])->name('photos.show');
    Route::put('/photos/{photo}', [AlbumPhotoController::class, 'update'])->name('photos.update');
    Route::patch('/photos/{photo}/favorite', [AlbumPhotoController::class, 'favorite'])->name('photos.favorite');
    Route::delete('/photos/{photo}', [AlbumPhotoController::class, 'destroy'])->name('photos.destroy');

    Route::put('/preferences', [PreferenceController::class, 'update'])->name('preferences.update');

    Route::post('/games/conociendo-a-carla/questions', [GardenQuizController::class, 'storeQuestion'])->name('garden-quiz.questions.store');
    Route::put('/games/conociendo-a-carla/questions/{question}', [GardenQuizController::class, 'updateQuestion'])->name('garden-quiz.questions.update');
    Route::delete('/games/conociendo-a-carla/questions/{question}', [GardenQuizController::class, 'destroyQuestion'])->name('garden-quiz.questions.destroy');
    Route::post('/games/conociendo-a-carla/reward', [GardenQuizController::class, 'uploadReward'])->name('garden-quiz.reward.upload');
    Route::delete('/games/conociendo-a-carla/reward', [GardenQuizController::class, 'deleteReward'])->name('garden-quiz.reward.delete');

    Route::post('/entries', [GardenPostController::class, 'store'])->name('entries.store');
    Route::put('/profile', [GardenProfileController::class, 'save'])->name('profile.save');
    Route::put('/entries/{post}', [GardenPostController::class, 'update'])->name('entries.update');
    Route::post('/entries/{post}/publish', [GardenPostController::class, 'publish'])->name('entries.publish');
    Route::post('/entries/{post}/unpublish', [GardenPostController::class, 'unpublish'])->name('entries.unpublish');
    Route::delete('/entries/{post}', [GardenPostController::class, 'destroy'])->name('entries.destroy');

    // ── Notas y Recuerdos Contextuales de Carla por Pantalla ──
    Route::post('/garden-notes', [GardenNoteController::class, 'store'])->name('garden-notes.store');
    Route::put('/garden-notes/{note}', [GardenNoteController::class, 'update'])->name('garden-notes.update');
    Route::delete('/garden-notes/{note}', [GardenNoteController::class, 'destroy'])->name('garden-notes.destroy');
});

// Ruta pública para leer notas de cada rincón
Route::get('/garden-notes', [GardenNoteController::class, 'index'])->name('garden-notes.index');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect('/#admin');
    })->name('index');

    Route::get('users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::post('users', [AdminController::class, 'usersStore'])->name('users.store');
    Route::put('users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    Route::delete('users/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    Route::post('users/{user}/toggle-admin', [AdminController::class, 'usersToggleAdmin'])->name('users.toggle-admin');

    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/photo', [AdminController::class, 'uploadProfilePhoto'])->name('profile.photo');
    Route::delete('profile/photo', [AdminController::class, 'deleteProfilePhoto'])->name('profile.photo.delete');
    Route::post('profile/publish', [AdminController::class, 'publishProfile'])->name('profile.publish');
    Route::post('profile/unpublish', [AdminController::class, 'unpublishProfile'])->name('profile.unpublish');

    Route::get('hero-photos', [AdminController::class, 'heroPhotosIndex'])->name('hero-photos.index');
    Route::post('hero-photos', [AdminController::class, 'heroPhotosStore'])->name('hero-photos.store');
    Route::delete('hero-photos/{heroPhoto}', [AdminController::class, 'heroPhotosDestroy'])->name('hero-photos.destroy');
    Route::post('hero-photos/{heroPhoto}/toggle', [AdminController::class, 'heroPhotosToggle'])->name('hero-photos.toggle');

    Route::get('posts', [AdminController::class, 'postsIndex'])->name('posts.index');
    Route::post('posts', [AdminController::class, 'postsStore'])->name('posts.store');
    Route::put('posts/{post}', [AdminController::class, 'postsUpdate'])->name('posts.update');
    Route::delete('posts/{post}', [AdminController::class, 'postsDestroy'])->name('posts.destroy');
    Route::post('posts/{post}/publish', [AdminController::class, 'postsPublish'])->name('posts.publish');
    Route::post('posts/{post}/unpublish', [AdminController::class, 'postsUnpublish'])->name('posts.unpublish');

    Route::get('quiz-questions', [AdminController::class, 'quizQuestionsIndex'])->name('quiz-questions.index');
    Route::post('quiz-questions', [AdminController::class, 'quizQuestionsStore'])->name('quiz-questions.store');
    Route::put('quiz-questions/{question}', [AdminController::class, 'quizQuestionsUpdate'])->name('quiz-questions.update');
    Route::delete('quiz-questions/{question}', [AdminController::class, 'quizQuestionsDestroy'])->name('quiz-questions.destroy');
    Route::post('quiz-questions/{question}/toggle', [AdminController::class, 'quizQuestionsToggle'])->name('quiz-questions.toggle');
    Route::get('quiz-settings', [AdminController::class, 'quizSettings'])->name('quiz-settings');
    Route::put('quiz-settings', [AdminController::class, 'updateQuizSettings'])->name('quiz-settings.update');
    Route::post('quiz-reward', [AdminController::class, 'uploadQuizReward'])->name('quiz-reward.upload');
    Route::delete('quiz-reward', [AdminController::class, 'deleteQuizReward'])->name('quiz-reward.delete');

    Route::get('albums', [AdminController::class, 'albumsIndex'])->name('albums.index');
    Route::post('albums', [AdminController::class, 'albumsStore'])->name('albums.store');
    Route::put('albums/{album}', [AdminController::class, 'albumsUpdate'])->name('albums.update');
    Route::delete('albums/{album}', [AdminController::class, 'albumsDestroy'])->name('albums.destroy');

    Route::get('albums/{album}/photos', [AdminController::class, 'albumPhotosIndex'])->name('albums.photos.index');
    Route::post('albums/{album}/photos', [AdminController::class, 'albumPhotosStore'])->name('albums.photos.store');
    Route::put('albums/{album}/photos/{photo}', [AdminController::class, 'albumPhotosUpdate'])->name('albums.photos.update');
    Route::delete('albums/{album}/photos/{photo}', [AdminController::class, 'albumPhotosDestroy'])->name('albums.photos.destroy');
    Route::post('photos/{photo}/favorite', [AdminController::class, 'toggleFavorite'])->name('photos.favorite');

    Route::get('media', [AdminController::class, 'mediaIndex'])->name('media.index');
    Route::post('media', [AdminController::class, 'mediaStore'])->name('media.store');
    Route::put('media/{media}', [AdminController::class, 'mediaUpdate'])->name('media.update');
    Route::delete('media/{media}', [AdminController::class, 'mediaDestroy'])->name('media.destroy');

    // Galería Dinámica
    Route::get('gallery', [AdminController::class, 'galleryIndex'])->name('gallery.index');
    Route::post('gallery', [AdminController::class, 'galleryStore'])->name('gallery.store');
    Route::put('gallery/{item}', [AdminController::class, 'galleryUpdate'])->name('gallery.update');
    Route::delete('gallery/{item}', [AdminController::class, 'galleryDestroy'])->name('gallery.destroy');

    // Destinos Dinámicos (Mapa de Sueños)
    Route::get('destinations', [AdminController::class, 'destinationsIndex'])->name('destinations.index');
    Route::post('destinations', [AdminController::class, 'destinationsStore'])->name('destinations.store');
    Route::put('destinations/{destination}', [AdminController::class, 'destinationsUpdate'])->name('destinations.update');
    Route::delete('destinations/{destination}', [AdminController::class, 'destinationsDestroy'])->name('destinations.destroy');

    // Poemas Dinámicos (Pergamino de Seda)
    Route::get('poems', [AdminController::class, 'poemsIndex'])->name('poems.index');
    Route::post('poems', [AdminController::class, 'poemsStore'])->name('poems.store');
    Route::put('poems/{poem}', [AdminController::class, 'poemsUpdate'])->name('poems.update');
    Route::delete('poems/{poem}', [AdminController::class, 'poemsDestroy'])->name('poems.destroy');


    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    Route::post('home-cards', [GardenHomeCardController::class, 'store'])->name('home-cards.store');
    Route::put('home-cards/{homeCard}', [GardenHomeCardController::class, 'update'])->name('home-cards.update');
    Route::delete('home-cards/{homeCard}', [GardenHomeCardController::class, 'destroy'])->name('home-cards.destroy');

    // ── Sonidos del Clima y Estaciones (Panel de Administración) ──
    Route::get('season-audios', [\App\Http\Controllers\SeasonAudioController::class, 'adminIndex'])->name('season-audios.index');
    Route::post('season-audios', [\App\Http\Controllers\SeasonAudioController::class, 'store'])->name('season-audios.store');
    Route::put('season-audios/{seasonAudio}', [\App\Http\Controllers\SeasonAudioController::class, 'update'])->name('season-audios.update');
    Route::post('season-audios/{seasonAudio}/toggle', [\App\Http\Controllers\SeasonAudioController::class, 'toggleActive'])->name('season-audios.toggle');
    Route::delete('season-audios/{seasonAudio}', [\App\Http\Controllers\SeasonAudioController::class, 'destroy'])->name('season-audios.destroy');

    // ── Estados Efímeros 24h (Estilo WhatsApp en Inicio) ──
    Route::post('garden-statuses', [\App\Http\Controllers\GardenStatusController::class, 'store'])->name('garden-statuses.store');
    Route::delete('garden-statuses/{gardenStatus}', [\App\Http\Controllers\GardenStatusController::class, 'destroy'])->name('garden-statuses.destroy');

    // ── Bóveda Familiar "Mi Familia" (Zafiro del Mapa · Exclusivo Admin) ──
    Route::get('family-sanctuary', [\App\Http\Controllers\FamilySanctuaryController::class, 'index'])->name('family-sanctuary.index');
    Route::post('family-members', [\App\Http\Controllers\FamilySanctuaryController::class, 'storeMember'])->name('family-members.store');
    Route::post('family-members/{familyMember}', [\App\Http\Controllers\FamilySanctuaryController::class, 'updateMember'])->name('family-members.update');
    Route::delete('family-members/{familyMember}', [\App\Http\Controllers\FamilySanctuaryController::class, 'destroyMember'])->name('family-members.destroy');
    Route::post('family-memories', [\App\Http\Controllers\FamilySanctuaryController::class, 'storeMemory'])->name('family-memories.store');
    Route::post('family-memories/{familyMemory}', [\App\Http\Controllers\FamilySanctuaryController::class, 'updateMemory'])->name('family-memories.update');
    Route::delete('family-memories/{familyMemory}', [\App\Http\Controllers\FamilySanctuaryController::class, 'destroyMemory'])->name('family-memories.destroy');

    // ── Auditoría & Monitoreo de Tráfico de Usuarios ──
    Route::get('traffic', [\App\Http\Controllers\GardenTrafficController::class, 'adminIndex'])->name('traffic.index');
    Route::delete('traffic/purge', [\App\Http\Controllers\GardenTrafficController::class, 'purge'])->name('traffic.purge');
});

// Endpoint público para beacon de tráfico en la SPA
Route::post('/traffic/ping', [\App\Http\Controllers\GardenTrafficController::class, 'ping'])
    ->middleware('throttle:120,1')
    ->name('traffic.ping');

// Desbloqueo con usuario/correo y contraseña de Administrador para el Santuario Familiar (#familia)
Route::post('/family-sanctuary/unlock', [\App\Http\Controllers\FamilySanctuaryController::class, 'unlock'])
    ->middleware('throttle:15,1')
    ->name('family-sanctuary.unlock');

// Ruta pública para cargar los audios reales de cada estación en el reproductor de clima
Route::get('/season-audios', [\App\Http\Controllers\SeasonAudioController::class, 'index'])->name('season-audios.public');

// Ruta pública para leer los Estados Efímeros activos (< 24h)
Route::get('/garden-statuses', [\App\Http\Controllers\GardenStatusController::class, 'index'])->name('garden-statuses.index');

// Ruta pública de respaldo para servir archivos de almacenamiento público
Route::get('/storage/{path}', function (string $path) {
    $cleanPath = ltrim($path, '/');
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
        return \Illuminate\Support\Facades\Storage::disk('public')->response($cleanPath);
    }
    abort(404);
})->where('path', '.*')->name('storage.public.fallback');

