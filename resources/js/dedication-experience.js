/**
 * dedication-experience.js
 * Experiencia inmersiva y de vanguardia para la Rosaleda Imperial / Dedicatoria:
 * - Navegación inteligente por pestañas y scroll-spy
 * - Sello de lacre interactivo en relieve 3D con audio y destellos
 * - Copia de carta, modo luz de velas y arpegio sonoro
 * - Sellado interactivo de las 4 Promesas Eternas
 * - Sobres de ocasión desplegables con animación suave
 * - Ofrenda interactiva de rosas con persistencia en localStorage y lluvia de pétalos
 */

export function initDedicationExperience() {
    const screen = document.getElementById('screen-dedicatoria');
    if (!screen) return;

    // Helper de audio seguro
    function playChime(freq, delay = 0, duration = 1.2) {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
        setTimeout(() => {
            try {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextClass) return;
                if (!window.__gardenAudioCtx) {
                    window.__gardenAudioCtx = new AudioContextClass();
                }
                const ctx = window.__gardenAudioCtx;
                if (ctx.state === 'suspended') ctx.resume();

                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, ctx.currentTime);
                gain.gain.setValueAtTime(0.0001, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.09, ctx.currentTime + 0.04);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + duration);

                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + duration + 0.1);
            } catch (_) {}
        }, delay);
    }

    // Helper de toast seguro
    function showDedicationToast(msg) {
        if (typeof window.showToast === 'function') {
            window.showToast(msg);
        } else {
            const toastEl = document.querySelector('.toast');
            if (toastEl) {
                toastEl.textContent = msg;
                toastEl.classList.add('is-visible');
                setTimeout(() => toastEl.classList.remove('is-visible'), 3500);
            }
        }
    }

    // 1. Navegación por pestañas y filtro de secciones
    const tabBtns = screen.querySelectorAll('.dedication-tab-btn');
    const sections = screen.querySelectorAll('.dedication-section-block');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.dataset.dedicationTab;
            tabBtns.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            playChime(659.25, 0, 0.4); // E5 suave

            if (tab === 'all') {
                sections.forEach(sec => {
                    sec.style.display = '';
                    sec.classList.remove('is-highlighted');
                });
                screen.querySelector('.dedication-header-hero')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                sections.forEach(sec => {
                    if (sec.dataset.sectionCategory === tab) {
                        sec.style.display = '';
                        sec.classList.add('is-highlighted');
                        sec.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => sec.classList.remove('is-highlighted'), 2500);
                    } else {
                        sec.style.display = '';
                    }
                });
            }
        });
    });

    // 2. Sello de Lacre Interactivo 3D
    const waxSeal = document.getElementById('interactive-wax-seal');
    waxSeal?.addEventListener('click', () => {
        waxSeal.classList.add('is-spinning');
        setTimeout(() => waxSeal.classList.remove('is-spinning'), 1200);

        // Arpegio de amor
        playChime(523.25, 0);   // C5
        playChime(659.25, 120); // E5
        playChime(783.99, 240); // G5
        playChime(1046.50, 380); // C6

        showDedicationToast('👑 «Sello de Amor grabado en oro para Carla Lorena.» ❦');
        triggerRoseShower(12, waxSeal.getBoundingClientRect());
    });

    // 3. Botones de acción del Pergamino
    const copyBtn = document.getElementById('btn-copy-dedication-letter');
    copyBtn?.addEventListener('click', () => {
        const letterText = `Para Carla Lorena · Eternamente:\n\n«A la persona que ilumina cada uno de mis días»\n\nLorena, construir este jardín es la forma más pura que encontré para plasmar en el mundo digital todo lo que despiertas en mí: amor, pasión, confianza, ternura y sobre todo sinceridad y una alegría que renueva cada instante.\n\nHay presencias que simplemente hacen que la vida sea más hermosa. Tu forma de ver el mundo, tu carácter noble y dulce, la sencillez de tu personalidad y la manera mágica en la que me enamoraste hacen que todo a tu alrededor florezca con una luz única.\n\n«Si el mundo a veces va demasiado deprisa, deseo que este pequeño jardín sea siempre tu refugio: un lugar donde recuerdes tu infinito valor y sepas que siempre hay alguien que piensa en ti con el más tierno, leal y profundo de los cariños.»\n\nCon todo mi amor y cariño para mi vida, la mujer que amo:\nTu Ingeniero Julio Adrián`;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(letterText)
                .then(() => {
                    playChime(880.00, 0, 0.6);
                    showDedicationToast('📋 «Dedicatoria guardada en tu portapapeles con todo mi amor.» 💌');
                })
                .catch(() => {
                    showDedicationToast('💌 «Dedicatoria lista en tu corazón, Carla.»');
                });
        } else {
            showDedicationToast('💌 «Guardado en tu corazón, Carla Lorena.»');
        }
    });

    // Activar modo luz de velas
    function toggleCandlelight() {
        if (typeof window.toggleGardenCandlelight === 'function') {
            window.toggleGardenCandlelight();
            return;
        }
        const overlay = document.getElementById('candlelight-reading-overlay');
        if (overlay) {
            const isActive = overlay.classList.contains('is-active');
            if (isActive) {
                overlay.classList.remove('is-active');
                document.body.classList.remove('in-candlelight-mode');
                showDedicationToast('🕯️ Luces encendidas en la Rosaleda');
            } else {
                overlay.classList.add('is-active');
                document.body.classList.add('in-candlelight-mode');
                playChime(440.00, 0);
                playChime(554.37, 150);
                playChime(659.25, 300);
                showDedicationToast('🕯️ Modo lectura íntima a la luz de velas activado');
            }
        }
    }

    document.getElementById('btn-letter-candlelight')?.addEventListener('click', toggleCandlelight);
    document.getElementById('btn-dedication-candlelight')?.addEventListener('click', toggleCandlelight);
    document.getElementById('btn-interactive-candlelight')?.addEventListener('click', toggleCandlelight);

    // Arpegio de Campanas
    function playRomanticArpeggio() {
        playChime(523.25, 0);    // C5
        playChime(659.25, 140);  // E5
        playChime(783.99, 280);  // G5
        playChime(987.77, 420);  // B5
        playChime(1046.50, 560); // C6
        showDedicationToast('🎵 Melodía de cuerdas y campanas para Carla Lorena ✨');
    }

    document.getElementById('btn-letter-audio-chime')?.addEventListener('click', playRomanticArpeggio);
    document.getElementById('btn-dedication-audio')?.addEventListener('click', playRomanticArpeggio);

    // 4. Lluvia de Rosas en ráfaga
    function triggerRoseShower(count = 28, sourceRect = null) {
        const container = document.createElement('div');
        container.className = 'dedication-particles-container';
        container.setAttribute('aria-hidden', 'true');
        document.body.appendChild(container);

        const petalsSymbols = ['🌹', '🌸', '✨', '💖', '❦', '🌷'];

        for (let i = 0; i < count; i++) {
            const p = document.createElement('span');
            p.className = 'dedication-floating-petal';
            p.textContent = petalsSymbols[Math.floor(Math.random() * petalsSymbols.length)];
            
            const startX = sourceRect 
                ? (sourceRect.left + sourceRect.width / 2 + (Math.random() - 0.5) * 160)
                : Math.random() * window.innerWidth;
            const startY = sourceRect 
                ? (sourceRect.top + sourceRect.height / 2)
                : -20;

            p.style.left = `${Math.max(10, Math.min(window.innerWidth - 30, startX))}px`;
            p.style.top = `${startY}px`;
            p.style.fontSize = `${16 + Math.random() * 18}px`;
            p.style.animationDelay = `${(Math.random() * 0.8).toFixed(2)}s`;
            p.style.animationDuration = `${(2.5 + Math.random() * 2.2).toFixed(2)}s`;

            container.appendChild(p);
        }

        setTimeout(() => {
            container.remove();
        }, 5500);
    }

    document.getElementById('btn-dedication-petals-storm')?.addEventListener('click', (e) => {
        playChime(587.33, 0);
        playChime(880.00, 180);
        showDedicationToast('🌹 «¡Una lluvia de rosas desciende en tu honor, mi reina!» ✨');
        triggerRoseShower(32);
    });

    // 5. Sellado de las 4 Promesas
    const promiseCards = screen.querySelectorAll('.pillar-card');
    const promiseToasts = {
        '1': '🌸 Promesa I sellada: Estar a tu lado en cada paso y celebrar tu vida.',
        '2': '👑 Promesa II sellada: Valorar y admirar por siempre tu maravillosa esencia.',
        '3': '🕊️ Promesa III sellada: Ser tu refugio incondicional de paz, dulzura y serenidad.',
        '4': '💍 Promesa IV sellada: Seguir construyendo juntos un futuro lleno de amor y sueños.'
    };

    promiseCards.forEach(card => {
        const touchBtn = card.querySelector('.pillar-touch-btn');
        const handleSeal = () => {
            card.classList.add('is-sealed');
            const pId = card.dataset.promise || '1';
            playChime(659.25, 0);
            playChime(783.99, 120);
            showDedicationToast(promiseToasts[pId] || '❦ Promesa grabada en el jardín');
            triggerRoseShower(8, card.getBoundingClientRect());
            setTimeout(() => card.classList.remove('is-sealed'), 2000);
        };

        touchBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            handleSeal();
        });
        card.addEventListener('click', handleSeal);
    });

    // 6. Sobres de Ocasión Desplegables
    const envelopes = screen.querySelectorAll('.dedication-letter-envelope');
    envelopes.forEach(envelope => {
        const toggleBtn = envelope.querySelector('.envelope-toggle-btn');
        const content = envelope.querySelector('.envelope-unfolded-content');

        const toggleEnvelope = () => {
            const isHidden = content.hidden;
            content.hidden = !isHidden;
            toggleBtn.setAttribute('aria-expanded', String(isHidden));
            envelope.classList.toggle('is-open', isHidden);

            const btnText = toggleBtn.querySelector('.btn-text');
            if (isHidden) {
                if (btnText) btnText.textContent = 'Cerrar carta ❦';
                playChime(523.25, 0);
                playChime(659.25, 140);
                showDedicationToast('💌 Has desatado una carta secreta de amor');
            } else {
                if (btnText) btnText.textContent = 'Abrir carta ❦';
            }
        };

        toggleBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleEnvelope();
        });

        envelope.querySelector('.envelope-header')?.addEventListener('click', toggleEnvelope);
    });

    // 7. Ofrenda de Rosas Interactiva y Contador LocalStorage
    const sparkBtn = document.getElementById('dedication-spark-btn');
    const counterEl = document.getElementById('dedication-petals-counter');
    const STORAGE_KEY = 'garden_dedication_petals_count';

    let currentPetals = parseInt(localStorage.getItem(STORAGE_KEY), 10);
    if (isNaN(currentPetals) || currentPetals < 384) {
        currentPetals = 384;
    }
    if (counterEl) {
        counterEl.textContent = currentPetals.toLocaleString();
    }

    const romanticSparkMessages = [
        '🌹 «Cada flor lleva tu nombre, Carla Lorena.» ✨',
        '💖 «Tu sonrisa es la luz que ilumina todo este jardín.»',
        '✨ «Gracias por ser la mujer más maravillosa de mi vida.»',
        '👑 «Para mi reina hermosa: un amor que jamás se marchita.»',
        '🌸 «Floreces en cada pensamiento, en cada instante.»',
        '🕊️ «En tus ojos habita toda la paz que mi alma soñó.»'
    ];

    sparkBtn?.addEventListener('click', (e) => {
        currentPetals += 1;
        if (counterEl) {
            counterEl.textContent = currentPetals.toLocaleString();
            counterEl.classList.remove('pulse-count');
            void counterEl.offsetWidth; // Forzar reflow
            counterEl.classList.add('pulse-count');
        }
        try {
            localStorage.setItem(STORAGE_KEY, currentPetals.toString());
        } catch (_) {}

        playChime(523.25, 0);
        playChime(659.25, 120);
        playChime(783.99, 240);
        playChime(1046.50, 360);

        const randomMsg = romanticSparkMessages[Math.floor(Math.random() * romanticSparkMessages.length)];
        showDedicationToast(randomMsg);

        triggerRoseShower(18, sparkBtn.getBoundingClientRect());
    });
}
