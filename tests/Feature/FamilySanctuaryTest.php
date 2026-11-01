<?php

namespace Tests\Feature;

use App\Models\FamilyMember;
use App\Models\FamilyMemory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FamilySanctuaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_and_non_admins_cannot_unlock_or_manage_family_sanctuary(): void
    {
        $member = User::factory()->create([
            'id' => 99,
            'name' => 'visitante',
            'email' => 'visitante@example.com',
            'password' => Hash::make('secret123'),
            'is_admin' => false,
        ]);

        // Intento con credenciales de un usuario que NO es admin
        $this->postJson(route('family-sanctuary.unlock'), [
            'login' => 'visitante',
            'password' => 'secret123',
        ])->assertStatus(403)
          ->assertJsonPath('unlocked', false);

        // Intento sin sesión en rutas administrativas
        $this->getJson(route('admin.family-sanctuary.index'))->assertStatus(401);

        // Intento autenticado como usuario no administrador
        $this->actingAs($member)
            ->getJson(route('admin.family-sanctuary.index'))
            ->assertStatus(403);
    }

    public function test_admin_can_unlock_family_vault_with_username_or_email_and_password(): void
    {
        $admin = User::factory()->create([
            'name' => 'carlalorenah',
            'email' => 'carlalorenah@gmail.com',
            'password' => Hash::make('amor2026'),
            'is_admin' => true,
        ]);

        $response = $this->postJson(route('family-sanctuary.unlock'), [
            'login' => 'carlalorenah',
            'password' => 'amor2026',
        ]);

        $response->assertOk()
            ->assertJsonPath('unlocked', true)
            ->assertJsonPath('user.email', $admin->email);

        $names = collect($response->json('members'))->pluck('name')->all();
        $this->assertContains('Carla Lorena', $names);
        $this->assertContains('Adrián', $names);
        $this->assertContains('Ody', $names);
    }

    public function test_admin_can_create_update_and_delete_children_and_family_memories(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        // Crear un nuevo hijo en el álbum familiar
        $createMember = $this->actingAs($admin)->postJson(route('admin.family-members.store'), [
            'name' => 'Mateo Adrián',
            'role_badge' => 'Hijo Amado · Pequeño Príncipe',
            'category' => 'children',
            'avatar_icon' => '🌟',
            'bio' => 'Alegría infinita de Carla Lorena y Adrián.',
            'special_date' => 'Semilla de Amor #3',
            'favorite_quote' => '«Nuestro sol de cada mañana»',
            'photo' => UploadedFile::fake()->image('mateo.jpg', 600, 800),
        ]);

        $createMember->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('member.name', 'Mateo Adrián');

        $memberId = $createMember->json('member.id');
        $member = FamilyMember::findOrFail($memberId);
        Storage::disk('public')->assertExists($member->photo_path);

        // Subir un recuerdo fotográfico vinculado al álbum familiar
        $createMemory = $this->actingAs($admin)->postJson(route('admin.family-memories.store'), [
            'title' => 'Tarde en el jardín con Adrián, Ody y los niños',
            'story' => 'Un día lleno de juegos y abrazos.',
            'category' => 'children',
            'family_member_id' => $memberId,
            'memory_date' => 'Primavera 2026',
            'emotion_tag' => 'Amor Eterno',
            'image' => UploadedFile::fake()->image('recuerdo-familiar.jpg', 1200, 900),
        ]);

        $createMemory->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('memory.title', 'Tarde en el jardín con Adrián, Ody y los niños');

        $memoryId = $createMemory->json('memory.id');
        $memory = FamilyMemory::findOrFail($memoryId);
        Storage::disk('public')->assertExists($memory->image_path);

        // Eliminar el recuerdo y el integrante
        $this->actingAs($admin)
            ->deleteJson(route('admin.family-memories.destroy', $memory))
            ->assertOk();

        $this->actingAs($admin)
            ->deleteJson(route('admin.family-members.destroy', $member))
            ->assertOk();
    }
}

