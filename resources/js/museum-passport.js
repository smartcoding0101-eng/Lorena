/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  EL JARDÍN DE CARLA LORENA · EXPERIENCIAS UX DE ÉLITE
 *  1. Modo Museo Cinematográfico de la Galería (Lightbox Bellas Artes)
 *  2. Pasaporte del Jardín Secreto (Bitácora de Sellos y Logros)
 * ═══════════════════════════════════════════════════════════════════════════
 */

// Sintetizador sutil de audio para sensaciones táctiles y poéticas
export function playChimeNote(frequency = 659.25, duration = 1.0) {
    if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
    try {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;
        const ctx = new AudioCtx();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();

        osc.type = 'sine';
        osc.frequency.setValueAtTime(frequency, ctx.currentTime);
        gain.gain.setValueAtTime(0.0001, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.05, ctx.currentTime + 0.04);
        gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + duration);

        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + duration);
    } catch (_) {}
}

function displayToast(msg) {
    const toast = document.querySelector('.toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('is-visible');
    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 3800);
}

/* ═══════════════════════════════════════════════════════════════════════════
   1. MODO MUSEO CINEMATOGRÁFICO
   ═══════════════════════════════════════════════════════════════════════════ */
let currentMuseumIndex = 0;
let museumItems = [];

export function getMuseumItems() {
    return Array.from(document.querySelectorAll('.gallery-grid .gallery-item:not([hidden])'));
}

export function openMuseumLightbox(itemOrIndex) {
    museumItems = getMuseumItems();
    if (museumItems.length === 0) return;

    if (typeof itemOrIndex === 'number') {
        currentMuseumIndex = Math.max(0, Math.min(itemOrIndex, museumItems.length - 1));
    } else {
        const idx = museumItems.indexOf(itemOrIndex);
        currentMuseumIndex = idx >= 0 ? idx : 0;
    }

    renderMuseumSlide(currentMuseumIndex, false);

    const museumDialog = document.getElementById('museum-lightbox');
    if (museumDialog instanceof HTMLDialogElement && !museumDialog.open) {
        museumDialog.showModal();
        playChimeNote(659.25, 0.8);
        setTimeout(() => playChimeNote(783.99, 1.2), 140);
    }
}

export function renderMuseumSlide(index, playChime = true) {
    if (!museumItems || museumItems.length === 0) {
        museumItems = getMuseumItems();
    }
    if (index < 0 || index >= museumItems.length) return;

    const item = museumItems[index];
    const imgEl = item.querySelector('img');
    const title = item.dataset.title || item.querySelector('.gallery-caption-header strong')?.textContent || 'Momento Mágico';
    const imgSrc = item.dataset.image || imgEl?.src || '';
    const imgAlt = imgEl?.alt || title;
    const badgeText = item.querySelector('.card-number')?.textContent || 'FOTOGRAFÍA BOTÁNICA';
    const pillText = item.querySelector('.gallery-pill')?.textContent || 'Colección Carla';
    const quoteText = item.querySelector('.gallery-caption-quote')?.textContent || '«Para recordarte lo bonito que es florecer despacio y a tu propio ritmo.»';

    const museumDialog = document.getElementById('museum-lightbox');
    if (!museumDialog) return;

    const activeImg = document.getElementById('museum-active-img');
    const badgeEl = document.getElementById('museum-badge');
    const counterEl = document.getElementById('museum-counter');
    const titleEl = document.getElementById('museum-title');
    const pillEl = document.getElementById('museum-collection-pill');
    const quoteEl = document.getElementById('museum-quote');
    const photoFrame = document.getElementById('museum-photo-frame');

    if (activeImg) {
        activeImg.style.opacity = '0';
        activeImg.style.transform = 'scale(0.96)';
        setTimeout(() => {
            activeImg.src = imgSrc;
            activeImg.alt = imgAlt;
            activeImg.style.opacity = '1';
            activeImg.style.transform = 'scale(1)';
        }, 120);
    }

    if (badgeEl) badgeEl.textContent = badgeText;
    if (counterEl) counterEl.textContent = `Obra ${index + 1} de ${museumItems.length}`;
    if (titleEl) titleEl.textContent = title;
    if (pillEl) pillEl.textContent = pillText;
    if (quoteEl) quoteEl.textContent = quoteText;

    // Reset de zoom
    photoFrame?.classList.remove('is-zoomed');
    const zoomIcon = document.getElementById('museum-zoom-icon');
    if (zoomIcon) zoomIcon.textContent = '🔍';

    if (playChime) {
        const notes = [523.25, 587.33, 659.25, 698.46, 783.99, 880.00];
        playChimeNote(notes[index % notes.length], 0.9);
    }
}

export function navigateMuseum(direction) {
    if (!museumItems || museumItems.length === 0) {
        museumItems = getMuseumItems();
    }
    if (museumItems.length === 0) return;
    currentMuseumIndex = (currentMuseumIndex + direction + museumItems.length) % museumItems.length;
    renderMuseumSlide(currentMuseumIndex, true);
}

export function initMuseumLightbox() {
    const prevBtn = document.getElementById('museum-prev-btn');
    const nextBtn = document.getElementById('museum-next-btn');
    const zoomBtn = document.getElementById('museum-zoom-btn');
    const copyBtn = document.getElementById('museum-quote-copy-btn');
    const photoFrame = document.getElementById('museum-photo-frame');
    const activeImg = document.getElementById('museum-active-img');
    const museumDialog = document.getElementById('museum-lightbox');

    prevBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        navigateMuseum(-1);
    });

    nextBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        navigateMuseum(1);
    });

    const toggleZoom = (e) => {
        e?.stopPropagation();
        if (!photoFrame) return;
        const isZoomed = photoFrame.classList.toggle('is-zoomed');
        const zoomIcon = document.getElementById('museum-zoom-icon');
        if (zoomIcon) zoomIcon.textContent = isZoomed ? '🔎' : '🔍';
        playChimeNote(isZoomed ? 783.99 : 523.25, 0.6);
    };

    zoomBtn?.addEventListener('click', toggleZoom);
    activeImg?.addEventListener('click', toggleZoom);

    copyBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const quoteEl = document.getElementById('museum-quote');
        const titleEl = document.getElementById('museum-title');
        const textToCopy = quoteEl ? `${quoteEl.textContent} — "${titleEl?.textContent || 'Carla Lorena'}"` : '';
        if (navigator.clipboard && textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                displayToast('✨ Pensamiento copiado con cariño al portapapeles');
                playChimeNote(880.00, 0.8);
            }).catch(() => {
                displayToast('✨ Cita seleccionada');
            });
        }
    });

    // Atajos de teclado en el Modo Museo
    window.addEventListener('keydown', (e) => {
        if (!museumDialog || !museumDialog.open) return;
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            navigateMuseum(-1);
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            navigateMuseum(1);
        } else if (e.key === 'z' || e.key === 'Z') {
            toggleZoom();
        }
    });

    // Soporte para gestos táctiles (Swipe)
    let touchStartX = 0;
    museumDialog?.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    museumDialog?.addEventListener('touchend', (e) => {
        const touchEndX = e.changedTouches[0].screenX;
        const diffX = touchEndX - touchStartX;
        if (Math.abs(diffX) > 45) {
            if (diffX < 0) {
                navigateMuseum(1);
            } else {
                navigateMuseum(-1);
            }
        }
    }, { passive: true });
}

/* ═══════════════════════════════════════════════════════════════════════════
   2. PASAPORTE DEL JARDÍN SECRETO (BITÁCORA DE SELLOS)
   ═══════════════════════════════════════════════════════════════════════════ */
export const GARDEN_STAMPS_CATALOG = [
    {
        id: 'inicio',
        title: 'Umbral del Jardín',
        icon: '🏡',
        subtitle: 'Donde florece el amor',
        screenId: 'inicio',
        dedication: '«Bienvenida a tu refugio, Carla Lorena. Aquí cada brisa susurra tu nombre y cada sendero fue trazado para recordarte lo infinitamente amada que eres.»',
        flower: 'Rosa Damascena de Amor Eterno 🌹',
        gem: 'Rubí Carmesí de Pasión Serena 💎',
        melody: 'Arpegio Celestial de Bienvenida (C5 - 523Hz)',
        virtue: 'Ternura Infinita y Luz Vital ✨',
        memoryQuote: '«El amor no se busca, se reconoce en el brillo de tus ojos cuando sonríes.»',
        secretPerk: 'Portal Maestro · Desbloquea el acceso a todas las rutas secretas',
        frequency: 523.25,
        badgeGradient: 'linear-gradient(135deg, #f43f5e 0%, #be123c 100%)'
    },
    {
        id: 'mapa',
        title: 'Sendero Secreto',
        icon: '🗺️',
        subtitle: 'La guía de los rincones',
        screenId: 'mapa',
        dedication: '«Un mapa que no mide distancias en kilómetros, sino en latidos y momentos hermosos compartidos contigo, Carla. Camina sin prisa, este jardín te pertenece.»',
        flower: 'Jazmín Blanco de Medianoche 🌼',
        gem: 'Zafiro Estrella Guía 🌟',
        melody: 'Campanillas de la Brisa Guía (D5 - 587Hz)',
        virtue: 'Curiosidad Noble y Esperanza Radiante 🧭',
        memoryQuote: '«No hay camino largo cuando el destino es contemplar tu paz interior.»',
        secretPerk: 'Brújula Astral · Ilumina los atajos poéticos de este universo',
        frequency: 587.33,
        badgeGradient: 'linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%)'
    },
    {
        id: 'jardin',
        title: 'Jardín Botánico',
        icon: '🌸',
        subtitle: 'Rosas y camelias vivas',
        screenId: 'jardin',
        dedication: '«Cada pétalo que florece en este santuario busca imitar tu delicadeza y fortaleza. Eres el alma viviente que hace cantar a la tierra, Carla Lorena.»',
        flower: 'Camelia Rosa Silvestre de Montaña 🌺',
        gem: 'Esmeralda de Rocío Matutino 🌿',
        melody: 'Sonata Floral en Sol Mayor (E5 - 659Hz)',
        virtue: 'Gracia Natural y Belleza Serena 🌷',
        memoryQuote: '«Florecer no es abrirse de prisa, es tener la paciencia de un capullo que sabe que su fragancia es para siempre.»',
        secretPerk: 'Rocío Eterno · Otorga vida perpetua a las flores que toques con amor',
        frequency: 659.25,
        badgeGradient: 'linear-gradient(135deg, #ec4899 0%, #be185d 100%)'
    },
    {
        id: 'galeria',
        title: 'Salón de Arte',
        icon: '🖼️',
        subtitle: 'Momentos y cuadros mágicos',
        screenId: 'galeria',
        dedication: '«Tus fotografías y recuerdos son más valiosos que cualquier lienzo del Louvre. Carla Lorena, tu sonrisa es la obra de arte más perfecta jamás contemplada.»',
        flower: 'Lirio Real de los Valles 🪻',
        gem: 'Ópalo de Mil Destellos 🎨',
        melody: 'Melodía de Acuarela Pura (F5 - 698Hz)',
        virtue: 'Sensibilidad Exquisita y Magia Visual 👁️',
        memoryQuote: '«Una fotografía guarda un instante, pero tu esencia guarda un universo entero de luz.»',
        secretPerk: 'Modo Museo Velvet · Activa el marco dorado en tus cuadros favoritos',
        frequency: 698.46,
        badgeGradient: 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)'
    },
    {
        id: 'biblioteca',
        title: 'Rincón de Lectura',
        icon: '📖',
        subtitle: 'Refugio de versos y calma',
        screenId: 'biblioteca',
        dedication: '«Entre páginas antiguas y susurros de papel, encontré que todos los grandes poetas se quedaron cortos al intentar describir lo que tu presencia provoca.»',
        flower: 'Lavanda Relajante de la Provenza 🪻',
        gem: 'Amatista de Serenidad Profunda 💜',
        melody: 'Acorde de Arpa Antigua (G5 - 783Hz)',
        virtue: 'Sabiduría Calma y Nobleza de Pensamiento 📜',
        memoryQuote: '«Hay libros que te transportan a otro mundo, pero tú eres el mundo al que siempre quiero regresar.»',
        secretPerk: 'Tinta Dorada · Te permite guardar fragmentos poéticos en tu bitácora',
        frequency: 783.99,
        badgeGradient: 'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)'
    },
    {
        id: 'dedicatoria',
        title: 'Carta del Corazón',
        icon: '💌',
        subtitle: 'Palabras sinceras de amor',
        screenId: 'dedicatoria',
        dedication: '«Escrita con tinta indeleble desde lo más puro del alma para ti, Carla Lorena. Eres mi certeza más hermosa y mi regalo más grande en esta vida.»',
        flower: 'Orquídea Blanca de Devoción Pura 🤍',
        gem: 'Cuarzo Rosa del Afecto Inmortal 💖',
        melody: 'Cuerdas Románticas en Do Mayor (A5 - 880Hz)',
        virtue: 'Amor Incondicional y Lealtad Trascendente 🕊️',
        memoryQuote: '«Amarte es la decisión más fácil, hermosa y luminosa que he tomado jamás.»',
        secretPerk: 'Lacre Sellado · Envuelve tus sentimientos en una promesa inquebrantable',
        frequency: 880.00,
        badgeGradient: 'linear-gradient(135deg, #f43f5e 0%, #e11d48 100%)'
    },
    {
        id: 'amigos',
        title: 'Dedicatorias de Amigos',
        icon: '🌸',
        subtitle: 'Voces y cariño de amigos',
        screenId: 'amigos',
        dedication: '«El eco de todos los que te admiran y quieren verte florecer siempre. Tienes el don especial de dejar una huella dulce en cada vida que tocas, Carla.»',
        flower: 'Girasol de Gratitud y Amistad 🌻',
        gem: 'Citrino de Alegría Compartida ☀️',
        melody: 'Armonía Dulce de Comunidad (B5 - 987Hz)',
        virtue: 'Generosidad Cálida y Simpatía Genuina 🤝',
        memoryQuote: '«Quien tiene un alma bonita como la tuya, nunca camina en soledad.»',
        secretPerk: 'Muro del Afecto · Multiplica las notas y mensajes de buenos deseos',
        frequency: 987.77,
        badgeGradient: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)'
    },
    {
        id: 'capsula',
        title: 'Cápsula del Tiempo',
        icon: '⏳',
        subtitle: 'Mensajes para el mañana',
        screenId: 'capsula',
        dedication: '«Guardamos aquí secretos, risas y anhelos que madurarán como el mejor vino. Que el futuro te encuentre siempre tan radiante y plena como hoy, Carla Lorena.»',
        flower: 'Flor de Loto de la Trascendencia 🪷',
        gem: 'Cristal de Roca Temporal 💎',
        melody: 'Eco de Campana del Futuro (C6 - 1046Hz)',
        virtue: 'Visión Soñadora y Fidelidad al Tiempo 🕰️',
        memoryQuote: '«Los mejores días de tu vida aún están aguardando por florecer frente a ti.»',
        secretPerk: 'Reloj de Arena Mágico · Detiene el tiempo en los momentos más bellos',
        frequency: 1046.50,
        badgeGradient: 'linear-gradient(135deg, #10b981 0%, #047857 100%)'
    },
    {
        id: 'aventura-sultana',
        title: 'Sultana la Guardiana',
        icon: '🐾',
        subtitle: 'Pasitos fieles de alegría',
        screenId: 'aventura-sultana',
        dedication: '«Con su corazón noble y saltitos incansables, Sultana custodia este rincón para arrancarte una sonrisa en tus días más grises. Te adora con fidelidad pura, Carla.»',
        flower: 'Margaritas Silvestres del Prado 🌼',
        gem: 'Ámbar Dorado de Alegría Pura 🐕',
        melody: 'Sonata Alegre de Cascabeles (D6 - 1174Hz)',
        virtue: 'Lealtad Incondicional y Ternura Juguetona 🐾',
        memoryQuote: '«La felicidad más sincera cabe en el movimiento de una colita llena de amor.»',
        secretPerk: 'Patitas Mágicas · Desbloquea recompensas especiales al acariciarla',
        frequency: 1174.66,
        badgeGradient: 'linear-gradient(135deg, #f97316 0%, #ea580c 100%)'
    },
    {
        id: 'rompecabezas',
        title: 'Rompecabezas Floral',
        icon: '🧩',
        subtitle: 'Uniendo cada fragmento',
        screenId: 'rompecabezas',
        dedication: '«Como cada pieza que encuentra su lugar perfecto, así cada detalle de tu personalidad encaja en una armonía sublime. Eres el cuadro terminado más hermoso.»',
        flower: 'Dalia Multicolor de la Ingeniosidad 🌸',
        gem: 'Turquesa de la Claridad Mental 💠',
        melody: 'Clavecin de Precisión y Paz (E6 - 1318Hz)',
        virtue: 'Paciencia Dulce y Determinación Brillante 🧩',
        memoryQuote: '«Incluso cuando todo parece fragmentado, el amor sabe unir cada pieza en perfecta sintonía.»',
        secretPerk: 'Ensamble Perfecto · Otorga destellos guiados en retos lúdicos',
        frequency: 1318.51,
        badgeGradient: 'linear-gradient(135deg, #14b8a6 0%, #0f766e 100%)'
    },
    {
        id: 'tesoro',
        title: 'Cofre del Tesoro',
        icon: '✨',
        subtitle: 'Secretos dorados',
        screenId: 'tesoro',
        dedication: '«El verdadero tesoro jamás estuvo enterrado en monedas de oro; el mayor tesoro es tenerte en nuestras vidas, Carla Lorena, alumbrando cada día con tu bondad.»',
        flower: 'Rosa de Oro Mística 🏵️',
        gem: 'Topacio Dorado Imperial 👑',
        melody: 'Resonancia de Cofre Encantado (F6 - 1396Hz)',
        virtue: 'Alma Luminosa y Generosidad Radiante 🪙',
        memoryQuote: '«El brillo de tus ojos vale más que todas las coronas del mundo.»',
        secretPerk: 'Aura Dorada · Derrama partículas de polvo estelar al caminar',
        frequency: 1396.91,
        badgeGradient: 'linear-gradient(135deg, #eab308 0%, #ca8a04 100%)'
    },
    {
        id: 'carla',
        title: 'Espacio Íntimo',
        icon: '♡',
        subtitle: 'El rincón personal de Carla',
        screenId: 'carla',
        dedication: '«Un santuario sagrado solo para ti. Respira profundo, descalza tus pensamientos y siente el cobijo de este jardín que late al unísono de tu corazón, Carla Lorena.»',
        flower: 'Magnolia de Paz Absoluta 🤍',
        gem: 'Diamante Rosa del Espíritu 🌸',
        melody: 'Lamento Dulce de Violín y Campanillas (G6 - 1567Hz)',
        virtue: 'Paz Interior, Soberanía y Dignidad 🕊️',
        memoryQuote: '«Eres tu propio hogar, y este jardín secreto es tu palacio de sosiego.»',
        secretPerk: 'Escudo de Serenidad · Disipa toda fatiga y estrés del día a día',
        frequency: 1567.98,
        badgeGradient: 'linear-gradient(135deg, #f43f5e 0%, #881337 100%)'
    },
    {
        id: 'albumes',
        title: 'Álbumes de Recuerdos',
        icon: '📸',
        subtitle: 'Memorias fotográficas',
        screenId: 'albumes',
        dedication: '«Cada instante a tu lado merece ser guardado en encuadernaciones de terciopelo. Carla Lorena, gracias por existir y regalar tantas memorias inolvidables.»',
        flower: 'Peonía Rosada de la Fortuna 🌺',
        gem: 'Aguamarina de Claridad Emocional 🌊',
        melody: 'Chime de Fotograma Celestial (A6 - 1760Hz)',
        virtue: 'Gratitud Eterna y Memorias Invaluables 📷',
        memoryQuote: '«El tiempo pasa en el reloj, pero en tu corazón los momentos amados nunca envejecen.»',
        secretPerk: 'Enfoque Mágico · Resalta la iluminación de cada captura de vida',
        frequency: 1760.00,
        badgeGradient: 'linear-gradient(135deg, #d946ef 0%, #a21caf 100%)'
    }
];

export function getPassportData() {
    try {
        const raw = localStorage.getItem('carla_garden_passport');
        return raw ? JSON.parse(raw) : { stamps: ['inicio'], unlockedAt: {} };
    } catch (_) {
        return { stamps: ['inicio'], unlockedAt: {} };
    }
}

export function savePassportData(data) {
    try {
        localStorage.setItem('carla_garden_passport', JSON.stringify(data));
    } catch (_) {}
}

export function registerPassportStamp(screenId) {
    const known = GARDEN_STAMPS_CATALOG.find(s => s.id === screenId);
    if (!known) return;

    const passport = getPassportData();
    if (!passport.stamps.includes(screenId)) {
        passport.stamps.push(screenId);
        passport.unlockedAt[screenId] = new Date().toLocaleDateString('es-ES', { month: 'short', day: 'numeric' });
        savePassportData(passport);

        // Feedback sensorial y poético
        playChimeNote(known.frequency || 587.33, 0.7);
        setTimeout(() => playChimeNote(880.00, 1.2), 160);

        displayToast(`✨ ¡Nuevo sello en tu Pasaporte: ${known.title}! ⚜️`);
    }
    updatePassportUI();
}

// ── EXPEDICIÓN DE DETALLE: 10 VARIABLES DEDICADAS A CARLA LORENA ────────────
export function openPassportDetail(stampId) {
    const stamp = GARDEN_STAMPS_CATALOG.find(s => s.id === stampId);
    if (!stamp) return;

    const passport = getPassportData();
    const isUnlocked = passport.stamps.includes(stamp.id);
    const dateStr = passport.unlockedAt[stamp.id] || 'Descubierto en tu viaje';

    const detailDialog = document.getElementById('passport-detail-dialog');
    const detailCard = document.getElementById('passport-detail-card');
    if (!detailDialog || !detailCard) return;

    // Disparar sonido personalizado de la estación
    playChimeNote(stamp.frequency, 0.9);
    setTimeout(() => playChimeNote(stamp.frequency * 1.25, 0.6), 120);

    // Renderizado de las 10 Variables Dedicadas a Carla Lorena
    detailCard.innerHTML = `
        <header class="pdetail-header">
            <div class="pdetail-badge-emblem" style="background: ${stamp.badgeGradient}">
                <span class="pdetail-icon">${stamp.icon}</span>
                ${isUnlocked ? '<span class="pdetail-verified">✓</span>' : '<span class="pdetail-locked">🔒</span>'}
            </div>
            <div class="pdetail-header-info">
                <span class="pdetail-tag">HOJA DEL PASAPORTE REAL · SELLO N° ${GARDEN_STAMPS_CATALOG.indexOf(stamp) + 1}</span>
                <h3 class="pdetail-title">${stamp.title}</h3>
                <p class="pdetail-status ${isUnlocked ? 'is-unlocked' : 'is-locked'}">
                    ${isUnlocked ? `✦ Sello Descubierto · Registrado el ${dateStr}` : `✦ Rincón por explorar en el jardín secreto`}
                </p>
            </div>
            <button type="button" class="pdetail-close-btn" id="btn-close-pdetail" aria-label="Cerrar detalle">✕</button>
        </header>

        <!-- 1. DEDICATORIA PRINCIPAL ÍNTIMA -->
        <div class="pdetail-dedication-box">
            <span class="pdetail-quote-mark">“</span>
            <p class="pdetail-dedication-text">${stamp.dedication}</p>
            <span class="pdetail-for">Dedicado con todo el amor a Carla Lorena</span>
        </div>

        <!-- 2 AL 9: GRID DE DIMENSIONES Y DETALLES POÉTICOS -->
        <div class="pdetail-grid">
            <div class="pdetail-cell">
                <span class="pcell-icon">🌺</span>
                <div class="pcell-body">
                    <strong>Flor Emblema</strong>
                    <p>${stamp.flower}</p>
                </div>
            </div>

            <div class="pdetail-cell">
                <span class="pcell-icon">💎</span>
                <div class="pcell-body">
                    <strong>Gema & Destello</strong>
                    <p>${stamp.gem}</p>
                </div>
            </div>

            <div class="pdetail-cell">
                <span class="pcell-icon">🎶</span>
                <div class="pcell-body">
                    <strong>Armonía Musical</strong>
                    <p>${stamp.melody}</p>
                </div>
            </div>

            <div class="pdetail-cell">
                <span class="pcell-icon">🕊️</span>
                <div class="pcell-body">
                    <strong>Virtud Inspirada</strong>
                    <p>${stamp.virtue}</p>
                </div>
            </div>

            <div class="pdetail-cell pdetail-cell-wide">
                <span class="pcell-icon">📜</span>
                <div class="pcell-body">
                    <strong>Pensamiento para el Alma</strong>
                    <p class="pcell-italic">${stamp.memoryQuote}</p>
                </div>
            </div>

            <div class="pdetail-cell pdetail-cell-wide">
                <span class="pcell-icon">✨</span>
                <div class="pcell-body">
                    <strong>Privilegio Mágico del Rincón</strong>
                    <p>${stamp.secretPerk}</p>
                </div>
            </div>
        </div>

        <!-- 10. ACCIONES Y BOTÓN DE TELETRANSPORTE -->
        <footer class="pdetail-footer">
            <button type="button" class="pdetail-action-btn pdetail-btn-go" id="btn-pdetail-teleport" data-screen="${stamp.screenId}">
                <span>🚀 Explorar este Rincón Ahora</span>
            </button>
            <button type="button" class="pdetail-action-btn pdetail-btn-copy" id="btn-pdetail-copy">
                <span>💖 Guardar Dedicatoria</span>
            </button>
        </footer>
    `;

    // Abrir modal con soporte nativo
    if (detailDialog instanceof HTMLDialogElement) {
        detailDialog.showModal();
    }

    // Configurar escuchadores dentro del modal
    const closeBtn = detailCard.querySelector('#btn-close-pdetail');
    closeBtn?.addEventListener('click', () => {
        detailDialog.close();
    });

    // Botón de teletransporte (Navegar a la pantalla correspondiente)
    const teleportBtn = detailCard.querySelector('#btn-pdetail-teleport');
    teleportBtn?.addEventListener('click', () => {
        const targetScreen = teleportBtn.dataset.screen;
        detailDialog.close();
        const mainPassport = document.getElementById('passport-dialog');
        if (mainPassport instanceof HTMLDialogElement) {
            mainPassport.close();
        }

        // Navegar a la pantalla correspondiente
        if (targetScreen) {
            // Emular enlace data-go
            window.location.hash = `#${targetScreen}`;
            const dummyLink = document.createElement('a');
            dummyLink.dataset.go = targetScreen;
            dummyLink.hidden = true;
            document.body.appendChild(dummyLink);
            dummyLink.click();
            dummyLink.remove();

            // Desbloquear automáticamente el sello al visitarlo
            registerPassportStamp(targetScreen);

            displayToast(`✨ Has viajado al rincón: ${stamp.title}`);
        }
    });

    // Botón de copiar dedicatoria
    const copyBtn = detailCard.querySelector('#btn-pdetail-copy');
    copyBtn?.addEventListener('click', () => {
        const textToCopy = `${stamp.title} — Dedicatoria para Carla Lorena:\n\n${stamp.dedication}\n\n«${stamp.memoryQuote}»\nFlor: ${stamp.flower}`;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                displayToast('💖 ¡Dedicatoria copiada al portapapeles con cariño!');
                playChimeNote(880.00, 0.8);
            }).catch(() => {
                displayToast('💖 Dedicatoria seleccionada');
            });
        }
    });
}

export function updatePassportUI() {
    const passport = getPassportData();
    const countEl = document.getElementById('passport-stamp-count');
    const total = GARDEN_STAMPS_CATALOG.length;
    const current = passport.stamps.length;

    if (countEl) {
        countEl.textContent = `${current}/${total}`;
    }

    const grid = document.getElementById('passport-stamps-grid');
    if (grid) {
        grid.innerHTML = GARDEN_STAMPS_CATALOG.map(stamp => {
            const isUnlocked = passport.stamps.includes(stamp.id);
            const dateStr = passport.unlockedAt[stamp.id] || 'Descubierto';
            return `
                <button type="button" 
                    class="passport-stamp-item ${isUnlocked ? 'is-unlocked' : 'is-locked'}" 
                    data-stamp-id="${stamp.id}"
                    title="Haz clic para ver las 10 dedicatorias de: ${stamp.title}"
                    aria-label="Abrir detalles de ${stamp.title}">
                    <div class="stamp-wax-seal">
                        <span class="stamp-icon">${stamp.icon}</span>
                        ${isUnlocked ? '<span class="stamp-verified">✓</span>' : '<span class="stamp-lock">🔒</span>'}
                    </div>
                    <strong class="stamp-name">${stamp.title}</strong>
                    <small class="stamp-sub">${isUnlocked ? dateStr : 'Por explorar'}</small>
                    <span class="stamp-tap-hint">Ver 10 detalles ✦</span>
                </button>
            `;
        }).join('');

        // Conectar cada botón con su respectivo detalle acústico y modal
        grid.querySelectorAll('.passport-stamp-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const sId = btn.dataset.stampId;
                openPassportDetail(sId);
            });

            // Efecto sonoro de hover
            btn.addEventListener('mouseenter', () => {
                const sId = btn.dataset.stampId;
                const item = GARDEN_STAMPS_CATALOG.find(s => s.id === sId);
                if (item) {
                    playChimeNote(item.frequency * 0.5, 0.25);
                }
            });
        });
    }

    const progressFill = document.getElementById('passport-progress-fill');
    if (progressFill) {
        const pct = Math.round((current / total) * 100);
        progressFill.style.width = `${pct}%`;
    }
}

export function initGardenPassport() {
    const trigger = document.getElementById('passport-header-trigger');
    const dialog = document.getElementById('passport-dialog');
    const detailDialog = document.getElementById('passport-detail-dialog');

    trigger?.addEventListener('click', (e) => {
        e.stopPropagation();
        updatePassportUI();
        if (dialog instanceof HTMLDialogElement) {
            dialog.showModal();
            playChimeNote(659.25, 0.6);
            setTimeout(() => playChimeNote(880.00, 1.0), 140);
        }
    });

    // Cerrar detalle al hacer clic en el backdrop
    detailDialog?.addEventListener('click', (e) => {
        if (e.target === detailDialog) {
            detailDialog.close();
        }
    });

    updatePassportUI();
}

