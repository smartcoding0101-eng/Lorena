<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GardenMedia;
use App\Models\GardenPost;
use App\Models\GardenProfile;
use App\Models\GardenHeroPhoto;
use App\Models\GardenGalleryItem;
use App\Models\GardenDestination;
use App\Models\GardenPoem;

use App\Models\FriendDedication;
use App\Models\GardenHomeCard;
use App\Models\GardenStatus;
use Illuminate\Support\Facades\Schema;
use App\Models\GardenQuizQuestion;
use App\Models\GardenQuizSettings;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $blogPosts = GardenPost::publishedBlog()->latest()->take(30)->get();
        $publicProfile = GardenProfile::query()
            ->where('status', 'published')
            ->with('user:id,name')
            ->latest('updated_at')
            ->first();
        $editableProfile = auth()->user()?->gardenProfile;

        if (Schema::hasTable('garden_hero_photos')) {
            if (! app()->runningUnitTests() && GardenHeroPhoto::where('is_active', true)->count() < 3) {
                $this->ensureDefaultHeroPhotos();
            }
        }

        
        if (Schema::hasTable('garden_gallery_items') && ! app()->runningUnitTests() && GardenGalleryItem::count() === 0) {
            \Database\Seeders\DynamicGardenContentSeeder::seedGallery();
        }
        if (Schema::hasTable('garden_destinations') && ! app()->runningUnitTests() && GardenDestination::count() === 0) {
            \Database\Seeders\DynamicGardenContentSeeder::seedDestinations();
        }
        if (Schema::hasTable('garden_poems') && ! app()->runningUnitTests() && GardenPoem::count() === 0) {
            \Database\Seeders\DynamicGardenContentSeeder::seedPoems();
        }
        if (auth()->check() && ! app()->runningUnitTests()) {
            \Database\Seeders\DynamicGardenContentSeeder::seedPersonalSanctuary(auth()->user());
        }

        $galleryItems = Schema::hasTable('garden_gallery_items')
            ? GardenGalleryItem::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get()
            : collect();

        $destinations = Schema::hasTable('garden_destinations')
            ? GardenDestination::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get()
            : collect();

        $gardenPoems = Schema::hasTable('garden_poems')
            ? GardenPoem::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()
            : collect();

        $heroPhotos = Schema::hasTable('garden_hero_photos')
            ? GardenHeroPhoto::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->get()
            : collect();

        $editableBlogPosts = auth()->check()
            ? auth()->user()->gardenPosts()->where('kind', 'blog')->latest()->get()
            : collect();

        $diaryPosts = auth()->check()
            ? auth()->user()->gardenPosts()->where('kind', 'diary')->latest()->get()
            : collect();

        $albums = auth()->check()
            ? auth()->user()->albums()->with('photos')->latest()->get()
            : collect();

        $gardenMedia = auth()->check()
            ? auth()->user()->gardenMedia()->latest()->get()
            : collect();

        $favoritePhotos = auth()->check()
            ? auth()->user()->photos()->where('is_favorite', true)->with('album:id,title')->latest()->get()
            : collect();

        $timeCapsules = auth()->check()
            ? auth()->user()->timeCapsules()->orderBy('unlock_at', 'asc')->get()
            : collect();

        $personalStats = [
            'albums' => $albums->count(),
            'photos' => auth()->check() ? max(auth()->user()->photos()->count(), $albums->sum(fn ($album) => $album->photos->count())) : 0,
            'favorites' => $favoritePhotos->count(),
            'drafts' => $editableBlogPosts->where('status', 'draft')->count(),
            'diary' => $diaryPosts->count(),
            'capsules' => $timeCapsules->count(),
            'media' => $gardenMedia->count(),
        ];

        $quizActiveCount = GardenQuizQuestion::active()->count();
        $quizRewardReady = $this->quizRewardIsReady();
        $isGardenQuizManager = auth()->check() && (auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true));
        $quizQuestions = $isGardenQuizManager
            ? GardenQuizQuestion::query()->latest()->get()
            : collect();

        $globalAdminStats = [
            'users' => User::count(),
            'posts' => GardenPost::count(),
            'quiz' => GardenQuizQuestion::count(),
            'albums' => Album::count(),
            'media' => GardenMedia::count(),
        ];

        $friendDedications = FriendDedication::query()->latest()->take(60)->get();
        $homeCards = GardenHomeCard::active()->orderBy('sort_order', 'asc')->get();
        $activeStatuses = collect();
        if (Schema::hasTable('garden_statuses')) {
            if (!app()->runningUnitTests() && GardenStatus::active()->count() === 0) {
                $this->ensureDefaultGardenStatuses();
            }
            $activeStatuses = GardenStatus::active()->orderBy('created_at', 'asc')->get();
        }

        $isFamilyAdmin = auth()->check() && ((auth()->user()->is_admin ?? false) || in_array(auth()->id(), [1, 2], true));
        $familyMembers = collect();
        $familyMemories = collect();
        if ($isFamilyAdmin && Schema::hasTable('family_members') && Schema::hasTable('family_memories')) {
            FamilySanctuaryController::ensureDefaultFamilyData();
            $familyMembers = \App\Models\FamilyMember::query()->orderBy('sort_order')->orderBy('id')->get();
            $familyMemories = \App\Models\FamilyMemory::query()->with('member')->orderByDesc('is_featured')->orderByDesc('id')->get();
        }

        return view('welcome', compact(
            'albums',
            'blogPosts',
            'editableProfile',
            'editableBlogPosts',
            'diaryPosts',
            'favoritePhotos',
            'gardenMedia',
            'timeCapsules',
            'friendDedications',
            'homeCards',
            'activeStatuses',
            'isFamilyAdmin',
            'familyMembers',
            'familyMemories',
            'personalStats',
            'publicProfile',
            'quizActiveCount',
            'quizRewardReady',
            'quizQuestions',
            'isGardenQuizManager',
            'globalAdminStats',
            'heroPhotos',
            'galleryItems',
            'destinations',
            'gardenPoems',
        ));
    }

    private function quizRewardIsReady(): bool
    {
        $path = GardenQuizSettings::query()->find(1)?->reward_image_path;

        return $path !== null && Storage::disk('garden_private')->exists($path);
    }

    private function ensureDefaultGardenStatuses(): void
    {
        if (GardenStatus::count() > 0 || cache()->get('garden_statuses_seeded_v1')) {
            return;
        }

        $defaults = [
            [
                'source' => public_path('images/carla-hero.jpg'),
                'target' => 'garden-statuses/estado-bienvenida-1.jpg',
                'caption' => 'Bienvenida a mi jardín secreto · Cada instante florece con el corazón ✨🌹',
                'hours' => 24,
            ],
            [
                'source' => public_path('images/hero-option-2.jpg'),
                'target' => 'garden-statuses/estado-bienvenida-2.jpg',
                'caption' => 'Luz dorada y pétalos suaves en nuestro rincón especial 🌸',
                'hours' => 22,
            ],
            [
                'source' => public_path('images/fondo-flores.jpg'),
                'target' => 'garden-statuses/estado-bienvenida-3.jpg',
                'caption' => 'Susurros botánicos del día · Un respiro de calma y armonía 🍃',
                'hours' => 20,
            ],
        ];

        foreach ($defaults as $item) {
            $imagePath = 'images/carla-hero.jpg';
            if (is_file($item['source'])) {
                Storage::disk('public')->put($item['target'], file_get_contents($item['source']));
                $imagePath = $item['target'];
            }

            GardenStatus::create([
                'user_id' => User::query()->where('is_admin', true)->value('id') ?? User::query()->value('id'),
                'caption' => $item['caption'],
                'image_path' => $imagePath,
                'expires_at' => now()->addHours($item['hours']),
            ]);
        }

        cache()->forever('garden_statuses_seeded_v1', true);
    }

    private function ensureDefaultHeroPhotos(): void
    {
        $adminUser = User::where('is_admin', true)->first() ?? User::first();
        if (! $adminUser) {
            return;
        }

        $defaults = [
            [
                'file' => public_path('images/hero-option-2.jpg'),
                'target' => 'hero/' . $adminUser->id . '/carla-doctora.jpg',
                'caption' => 'Dra. Carla Lorena · Vocación y Ternura',
                'order' => 1,
            ],
            [
                'file' => public_path('images/hero-option-1.jpg'),
                'target' => 'hero/' . $adminUser->id . '/carla-luz-natural.jpg',
                'caption' => 'Carla Lorena · Luz del Jardín',
                'order' => 2,
            ],
            [
                'file' => public_path('images/carla-hero.jpg'),
                'target' => 'hero/' . $adminUser->id . '/carla-atelier.jpg',
                'caption' => 'Carla Lorena · Belleza y Esencia',
                'order' => 3,
            ],
        ];

        $disk = Storage::disk('garden_private');

        foreach ($defaults as $item) {
            if (is_file($item['file'])) {
                if (! $disk->exists($item['target'])) {
                    $disk->put($item['target'], file_get_contents($item['file']));
                }

                GardenHeroPhoto::firstOrCreate(
                    [
                        'photo_path' => $item['target'],
                    ],
                    [
                        'user_id' => $adminUser->id,
                        'caption' => $item['caption'],
                        'sort_order' => $item['order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
