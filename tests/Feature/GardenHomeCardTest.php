<?php

namespace Tests\Feature;

use App\Models\GardenHomeCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GardenHomeCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_manage_home_cards(): void
    {
        $this->postJson(route('admin.home-cards.store'), [
            'title' => 'Espacio de Recuerdos',
            'description' => 'Un bello espacio interactivo.',
            'target_screen' => 'galeria',
            'style_variant' => 'space-card-large',
        ])->assertUnauthorized();
    }

    public function test_non_admin_user_cannot_manage_home_cards(): void
    {
        $user = User::factory()->create(['id' => 99, 'is_admin' => false]);
        $this->actingAs($user);

        $this->postJson(route('admin.home-cards.store'), [
            'title' => 'Espacio Prohibido',
            'description' => 'No debe permitirse.',
            'target_screen' => 'galeria',
            'style_variant' => 'space-card-large',
        ])->assertForbidden();
    }

    public function test_admin_user_can_create_update_and_delete_home_cards(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        // 1. Crear tarjeta
        $response = $this->postJson(route('admin.home-cards.store'), [
            'title' => 'Rincón del Cosmos',
            'subtitle' => 'Estrellas & Galaxias',
            'emblem_icon' => '🌌 ✦',
            'description' => 'Explora los misterios de las estrellas.',
            'quote' => 'El universo conspira a nuestro favor.',
            'target_screen' => 'galeria',
            'style_variant' => 'space-card-cosmos',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'card' => [
                    'title' => 'Rincón del Cosmos',
                    'style_variant' => 'space-card-cosmos',
                ],
            ]);

        $card = GardenHomeCard::query()->sole();
        $this->assertSame('Rincón del Cosmos', $card->title);

        // 2. Actualizar tarjeta
        $updateResponse = $this->putJson(route('admin.home-cards.update', $card), [
            'title' => 'Rincón del Cosmos Infinito',
            'subtitle' => 'Constelaciones',
            'description' => 'Descripción actualizada.',
            'target_screen' => 'galeria',
            'style_variant' => 'space-card-cosmos',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $updateResponse->assertOk()
            ->assertJson([
                'success' => true,
                'card' => [
                    'title' => 'Rincón del Cosmos Infinito',
                ],
            ]);

        $this->assertSame('Rincón del Cosmos Infinito', $card->fresh()->title);

        // 3. Eliminar tarjeta
        $deleteResponse = $this->deleteJson(route('admin.home-cards.destroy', $card));
        $deleteResponse->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('garden_home_cards', ['id' => $card->id]);
    }
}
