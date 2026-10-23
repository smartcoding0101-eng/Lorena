<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GardenPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_only_see_published_blog_posts_and_never_diary_entries(): void
    {
        $owner = User::factory()->create();
        $owner->gardenPosts()->create([
            'title' => 'Nota pública',
            'slug' => 'nota-publica',
            'kind' => 'blog',
            'status' => 'published',
            'body' => 'Texto compartido.',
        ]);
        $draft = $owner->gardenPosts()->create([
            'title' => 'Borrador secreto marcador',
            'slug' => 'borrador-secreto',
            'kind' => 'blog',
            'status' => 'draft',
            'body' => 'Solo para Carla.',
        ]);
        $diary = $owner->gardenPosts()->create([
            'title' => 'Diario privado marcador',
            'slug' => 'diario-privado',
            'kind' => 'diary',
            'status' => 'draft',
            'body' => 'Una nota personal.',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Nota pública')
            ->assertDontSee('Borrador secreto marcador')
            ->assertDontSee('Diario privado marcador');
        $this->get(route('blog.show', 'nota-publica'))->assertOk()->assertSee('Texto compartido.');
        $this->get(route('blog.show', $draft->slug))->assertNotFound();
        $this->get(route('blog.show', $diary->slug))->assertNotFound();
    }

    public function test_an_owner_can_create_edit_publish_unpublish_and_delete_blog_entries(): void
    {
        $owner = User::factory()->create();

        $this->actingAs($owner)->post(route('entries.store'), [
            'kind' => 'blog',
            'title' => 'Un título para compartir',
            'category' => 'Inspiración',
            'excerpt' => 'Resumen público.',
            'body' => 'Texto público.',
        ])->assertRedirect(route('home').'#blog');

        $post = $owner->gardenPosts()->sole();
        $this->assertSame('draft', $post->status);
        $this->get(route('blog.show', $post->slug))->assertNotFound();

        $this->actingAs($owner)->put(route('entries.update', $post), [
            'title' => 'Título revisado',
            'category' => 'Lecturas',
            'excerpt' => 'Resumen actualizado.',
            'body' => 'Texto actualizado.',
        ])->assertRedirect(route('home').'#blog');

        $this->post(route('entries.publish', $post))
            ->assertRedirect(route('home').'#blog');
        $this->assertDatabaseHas('garden_posts', ['id' => $post->id, 'status' => 'published']);
        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee('Título revisado')
            ->assertSee('Texto actualizado.');

        $this->post(route('entries.unpublish', $post))
            ->assertRedirect(route('home').'#blog');
        $this->get(route('blog.show', $post->slug))->assertNotFound();

        $this->delete(route('entries.destroy', $post))
            ->assertRedirect(route('home').'#blog');
        $this->assertDatabaseMissing('garden_posts', ['id' => $post->id]);
    }

    public function test_diary_entries_are_private_and_cannot_be_published(): void
    {
        $owner = User::factory()->create();
        $entry = $owner->gardenPosts()->create([
            'title' => 'Nota solo mía marcador',
            'slug' => 'nota-solo-mia',
            'kind' => 'diary',
            'status' => 'draft',
            'body' => 'Contenido privado marcador.',
        ]);

        $this->actingAs($owner)->get(route('home'))
            ->assertOk()
            ->assertSee('Nota solo mía marcador')
            ->assertSee('Contenido privado marcador.');
        $this->post(route('entries.publish', $entry))->assertForbidden();
        $this->assertDatabaseHas('garden_posts', ['id' => $entry->id, 'status' => 'draft']);

        auth()->logout();
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Nota solo mía marcador')
            ->assertDontSee('Contenido privado marcador.');
        $this->get(route('blog.show', $entry->slug))->assertNotFound();
    }

    public function test_guests_and_other_users_cannot_manage_private_entries(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $entry = $owner->gardenPosts()->create([
            'title' => 'Borrador del propietario',
            'slug' => 'borrador-del-propietario',
            'kind' => 'blog',
            'status' => 'draft',
            'body' => 'Contenido privado.',
        ]);

        $this->post(route('entries.store'), [
            'kind' => 'diary',
            'title' => 'No autorizado',
            'body' => 'No se debe guardar.',
        ])->assertRedirect(route('login'));

        $this->actingAs($otherUser)
            ->put(route('entries.update', $entry), [
                'title' => 'Intento de edición',
                'body' => 'No autorizado.',
            ])->assertForbidden();
        $this->actingAs($otherUser)->post(route('entries.publish', $entry))->assertForbidden();
        $this->actingAs($otherUser)->delete(route('entries.destroy', $entry))->assertForbidden();

        $this->assertDatabaseHas('garden_posts', [
            'id' => $entry->id,
            'title' => 'Borrador del propietario',
            'status' => 'draft',
        ]);
        $this->assertDatabaseCount('garden_posts', 1);
    }

    public function test_post_body_is_rendered_as_escaped_plain_text(): void
    {
        $owner = User::factory()->create();
        $owner->gardenPosts()->create([
            'title' => 'Texto plano',
            'slug' => 'texto-plano',
            'kind' => 'blog',
            'status' => 'published',
            'body' => '<script>alert("no")</script>',
        ]);

        $this->get(route('blog.show', 'texto-plano'))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(&quot;no&quot;)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert("no")</script>', false);
    }
}
