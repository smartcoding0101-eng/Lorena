/**
 * garden-ux-innovations.js
 * Las 4 Experiencias de Usuario de Vanguardia para El Jardín de Carla Lorena:
 * 1. La Brújula del Jardín (Dock Flotante Ergonómico Inferior)
 * 2. Efecto Holográfico y Giros 3D (Tilt Card & Specular Sheen Interaction)
 * 3. Modo Lectura de Cartas "Luz de Velas" (Mood Immersion & Fireflies)
 * 4. Buscador Universal Mágico (Spotlight Jardín - Ctrl+K)
 */

export function initGardenUXInnovations() {
    initGardenBottomDock();
    init3DTiltCards();
    initCandlelightReadingMode();
    initGardenSpotlightSearch();
}

/**
 * 1. LA BRÚJULA DEL JARDÍN: Dock Flotante Ergonómico Inferior
 * Accesible al pulgar con 4 destinos clave:
 * - 🌸 Inicio: Saludo dinámico, clima del día y estados de 24h
 * - 🗺️ Mapa & Rincones: Exploración libre del jardín
 * - 👨‍👩‍👧‍👦 Santuario Familiar: El espacio íntimo de Carla, Adrián, Ody y los niños
 * - 💌 Memorias & Notas: Abre el cajón lateral contextual #corner-crud-drawer
 */
function initGardenBottomDock() {
    let dock = document.getElementById('garden-compass-dock');
    if (dock) return; // Ya existe

    dock = document.createElement('nav');
    dock.id = 'garden-compass-dock';
    dock.className = 'garden-compass-dock';
    dock.setAttribute('aria-label', 'Brújula de Navegación del Jardín');
    dock.innerHTML = `
        <div class="compass-dock-glow"></div>
        <div class="compass-dock-items">
            <a href="#inicio" data-go="inicio" class="compass-dock-btn" data-dock-target="inicio" title="Inicio, Clima y Estados 24h">
                <span class="compass-dock-icon">🌸</span>
                <span class="compass-dock-label">Inicio</span>
            </a>
            <a href="#mapa" data-go="mapa" class="compass-dock-btn" data-dock-target="mapa" title="Mapa del Jardín Secreto">
                <span class="compass-dock-icon">🗺️</span>
                <span class="compass-dock-label">Mapa</span>
            </a>
            <a href="#familia" data-go="familia" class="compass-dock-btn" data-dock-target="familia" title="Santuario Familiar Privado">
                <span class="compass-dock-icon">👨‍👩‍👧‍👦</span>
                <span class="compass-dock-label">Mi Familia</span>
            </a>
            <button type="button" class="compass-dock-btn btn-dock-notes" id="compass-btn-notes" title="Abrir Notas & Memorias">
                <span class="compass-dock-icon">💌</span>
                <span class="compass-dock-label">Memorias</span>
            </button>
            <button type="button" class="compass-dock-btn btn-dock-spotlight" id="compass-btn-spotlight" title="Buscador Universal Mágico (Ctrl+K)">
                <span class="compass-dock-icon">✨</span>
                <span class="compass-dock-label">Buscar</span>
            </button>
        </div>
    `;

    document.body.appendChild(dock);

    // Eventos de botones
    const btnNotes = document.getElementById('compass-btn-notes');
    btnNotes?.addEventListener('click', (e) => {
        e.preventDefault();
        if (typeof window.openCornerNotesDrawer === 'function') {
            window.openCornerNotesDrawer();
        } else {
            const drawer = document.getElementById('corner-crud-drawer');
            if (drawer) drawer.hidden = false;
        }
    });

    const btnSpotlight = document.getElementById('compass-btn-spotlight');
    btnSpotlight?.addEventListener('click', (e) => {
        e.preventDefault();
        openGardenSpotlight();
    });

    // Actualizar clase activa del Dock según la pantalla en pantalla
    function updateActiveDockBtn() {
        const hash = window.location.hash.replace('#', '') || 'inicio';
        const buttons = dock.querySelectorAll('.compass-dock-btn[data-dock-target]');
        buttons.forEach(btn => {
            const isMatch = btn.dataset.dockTarget === hash;
            btn.classList.toggle('is-active', isMatch);
        });
    }

    window.addEventListener('hashchange', updateActiveDockBtn);
    window.addEventListener('popstate', updateActiveDockBtn);
    updateActiveDockBtn();
}

/**
 * 2. EFECTO HOLOGRÁFICO Y GIROS 3D (Tilt Card Interaction)
 * Proyecta reflejo dorado specular y calcula inclinación física al mover el puntero o dispositivo
 */
function init3DTiltCards() {
    const cardSelectors = [
        '.family-member-card',
        '.family-memory-item',
        // '.polaroid-card', // Removido: Polaroid completamente estática sin efecto tilt/balanceo
        '.space-card',
        '.game-card',
        '.corner-note-card',
        '.promenade-card',
        '.wax-letter-card'
    ];

    function applyTiltToElement(el) {
        if (el.dataset.tiltApplied) return;
        el.dataset.tiltApplied = 'true';
        el.classList.add('garden-tilt-card');

        let sheen = el.querySelector('.tilt-specular-sheen');
        if (!sheen) {
            sheen = document.createElement('div');
            sheen.className = 'tilt-specular-sheen';
            el.appendChild(sheen);
        }

        el.addEventListener('mousemove', (e) => {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -10; // Max 10 deg
            const rotateY = ((x - centerX) / centerX) * 10;
            
            el.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px)`;
            
            // Reflejo de luz dorada
            const sheenX = (x / rect.width) * 100;
            const sheenY = (y / rect.height) * 100;
            sheen.style.background = `radial-gradient(circle at ${sheenX}% ${sheenY}%, rgba(254, 240, 138, 0.45) 0%, rgba(251, 191, 36, 0.15) 40%, transparent 70%)`;
            sheen.style.opacity = '1';
        });

        el.addEventListener('mouseleave', () => {
            el.style.transform = '';
            sheen.style.opacity = '0';
        });
    }

    // Inicial y dinámico con MutationObserver
    function scanAndApply() {
        cardSelectors.forEach(selector => {
            document.querySelectorAll(selector).forEach(applyTiltToElement);
        });
    }

    scanAndApply();
    const observer = new MutationObserver(() => scanAndApply());
    observer.observe(document.body, { childList: true, subtree: true });
}

/**
 * 3. MODO LECTURA DE CARTAS "LUZ DE VELAS" (Mood Immersion & Fireflies)
 * Al abrir un poema o carta de amor, el fondo se oscurece con luz cálida,
 * emergen luciérnagas flotantes lentas y el audio se ajusta a un tono íntimo.
 */
function initCandlelightReadingMode() {
    let candlelightOverlay = document.getElementById('candlelight-reading-overlay');
    if (!candlelightOverlay) {
        candlelightOverlay = document.createElement('div');
        candlelightOverlay.id = 'candlelight-reading-overlay';
        candlelightOverlay.className = 'candlelight-reading-overlay';
        candlelightOverlay.setAttribute('aria-hidden', 'true');
        candlelightOverlay.innerHTML = `
            <div class="candlelight-flicker"></div>
            <div class="candlelight-fireflies" id="candlelight-fireflies"></div>
            <button type="button" class="candlelight-exit-btn" id="candlelight-exit-btn" title="Apagar luz de velas">🕯️ Apagar velas</button>
        `;
        document.body.appendChild(candlelightOverlay);

        document.getElementById('candlelight-exit-btn')?.addEventListener('click', () => {
            deactivateCandlelight();
        });
    }

    const firefliesContainer = document.getElementById('candlelight-fireflies');
    function generateFireflies(count = 14) {
        if (!firefliesContainer) return;
        firefliesContainer.innerHTML = '';
        for (let i = 0; i < count; i++) {
            const f = document.createElement('span');
            f.className = 'candlelight-firefly';
            f.style.left = `${Math.random() * 95}%`;
            f.style.top = `${Math.random() * 90}%`;
            f.style.animationDelay = `${(Math.random() * 5).toFixed(1)}s`;
            f.style.animationDuration = `${(4 + Math.random() * 4).toFixed(1)}s`;
            firefliesContainer.appendChild(f);
        }
    }

    function activateCandlelight() {
        candlelightOverlay.classList.add('is-active');
        generateFireflies(16);
        document.body.classList.add('in-candlelight-mode');
        
        // Sonido armónico de campanas suaves
        if (typeof window.playSoftChime === 'function' && !window.__gardenMasterAudioMuted) {
            window.playSoftChime(440.00); // A4
            setTimeout(() => window.playSoftChime(554.37), 160); // C#5
            setTimeout(() => window.playSoftChime(659.25), 320); // E5
        }
    }

    function deactivateCandlelight() {
        candlelightOverlay.classList.remove('is-active');
        document.body.classList.remove('in-candlelight-mode');
    }

    // Enganchar apertura de modales de cartas y poemas
    const mapRoseDialog = document.getElementById('map-rose-dialog');
    if (mapRoseDialog) {
        const observer = new MutationObserver(() => {
            if (mapRoseDialog.open) {
                activateCandlelight();
            } else {
                deactivateCandlelight();
            }
        });
        observer.observe(mapRoseDialog, { attributes: true, attributeFilter: ['open'] });
    }

    // Enganchar cartas con sello de lacre (.wax-letter-card)
    document.querySelectorAll('.wax-seal-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            activateCandlelight();
        });
    });

    window.activateCandlelight = activateCandlelight;
    window.deactivateCandlelight = deactivateCandlelight;
    window.toggleGardenCandlelight = () => {
        if (candlelightOverlay && candlelightOverlay.classList.contains('is-active')) {
            deactivateCandlelight();
        } else {
            activateCandlelight();
        }
    };
}

/**
 * 4. BUSCADOR UNIVERSAL MÁGICO (Spotlight Jardín - Ctrl+K)
 * Modal omnipresente con autocompletado emotivo para encontrar notas, poemas, fotos familiares y rincones.
 */
let spotlightDialog = null;

function initGardenSpotlightSearch() {
    if (document.getElementById('garden-spotlight-modal')) return;

    spotlightDialog = document.createElement('dialog');
    spotlightDialog.id = 'garden-spotlight-modal';
    spotlightDialog.className = 'garden-spotlight-modal';
    spotlightDialog.setAttribute('aria-label', 'Buscador Mágico del Jardín');

    spotlightDialog.innerHTML = `
        <div class="spotlight-card">
            <div class="spotlight-header">
                <span class="spotlight-search-icon">🔍</span>
                <input type="text" id="spotlight-input" class="spotlight-input" placeholder="Buscar en el jardín (poemas, notas, familia, rincones)..." autocomplete="off" />
                <kbd class="spotlight-kbd">ESC</kbd>
            </div>
            <div class="spotlight-quick-tags">
                <span class="spotlight-tag" data-filter="all">✨ Todo</span>
                <span class="spotlight-tag" data-filter="familia">👨‍👩‍👧‍👦 Familia</span>
                <span class="spotlight-tag" data-filter="notas">💌 Notas</span>
                <span class="spotlight-tag" data-filter="poemas">📜 Poemas</span>
                <span class="spotlight-tag" data-filter="rincones">🗺️ Rincones</span>
            </div>
            <div class="spotlight-results" id="spotlight-results-list">
                <!-- Se llena dinámicamente -->
            </div>
            <div class="spotlight-footer">
                <small>Usa ↑ ↓ para navegar · Enter para abrir · <span class="spotlight-shortcut-hint">Ctrl + K en cualquier momento</span></small>
            </div>
        </div>
    `;

    document.body.appendChild(spotlightDialog);

    const input = document.getElementById('spotlight-input');
    const resultsList = document.getElementById('spotlight-results-list');
    const tags = spotlightDialog.querySelectorAll('.spotlight-tag');

    // Base de datos de búsqueda del Jardín
    const searchDatabase = [
        { type: 'rincones', title: 'Inicio & Bienvenida', subtitle: 'Saludo de amor, flor del día y estados de 24h', icon: '🌸', action: () => navigateToScreen('inicio') },
        { type: 'rincones', title: 'Mapa del Jardín Secreto', subtitle: '12 santuarios en flor y la Gran Rosa Imperial', icon: '🗺️', action: () => navigateToScreen('mapa') },
        { type: 'familia',  title: 'Santuario Familiar Privado', subtitle: 'Carla Lorena, Adrián, Ody y nuestros hijos amados', icon: '💎', action: () => navigateToScreen('familia') },
        { type: 'notas',    title: 'Notas & Memorias', subtitle: 'Cajón flotante con recuerdos, fotos y pensamientos', icon: '💌', action: () => { window.openCornerNotesDrawer?.(); } },
        { type: 'poemas',   title: 'Carta a Mi Amada Princesa Lorena', subtitle: '«Si este mapa secreto tiene senderos de rosas...»', icon: '🌹', action: () => { document.querySelector('.luxury-heart-emblem')?.click(); } },
        { type: 'poemas',   title: 'Poema: Donde Florece Tu Mirada', subtitle: '«Dicen que el rosal florece lento, aguardando el rocío...»', icon: '📜', action: () => { document.querySelector('.luxury-heart-emblem')?.click(); } },
        { type: 'rincones', title: 'Galería de Recuerdos Polaroid', subtitle: 'Instantes mágicos y fotografías con marco vintage', icon: '📸', action: () => navigateToScreen('galeria') },
        { type: 'rincones', title: 'Cápsula del Tiempo', subtitle: 'Cartas selladas con amor para florecer en el futuro', icon: '🌷', action: () => navigateToScreen('capsula') },
        { type: 'rincones', title: 'Biblioteca de Sabiduría & Poemas', subtitle: 'Lecturas, reflexiones diarias y poemas selectos', icon: '🪷', action: () => navigateToScreen('biblioteca') },
        { type: 'rincones', title: 'Entretenimiento & Música', subtitle: 'Reproductor de canciones compartidas y vídeos favoritos', icon: '🎶', action: () => navigateToScreen('entretenimiento') },
        { type: 'rincones', title: 'Mi Diario Personal', subtitle: 'Cuaderno íntimo protegido para tus pensamientos', icon: '📖', action: () => navigateToScreen('diario') },
        { type: 'rincones', title: 'El Blog de Carla Lorena', subtitle: 'Artículos, destellos y reflexiones compartidas', icon: '🌿', action: () => navigateToScreen('blog') },
        { type: 'rincones', title: 'Juegos & Aventuras', subtitle: 'Minijuegos lúdicos, rompecabezas y retos del jardín', icon: '🎮', action: () => navigateToScreen('juegos') }
    ];

    let currentFilter = 'all';

    function renderResults(query = '') {
        const cleanQ = query.trim().toLowerCase();
        const filtered = searchDatabase.filter(item => {
            const matchesFilter = currentFilter === 'all' || item.type === currentFilter;
            const matchesQuery = !cleanQ || 
                item.title.toLowerCase().includes(cleanQ) || 
                item.subtitle.toLowerCase().includes(cleanQ) ||
                item.type.toLowerCase().includes(cleanQ);
            return matchesFilter && matchesQuery;
        });

        if (filtered.length === 0) {
            resultsList.innerHTML = `
                <div class="spotlight-empty">
                    <span>🌱</span>
                    <p>No se encontraron pétalos que coincidan con «${query}»</p>
                </div>
            `;
            return;
        }

        resultsList.innerHTML = filtered.map((item, idx) => `
            <div class="spotlight-item ${idx === 0 ? 'is-focused' : ''}" data-idx="${idx}">
                <span class="spotlight-item-icon">${item.icon}</span>
                <div class="spotlight-item-info">
                    <strong>${item.title}</strong>
                    <small>${item.subtitle}</small>
                </div>
                <span class="spotlight-item-type">${item.type}</span>
            </div>
        `).join('');

        // Eventos de clic
        resultsList.querySelectorAll('.spotlight-item').forEach((itemEl, idx) => {
            itemEl.addEventListener('click', () => {
                filtered[idx].action();
                closeGardenSpotlight();
            });
        });
    }

    input?.addEventListener('input', (e) => {
        renderResults(e.target.value);
    });

    tags.forEach(tag => {
        tag.addEventListener('click', () => {
            tags.forEach(t => t.classList.remove('is-active'));
            tag.classList.add('is-active');
            currentFilter = tag.dataset.filter;
            renderResults(input.value);
        });
    });

    // Atajos de teclado: Escape y Enter
    input?.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeGardenSpotlight();
        } else if (e.key === 'Enter') {
            const firstResult = resultsList.querySelector('.spotlight-item');
            if (firstResult) {
                firstResult.click();
            }
        }
    });

    spotlightDialog.addEventListener('click', (e) => {
        if (e.target === spotlightDialog) {
            closeGardenSpotlight();
        }
    });

    // Tecla Global Ctrl + K / Cmd + K
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (spotlightDialog.open) {
                closeGardenSpotlight();
            } else {
                openGardenSpotlight();
            }
        }
    });

    window.openGardenSpotlight = openGardenSpotlight;
    window.closeGardenSpotlight = closeGardenSpotlight;
}

function openGardenSpotlight() {
    if (!spotlightDialog) return;
    if (typeof spotlightDialog.showModal === 'function') {
        spotlightDialog.showModal();
        const input = document.getElementById('spotlight-input');
        if (input) {
            input.value = '';
            input.focus();
            // Disparar render inicial
            input.dispatchEvent(new Event('input'));
        }
    }
}

function closeGardenSpotlight() {
    if (spotlightDialog?.open) {
        spotlightDialog.close();
    }
}

function navigateToScreen(screenKey) {
    window.location.hash = `#${screenKey}`;
    const screenTarget = document.querySelector(`.screen[data-screen="${screenKey}"]`);
    if (screenTarget) {
        document.querySelectorAll('.screen').forEach(s => {
            s.classList.remove('is-active');
            s.hidden = true;
        });
        screenTarget.classList.add('is-active');
        screenTarget.hidden = false;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

