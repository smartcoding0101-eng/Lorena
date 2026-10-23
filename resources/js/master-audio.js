/**
 * master-audio.js
 * ═══════════════════════════════════════════════════════════════════════════════
 *  EL JARDÍN DE CARLA LORENA · BOTÓN FLOTANTE & SISTEMA DE APAGADO GENERAL DE SONIDO
 * ═══════════════════════════════════════════════════════════════════════════════
 *  Garantiza el apagado total e inmediato de TODOS los emisores de audio de la web:
 *  1. ATMÓSFERA EMOCIONAL / El Clima del Jardín (loops ambientales, lluvia, trinos, arpas, etc.)
 *  2. Melodía de la música de fondo (garden-audio.js)
 *  3. Melodía serena de acordes pentatónicos (relax-melody-btn)
 *  4. Efectos sonoros táctiles y micro-interacciones (chimes, campanas, gotas, arpas, rosas, deseos)
 *  5. Reproductor multimedia (entertainment-player.js HTML5 audio, video, YouTube)
 *  6. Garantiza CERO emisión de sonido al hacer clic en este botón de apagado.
 */

import { muteBackgroundMusic } from './garden-audio.js';
import { stopAllWeatherSound } from './seasonal-weather.js';
import { pauseEntertainmentMedia } from './entertainment-player.js';

const STORAGE_KEY_MASTER_MUTE = 'carla_garden_master_audio_muted_v1';

let isMuted = localStorage.getItem(STORAGE_KEY_MASTER_MUTE) === '1';
let floatingBtn = null;

function showSilentToast(msg) {
    const toast = document.querySelector('.toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('is-visible');
    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 3200);
}

function renderButtonInnerHTML(btn) {
    if (!btn) return;

    if (isMuted) {
        btn.classList.add('is-muted');
        btn.setAttribute('aria-label', 'Activar sonido general del jardín');
        btn.setAttribute('title', 'Sonido general silenciado · Clic para activar');
        btn.innerHTML = `
            <span class="mab-icon-wrap" aria-hidden="true">
                <svg class="mab-svg mab-svg-mute" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <line x1="23" y1="9" x2="17" y2="15"></line>
                    <line x1="17" y1="9" x2="23" y2="15"></line>
                </svg>
            </span>
            <span class="mab-tooltip" role="tooltip">Sonido Apagado (Silencio Total) · Clic para Activar</span>
        `;
    } else {
        btn.classList.remove('is-muted');
        btn.setAttribute('aria-label', 'Apagar sonido general del jardín (Silencio Total)');
        btn.setAttribute('title', 'Sonido activo · Clic para Apagado General');
        btn.innerHTML = `
            <span class="mab-icon-wrap" aria-hidden="true">
                <svg class="mab-svg mab-svg-sound" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                </svg>
            </span>
            <span class="mab-tooltip" role="tooltip">Apagado General de Sonido (Silencio Total)</span>
        `;
    }
}

export const GardenMasterAudio = {
    isMuted() {
        return isMuted;
    },

    muteAll(showFeedback = true) {
        isMuted = true;
        localStorage.setItem(STORAGE_KEY_MASTER_MUTE, '1');

        // 1. Apagar El Clima del Jardín / ATMÓSFERA EMOCIONAL (sin emitir sonidos ni arpas)
        try {
            stopAllWeatherSound(true);
        } catch (_) {}

        // 2. Apagar Música de fondo ambiental
        try {
            muteBackgroundMusic();
        } catch (_) {}

        // 3. Apagar Melodía de Calma (Pentatónica)
        try {
            if (typeof window._stopAppRelaxMelody === 'function') {
                window._stopAppRelaxMelody();
            }
        } catch (_) {}

        // 4. Apagar Ambientaciones del Modal (brisa, trinos)
        try {
            if (typeof window._stopAppAmbientSounds === 'function') {
                window._stopAppAmbientSounds();
            }
        } catch (_) {}

        // 5. Pausar Reproductor de Entretenimiento (Audio/Video/YouTube)
        try {
            pauseEntertainmentMedia();
        } catch (_) {}

        // 6. Suspender cualquier AudioContext abierto en window
        try {
            if (window._globalAudioContexts && Array.isArray(window._globalAudioContexts)) {
                window._globalAudioContexts.forEach(ctx => {
                    if (ctx && ctx.state === 'running') {
                        try { ctx.suspend(); } catch (_) {}
                    }
                });
            }
        } catch (_) {}

        // 7. Sincronizar el botón de música de fondo `#music-toggle-btn`
        const musicBtn = document.getElementById('music-toggle-btn');
        if (musicBtn) {
            musicBtn.classList.remove('is-playing');
            musicBtn.setAttribute('aria-pressed', 'false');
            musicBtn.classList.add('is-master-muted');
        }

        // 8. Actualizar UI del botón flotante
        renderButtonInnerHTML(floatingBtn);

        // 9. Feedback visual silencioso (CERO sonido)
        if (showFeedback) {
            showSilentToast('🔇 Sonido general apagado · Silencio total en el jardín');
        }

        window.dispatchEvent(new CustomEvent('garden-master-audio-change', { detail: { muted: true } }));
    },

    unmuteAll(showFeedback = true) {
        isMuted = false;
        localStorage.setItem(STORAGE_KEY_MASTER_MUTE, '0');

        const musicBtn = document.getElementById('music-toggle-btn');
        if (musicBtn) {
            musicBtn.classList.remove('is-master-muted');
        }

        renderButtonInnerHTML(floatingBtn);

        if (showFeedback) {
            showSilentToast('🔊 Sonido general restaurado');
        }

        window.dispatchEvent(new CustomEvent('garden-master-audio-change', { detail: { muted: false } }));
    },

    toggle() {
        if (isMuted) {
            this.unmuteAll(true);
        } else {
            this.muteAll(true);
        }
        return isMuted;
    }
};

// Registrar en window para interceptores universales
window.GardenMasterAudio = GardenMasterAudio;

/**
 * Inicializar el Botón Flotante Maestro de Sonido
 */
export function initMasterAudioController() {
    floatingBtn = document.getElementById('master-audio-floating-btn');
    if (!floatingBtn) {
        const dock = document.getElementById('floating-dock-right');
        floatingBtn = document.createElement('button');
        floatingBtn.id = 'master-audio-floating-btn';
        floatingBtn.className = 'master-audio-floating-btn';
        floatingBtn.type = 'button';
        if (dock) {
            dock.prepend(floatingBtn);
        } else {
            document.body.appendChild(floatingBtn);
        }
    }

    renderButtonInnerHTML(floatingBtn);

    // Clic en el botón: NUNCA emite sonido alguno
    floatingBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        GardenMasterAudio.toggle();
    });

    // Si el usuario lo dejó silenciado previamente, asegurar el silencio de arranque
    if (isMuted) {
        setTimeout(() => {
            GardenMasterAudio.muteAll(false);
        }, 200);
    }
}
