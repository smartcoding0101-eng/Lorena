<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_landing_page_contains_the_connected_demo_screens(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('El Jardín de Carla')
            ->assertSee('data-screen="mapa"', false)
            ->assertSee('data-screen="galeria"', false)
            ->assertSee('data-screen="juegos"', false)
            ->assertSee('class="game-card-grid"', false)
            ->assertSee('data-game-card', false)
            ->assertSee('class="game-card-heading"', false)
            ->assertSee('class="game-card-copy"', false)
            ->assertSee('class="game-card-detail"', false)
            ->assertSee('data-screen="tesoro"', false)
            ->assertSee('data-screen="historias"', false)
            ->assertSee('data-screen="preferencias"', false)
            ->assertSee('data-screen="rompecabezas"', false)
            ->assertSee('data-screen="bingo-amable"', false)
            ->assertSee('data-screen="adivina-escena"', false)
            ->assertSee('data-screen="aventura-sultana"', false)
            ->assertSee('data-sultana-game', false)
            ->assertSee('data-sultana-start', false)
            ->assertSee('data-sultana-clear', false)
            ->assertSee('data-sultana-card-status', false)
            ->assertSee('data-screen="jardines-liria"', false)
            ->assertSee('data-screen="sultana-plataformas"', false)
            ->assertSee('Sultana y los senderos del alba')
            ->assertSee('data-platformer-canvas', false)
            ->assertSee('data-platformer-status', false)
            ->assertSee('data-platformer-select', false)
            ->assertSee('data-platformer-relics', false)
            ->assertSee('data-platformer-score', false)
            ->assertSee('data-platformer-best-level', false)
            ->assertSee('data-platformer-best-campaign', false)
            ->assertSee('data-platformer-finale', false)
            ->assertSee('data-platformer-replay', false)
            ->assertSee('Un jardín para guardar la luz')
            ->assertSee('Ilustración original de demostración; no es una fotografía de Carla.')
            ->assertSee('/sultana-finale.svg')
            ->assertSee('al agotarlos, el nivel actual se reinicia desde el principio')
            ->assertSee('Los récords se guardan en este navegador')
            ->assertSee('el récord de campaña se obtiene al completar los nueve niveles desde el primero')
            ->assertSee('los murciélagos vuelan')
            ->assertSee('data-platformer-control="left"', false)
            ->assertSee('data-platformer-control="right"', false)
            ->assertSee('data-platformer-control="jump"', false)
            ->assertSee('data-platformer-control="action"', false)
            ->assertSee('data-platformer-pause', false)
            ->assertSee('data-platformer-restart', false)
            ->assertSee('data-platformer-clear', false)
            ->assertSee('data-platformer-next', false)
            ->assertSee('9 NIVELES')
            ->assertSee('9 niveles · salto doble · destellos')
            ->assertSee('automáticamente')
            ->assertSee('salto doble')
            ->assertSee('data-garden3d-game', false)
            ->assertSee('data-garden3d-stage', false)
            ->assertSee('data-garden3d-level', false)
            ->assertSee('data-garden3d-objective', false)
            ->assertSee('data-garden3d-objective-arrow', false)
            ->assertSee('data-garden3d-objective-text', false)
            ->assertSee('18 ESCENARIOS')
            ->assertSee('Dieciocho escenarios de la aventura')
            ->assertSee('enemigos y trampas')
            ->assertSee('WASD o flechas para moverte según la cámara')
            ->assertSee('Arrastra la escena para girar la cámara')
            ->assertSee('usa Correr y pulsa la acción cuando estés cerca')
            ->assertSee('El progreso y la posición se guardan en este navegador')
            ->assertSee('data-garden3d-count', false)
            ->assertSee('aria-label="Dieciocho escenarios de la aventura"', false)
            ->assertSee('data-garden3d-quest-progress', false)
            ->assertSee('aria-label="Progreso de la aventura"', false)
            ->assertSee('data-garden3d-pause', false)
            ->assertSee('data-garden3d-finale', false)
            ->assertSee('La flecha señala el objetivo pendiente más cercano')
            ->assertSee('data-garden3d-interact', false)
            ->assertSee('data-garden3d-reset', false)
            ->assertSee('data-garden3d-replay', false)
            ->assertSee('data-sultana-progress', false)
            ->assertSee('data-sultana-achievements', false)
            ->assertSee('data-sultana-reset', false)
            ->assertSee('Las crónicas de la princesa')
            ->assertSee('5 capítulos · progreso guardado')
            ->assertSee('data-flower-board', false)
            ->assertSee('data-flower-restart', false)
            ->assertSee('data-kindness-bingo-board', false)
            ->assertSee('data-kindness-bingo-reset', false)
            ->assertSee('data-scene-guess-game', false)
            ->assertSee('data-scene-restart', false)
            ->assertSee('Rompecabezas floral')
            ->assertSee('¿Qué prefieres?')
            ->assertSee('10 preguntas · premio privado')
            ->assertSee('9 casillas · sin obligaciones')
            ->assertSee('IMÁGENES DE DEMOSTRACIÓN');
    }

    public function test_the_sultana_finale_illustration_is_available(): void
    {
        $illustration = public_path('sultana-finale.svg');

        $this->assertFileExists($illustration);
        $this->assertStringContainsString(
            '<title id="title">Sultana celebra el final de su aventura en Liria</title>',
            file_get_contents($illustration)
        );
    }
}
