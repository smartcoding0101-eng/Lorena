<?php

namespace Tests\Feature;

use App\Models\FriendDedication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FriendDedicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_read_friend_dedications(): void
    {
        FriendDedication::create([
            'author_name' => 'Lucía M.',
            'message' => '¡Feliz día Carla, te quiero mucho!',
            'flower_badge' => '🌸',
        ]);

        $response = $this->getJson(route('friend-dedications.index'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertCount(1, $response->json('dedications'));
        $this->assertSame('Lucía M.', $response->json('dedications.0.author_name'));
    }

    public function test_guests_can_submit_friend_dedication_with_automatic_sanitization(): void
    {
        $response = $this->postJson(route('friend-dedications.store'), [
            'author_name' => '<b>María</b>',
            'message' => '<script>alert("xss")</script>Que tengas un hermoso día lleno de flores y amor.',
            'flower_badge' => '💖',
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => '¡Tu dedicatoria ha florecido en el jardín de Carla!',
                'dedication' => [
                    'author_name' => 'María',
                    'flower_badge' => '💖',
                ],
            ]);

        $dedication = FriendDedication::query()->sole();
        $this->assertSame('María', $dedication->author_name, 'El HTML en author_name debe ser despojado por seguridad');
        $this->assertStringNotContainsString('<script>', $dedication->message, 'Los scripts maliciosos deben ser neutralizados');
        $this->assertSame('alert("xss")Que tengas un hermoso día lleno de flores y amor.', $dedication->message);
    }

    public function test_friend_dedication_validates_required_fields_and_min_lengths(): void
    {
        $this->postJson(route('friend-dedications.store'), [
            'author_name' => 'A', // min 2
            'message' => 'hi',     // min 4
        ])->assertUnprocessable()
          ->assertJsonValidationErrors(['author_name', 'message']);

        $this->assertDatabaseCount('friend_dedications', 0);
    }

    public function test_only_authenticated_users_can_delete_friend_dedications(): void
    {
        $dedication = FriendDedication::create([
            'author_name' => 'Amigo Anónimo',
            'message' => 'Un saludo afectuoso.',
            'flower_badge' => '🌼',
        ]);

        // Visitante intenta borrar
        $this->deleteJson(route('friend-dedications.destroy', $dedication))
            ->assertUnauthorized();

        $this->assertDatabaseHas('friend_dedications', ['id' => $dedication->id]);

        // Usuario autenticado borra
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->deleteJson(route('friend-dedications.destroy', $dedication));
        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('friend_dedications', ['id' => $dedication->id]);
    }
}
