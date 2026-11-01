<?php

namespace Tests\Feature;

use App\Models\GardenStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_endpoint_returns_only_active_statuses_under_24_hours(): void
    {
        Storage::fake('public');

        $active = GardenStatus::create([
            'caption' => 'Rosa fresca del día',
            'image_path' => 'garden-statuses/active.jpg',
            'expires_at' => now()->addHours(12),
        ]);

        GardenStatus::create([
            'caption' => 'Estado de ayer expirado',
            'image_path' => 'garden-statuses/expired.jpg',
            'expires_at' => now()->subMinute(),
        ]);

        $response = $this->getJson(route('garden-statuses.index'));

        $response->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('statuses.0.id', $active->id)
            ->assertJsonPath('statuses.0.caption', 'Rosa fresca del día');
    }

    public function test_guests_and_non_admins_cannot_upload_or_delete_statuses(): void
    {
        Storage::fake('public');

        $status = GardenStatus::create([
            'caption' => 'Estado protegido',
            'image_path' => 'garden-statuses/protected.jpg',
            'expires_at' => now()->addHours(24),
        ]);

        $this->postJson(route('admin.garden-statuses.store'), [
            'image' => UploadedFile::fake()->image('estado.jpg'),
        ])->assertStatus(401);

        $member = User::factory()->create(['id' => 99, 'is_admin' => false]);

        $this->actingAs($member)->postJson(route('admin.garden-statuses.store'), [
            'image' => UploadedFile::fake()->image('estado.jpg'),
        ])->assertStatus(403);

        $this->actingAs($member)->deleteJson(route('admin.garden-statuses.destroy', $status))
            ->assertStatus(403);
    }

    public function test_admin_can_upload_and_delete_24h_statuses(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson(route('admin.garden-statuses.store'), [
            'caption' => 'Atardecer en el jardín',
            'images' => [
                UploadedFile::fake()->image('vertical.jpg', 600, 1200),
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('statuses.0.caption', 'Atardecer en el jardín');

        $status = GardenStatus::query()->sole();
        $this->assertTrue($status->expires_at->isFuture());
        Storage::disk('public')->assertExists($status->image_path);

        $this->actingAs($admin)->deleteJson(route('admin.garden-statuses.destroy', $status))
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('garden_statuses', 0);
    }
}
