/**
 * games-hub.js
 * Experiencias & Juegos que hacen sonreír — El Jardín de Carla Lorena
 * 
 * Funcionalidades:
 * 1. Filtrado dinámico por categorías de juegos (Trivias, Calma, Reto Visual, Aventuras).
 * 2. Selector "Experiencia al azar" con animación y toast poético.
 * 3. Celebración al completar el minijuego de memoria.
 * 4. Integración fluida con el sistema de navegación del Atelier.
 */

export function initGamesHub() {
    initGameCategoryFilters();
    initRandomGameButton();
    initMemoryVictoryObserver();
}

/**
 * 1. Filtrado por categorías con animación fluida
 */
function initGameCategoryFilters() {
    const filterButtons = document.querySelectorAll('[data-game-filter]');
    const gameCards = document.querySelectorAll('[data-game-card]');
    const emptyState = document.getElementById('games-filter-empty');
    const resetBtn = document.getElementById('btn-reset-game-filter');
    const statusText = document.querySelector('#games-filter-status .gallery-caption');

    if (!filterButtons.length || !gameCards.length) return;

    const categoryNames = {
        todos: 'Todas las experiencias (8)',
        retos: 'Trivias & Retos íntimos',
        calma: 'Calma, elecciones & bienestar',
        visual: 'Retos visuales y botánica',
        aventuras: 'Aventuras narrativas & 3D de Sultana'
    };

    function applyFilter(category) {
        // Actualizar estado visual de los chips de filtro
        filterButtons.forEach(btn => {
            const isMatch = btn.dataset.gameFilter === category;
            btn.classList.toggle('is-selected', isMatch);
            btn.setAttribute('aria-pressed', String(isMatch));
        });

        let visibleCount = 0;

        gameCards.forEach((card, index) => {
            const cardCategory = card.dataset.gameCategory || '';
            const matches = category === 'todos' || cardCategory === category;

            if (matches) {
                card.hidden = false;
                card.style.display = 'flex';
                card.style.opacity = '0';
                card.style.transform = 'translateY(12px)';
                visibleCount++;

                // Efecto cascada de aparición sutil
                setTimeout(() => {
                    card.style.transition = 'opacity 0.35s ease, transform 0.35s cubic-bezier(0.16, 1, 0.3, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 30 * index);
            } else {
                card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                card.style.opacity = '0';
                card.style.transform = 'translateY(8px)';
                setTimeout(() => {
                    card.hidden = true;
                    card.style.display = 'none';
                }, 200);
            }
        });

        // Mostrar / ocultar mensaje de categoría vacía
        if (emptyState) {
            emptyState.hidden = visibleCount > 0;
            emptyState.style.display = visibleCount > 0 ? 'none' : 'block';
        }

        // Actualizar leyenda de estado
        if (statusText) {
            const catLabel = categoryNames[category] || 'Colección Privada';
            statusText.textContent = `${catLabel.toUpperCase()} · ${visibleCount} EXPERIENCIA${visibleCount === 1 ? '' : 'S'} DISPONIBLE${visibleCount === 1 ? '' : 'S'}`;
        }
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.dataset.gameFilter || 'todos';
            applyFilter(cat);
        });
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            applyFilter('todos');
        });
    }
}

/**
 * 2. Botón "Experiencia al azar"
 */
function initRandomGameButton() {
    const randomBtn = document.getElementById('btn-random-game');
    if (!randomBtn) return;

    randomBtn.addEventListener('click', () => {
        const gameCards = Array.from(document.querySelectorAll('[data-game-card]')).filter(c => !c.hidden && c.offsetParent !== null);
        if (!gameCards.length) return;

        // Seleccionar tarjeta aleatoria
        const randomIndex = Math.floor(Math.random() * gameCards.length);
        const selectedCard = gameCards[randomIndex];
        const title = selectedCard.querySelector('.game-card-title')?.textContent?.trim() || 'experiencia especial';
        const targetScreen = selectedCard.getAttribute('data-go') || selectedCard.getAttribute('href')?.replace('#', '');

        // Animación visual de destello sobre la tarjeta
        selectedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        selectedCard.classList.add('is-random-highlight');

        // Mostrar notificación elegante en pantalla
        const toast = document.querySelector('.toast');
        if (toast) {
            toast.textContent = `🎲 ¡El jardín eligió para ti: "${title}"! Abriendo...`;
            toast.hidden = false;
            toast.classList.add('is-visible');
            setTimeout(() => {
                toast.classList.remove('is-visible');
                toast.hidden = true;
            }, 3500);
        }

        // Navegar a la pantalla después del destello
        setTimeout(() => {
            selectedCard.classList.remove('is-random-highlight');
            if (targetScreen) {
                window.location.hash = targetScreen;
            }
        }, 800);
    });
}

/**
 * 3. Observador de victoria en el juego de memoria
 */
function initMemoryVictoryObserver() {
    const pairsEl = document.querySelector('[data-memory-pairs]');
    const messageEl = document.querySelector('[data-memory-message]');
    const panel = document.querySelector('.atelier-memory-panel');
    if (!pairsEl || !panel) return;

    const observer = new MutationObserver(() => {
        const text = pairsEl.textContent || '';
        if (text.includes('6 / 6')) {
            panel.classList.add('is-victory-glow');

            // Disparar pequeño festejo si no existe ya
            let banner = document.getElementById('memory-victory-banner');
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'memory-victory-banner';
                banner.className = 'memory-victory-banner';
                banner.innerHTML = `
                    <span class="victory-icon">🌸 ❦ 🌹</span>
                    <h4>¡Armonía Perfecta Encontrada!</h4>
                    <p>Has emparejado cada flor del jardín botánico. Que este instante llene tu corazón de serenidad.</p>
                `;
                panel.appendChild(banner);
            }

            setTimeout(() => {
                panel.classList.remove('is-victory-glow');
            }, 8000);
        }
    });

    observer.observe(pairsEl, { childList: true, characterData: true, subtree: true });
}
