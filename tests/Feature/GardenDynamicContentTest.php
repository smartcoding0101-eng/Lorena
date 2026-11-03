<?php

namespace Tests\Feature;

use App\Models\GardenDestination;
use App\Models\GardenGalleryItem;
use App\Models\GardenPoem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenDynamicContentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);
        Storage::fake('public');
    }

    public function test_public_home_renders_dynamic_gallery_destinations_and_poems(): void
    {
        $galleryItem = GardenGalleryItem::create([
            'title' => 'Rosas de Medianoche',
            'category' => 'foto',
            'pill' => 'Exclusivo',
            'quote' => 'Un suspiro de medianoche',
            'image_path' => 'https://example.com/rosas.jpg',
            'is_active' => true,
        ]);

        $destination = GardenDestination::create([
            'title' => 'Playa Escondida',
            'location_tag' => 'CARIBE · SUEÑO',
            'description' => 'Aguas cristalinas y arena fina',
            'image_path' => 'https://example.com/playa.jpg',
            'is_active' => true,
        ]);

        $poem = GardenPoem::create([
            'title' => 'Verso del Amanecer',
            'mood' => 'Tranquilidad matutina',
            'stanza1' => 'Despierta el cielo con suave color',
            'signature' => 'Con amor eterno',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Rosas de Medianoche');
        $response->assertSee('Playa Escondida');
        $response->assertSee('Verso del Amanecer');
    }

    public function test_admin_home_renders_curation_cards_and_preview_components(): void
    {
        $res = $this->actingAs($this->admin)->get('/');
        $res->assertStatus(200);
        $res->assertSee('admin-curation-card');
        $res->assertSee('gallery-editorial-grid');
        $res->assertSee('gallery-preview-container');
        $res->assertSee('gallery-input-file');
        $res->assertSee('gallery-dropzone');
    }

    public function test_admin_can_manage_gallery_items(): void
    {
        // 1. Index
        $res = $this->actingAs($this->admin)->getJson('/admin/gallery');
        $res->assertStatus(200);

        // 2. Store with URL
        $storeRes = $this->actingAs($this->admin)->postJson('/admin/gallery', [
            'title' => 'Atardecer en la Pradera',
            'category' => 'video',
            'pill' => 'Luz Dorada',
            'tag_label' => 'POSTAL EN MOVIMIENTO',
            'quote' => 'Hora mágica',
            'image_url' => 'https://example.com/atardecer.jpg',
        ]);
        $storeRes->assertStatus(201);
        $this->assertDatabaseHas('garden_gallery_items', [
            'title' => 'Atardecer en la Pradera',
            'category' => 'video',
        ]);

        $itemId = $storeRes->json('item.id');

        // 3. Update
        $updateRes = $this->actingAs($this->admin)->putJson("/admin/gallery/{$itemId}", [
            'title' => 'Atardecer Renovado',
            'category' => 'foto',
        ]);
        $updateRes->assertStatus(200);
        $this->assertDatabaseHas('garden_gallery_items', [
            'id' => $itemId,
            'title' => 'Atardecer Renovado',
            'category' => 'foto',
        ]);

        // 4. Destroy
        $delRes = $this->actingAs($this->admin)->deleteJson("/admin/gallery/{$itemId}");
        $delRes->assertStatus(200);
        $this->assertDatabaseMissing('garden_gallery_items', ['id' => $itemId]);
    }

    public function test_admin_can_manage_destinations(): void
    {
        // 1. Store
        $res = $this->actingAs($this->admin)->postJson('/admin/destinations', [
            'title' => 'Kyoto en Primavera',
            'location_tag' => 'JAPÓN · CEREZOS',
            'description' => 'Templos milenarios cubiertos de flores de cerezo',
            'image_url' => 'https://example.com/kyoto.jpg',
        ]);
        $res->assertStatus(201);
        $this->assertDatabaseHas('garden_destinations', ['title' => 'Kyoto en Primavera']);

        $destId = $res->json('destination.id');

        // 2. Update
        $updateRes = $this->actingAs($this->admin)->putJson("/admin/destinations/{$destId}", [
            'title' => 'Kyoto Imperial',
            'location_tag' => 'JAPÓN · CEREZOS',
            'description' => 'Actualizado',
        ]);
        $updateRes->assertStatus(200);

        // 3. Delete
        $delRes = $this->actingAs($this->admin)->deleteJson("/admin/destinations/{$destId}");
        $delRes->assertStatus(200);
        $this->assertDatabaseMissing('garden_destinations', ['id' => $destId]);
    }

    public function test_admin_can_manage_poems(): void
    {
        // 1. Store
        $res = $this->actingAs($this->admin)->postJson('/admin/poems', [
            'title' => 'Soneto Imperial',
            'mood' => 'Amor y admiración',
            'stanza1' => 'Líneas escritas en papel de arroz',
            'stanza2' => 'Para ti con devoción',
            'signature' => 'Por siempre tuyo',
        ]);
        $res->assertStatus(201);
        $this->assertDatabaseHas('garden_poems', ['title' => 'Soneto Imperial']);

        $poemId = $res->json('poem.id');

        // 2. Update
        $updateRes = $this->actingAs($this->admin)->putJson("/admin/poems/{$poemId}", [
            'title' => 'Soneto Imperial Editado',
            'stanza1' => 'Nueva estrofa',
        ]);
        $updateRes->assertStatus(200);

        // 3. Delete
        $delRes = $this->actingAs($this->admin)->deleteJson("/admin/poems/{$poemId}");
        $delRes->assertStatus(200);
        $this->assertDatabaseMissing('garden_poems', ['id' => $poemId]);
    }
}

