/**
 * Hero Motion & Ethereal Micro-Interactions System
 * Diseñado con física de resortes, aceleración por hardware (sub-300ms)
 * y respeto a accesibilidad (prefers-reduced-motion).
 */

export function initHeroMotion() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    initHero3DParallax();
    initEnchantedRoseBurst();
    initMagneticButtons();
    initHeroEntranceReveal();
    initAmbientDriftingMotes();
}

/**
 * 1. PARALLAX 3D INTERACTIVO CON FÍSICA SUAVE (LERP) PARA EL MARCO DE RETRATOS
 */
function initHero3DParallax() {
    const frame = document.getElementById('hero-carousel-frame');
    const heroWrap = document.querySelector('.welcome-wrap');
    if (!frame || !heroWrap) return;

    let targetRotX = 0;
    let targetRotY = 0;
    let currentRotX = 0;
    let currentRotY = 0;
    let isHovering = false;
    let rafId = null;

    const ambientGlow = frame.querySelector('.frame-ambient-glow');
    const monogram = frame.querySelector('.art-stamp');

    function onMouseMove(e) {
        const rect = heroWrap.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;

        // Normalizado de -1 a 1 respecto al centro del área
        const normX = ((mouseX / rect.width) * 2 - 1);
        const normY = ((mouseY / rect.height) * 2 - 1);

        // Amplitud sutil y elegante de inclinación (máx 7.5 grados)
        targetRotX = -normY * 7.5;
        targetRotY = normX * 7.5;

        // Desplazamiento dinámico de la fuente de luz ambiental
        if (ambientGlow) {
            const lightX = 50 + normX * 28;
            const lightY = 40 + normY * 28;
            ambientGlow.style.background = `radial-gradient(circle at ${lightX}% ${lightY}%, rgba(255, 62, 154, 0.32) 0%, rgba(255, 138, 107, 0.22) 45%, transparent 70%)`;
        }
    }

    function animate() {
        // Interpolación lineal suave (lerp 0.08) para sensación de masa física
        currentRotX += (targetRotX - currentRotX) * 0.08;
        currentRotY += (targetRotY - currentRotY) * 0.08;

        frame.style.transform = `perspective(1200px) rotateX(${currentRotX.toFixed(2)}deg) rotateY(${currentRotY.toFixed(2)}deg) translateZ(${isHovering ? '12px' : '0px'})`;

        // Efecto de profundidad desacoplado para el sello de autenticidad editorial
        if (monogram) {
            monogram.style.transform = `translate3d(${-currentRotY * 1.2}px, ${currentRotX * 1.2}px, 24px)`;
        }

        rafId = requestAnimationFrame(animate);
    }

    heroWrap.addEventListener('mouseenter', () => {
        isHovering = true;
        if (!rafId) rafId = requestAnimationFrame(animate);
    });

    heroWrap.addEventListener('mousemove', onMouseMove, { passive: true });

    heroWrap.addEventListener('mouseleave', () => {
        isHovering = false;
        targetRotX = 0;
        targetRotY = 0;
        if (ambientGlow) {
            ambientGlow.style.background = '';
        }
    });

    // Iniciar loop
    rafId = requestAnimationFrame(animate);
}

/**
 * 2. BURST CINEMÁTICO DE PÉTALOS Y DESTELLOS AL TOCAR LA ROSA ENCANTADA
 */
function initEnchantedRoseBurst() {
    const trigger = document.getElementById('enchanted-rose-trigger');
    if (!trigger) return;

    const symbols = ['🌸', '✨', '🌹', '💖', '✦', '🌷', '💫'];

    function createParticleBurst(e) {
        const rect = trigger.getBoundingClientRect();
        const originX = rect.left + rect.width / 2;
        const originY = rect.top + rect.height / 2;

        const count = 16;
        for (let i = 0; i < count; i++) {
            const particle = document.createElement('span');
            particle.className = 'enchanted-particle-burst';
            particle.textContent = symbols[Math.floor(Math.random() * symbols.length)];

            // Física de dispersión radial hacia arriba
            const angle = (Math.PI * 1.1) + (Math.random() * Math.PI * 0.8); // Cono hacia arriba
            const distance = 60 + Math.random() * 110;
            const destX = Math.cos(angle) * distance;
            const destY = Math.sin(angle) * distance - 40; // Impulso ascendente adicional
            const rotation = (Math.random() - 0.5) * 180;
            const duration = 0.8 + Math.random() * 0.5;

            particle.style.cssText = `
                position: fixed;
                left: ${originX}px;
                top: ${originY}px;
                font-size: ${14 + Math.random() * 12}px;
                pointer-events: none;
                z-index: 10005;
                will-change: transform, opacity;
                transition: transform ${duration}s cubic-bezier(0.16, 1, 0.3, 1), opacity ${duration}s ease-out;
                transform: translate(-50%, -50%) scale(0.6);
                opacity: 1;
            `;

            document.body.appendChild(particle);

            // Disparar en el siguiente frame
            requestAnimationFrame(() => {
                particle.style.transform = `translate(calc(-50% + ${destX}px), calc(-50% + ${destY}px)) scale(${0.8 + Math.random() * 0.5}) rotate(${rotation}deg)`;
                particle.style.opacity = '0';
            });

            // Limpieza
            setTimeout(() => {
                particle.remove();
            }, duration * 1000 + 50);
        }

        // Respuesta háptica en móviles si está disponible
        if (navigator.vibrate) {
            navigator.vibrate([25, 40]);
        }
    }

    trigger.addEventListener('click', createParticleBurst);
}

/**
 * 3. BOTONES MAGNÉTICOS CON RESORTE ELÁSTICO (SUB-300MS)
 */
function initMagneticButtons() {
    const buttons = document.querySelectorAll('.welcome-actions .button, .statuses-quick-add-btn');

    buttons.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            // Desplazamiento elástico magnético de máx 4px
            btn.style.transform = `translate(${x * 0.16}px, ${y * 0.16}px)`;
        });

        btn.addEventListener('mouseleave', () => {
            btn.style.transform = '';
            btn.style.transition = 'transform 0.28s cubic-bezier(0.16, 1, 0.3, 1)';
            setTimeout(() => {
                btn.style.transition = '';
            }, 280);
        });
    });
}

/**
 * 4. REVELACIÓN ESCALONADA (STAGGER) AL INGRESAR A LA PANTALLA INICIO
 */
function initHeroEntranceReveal() {
    const screenInicio = document.querySelector('.screen[data-screen="inicio"]');
    if (!screenInicio) return;

    function triggerEntrance() {
        const elements = [
            screenInicio.querySelector('.romantic-crown-tag'),
            screenInicio.querySelector('.hero-grand-title .row-1'),
            screenInicio.querySelector('.hero-grand-title .row-2'),
            screenInicio.querySelector('.welcome-text'),
            screenInicio.querySelector('.welcome-actions'),
            screenInicio.querySelector('#daily-bloom-card'),
            screenInicio.querySelector('#hero-carousel-frame'),
            screenInicio.querySelector('#home-statuses-section')
        ].filter(Boolean);

        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(16px)';
            el.style.transition = `opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1) ${index * 60}ms, transform 0.65s cubic-bezier(0.16, 1, 0.3, 1) ${index * 60}ms`;

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
            });
        });
    }

    // Exponer para que el SPA router pueda re-dispararlo al volver a Inicio
    window.triggerHeroEntranceReveal = triggerEntrance;

    // Ejecutar inicial si inicio está visible
    if (!screenInicio.hasAttribute('hidden')) {
        triggerEntrance();
    }
}

/**
 * 5. MOTES BOTÁNICOS FLOTANTES SUTILES EN EL FONDO DEL HERO
 */
function initAmbientDriftingMotes() {
    const heroWrap = document.querySelector('.welcome-wrap');
    if (!heroWrap) return;

    const motesCount = 6;
    for (let i = 0; i < motesCount; i++) {
        const mote = document.createElement('div');
        mote.className = 'hero-ambient-mote';
        mote.setAttribute('aria-hidden', 'true');

        const size = 6 + Math.random() * 10;
        const startX = 5 + Math.random() * 90;
        const startY = 10 + Math.random() * 80;
        const dur = 8 + Math.random() * 8;
        const delay = Math.random() * 5;

        mote.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${startX}%;
            top: ${startY}%;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 182, 193, 0.6) 0%, rgba(255, 105, 180, 0.15) 60%, transparent 100%);
            box-shadow: 0 0 12px rgba(255, 62, 154, 0.4);
            pointer-events: none;
            z-index: 1;
            opacity: 0.75;
            animation: heroMoteFloat ${dur}s ease-in-out ${delay}s infinite alternate;
        `;

        heroWrap.appendChild(mote);
    }
}

