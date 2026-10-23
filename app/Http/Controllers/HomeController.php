<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GardenMedia;
use App\Models\GardenPost;
use App\Models\GardenProfile;
use App\Models\FriendDedication;
use App\Models\GardenHomeCard;
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

        $personalStats = [
            'albums' => $albums->count(),
            'photos' => $albums->sum(fn ($album) => $album->photos->count()),
            'favorites' => $favoritePhotos->count(),
            'drafts' => $editableBlogPosts->where('status', 'draft')->count(),
            'diary' => $diaryPosts->count(),
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

        $timeCapsules = auth()->check()
            ? auth()->user()->timeCapsules()->orderBy('unlock_at', 'asc')->get()
            : collect();

        $friendDedications = FriendDedication::query()->latest()->take(60)->get();
        $homeCards = GardenHomeCard::active()->orderBy('sort_order', 'asc')->get();

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
}
