<?php

namespace App\Http\Controllers;

use App\Models\GardenTrafficVisit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GardenTrafficController extends Controller
{
    /**
     * Endpoint público / SPA beacon para registrar ping o visita de pantalla.
     */
    public function ping(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'visitor_uuid' => ['nullable', 'string', 'max:64'],
                'screen' => ['nullable', 'string', 'max:50'],
                'device' => ['nullable', 'string', 'max:30'],
                'browser' => ['nullable', 'string', 'max:50'],
                'os' => ['nullable', 'string', 'max:50'],
                'referer' => ['nullable', 'string', 'max:255'],
                'duration_seconds' => ['nullable', 'integer', 'min:0', 'max:86400'],
            ]);

            $visitorUuid = $data['visitor_uuid'] ?? null;
            if (!$visitorUuid || strlen($visitorUuid) < 8) {
                $visitorUuid = Str::uuid()->toString();
            }

            $screen = trim((string) ($data['screen'] ?? 'inicio')) ?: 'inicio';
            $ip = $request->ip();
            $userAgent = $request->userAgent();
            $userId = Auth::id();
            $now = Carbon::now();

            // Buscar si existe una sesión activa para este visitante en la misma pantalla en los últimos 15 min
            $recentVisit = GardenTrafficVisit::where('visitor_uuid', $visitorUuid)
                ->where('screen', $screen)
                ->where('last_seen_at', '>=', Carbon::now()->subMinutes(15))
                ->latest('last_seen_at')
                ->first();

            if ($recentVisit) {
                $addSeconds = isset($data['duration_seconds']) ? (int) $data['duration_seconds'] : 15;
                $recentVisit->duration_seconds = min(86400, $recentVisit->duration_seconds + max(5, $addSeconds));
                $recentVisit->last_seen_at = $now;
                if ($userId && !$recentVisit->user_id) {
                    $recentVisit->user_id = $userId;
                }
                $recentVisit->save();
                $visit = $recentVisit;
            } else {
                $visit = GardenTrafficVisit::create([
                    'user_id' => $userId,
                    'visitor_uuid' => $visitorUuid,
                    'screen' => $screen,
                    'ip_address' => $ip,
                    'device' => $data['device'] ?? $this->detectDevice($userAgent),
                    'browser' => $data['browser'] ?? $this->detectBrowser($userAgent),
                    'os' => $data['os'] ?? $this->detectOs($userAgent),
                    'referer' => $data['referer'] ?? $request->header('referer'),
                    'user_agent' => $userAgent ? Str::limit($userAgent, 400) : null,
                    'duration_seconds' => isset($data['duration_seconds']) ? (int) $data['duration_seconds'] : 5,
                    'last_seen_at' => $now,
                ]);
            }

            return response()->json([
                'success' => true,
                'visitor_uuid' => $visitorUuid,
                'visit_id' => $visit->id,
                'screen' => $visit->screen,
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Traffic ping could not be recorded: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to record ping: ' . $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Endpoint administrativo: Consulta de auditoría y métricas de tráfico.
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $filter = $request->query('filter', 'all'); // all, registered, guests, online
        $screen = $request->query('screen', 'all');
        $dateRange = $request->query('range', 'all'); // today, 7days, 30days, all
        $search = trim((string) $request->query('q', ''));

        $query = GardenTrafficVisit::with('user')->latest('last_seen_at');

        // Filtro por tipo de usuario
        if ($filter === 'registered') {
            $query->registered();
        } elseif ($filter === 'guests') {
            $query->guests();
        } elseif ($filter === 'online') {
            $query->onlineNow(5);
        }

        // Filtro por pantalla
        if ($screen && $screen !== 'all') {
            $query->where('screen', $screen);
        }

        // Filtro por rango temporal
        if ($dateRange === 'today') {
            $query->today();
        } elseif ($dateRange === '7days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($dateRange === '30days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        // Búsqueda libre
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('visitor_uuid', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $visits = $query->paginate(25);

        // Métricas KPI globales
        $onlineNowCount = GardenTrafficVisit::onlineNow(5)->distinct('visitor_uuid')->count('visitor_uuid');
        $visitsTodayCount = GardenTrafficVisit::today()->count();
        $uniqueVisitorsToday = GardenTrafficVisit::today()->distinct('visitor_uuid')->count('visitor_uuid');
        $registeredToday = GardenTrafficVisit::today()->registered()->distinct('user_id')->count('user_id');

        $topScreenRecord = GardenTrafficVisit::today()
            ->selectRaw('screen, count(*) as count')
            ->groupBy('screen')
            ->orderByDesc('count')
            ->first();

        $topScreen = $topScreenRecord ? $topScreenRecord->screen : 'inicio';

        // Gráfico últimos 7 días
        $sevenDays = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->translatedFormat('D d');
            $count = GardenTrafficVisit::whereDate('created_at', $date)->count();
            $sevenDays[] = [
                'date' => $dateStr,
                'label' => $label,
                'visits' => $count,
            ];
        }

        return response()->json([
            'visits' => $visits,
            'metrics' => [
                'online_now' => $onlineNowCount,
                'visits_today' => $visitsTodayCount,
                'unique_visitors_today' => $uniqueVisitorsToday,
                'registered_today' => $registeredToday,
                'top_screen' => $topScreen,
            ],
            'chart' => $sevenDays,
        ]);
    }

    /**
     * Purga opcional de registros antiguos (Solo Admin).
     */
    public function purge(Request $request): JsonResponse
    {
        $days = (int) $request->input('days', 30);
        $days = max(7, min(365, $days));

        $deleted = GardenTrafficVisit::where('created_at', '<', Carbon::now()->subDays($days))->delete();

        return response()->json([
            'success' => true,
            'message' => "Se han purgado {$deleted} registros de tráfico con más de {$days} días de antigüedad.",
            'deleted_count' => $deleted,
        ]);
    }

    private function detectDevice(?string $ua): string
    {
        if (!$ua) return 'Escritorio';
        $uaLower = strtolower($ua);
        if (str_contains($uaLower, 'mobile') || str_contains($uaLower, 'android') || str_contains($uaLower, 'iphone')) {
            return 'Móvil';
        }
        if (str_contains($uaLower, 'ipad') || str_contains($uaLower, 'tablet')) {
            return 'Tablet';
        }
        return 'Escritorio';
    }

    private function detectBrowser(?string $ua): string
    {
        if (!$ua) return 'Desconocido';
        if (str_contains($ua, 'Edg/')) return 'Edge';
        if (str_contains($ua, 'Chrome/') && !str_contains($ua, 'Edg/')) return 'Chrome';
        if (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome/')) return 'Safari';
        if (str_contains($ua, 'Firefox/')) return 'Firefox';
        if (str_contains($ua, 'Opera/') || str_contains($ua, 'OPR/')) return 'Opera';
        return 'Navegador Web';
    }

    private function detectOs(?string $ua): string
    {
        if (!$ua) return 'Desconocido';
        $uaLower = strtolower($ua);
        if (str_contains($uaLower, 'windows')) return 'Windows';
        if (str_contains($uaLower, 'android')) return 'Android';
        if (str_contains($uaLower, 'iphone') || str_contains($uaLower, 'ipad') || str_contains($uaLower, 'ios')) return 'iOS';
        if (str_contains($uaLower, 'mac os') || str_contains($uaLower, 'macintosh')) return 'macOS';
        if (str_contains($uaLower, 'linux')) return 'Linux';
        return 'Sistema Operativo';
    }
}

