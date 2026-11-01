/**
 * Ciclo de Hover Automático para las Tarjetas de Rincones (El Jardín de Carla Lorena)
 * 
 * Requerimientos:
 * 1. En las tarjetas de la sección "Rincones que esperan por ti" (#home-space-grid .space-card),
 *    aplicar el efecto hover cada 3 segundos de manera secuencial (tarjeta 1, 2, 3... y volver a iniciar).
 * 2. Si el usuario pasa el mouse sobre alguna tarjeta, se respeta la interacción del usuario y se detiene el ciclo automático.
 * 3. Si no hay interacción con el mouse durante 3 segundos, se reanuda el ciclo automático de hover por tarjeta.
 */

export function initCardsAutoHover() {
    const grid = document.getElementById('home-space-grid') || document.querySelector('.space-grid');
    if (!grid) return;

    const CYCLE_INTERVAL_MS = 3000; // 3 segundos por tarjeta
    const RESUME_DELAY_MS = 3000;   // 3 segundos sin marcar antes de reiniciar el ciclo

    let cycleTimer = null;
    let resumeTimer = null;
    let currentIndex = -1;
    let isMouseOverAnyCard = false;

    // Obtener las tarjetas interactivas de la cuadrícula
    function getCards() {
        const rawCards = Array.from(grid.querySelectorAll('.space-card'));
        return rawCards.filter((card) => !card.hidden && card.offsetParent !== null);
    }

    // Verificar si la sección de tarjetas es visible o está en pantalla
    function isGridVisible() {
        const rect = grid.getBoundingClientRect();
        return rect.bottom > 0 && rect.top < (window.innerHeight || document.documentElement.clientHeight);
    }

    // Limpiar el efecto hover simulado en todas las tarjetas
    function clearAutoHover() {
        const cards = getCards();
        cards.forEach((card) => card.classList.remove('is-auto-hover'));
    }

    // Avanzar a la siguiente tarjeta y aplicar el hover simulado
    function stepToNextCard() {
        if (isMouseOverAnyCard || document.hidden) return;

        const cards = getCards();
        if (cards.length === 0) return;

        // Avanzar índice circularmente: 0 -> 1 -> 2 ... -> volver al inicio (0)
        currentIndex = (currentIndex + 1) % cards.length;

        cards.forEach((card, idx) => {
            if (idx === currentIndex) {
                card.classList.add('is-auto-hover');
            } else {
                card.classList.remove('is-auto-hover');
            }
        });
    }

    // Iniciar el ciclo recurrente de 3 segundos
    function startAutoCycle(immediate = true) {
        stopAutoCycle();
        if (isMouseOverAnyCard || document.hidden) return;

        if (immediate) {
            stepToNextCard();
        }

        cycleTimer = setInterval(stepToNextCard, CYCLE_INTERVAL_MS);
    }

    // Detener el ciclo automático
    function stopAutoCycle() {
        if (cycleTimer) {
            clearInterval(cycleTimer);
            cycleTimer = null;
        }
    }

    // Programar la reanudación si el usuario no pasa el mouse por 3 segundos
    function scheduleResume() {
        if (resumeTimer) {
            clearTimeout(resumeTimer);
        }

        resumeTimer = setTimeout(() => {
            if (!isMouseOverAnyCard && !document.hidden) {
                startAutoCycle(true);
            }
        }, RESUME_DELAY_MS);
    }

    // Manejador cuando el mouse entra a una tarjeta
    function handleCardEnter(e) {
        isMouseOverAnyCard = true;
        if (resumeTimer) {
            clearTimeout(resumeTimer);
            resumeTimer = null;
        }
        stopAutoCycle();
        clearAutoHover();

        const cards = getCards();
        const hoveredIdx = cards.indexOf(e.currentTarget);
        if (hoveredIdx !== -1) {
            currentIndex = hoveredIdx;
        }
    }

    // Manejador cuando el mouse sale de una tarjeta
    function handleCardLeave() {
        setTimeout(() => {
            const cards = getCards();
            const anyHovered = cards.some((card) => card.matches(':hover'));
            if (!anyHovered) {
                isMouseOverAnyCard = false;
                clearAutoHover();
                scheduleResume();
            }
        }, 40);
    }

    // Registrar eventos para cada tarjeta
    function bindCards() {
        const cards = getCards();
        cards.forEach((card) => {
            card.removeEventListener('mouseenter', handleCardEnter);
            card.removeEventListener('mouseleave', handleCardLeave);
            card.removeEventListener('focusin', handleCardEnter);
            card.removeEventListener('focusout', handleCardLeave);

            card.addEventListener('mouseenter', handleCardEnter);
            card.addEventListener('mouseleave', handleCardLeave);
            card.addEventListener('focusin', handleCardEnter);
            card.addEventListener('focusout', handleCardLeave);
        });
    }

    // Escuchar mutaciones en caso de que se agreguen/eliminen tarjetas dinámicamente
    const observer = new MutationObserver(() => {
        bindCards();
    });
    observer.observe(grid, { childList: true, subtree: false });

    // Pausar si la pestaña se oculta y reanudar al volver
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoCycle();
            clearAutoHover();
        } else {
            scheduleResume();
        }
    });

    // Iniciar
    bindCards();
    scheduleResume();
}
