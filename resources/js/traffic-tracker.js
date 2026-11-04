/**
 * Monitor y Captura de Tráfico en Tiempo Real para El Jardín de Carla
 * Captura navegación SPA (hash routing), visitantes invitados y usuarios autenticados.
 */

(function () {
    const STORAGE_KEY = 'carla_visitor_uuid';
    const PING_INTERVAL_MS = 30000; // Ping cada 30 segundos para presencia activa "En línea ahora"

    function getOrCreateVisitorUuid() {
        try {
            let uuid = localStorage.getItem(STORAGE_KEY);
            if (!uuid || uuid.length < 16) {
                uuid = 'v_' + Math.random().toString(36).substring(2, 12) + '_' + Date.now().toString(36);
                localStorage.setItem(STORAGE_KEY, uuid);
            }
            return uuid;
        } catch (_) {
            return 'v_temp_' + Math.random().toString(36).substring(2, 10);
        }
    }

    const visitorUuid = getOrCreateVisitorUuid();
    let currentScreen = getCurrentScreen();
    let screenStartTime = Date.now();
    let pingTimer = null;

    function getCurrentScreen() {
        const hash = window.location.hash.replace('#', '').trim();
        return hash || 'inicio';
    }

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function sendTrafficPing(isLeaving = false, forceScreen = null) {
        const activeScreen = forceScreen || currentScreen || getCurrentScreen();
        const durationSec = Math.max(1, Math.round((Date.now() - screenStartTime) / 1000));
        const payload = {
            visitor_uuid: visitorUuid,
            screen: activeScreen,
            duration_seconds: durationSec,
            referer: document.referrer || window.location.href,
        };

        const csrfToken = getCsrfToken();
        const url = '/traffic/ping';

        // Si la página se está cerrando, usar sendBeacon si está disponible
        if (isLeaving && navigator.sendBeacon) {
            try {
                const blob = new Blob([JSON.stringify(payload)], { type: 'application/json' });
                navigator.sendBeacon(url, blob);
                return;
            } catch (_) {}
        }

        // Petición fetch asíncrona no invasiva
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken;
        }

        fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(payload),
            keepalive: isLeaving,
        }).catch(() => {});
    }

    function handleScreenChange(forcedScreen = null) {
        const newScreen = forcedScreen || getCurrentScreen();
        if (newScreen === currentScreen) return;

        // Enviar reporte de la pantalla anterior con su duración
        sendTrafficPing(false, currentScreen);

        // Actualizar a la nueva pantalla
        currentScreen = newScreen;
        screenStartTime = Date.now();

        // Enviar ping inicial de la nueva pantalla tras pequeña transición
        setTimeout(() => sendTrafficPing(false, currentScreen), 400);
    }

    // Inicializar monitoreo
    function initTrafficTracker() {
        // Enviar primer ping rápido tras carga inicial (500ms)
        setTimeout(() => sendTrafficPing(false), 500);

        // Detectar cambios de pantalla vía eventos personalizados SPA y popstate / hashchange
        window.addEventListener('garden:screen-change', (e) => {
            if (e.detail?.screen) {
                handleScreenChange(e.detail.screen);
            }
        });
        window.addEventListener('hashchange', () => handleScreenChange());
        window.addEventListener('popstate', () => handleScreenChange());

        // Heartbeat periódico para estado "En línea ahora" (cada 30s)
        pingTimer = setInterval(() => {
            if (!document.hidden) {
                sendTrafficPing(false);
            }
        }, PING_INTERVAL_MS);

        // Al cambiar de pestaña o volver a activarse
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                sendTrafficPing(false);
            }
        });

        // Al cerrar o recargar la ventana
        window.addEventListener('beforeunload', () => {
            sendTrafficPing(true);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTrafficTracker);
    } else {
        initTrafficTracker();
    }
})();
