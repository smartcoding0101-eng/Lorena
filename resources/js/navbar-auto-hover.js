/**
 * Ciclo de Hover Automático para el Navbar (El Jardín de Carla Lorena)
 * 
 * Requerimientos:
 * 1. En el navbar, cada 3 segundos agregar el efecto hover en cada botón secuencialmente.
 * 2. Hasta que el mouse pase por el botón y marque según el mouse (hover interactivo del usuario).
 * 3. Si no marcó ningún botón en 3 segundos, vuelve a iniciar el efecto hover en cada menú del navbar.
 */

export function initNavbarAutoHover() {
    const nav = document.getElementById('main-nav') || document.querySelector('.main-nav');
    if (!nav) return;

    const CYCLE_INTERVAL_MS = 3000; // 3 segundos por botón
    const RESUME_DELAY_MS = 3000;   // 3 segundos sin marcar antes de reiniciar el ciclo

    let cycleTimer = null;
    let resumeTimer = null;
    let currentIndex = -1;
    let isMouseOverAnyButton = false;

    // Obtener los botones/enlaces interactivos del menú
    function getNavButtons() {
        const rawButtons = Array.from(
            nav.querySelectorAll('.nav-item, .nav-passport-btn, a, button')
        );

        return rawButtons.filter((btn, idx, arr) => {
            return (
                arr.indexOf(btn) === idx &&
                !btn.hidden &&
                !btn.classList.contains('menu-toggle')
            );
        });
    }

    // Verificar si el navbar está visible en pantalla (para no ciclar si el menú móvil está cerrado)
    function isNavVisible() {
        return window.getComputedStyle(nav).display !== 'none';
    }

    // Limpiar el efecto hover simulado en todos los botones
    function clearAutoHover() {
        const buttons = getNavButtons();
        buttons.forEach((btn) => btn.classList.remove('is-auto-hover'));
    }

    // Avanza al siguiente botón y aplica el hover simulado
    function stepToNextButton() {
        if (isMouseOverAnyButton || document.hidden || !isNavVisible()) return;

        const buttons = getNavButtons();
        if (buttons.length === 0) return;

        // Avanzar índice circularmente
        currentIndex = (currentIndex + 1) % buttons.length;

        buttons.forEach((btn, idx) => {
            if (idx === currentIndex) {
                btn.classList.add('is-auto-hover');
            } else {
                btn.classList.remove('is-auto-hover');
            }
        });
    }

    // Iniciar el ciclo recurrente de 3 segundos
    function startAutoCycle(immediate = true) {
        stopAutoCycle();
        if (isMouseOverAnyButton || document.hidden || !isNavVisible()) return;

        if (immediate) {
            stepToNextButton();
        }

        cycleTimer = setInterval(stepToNextButton, CYCLE_INTERVAL_MS);
    }

    // Detener el ciclo automático
    function stopAutoCycle() {
        if (cycleTimer) {
            clearInterval(cycleTimer);
            cycleTimer = null;
        }
    }

    // Programar la reanudación si el usuario no marca ningún botón en 3 segundos
    function scheduleResume() {
        if (resumeTimer) {
            clearTimeout(resumeTimer);
        }

        resumeTimer = setTimeout(() => {
            if (!isMouseOverAnyButton && !document.hidden && isNavVisible()) {
                startAutoCycle(true);
            }
        }, RESUME_DELAY_MS);
    }

    // Manejador cuando el cursor entra a un botón del navbar
    function handleButtonEnter(e) {
        isMouseOverAnyButton = true;
        if (resumeTimer) {
            clearTimeout(resumeTimer);
            resumeTimer = null;
        }
        stopAutoCycle();
        clearAutoHover();

        // Actualizar el índice al botón actual sobre el que pasó el mouse
        const buttons = getNavButtons();
        const hoveredIdx = buttons.indexOf(e.currentTarget);
        if (hoveredIdx !== -1) {
            currentIndex = hoveredIdx;
        }
    }

    // Manejador cuando el cursor sale de un botón del navbar
    function handleButtonLeave() {
        // Verificar si el cursor pasó inmediatamente a otro botón del navbar
        setTimeout(() => {
            const buttons = getNavButtons();
            const anyHovered = buttons.some((btn) => btn.matches(':hover'));
            if (!anyHovered) {
                isMouseOverAnyButton = false;
                clearAutoHover();
                scheduleResume();
            }
        }, 30);
    }

    // Registrar eventos para cada botón del navbar
    function bindNavButtons() {
        const buttons = getNavButtons();
        buttons.forEach((btn) => {
            btn.addEventListener('mouseenter', handleButtonEnter);
            btn.addEventListener('mouseleave', handleButtonLeave);
            btn.addEventListener('focus', handleButtonEnter);
            btn.addEventListener('blur', handleButtonLeave);
            btn.addEventListener('click', (e) => {
                handleButtonEnter(e);
                // Si el usuario hace clic, volver a programar si quita el mouse
                setTimeout(handleButtonLeave, 300);
            });
        });
    }

    bindNavButtons();

    // Detección de visibilidad de pestaña
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoCycle();
            if (resumeTimer) clearTimeout(resumeTimer);
            clearAutoHover();
        } else {
            if (!isMouseOverAnyButton) {
                scheduleResume();
            }
        }
    });

    // Comprobar si al inicio el mouse ya está sobre algún botón
    const buttons = getNavButtons();
    const initiallyHovered = buttons.some((btn) => btn.matches(':hover'));
    if (initiallyHovered) {
        isMouseOverAnyButton = true;
    } else {
        // Iniciar el temporizador inicial de 3 segundos para arrancar el ciclo
        scheduleResume();
    }
}
