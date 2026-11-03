<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\GardenMedia;
use App\Models\GardenPost;
use App\Models\TimeCapsule;
use App\Models\User;
use Database\Seeders\DynamicGardenContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalMetricsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_personal_stats(): void
    {
        $response = $this->getJson('/personal-stats');
        $response->assertStatus(401);
    }

    public function test_personal_stats_returns_accurate_guaranteed_counts(): void
    {
        $user = User::factory()->create();

        // Initially zero
        $this->actingAs($user);
        $response = $this->getJson('/personal-stats');
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'stats' => [
                    'albums' => 0,
                    'photos' => 0,
                    'favorites' => 0,
                    'diary' => 0,
                    'capsules' => 0,
                    'drafts' => 0,
                    'media' => 0,
                ],
            ]);

        // Create 2 albums with 3 photos (1 favorite)
        $album1 = $user->albums()->create(['title' => 'Álbum 1']);
        $album2 = $user->albums()->create(['title' => 'Álbum 2']);

        $user->photos()->create([
            'album_id' => $album1->id,
            'title' => 'Foto 1',
            'path' => 'p1.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 100,
            'is_favorite' => true,
        ]);
        $user->photos()->create([
            'album_id' => $album1->id,
            'title' => 'Foto 2',
            'path' => 'p2.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 100,
            'is_favorite' => false,
        ]);
        $user->photos()->create([
            'album_id' => $album2->id,
            'title' => 'Foto 3',
            'path' => 'p3.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 100,
            'is_favorite' => false,
        ]);

        // Create diary entry
        $user->gardenPosts()->create([
            'title' => 'Diario íntimo',
            'slug' => 'diario-intimo',
            'kind' => 'diary',
            'status' => 'draft',
            'body' => 'Contenido íntimo...',
        ]);

        // Create blog draft
        $user->gardenPosts()->create([
            'title' => 'Borrador de blog',
            'slug' => 'borrador-de-blog',
            'kind' => 'blog',
            'status' => 'draft',
            'body' => 'Contenido de blog...',
        ]);

        // Create time capsule
        $user->timeCapsules()->create([
            'title' => 'Cápsula 1',
            'mood' => 'love',
            'author_name' => 'Carla',
            'unlock_at' => now()->addDay(),
            'message' => 'Secreto...',
            'is_opened' => false,
        ]);

        // Create media
        $user->gardenMedia()->create([
            'title' => 'Canción',
            'media_type' => 'audio',
            'source_type' => 'external_audio',
            'source_url' => 'https://example.com/audio.mp3',
        ]);

        // Verify guaranteed counts
        $res = $this->getJson('/personal-stats');
        $res->assertOk()
            ->assertJson([
                'success' => true,
                'stats' => [
                    'albums' => 2,
                    'photos' => 3,
                    'favorites' => 1,
                    'diary' => 1,
                    'capsules' => 1,
                    'drafts' => 1,
                    'media' => 1,
                ],
            ]);
    }

    public function test_personal_sanctuary_seeder_populates_records_and_metrics(): void
    {
        $user = User::factory()->create(['name' => 'Carla Lorena']);
        $this->actingAs($user);

        DynamicGardenContentSeeder::seedPersonalSanctuary($user);

        $this->assertEquals(2, $user->albums()->count());
        $this->assertEquals(4, $user->photos()->count());
        $this->assertEquals(2, $user->photos()->where('is_favorite', true)->count());
        $this->assertEquals(2, $user->gardenPosts()->where('kind', 'diary')->count());
        $this->assertEquals(1, $user->gardenPosts()->where('kind', 'blog')->where('status', 'draft')->count());
        $this->assertEquals(2, $user->timeCapsules()->count());
        $this->assertEquals(1, $user->gardenMedia()->count());

        $response = $this->getJson('/personal-stats');
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'stats' => [
                    'albums' => 2,
                    'photos' => 4,
                    'favorites' => 2,
                    'diary' => 2,
                    'capsules' => 2,
                    'drafts' => 1,
                    'media' => 1,
                ],
            ]);
    }
}
