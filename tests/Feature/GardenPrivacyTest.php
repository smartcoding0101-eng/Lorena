<?php

namespace Tests\Feature;

use App\Models\AlbumPhoto;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenPrivacyTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_read_or_change_personal_content(): void
    {
        $owner = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Colección privada']);

        $this->get('/#albumes')->assertDontSee('Colección privada');
        $this->get('/register')->assertNotFound();
        $this->get(route('photos.show', 1))->assertRedirect(route('login'));
        $this->post(route('albums.store'), ['title' => 'Intrusión'])->assertRedirect(route('login'));
    }

    public function test_database_rejects_a_photo_linked_to_another_users_album(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Álbum privado']);

        $this->expectException(QueryException::class);

        DB::table('album_photos')->insert([
            'user_id' => $otherUser->id,
            'album_id' => $album->id,
            'path' => "{$otherUser->id}/archivo.png",
            'title' => 'Archivo no autorizado',
            'mime_type' => 'image/png',
            'file_size' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_another_user_cannot_edit_an_album_or_read_its_private_photo(): void
    {
        Storage::fake('garden_private');

        $owner = User::factory()->create();
        $visitor = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Álbum privado']);
        $path = "{$owner->id}/{$album->id}/photo.png";
        Storage::disk('garden_private')->put($path, 'private image bytes');
        $photo = $album->photos()->make([
            'title' => 'Fotografía privada',
            'mime_type' => 'image/png',
            'file_size' => 19,
        ]);
        $photo->path = $path;
        $photo->user()->associate($owner);
        $photo->save();

        $this->actingAs($visitor)
            ->put(route('albums.update', $album), ['title' => 'Cambio no autorizado'])
            ->assertForbidden();
        $this->actingAs($visitor)
            ->get(route('photos.show', $photo))
            ->assertForbidden();
        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
            'title' => 'Álbum privado',
            'user_id' => $owner->id,
        ]);
    }

    public function test_the_personal_dashboard_and_favorites_only_show_the_owners_saved_photos(): void
    {
        Storage::fake('garden_private');

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Momentos favoritos']);
        $otherAlbum = $otherUser->albums()->create(['title' => 'Colección ajena']);

        $makePhoto = function (User $user, $album, string $title, bool $favorite): AlbumPhoto {
            $path = "{$user->id}/{$album->id}/".bin2hex(random_bytes(8)).'.png';
            Storage::disk('garden_private')->put($path, 'private image bytes');
            $photo = $album->photos()->make([
                'title' => $title,
                'mime_type' => 'image/png',
                'file_size' => 19,
                'is_favorite' => $favorite,
            ]);
            $photo->path = $path;
            $photo->user()->associate($user);
            $photo->save();

            return $photo;
        };

        $makePhoto($owner, $album, 'Favorito de Carla', true);
        $makePhoto($owner, $album, 'Sin guardar', false);
        $makePhoto($otherUser, $otherAlbum, 'Favorito de otra cuenta', true);

        $this->actingAs($owner)
            ->get('/#carla')
            ->assertOk()
            ->assertSee('Favorito de Carla')
            ->assertSee('Mis favoritos')
            ->assertSee('Momentos favoritos')
            ->assertDontSee('Favorito de otra cuenta');

        $favoritesResponse = $this->get('/#favoritos')->assertOk();
        preg_match(
            '/<section class="screen" data-screen="favoritos".*?<\/section>/s',
            $favoritesResponse->getContent(),
            $favoritesMarkup,
        );

        $this->assertNotEmpty($favoritesMarkup);
        $this->assertStringContainsString('Favorito de Carla', $favoritesMarkup[0]);
        $this->assertStringNotContainsString('Sin guardar', $favoritesMarkup[0]);
        $this->assertStringNotContainsString('Favorito de otra cuenta', $favoritesMarkup[0]);
    }

    public function test_the_owner_can_upload_and_retrieve_a_private_image(): void
    {
        Storage::fake('garden_private');

        $owner = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Días especiales']);
        $image = UploadedFile::fake()->image('flor.png');

        $this->actingAs($owner)
            ->post(route('albums.photos.store', $album), [
                'title' => 'Una flor',
                'description' => 'Demostración privada.',
                'photo' => $image,
            ])
            ->assertRedirect(route('home').'#albumes');

        $photo = AlbumPhoto::query()->sole();
        Storage::disk('garden_private')->assertExists($photo->path);

        $this->get(route('photos.show', $photo))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->patch(route('photos.favorite', $photo), ['is_favorite' => true])
            ->assertRedirect(route('home').'#albumes');
        $this->patch(route('photos.favorite', $photo), [
            'is_favorite' => false,
            'return_to' => 'favoritos',
        ])->assertRedirect(route('home').'#favoritos');
        $this->patch(route('photos.favorite', $photo), [
            'is_favorite' => true,
            'return_to' => 'https://example.invalid',
        ])->assertSessionHasErrors('return_to');
        $this->put(route('photos.update', $photo), [
            'title' => 'Días de primavera',
            'description' => 'Una flor junto a la ventana.',
        ])->assertRedirect(route('home').'#albumes');

        $this->patch(route('photos.favorite', $photo), ['is_favorite' => true]);
        $this->assertDatabaseHas('album_photos', [
            'id' => $photo->id,
            'title' => 'Días de primavera',
            'is_favorite' => true,
        ]);
    }

    public function test_invalid_uploads_are_rejected_without_creating_a_photo(): void
    {
        Storage::fake('garden_private');

        $owner = User::factory()->create();
        $album = $owner->albums()->create(['title' => 'Colección']);

        $this->actingAs($owner)
            ->from(route('home').'#albumes')
            ->post(route('albums.photos.store', $album), [
                'title' => 'No es una foto',
                'photo' => UploadedFile::fake()->create('archivo.txt', 2, 'text/plain'),
            ])
            ->assertSessionHasErrors('photo');

        $this->assertDatabaseCount('album_photos', 0);
        $this->assertSame([], Storage::disk('garden_private')->allFiles());
    }

    public function test_the_owner_can_create_update_and_delete_albums_and_save_preferences(): void
    {
        $owner = User::factory()->create();

        $this->actingAs($owner)
            ->post(route('albums.store'), ['title' => 'Días bonitos'])
            ->assertRedirect(route('home').'#albumes');

        $album = $owner->albums()->sole();

        $this->put(route('albums.update', $album), [
            'title' => 'Días de primavera',
            'description' => 'Una colección personal.',
        ])->assertRedirect(route('home').'#albumes');

        $this->put(route('preferences.update'), ['theme' => 'sage'])
            ->assertRedirect(route('home').'#ajustes');

        $this->assertSame('sage', $owner->fresh()->preferences['theme']);

        $this->delete(route('albums.destroy', $album))
            ->assertRedirect(route('home').'#albumes');
        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }

    public function test_login_uses_a_hashed_password_and_creates_a_session(): void
    {
        $owner = User::factory()->create([
            'email' => 'carla@example.test',
            'password' => Hash::make('correct horse battery'),
        ]);

        $this->assertNotSame('correct horse battery', $owner->password);

        $this->post(route('login.store'), [
            'email' => 'carla@example.test',
            'password' => 'incorrect password',
        ])->assertSessionHasErrors('email');

        $this->post(route('login.store'), [
            'email' => 'carla@example.test',
            'password' => 'correct horse battery',
        ])->assertRedirect(route('home').'#carla');

        $this->assertAuthenticatedAs($owner);
    }

    public function test_login_page_is_public_but_private_management_remains_protected(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Inicia sesión');

        $this->put(route('preferences.update'), ['theme' => 'sage'])
            ->assertRedirect(route('login'));
    }

    public function test_mysql_installer_refuses_to_run_when_sqlite_is_configured(): void
    {
        $this->assertSame('sqlite', config('database.default'));

        $this->artisan('garden:install')
            ->expectsOutput('Configura DB_CONNECTION=mysql en .env antes de instalar.')
            ->assertExitCode(Command::FAILURE);

        $this->assertDatabaseCount('users', 0);
    }
}
