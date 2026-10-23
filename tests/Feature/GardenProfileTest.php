<?php

namespace Tests\Feature;

use App\Models\GardenProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GardenProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_owner_can_save_a_private_profile_and_upload_a_private_featured_photo(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create(['name' => 'Carla Lorena Hernández']);

        $this->actingAs($owner)
            ->put(route('profile.save'), [
                'profession' => 'Médica especialista',
                'biography' => 'Me inspira aprender y acompañar a las personas.',
                'education' => "Medicina\nEspecialidad clínica",
                'experience' => 'Atención clínica',
                'achievements' => 'Proyecto de educación en salud',
                'interests' => 'Ciencia y naturaleza',
                'additional_info' => 'Información que decido mantener privada.',
                'status' => 'draft',
                'featured_photo' => UploadedFile::fake()->image('carla.jpg'),
            ])
            ->assertRedirect(route('home').'#blog')
            ->assertSessionHas('status', 'Perfil guardado como borrador privado.');

        $profile = GardenProfile::query()->sole();
        $this->assertSame($owner->id, $profile->user_id);
        $this->assertSame('draft', $profile->status);
        $this->assertSame("Medicina\nEspecialidad clínica", $profile->education);
        Storage::disk('garden_private')->assertExists($profile->featured_photo_path);

        $this->get('/#blog')
            ->assertOk()
            ->assertSee('Mi perfil y fotografía destacada')
            ->assertSee('Médica especialista')
            ->assertSee('Guardar como borrador privado')
            ->assertSee('Publicar perfil en el blog');

        Auth::logout();
        $this->get('/#blog')
            ->assertOk()
            ->assertDontSee('Médica especialista')
            ->assertDontSee('Información que decido mantener privada.');

        $this->get(route('profiles.featured-photo', $profile))->assertNotFound();
        $this->actingAs($owner)
            ->get(route('profiles.featured-photo', $profile))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_publishing_a_profile_shows_its_details_and_featured_photo_publicly(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create(['name' => 'Carla Lorena Hernández']);
        $path = 'profiles/'.$owner->id.'/portrait.jpg';
        Storage::disk('garden_private')->put($path, 'private image bytes');

        $profile = $owner->gardenProfile()->create([
            'profession' => 'Doctora',
            'biography' => 'Una presentación pública.',
            'education' => 'Medicina',
            'experience' => 'Experiencia profesional',
            'achievements' => 'Proyecto destacado',
            'interests' => 'Lectura y ciencia',
            'additional_info' => 'Información adicional autorizada.',
            'featured_photo_path' => $path,
            'status' => 'draft',
        ]);

        $this->actingAs($owner)
            ->put(route('profile.save'), [
                'profession' => $profile->profession,
                'biography' => $profile->biography,
                'education' => $profile->education,
                'experience' => $profile->experience,
                'achievements' => $profile->achievements,
                'interests' => $profile->interests,
                'additional_info' => $profile->additional_info,
                'status' => 'published',
            ])
            ->assertRedirect(route('home').'#blog')
            ->assertSessionHas('status', 'Perfil actualizado y publicado en el blog.');

        $this->assertDatabaseHas('garden_profiles', ['id' => $profile->id, 'status' => 'published']);
        $this->get('/#blog')
            ->assertOk()
            ->assertSee('Carla Lorena Hernández')
            ->assertSee('Doctora')
            ->assertSee('Una presentación pública.')
            ->assertSee('Experiencia profesional')
            ->assertSee('Información adicional autorizada.')
            ->assertSee(route('profiles.featured-photo', $profile));

        $this->get(route('profiles.featured-photo', $profile))
            ->assertOk()
            ->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_another_account_cannot_edit_or_preview_a_private_profile_photo(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $profile = $owner->gardenProfile()->create([
            'status' => 'draft',
            'featured_photo_path' => 'profiles/'.$owner->id.'/private.png',
        ]);
        Storage::disk('garden_private')->put($profile->featured_photo_path, 'private image bytes');

        $this->assertFalse(Gate::forUser($otherUser)->allows('update', $profile));
        $this->actingAs($otherUser)
            ->get(route('profiles.featured-photo', $profile))
            ->assertNotFound();
    }

    public function test_invalid_profile_photos_are_rejected_without_saving_profile_data(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();

        $this->actingAs($owner)
            ->from('/#blog')
            ->put(route('profile.save'), [
                'profession' => 'No guardar hasta validar.',
                'status' => 'draft',
                'featured_photo' => UploadedFile::fake()->create('documento.txt', 2, 'text/plain'),
            ])
            ->assertSessionHasErrors('featured_photo');

        $this->assertDatabaseCount('garden_profiles', 0);
        $this->assertSame([], Storage::disk('garden_private')->allFiles());
    }

    public function test_the_owner_can_remove_the_featured_photo(): void
    {
        Storage::fake('garden_private');
        $owner = User::factory()->create();
        $path = 'profiles/'.$owner->id.'/portrait.png';
        Storage::disk('garden_private')->put($path, 'private image bytes');
        $owner->gardenProfile()->create([
            'profession' => 'Doctora',
            'featured_photo_path' => $path,
            'status' => 'draft',
        ]);

        $this->actingAs($owner)
            ->put(route('profile.save'), [
                'profession' => 'Doctora',
                'status' => 'draft',
                'remove_photo' => '1',
            ])
            ->assertRedirect(route('home').'#blog');

        $this->assertNull($owner->gardenProfile()->sole()->featured_photo_path);
        Storage::disk('garden_private')->assertMissing($path);
    }
}
