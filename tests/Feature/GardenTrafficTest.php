<?php

namespace Tests\Feature;

use App\Models\GardenTrafficVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GardenTrafficTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_ping_traffic_and_register_visit(): void
    {
        $response = $this->postJson(route('traffic.ping'), [
            'visitor_uuid' => 'test-visitor-uuid-12345678',
            'screen' => 'galeria',
            'device' => 'Escritorio',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'duration_seconds' => 10,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'visitor_uuid' => 'test-visitor-uuid-12345678',
                'screen' => 'galeria',
            ]);

        $this->assertDatabaseHas('garden_traffic_visits', [
            'visitor_uuid' => 'test-visitor-uuid-12345678',
            'screen' => 'galeria',
            'user_id' => null,
            'device' => 'Escritorio',
            'browser' => 'Chrome',
            'os' => 'Windows',
        ]);
    }

    public function test_ping_updates_existing_recent_visit_duration(): void
    {
        $uuid = 'repeat-visitor-uuid-98765432';

        $firstPing = $this->postJson(route('traffic.ping'), [
            'visitor_uuid' => $uuid,
            'screen' => 'inicio',
            'duration_seconds' => 10,
        ]);
        $firstPing->assertOk();

        $this->assertDatabaseCount('garden_traffic_visits', 1);

        $secondPing = $this->postJson(route('traffic.ping'), [
            'visitor_uuid' => $uuid,
            'screen' => 'inicio',
            'duration_seconds' => 20,
        ]);
        $secondPing->assertOk();

        // No se debe duplicar el registro si es en los últimos 15 min en la misma pantalla
        $this->assertDatabaseCount('garden_traffic_visits', 1);

        $visit = GardenTrafficVisit::first();
        $this->assertGreaterThanOrEqual(25, $visit->duration_seconds);
    }

    public function test_ping_links_authenticated_user_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('traffic.ping'), [
            'visitor_uuid' => 'user-session-uuid-11223344',
            'screen' => 'mapa',
            'duration_seconds' => 15,
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('garden_traffic_visits', [
            'visitor_uuid' => 'user-session-uuid-11223344',
            'screen' => 'mapa',
            'user_id' => $user->id,
        ]);
    }

    public function test_guests_cannot_access_admin_traffic_endpoints(): void
    {
        $getResponse = $this->getJson(route('admin.traffic.index'));
        $this->assertTrue(in_array($getResponse->status(), [401, 403, 302], true));

        $purgeResponse = $this->deleteJson(route('admin.traffic.purge'));
        $this->assertTrue(in_array($purgeResponse->status(), [401, 403, 302], true));
    }

    public function test_non_admin_users_cannot_access_admin_traffic_endpoints(): void
    {
        $user = User::factory()->create([
            'id' => 999,
            'is_admin' => false,
        ]);

        $getResponse = $this->actingAs($user)->getJson(route('admin.traffic.index'));
        $getResponse->assertForbidden();

        $purgeResponse = $this->actingAs($user)->deleteJson(route('admin.traffic.purge'));
        $purgeResponse->assertForbidden();
    }

    public function test_admin_can_view_traffic_audit_and_metrics(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Crear visitas de prueba
        GardenTrafficVisit::create([
            'visitor_uuid' => 'uuid-admin-test-1',
            'screen' => 'inicio',
            'device' => 'Escritorio',
            'browser' => 'Firefox',
            'os' => 'Linux',
            'duration_seconds' => 60,
            'last_seen_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        GardenTrafficVisit::create([
            'user_id' => $admin->id,
            'visitor_uuid' => 'uuid-admin-test-2',
            'screen' => 'admin',
            'device' => 'Escritorio',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'duration_seconds' => 120,
            'last_seen_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.traffic.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'visits' => [
                    'data',
                    'current_page',
                    'total',
                ],
                'metrics' => [
                    'online_now',
                    'visits_today',
                    'unique_visitors_today',
                    'registered_today',
                    'top_screen',
                ],
                'chart',
            ]);

        $metrics = $response->json('metrics');
        $this->assertEquals(2, $metrics['visits_today']);
        $this->assertEquals(2, $metrics['online_now']);
        $this->assertEquals(1, $metrics['registered_today']);
    }

    public function test_admin_can_filter_traffic_by_type_and_screen(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Invitado en 'galeria'
        GardenTrafficVisit::create([
            'visitor_uuid' => 'guest-uuid',
            'screen' => 'galeria',
            'user_id' => null,
            'last_seen_at' => Carbon::now(),
        ]);

        // Usuario registrado en 'diario'
        GardenTrafficVisit::create([
            'visitor_uuid' => 'reg-uuid',
            'screen' => 'diario',
            'user_id' => $admin->id,
            'last_seen_at' => Carbon::now(),
        ]);

        // Filtrar solo registrados
        $regResponse = $this->actingAs($admin)->getJson(route('admin.traffic.index', ['filter' => 'registered']));
        $regResponse->assertOk();
        $this->assertCount(1, $regResponse->json('visits.data'));
        $this->assertEquals('diario', $regResponse->json('visits.data.0.screen'));

        // Filtrar solo invitados
        $guestResponse = $this->actingAs($admin)->getJson(route('admin.traffic.index', ['filter' => 'guests']));
        $guestResponse->assertOk();
        $this->assertCount(1, $guestResponse->json('visits.data'));
        $this->assertEquals('galeria', $guestResponse->json('visits.data.0.screen'));

        // Filtrar por pantalla
        $screenResponse = $this->actingAs($admin)->getJson(route('admin.traffic.index', ['screen' => 'galeria']));
        $screenResponse->assertOk();
        $this->assertCount(1, $screenResponse->json('visits.data'));
    }

    public function test_admin_can_purge_old_traffic(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Registro antiguo (45 días)
        $ancient = GardenTrafficVisit::create([
            'visitor_uuid' => 'ancient-uuid',
            'screen' => 'inicio',
            'last_seen_at' => Carbon::now()->subDays(45),
        ]);
        GardenTrafficVisit::where('id', $ancient->id)->update([
            'created_at' => Carbon::now()->subDays(45),
        ]);

        // Registro reciente (2 días)
        $fresh = GardenTrafficVisit::create([
            'visitor_uuid' => 'fresh-uuid',
            'screen' => 'inicio',
            'last_seen_at' => Carbon::now()->subDays(2),
        ]);
        GardenTrafficVisit::where('id', $fresh->id)->update([
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $this->assertDatabaseCount('garden_traffic_visits', 2);

        $purgeResponse = $this->actingAs($admin)->deleteJson(route('admin.traffic.purge', ['days' => 30]));
        $purgeResponse->assertOk()
            ->assertJson([
                'success' => true,
                'deleted_count' => 1,
            ]);

        $this->assertDatabaseCount('garden_traffic_visits', 1);
        $this->assertDatabaseHas('garden_traffic_visits', ['visitor_uuid' => 'fresh-uuid']);
    }
}
