<?php

namespace Tests\Feature;

use App\Models\GardenMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_owner_can_upload_play_and_remove_private_audio_and_video(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $this->actingAs($owner);

        $this->post(route('garden-media.store'), [
            'source_type' => 'upload',
            'media_type' => 'audio',
            'title' => 'Canción de prueba',
            'description' => 'Un audio privado.',
            'file' => UploadedFile::fake()->create('cancion.mp3', 32, 'audio/mpeg'),
        ])->assertRedirect(route('home').'#entretenimiento');

        $audio = GardenMedia::query()->sole();
        $this->assertSame('audio', $audio->media_type);
        $this->assertSame($owner->id, $audio->user_id);
        Storage::disk('garden_private')->assertExists($audio->path);
        Storage::disk('garden_private')->put($audio->path, str_repeat('a', 32768));

        $this->get('/#entretenimiento')
            ->assertOk()
            ->assertSee('El espacio de')
            ->assertSee('Canción de prueba')
            ->assertSee(route('garden-media.stream', $audio));

        $this->get(route('garden-media.stream', $audio))
            ->assertOk()
            ->assertHeader('Content-Type', 'audio/mpeg')
            ->assertHeader('Accept-Ranges', 'bytes')
            ->assertHeaderContains('Cache-Control', 'private')
            ->assertHeaderContains('Cache-Control', 'no-store');

        $this->get(route('garden-media.stream', $audio), ['Range' => 'bytes=0-9'])
            ->assertStatus(206)
            ->assertHeader('Content-Range', 'bytes 0-9/32768')
            ->assertHeader('Content-Length', '10');

        $this->post(route('garden-media.store'), [
            'source_type' => 'upload',
            'media_type' => 'video',
            'title' => 'Video de prueba',
            'description' => 'Un video privado.',
            'file' => UploadedFile::fake()->create('video.mp4', 48, 'video/mp4'),
        ])->assertRedirect(route('home').'#entretenimiento');

        $video = GardenMedia::query()->where('media_type', 'video')->sole();
        Storage::disk('garden_private')->assertExists($video->path);
        Storage::disk('garden_private')->put($video->path, str_repeat('v', 49152));
        $this->get('/#entretenimiento')->assertSee('Video de prueba')->assertSee('video controls');

        $this->delete(route('garden-media.destroy', $audio))
            ->assertRedirect(route('home').'#entretenimiento');
        Storage::disk('garden_private')->assertMissing($audio->path);
        $this->assertDatabaseMissing('garden_media', ['id' => $audio->id]);
    }

    public function test_the_owner_can_save_youtube_and_direct_mp3_links_privately(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $this->actingAs($owner);

        $this->post(route('garden-media.store'), [
            'source_type' => 'youtube',
            'title' => 'Video de Carla',
            'description' => 'Un video enlazado.',
            'source_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ])->assertRedirect(route('home').'#entretenimiento');

        $this->post(route('garden-media.store'), [
            'source_type' => 'external_audio',
            'title' => 'Canción externa',
            'description' => 'Un MP3 desde otro servidor.',
            'source_url' => 'https://media.example.test/music/song.mp3?list=1',
        ])->assertRedirect(route('home').'#entretenimiento');

        $youtube = GardenMedia::query()->where('source_type', 'youtube')->sole();
        $audio = GardenMedia::query()->where('source_type', 'external_audio')->sole();
        $this->assertSame('video', $youtube->media_type);
        $this->assertSame('audio', $audio->media_type);
        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $youtube->youtube_embed_url);
        $this->assertSame('https://media.example.test/music/song.mp3?list=1', $audio->source_url);
        $this->assertNull($youtube->path);
        $this->assertNull($audio->path);
        $this->assertSame([], Storage::disk('garden_private')->allFiles());

        $this->get('/#entretenimiento')
            ->assertOk()
            ->assertSee('Video de Carla')
            ->assertSee('Canción externa')
            ->assertSee('data-youtube-load', false)
            ->assertSee('youtube-nocookie.com/embed/dQw4w9WgXcQ')
            ->assertSee('referrerpolicy', false)
            ->assertDontSee('<iframe', false);

        $this->assertNull($youtube->mime_type);
        $this->assertNull($audio->mime_type);
        $this->assertSame('dQw4w9WgXcQ', GardenMedia::youtubeVideoIdFromUrl('https://youtu.be/dQw4w9WgXcQ'));
        $this->assertSame('dQw4w9WgXcQ', GardenMedia::youtubeVideoIdFromUrl('https://m.youtube.com/shorts/dQw4w9WgXcQ'));

        $this->delete(route('garden-media.destroy', $audio))
            ->assertRedirect(route('home').'#entretenimiento');
        $this->assertDatabaseMissing('garden_media', ['id' => $audio->id]);
    }

    public function test_external_links_must_be_valid_youtube_or_https_mp3_urls(): void
    {
        $owner = User::factory()->create();
        $this->actingAs($owner);

        foreach ([
            ['youtube', 'http://www.youtube.com/watch?v=dQw4w9WgXcQ'],
            ['youtube', 'https://attacker.example/watch?v=dQw4w9WgXcQ'],
            ['youtube', 'https://www.youtube.com/watch?v=invalid'],
            ['external_audio', 'http://media.example.test/song.mp3'],
            ['external_audio', 'https://media.example.test/song.wav'],
            ['external_audio', 'https://user:password@media.example.test/song.mp3'],
        ] as [$sourceType, $sourceUrl]) {
            $this->from('/#entretenimiento')
                ->post(route('garden-media.store'), [
                    'source_type' => $sourceType,
                    'title' => 'Enlace no válido',
                    'source_url' => $sourceUrl,
                ])
                ->assertSessionHasErrors('source_url');
        }

        $this->assertDatabaseCount('garden_media', 0);
    }

    public function test_guests_and_other_accounts_cannot_read_private_media(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $media = $owner->gardenMedia()->create([
            'title' => 'Audio privado',
            'media_type' => 'audio',
            'source_type' => 'upload',
            'path' => 'entertainment/'.$owner->id.'/audio.mp3',
            'mime_type' => 'audio/mpeg',
            'file_size' => 12,
        ]);
        Storage::disk('garden_private')->put($media->path, 'private bytes');
        $owner->gardenMedia()->create([
            'title' => 'Enlace privado de Carla',
            'media_type' => 'video',
            'source_type' => 'youtube',
            'source_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'path' => null,
            'mime_type' => null,
            'file_size' => null,
        ]);

        $this->get(route('garden-media.stream', $media))->assertRedirect(route('login'));
        $this->get('/#entretenimiento')
            ->assertDontSee('Audio privado')
            ->assertDontSee('Enlace privado de Carla')
            ->assertDontSee('dQw4w9WgXcQ');
        $this->actingAs($otherUser)
            ->get(route('garden-media.stream', $media))
            ->assertForbidden();
        $this->actingAs($otherUser)
            ->delete(route('garden-media.destroy', $media))
            ->assertForbidden();
        $this->assertDatabaseHas('garden_media', ['id' => $media->id, 'user_id' => $owner->id]);
    }

    public function test_invalid_and_oversized_media_uploads_are_rejected(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();

        $this->actingAs($owner)
            ->from('/#entretenimiento')
            ->post(route('garden-media.store'), [
                'source_type' => 'upload',
                'media_type' => 'audio',
                'title' => 'Documento no válido',
                'file' => UploadedFile::fake()->create('documento.txt', 10, 'text/plain'),
            ])
            ->assertSessionHasErrors('file');

        $this->from('/#entretenimiento')
            ->post(route('garden-media.store'), [
                'source_type' => 'upload',
                'media_type' => 'audio',
                'title' => 'Audio demasiado grande',
                'file' => UploadedFile::fake()->create('grande.mp3', 20481, 'audio/mpeg'),
            ])
            ->assertSessionHasErrors('file');

        $this->from('/#entretenimiento')
            ->post(route('garden-media.store'), [
                'source_type' => 'upload',
                'media_type' => 'video',
                'title' => 'Video demasiado grande',
                'file' => UploadedFile::fake()->create('grande.mp4', 102401, 'video/mp4'),
            ])
            ->assertSessionHasErrors('file');

        $this->assertDatabaseCount('garden_media', 0);
        $this->assertSame([], Storage::disk('garden_private')->allFiles());
    }

    public function test_media_stream_returns_416_for_an_unsatisfiable_byte_range(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $media = $owner->gardenMedia()->create([
            'title' => 'Audio corto',
            'media_type' => 'audio',
            'path' => 'entertainment/'.$owner->id.'/short.mp3',
            'mime_type' => 'audio/mpeg',
            'file_size' => 4,
        ]);
        Storage::disk('garden_private')->put($media->path, 'song');

        $this->actingAs($owner)
            ->get(route('garden-media.stream', $media), ['Range' => 'bytes=9-12'])
            ->assertStatus(416)
            ->assertHeader('Content-Range', 'bytes */4');
    }
}
