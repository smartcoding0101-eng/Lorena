<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GardenMedia;
use App\Models\GardenPost;
use App\Models\GardenProfile;
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
            'photos' => $albums->sum(fn ($album) => $album->photos->count()),
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
}
