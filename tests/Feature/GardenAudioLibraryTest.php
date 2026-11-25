<?php

namespace Tests\Feature;

use App\Services\GardenAudioLibraryService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class GardenAudioLibraryTest extends TestCase
{
    protected string $testAudioDir;
    protected string $testFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testAudioDir = public_path('audio');
        if (! File::isDirectory($this->testAudioDir)) {
            File::makeDirectory($this->testAudioDir, 0755, true, true);
        }
        $this->testFile = $this->testAudioDir . DIRECTORY_SEPARATOR . '01 - Balada_de_Prueba.mp3';
    }

    protected function tearDown(): void
    {
        if (File::exists($this->testFile)) {
            File::delete($this->testFile);
        }
        parent::tearDown();
    }

    public function test_audio_library_endpoint_returns_json_response(): void
    {
        $response = $this->getJson(route('api.audio-library'));

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'count',
                'tracks',
            ]);
    }

    public function test_audio_library_detects_mp3_files_in_public_audio(): void
    {
        File::put($this->testFile, 'fake mp3 content');

        $tracks = GardenAudioLibraryService::getPublicAudioTracks();

        $this->assertGreaterThanOrEqual(1, $tracks->count());

        $track = $tracks->firstWhere('file_name', '01 - Balada_de_Prueba.mp3');
        $this->assertNotNull($track);
        $this->assertSame('Balada De Prueba', $track['title']);
        $this->assertSame('audio', $track['type']);
        $this->assertSame('external_audio', $track['source_type']);
        $this->assertTrue($track['is_public_library']);
        $this->assertStringContainsString('Balada_de_Prueba.mp3', $track['url']);

        $response = $this->getJson(route('api.audio-library'));
        $response->assertOk()
            ->assertJsonFragment([
                'title' => 'Balada De Prueba',
                'file_name' => '01 - Balada_de_Prueba.mp3',
            ]);
    }

    public function test_format_title_cleans_numbers_and_underscores(): void
    {
        $this->assertSame('Fly Me To The Moon', GardenAudioLibraryService::formatTitle('01 - Fly_Me_To_The_Moon'));
        $this->assertSame('My Way', GardenAudioLibraryService::formatTitle('02. My-Way'));
        $this->assertSame('Carla Lorena', GardenAudioLibraryService::formatTitle('[12] Carla_Lorena'));
    }
}
