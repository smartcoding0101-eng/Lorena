<?php

namespace Tests\Feature;

use App\Models\GardenHeroPhoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenHeroPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_active_hero_photo(): void
    {
        Storage::fake('garden_private');

        $user = User::factory()->create(['is_admin' => true]);
        $file = UploadedFile::fake()->image('hero_test.jpg', 600, 600);
        $path = $file->store('hero/' . $user->id, 'garden_private');

        $heroPhoto = GardenHeroPhoto::create([
            'user_id' => $user->id,
            'photo_path' => $path,
            'caption' => 'Retrato en flores',
            'is_active' => true,
        ]);

        $response = $this->get(route('hero-photos.show', $heroPhoto));
        $response->assertOk();
        $this->assertEquals('image/jpeg', $response->headers->get('Content-Type'));
    }

    public function test_guests_cannot_view_inactive_hero_photo(): void
    {
        Storage::fake('garden_private');

        $user = User::factory()->create(['is_admin' => true]);
        $file = UploadedFile::fake()->image('hero_inactive.jpg');
        $path = $file->store('hero/' . $user->id, 'garden_private');

        $heroPhoto = GardenHeroPhoto::create([
            'user_id' => $user->id,
            'photo_path' => $path,
            'is_active' => false,
        ]);

        $response = $this->get(route('hero-photos.show', $heroPhoto));
        $response->assertNotFound();
    }

    public function test_admin_can_upload_multiple_hero_photos(): void
    {
        Storage::fake('garden_private');

        $admin = User::factory()->create(['is_admin' => true]);

        $files = [
            UploadedFile::fake()->image('foto1.jpg', 800, 800),
            UploadedFile::fake()->image('foto2.png', 1000, 800),
            UploadedFile::fake()->image('foto3.webp', 600, 900),
        ];

        $response = $this->actingAs($admin)->postJson(route('admin.hero-photos.store'), [
            'photos' => $files,
            'caption' => 'Colección Primavera',
        ]);

        $response->assertCreated();
        $response->assertJsonCount(3, 'photos');
        $this->assertDatabaseCount('garden_hero_photos', 3);

        $first = GardenHeroPhoto::first();
        Storage::disk('garden_private')->assertExists($first->photo_path);
    }

    public function test_admin_can_delete_hero_photo_and_removes_from_disk(): void
    {
        Storage::fake('garden_private');

        $admin = User::factory()->create(['is_admin' => true]);
        $file = UploadedFile::fake()->image('foto_a_borrar.jpg');
        $path = $file->store('hero/' . $admin->id, 'garden_private');

        $heroPhoto = GardenHeroPhoto::create([
            'user_id' => $admin->id,
            'photo_path' => $path,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->deleteJson(route('admin.hero-photos.destroy', $heroPhoto));
        $response->assertOk();

        $this->assertDatabaseMissing('garden_hero_photos', ['id' => $heroPhoto->id]);
        Storage::disk('garden_private')->assertMissing($path);
    }

    public function test_admin_can_toggle_hero_photo_active_state(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $heroPhoto = GardenHeroPhoto::create([
            'user_id' => $admin->id,
            'photo_path' => 'hero/dummy.jpg',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->postJson(route('admin.hero-photos.toggle', $heroPhoto));
        $response->assertOk();
        $this->assertFalse($heroPhoto->fresh()->is_active);

        $response2 = $this->actingAs($admin)->postJson(route('admin.hero-photos.toggle', $heroPhoto));
        $response2->assertOk();
        $this->assertTrue($heroPhoto->fresh()->is_active);
    }

    public function test_home_page_renders_with_multiple_hero_photos(): void
    {
        Storage::fake('garden_private');

        $admin = User::factory()->create(['is_admin' => true]);
        $file1 = UploadedFile::fake()->image('hero1.jpg');
        $file2 = UploadedFile::fake()->image('hero2.jpg');

        $p1 = $file1->store('hero/' . $admin->id, 'garden_private');
        $p2 = $file2->store('hero/' . $admin->id, 'garden_private');

        GardenHeroPhoto::create(['user_id' => $admin->id, 'photo_path' => $p1, 'is_active' => true]);
        GardenHeroPhoto::create(['user_id' => $admin->id, 'photo_path' => $p2, 'is_active' => true]);

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('hero-carousel-frame', false);
        $response->assertSee('hero-slides-track', false);
        $response->assertSee('hero-dots-container', false);
    }
}
