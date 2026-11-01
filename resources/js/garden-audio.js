/**
 * garden-audio.js
 * Sistema de música ambiente generada con Web Audio API.
 * Sin archivos externos · Fade suave entre secciones · Control de volumen.
 */

// ─── Estado global ─────────────────────────────────────────────────────────────
let audioCtx = null;
let masterGain = null;
let currentTrackNodes = [];      // nodos del track activo
let currentSection = null;
let fadeTimer = null;
let userEnabledAudio = false;    // requiere gesto del usuario (política del navegador)
let pendingSection = null;

// ─── Perfiles de música por sección ────────────────────────────────────────────
// Cada perfil define la escala, bpm, reverb, y tipo de timbre.
const TRACK_PROFILES = {
    // Secciones con juegos activos → música más rítmica y viva
    'jardines-liria': {
        label: 'Jardín 3D',
        scale: [261.63, 293.66, 329.63, 349.23, 392.00, 440.00, 493.88, 523.25], // C mayor
        baseFreq: 130.81,
        bpm: 72,
        timbre: 'harp',
        reverbWet: 0.45,
        volume: 0.30,
    },
    'sultana-plataformas': {
        label: 'Plataformas',
        scale: [220.00, 246.94, 261.63, 293.66, 329.63, 369.99, 415.30, 440.00], // A menor
        baseFreq: 110.00,
        bpm: 88,
        timbre: 'pluck',
        reverbWet: 0.30,
        volume: 0.28,
    },
    'aventura-sultana': {
        label: 'Aventura',
        scale: [261.63, 294.33, 329.63, 349.23, 392.00, 440.00, 493.88, 523.25], // C lídio
        baseFreq: 130.81,
        bpm: 60,
        timbre: 'pad',
        reverbWet: 0.60,
        volume: 0.22,
    },
    'rompecabezas': {
        label: 'Puzzle',
        scale: [277.18, 311.13, 369.99, 415.30, 466.16, 554.37, 622.25, 739.99], // C# menor
        baseFreq: 138.59,
        bpm: 66,
        timbre: 'bell',
        reverbWet: 0.55,
        volume: 0.24,
    },
    'conociendo-carla': {
        label: 'Quiz',
        scale: [261.63, 329.63, 392.00, 523.25, 659.25, 783.99, 1046.50], // C mayor arpeggio
        baseFreq: 130.81,
        bpm: 80,
        timbre: 'pluck',
        reverbWet: 0.35,
        volume: 0.26,
    },
    'bingo-amable': {
        label: 'Bingo',
        scale: [392.00, 440.00, 493.88, 523.25, 587.33, 659.25, 739.99, 783.99], // G mayor
        baseFreq: 196.00,
        bpm: 76,
        timbre: 'harp',
        reverbWet: 0.40,
        volume: 0.28,
    },
    'adivina-escena': {
        label: 'Adivina Escena',
        scale: [349.23, 392.00, 440.00, 493.88, 523.25, 587.33, 659.25, 698.46], // F mayor
        baseFreq: 174.61,
        bpm: 70,
        timbre: 'pad',
        reverbWet: 0.50,
        volume: 0.25,
    },
    // Secciones de lectura/descanso → ambiente muy suave
    'inicio': {
        label: 'Inicio',
        scale: [261.63, 293.66, 329.63, 392.00, 440.00, 523.25, 659.25, 783.99],
        baseFreq: 130.81,
        bpm: 52,
        timbre: 'pad',
        reverbWet: 0.70,
        volume: 0.18,
    },
    'jardin': {
        label: 'Jardín',
        scale: [261.63, 293.66, 329.63, 392.00, 440.00, 523.25],
        baseFreq: 130.81,
        bpm: 50,
        timbre: 'pad',
        reverbWet: 0.75,
        volume: 0.16,
    },
    'biblioteca': {
        label: 'Biblioteca',
        scale: [220.00, 261.63, 311.13, 349.23, 415.30, 466.16],
        baseFreq: 110.00,
        bpm: 48,
        timbre: 'pad',
        reverbWet: 0.80,
        volume: 0.14,
    },
    'galeria': {
        label: 'Galería',
        scale: [329.63, 369.99, 415.30, 493.88, 554.37, 622.25],
        baseFreq: 164.81,
        bpm: 54,
        timbre: 'bell',
        reverbWet: 0.65,
        volume: 0.18,
    },
    'historias': {
        label: 'Historias',
        scale: [261.63, 311.13, 349.23, 415.30, 466.16, 523.25],
        baseFreq: 130.81,
        bpm: 50,
        timbre: 'pad',
        reverbWet: 0.78,
        volume: 0.15,
    },
    'dedicatoria': {
        label: 'Dedicatoria',
        scale: [261.63, 329.63, 392.00, 523.25, 659.25, 783.99],
        baseFreq: 130.81,
        bpm: 48,
        timbre: 'harp',
        reverbWet: 0.72,
        volume: 0.20,
    },
    '__default__': {
        label: 'General',
        scale: [261.63, 293.66, 329.63, 392.00, 440.00, 523.25],
        baseFreq: 130.81,
        bpm: 58,
        timbre: 'pad',
        reverbWet: 0.60,
        volume: 0.16,
    },
};

// ─── Inicializar AudioContext ───────────────────────────────────────────────────
function ensureContext() {
    if (audioCtx) return true;
    try {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        masterGain = audioCtx.createGain();
        masterGain.gain.setValueAtTime(0, audioCtx.currentTime);
        masterGain.connect(audioCtx.destination);
        return true;
    } catch {
        return false;
    }
}

// ─── Reverb (convolution simple con ruido filtrado) ────────────────────────────
function buildReverb(wetLevel = 0.4) {
    if (!audioCtx) return null;
    const convolver = audioCtx.createConvolver();
    const sampleRate = audioCtx.sampleRate;
    const duration = 2.5;
    const length = Math.floor(sampleRate * duration);
    const buffer = audioCtx.createBuffer(2, length, sampleRate);
    for (let c = 0; c < 2; c++) {
        const data = buffer.getChannelData(c);
        for (let i = 0; i < length; i++) {
            data[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / length, 2.5);
        }
    }
    convolver.buffer = buffer;
    const wetGain = audioCtx.createGain();
    wetGain.gain.value = wetLevel;
    convolver.connect(wetGain);
    return { convolver, wetGain };
}

// ─── Generadores de timbre ──────────────────────────────────────────────────────
function createOscillatorVoice(freq, timbre, when, duration) {
    if (!audioCtx) return [];
    const nodes = [];
    const env = audioCtx.createGain();
    env.gain.setValueAtTime(0, when);

    switch (timbre) {
        case 'harp': {
            // Arpas: ataque rápido, decaimiento medio, oscilador triangular + armónico
            const osc = audioCtx.createOscillator();
            osc.type = 'triangle';
            osc.frequency.value = freq;
            const osc2 = audioCtx.createOscillator();
            osc2.type = 'sine';
            osc2.frequency.value = freq * 2;
            const g2 = audioCtx.createGain(); g2.gain.value = 0.25;
            osc2.connect(g2); g2.connect(env);
            osc.connect(env);
            env.gain.linearRampToValueAtTime(0.9, when + 0.01);
            env.gain.exponentialRampToValueAtTime(0.001, when + duration);
            osc.start(when); osc2.start(when);
            osc.stop(when + duration); osc2.stop(when + duration);
            nodes.push(osc, osc2, g2, env);
            break;
        }
        case 'pluck': {
            // Pluck: Karplus-Strong simplificado con ruido filtrado
            const bufLen = Math.floor(audioCtx.sampleRate / freq);
            const buf = audioCtx.createBuffer(1, bufLen, audioCtx.sampleRate);
            const data = buf.getChannelData(0);
            for (let i = 0; i < bufLen; i++) data[i] = Math.random() * 2 - 1;
            const src = audioCtx.createBufferSource();
            src.buffer = buf; src.loop = true;
            const filter = audioCtx.createBiquadFilter();
            filter.type = 'lowpass'; filter.frequency.value = freq * 6;
            src.connect(filter); filter.connect(env);
            env.gain.linearRampToValueAtTime(0.85, when + 0.005);
            env.gain.exponentialRampToValueAtTime(0.001, when + duration * 0.7);
            src.start(when); src.stop(when + duration);
            nodes.push(src, filter, env);
            break;
        }
        case 'bell': {
            // Bell: dos osciladores en relación inarmónica con decaimiento largo
            [[1, 0.8], [2.76, 0.3], [5.4, 0.15]].forEach(([ratio, amp]) => {
                const osc = audioCtx.createOscillator();
                osc.type = 'sine';
                osc.frequency.value = freq * ratio;
                const g = audioCtx.createGain(); g.gain.value = amp;
                osc.connect(g); g.connect(env);
                osc.start(when); osc.stop(when + duration * 1.8);
                nodes.push(osc, g);
            });
            env.gain.linearRampToValueAtTime(0.7, when + 0.008);
            env.gain.exponentialRampToValueAtTime(0.001, when + duration * 1.6);
            nodes.push(env);
            break;
        }
        case 'pad':
        default: {
            // Pad: onda senoidal suave con vibrato lento
            const osc = audioCtx.createOscillator();
            osc.type = 'sine';
            osc.frequency.value = freq;
            const lfo = audioCtx.createOscillator();
            lfo.type = 'sine'; lfo.frequency.value = 5;
            const lfoGain = audioCtx.createGain(); lfoGain.gain.value = freq * 0.005;
            lfo.connect(lfoGain); lfoGain.connect(osc.frequency);
            osc.connect(env);
            env.gain.linearRampToValueAtTime(0.6, when + 0.25);
            env.gain.setValueAtTime(0.6, when + duration - 0.3);
            env.gain.linearRampToValueAtTime(0, when + duration);
            osc.start(when); lfo.start(when);
            osc.stop(when + duration + 0.05); lfo.stop(when + duration + 0.05);
            nodes.push(osc, lfo, lfoGain, env);
            break;
        }
    }
    return nodes;
}

// ─── Tono de bajo continuo ─────────────────────────────────────────────────────
function createDrone(baseFreq, volume) {
    if (!audioCtx) return [];
    const osc = audioCtx.createOscillator();
    osc.type = 'sine';
    osc.frequency.value = baseFreq;
    const g = audioCtx.createGain();
    g.gain.value = volume * 0.18;
    // vibrato suavísimo
    const lfo = audioCtx.createOscillator();
    lfo.type = 'sine'; lfo.frequency.value = 0.3;
    const lfoG = audioCtx.createGain(); lfoG.gain.value = baseFreq * 0.003;
    lfo.connect(lfoG); lfoG.connect(osc.frequency);
    osc.connect(g);
    lfo.start(); osc.start();
    return [osc, g, lfo, lfoG];
}

// ─── Motor de secuenciación ─────────────────────────────────────────────────────
function buildTrack(profile, reverb) {
    const { scale, baseFreq, bpm, timbre, volume } = profile;
    const beatDuration = 60 / bpm;
    const notesPerBeat = timbre === 'pad' ? 2 : 1;
    const noteStep = beatDuration / notesPerBeat;

    // Patrones melódicos (índices en scale) — varios para variedad
    const patterns = [
        [0, 2, 4, 2, 5, 3, 1, 0],
        [4, 2, 0, 1, 3, 5, 4, 2],
        [0, 1, 3, 4, 3, 1, 0, 2],
        [2, 4, 5, 4, 2, 1, 0, 1],
        [5, 4, 2, 0, 1, 3, 4, 5],
    ];

    let patternIndex = 0;
    let noteIndex = 0;
    let scheduledNodes = [];
    let stopped = false;
    const LOOK_AHEAD = 0.2;     // segundos de anticipación
    const SCHEDULE_INTERVAL = 100; // ms

    // Drone de bajo
    const droneNodes = createDrone(baseFreq, volume);
    droneNodes.forEach((n) => {
        if (n instanceof GainNode) n.connect(masterGain);
        else if (n instanceof OscillatorNode) {/* connected via gain */}
    });
    // Conectar drone correctamente
    const droneGain = droneNodes[1];
    if (droneGain) droneGain.connect(masterGain);

    let nextNoteTime = audioCtx.currentTime + 0.1;

    function scheduleNote() {
        if (stopped) return;

        while (nextNoteTime < audioCtx.currentTime + LOOK_AHEAD) {
            const pattern = patterns[patternIndex % patterns.length];
            const scaleIdx = pattern[noteIndex % pattern.length];
            const freq = scale[scaleIdx % scale.length];

            // Octava aleatoria para variedad
            const octave = Math.random() < 0.25 ? 0.5 : Math.random() < 0.2 ? 2 : 1;
            const noteDuration = beatDuration * (Math.random() < 0.3 ? 1.8 : 1.2);

            const noteNodes = createOscillatorVoice(freq * octave, timbre, nextNoteTime, noteDuration);

            noteNodes.forEach((n) => {
                if (n instanceof GainNode) {
                    const volGain = audioCtx.createGain();
                    volGain.gain.value = volume;
                    n.connect(volGain);
                    // Connect to reverb if available
                    if (reverb) {
                        volGain.connect(reverb.convolver);
                        reverb.wetGain.connect(masterGain);
                    }
                    volGain.connect(masterGain);
                    scheduledNodes.push(volGain);
                }
            });
            scheduledNodes.push(...noteNodes);

            noteIndex++;
            if (noteIndex % pattern.length === 0) {
                patternIndex++;
                // Silencio ocasional entre patrones
                nextNoteTime += noteStep * (Math.random() < 0.3 ? 3 : 1);
            }
            nextNoteTime += noteStep;
        }

        if (!stopped) {
            setTimeout(scheduleNote, SCHEDULE_INTERVAL);
        }
    }

    scheduleNote();

    return {
        allNodes: [...droneNodes, ...scheduledNodes],
        droneNodes,
        stop() {
            stopped = true;
            droneNodes.forEach((n) => {
                try { if (n.stop) n.stop(); } catch {}
                try { n.disconnect(); } catch {}
            });
        },
    };
}

// ─── Fade in/out ───────────────────────────────────────────────────────────────
const FADE_DURATION = 1.8; // segundos

function fadeOut(cb) {
    if (!masterGain || !audioCtx) { if (cb) cb(); return; }
    const now = audioCtx.currentTime;
    masterGain.gain.cancelScheduledValues(now);
    masterGain.gain.setValueAtTime(masterGain.gain.value, now);
    masterGain.gain.linearRampToValueAtTime(0, now + FADE_DURATION);
    setTimeout(() => {
        stopCurrentTrack();
        if (cb) cb();
    }, FADE_DURATION * 1000 + 50);
}

function fadeIn(targetVolume = 0.3) {
    if (!masterGain || !audioCtx) return;
    const now = audioCtx.currentTime;
    masterGain.gain.cancelScheduledValues(now);
    masterGain.gain.setValueAtTime(0, now);
    masterGain.gain.linearRampToValueAtTime(targetVolume, now + FADE_DURATION);
}

function stopCurrentTrack() {
    currentTrackNodes.forEach((track) => {
        try { track.stop?.(); } catch {}
        try { track.disconnect?.(); } catch {}
    });
    currentTrackNodes = [];
}

// ─── API pública ───────────────────────────────────────────────────────────────

/**
 * Cambiar a la música de la sección indicada con fade.
 * @param {string} section  — valor del data-screen
 */
export function playMusicForScreen(section) {
    // Sonidos predeterminados de sala desactivados: solo se reproducen los audios cargados desde el panel Admin
    return;
}

export function enableAudio() {
    // Sonidos predeterminados de sala desactivados
    return;
}

/**
 * Pausar/reanudar toda la música.
 */
export function toggleMusic() {
    if (!audioCtx) return false;
    if (audioCtx.state === 'running') {
        audioCtx.suspend();
        return false;
    } else {
        audioCtx.resume();
        return true;
    }
}

/**
 * Ajustar volumen global 0..1
 */
export function setMasterVolume(v) {
    if (!masterGain || !audioCtx) return;
    masterGain.gain.cancelScheduledValues(audioCtx.currentTime);
    masterGain.gain.setValueAtTime(v, audioCtx.currentTime);
}

/**
 * ¿Está sonando música?
 */
export function isMusicPlaying() {
    return audioCtx?.state === 'running' && currentTrackNodes.length > 0;
}

/**
 * Apagar y silenciar totalmente la música de fondo.
 */
export function muteBackgroundMusic() {
    stopCurrentTrack();
    if (fadeTimer) {
        clearTimeout(fadeTimer);
        fadeTimer = null;
    }
    if (masterGain && audioCtx) {
        try {
            masterGain.gain.cancelScheduledValues(audioCtx.currentTime);
            masterGain.gain.setValueAtTime(0, audioCtx.currentTime);
        } catch (_) {}
    }
    if (audioCtx && audioCtx.state === 'running') {
        try {
            audioCtx.suspend();
        } catch (_) {}
    }
}
