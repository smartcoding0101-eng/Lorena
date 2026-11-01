/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  EL JARDÍN DE CARLA LORENA · DOCK DE BOTONES FLOTANTES DE SORPRESAS (UX)
 *  1. 🎁 Cofre de Sorpresas & Recuerdos (Polaroid 3D, Cupones de Amor, Confidencias)
 *  2. 📜 Buzón de Botellas al Viento & Deseos Voladores
 *  3. 📸 Cámara de Recuerdos Polaroid Instantánea (Descargable PNG)
 * ═══════════════════════════════════════════════════════════════════════════
 */

import { playChimeNote } from './museum-passport.js';

function showToast(msg) {
    const toast = document.querySelector('.toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.classList.add('is-visible');
    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 3800);
}

// ── Claves de Persistencia del Cofre ──────────────────────────────────────
const STORAGE_KEY_CHEST_UNLOCKED = 'carla_chest_unlocked_v1';
const STORAGE_KEY_CHEST_COUPONS  = 'carla_chest_coupons_v1';

// ── Colección de Sorpresas del Cofre (12 Tesoros Coleccionables) ──────────
const SURPRISE_ITEMS = [
    {
        id: 'pol-almendros',
        type: 'polaroid',
        title: 'Tarde bajo los almendros',
        img: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=700&q=85',
        frontText: 'Un rayo de sol capturado solo para ti',
        backText: '«Aquel día prometimos que no importaría la distancia ni el tiempo, este jardín siempre guardaría tu risa y tu paz.» — Adrián ♡',
        date: 'Primavera en el jardín'
    },
    {
        id: 'cup-peliculas',
        type: 'coupon',
        couponTitle: 'CUPÓN DE AMOR EXCLUSIVO',
        validoPor: 'Una tarde de películas, café tibio y mantitas suaves sin mirar el reloj',
        codigo: 'AMOR-CARLA-01',
        mensaje: 'Canjeable en cualquier momento en que necesites desconectar del mundo y descansar.'
    },
    {
        id: 'sec-ingeniero',
        type: 'secret',
        badge: 'CONFIDENCIA DEL INGENIERO',
        title: 'La razón de cada detalle',
        content: '¿Sabías que cada rosa, cada acorde musical y cada línea de código de esta web fueron creados pensando en hacerte sonreír cuando tu día se sienta pesado? Eres la luz de este proyecto.'
    },
    {
        id: 'pol-jazmines',
        type: 'polaroid',
        title: 'El susurro de la lluvia y jazmines',
        img: 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=700&q=85',
        frontText: 'Jazmines frescos al despertar',
        backText: '«La lluvia puede caer afuera, pero en tu corazón siempre existirá una primavera encendida.» — Para Carla Lorena',
        date: 'Tiempo de lluvia y flores'
    },
    {
        id: 'cup-abrazo',
        type: 'coupon',
        couponTitle: 'VALE POR UN ABRAZO INFINITO',
        validoPor: 'Un abrazo de esos que reconstruyen cualquier pedacito roto y traen calma absoluta',
        codigo: 'ABRAZO-ETERNO-02',
        mensaje: 'Válido sin fecha de vencimiento y con derecho a repetición ilimitada.'
    },
    {
        id: 'sec-flores',
        type: 'secret',
        badge: 'PENSAMIENTO SECRETO',
        title: 'Entre todas las flores',
        content: 'En un jardín de diez mil flores silvestres, no hay ninguna que iguale la nobleza y calidez de tu corazón. Que nunca se te olvide lo valiosa que eres.'
    },
    {
        id: 'cup-postre',
        type: 'coupon',
        couponTitle: 'VALE POR UN POSTRE FAVORITO',
        validoPor: 'Una salida por tu helado o dulce favorito, con charla sin prisa y sonrisas',
        codigo: 'DULCE-CARLA-03',
        mensaje: 'Porque endulzar el día siempre es una buena idea.'
    },
    {
        id: 'pol-atardecer',
        type: 'polaroid',
        title: 'Dorado atardecer sobre el jardín',
        img: 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=700&q=85',
        frontText: 'Cuando el cielo se viste de oro y rosa',
        backText: '«Cada puesta de sol me recuerda que incluso al terminar el día, tu luz deja tibio todo lo que toca.» — Adrián ♡',
        date: 'Crepúsculo dorado'
    },
    {
        id: 'cup-cena',
        type: 'coupon',
        couponTitle: 'VALE POR UNA CENA ESPECIAL',
        validoPor: 'Tu plato favorito preparado o elegido por ti, velas encendidas y tu música preferida',
        codigo: 'CENA-ESTRELLAS-04',
        mensaje: 'Reservado exclusivamente para celebrar tu vida y tus alegrías.'
    },
    {
        id: 'sec-estrella',
        type: 'secret',
        badge: 'SECRETO DEL FIRMAMENTO',
        title: 'Tu nombre en la arquitectura',
        content: 'Si sumas las proporciones áureas del mapa y las notas del arpa del jardín, todas están afinadas en 432 Hz y 528 Hz: frecuencias de armonía y bienestar pensadas para darte paz real.'
    },
    {
        id: 'pol-estrellas',
        type: 'polaroid',
        title: 'Noche de constelaciones tranquilas',
        img: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=700&q=85',
        frontText: 'Un cielo entero cuidando tus sueños',
        backText: '«Nunca caminas sola; hay un universo de cariño acompañando cada uno de tus pasos, Carla Lorena.»',
        date: 'Medianoche estrellada'
    },
    {
        id: 'sec-promesa',
        type: 'secret',
        badge: 'PROMESA ETERNA',
        title: 'Un refugio que no caduca',
        content: 'Pasen los meses o los años, este rincón digital siempre estará abierto para recordarte lo admirada, respetada y profundamente querida que eres.'
    }
];

// ── Colección de Mensajes de la Botella ────────────────────────────────────
const BOTTLE_MESSAGES = [
    // --- Categoría: Amor & Ternura (amor) ---
    {
        category: 'amor',
        text: '«Hay personas que son refugio y hogar. Para este jardín y para mi corazón, esa persona eres tú, Carla Lorena.»',
        author: '- Carta en papel de lino',
        origin: '🌸 Orillas del Lago de Cristal'
    },
    {
        category: 'amor',
        text: '«Ponme como un sello sobre tu corazón. El amor verdadero es tan suave como el aroma de la lavanda y tan eterno como el amanecer.»',
        author: '- Cantares 8:6',
        origin: '🌹 Rosaleda Real'
    },
    {
        category: 'amor',
        text: '«Eres la melodía que calma mis tormentas y el verso más dulce que la vida se atrevió a componer en mi camino.»',
        author: '- Dedicatoria de amor eterno',
        origin: '🌊 Mareas del Atardecer'
    },
    {
        category: 'amor',
        text: '«Si el universo entero fuera una biblioteca de estrellas, cada una de mis páginas favoritas llevaría tu nombre, Carla.»',
        author: '- El Guardián del Faro',
        origin: '✨ Bahía de las Estrellas'
    },
    {
        category: 'amor',
        text: '«Tus sonrisas son como pétalos de sol abriéndose al alba: iluminan con calidez incluso mis días más grises.»',
        author: '- Diario secreto del Jardín',
        origin: '🌸 Pabellón de Seda'
    },
    {
        category: 'amor',
        text: '«Amarte no es una casualidad del tiempo, es la certeza más bonita y luminosa que florece en mi alma.»',
        author: '- Carta sellada con cera carmín',
        origin: '💖 Santuario del Lirio'
    },

    // --- Categoría: Calma & Paz (calma) ---
    {
        category: 'calma',
        text: '«Que la paz que buscas te encuentre hoy en las pequeñas cosas: en el aroma de una flor, en el calor del té y en una respiración profunda.»',
        author: '- Mensaje arrastrado por la brisa',
        origin: '🍃 Isla de la Serenidad'
    },
    {
        category: 'calma',
        text: '«No temas al viento; los tallos más firmes y sabios aprendieron a danzar con la lluvia antes de regalar sus mejores rosas.»',
        author: '- Sabiduría botánica antigua',
        origin: '🌿 Sendero de los Sauces'
    },
    {
        category: 'calma',
        text: '«El mar susurra que todo pasa a su debido tiempo. Descansa tu mente, querida Carla; hoy estás a salvo en tu propio jardín.»',
        author: '- Murmullos del Océano',
        origin: '🌊 Caleta del Silencio'
    },
    {
        category: 'calma',
        text: '«La serenidad no es ausencia de movimiento, sino la certeza íntima de que nada puede apagar la luz pura que vive en tu centro.»',
        author: '- Pensamiento de luz',
        origin: '🌙 Reflejos de Luna'
    },
    {
        category: 'calma',
        text: '«Inhala despacio, exhala las prisas del mundo exterior. Este rincón fue programado para que tu respiración siempre encuentre compás y calma.»',
        author: '- Manifiesto de Paz',
        origin: '🕊️ Manantial Blanco'
    },

    // --- Categoría: Inspiración & Sueños (inspiracion) ---
    {
        category: 'inspiracion',
        text: '«Florecer despacio no es llegar tarde, es florecer con raíces profundas, tronco fuerte y belleza perdurable.»',
        author: '- Susurros del jardín botánico',
        origin: '🌺 Valle de la Esperanza'
    },
    {
        category: 'inspiracion',
        text: '«Si alguna vez dudas de tu grandeza, mira las flores del jardín: ninguna compite con su vecina, cada una brilla con su propia esencia única.»',
        author: '- Cuaderno de Reflexiones',
        origin: '🌷 Pradera Dorada'
    },
    {
        category: 'inspiracion',
        text: '«Dondequiera que mires hoy, encuentra un motivo para dar gracias y avanzar con paso firme hacia tus mayores ilusiones.»',
        author: '- Orquídea de la Mañana',
        origin: '🌅 Colina del Alba'
    },
    {
        category: 'inspiracion',
        text: '«Tus sueños tienen la fuerza de los brotes en primavera: son capaces de atravesar la tierra más dura para tocar el cielo azul.»',
        author: '- Crónica de los Sueños',
        origin: '💫 Horizonte Abierto'
    },
    {
        category: 'inspiracion',
        text: '«La gentileza es tu virtud más poderosa; jamás permitas que la prisa del mundo te haga dudar de lo valiosa y luminosa que eres.»',
        author: '- Carta sellada con flores secas',
        origin: '✨ Cumbre de Cristal'
    },

    // --- Categoría: Julio Adrián (adrian) ---
    {
        category: 'adrian',
        text: '«Cada línea de código, cada botón y cada destello de este jardín fueron forjados con el único anhelo de verte sonreír, mi princesa Carla.»',
        author: '- Tu Ingeniero, Julio Adrián',
        origin: '💌 Mensaje Dedicado con Devoción'
    },
    {
        category: 'adrian',
        text: '«No existe distancia, rutina ni cansancio que puedan aminorar lo que siento por ti. Eres mi inspiración de todos los días.»',
        author: '- Julio Adrián',
        origin: '🌹 El Rincón Secreto de Adrián'
    },
    {
        category: 'adrian',
        text: '«Te miro y confirmo que la vida fue infinitamente generosa al ponerte en mi camino. Te amo con cada latido y cada pensamiento.»',
        author: '- Julio Adrián',
        origin: '💖 Con todo mi amor para Carla'
    },
    {
        category: 'adrian',
        text: '«Quiero ser siempre tu lugar seguro, el abrazo al que quieras volver y el ingeniero que construya todos los jardines de tus sueños.»',
        author: '- Julio Adrián',
        origin: '🕊️ Para mi Carla Lorena'
    }
];

// ── Fotografías para la Cámara Polaroid ────────────────────────────────────
const POLAROID_PHOTOS = [
    { category: 'flores', title: 'Flores de domingo para Carla', quote: '«Para recordarte lo bonito que es florecer despacio y a tu propio ritmo.»', img: 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=800&q=85' },
    { category: 'flores', title: 'El sendero de los jazmines', quote: '«El camino más hermoso siempre es el que recorremos con el alma liviana.»', img: 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=800&q=85' },
    { category: 'flores', title: 'Rosas de seda bajo el rocío', quote: '«En la delicadeza de una rosa reside la fuerza más pura del amor.»', img: 'https://images.unsplash.com/photo-1496062031456-07b8f162a322?auto=format&fit=crop&w=800&q=85' },
    { category: 'atardecer', title: 'Una tarde dorada sobre el trigo', quote: '«Los mejores atardeceres son aquellos compartidos en silencio cómplice.»', img: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=85' },
    { category: 'atardecer', title: 'Luz de atardecer entre las flores', quote: '«Un cálido recordatorio de que siempre hay belleza al final del día.»', img: 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=800&q=85' },
    { category: 'atardecer', title: 'Horizonte de luz carmesí', quote: '«El cielo se viste de fiesta solo para contemplar tu tranquilidad.»', img: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=85' },
    { category: 'amor', title: 'El lago de los reflejos serenos', quote: '«La serenidad no es ausencia de ruido, es paz en el centro del pecho.»', img: 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=800&q=85' },
    { category: 'amor', title: 'Cielo estrellado sobre las cumbres', quote: '«Bajo un millón de estrellas, cada suspiro tiene tu nombre grabado.»', img: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=800&q=85' },
    { category: 'amor', title: 'Un refugio en tus ojos', quote: '«Todo lo que florece con verdad en este mundo lleva un destello de ti, Carla.»', img: 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=800&q=85' }
];

let activePolaroidFilter = 'all';

let lastChestIndex = -1;
let lastBottleIndex = -1;
let currentPolaroid = null;
let currentRelicsOffer = [];
let currentCollectionFilter = 'all';
let currentBottleCategory = 'all';

/* ═══════════════════════════════════════════════════════════════════════════
   1. COFRE DE SORPRESAS (3 RELIQUIAS MISTERIOSAS + ÁLBUM COLECCIONADOR)
   ═══════════════════════════════════════════════════════════════════════════ */
function getUnlockedChestIds() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY_CHEST_UNLOCKED);
        const parsed = raw ? JSON.parse(raw) : [];
        return Array.isArray(parsed) ? parsed : [];
    } catch (_) {
        return [];
    }
}

function markChestItemUnlocked(itemId) {
    if (!itemId) return false;
    const unlocked = getUnlockedChestIds();
    if (!unlocked.includes(itemId)) {
        unlocked.push(itemId);
        try {
            localStorage.setItem(STORAGE_KEY_CHEST_UNLOCKED, JSON.stringify(unlocked));
        } catch (_) {}
        return true;
    }
    return false;
}

function getRedeemedCoupons() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY_CHEST_COUPONS);
        const parsed = raw ? JSON.parse(raw) : [];
        return Array.isArray(parsed) ? parsed : [];
    } catch (_) {
        return [];
    }
}

function saveRedeemedCoupon(couponItem) {
    if (!couponItem || !couponItem.codigo) return;
    const list = getRedeemedCoupons();
    if (list.some(c => c.codigo === couponItem.codigo)) return;
    const nowStr = new Date().toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' });
    list.unshift({
        id: couponItem.id,
        couponTitle: couponItem.couponTitle,
        validoPor: couponItem.validoPor,
        codigo: couponItem.codigo,
        mensaje: couponItem.mensaje,
        redeemedAt: nowStr
    });
    try {
        localStorage.setItem(STORAGE_KEY_CHEST_COUPONS, JSON.stringify(list));
    } catch (_) {}
}

function updateChestProgressUI() {
    const unlocked = getUnlockedChestIds();
    const coupons = getRedeemedCoupons();
    const total = SURPRISE_ITEMS.length;
    const count = Math.min(total, unlocked.length);
    const pct = Math.round((count / total) * 100);

    const countEl = document.getElementById('chest-progress-count');
    const barFillEl = document.getElementById('chest-progress-bar-fill');
    const colBadge = document.getElementById('chest-collection-badge');
    const cupBadge = document.getElementById('chest-coupons-badge');

    if (countEl) countEl.textContent = `${count} / ${total}`;
    if (barFillEl) barFillEl.style.width = `${pct}%`;
    if (colBadge) colBadge.textContent = `${count}`;
    if (cupBadge) cupBadge.textContent = `${coupons.length}`;
}

function switchChestTab(tabName) {
    const tabs = document.querySelectorAll('.chest-tab-btn');
    tabs.forEach((btn) => {
        const isCurrent = btn.dataset.chestTab === tabName;
        btn.classList.toggle('is-active', isCurrent);
        btn.setAttribute('aria-selected', isCurrent ? 'true' : 'false');
    });

    const panes = {
        relics: document.getElementById('chest-pane-relics'),
        collection: document.getElementById('chest-pane-collection'),
        coupons: document.getElementById('chest-pane-coupons')
    };

    Object.entries(panes).forEach(([key, pane]) => {
        if (!pane) return;
        const active = key === tabName;
        pane.classList.toggle('is-active', active);
        pane.hidden = !active;
    });

    if (tabName === 'collection') {
        renderChestCollectionGrid();
    } else if (tabName === 'coupons') {
        renderChestCouponsWallet();
    }
}

function pickThreeRelics() {
    const unlocked = getUnlockedChestIds();
    // Priorizar al menos 1 o 2 tesoros aún no desbloqueados para que sea emocionante completar la colección
    const lockedPool = SURPRISE_ITEMS.filter(item => !unlocked.includes(item.id));
    const shuffledAll = [...SURPRISE_ITEMS].sort(() => Math.random() - 0.5);
    const chosen = [];

    if (lockedPool.length > 0) {
        const shuffledLocked = [...lockedPool].sort(() => Math.random() - 0.5);
        chosen.push(shuffledLocked[0]);
    }
    for (const candidate of shuffledAll) {
        if (chosen.length >= 3) break;
        if (!chosen.some(c => c.id === candidate.id)) {
            chosen.push(candidate);
        }
    }
    return chosen.sort(() => Math.random() - 0.5);
}

function renderThreeRelicsStage() {
    const stage = document.getElementById('chest-content-stage');
    const backBtn = document.getElementById('chest-back-relics-btn');
    const nextBtn = document.getElementById('chest-next-btn');
    const hintEl = document.getElementById('chest-stage-hint');
    if (!stage) return;

    if (backBtn) backBtn.hidden = true;
    if (nextBtn) {
        nextBtn.innerHTML = '<span>Barajar 3 Nuevas Reliquias</span> <span>🎲</span>';
    }
    if (hintEl) {
        hintEl.textContent = 'Toca una de las 3 reliquias selladas para romper su lacre real y revelar tu sorpresa';
    }

    currentRelicsOffer = pickThreeRelics();
    const unlocked = getUnlockedChestIds();

    const relicVisuals = [
        { title: 'Sobre de Lacre Rosa', subtitle: 'Susurro del Jardín', icon: '💌', seal: '❦', tone: 'rose' },
        { title: 'Reliquia Dorada', subtitle: 'Promesa de Luz', icon: '🗝️', seal: '✦', tone: 'gold' },
        { title: 'Cápsula de Cristal', subtitle: 'Recuerdo Eterno', icon: '🏺', seal: '❀', tone: 'amethyst' }
    ];

    stage.innerHTML = `
        <div class="chest-relics-trio" role="list" aria-label="Tres reliquias misteriosas para elegir">
            ${currentRelicsOffer.map((item, idx) => {
                const vis = relicVisuals[idx % relicVisuals.length];
                const isAlreadyUnlocked = unlocked.includes(item.id);
                const typeHint = item.type === 'polaroid' ? '📷 Polaroid' : (item.type === 'coupon' ? '🎫 Vale de Amor' : '💎 Secreto');
                return `
                    <button type="button" class="chest-relic-card relic-tone-${vis.tone}" data-relic-index="${idx}" role="listitem">
                        <span class="relic-status-tag ${isAlreadyUnlocked ? 'is-collected' : 'is-new'}">
                            ${isAlreadyUnlocked ? '✓ En colección' : '✨ Nuevo tesoro'}
                        </span>
                        <div class="relic-icon-orb">
                            <span class="relic-main-emoji">${vis.icon}</span>
                            <span class="relic-wax-badge">${vis.seal}</span>
                        </div>
                        <h4 class="relic-card-title">${vis.title}</h4>
                        <p class="relic-card-sub">${vis.subtitle}</p>
                        <span class="relic-type-pill">${typeHint}</span>
                        <span class="relic-cta-text">Romper sello →</span>
                    </button>
                `;
            }).join('')}
        </div>
    `;

    stage.querySelectorAll('.chest-relic-card').forEach((cardBtn) => {
        cardBtn.addEventListener('click', () => {
            const idx = Number(cardBtn.dataset.relicIndex || 0);
            const selectedItem = currentRelicsOffer[idx];
            if (!selectedItem) return;

            cardBtn.classList.add('is-breaking-seal');
            playChimeNote(587.33, 0.45);
            setTimeout(() => playChimeNote(880.00, 0.8), 110);

            setTimeout(() => {
                revealTreasureItem(selectedItem, true);
            }, 260);
        });
    });
}

function revealTreasureItem(item, fromRelicSelection = false) {
    const stage = document.getElementById('chest-content-stage');
    const backBtn = document.getElementById('chest-back-relics-btn');
    const nextBtn = document.getElementById('chest-next-btn');
    const hintEl = document.getElementById('chest-stage-hint');
    if (!stage || !item) return;

    const isFirstTime = markChestItemUnlocked(item.id);
    updateChestProgressUI();

    if (backBtn) backBtn.hidden = false;
    if (nextBtn) {
        nextBtn.innerHTML = '<span>Abrir otra sorpresa al azar</span> <span>🎲</span>';
    }

    const newBadgeHtml = isFirstTime
        ? '<div class="chest-newly-unlocked-banner">🎉 ¡Nuevo tesoro desbloqueado en tu colección!</div>'
        : '';

    if (item.type === 'polaroid') {
        if (hintEl) hintEl.textContent = 'Toca la fotografía Polaroid para voltearla en 3D y leer su nota secreta';
        stage.innerHTML = `
            ${newBadgeHtml}
            <div class="surprise-flip-card" id="surprise-flip-target" role="button" tabindex="0" title="Haz clic para voltear la polaroid">
                <div class="surprise-flip-inner">
                    <div class="surprise-flip-front">
                        <div class="flip-photo-wrap">
                            <img src="${item.img}" alt="${item.title}">
                            <span class="flip-badge">📷 TOCA PARA VER REVERSO</span>
                        </div>
                        <h4 class="flip-title">${item.title}</h4>
                        <p class="flip-caption">${item.frontText}</p>
                    </div>
                    <div class="surprise-flip-back">
                        <span class="back-wax-mark">❦</span>
                        <h4 class="back-heading">Nota Secreta</h4>
                        <p class="back-note">${item.backText}</p>
                        <small class="back-date">${item.date}</small>
                    </div>
                </div>
            </div>
        `;

        const flipTarget = document.getElementById('surprise-flip-target');
        flipTarget?.addEventListener('click', () => {
            flipTarget.classList.toggle('is-flipped');
            playChimeNote(698.46, 0.5);
        });
        flipTarget?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                flipTarget.classList.toggle('is-flipped');
                playChimeNote(698.46, 0.5);
            }
        });

    } else if (item.type === 'coupon') {
        if (hintEl) hintEl.textContent = 'Canjea este cupón para guardarlo en tu billetera personal «Mis Cupones»';
        const alreadyRedeemed = getRedeemedCoupons().some(c => c.codigo === item.codigo);
        stage.innerHTML = `
            ${newBadgeHtml}
            <div class="surprise-coupon-card">
                <div class="coupon-gold-ribbon">🎫 ${item.couponTitle}</div>
                <div class="coupon-body">
                    <h3 class="coupon-valido">«${item.validoPor}»</h3>
                    <p class="coupon-desc">${item.mensaje}</p>
                    <div class="coupon-code-row">
                        <span class="coupon-code">CÓDIGO: ${item.codigo}</span>
                        <button type="button" class="coupon-redeem-btn${alreadyRedeemed ? ' is-redeemed' : ''}" id="coupon-redeem-btn">
                            ${alreadyRedeemed ? '¡Guardado en Mis Cupones! ✓' : 'Canjear y Guardar ♡'}
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('coupon-redeem-btn')?.addEventListener('click', (e) => {
            saveRedeemedCoupon(item);
            updateChestProgressUI();
            const btn = e.currentTarget;
            btn.textContent = '¡Guardado en Mis Cupones! ✓';
            btn.classList.add('is-redeemed');
            playChimeNote(880.00, 1.2);
            showToast('💖 ¡Cupón canjeado! Puedes verlo y copiarlo cuando quieras en la pestaña «Mis Cupones».');
        });

    } else if (item.type === 'secret') {
        if (hintEl) hintEl.textContent = 'Una confidencia escrita especialmente para ti y guardada en tu colección';
        stage.innerHTML = `
            ${newBadgeHtml}
            <div class="surprise-secret-card">
                <span class="secret-eyebrow">💎 ${item.badge}</span>
                <h3 class="secret-title">${item.title}</h3>
                <div class="blog-card-divider" aria-hidden="true">
                    <span class="divider-line"></span>
                    <span class="divider-rose">❦</span>
                    <span class="divider-line"></span>
                </div>
                <p class="secret-text">${item.content}</p>
            </div>
        `;
    }

    if (fromRelicSelection && isFirstTime) {
        showToast('✨ ¡Has descubierto un nuevo tesoro para tu colección!');
    }
}

function renderChestCollectionGrid() {
    const gridEl = document.getElementById('chest-collection-grid');
    if (!gridEl) return;

    const unlocked = getUnlockedChestIds();
    const filtered = SURPRISE_ITEMS.filter(item => currentCollectionFilter === 'all' || item.type === currentCollectionFilter);

    gridEl.innerHTML = filtered.map((item) => {
        const isUnlocked = unlocked.includes(item.id);
        const typeBadge = item.type === 'polaroid' ? '📷 Polaroid 3D' : (item.type === 'coupon' ? '🎫 Cupón' : '💎 Confidencia');
        const displayTitle = item.title || item.couponTitle || 'Secreto';
        const displayDesc = item.type === 'polaroid'
            ? item.frontText
            : (item.type === 'coupon' ? item.validoPor : item.content.slice(0, 75) + '…');

        if (!isUnlocked) {
            return `
                <article class="chest-col-item is-locked" title="Abre reliquias en la primera pestaña para desbloquear este tesoro">
                    <div class="chest-col-lock-icon">🔒</div>
                    <span class="chest-col-type">${typeBadge}</span>
                    <h4 class="chest-col-title">Tesoro Misterioso</h4>
                    <p class="chest-col-desc">Rompe los sellos en «3 Reliquias» para revelar este recuerdo.</p>
                </article>
            `;
        }

        return `
            <article class="chest-col-item is-unlocked" data-item-id="${item.id}" role="button" tabindex="0" title="Haz clic para inspeccionar este tesoro">
                <div class="chest-col-top">
                    <span class="chest-col-type">${typeBadge}</span>
                    <span class="chest-col-check">✓ Desbloqueado</span>
                </div>
                <h4 class="chest-col-title">${displayTitle}</h4>
                <p class="chest-col-desc">${displayDesc}</p>
                <span class="chest-col-open-link">Ver tesoro completo →</span>
            </article>
        `;
    }).join('');

    gridEl.querySelectorAll('.chest-col-item.is-unlocked').forEach((card) => {
        const openItem = () => {
            const itemId = card.dataset.itemId;
            const found = SURPRISE_ITEMS.find(i => i.id === itemId);
            if (!found) return;
            switchChestTab('relics');
            revealTreasureItem(found, false);
            playChimeNote(659.25, 0.5);
        };
        card.addEventListener('click', openItem);
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openItem();
            }
        });
    });
}

function renderChestCouponsWallet() {
    const walletEl = document.getElementById('chest-coupons-wallet');
    if (!walletEl) return;

    const coupons = getRedeemedCoupons();
    if (coupons.length === 0) {
        walletEl.innerHTML = `
            <div class="chest-wallet-empty">
                <span class="wallet-empty-icon">🎟️</span>
                <h4>Tu billetera de cupones aún está vacía</h4>
                <p>Cuando descubras un Vale de Amor en las reliquias y pulses <strong>«Canjear y Guardar ♡»</strong>, aparecerá aquí listo para usar.</p>
            </div>
        `;
        return;
    }

    walletEl.innerHTML = coupons.map((c) => `
        <article class="chest-wallet-ticket">
            <div class="wallet-ticket-header">
                <span class="wallet-ticket-ribbon">🎫 ${c.couponTitle}</span>
                <small class="wallet-ticket-date">Canjeado: ${c.redeemedAt}</small>
            </div>
            <p class="wallet-ticket-valido">«${c.validoPor}»</p>
            <div class="wallet-ticket-footer">
                <code class="wallet-ticket-code">${c.codigo}</code>
                <button type="button" class="wallet-copy-coupon-btn" data-coupon-code="${c.codigo}" data-coupon-text="${c.validoPor}">
                    📋 Copiar Vale para Adrián
                </button>
            </div>
        </article>
    `).join('');

    walletEl.querySelectorAll('.wallet-copy-coupon-btn').forEach((btn) => {
        btn.addEventListener('click', async () => {
            const code = btn.dataset.couponCode || '';
            const text = btn.dataset.couponText || '';
            const shareText = `🎟️ ¡Hola Adrián! Quiero hacer válido mi cupón del Jardín Secreto:\n«${text}»\nCódigo: ${code} ♡`;
            try {
                await navigator.clipboard.writeText(shareText);
                btn.textContent = '✓ ¡Vale Copiado!';
                setTimeout(() => { btn.textContent = '📋 Copiar Vale para Adrián'; }, 2000);
            } catch (_) {}
            playChimeNote(880.00, 0.7);
            showToast('💌 ¡Texto del cupón copiado! Ya puedes enviárselo a Adrián.');
        });
    });
}

function openSurpriseChest() {
    const dialog = document.getElementById('surprise-chest-dialog');
    if (!dialog) return;

    updateChestProgressUI();
    switchChestTab('relics');
    renderThreeRelicsStage();
    dialog.showModal();
    playChimeNote(523.25, 0.6);
    setTimeout(() => playChimeNote(659.25, 0.7), 120);
    setTimeout(() => playChimeNote(880.00, 1.0), 240);
}

function renderRandomSurprise() {
    let nextIdx;
    do {
        nextIdx = Math.floor(Math.random() * SURPRISE_ITEMS.length);
    } while (SURPRISE_ITEMS.length > 1 && nextIdx === lastChestIndex);
    lastChestIndex = nextIdx;

    revealTreasureItem(SURPRISE_ITEMS[nextIdx], false);
}

/* ═══════════════════════════════════════════════════════════════════════════
   2. BUZÓN DE BOTELLAS AL VIENTO & DESEOS
   ═══════════════════════════════════════════════════════════════════════════ */
function openBottleWishes() {
    const dialog = document.getElementById('bottle-wishes-dialog');
    if (!dialog) return;

    fetchRandomBottleMessage(false);
    renderSavedWishes();
    dialog.showModal();
    playChimeNote(440.00, 0.7);
    setTimeout(() => playChimeNote(587.33, 1.0), 160);
}

function fetchRandomBottleMessage(playChime = true) {
    const pool = currentBottleCategory === 'all'
        ? BOTTLE_MESSAGES
        : BOTTLE_MESSAGES.filter(m => m.category === currentBottleCategory);

    const activePool = pool.length > 0 ? pool : BOTTLE_MESSAGES;
    let nextIdx;
    do {
        nextIdx = Math.floor(Math.random() * activePool.length);
    } while (activePool.length > 1 && nextIdx === lastBottleIndex);
    lastBottleIndex = nextIdx;

    const msg = activePool[nextIdx];
    const textEl = document.getElementById('parchment-message-text');
    const authorEl = document.getElementById('parchment-author');
    const badgeEl = document.getElementById('parchment-origin-badge');
    const starBtn = document.getElementById('parchment-star-btn');
    const scrollBox = document.getElementById('parchment-scroll-box');

    if (scrollBox) {
        scrollBox.style.opacity = '0';
        scrollBox.style.transform = 'translateY(6px)';
        setTimeout(() => {
            if (textEl) textEl.textContent = msg.text;
            if (authorEl) authorEl.textContent = msg.author;
            if (badgeEl) badgeEl.textContent = msg.origin || '🌊 Mar del Jardín Secreto';
            if (starBtn) {
                try {
                    const favs = JSON.parse(localStorage.getItem('carla_fav_bottles') || '[]');
                    starBtn.classList.toggle('is-favorite', favs.some(f => f.text === msg.text));
                } catch (_) {}
            }
            scrollBox.style.opacity = '1';
            scrollBox.style.transform = 'translateY(0)';
        }, 150);
    }

    if (playChime) {
        playChimeNote(659.25, 0.8);
    }
}

function getSavedWishes() {
    try {
        const raw = localStorage.getItem('carla_floating_wishes');
        return raw ? JSON.parse(raw) : [];
    } catch (_) {
        return [];
    }
}

function saveWish(text) {
    const list = getSavedWishes();
    list.unshift({
        id: Date.now(),
        text: text,
        date: new Date().toLocaleDateString('es-ES', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })
    });
    try {
        localStorage.setItem('carla_floating_wishes', JSON.stringify(list.slice(0, 20)));
    } catch (_) {}
}

function renderSavedWishes() {
    const container = document.getElementById('released-wishes-list');
    if (!container) return;

    const wishes = getSavedWishes();
    if (wishes.length === 0) {
        container.innerHTML = `
            <div class="empty-wishes">
                <span class="empty-icon">🌸</span>
                <p>Aún no hay deseos flotando. ¡Sé la primera en liberar uno al jardín!</p>
            </div>
        `;
        return;
    }

    container.innerHTML = `
        <h4 class="wishes-list-title">Deseos flotando en el jardín (${wishes.length})</h4>
        <div class="wishes-cards-scroll">
            ${wishes.map(w => `
                <div class="wish-item-card">
                    <p class="wish-item-text">«${w.text}»</p>
                    <small class="wish-item-date">${w.date}</small>
                </div>
            `).join('')}
        </div>
    `;
}

function releaseWishToGarden() {
    const input = document.getElementById('wish-input');
    const val = input ? input.value.trim() : '';

    if (!val) {
        showToast('🌸 Por favor, escribe unas palabras para tu deseo.');
        return;
    }

    saveWish(val);
    if (input) input.value = '';
    const charCount = document.getElementById('wish-char-count');
    if (charCount) charCount.textContent = '0 / 250';

    renderSavedWishes();

    // Animación de destellos y audio poético
    playChimeNote(523.25, 0.4);
    setTimeout(() => playChimeNote(659.25, 0.4), 120);
    setTimeout(() => playChimeNote(783.99, 0.5), 240);
    setTimeout(() => playChimeNote(1046.50, 1.2), 360);

    showToast('✨ Tu deseo ha sido liberado al jardín y flota con amor entre las rosas.');
}

/* ═══════════════════════════════════════════════════════════════════════════
   3. CÁMARA POLAROID INSTANTÁNEA (DESCARGABLE PNG)
   ═══════════════════════════════════════════════════════════════════════════ */
function openPolaroidCamera() {
    const dialog = document.getElementById('polaroid-camera-dialog');
    const flashOverlay = document.getElementById('flash-effect-overlay');
    if (!dialog) return;

    // Disparar flash suave fotográfico
    if (flashOverlay) {
        flashOverlay.hidden = false;
        flashOverlay.classList.add('flash-active');
        playChimeNote(880.00, 0.15); // Sonido de clic obturador
        setTimeout(() => {
            flashOverlay.classList.remove('flash-active');
            flashOverlay.hidden = true;
        }, 220);
    }

    renderRandomPolaroid();
    dialog.showModal();
    setTimeout(() => {
        playChimeNote(523.25, 0.6);
        setTimeout(() => playChimeNote(783.99, 1.0), 150);
    }, 250);
}

function renderRandomPolaroid() {
    let pool = POLAROID_PHOTOS;
    if (activePolaroidFilter !== 'all') {
        pool = POLAROID_PHOTOS.filter(p => p.category === activePolaroidFilter);
        if (!pool.length) pool = POLAROID_PHOTOS;
    }

    const photo = pool[Math.floor(Math.random() * pool.length)];
    currentPolaroid = photo;

    const img = document.getElementById('polaroid-photo-img');
    const title = document.getElementById('polaroid-title-text');
    const quote = document.getElementById('polaroid-quote-text');
    const date = document.getElementById('polaroid-date-text');
    const badge = document.getElementById('polaroid-category-badge');

    if (img) img.src = photo.img;
    if (title) title.textContent = photo.title;
    if (quote) quote.textContent = photo.quote;
    if (badge) {
        const catMap = { flores: '🌿 Jardín & Flores', atardecer: '🌅 Luz Dorada', amor: '💖 Pensamiento Puro' };
        badge.textContent = catMap[photo.category] || '✨ Colección Especial';
    }
    if (date) {
        const today = new Date().toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
        date.textContent = today;
    }
}

// Descarga en formato Canvas PNG de alta resolución
function downloadPolaroidPNG() {
    if (!currentPolaroid) return;

    const canvas = document.createElement('canvas');
    canvas.width = 800;
    canvas.height = 1000;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    // Fondo polaroid crema/blanco cálido
    ctx.fillStyle = '#faf7f5';
    ctx.fillRect(0, 0, 800, 1000);

    // Borde exterior sutil
    ctx.strokeStyle = '#e8dcd8';
    ctx.lineWidth = 4;
    ctx.strokeRect(10, 10, 780, 980);

    // Cargar imagen
    const image = new Image();
    image.crossOrigin = 'anonymous';
    image.onload = () => {
        // Marco de la foto
        const photoX = 50;
        const photoY = 50;
        const photoW = 700;
        const photoH = 650;

        ctx.drawImage(image, photoX, photoY, photoW, photoH);

        // Borde interior de la foto
        ctx.strokeStyle = 'rgba(0,0,0,0.08)';
        ctx.lineWidth = 2;
        ctx.strokeRect(photoX, photoY, photoW, photoH);

        // Textos del faldón
        ctx.fillStyle = '#3a282b';
        ctx.font = 'bold 36px Georgia, serif';
        ctx.textAlign = 'center';
        ctx.fillText(currentPolaroid.title, 400, 760);

        // Cita poética
        ctx.fillStyle = '#6d5458';
        ctx.font = 'italic 24px Georgia, serif';
        ctx.fillText(currentPolaroid.quote, 400, 820);

        // Divisor floral
        ctx.fillStyle = '#b8898e';
        ctx.font = '24px serif';
        ctx.fillText('❦ ────── 🌸 ────── ❦', 400, 875);

        // Fecha y sello
        const todayStr = new Date().toLocaleDateString('es-ES', { day: 'numeric', month: 'long', year: 'numeric' });
        ctx.fillStyle = '#8f777b';
        ctx.font = '18px sans-serif';
        ctx.fillText(`EL JARDÍN DE CARLA LORENA · ${todayStr}`, 400, 930);

        // Descargar como archivo
        const link = document.createElement('a');
        link.download = `polaroid-carla-lorena-${Date.now()}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();

        playChimeNote(880.00, 1.2);
        showToast('📸 ¡Postal Polaroid descargada con éxito!');
    };

    image.onerror = () => {
        showToast('🌸 Descarga lista desde la vista previa.');
    };

    image.src = currentPolaroid.img;
}

/* ═══════════════════════════════════════════════════════════════════════════
   INICIALIZACIÓN GENERAL DEL DOCK DE SORPRESAS
   ═══════════════════════════════════════════════════════════════════════════ */
export function initFloatingSurprises() {
    // 1. Botón Cofre de Sorpresas (3 Reliquias + Coleccionador + Mis Cupones)
    const chestBtn = document.getElementById('btn-surprise-chest');
    chestBtn?.addEventListener('click', openSurpriseChest);

    const chestBackBtn = document.getElementById('chest-back-relics-btn');
    chestBackBtn?.addEventListener('click', () => {
        renderThreeRelicsStage();
        playChimeNote(587.33, 0.5);
    });

    const chestNextBtn = document.getElementById('chest-next-btn');
    chestNextBtn?.addEventListener('click', () => {
        const backBtn = document.getElementById('chest-back-relics-btn');
        if (backBtn && !backBtn.hidden) {
            renderRandomSurprise();
        } else {
            renderThreeRelicsStage();
        }
        playChimeNote(659.25, 0.6);
    });

    document.querySelectorAll('.chest-tab-btn').forEach((tabBtn) => {
        tabBtn.addEventListener('click', () => {
            switchChestTab(tabBtn.dataset.chestTab || 'relics');
            playChimeNote(523.25, 0.45);
        });
    });

    document.querySelectorAll('.chest-filter-chip').forEach((chip) => {
        chip.addEventListener('click', () => {
            currentCollectionFilter = chip.dataset.chestFilter || 'all';
            document.querySelectorAll('.chest-filter-chip').forEach(c => c.classList.toggle('is-active', c === chip));
            renderChestCollectionGrid();
            playChimeNote(587.33, 0.4);
        });
    });

    // 2. Botón Botella al Viento
    const bottleBtn = document.getElementById('btn-floating-bottle');
    bottleBtn?.addEventListener('click', openBottleWishes);

        // Chips de Categoría de Botella (Ternura, Calma, Inspiración, Adrián)
    const categoryChips = document.querySelectorAll('.bottle-category-chip');
    categoryChips.forEach(chip => {
        chip.addEventListener('click', () => {
            categoryChips.forEach(c => c.classList.remove('is-active'));
            chip.classList.add('is-active');
            currentBottleCategory = chip.dataset.cat || 'all';
            lastBottleIndex = -1;
            fetchRandomBottleMessage(true);
            playChimeNote(783.99, 0.4);
        });
    });

    const bottleFetchBtn = document.getElementById('bottle-fetch-another');
    bottleFetchBtn?.addEventListener('click', () => fetchRandomBottleMessage(true));

    // Pestañas de Botella
    const tabRead = document.getElementById('tab-read-bottle');
    const tabWrite = document.getElementById('tab-send-wish');
    const paneRead = document.getElementById('pane-bottle-read');
    const paneWrite = document.getElementById('pane-bottle-write');

    tabRead?.addEventListener('click', () => {
        tabRead.classList.add('is-active');
        tabWrite?.classList.remove('is-active');
        if (paneRead) { paneRead.hidden = false; paneRead.classList.add('is-active'); }
        if (paneWrite) { paneWrite.hidden = true; paneWrite.classList.remove('is-active'); }
        playChimeNote(523.25, 0.4);
    });

    tabWrite?.addEventListener('click', () => {
        tabWrite.classList.add('is-active');
        tabRead?.classList.remove('is-active');
        if (paneWrite) { paneWrite.hidden = false; paneWrite.classList.add('is-active'); }
        if (paneRead) { paneRead.hidden = true; paneRead.classList.remove('is-active'); }
        playChimeNote(587.33, 0.4);
    });

    // Contador y envío de deseo
    const wishInput = document.getElementById('wish-input');
    const charCount = document.getElementById('wish-char-count');
    wishInput?.addEventListener('input', (e) => {
        if (charCount) charCount.textContent = `${e.target.value.length} / 250`;
    });

    const releaseBtn = document.getElementById('btn-release-wish');
    releaseBtn?.addEventListener('click', releaseWishToGarden);

    // 3. Botón Cámara Polaroid
    const cameraBtn = document.getElementById('btn-polaroid-camera');
    cameraBtn?.addEventListener('click', openPolaroidCamera);

    const polaroidRerollBtn = document.getElementById('polaroid-reroll-btn');
    polaroidRerollBtn?.addEventListener('click', () => {
        renderRandomPolaroid();
        playChimeNote(659.25, 0.5);
    });

    const polaroidDownloadBtn = document.getElementById('polaroid-download-btn');
    polaroidDownloadBtn?.addEventListener('click', downloadPolaroidPNG);

    // 4. Botón Guía Completa del Sistema
    const guideBtn = document.getElementById('btn-open-system-guide');
    const guideDialog = document.getElementById('system-guide-dialog');
    const closeGuideBtn = document.getElementById('btn-close-system-guide');
    const guideTabs = document.querySelectorAll('.guide-tab');
    const searchInput = document.getElementById('guide-search-input');
    const guideCards = document.querySelectorAll('.guide-item-card');

    function openSystemGuide() {
        if (!guideDialog) return;
        playChimeNote(659.25, 0.6);
        setTimeout(() => playChimeNote(880.00, 0.9), 120);
        if (guideDialog instanceof HTMLDialogElement) {
            guideDialog.showModal();
        }
    }

    guideBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        openSystemGuide();
    });

    closeGuideBtn?.addEventListener('click', () => {
        if (guideDialog instanceof HTMLDialogElement) {
            guideDialog.close();
        }
    });

    guideDialog?.addEventListener('click', (e) => {
        if (e.target === guideDialog && guideDialog instanceof HTMLDialogElement) {
            guideDialog.close();
        }
    });

    // Pestañas temáticas de la guía
    guideTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabName = tab.dataset.guideTab;
            guideTabs.forEach(t => {
                const isActive = t === tab;
                t.classList.toggle('is-active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.guide-pane').forEach(pane => {
                const isCurrent = pane.id === `guide-pane-${tabName}`;
                pane.classList.toggle('is-active', isCurrent);
                pane.hidden = !isCurrent;
            });

            playChimeNote(783.99, 0.4);
        });
    });

    // Búsqueda interactiva en la guía
    searchInput?.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        if (!query) {
            guideCards.forEach(card => card.style.display = '');
            return;
        }

        document.querySelectorAll('.guide-pane').forEach(p => p.hidden = false);

        guideCards.forEach(card => {
            const text = (card.innerText + ' ' + (card.dataset.keywords || '')).toLowerCase();
            card.style.display = text.includes(query) ? '' : 'none';
        });
    });
}



// ── INTERACTIVIDAD POLAROID & BOTELLAS AL VIENTO ──
function initEnhancedSurprisesInteractions() {
    // 1. Filtros de categoría de la Polaroid
    document.querySelectorAll('.polaroid-filter-pill').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.polaroid-filter-pill').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            activePolaroidFilter = btn.dataset.filter || 'all';
            renderRandomPolaroid();
            playChimeNote(659.25, 0.4);
        });
    });

    // 2. Copiar frase de la Polaroid
    const copyQuoteBtn = document.getElementById('polaroid-copy-quote-btn');
    copyQuoteBtn?.addEventListener('click', () => {
        if (!currentPolaroid) return;
        const textToCopy = `${currentPolaroid.title}\n${currentPolaroid.quote}\n— El Jardín de Carla Lorena`;
        navigator.clipboard?.writeText(textToCopy).then(() => {
            const txt = document.getElementById('copy-quote-text');
            if (txt) txt.textContent = '¡Copiado con amor! ✨';
            playChimeNote(880.0, 0.4);
            setTimeout(() => {
                if (txt) txt.textContent = 'Copiar Frase';
            }, 2000);
        });
    });

    // 3. Copiar carta de la Botella
    const copyBottleBtn = document.getElementById('btn-copy-bottle-msg');
    copyBottleBtn?.addEventListener('click', () => {
        const textEl = document.getElementById('parchment-message-text');
        const authorEl = document.getElementById('parchment-author');
        if (!textEl) return;
        const msg = `${textEl.textContent}\n${authorEl?.textContent || ''}\n— Rescatado en El Jardín de Carla Lorena`;
        navigator.clipboard?.writeText(msg).then(() => {
            const txt = document.getElementById('copy-bottle-text');
            if (txt) txt.textContent = '¡Mensaje Copiado! ✨';
            playChimeNote(880.0, 0.4);
            setTimeout(() => {
                if (txt) txt.textContent = 'Copiar Carta';
            }, 2000);
        });
    });

    // 4. Tab de Favoritos de Botellas
    const tabFavs = document.getElementById('tab-fav-bottles');
    const tabRead = document.getElementById('tab-read-bottle');
    const tabSend = document.getElementById('tab-send-wish');
    const paneRead = document.getElementById('pane-bottle-read');
    const paneSend = document.getElementById('pane-bottle-write');
    const paneFavs = document.getElementById('pane-bottle-favs');

    function updateFavsCount() {
        try {
            const favs = JSON.parse(localStorage.getItem('carla_fav_bottles') || '[]');
            const countEl = document.getElementById('fav-bottles-count');
            if (countEl) countEl.textContent = favs.length;
        } catch (_) {}
    }

    function renderFavsList() {
        const list = document.getElementById('fav-bottles-list');
        if (!list) return;
        try {
            const favs = JSON.parse(localStorage.getItem('carla_fav_bottles') || '[]');
            if (!favs.length) {
                list.innerHTML = '<p style="text-align:center; color:#9f1239; font-style:italic; padding:20px;">Aún no has guardado mensajes favoritos. Toca la estrella ⭐️ en cualquier carta para conservarla aquí.</p>';
                return;
            }
            list.innerHTML = favs.map(f => `
                <div class="fav-bottle-card">
                    <p class="fav-bottle-text">${f.text}</p>
                    <div class="fav-bottle-meta">
                        <span>${f.origin || '🌊 Mar del Jardín'} · ${f.author || ''}</span>
                        <span>⭐ Favorito</span>
                    </div>
                </div>
            `).join('');
        } catch (_) {}
    }

    tabFavs?.addEventListener('click', () => {
        [tabRead, tabSend, tabFavs].forEach(t => t?.classList.remove('is-active'));
        tabFavs.classList.add('is-active');
        if (paneRead) { paneRead.classList.remove('is-active'); paneRead.hidden = true; }
        if (paneSend) { paneSend.classList.remove('is-active'); paneSend.hidden = true; }
        if (paneFavs) { paneFavs.classList.add('is-active'); paneFavs.hidden = false; }
        renderFavsList();
        playChimeNote(783.99, 0.4);
    });

    // Actualizar tabs al volver a Leer o Lanzar
    tabRead?.addEventListener('click', () => {
        if (paneFavs) { paneFavs.classList.remove('is-active'); paneFavs.hidden = true; }
    });
    tabSend?.addEventListener('click', () => {
        if (paneFavs) { paneFavs.classList.remove('is-active'); paneFavs.hidden = true; }
    });

    // 5. Botón de Marcar Favorito en la Botella
    const starBtn = document.getElementById('parchment-star-btn');
    starBtn?.addEventListener('click', () => {
        const textEl = document.getElementById('parchment-message-text');
        const authorEl = document.getElementById('parchment-author');
        const badgeEl = document.getElementById('parchment-origin-badge');
        if (!textEl) return;
        try {
            let favs = JSON.parse(localStorage.getItem('carla_fav_bottles') || '[]');
            const currentItem = {
                text: textEl.textContent,
                author: authorEl?.textContent || '',
                origin: badgeEl?.textContent || ''
            };
            const existingIdx = favs.findIndex(f => f.text === currentItem.text);
            if (existingIdx >= 0) {
                favs.splice(existingIdx, 1);
                starBtn.classList.remove('is-favorite');
            } else {
                favs.push(currentItem);
                starBtn.classList.add('is-favorite');
                playChimeNote(1046.50, 0.4);
            }
            localStorage.setItem('carla_fav_bottles', JSON.stringify(favs));
            updateFavsCount();
        } catch (_) {}
    });

    updateFavsCount();
}
