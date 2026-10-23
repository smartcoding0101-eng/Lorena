/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  EL JARDÍN DE CARLA LORENA · SUITE ATMOSFÉRICA & ESTACIONES GLOBALES (UX)
 *  PILAR 1: Climas Mágicos (Primavera 3D, Lluvia, Verano, Otoño, Invierno,
 *           Noche de Estrellas Fugaces, Burbujas de Ensueño, Calma)
 *  PILAR 2: Física Reactiva al Cursor & Gestos Táctiles (Brisa, Pops, Deseos)
 *  PILAR 3: Micro-Ajustes (Intensidad, Volumen Slider, Modo Biorritmo)
 *  PILAR 4: Sincronización Automática con Clima Real (Open-Meteo API Libre)
 * ═══════════════════════════════════════════════════════════════════════════
 */

// ── Claves de Almacenamiento Local ───────────────────────────────────────────
const STORAGE_KEY_SEASON    = 'carla_garden_season';
const STORAGE_KEY_SOUND     = 'carla_garden_season_sound';
const STORAGE_KEY_INTENSITY = 'carla_garden_season_intensity';
const STORAGE_KEY_VOLUME    = 'carla_garden_season_volume';
const STORAGE_KEY_BIORHYTHM = 'carla_garden_season_biorhythm';
const STORAGE_KEY_REAL_SYNC = 'carla_garden_season_realsync';
const STORAGE_KEY_GRADING   = 'carla_garden_color_grading';
const STORAGE_KEY_WISHES    = 'carla_garden_wishes';

// ── Catálogo Maestro de Estaciones (Pilar 1) ─────────────────────────────────
export const SEASONS_CONFIG = {
    spring: {
        id: 'spring',
        name: 'Primavera',
        fullName: 'Primavera Eterna',
        icon: '🌸',
        tooltip: 'Clima: Primavera (Pétalos 3D)',
        soundDesc: 'Brisa floral y campanillas',
        toast: '🌸 Primavera eterna: Pétalos de rosa y jazmines en vuelo'
    },
    rain: {
        id: 'rain',
        name: 'Lluvia',
        fullName: 'Lluvia Romántica',
        icon: '🌧️',
        tooltip: 'Clima: Lluvia Romántica',
        soundDesc: 'Gotas de cristal y murmullo',
        toast: '🌧️ Lluvia romántica: Gotas de cristal acariciando la tarde'
    },
    summer: {
        id: 'summer',
        name: 'Verano',
        fullName: 'Verano Mágico',
        icon: '☀️',
        tooltip: 'Clima: Verano (Luciérnagas)',
        soundDesc: 'Noche cálida y grillos serenos',
        toast: '☀️ Verano mágico: Luciérnagas doradas y calor de medianoche'
    },
    autumn: {
        id: 'autumn',
        name: 'Otoño',
        fullName: 'Otoño Cálido',
        icon: '🍂',
        tooltip: 'Clima: Otoño (Hojas en remolino)',
        soundDesc: 'Susurro de viento entre hojas',
        toast: '🍂 Otoño cálido: Remolino de hojas doradas y recuerdos'
    },
    winter: {
        id: 'winter',
        name: 'Invierno',
        fullName: 'Invierno Encantado',
        icon: '❄️',
        tooltip: 'Clima: Invierno (Nieve de cristal)',
        soundDesc: 'Viento sereno y campanas de hielo',
        toast: '❄️ Invierno encantado: Copos de nieve y escarcha de ensueño'
    },
    stars: {
        id: 'stars',
        name: 'Estrellas',
        fullName: 'Noche de Estrellas Fugaces',
        icon: '🌠',
        tooltip: 'Clima: Estrellas Fugaces (Haz clic para un deseo)',
        soundDesc: 'Frecuencia de paz 432 Hz',
        toast: '🌠 Noche estrellada: Pide un deseo cuando veas una estrella cruzar'
    },
    bubbles: {
        id: 'bubbles',
        name: 'Burbujas',
        fullName: 'Burbujas de Ensueño',
        icon: '🫧',
        tooltip: 'Clima: Burbujas (Pasa el cursor o tócalas)',
        soundDesc: 'Arpegios etéreos y manantial',
        toast: '🫧 Burbujas de ensueño: Toca o roza las burbujas para hacerlas explotar'
    },
    clear: {
        id: 'clear',
        name: 'Calma',
        fullName: 'Calma Serena',
        icon: '✨',
        tooltip: 'Clima: Calma Serena',
        soundDesc: 'Silencio y reposo',
        toast: '✨ Calma serena: Descanso visual y paz en el jardín'
    }
};

// ── Estado Global ─────────────────────────────────────────────────────────────
let currentSeason   = 'spring';
let soundEnabled    = true;
let soundVolume     = 0.7;        // 0.0 a 1.0
let intensityMode   = 'medium';   // 'low' | 'medium' | 'high'
let biorhythmActive = false;
let realSyncActive  = false;

let canvas = null;
let ctx = null;
let animFrameId = null;

let particles = [];
let splashes = [];
let sparkles = [];
let shootingStars = [];
let lastShootingStarTime = 0;

// Estado de Micro-Eventos Especiales (Pilar 8)
let rainbowState = {
    active: false,
    opacity: 0,
    maxOpacity: 0.82,
    phase: 'in',
    timer: 0
};

let auroraState = {
    active: false,
    opacity: 0,
    phase: 0
};

// Cursor y física de fluidos interactiva (Pilar 2)
let mouse = {
    x: -1000,
    y: -1000,
    prevX: -1000,
    prevY: -1000,
    vx: 0,
    vy: 0,
    speed: 0,
    isActive: false,
    lastMove: 0
};

// Web Audio API
let audioCtx = null;
let masterGainNode = null;
let activeSoundNodes = null;
let chimeTimer = null;
let raindropTimer = null;

function showToast(msg) {
    const toast = document.querySelector('.toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('is-visible');
    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 3600);
}

// ── Factor de Escala de Partículas según Intensidad (Pilar 3) ────────────────
function getIntensityMultiplier() {
    if (intensityMode === 'low') return 0.55;
    if (intensityMode === 'high') return 1.6;
    return 1.0;
}

function resizeCanvas() {
    if (!canvas) return;
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

// ── PILAR 2: Manejo de Gestos y Brisa del Cursor ─────────────────────────────
function initCursorInteraction() {
    const updateCoords = (clientX, clientY) => {
        const now = performance.now();
        const dt = Math.max(16, now - (mouse.lastMove || now));
        mouse.lastMove = now;

        if (mouse.prevX === -1000) {
            mouse.prevX = clientX;
            mouse.prevY = clientY;
        }

        mouse.vx = (clientX - mouse.prevX) / (dt / 16);
        mouse.vy = (clientY - mouse.prevY) / (dt / 16);
        mouse.speed = Math.min(25, Math.hypot(mouse.vx, mouse.vy));

        mouse.prevX = mouse.x;
        mouse.prevY = mouse.y;
        mouse.x = clientX;
        mouse.y = clientY;
        mouse.isActive = true;

        // Si estamos en modo burbujas, verificar pops al rozar
        if (currentSeason === 'bubbles') {
            checkBubbleInteractions(clientX, clientY);
        }
    };

    window.addEventListener('mousemove', (e) => {
        updateCoords(e.clientX, e.clientY);
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
        if (e.touches && e.touches[0]) {
            updateCoords(e.touches[0].clientX, e.touches[0].clientY);
        }
    }, { passive: true });

    window.addEventListener('mouseleave', () => {
        mouse.isActive = false;
        mouse.x = -1000;
        mouse.y = -1000;
    });

    // Clics interactivos en estrellas fugaces o burbujas
    window.addEventListener('click', (e) => {
        handleGlobalCanvasClick(e.clientX, e.clientY);
    });
}

function handleGlobalCanvasClick(clickX, clickY) {
    // 1. En estrellas: clic para pedir un deseo
    if (currentSeason === 'stars') {
        const hitStar = shootingStars.find(s => Math.hypot(s.x - clickX, s.y - clickY) < 60);
        if (hitStar || shootingStars.length > 0) {
            triggerWishGrantedEffect(clickX, clickY);
        }
    }
    // 2. En burbujas: clic directo para explotar
    if (currentSeason === 'bubbles') {
        checkBubbleInteractions(clickX, clickY, true);
    }
}

function triggerWishGrantedEffect(x, y) {
    playHarpChime(784); // G5 suave
    createSparkleBurst(x, y, 16, ['#fde047', '#ffffff', '#f472b6']);
    showToast('✨ ¡Pediste un deseo a la estrella fugaz! Que el universo cumpla todo lo que sueñas, Carla ♡');
}

function createSparkleBurst(x, y, count = 10, colors = ['#ffffff', '#fbcfe8']) {
    for (let i = 0; i < count; i++) {
        const angle = Math.random() * Math.PI * 2;
        const spd = 1.5 + Math.random() * 3.5;
        sparkles.push({
            x,
            y,
            vx: Math.cos(angle) * spd,
            vy: Math.sin(angle) * spd,
            color: colors[Math.floor(Math.random() * colors.length)],
            radius: 1.5 + Math.random() * 2.5,
            opacity: 1,
            decay: 0.025 + Math.random() * 0.03
        });
    }
}

// ── GENERADORES Y MOTORES DE PARTÍCULAS (PILAR 1) ───────────────────────────

// 1. PRIMAVERA (Pétalos 3D con doble faz)
const PETAL_COLORS = [
    { face: '#fbcfe8', edge: '#f472b6', shadow: '#e879f9' },
    { face: '#fda4af', edge: '#fb7185', shadow: '#f43f5e' },
    { face: '#fdf2f8', edge: '#f9a8d4', shadow: '#f472b6' },
    { face: '#ffe4e6', edge: '#fecdd3', shadow: '#fda4af' }
];

function initSpringParticles() {
    const baseCount = window.innerWidth < 640 ? 18 : 34;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        size: 8 + Math.random() * 8,
        speedY: 0.7 + Math.random() * 1.0,
        speedX: -0.3 + Math.random() * 0.6,
        rotX: Math.random() * Math.PI * 2,
        rotY: Math.random() * Math.PI * 2,
        rotZ: Math.random() * Math.PI * 2,
        spinX: (Math.random() - 0.5) * 0.04,
        spinY: (Math.random() - 0.5) * 0.04,
        spinZ: (Math.random() - 0.5) * 0.02,
        swingAngle: Math.random() * Math.PI * 2,
        swingSpeed: 0.015 + Math.random() * 0.02,
        color: PETAL_COLORS[Math.floor(Math.random() * PETAL_COLORS.length)],
        opacity: 0.55 + Math.random() * 0.35
    }));
}

function updateAndDrawSpring() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((p) => {
        p.rotX += p.spinX;
        p.rotY += p.spinY;
        p.rotZ += p.spinZ;
        p.swingAngle += p.swingSpeed;

        // Brisa reactiva al cursor (Pilar 2)
        if (mouse.isActive) {
            const dx = p.x - mouse.x;
            const dy = p.y - mouse.y;
            const dist = Math.hypot(dx, dy);
            if (dist < 110) {
                const force = (1 - dist / 110) * (mouse.speed * 0.35 + 1.2);
                p.x += (dx / dist) * force;
                p.y += (dy / dist) * force;
                p.rotZ += force * 0.05;
            }
        }

        const sway = Math.sin(p.swingAngle) * 0.9;
        p.y += p.speedY;
        p.x += p.speedX + sway;

        if (p.y > canvas.height + 30) {
            p.y = -25;
            p.x = Math.random() * canvas.width;
        }
        if (p.x < -30) p.x = canvas.width + 20;
        if (p.x > canvas.width + 30) p.x = -20;

        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.rotZ);

        const scaleX = Math.cos(p.rotX);
        const scaleY = Math.sin(p.rotY);
        ctx.scale(Math.max(0.18, Math.abs(scaleX)), Math.max(0.2, Math.abs(scaleY)));

        ctx.beginPath();
        ctx.moveTo(0, -p.size);
        ctx.bezierCurveTo(p.size * 0.85, -p.size * 0.45, p.size * 0.85, p.size * 0.5, 0, p.size);
        ctx.bezierCurveTo(-p.size * 0.85, p.size * 0.5, -p.size * 0.85, -p.size * 0.45, 0, -p.size);

        const grad = ctx.createRadialGradient(0, 0, p.size * 0.1, 0, 0, p.size);
        const fillCol = scaleX >= 0 ? p.color.face : p.color.edge;
        grad.addColorStop(0, '#ffffff');
        grad.addColorStop(0.35, fillCol);
        grad.addColorStop(1, p.color.shadow);

        ctx.fillStyle = grad;
        ctx.globalAlpha = p.opacity;
        ctx.shadowColor = 'rgba(232, 121, 249, 0.25)';
        ctx.shadowBlur = 6;
        ctx.fill();

        ctx.restore();
    });
}

// 2. LLUVIA (Gotas cristalinas con micro-splashes y desvío al viento)
function initRainParticles() {
    const baseCount = window.innerWidth < 640 ? 40 : 75;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * (canvas.width + 200) - 100,
        y: Math.random() * canvas.height,
        len: 18 + Math.random() * 22,
        speed: 16 + Math.random() * 11,
        angle: 0.22,
        thickness: 0.9 + Math.random() * 1.3,
        opacity: 0.35 + Math.random() * 0.45
    }));
    splashes = [];
}

function updateAndDrawRain() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((r) => {
        let currentAngle = r.angle;
        if (mouse.isActive) {
            const dx = r.x - mouse.x;
            const dy = r.y - mouse.y;
            if (Math.hypot(dx, dy) < 120) {
                currentAngle += (mouse.vx * 0.02);
            }
        }

        r.y += r.speed;
        r.x += r.speed * currentAngle;

        if (r.y > canvas.height - 15) {
            if (Math.random() < 0.4) {
                splashes.push({
                    x: r.x,
                    y: canvas.height - 5 - Math.random() * 10,
                    radius: 1.5,
                    maxRadius: 6 + Math.random() * 8,
                    opacity: 0.65
                });
            }
            r.y = -30;
            r.x = Math.random() * (canvas.width + 200) - 100;
        }

        const headX = r.x;
        const headY = r.y;
        const tailX = r.x - r.len * currentAngle;
        const tailY = r.y - r.len;

        const grad = ctx.createLinearGradient(tailX, tailY, headX, headY);
        grad.addColorStop(0, 'rgba(255, 255, 255, 0)');
        grad.addColorStop(0.7, `rgba(200, 225, 255, ${r.opacity * 0.7})`);
        grad.addColorStop(1, `rgba(255, 255, 255, ${r.opacity})`);

        ctx.strokeStyle = grad;
        ctx.lineWidth = r.thickness;
        ctx.lineCap = 'round';
        ctx.beginPath();
        ctx.moveTo(tailX, tailY);
        ctx.lineTo(headX, headY);
        ctx.stroke();
    });

    for (let i = splashes.length - 1; i >= 0; i--) {
        const s = splashes[i];
        s.radius += 0.8;
        s.opacity -= 0.055;
        if (s.opacity <= 0) {
            splashes.splice(i, 1);
            continue;
        }
        ctx.save();
        ctx.beginPath();
        ctx.ellipse(s.x, s.y, s.radius * 1.8, s.radius * 0.6, 0, 0, Math.PI * 2);
        ctx.strokeStyle = `rgba(215, 235, 255, ${s.opacity})`;
        ctx.lineWidth = 1;
        ctx.stroke();
        ctx.restore();
    }
}

// 3. VERANO (Luciérnagas bioluminiscentes y repulsión reactiva)
function initSummerParticles() {
    const baseCount = window.innerWidth < 640 ? 16 : 28;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        vx: (Math.random() - 0.5) * 0.7,
        vy: -0.3 - Math.random() * 0.5,
        size: 2.2 + Math.random() * 2.5,
        pulseAngle: Math.random() * Math.PI * 2,
        pulseSpeed: 0.025 + Math.random() * 0.04,
        wanderAngle: Math.random() * Math.PI * 2,
        wanderSpeed: 0.01 + Math.random() * 0.02
    }));
}

function updateAndDrawSummer() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((f) => {
        f.wanderAngle += f.wanderSpeed;
        f.pulseAngle += f.pulseSpeed;

        // Repulsión tímida ante el cursor
        if (mouse.isActive) {
            const dx = f.x - mouse.x;
            const dy = f.y - mouse.y;
            const dist = Math.hypot(dx, dy);
            if (dist < 100) {
                const evade = (1 - dist / 100) * 3.5;
                f.x += (dx / dist) * evade;
                f.y += (dy / dist) * evade;
            }
        }

        f.x += f.vx + Math.cos(f.wanderAngle) * 0.6;
        f.y += f.vy + Math.sin(f.wanderAngle) * 0.4;

        if (f.y < -30) {
            f.y = canvas.height + 20;
            f.x = Math.random() * canvas.width;
        }
        if (f.x < -30) f.x = canvas.width + 20;
        if (f.x > canvas.width + 30) f.x = -20;

        const pulse = (Math.sin(f.pulseAngle) + 1) / 2;
        const alpha = 0.25 + pulse * 0.75;
        const glowRadius = f.size * (3.5 + pulse * 4);

        ctx.save();
        const rad = ctx.createRadialGradient(f.x, f.y, 0, f.x, f.y, glowRadius);
        rad.addColorStop(0, `rgba(255, 255, 255, ${alpha})`);
        rad.addColorStop(0.2, `rgba(254, 240, 138, ${alpha * 0.9})`);
        rad.addColorStop(0.55, `rgba(245, 158, 11, ${alpha * 0.35})`);
        rad.addColorStop(1, 'rgba(245, 158, 11, 0)');

        ctx.fillStyle = rad;
        ctx.beginPath();
        ctx.arc(f.x, f.y, glowRadius, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = `rgba(255, 255, 255, ${alpha * 0.95})`;
        ctx.beginPath();
        ctx.arc(f.x, f.y, f.size * 0.8, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
    });
}

// 4. OTOÑO (Hojas cálidas con balanceo pendular y brisa)
const AUTUMN_COLORS = [
    { main: '#d97706', edge: '#b45309', shadow: '#78350f' },
    { main: '#ea580c', edge: '#c2410c', shadow: '#9a3412' },
    { main: '#b91c1c', edge: '#991b1b', shadow: '#7f1d1d' },
    { main: '#ca8a04', edge: '#a16207', shadow: '#713f12' }
];

function initAutumnParticles() {
    const baseCount = window.innerWidth < 640 ? 16 : 28;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        size: 9 + Math.random() * 9,
        speedY: 0.8 + Math.random() * 1.1,
        speedX: 0.3 + Math.random() * 0.6,
        angle: Math.random() * Math.PI * 2,
        spinSpeed: (Math.random() - 0.5) * 0.03,
        swingAngle: Math.random() * Math.PI * 2,
        swingSpeed: 0.02 + Math.random() * 0.025,
        flipAngle: Math.random() * Math.PI * 2,
        flipSpeed: 0.03 + Math.random() * 0.03,
        color: AUTUMN_COLORS[Math.floor(Math.random() * AUTUMN_COLORS.length)],
        opacity: 0.65 + Math.random() * 0.3
    }));
}

function updateAndDrawAutumn() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((l) => {
        l.swingAngle += l.swingSpeed;
        l.flipAngle += l.flipSpeed;
        l.angle += l.spinSpeed;

        if (mouse.isActive) {
            const dx = l.x - mouse.x;
            const dy = l.y - mouse.y;
            const dist = Math.hypot(dx, dy);
            if (dist < 110) {
                const force = (1 - dist / 110) * (mouse.speed * 0.4 + 1.5);
                l.x += (dx / dist) * force;
                l.y += (dy / dist) * force;
                l.angle += force * 0.08;
            }
        }

        const sway = Math.sin(l.swingAngle) * 1.4;
        l.y += l.speedY;
        l.x += l.speedX + sway;

        if (l.y > canvas.height + 35) {
            l.y = -30;
            l.x = Math.random() * (canvas.width + 100) - 50;
        }
        if (l.x > canvas.width + 40) l.x = -30;

        ctx.save();
        ctx.translate(l.x, l.y);
        ctx.rotate(l.angle);

        const scaleX = Math.cos(l.flipAngle);
        ctx.scale(Math.max(0.2, Math.abs(scaleX)), 1);

        ctx.beginPath();
        ctx.moveTo(0, -l.size);
        ctx.bezierCurveTo(l.size * 0.75, -l.size * 0.4, l.size * 0.9, l.size * 0.3, 0, l.size);
        ctx.bezierCurveTo(-l.size * 0.9, l.size * 0.3, -l.size * 0.75, -l.size * 0.4, 0, -l.size);

        const grad = ctx.createLinearGradient(0, -l.size, 0, l.size);
        grad.addColorStop(0, l.color.main);
        grad.addColorStop(0.5, l.color.edge);
        grad.addColorStop(1, l.color.shadow);

        ctx.fillStyle = grad;
        ctx.globalAlpha = l.opacity;
        ctx.shadowColor = 'rgba(180, 83, 9, 0.25)';
        ctx.shadowBlur = 5;
        ctx.fill();

        ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(0, -l.size * 0.75);
        ctx.lineTo(0, l.size * 0.85);
        ctx.stroke();

        ctx.restore();
    });
}

// 5. INVIERNO (Copos de nieve cristalinos y escarcha esponjosa)
function initWinterParticles() {
    const baseCount = window.innerWidth < 640 ? 35 : 65;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: 1.5 + Math.random() * 3.8,
        speedY: 0.5 + Math.random() * 1.1,
        speedX: (Math.random() - 0.5) * 0.5,
        swing: Math.random() * Math.PI * 2,
        swingSpeed: 0.015 + Math.random() * 0.02,
        isCrystal: Math.random() > 0.6,
        rot: Math.random() * Math.PI * 2,
        rotSpeed: (Math.random() - 0.5) * 0.02,
        opacity: 0.4 + Math.random() * 0.55
    }));
}

function updateAndDrawWinter() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((s) => {
        s.swing += s.swingSpeed;
        s.rot += s.rotSpeed;

        if (mouse.isActive) {
            const dx = s.x - mouse.x;
            const dy = s.y - mouse.y;
            const dist = Math.hypot(dx, dy);
            if (dist < 100) {
                const force = (1 - dist / 100) * 2.8;
                s.x += (dx / dist) * force;
                s.y += (dy / dist) * force;
            }
        }

        s.y += s.speedY;
        s.x += s.speedX + Math.sin(s.swing) * 0.7;

        if (s.y > canvas.height + 15) {
            s.y = -15;
            s.x = Math.random() * canvas.width;
        }
        if (s.x < -15) s.x = canvas.width + 10;
        if (s.x > canvas.width + 15) s.x = -10;

        ctx.save();
        ctx.translate(s.x, s.y);
        ctx.rotate(s.rot);
        ctx.globalAlpha = s.opacity;

        if (s.isCrystal) {
            // Cristal de nieve hexagonal fino
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 0.9;
            for (let i = 0; i < 3; i++) {
                ctx.beginPath();
                ctx.moveTo(-s.radius * 1.5, 0);
                ctx.lineTo(s.radius * 1.5, 0);
                ctx.stroke();
                ctx.rotate(Math.PI / 3);
            }
        } else {
            // Copo suave con halo de escarcha
            const grad = ctx.createRadialGradient(0, 0, 0, 0, 0, s.radius * 1.6);
            grad.addColorStop(0, '#ffffff');
            grad.addColorStop(0.5, 'rgba(235, 245, 255, 0.7)');
            grad.addColorStop(1, 'rgba(255, 255, 255, 0)');
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(0, 0, s.radius * 1.6, 0, Math.PI * 2);
            ctx.fill();
        }

        ctx.restore();
    });
}

// 6. NOCHE DE ESTRELLAS FUGACES & DESEOS (Estrellas titilantes + fugaces)
function initStarsParticles() {
    const count = window.innerWidth < 640 ? 45 : 85;
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: 0.8 + Math.random() * 1.8,
        twinkle: Math.random() * Math.PI * 2,
        twinkleSpeed: 0.02 + Math.random() * 0.04,
        color: Math.random() > 0.3 ? '#ffffff' : (Math.random() > 0.5 ? '#fef08a' : '#bae6fd')
    }));
    shootingStars = [];
    lastShootingStarTime = performance.now();
}

function spawnShootingStar() {
    const startX = Math.random() * (canvas.width * 0.75);
    const startY = Math.random() * (canvas.height * 0.4);
    const angle = 0.45 + (Math.random() - 0.5) * 0.2; // ~25° diagonal
    const speed = 18 + Math.random() * 10;
    shootingStars.push({
        x: startX,
        y: startY,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed,
        len: 120 + Math.random() * 80,
        opacity: 1,
        life: 0,
        maxLife: 45
    });
}

function updateAndDrawStars() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // 1. Estrellas fijas titilantes
    particles.forEach((st) => {
        st.twinkle += st.twinkleSpeed;
        const alpha = 0.25 + ((Math.sin(st.twinkle) + 1) / 2) * 0.75;

        ctx.save();
        ctx.fillStyle = st.color;
        ctx.globalAlpha = alpha;
        ctx.beginPath();
        ctx.arc(st.x, st.y, st.radius, 0, Math.PI * 2);
        ctx.fill();

        if (st.radius > 1.8 && alpha > 0.75) {
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
            ctx.lineWidth = 0.5;
            ctx.beginPath();
            ctx.moveTo(st.x - 4, st.y);
            ctx.lineTo(st.x + 4, st.y);
            ctx.moveTo(st.x, st.y - 4);
            ctx.lineTo(st.x, st.y + 4);
            ctx.stroke();
        }
        ctx.restore();
    });

    // 2. Estrellas fugaces periódicas (cada 5 a 10s)
    const now = performance.now();
    if (now - lastShootingStarTime > 6500 && Math.random() < 0.03) {
        spawnShootingStar();
        lastShootingStarTime = now;
    }

    for (let i = shootingStars.length - 1; i >= 0; i--) {
        const s = shootingStars[i];
        s.x += s.vx;
        s.y += s.vy;
        s.life++;

        if (s.life > s.maxLife * 0.6) {
            s.opacity = Math.max(0, 1 - (s.life - s.maxLife * 0.6) / (s.maxLife * 0.4));
        }

        if (s.opacity <= 0 || s.x > canvas.width + 100 || s.y > canvas.height + 100) {
            shootingStars.splice(i, 1);
            continue;
        }

        const tailX = s.x - (s.vx / Math.hypot(s.vx, s.vy)) * s.len;
        const tailY = s.y - (s.vy / Math.hypot(s.vx, s.vy)) * s.len;

        ctx.save();
        const grad = ctx.createLinearGradient(tailX, tailY, s.x, s.y);
        grad.addColorStop(0, 'rgba(254, 240, 138, 0)');
        grad.addColorStop(0.7, `rgba(254, 240, 138, ${s.opacity * 0.5})`);
        grad.addColorStop(1, `rgba(255, 255, 255, ${s.opacity})`);

        ctx.strokeStyle = grad;
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.shadowColor = '#fef08a';
        ctx.shadowBlur = 10;

        ctx.beginPath();
        ctx.moveTo(tailX, tailY);
        ctx.lineTo(s.x, s.y);
        ctx.stroke();
        ctx.restore();
    }

    drawSparkles();
}

// 7. BURBUJAS DE ENSUEÑO (Iridiscentes y reactivas a toques/hover)
function initBubblesParticles() {
    const baseCount = window.innerWidth < 640 ? 14 : 24;
    const count = Math.round(baseCount * getIntensityMultiplier());
    particles = Array.from({ length: count }, () => ({
        x: Math.random() * canvas.width,
        y: canvas.height + Math.random() * 200,
        radius: 12 + Math.random() * 18,
        speedY: 0.6 + Math.random() * 0.9,
        swing: Math.random() * Math.PI * 2,
        swingSpeed: 0.015 + Math.random() * 0.02,
        hue: Math.floor(Math.random() * 60) + 320, // Tonos lila a rosa
        isPopped: false
    }));
    sparkles = [];
}

function checkBubbleInteractions(px, py, forcePop = false) {
    particles.forEach((b) => {
        if (b.isPopped) return;
        const dist = Math.hypot(b.x - px, b.y - py);
        if (dist < b.radius + (forcePop ? 15 : 5)) {
            popBubble(b);
        }
    });
}

function popBubble(b) {
    b.isPopped = true;
    createSparkleBurst(b.x, b.y, 8, ['#fbcfe8', '#e9d5ff', '#ffffff']);
    playBubblePopSound();

    // Reaparecer abajo
    setTimeout(() => {
        b.y = canvas.height + 30;
        b.x = Math.random() * canvas.width;
        b.isPopped = false;
    }, 1200 + Math.random() * 1500);
}

function updateAndDrawBubbles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach((b) => {
        if (b.isPopped) return;

        b.swing += b.swingSpeed;
        b.y -= b.speedY;
        b.x += Math.sin(b.swing) * 0.7;

        // Si el cursor pasa cerca, suave deformación elástica
        let deformX = 1;
        let deformY = 1;
        if (mouse.isActive) {
            const dx = b.x - mouse.x;
            const dy = b.y - mouse.y;
            const dist = Math.hypot(dx, dy);
            if (dist < b.radius * 2.2) {
                b.x += (dx / dist) * 2;
                b.y += (dy / dist) * 2;
                deformX = 1.15;
                deformY = 0.88;
            }
        }

        if (b.y < -b.radius * 2) {
            b.y = canvas.height + b.radius;
            b.x = Math.random() * canvas.width;
        }

        ctx.save();
        ctx.translate(b.x, b.y);
        ctx.scale(deformX, deformY);

        // Borde tornasolado
        const grad = ctx.createLinearGradient(-b.radius, -b.radius, b.radius, b.radius);
        grad.addColorStop(0, 'rgba(255, 255, 255, 0.75)');
        grad.addColorStop(0.3, 'rgba(244, 114, 182, 0.55)');
        grad.addColorStop(0.7, 'rgba(192, 132, 252, 0.55)');
        grad.addColorStop(1, 'rgba(147, 197, 253, 0.75)');

        ctx.strokeStyle = grad;
        ctx.lineWidth = 1.6;
        ctx.beginPath();
        ctx.arc(0, 0, b.radius, 0, Math.PI * 2);
        ctx.stroke();

        // Relleno iridiscente casi transparente
        const fillGrad = ctx.createRadialGradient(-b.radius * 0.3, -b.radius * 0.3, 0, 0, 0, b.radius);
        fillGrad.addColorStop(0, 'rgba(255, 255, 255, 0.35)');
        fillGrad.addColorStop(0.7, 'rgba(249, 168, 212, 0.08)');
        fillGrad.addColorStop(1, 'rgba(192, 132, 252, 0.15)');
        ctx.fillStyle = fillGrad;
        ctx.fill();

        // Reflejo curvo blanco de luz
        ctx.strokeStyle = 'rgba(255, 255, 255, 0.85)';
        ctx.lineWidth = 1.4;
        ctx.beginPath();
        ctx.arc(-b.radius * 0.25, -b.radius * 0.25, b.radius * 0.55, Math.PI * 1.1, Math.PI * 1.7);
        ctx.stroke();

        ctx.restore();
    });

    drawSparkles();
}

function drawSparkles() {
    for (let i = sparkles.length - 1; i >= 0; i--) {
        const sp = sparkles[i];
        sp.x += sp.vx;
        sp.y += sp.vy;
        sp.opacity -= sp.decay;

        if (sp.opacity <= 0) {
            sparkles.splice(i, 1);
            continue;
        }

        ctx.save();
        ctx.globalAlpha = sp.opacity;
        ctx.fillStyle = sp.color;
        ctx.beginPath();
        ctx.arc(sp.x, sp.y, sp.radius, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
    }
}

// ── Micro-Eventos Celestes Especiales (Pilar 8) ──────────────────────────────
function isSpecialAtmosphericActive() {
    return (rainbowState && rainbowState.active) || (auroraState && (auroraState.active || auroraState.opacity > 0.01));
}

function ensureRenderLoopRunning() {
    if (!animFrameId) {
        if (!canvas) {
            canvas = document.getElementById('global-weather-canvas');
            if (canvas) {
                ctx = canvas.getContext('2d');
                window.addEventListener('resize', resizeCanvas);
                resizeCanvas();
            }
        }
        if (canvas && ctx) {
            renderLoop();
        }
    }
}

function drawAtmosphericSpecials() {
    if (!canvas || !ctx) return;

    // 1. ARCOÍRIS CELESTIAL ROMÁNTICO
    if (rainbowState.active) {
        const now = performance.now();
        if (rainbowState.phase === 'in') {
            rainbowState.opacity += 0.012;
            if (rainbowState.opacity >= rainbowState.maxOpacity) {
                rainbowState.opacity = rainbowState.maxOpacity;
                rainbowState.phase = 'sustain';
                rainbowState.timer = now;
            }
        } else if (rainbowState.phase === 'sustain') {
            if (now - rainbowState.timer > 9500) {
                rainbowState.phase = 'out';
            }
        } else if (rainbowState.phase === 'out') {
            rainbowState.opacity -= 0.008;
            if (rainbowState.opacity <= 0) {
                rainbowState.opacity = 0;
                rainbowState.active = false;
            }
        }

        if (rainbowState.opacity > 0) {
            ctx.save();
            ctx.globalAlpha = rainbowState.opacity * 0.42;
            const cx = canvas.width * 0.5;
            const cy = canvas.height * 1.38;
            const baseR = Math.max(canvas.width, canvas.height) * 0.74;
            const rainbowBands = [
                { color: 'rgba(239, 68, 68, 0.42)', w: 22 },  // Rojo
                { color: 'rgba(249, 115, 22, 0.42)', w: 20 }, // Naranja
                { color: 'rgba(234, 179, 8, 0.42)', w: 20 },  // Amarillo
                { color: 'rgba(34, 197, 94, 0.42)', w: 20 },  // Verde
                { color: 'rgba(6, 182, 212, 0.42)', w: 20 },  // Cian
                { color: 'rgba(59, 130, 246, 0.42)', w: 20 }, // Azul
                { color: 'rgba(168, 85, 247, 0.42)', w: 22 }  // Violeta
            ];

            let currR = baseR;
            rainbowBands.forEach((band) => {
                ctx.beginPath();
                ctx.arc(cx, cy, currR, Math.PI * 1.07, Math.PI * 1.93);
                ctx.strokeStyle = band.color;
                ctx.lineWidth = band.w;
                ctx.stroke();
                currR -= band.w;
            });
            ctx.restore();
        }
    }

    // 2. AURORA BOREAL ONDULANTE
    if (auroraState.active) {
        if (auroraState.opacity < 0.62) auroraState.opacity += 0.012;
    } else {
        if (auroraState.opacity > 0) auroraState.opacity -= 0.015;
    }

    if (auroraState.opacity > 0.005) {
        ctx.save();
        ctx.globalAlpha = auroraState.opacity;
        auroraState.phase += 0.012;

        const w = canvas.width;
        const h = canvas.height;
        const ribbons = [
            { baseColor: 'rgba(52, 211, 153, 0.32)', yOffset: h * 0.08, amp: 42, freq: 0.0025, phaseShift: 0 },
            { baseColor: 'rgba(56, 189, 248, 0.28)', yOffset: h * 0.14, amp: 52, freq: 0.0030, phaseShift: 1.5 },
            { baseColor: 'rgba(192, 132, 252, 0.26)', yOffset: h * 0.20, amp: 38, freq: 0.0022, phaseShift: 3.0 }
        ];

        ribbons.forEach((ribbon) => {
            ctx.beginPath();
            ctx.moveTo(0, 0);
            for (let x = 0; x <= w; x += 25) {
                const y = ribbon.yOffset + Math.sin(x * ribbon.freq + auroraState.phase + ribbon.phaseShift) * ribbon.amp
                         + Math.cos(x * ribbon.freq * 0.5 + auroraState.phase * 0.7) * (ribbon.amp * 0.4);
                ctx.lineTo(x, y);
            }
            ctx.lineTo(w, 0);
            ctx.closePath();

            const grad = ctx.createLinearGradient(0, 0, 0, ribbon.yOffset + ribbon.amp + 80);
            grad.addColorStop(0, 'rgba(255, 255, 255, 0)');
            grad.addColorStop(0.35, ribbon.baseColor);
            grad.addColorStop(1, 'rgba(0, 0, 0, 0)');

            ctx.fillStyle = grad;
            ctx.fill();
        });
        ctx.restore();
    }
}

// ── Bucle de Animación Maestro ───────────────────────────────────────────────
function renderLoop() {
    switch (currentSeason) {
        case 'spring':  updateAndDrawSpring(); break;
        case 'rain':    updateAndDrawRain(); break;
        case 'summer':  updateAndDrawSummer(); break;
        case 'autumn':  updateAndDrawAutumn(); break;
        case 'winter':  updateAndDrawWinter(); break;
        case 'stars':   updateAndDrawStars(); break;
        case 'bubbles': updateAndDrawBubbles(); break;
        case 'clear':
        default:
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            break;
    }

    // Dibujar micro-eventos celestiales (Pilar 8)
    drawAtmosphericSpecials();

    if (currentSeason !== 'clear' || isSpecialAtmosphericActive()) {
        animFrameId = requestAnimationFrame(renderLoop);
    } else {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        animFrameId = null;
    }
}

function startSeasonAnimation(seasonId) {
    if (animFrameId) {
        cancelAnimationFrame(animFrameId);
        animFrameId = null;
    }

    currentSeason = seasonId;

    if (!canvas) {
        canvas = document.getElementById('global-weather-canvas');
        if (canvas) {
            ctx = canvas.getContext('2d');
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
        }
    }

    if (!canvas || !ctx) return;

    switch (seasonId) {
        case 'spring':  initSpringParticles(); break;
        case 'rain':    initRainParticles(); break;
        case 'summer':  initSummerParticles(); break;
        case 'autumn':  initAutumnParticles(); break;
        case 'winter':  initWinterParticles(); break;
        case 'stars':   initStarsParticles(); break;
        case 'bubbles': initBubblesParticles(); break;
        case 'clear':
        default:
            particles = [];
            break;
    }

    renderLoop();
}

// ── SÍNTESIS SONORA AMBIENTAL (WEB AUDIO API) ────────────────────────────────
function getAudioContext() {
    if (!audioCtx) {
        const AudioClass = window.AudioContext || window.webkitAudioContext;
        if (AudioClass) {
            audioCtx = new AudioClass();
            masterGainNode = audioCtx.createGain();
            masterGainNode.gain.setValueAtTime(soundVolume, audioCtx.currentTime);
            masterGainNode.connect(audioCtx.destination);
        }
    }
    if (audioCtx && audioCtx.state === 'suspended') {
        audioCtx.resume();
    }
    return audioCtx;
}

function setMasterSoundVolume(vol) {
    soundVolume = Math.max(0, Math.min(1, vol));
    localStorage.setItem(STORAGE_KEY_VOLUME, soundVolume.toString());
    if (masterGainNode && audioCtx) {
        masterGainNode.gain.setValueAtTime(soundVolume, audioCtx.currentTime);
    }
}

function stopAmbientSound() {
    clearInterval(chimeTimer);
    clearInterval(raindropTimer);
    chimeTimer = null;
    raindropTimer = null;

    if (activeSoundNodes) {
        try {
            if (typeof activeSoundNodes.cleanup === 'function') {
                activeSoundNodes.cleanup();
            }
        } catch (_) {}
    }

    if (activeSoundNodes && audioCtx) {
        try {
            const now = audioCtx.currentTime;
            activeSoundNodes.gainNode?.gain.exponentialRampToValueAtTime(0.0001, now + 0.5);
            setTimeout(() => {
                activeSoundNodes?.sources?.forEach(s => {
                    try { s.stop(); } catch (_) {}
                });
                activeSoundNodes = null;
            }, 550);
        } catch (_) {
            activeSoundNodes = null;
        }
    }
}

let reverbNode = null;
function getReverbNode(actx) {
    if (reverbNode) return reverbNode;
    try {
        const delay = actx.createDelay(1.0);
        delay.delayTime.setValueAtTime(0.18, actx.currentTime);
        const feedback = actx.createGain();
        feedback.gain.setValueAtTime(0.24, actx.currentTime);
        const dampFilter = actx.createBiquadFilter();
        dampFilter.type = 'lowpass';
        dampFilter.frequency.setValueAtTime(2200, actx.currentTime);

        delay.connect(dampFilter);
        dampFilter.connect(feedback);
        feedback.connect(delay);

        const wetGain = actx.createGain();
        wetGain.gain.setValueAtTime(0.22, actx.currentTime);
        dampFilter.connect(wetGain);
        wetGain.connect(masterGainNode || actx.destination);

        reverbNode = delay;
        return reverbNode;
    } catch (_) {
        return masterGainNode || actx.destination;
    }
}

// ── Campanilla de Arpa Cristalina Multi-Armónica (Pilar 1, 2 & UI) ───────────
function playHarpChime(freq = 659.25) {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    const actx = getAudioContext();
    if (!actx || !soundEnabled) return;
    try {
        const t = actx.currentTime;
        const dest = masterGainNode || actx.destination;
        const rev = getReverbNode(actx);

        // 1. Armónico Fundamental (Cálido y redondo)
        const osc1 = actx.createOscillator();
        const g1 = actx.createGain();
        osc1.type = 'sine';
        osc1.frequency.setValueAtTime(freq, t);
        g1.gain.setValueAtTime(0.0001, t);
        g1.gain.exponentialRampToValueAtTime(0.038 * soundVolume, t + 0.015);
        g1.gain.exponentialRampToValueAtTime(0.0001, t + 1.6);
        osc1.connect(g1);
        g1.connect(dest);
        g1.connect(rev);
        osc1.start(t);
        osc1.stop(t + 1.65);

        // 2. Segundo Armónico (Octava brillante)
        const osc2 = actx.createOscillator();
        const g2 = actx.createGain();
        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(freq * 2, t);
        g2.gain.setValueAtTime(0.0001, t);
        g2.gain.exponentialRampToValueAtTime(0.012 * soundVolume, t + 0.012);
        g2.gain.exponentialRampToValueAtTime(0.0001, t + 1.1);
        osc2.connect(g2);
        g2.connect(dest);
        osc2.start(t);
        osc2.stop(t + 1.15);

        // 3. Tercer Armónico (Quinta dulce)
        const osc3 = actx.createOscillator();
        const g3 = actx.createGain();
        osc3.type = 'sine';
        osc3.frequency.setValueAtTime(freq * 3, t);
        g3.gain.setValueAtTime(0.0001, t);
        g3.gain.exponentialRampToValueAtTime(0.004 * soundVolume, t + 0.01);
        g3.gain.exponentialRampToValueAtTime(0.0001, t + 0.65);
        osc3.connect(g3);
        g3.connect(dest);
        osc3.start(t);
        osc3.stop(t + 0.7);
    } catch (_) {}
}

// ── Pop Acuático Cristalino de Burbujas (Pilar 1 & 2) ─────────────────────────
function playBubblePopSound() {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    const actx = getAudioContext();
    if (!actx || !soundEnabled) return;
    try {
        const t = actx.currentTime;
        const dest = masterGainNode || actx.destination;

        // Tono acuático descendente suave
        const osc = actx.createOscillator();
        const g = actx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(640, t);
        osc.frequency.exponentialRampToValueAtTime(360, t + 0.045);

        g.gain.setValueAtTime(0.0001, t);
        g.gain.exponentialRampToValueAtTime(0.024 * soundVolume, t + 0.008);
        g.gain.exponentialRampToValueAtTime(0.0001, t + 0.05);

        osc.connect(g);
        g.connect(dest);
        osc.start(t);
        osc.stop(t + 0.055);

        // Brillo agudo de la membrana al reventar
        const popSpark = actx.createOscillator();
        const popSparkGain = actx.createGain();
        popSpark.type = 'sine';
        popSpark.frequency.setValueAtTime(1380, t);
        popSparkGain.gain.setValueAtTime(0.0001, t);
        popSparkGain.gain.exponentialRampToValueAtTime(0.008 * soundVolume, t + 0.005);
        popSparkGain.gain.exponentialRampToValueAtTime(0.0001, t + 0.03);
        popSpark.connect(popSparkGain);
        popSparkGain.connect(dest);
        popSpark.start(t);
        popSpark.stop(t + 0.035);
    } catch (_) {}
}

// ── Fricción Suave sobre Cristal Empañado (Pilar 5) ───────────────────────────
let lastWipeSoundTime = 0;
function playGlassWipeSound() {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    const actx = getAudioContext();
    if (!actx || !soundEnabled) return;
    const now = performance.now();
    if (now - lastWipeSoundTime < 110) return;
    lastWipeSoundTime = now;

    try {
        const t = actx.currentTime;
        const bufferSize = Math.floor(actx.sampleRate * 0.1);
        const buffer = actx.createBuffer(1, bufferSize, actx.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
            data[i] = (Math.random() * 2 - 1) * 0.2;
        }

        const noise = actx.createBufferSource();
        noise.buffer = buffer;

        const filter = actx.createBiquadFilter();
        filter.type = 'bandpass';
        const centerFreq = 1050 + Math.random() * 300;
        filter.frequency.setValueAtTime(centerFreq, t);
        filter.frequency.exponentialRampToValueAtTime(750, t + 0.09);
        filter.Q.setValueAtTime(2.8, t);

        const gainNode = actx.createGain();
        gainNode.gain.setValueAtTime(0.0001, t);
        gainNode.gain.exponentialRampToValueAtTime(0.016 * soundVolume, t + 0.015);
        gainNode.gain.exponentialRampToValueAtTime(0.0001, t + 0.09);

        noise.connect(filter);
        filter.connect(gainNode);
        gainNode.connect(masterGainNode || actx.destination);

        noise.start(t);
        noise.stop(t + 0.095);
    } catch (_) {}
}

// ── Acorde Celestial Armónico Fmaj9 / Cmaj9 (Pilar 7 & 8) ────────────────────
function playCelestialChord() {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    const actx = getAudioContext();
    if (!actx || !soundEnabled) return;
    try {
        // Escala celestial afinada: C5, E5, G5, B5, C6, E6
        const chordNotes = [523.25, 659.25, 783.99, 987.77, 1046.50, 1318.51];
        chordNotes.forEach((freq, idx) => {
            setTimeout(() => {
                playHarpChime(freq);
            }, idx * 48);
        });
    } catch (_) {}
}

// ── Resonancia Armónica y Frecuencia de Aurora Boreal (Pilar 8) ──────────────
function playAuroraHarmonic() {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    const actx = getAudioContext();
    if (!actx || !soundEnabled) return;
    try {
        const t = actx.currentTime;
        const dest = masterGainNode || actx.destination;
        const rev = getReverbNode(actx);

        // Batido binaural curativo: 432 Hz y 435 Hz (3 Hz onda delta serena)
        const osc1 = actx.createOscillator();
        const osc2 = actx.createOscillator();
        const g = actx.createGain();
        const lp = actx.createBiquadFilter();

        lp.type = 'lowpass';
        lp.frequency.setValueAtTime(1400, t);

        osc1.type = 'sine';
        osc1.frequency.setValueAtTime(432, t);
        osc1.frequency.exponentialRampToValueAtTime(648, t + 1.6); // Quinta armónica

        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(435.5, t);
        osc2.frequency.exponentialRampToValueAtTime(651.5, t + 1.6);

        g.gain.setValueAtTime(0.0001, t);
        g.gain.exponentialRampToValueAtTime(0.028 * soundVolume, t + 0.8);
        g.gain.exponentialRampToValueAtTime(0.0001, t + 2.5);

        osc1.connect(lp);
        osc2.connect(lp);
        lp.connect(g);
        g.connect(dest);
        g.connect(rev);

        osc1.start(t);
        osc2.start(t);
        osc1.stop(t + 2.55);
        osc2.stop(t + 2.55);
    } catch (_) {}
}

// ── SÍNTESIS AMBIENTAL CONTINUA POR ESTACIÓN ─────────────────────────────────
function playAmbientSoundForSeason(seasonId) {
    stopAmbientSound();
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    if (!soundEnabled || seasonId === 'clear') return;

    const ctxAudio = getAudioContext();
    if (!ctxAudio) return;

    const now = ctxAudio.currentTime;
    const dest = masterGainNode || ctxAudio.destination;
    const rev = getReverbNode(ctxAudio);

    // 1. LLUVIA ROMÁNTICA: Lecho suave de gotas y micro-salpicaduras en pentatónica
    if (seasonId === 'rain') {
        const bufferSize = ctxAudio.sampleRate * 2;
        const buffer = ctxAudio.createBuffer(1, bufferSize, ctxAudio.sampleRate);
        const data = buffer.getChannelData(0);
        let b0 = 0, b1 = 0, b2 = 0;
        for (let i = 0; i < bufferSize; i++) {
            const white = Math.random() * 2 - 1;
            b0 = 0.99886 * b0 + white * 0.0555179;
            b1 = 0.99332 * b1 + white * 0.0750759;
            b2 = 0.96900 * b2 + white * 0.1538520;
            data[i] = (b0 + b1 + b2) * 0.08;
        }

        const rainSource = ctxAudio.createBufferSource();
        rainSource.buffer = buffer;
        rainSource.loop = true;

        const rainFilter = ctxAudio.createBiquadFilter();
        rainFilter.type = 'lowpass';
        rainFilter.frequency.setValueAtTime(750, now);

        const gainNode = ctxAudio.createGain();
        gainNode.gain.setValueAtTime(0.0001, now);
        gainNode.gain.exponentialRampToValueAtTime(0.09, now + 1.2);

        rainSource.connect(rainFilter);
        rainFilter.connect(gainNode);
        gainNode.connect(dest);
        rainSource.start();

        activeSoundNodes = { sources: [rainSource], gainNode };

        // Gotas cristalinas cayendo a intervalos orgánicos con afinación de arpa
        const raindropPentatonic = [1046.50, 1174.66, 1318.51, 1567.98, 1760.00];
        raindropTimer = setInterval(() => {
            if (!soundEnabled || currentSeason !== 'rain') return;
            try {
                const dropFreq = raindropPentatonic[Math.floor(Math.random() * raindropPentatonic.length)];
                const dropOsc = ctxAudio.createOscillator();
                const dropGain = ctxAudio.createGain();
                const t = ctxAudio.currentTime;

                dropOsc.type = 'sine';
                dropOsc.frequency.setValueAtTime(dropFreq, t);
                dropOsc.frequency.exponentialRampToValueAtTime(dropFreq * 0.7, t + 0.07);

                dropGain.gain.setValueAtTime(0.0001, t);
                dropGain.gain.exponentialRampToValueAtTime(0.015 * soundVolume, t + 0.008);
                dropGain.gain.exponentialRampToValueAtTime(0.0001, t + 0.09);

                dropOsc.connect(dropGain);
                dropGain.connect(dest);
                dropGain.connect(rev);

                dropOsc.start(t);
                dropOsc.stop(t + 0.1);
            } catch (_) {}
        }, 340);

    // 2. VERANO MÁGICO: Noche tibia con grillos tenues y aire cálido F#3/C#4
    } else if (seasonId === 'summer') {
        // Drone cálido y sereno de atardecer
        const oscWarm1 = ctxAudio.createOscillator();
        const oscWarm2 = ctxAudio.createOscillator();
        const warmGain = ctxAudio.createGain();
        const warmFilter = ctxAudio.createBiquadFilter();

        warmFilter.type = 'lowpass';
        warmFilter.frequency.setValueAtTime(260, now);

        oscWarm1.type = 'sine';
        oscWarm1.frequency.setValueAtTime(185.00, now); // F#3
        oscWarm2.type = 'sine';
        oscWarm2.frequency.setValueAtTime(277.18, now); // C#4

        warmGain.gain.setValueAtTime(0.0001, now);
        warmGain.gain.exponentialRampToValueAtTime(0.02 * soundVolume, now + 1.8);

        oscWarm1.connect(warmFilter);
        oscWarm2.connect(warmFilter);
        warmFilter.connect(warmGain);
        warmGain.connect(dest);

        oscWarm1.start(now);
        oscWarm2.start(now);

        // Grillos nocturnos sutiles y musicales
        const cricketBuffer = ctxAudio.createBuffer(1, Math.floor(ctxAudio.sampleRate * 0.04), ctxAudio.sampleRate);
        const cricketData = cricketBuffer.getChannelData(0);
        for (let i = 0; i < cricketData.length; i++) {
            cricketData[i] = (Math.random() * 2 - 1) * 0.15;
        }

        const cricketInterval = setInterval(() => {
            if (!soundEnabled || currentSeason !== 'summer') return;
            try {
                const ct = ctxAudio.currentTime;
                const crk = ctxAudio.createBufferSource();
                crk.buffer = cricketBuffer;

                const crkFilter = ctxAudio.createBiquadFilter();
                crkFilter.type = 'bandpass';
                crkFilter.frequency.setValueAtTime(4500 + Math.random() * 400, ct);
                crkFilter.Q.setValueAtTime(8, ct);

                const crkGain = ctxAudio.createGain();
                crkGain.gain.setValueAtTime(0.0001, ct);
                crkGain.gain.exponentialRampToValueAtTime(0.007 * soundVolume, ct + 0.005);
                crkGain.gain.exponentialRampToValueAtTime(0.0001, ct + 0.038);

                crk.connect(crkFilter);
                crkFilter.connect(crkGain);
                crkGain.connect(dest);

                crk.start(ct);
                crk.stop(ct + 0.04);
            } catch (_) {}
        }, 1800);

        activeSoundNodes = { 
            sources: [oscWarm1, oscWarm2], 
            gainNode: warmGain,
            cleanup: () => clearInterval(cricketInterval)
        };

    // 3. OTOÑO CÁLIDO: Brisa ondulante entre follaje dorado
    } else if (seasonId === 'autumn') {
        const bufferSize = ctxAudio.sampleRate * 2;
        const buffer = ctxAudio.createBuffer(1, bufferSize, ctxAudio.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
            data[i] = (Math.random() * 2 - 1) * 0.14;
        }

        const windSource = ctxAudio.createBufferSource();
        windSource.buffer = buffer;
        windSource.loop = true;

        const windFilter = ctxAudio.createBiquadFilter();
        windFilter.type = 'bandpass';
        windFilter.frequency.setValueAtTime(280, now);
        windFilter.Q.setValueAtTime(2.2, now);

        const windLfo = ctxAudio.createOscillator();
        const windLfoGain = ctxAudio.createGain();
        windLfo.frequency.setValueAtTime(0.12, now); // Oscilación natural lenta
        windLfoGain.gain.setValueAtTime(110, now);
        windLfo.connect(windFilter.frequency);

        const gainNode = ctxAudio.createGain();
        gainNode.gain.setValueAtTime(0.0001, now);
        gainNode.gain.exponentialRampToValueAtTime(0.07, now + 1.2);

        windSource.connect(windFilter);
        windFilter.connect(gainNode);
        gainNode.connect(dest);

        windSource.start();
        windLfo.start();

        activeSoundNodes = { sources: [windSource, windLfo], gainNode };

    // 4. PRIMAVERA ETERNA: Aire floral y campanillas eólicas afinadas
    } else if (seasonId === 'spring') {
        const bufferSize = ctxAudio.sampleRate * 2;
        const buffer = ctxAudio.createBuffer(1, bufferSize, ctxAudio.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
            data[i] = (Math.random() * 2 - 1) * 0.08;
        }

        const breeze = ctxAudio.createBufferSource();
        breeze.buffer = buffer;
        breeze.loop = true;

        const filter = ctxAudio.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.setValueAtTime(320, now);

        const gainNode = ctxAudio.createGain();
        gainNode.gain.setValueAtTime(0.0001, now);
        gainNode.gain.exponentialRampToValueAtTime(0.05, now + 1.2);

        breeze.connect(filter);
        filter.connect(gainNode);
        gainNode.connect(dest);
        breeze.start();

        activeSoundNodes = { sources: [breeze], gainNode };

        // Arpegios de campanillas eólicas (Escala Pentatónica Mayor: C5, D5, E5, G5, A5)
        const chimeNotes = [523.25, 587.33, 659.25, 783.99, 880.00];
        chimeTimer = setInterval(() => {
            if (!soundEnabled || currentSeason !== 'spring') return;
            try {
                const note = chimeNotes[Math.floor(Math.random() * chimeNotes.length)];
                playHarpChime(note);
            } catch (_) {}
        }, 4600);

    // 5. INVIERNO ENCANTADO: Escarcha cristalina y brisa helada serena
    } else if (seasonId === 'winter') {
        const bufferSize = ctxAudio.sampleRate * 2;
        const buffer = ctxAudio.createBuffer(1, bufferSize, ctxAudio.sampleRate);
        const data = buffer.getChannelData(0);
        for (let i = 0; i < bufferSize; i++) {
            data[i] = (Math.random() * 2 - 1) * 0.09;
        }

        const snowWind = ctxAudio.createBufferSource();
        snowWind.buffer = buffer;
        snowWind.loop = true;

        const filter = ctxAudio.createBiquadFilter();
        filter.type = 'bandpass';
        filter.frequency.setValueAtTime(520, now);
        filter.Q.setValueAtTime(1.8, now);

        const gainNode = ctxAudio.createGain();
        gainNode.gain.setValueAtTime(0.0001, now);
        gainNode.gain.exponentialRampToValueAtTime(0.045, now + 1.4);

        snowWind.connect(filter);
        filter.connect(gainNode);
        gainNode.connect(dest);
        snowWind.start();

        // Destello de escarcha cada 6 segundos
        const winterChimes = [1567.98, 2093.00, 2349.32];
        const winterTimer = setInterval(() => {
            if (!soundEnabled || currentSeason !== 'winter') return;
            try {
                const n = winterChimes[Math.floor(Math.random() * winterChimes.length)];
                playHarpChime(n);
            } catch (_) {}
        }, 6200);

        activeSoundNodes = { 
            sources: [snowWind], 
            gainNode,
            cleanup: () => clearInterval(winterTimer)
        };

    // 6. NOCHE DE ESTRELLAS FUGACES: Afinación 432 Hz y quinta justa de meditación
    } else if (seasonId === 'stars') {
        const osc1 = ctxAudio.createOscillator();
        const osc2 = ctxAudio.createOscillator();
        const gainNode = ctxAudio.createGain();
        const lfo = ctxAudio.createOscillator();
        const lfoGain = ctxAudio.createGain();

        // Frecuencia sagrada 432 Hz + Quinta 648 Hz
        osc1.type = 'sine';
        osc1.frequency.setValueAtTime(432, now);

        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(648, now); // Armónico perfecto

        // Vibrato de respiración suave
        lfo.type = 'sine';
        lfo.frequency.setValueAtTime(0.15, now);
        lfoGain.gain.setValueAtTime(2.5, now);
        lfo.connect(osc1.frequency);

        gainNode.gain.setValueAtTime(0.0001, now);
        gainNode.gain.exponentialRampToValueAtTime(0.038, now + 2.0);

        osc1.connect(gainNode);
        osc2.connect(gainNode);
        gainNode.connect(dest);
        gainNode.connect(rev);

        osc1.start(now);
        osc2.start(now);
        lfo.start(now);

        activeSoundNodes = { sources: [osc1, osc2, lfo], gainNode };

    // 7. BURBUJAS DE ENSUEÑO: Manantial cristalino y arpegios etéreos
    } else if (seasonId === 'bubbles') {
        const oscDrone = ctxAudio.createOscillator();
        const droneGain = ctxAudio.createGain();
        oscDrone.type = 'sine';
        oscDrone.frequency.setValueAtTime(349.23, now); // F4
        droneGain.gain.setValueAtTime(0.0001, now);
        droneGain.gain.exponentialRampToValueAtTime(0.018 * soundVolume, now + 1.5);
        oscDrone.connect(droneGain);
        droneGain.connect(dest);
        oscDrone.start();

        // Arpegios de burbujas en Fa Mayor
        const bubbleNotes = [523.25, 698.46, 880.00, 1046.50];
        let noteIdx = 0;
        const bubbleTimer = setInterval(() => {
            if (!soundEnabled || currentSeason !== 'bubbles') return;
            try {
                playHarpChime(bubbleNotes[noteIdx % bubbleNotes.length]);
                noteIdx++;
            } catch (_) {}
        }, 1600);

        activeSoundNodes = { 
            sources: [oscDrone], 
            gainNode: droneGain,
            cleanup: () => clearInterval(bubbleTimer)
        };
    }
}

// ── PILAR 3: BIORRITMO DEL JARDÍN (SEGÚN LA HORA REAL) ────────────────────────
export function evaluateBiorhythmSeason() {
    if (!biorhythmActive) return;
    const hour = new Date().getHours();
    let autoSeason = 'spring';

    if (hour >= 6 && hour < 12) {
        autoSeason = 'spring';  // Mañana fresca y flores
    } else if (hour >= 12 && hour < 17) {
        autoSeason = 'bubbles'; // Tarde soñadora
    } else if (hour >= 17 && hour < 21) {
        autoSeason = 'autumn';  // Atardecer dorado
    } else {
        autoSeason = 'stars';   // Noche estrellada
    }

    if (autoSeason !== currentSeason) {
        setGardenSeason(autoSeason, true);
        showToast(`⏰ Biorritmo activo: Ajustado a ${SEASONS_CONFIG[autoSeason].fullName} por la hora actual`);
    }
}

// ── PILAR 4: SINCRONIZACIÓN CON EL CLIMA REAL (OPEN-METEO API) ────────────────
export async function syncWithRealWeather() {
    showToast('📡 Consultando el clima exterior en tiempo real...');

    try {
        let lat = -16.5; // Coordenadas predeterminadas (La Paz / zona de Carla)
        let lon = -68.15;

        // Intentar geolocalización con timeout corto
        if (navigator.geolocation) {
            try {
                const pos = await new Promise((resolve, reject) => {
                    navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 4000 });
                });
                lat = pos.coords.latitude;
                lon = pos.coords.longitude;
            } catch (_) {
                // Si declina o timeout, usamos coordenadas por defecto sin problema
            }
        }

        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;
        const res = await fetch(url);
        const data = await res.json();

        if (!data || !data.current_weather) {
            showToast('🌤️ No se pudo obtener el clima exterior. Manteniendo atmósfera actual.');
            return;
        }

        const cw = data.current_weather;
        const code = cw.weathercode;
        const temp = Math.round(cw.temperature);
        const isDay = cw.is_day === 1;

        let detectedSeason = 'spring';
        let desc = 'Agradable';

        // Mapeo meteorológico WMO:
        if ([51, 53, 55, 61, 63, 65, 80, 81, 82].includes(code)) {
            detectedSeason = 'rain';
            desc = 'Lluvia';
        } else if ([71, 73, 75, 77, 85, 86].includes(code)) {
            detectedSeason = 'winter';
            desc = 'Nieve / Frío';
        } else if ([0, 1].includes(code)) {
            detectedSeason = isDay ? (temp > 22 ? 'summer' : 'spring') : 'stars';
            desc = isDay ? 'Cielo despejado' : 'Noche estrellada';
        } else if ([2, 3, 45, 48].includes(code)) {
            detectedSeason = 'autumn';
            desc = 'Nublado / Brisa';
        }

        setGardenSeason(detectedSeason, true);

        const weatherStatusMsg = document.getElementById('weather-real-status');
        if (weatherStatusMsg) {
            weatherStatusMsg.textContent = `📍 Exterior: ${temp}°C · ${desc}`;
            weatherStatusMsg.hidden = false;
        }

        showToast(`🌦️ Clima real detectado (${temp}°C · ${desc}): Jardín adaptado a ${SEASONS_CONFIG[detectedSeason].name}`);
    } catch (err) {
        showToast('🌤️ Clima exterior inaccesible temporalmente. Continuando en armonía.');
    }
}

// ── CONTROL UI Y ACTUALIZACIÓN ───────────────────────────────────────────────
export function setGardenSeason(seasonId, triggerToast = true) {
    if (!SEASONS_CONFIG[seasonId]) seasonId = 'spring';
    currentSeason = seasonId;

    localStorage.setItem(STORAGE_KEY_SEASON, seasonId);

    const cfg = SEASONS_CONFIG[seasonId];
    const dockIcon = document.getElementById('dock-weather-icon');
    const dockTooltip = document.getElementById('dock-weather-tooltip');
    const soundDesc = document.getElementById('weather-sound-desc');

    if (dockIcon) dockIcon.textContent = cfg.icon;
    if (dockTooltip) dockTooltip.textContent = cfg.tooltip;
    if (soundDesc) soundDesc.textContent = soundEnabled ? cfg.soundDesc : 'Sonido en silencio';

    const seasonBtns = document.querySelectorAll('.weather-season-opt');
    seasonBtns.forEach((btn) => {
        const isSelected = btn.dataset.season === seasonId;
        btn.classList.toggle('is-active', isSelected);
        btn.setAttribute('aria-checked', isSelected ? 'true' : 'false');
    });

    startSeasonAnimation(seasonId);

    if (soundEnabled) {
        playAmbientSoundForSeason(seasonId);
    } else {
        stopAmbientSound();
    }

    if (triggerToast) {
        showToast(cfg.toast);
    }
}

export function setIntensityMode(mode) {
    intensityMode = mode;
    localStorage.setItem(STORAGE_KEY_INTENSITY, mode);

    const intensityBtns = document.querySelectorAll('.weather-intensity-btn');
    intensityBtns.forEach(btn => {
        btn.classList.toggle('is-active', btn.dataset.intensity === mode);
    });

    // Reiniciar animación con nueva densidad
    startSeasonAnimation(currentSeason);
    showToast(`✨ Densidad de partículas ajustada a: ${mode === 'low' ? 'Suave' : (mode === 'high' ? 'Intensa' : 'Equilibrada')}`);
}

export function toggleSeasonSound(forceState = null) {
    if (forceState !== null) {
        soundEnabled = forceState;
    } else {
        soundEnabled = !soundEnabled;
    }

    localStorage.setItem(STORAGE_KEY_SOUND, soundEnabled ? '1' : '0');

    const soundToggle = document.getElementById('weather-sound-toggle');
    const soundIcon = document.getElementById('weather-sound-icon');
    const soundDesc = document.getElementById('weather-sound-desc');

    if (soundToggle) soundToggle.checked = soundEnabled;
    if (soundIcon) soundIcon.textContent = soundEnabled ? '🔊' : '🔇';
    if (soundDesc) {
        soundDesc.textContent = soundEnabled 
            ? SEASONS_CONFIG[currentSeason].soundDesc 
            : 'Sonido en silencio';
    }

    if (soundEnabled) {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        getAudioContext();
        playAmbientSoundForSeason(currentSeason);
        showToast(`🔊 Sonido ambiental activado (${SEASONS_CONFIG[currentSeason].name})`);
    } else {
        stopAmbientSound();
        showToast('🔇 Sonido ambiental silenciado');
    }
}

// ── APAGADO TOTAL DE SONIDO DEL CLIMA (SIN EMISIÓN SONORA) ────────────────────
export function stopAllWeatherSound(silent = true) {
    soundEnabled = false;
    localStorage.setItem(STORAGE_KEY_SOUND, '0');
    stopAmbientSound();
    if (masterGainNode && audioCtx) {
        try {
            masterGainNode.gain.cancelScheduledValues(audioCtx.currentTime);
            masterGainNode.gain.setValueAtTime(0, audioCtx.currentTime);
        } catch (_) {}
    }
    if (audioCtx && audioCtx.state === 'running') {
        try { audioCtx.suspend(); } catch (_) {}
    }
    const soundToggle = document.getElementById('weather-sound-toggle');
    const soundIcon = document.getElementById('weather-sound-icon');
    const soundDesc = document.getElementById('weather-sound-desc');
    if (soundToggle) soundToggle.checked = false;
    if (soundIcon) soundIcon.textContent = '🔇';
    if (soundDesc) soundDesc.textContent = 'Sonido en silencio';
}

// ── APAGAR TODA LA ATMÓSFERA COMPLETA ────────────────────────────────────────
export function turnOffAtmosphere() {
    // 1. Desactivar biorritmo automático si estuviera activo
    if (biorhythmActive) {
        biorhythmActive = false;
        localStorage.setItem(STORAGE_KEY_BIORHYTHM, '0');
        const biorhythmToggle = document.getElementById('weather-biorhythm-toggle');
        if (biorhythmToggle) biorhythmToggle.checked = false;
    }

    // 2. Silenciar sonido ambiental
    soundEnabled = false;
    localStorage.setItem(STORAGE_KEY_SOUND, '0');
    stopAmbientSound();
    const soundToggle = document.getElementById('weather-sound-toggle');
    const soundIcon = document.getElementById('weather-sound-icon');
    const soundDesc = document.getElementById('weather-sound-desc');
    if (soundToggle) soundToggle.checked = false;
    if (soundIcon) soundIcon.textContent = '🔇';
    if (soundDesc) soundDesc.textContent = 'Atmósfera apagada';

    // 3. Desactivar micro-eventos especiales (Arcoíris y Aurora)
    if (rainbowState) {
        rainbowState.active = false;
        rainbowState.opacity = 0;
    }
    if (auroraState) {
        auroraState.active = false;
        auroraState.opacity = 0;
        const auroraBtn = document.getElementById('btn-toggle-aurora');
        if (auroraBtn) auroraBtn.classList.remove('is-active');
    }

    // 4. Quitar filtros de color/iluminación (volver a modo natural)
    setColorGrading('none', false);

    // 5. Establecer la estación 'clear' (calma sin partículas)
    setGardenSeason('clear', false);

    // 6. Limpiar canvas inmediatamente y cancelar animación
    if (animFrameId) {
        cancelAnimationFrame(animFrameId);
        animFrameId = null;
    }
    particles = [];
    if (canvas && ctx) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // 7. Notificación visual silenciosa (CERO emisión de sonido)
    showToast('💤 Toda la atmósfera ha sido apagada. El jardín descansa en serenidad.');
}

// ═══════════════════════════════════════════════════════════════════════════
// PILAR 5: CRISTAL EMPAÑADO DE LLUVIA (DESEMPAÑAR CON DEDO / CURSOR)
// ═══════════════════════════════════════════════════════════════════════════
const MISTY_QUOTES = [
    "«Eres la luz serena que ilumina cada rincón de este jardín. Ni la lluvia más intensa puede apagar la calidez y ternura que transmites al mundo, Carla.»",
    "«Hay personas que convierten un día común en un poema inolvidable. Para este jardín y para quienes te admiran, tú eres esa persona, Carla Lorena.»",
    "«Que cada gota de lluvia lave las tristezas y cada rayo de sol te recuerde lo valiosa, fuerte y hermosa que eres. ♡»",
    "«El tiempo pasa, pero las personas nobles y de corazón luminoso florecen con más gracia en cada estación. Feliz presente, Carla.»",
    "«En este jardín secreto no hay prisa, solo serenidad, música suave y un espacio reservado para tu alegría infinita.»",
    "«Sonríe hoy con el alma. Te mereces cada estrella del cielo y cada flor que hoy perfuma este camino.»"
];

let mistyQuoteIndex = 0;
let mistyCanvas = null;
let mistyCtx = null;
let isMistyDrawing = false;

function initMistyWindow() {
    const dialog = document.getElementById('misty-window-dialog');
    const openBtn = document.getElementById('btn-open-misty-window');
    const closeBtn = document.getElementById('btn-close-misty-dialog');
    const finishBtn = document.getElementById('btn-finish-misty');
    const fogAgainBtn = document.getElementById('btn-fog-window-again');
    const heartBtn = document.getElementById('btn-reveal-secret-heart');
    const cycleQuoteBtn = document.getElementById('btn-cycle-misty-quote');
    const secretText = document.getElementById('misty-secret-text');
    mistyCanvas = document.getElementById('misty-canvas');

    if (!dialog || !mistyCanvas) return;
    mistyCtx = mistyCanvas.getContext('2d');

    function resizeMistyCanvas() {
        const rect = mistyCanvas.getBoundingClientRect();
        if (rect.width > 0 && rect.height > 0) {
            mistyCanvas.width = rect.width;
            mistyCanvas.height = rect.height;
            fogWindowCanvas();
        }
    }

    function fogWindowCanvas() {
        if (!mistyCtx || !mistyCanvas) return;
        const w = mistyCanvas.width;
        const h = mistyCanvas.height;

        mistyCtx.globalCompositeOperation = 'source-over';
        // Base de vapor fría translúcida con tono lluvia
        const grad = mistyCtx.createLinearGradient(0, 0, w, h);
        grad.addColorStop(0, 'rgba(235, 243, 250, 0.94)');
        grad.addColorStop(0.5, 'rgba(220, 235, 245, 0.96)');
        grad.addColorStop(1, 'rgba(205, 225, 240, 0.95)');
        mistyCtx.fillStyle = grad;
        mistyCtx.fillRect(0, 0, w, h);

        // Micro-gotas de condensación realistas
        mistyCtx.fillStyle = 'rgba(255, 255, 255, 0.55)';
        for (let i = 0; i < 90; i++) {
            const rx = Math.random() * w;
            const ry = Math.random() * h;
            const rr = 1.2 + Math.random() * 2.5;
            mistyCtx.beginPath();
            mistyCtx.arc(rx, ry, rr, 0, Math.PI * 2);
            mistyCtx.fill();
        }

        // Trazos tenues de chorritos de agua bajando
        mistyCtx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
        mistyCtx.lineWidth = 1.5;
        for (let i = 0; i < 7; i++) {
            const sx = (w * 0.1) + Math.random() * (w * 0.8);
            const sy = Math.random() * (h * 0.3);
            const slen = 30 + Math.random() * 60;
            mistyCtx.beginPath();
            mistyCtx.moveTo(sx, sy);
            mistyCtx.bezierCurveTo(sx + (Math.random() - 0.5) * 8, sy + slen * 0.5, sx + (Math.random() - 0.5) * 8, sy + slen, sx, sy + slen);
            mistyCtx.stroke();
        }
    }

    function wipeAt(clientX, clientY) {
        if (!mistyCtx || !mistyCanvas) return;
        const rect = mistyCanvas.getBoundingClientRect();
        const x = clientX - rect.left;
        const y = clientY - rect.top;

        mistyCtx.save();
        mistyCtx.globalCompositeOperation = 'destination-out';
        const brushR = 26;
        const wipeGrad = mistyCtx.createRadialGradient(x, y, 0, x, y, brushR);
        wipeGrad.addColorStop(0, 'rgba(0, 0, 0, 1)');
        wipeGrad.addColorStop(0.7, 'rgba(0, 0, 0, 0.85)');
        wipeGrad.addColorStop(1, 'rgba(0, 0, 0, 0)');

        mistyCtx.fillStyle = wipeGrad;
        mistyCtx.beginPath();
        mistyCtx.arc(x, y, brushR, 0, Math.PI * 2);
        mistyCtx.fill();
        mistyCtx.restore();

        playGlassWipeSound();
    }

    // Eventos del mouse
    mistyCanvas.addEventListener('mousedown', (e) => {
        isMistyDrawing = true;
        wipeAt(e.clientX, e.clientY);
    });

    window.addEventListener('mousemove', (e) => {
        if (!isMistyDrawing) return;
        wipeAt(e.clientX, e.clientY);
    });

    window.addEventListener('mouseup', () => {
        isMistyDrawing = false;
    });

    // Eventos táctiles (móvil y tablet)
    mistyCanvas.addEventListener('touchstart', (e) => {
        if (e.touches && e.touches[0]) {
            isMistyDrawing = true;
            wipeAt(e.touches[0].clientX, e.touches[0].clientY);
            e.preventDefault();
        }
    }, { passive: false });

    mistyCanvas.addEventListener('touchmove', (e) => {
        if (!isMistyDrawing) return;
        if (e.touches && e.touches[0]) {
            wipeAt(e.touches[0].clientX, e.touches[0].clientY);
            e.preventDefault();
        }
    }, { passive: false });

    mistyCanvas.addEventListener('touchend', () => {
        isMistyDrawing = false;
    });

    // Abrir modal
    openBtn?.addEventListener('click', () => {
        const popover = document.getElementById('weather-season-popover');
        if (popover) popover.hidden = true;
        dialog.showModal();
        setTimeout(resizeMistyCanvas, 60);
        showToast('🪟 Desliza sobre el cristal empañado para revelar tu mensaje secreto');
    });

    // Cerrar modal
    const closeMisty = () => {
        dialog.close();
    };
    closeBtn?.addEventListener('click', closeMisty);
    finishBtn?.addEventListener('click', closeMisty);

    // Volver a empañar
    fogAgainBtn?.addEventListener('click', () => {
        fogWindowCanvas();
        playHarpChime(523.25);
        showToast('🌫️ El cristal se ha vuelto a empañar de lluvia');
    });

    // Revelar mensaje secreto – limpiar TODO el canvas en barrido radial
    heartBtn?.addEventListener('click', () => {
        if (!mistyCtx || !mistyCanvas) return;
        playCelestialChord();
        const cx = mistyCanvas.width / 2;
        const cy = mistyCanvas.height / 2;
        const maxR = Math.sqrt(cx * cx + cy * cy) + 20;
        let r = 0;
        const speed = maxR / 28; // ~28 frames to full reveal

        const revealInterval = setInterval(() => {
            r += speed;
            mistyCtx.save();
            mistyCtx.globalCompositeOperation = 'destination-out';
            const g = mistyCtx.createRadialGradient(cx, cy, 0, cx, cy, r);
            g.addColorStop(0, 'rgba(0,0,0,1)');
            g.addColorStop(0.85, 'rgba(0,0,0,0.95)');
            g.addColorStop(1, 'rgba(0,0,0,0)');
            mistyCtx.fillStyle = g;
            mistyCtx.beginPath();
            mistyCtx.arc(cx, cy, r, 0, Math.PI * 2);
            mistyCtx.fill();
            mistyCtx.restore();

            if (r >= maxR) {
                clearInterval(revealInterval);
                // Borrar cualquier resto del canvas
                mistyCtx.clearRect(0, 0, mistyCanvas.width, mistyCanvas.height);
                createSparkleBurst(cx, cy, 20, ['#f472b6', '#ffffff', '#fbcfe8', '#fde68a']);
                showToast('💌 ¡Mensaje revelado! El amor siempre está detrás del vaho.');
            }
        }, 18);
    });

    // Cambiar frase romántica
    cycleQuoteBtn?.addEventListener('click', () => {
        mistyQuoteIndex = (mistyQuoteIndex + 1) % MISTY_QUOTES.length;
        if (secretText) {
            secretText.style.opacity = '0';
            setTimeout(() => {
                secretText.textContent = MISTY_QUOTES[mistyQuoteIndex];
                secretText.style.opacity = '1';
            }, 200);
        }
        playHarpChime(659.25);
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// PILAR 6: FILTROS CROMÁTICOS CINEMATOGRÁFICOS (COLOR GRADING)
// ═══════════════════════════════════════════════════════════════════════════
export function setColorGrading(gradingMode, showFeedback = true) {
    const validModes = ['none', 'golden', 'moonlight', 'rose', 'vintage'];
    const mode = validModes.includes(gradingMode) ? gradingMode : 'none';

    // Remover clases anteriores
    validModes.forEach((m) => {
        if (m !== 'none') document.body.classList.remove(`theme-filter-${m}`);
    });

    if (mode !== 'none') {
        document.body.classList.add(`theme-filter-${mode}`);
    }

    localStorage.setItem(STORAGE_KEY_GRADING, mode);

    // Actualizar botones en el popover
    document.querySelectorAll('.weather-grading-btn').forEach((btn) => {
        const isCurrent = btn.dataset.grading === mode;
        btn.classList.toggle('is-active', isCurrent);
        btn.setAttribute('aria-pressed', isCurrent ? 'true' : 'false');
    });

    if (showFeedback) {
        const descMap = {
            none: '🌿 Iluminación natural sin filtro',
            golden: '🌅 Atardecer Dorado: Tonos cálidos y reconfortantes',
            moonlight: '🌙 Luz de Luna: Atmósfera serena de medianoche',
            rose: '🌸 Acuarela Rosa: Matiz romántico y ensueño',
            vintage: '🌧️ Bruma Nostálgica: Tono sepia suave y poético'
        };
        showToast(descMap[mode] || 'Filtro actualizado');
        playHarpChime(587.33); // D5
    }
}

function initColorGrading() {
    const gradingBtns = document.querySelectorAll('.weather-grading-btn');
    gradingBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            setColorGrading(btn.dataset.grading, true);
        });
    });

    const savedGrading = localStorage.getItem(STORAGE_KEY_GRADING) || 'none';
    setColorGrading(savedGrading, false);
}

// ═══════════════════════════════════════════════════════════════════════════
// PILAR 7: BÓVEDA CELESTIAL DE DESEOS AL COSMOS (WISH VAULT)
// ═══════════════════════════════════════════════════════════════════════════
const DEFAULT_WISHES = [
    {
        id: 1729000000001,
        text: "Que la risa nunca falte en tus días y cada paso te acerque a tus sueños más hermosos, Carla Lorena.",
        type: "golden",
        date: "19 Oct 2026"
    },
    {
        id: 1729000000002,
        text: "Que la serenidad de este jardín secreto sea tu refugio de paz en cada instante.",
        type: "rose",
        date: "19 Oct 2026"
    }
];

function getSavedWishes() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY_WISHES);
        if (!raw) return DEFAULT_WISHES;
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) && parsed.length > 0 ? parsed : DEFAULT_WISHES;
    } catch (_) {
        return DEFAULT_WISHES;
    }
}

function saveWishesToStorage(wishes) {
    localStorage.setItem(STORAGE_KEY_WISHES, JSON.stringify(wishes));
}

function renderWishCards() {
    const listEl = document.getElementById('wishes-list');
    const badgeEl = document.getElementById('wish-count-badge');
    if (!listEl) return;

    const wishes = getSavedWishes();
    if (badgeEl) badgeEl.textContent = `${wishes.length} ${wishes.length === 1 ? 'estrella' : 'estrellas'}`;

    if (wishes.length === 0) {
        listEl.innerHTML = `
            <div class="wish-empty-state">
                <span style="font-size: 2rem;">✨</span>
                <p>Aún no has lanzado deseos. ¡Pide el primero y enciende una estrella en tu cielo!</p>
            </div>
        `;
        return;
    }

    const typeIcons = {
        golden: { icon: '🌟', label: 'Dorada', class: 'tag-golden' },
        rose:   { icon: '💖', label: 'Rosa', class: 'tag-rose' },
        purple: { icon: '🔮', label: 'Amatista', class: 'tag-purple' },
        azure:  { icon: '💎', label: 'Zafiro', class: 'tag-azure' }
    };

    listEl.innerHTML = wishes.map((w) => {
        const tInfo = typeIcons[w.type] || typeIcons.golden;
        return `
            <article class="wish-card wish-card-${w.type || 'golden'}" data-wish-id="${w.id}">
                <div class="wish-card-header">
                    <span class="wish-card-type ${tInfo.class}">${tInfo.icon} Luz ${tInfo.label}</span>
                    <time class="wish-card-date">${w.date}</time>
                </div>
                <p class="wish-card-text">«${escapeWishHtml(w.text)}»</p>
                <div class="wish-card-actions">
                    <button type="button" class="btn-resonate-wish" data-wish-id="${w.id}" title="Hacer brillar este deseo">
                        ✨ Iluminar
                    </button>
                    <button type="button" class="btn-delete-wish" data-wish-id="${w.id}" title="Liberar deseo al infinito">
                        × Soltar
                    </button>
                </div>
            </article>
        `;
    }).join('');

    // Eventos para iluminar y eliminar
    listEl.querySelectorAll('.btn-resonate-wish').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const card = e.target.closest('.wish-card');
            if (card) {
                card.classList.add('is-resonating');
                playHarpChime(784);
                setTimeout(() => card.classList.remove('is-resonating'), 800);
            }
        });
    });

    listEl.querySelectorAll('.btn-delete-wish').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const wId = Number(btn.dataset.wishId);
            const updated = getSavedWishes().filter(w => w.id !== wId);
            saveWishesToStorage(updated);
            renderWishCards();
            showToast('Estrella liberada hacia el infinito del cosmos');
        });
    });
}

function escapeWishHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function initWishVault() {
    const dialog = document.getElementById('wish-star-dialog');
    const openBtn = document.getElementById('btn-open-wish-vault');
    const closeBtn = document.getElementById('btn-close-wish-dialog');
    const form = document.getElementById('wish-star-form');
    const textarea = document.getElementById('wish-star-text');

    if (!dialog) return;

    openBtn?.addEventListener('click', () => {
        const popover = document.getElementById('weather-season-popover');
        if (popover) popover.hidden = true;
        renderWishCards();
        dialog.showModal();
    });

    closeBtn?.addEventListener('click', () => {
        dialog.close();
    });

    form?.addEventListener('submit', (e) => {
        e.preventDefault();
        const text = textarea?.value?.trim();
        if (!text) return;

        const selectedTypeEl = form.querySelector('input[name="star_type"]:checked');
        const starType = selectedTypeEl ? selectedTypeEl.value : 'golden';

        const now = new Date();
        const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        const formattedDate = `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        const newWish = {
            id: Date.now(),
            text,
            type: starType,
            date: formattedDate
        };

        const currentWishes = getSavedWishes();
        currentWishes.unshift(newWish);
        saveWishesToStorage(currentWishes);

        renderWishCards();
        if (textarea) textarea.value = '';

        // Efectos celestiales de gratificación UX
        playCelestialChord();
        spawnShootingStar();
        ensureRenderLoopRunning();

        showToast('🌠 ¡Tu deseo ha sido grabado en las estrellas de tu jardín, Carla!');
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// PILAR 8: MICRO-EVENTOS DE CLIMA SORPRESA (ARCOÍRIS & AURORA BOREAL)
// ═══════════════════════════════════════════════════════════════════════════
export function triggerRainbow() {
    rainbowState.active = true;
    rainbowState.opacity = 0;
    rainbowState.phase = 'in';
    ensureRenderLoopRunning();
    playCelestialChord();
    showToast('🌈 Un arcoíris radiante abraza el cielo de tu jardín secreto');
}

export function toggleAurora() {
    auroraState.active = !auroraState.active;
    const btn = document.getElementById('btn-toggle-aurora');
    if (btn) {
        btn.classList.toggle('is-active', auroraState.active);
    }
    if (auroraState.active) {
        ensureRenderLoopRunning();
        playAuroraHarmonic();
        showToast('🌌 Luces de Aurora Boreal ondeando sobre el horizonte');
    } else {
        showToast('Aurora Boreal desvaneciéndose en la noche serena');
    }
}

function initAtmosphericSpecials() {
    const rainbowBtn = document.getElementById('btn-trigger-rainbow');
    const auroraBtn = document.getElementById('btn-toggle-aurora');

    rainbowBtn?.addEventListener('click', () => {
        triggerRainbow();
    });

    auroraBtn?.addEventListener('click', () => {
        toggleAurora();
    });
}

// ── INICIALIZACIÓN COMPLETA ──────────────────────────────────────────────────
export function initSeasonalWeather() {
    // 1. Cargar preferencias
    const savedSeason    = localStorage.getItem(STORAGE_KEY_SEASON) || 'spring';
    const savedSound     = localStorage.getItem(STORAGE_KEY_SOUND);
    const savedIntensity = localStorage.getItem(STORAGE_KEY_INTENSITY) || 'medium';
    const savedVolume    = localStorage.getItem(STORAGE_KEY_VOLUME);
    const savedBiorhythm = localStorage.getItem(STORAGE_KEY_BIORHYTHM) === '1';

    soundEnabled    = savedSound !== null ? savedSound === '1' : true;
    intensityMode   = savedIntensity;
    soundVolume     = savedVolume !== null ? parseFloat(savedVolume) : 0.7;
    biorhythmActive = savedBiorhythm;

    // 2. Elementos del DOM
    const dockBtn        = document.getElementById('btn-weather-season');
    const popover        = document.getElementById('weather-season-popover');
    const closeBtn       = document.getElementById('btn-close-weather-popover');
    const soundToggle    = document.getElementById('weather-sound-toggle');
    const volumeSlider   = document.getElementById('weather-volume-slider');
    const biorhythmToggle= document.getElementById('weather-biorhythm-toggle');
    const realSyncBtn    = document.getElementById('btn-weather-realsync');
    const seasonOpts     = document.querySelectorAll('.weather-season-opt');
    const intensityBtns  = document.querySelectorAll('.weather-intensity-btn');

    // 3. Apertura / Cierre del Popover
    function togglePopover(show = null) {
        if (!popover) return;
        const willShow = show !== null ? show : popover.hidden;
        popover.hidden = !willShow;
        dockBtn?.setAttribute('aria-expanded', willShow ? 'true' : 'false');
        if (willShow) {
            popover.classList.add('is-open');
        } else {
            popover.classList.remove('is-open');
        }
    }

    dockBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        getAudioContext();
        togglePopover();
    });

    closeBtn?.addEventListener('click', () => togglePopover(false));

    document.addEventListener('click', (e) => {
        if (popover && !popover.hidden && !popover.contains(e.target) && !dockBtn?.contains(e.target)) {
            togglePopover(false);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && popover && !popover.hidden) {
            togglePopover(false);
        }
    });

    // 4. Selector de Estaciones (Pilar 1)
    seasonOpts.forEach((btn) => {
        btn.addEventListener('click', () => {
            const sId = btn.dataset.season;
            if (biorhythmActive) {
                biorhythmActive = false;
                localStorage.setItem(STORAGE_KEY_BIORHYTHM, '0');
                if (biorhythmToggle) biorhythmToggle.checked = false;
            }
            setGardenSeason(sId, true);
        });
    });

    // 5. Controles de Intensidad y Volumen (Pilar 3)
    intensityBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            setIntensityMode(btn.dataset.intensity);
        });
    });

    volumeSlider?.addEventListener('input', (e) => {
        setMasterSoundVolume(parseFloat(e.target.value));
    });

    biorhythmToggle?.addEventListener('change', (e) => {
        biorhythmActive = e.target.checked;
        localStorage.setItem(STORAGE_KEY_BIORHYTHM, biorhythmActive ? '1' : '0');
        if (biorhythmActive) {
            evaluateBiorhythmSeason();
        } else {
            showToast('Biorritmo desactivado: Clima en modo manual');
        }
    });

    // 6. Sincronización con Clima Real (Pilar 4)
    realSyncBtn?.addEventListener('click', () => {
        syncWithRealWeather();
    });

    // 7. Toggle de Sonido y Apagado Maestro de Atmósfera
    soundToggle?.addEventListener('change', (e) => {
        toggleSeasonSound(e.target.checked);
    });

    const turnOffBtn = document.getElementById('btn-turn-off-atmosphere');
    turnOffBtn?.addEventListener('click', () => {
        turnOffAtmosphere();
    });

    // 8. Inicializar interacción de cursor (Pilar 2)
    initCursorInteraction();

    // 9. Pilares 5, 6, 7 y 8
    initMistyWindow();
    initColorGrading();
    initWishVault();
    initAtmosphericSpecials();

    // 10. Pausar cuando la pestaña está oculta
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            if (animFrameId) cancelAnimationFrame(animFrameId);
            stopAmbientSound();
        } else {
            startSeasonAnimation(currentSeason);
            if (soundEnabled) playAmbientSoundForSeason(currentSeason);
        }
    });

    // 11. Actualizar UI inicial y arrancar
    if (soundToggle) soundToggle.checked = soundEnabled;
    if (volumeSlider) volumeSlider.value = soundVolume;
    if (biorhythmToggle) biorhythmToggle.checked = biorhythmActive;

    const activeIntBtn = document.querySelector(`.weather-intensity-btn[data-intensity="${intensityMode}"]`);
    if (activeIntBtn) activeIntBtn.classList.add('is-active');

    if (biorhythmActive) {
        evaluateBiorhythmSeason();
    } else {
        setGardenSeason(savedSeason, false);
    }
}
