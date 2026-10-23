<?php

namespace Tests\Feature;

use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TimeCapsuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_or_create_time_capsules(): void
    {
        $this->getJson(route('time-capsules.index'))->assertUnauthorized();
        $this->postJson(route('time-capsules.store'), [
            'title' => 'Carta futura',
            'message' => 'Un secreto para el futuro',
            'unlock_at' => now()->addDays(5)->toDateTimeString(),
        ])->assertUnauthorized();
    }

    public function test_authenticated_user_can_seal_time_capsule_with_future_date(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['name' => 'Carla Lorena']);
        $this->actingAs($user);

        $futureDate = now()->addDays(10)->startOfMinute();

        $response = $this->postJson(route('time-capsules.store'), [
            'title' => 'Para abrir en nuestro aniversario',
            'message' => 'Prometo amarte hoy más que ayer y menos que mañana.',
            'unlock_at' => $futureDate->toDateTimeString(),
            'mood' => 'anniversary',
            'author_name' => 'Carla Lorena',
            'image' => UploadedFile::fake()->image('recuerdo.jpg', 600, 600),
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'capsule' => [
                    'title' => 'Para abrir en nuestro aniversario',
                    'is_unlocked' => false,
                ],
            ]);

        $capsule = TimeCapsule::query()->sole();
        $this->assertSame($user->id, $capsule->user_id);
        $this->assertSame('Para abrir en nuestro aniversario', $capsule->title);
        $this->assertFalse($capsule->is_opened);
        $this->assertNotNull($capsule->image_path);
        Storage::disk('public')->assertExists($capsule->image_path);
    }

    public function test_time_capsule_rejects_past_or_current_unlock_dates(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->postJson(route('time-capsules.store'), [
            'title' => 'Fecha inválida',
            'message' => 'Intentando sellar en el pasado',
            'unlock_at' => now()->subDay()->toDateTimeString(),
        ])->assertUnprocessable()
          ->assertJsonValidationErrors(['unlock_at']);

        $this->assertDatabaseCount('time_capsules', 0);
    }

    public function test_locked_capsule_does_not_reveal_secret_message_or_image_url_in_json(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $futureDate = now()->addMonth();

        $capsule = $user->timeCapsules()->create([
            'title' => 'Cápsula Secreta y Blindada',
            'message' => 'Este es un secreto que nadie debe leer antes de tiempo.',
            'unlock_at' => $futureDate,
            'image_path' => 'time-capsules/foto-secreta.jpg',
            'mood' => 'secret',
            'is_opened' => false,
        ]);

        $response = $this->getJson(route('time-capsules.index'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'total' => 1,
                'locked_count' => 1,
                'unlocked_count' => 0,
            ]);

        $data = $response->json('capsules.0');
        $this->assertSame('Cápsula Secreta y Blindada', $data['title']);
        $this->assertNull($data['message'], 'El mensaje secreto debe ser NULL mientras esté bloqueada');
        $this->assertNull($data['image_url'], 'La URL de la imagen debe ser NULL mientras esté bloqueada');
        $this->assertTrue($data['has_image']);
        $this->assertFalse($data['is_unlocked']);
    }

    public function test_unlocked_capsule_reveals_message_and_allows_marking_opened(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $unlockDate = now()->subMinutes(5);

        $capsule = $user->timeCapsules()->create([
            'title' => 'Cápsula del Pasado',
            'message' => '¡Felicidades, el tiempo ha llegado!',
            'unlock_at' => $unlockDate,
            'mood' => 'birthday',
            'is_opened' => false,
        ]);

        $response = $this->getJson(route('time-capsules.index'));
        $response->assertOk();

        $data = $response->json('capsules.0');
        $this->assertSame('¡Felicidades, el tiempo ha llegado!', $data['message']);
        $this->assertTrue($data['is_unlocked']);

        // Marcar como abierta
        $openResponse = $this->patchJson(route('time-capsules.open', $capsule));
        $openResponse->assertOk()
            ->assertJson(['success' => true]);

        $this->assertTrue($capsule->fresh()->is_opened);
    }

    public function test_cannot_mark_as_opened_if_not_unlocked_yet(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $capsule = $user->timeCapsules()->create([
            'title' => 'Aún no lista',
            'message' => 'Paciencia...',
            'unlock_at' => now()->addYear(),
            'mood' => 'future',
            'is_opened' => false,
        ]);

        $this->patchJson(route('time-capsules.open', $capsule))
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Esta cápsula aún no puede abrirse.',
            ]);

        $this->assertFalse($capsule->fresh()->is_opened);
    }

    public function test_user_cannot_open_or_delete_another_users_time_capsule(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $capsule = $user1->timeCapsules()->create([
            'title' => 'De Usuario 1',
            'message' => 'Solo para usuario 1',
            'unlock_at' => now()->subDay(),
            'mood' => 'love',
            'is_opened' => false,
        ]);

        $this->actingAs($user2);

        $this->patchJson(route('time-capsules.open', $capsule))
            ->assertForbidden();

        $this->deleteJson(route('time-capsules.destroy', $capsule))
            ->assertForbidden();

        $this->assertDatabaseHas('time_capsules', ['id' => $capsule->id]);
    }
}
