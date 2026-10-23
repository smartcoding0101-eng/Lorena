<?php

namespace Tests\Feature;

use App\Models\GardenNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_read_notes_filtered_by_screen_key(): void
    {
        GardenNote::create([
            'screen_key' => 'jardin',
            'title' => 'Flores en primavera',
            'content' => 'Las rosas han comenzado a florecer.',
            'author_name' => 'Carla Lorena',
            'mood' => 'love',
            'is_pinned' => true,
        ]);

        GardenNote::create([
            'screen_key' => 'mapa',
            'title' => 'Rincón del mapa',
            'content' => 'Senderos secretos.',
            'author_name' => 'Adrián',
            'mood' => 'dream',
            'is_pinned' => false,
        ]);

        $response = $this->getJson(route('garden-notes.index', ['screen' => 'jardin']));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'screen' => 'jardin',
            ]);

        $notes = $response->json('notes');
        $this->assertCount(1, $notes);
        $this->assertSame('Flores en primavera', $notes[0]['title']);
        $this->assertTrue($notes[0]['is_pinned']);
    }

    public function test_guests_cannot_create_or_update_or_delete_notes(): void
    {
        $this->postJson(route('garden-notes.store'), [
            'screen_key' => 'jardin',
            'content' => 'Nota no autorizada',
        ])->assertUnauthorized();

        $note = GardenNote::create([
            'screen_key' => 'jardin',
            'content' => 'Nota original',
            'author_name' => 'Carla',
            'mood' => 'love',
        ]);

        $this->putJson(route('garden-notes.update', $note), [
            'content' => 'Cambio no autorizado',
        ])->assertUnauthorized();

        $this->deleteJson(route('garden-notes.destroy', $note))
            ->assertUnauthorized();

        $this->assertDatabaseHas('garden_notes', ['id' => $note->id]);
    }

    public function test_authenticated_user_can_create_note_with_image_attachment(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['name' => 'Carla Lorena']);
        $this->actingAs($user);

        $response = $this->postJson(route('garden-notes.store'), [
            'screen_key' => 'biblioteca',
            'title' => 'Poema favorito',
            'content' => 'Caminante no hay camino, se hace camino al andar...',
            'author_name' => 'Carla',
            'mood' => 'gratitude',
            'is_pinned' => true,
            'image' => UploadedFile::fake()->image('poema.png', 400, 400),
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'note' => [
                    'screen_key' => 'biblioteca',
                    'title' => 'Poema favorito',
                    'mood' => 'gratitude',
                    'is_pinned' => true,
                ],
            ]);

        $note = GardenNote::query()->sole();
        $this->assertSame($user->id, $note->user_id);
        $this->assertNotNull($note->image_path);
        Storage::disk('public')->assertExists($note->image_path);
    }

    public function test_updating_note_can_replace_or_remove_attached_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $image1 = UploadedFile::fake()->image('foto1.jpg', 300, 300);
        $path1 = $image1->store('garden-notes', 'public');

        $note = GardenNote::create([
            'screen_key' => 'inicio',
            'title' => 'Título Inicial',
            'content' => 'Contenido inicial',
            'author_name' => 'Carla',
            'mood' => 'joy',
            'image_path' => $path1,
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists($path1);

        // Actualizar y remover imagen
        $response = $this->putJson(route('garden-notes.update', $note), [
            'content' => 'Contenido modificado sin imagen',
            'remove_image' => true,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'note' => [
                    'content' => 'Contenido modificado sin imagen',
                    'image_url' => null,
                ],
            ]);

        $note->refresh();
        $this->assertNull($note->image_path);
        Storage::disk('public')->assertMissing($path1);
    }

    public function test_deleting_note_removes_attached_file_from_disk(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $image = UploadedFile::fake()->image('para-borrar.jpg', 200, 200);
        $path = $image->store('garden-notes', 'public');

        $note = GardenNote::create([
            'screen_key' => 'inicio',
            'content' => 'Nota que será eliminada',
            'image_path' => $path,
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->deleteJson(route('garden-notes.destroy', $note));
        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('garden_notes', ['id' => $note->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
