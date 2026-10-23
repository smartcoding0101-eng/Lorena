<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\GardenPost;
use App\Models\GardenProfile;
use App\Models\GardenMedia;
use App\Policies\AlbumPhotoPolicy;
use App\Policies\AlbumPolicy;
use App\Policies\GardenPostPolicy;
use App\Policies\GardenProfilePolicy;
use App\Policies\GardenMediaPolicy;
use App\Services\GardenHomeCardService;
use App\Services\GardenNoteService;
use App\Services\TimeCapsuleService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GardenHomeCardService::class);
        $this->app->singleton(GardenNoteService::class);
        $this->app->singleton(TimeCapsuleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Album::class, AlbumPolicy::class);
        Gate::policy(AlbumPhoto::class, AlbumPhotoPolicy::class);
        Gate::policy(GardenPost::class, GardenPostPolicy::class);
        Gate::policy(GardenProfile::class, GardenProfilePolicy::class);
        Gate::policy(GardenMedia::class, GardenMediaPolicy::class);
    }
}
