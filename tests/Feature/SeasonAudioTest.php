<?php

namespace Tests\Feature;

use App\Models\SeasonAudio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeasonAudioTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_read_public_active_season_audios(): void
    {
        SeasonAudio::create([
            'season' => 'rain',
            'title' => 'Lluvia Serena',
            'file_path' => 'season-audios/rain_test.mp3',
            'original_name' => 'rain.mp3',
            'file_size' => 1024,
            'mime_type' => 'audio/mpeg',
            'is_active' => true,
        ]);

        SeasonAudio::create([
            'season' => 'rain',
            'title' => 'Lluvia Oculta',
            'file_path' => 'season-audios/rain_inactive.mp3',
            'original_name' => 'rain_inactive.mp3',
            'file_size' => 1024,
            'mime_type' => 'audio/mpeg',
            'is_active' => false,
        ]);

        $response = $this->getJson(route('season-audios.public'));

        $response->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('seasons.rain.0.title', 'Lluvia Serena');
    }

    public function test_guests_and_non_admins_cannot_access_or_manage_season_audios(): void
    {
        $guestResponse = $this->getJson(route('admin.season-audios.index'));
        $guestResponse->assertUnauthorized();

        $normalUser = User::factory()->create(['id' => 99, 'is_admin' => false]);

        $this->actingAs($normalUser)
            ->getJson(route('admin.season-audios.index'))
            ->assertForbidden();

        $this->actingAs($normalUser)
            ->postJson(route('admin.season-audios.store'), ['season' => 'spring'])
            ->assertForbidden();
    }

    public function test_admin_can_upload_and_manage_season_audios(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $file = UploadedFile::fake()->create('suave_brisa.mp3', 200, 'audio/mpeg');

        $response = $this->actingAs($admin)->postJson(route('admin.season-audios.store'), [
            'season' => 'spring',
            'title' => 'Brisa Primaveral',
            'files' => [$file],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true);
        $this->assertCount(1, $response->json('audios'));

        $this->assertDatabaseHas('season_audio', [
            'season' => 'spring',
            'title' => 'Brisa Primaveral',
            'original_name' => 'suave_brisa.mp3',
            'is_active' => true,
        ]);

        $audio = SeasonAudio::where('title', 'Brisa Primaveral')->first();
        $this->assertNotNull($audio);
        Storage::disk('public')->assertExists($audio->file_path);

        // Toggle active status
        $this->actingAs($admin)->postJson(route('admin.season-audios.toggle', $audio))
            ->assertOk()
            ->assertJsonPath('is_active', false);

        $this->assertFalse($audio->fresh()->is_active);

        // Update title
        $this->actingAs($admin)->putJson(route('admin.season-audios.update', $audio), [
            'season' => 'spring',
            'title' => 'Brisa Primaveral Editada',
        ])->assertOk();

        $this->assertEquals('Brisa Primaveral Editada', $audio->fresh()->title);

        // Delete audio and ensure file removal
        $this->actingAs($admin)->deleteJson(route('admin.season-audios.destroy', $audio))
            ->assertOk();

        $this->assertDatabaseMissing('season_audio', ['id' => $audio->id]);
        Storage::disk('public')->assertMissing($audio->file_path);
    }
}
