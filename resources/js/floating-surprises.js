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

// ── Colección de Sorpresas del Cofre ──────────────────────────────────────
const SURPRISE_ITEMS = [
    {
        type: 'polaroid',
        title: 'Tarde bajo los almendros',
        img: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=700&q=85',
        frontText: 'Un rayo de sol capturado solo para ti',
        backText: '«Aquel día prometimos que no importaría la distancia ni el tiempo, este jardín siempre guardaría tu risa y tu paz.» — Adrián ♡',
        date: 'Primavera en el jardín'
    },
    {
        type: 'coupon',
        couponTitle: 'CUPÓN DE AMOR EXCLUSIVO',
        validoPor: 'Una tarde de películas, café tibio y mantitas suaves sin mirar el reloj',
        codigo: 'AMOR-CARLA-01',
        mensaje: 'Canjeable en cualquier momento en que necesites desconectar del mundo y descansar.'
    },
    {
        type: 'secret',
        badge: 'CONFIDENCIA DEL INGENIERO',
        title: 'La razón de cada detalle',
        content: '¿Sabías que cada rosa, cada acorde musical y cada línea de código de esta web fueron creados pensando en hacerte sonreír cuando tu día se sienta pesado? Eres la luz de este proyecto.'
    },
    {
        type: 'polaroid',
        title: 'El susurro de la lluvia y jazmines',
        img: 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=700&q=85',
        frontText: 'Jazmines frescos al despertar',
        backText: '«La lluvia puede caer afuera, pero en tu corazón siempre existirá una primavera encendida.» — Para Carla Lorena',
        date: 'Tiempo de lluvia y flores'
    },
    {
        type: 'coupon',
        couponTitle: 'VALE POR UN ABRAZO INFINITO',
        validoPor: 'Un abrazo de esos que reconstruyen cualquier pedacito roto y traen calma absoluta',
        codigo: 'ABRAZO-ETERNO-02',
        mensaje: 'Válido sin fecha de vencimiento y con derecho a repetición ilimitada.'
    },
    {
        type: 'secret',
        badge: 'PENSAMIENTO SECRETO',
        title: 'Entre todas las flores',
        content: 'En un jardín de diez mil flores silvestres, no hay ninguna que iguale la nobleza y calidez de tu corazón. Que nunca se te olvide lo valiosa que eres.'
    },
    {
        type: 'coupon',
        couponTitle: 'VALE POR UN POSTRE FAVORITO',
        validoPor: 'Una salida por tu helado o dulce favorito, con charla sin prisa y sonrisas',
        codigo: 'DULCE-CARLA-03',
        mensaje: 'Porque endulzar el día siempre es una buena idea.'
    }
];

// ── Colección de Mensajes de la Botella ────────────────────────────────────
const BOTTLE_MESSAGES = [
    { text: '«Que la paz que buscas te encuentre hoy en las pequeñas cosas: en el aroma de una flor, en el calor del té y en una palabra sincera.»', author: '— Mensaje arrastrado por la brisa' },
    { text: '«Florecer despacio no es llegar tarde, es florecer con raíces firmes y belleza duradera.»', author: '— Susurros del jardín' },
    { text: '«Hay personas que son refugio y hogar. Para este jardín y para mi corazón, esa persona eres tú, Carla Lorena.»', author: '— Carta en papel de lino' },
    { text: '«Ponme como sello sobre tu corazón. El amor es fuerte como la vida y tan tierno como el primer brote de la mañana.»', author: '— Cantares 8:6' },
    { text: '«No temas al viento; los tallos más fuertes aprendieron a bailar con la tormenta antes de dar sus mejores rosas.»', author: '— Sabiduría botánica' },
    { text: '«Si alguna vez dudas de tu brillo, entra a este jardín y recuerda que todo aquí existe para reflejar tu propia luz.»', author: '— Adrián' }
];

// ── Fotografías para la Cámara Polaroid ────────────────────────────────────
const POLAROID_PHOTOS = [
    { title: 'Flores de domingo para Carla', quote: '«Para recordarte lo bonito que es florecer despacio y a tu propio ritmo.»', img: 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=800&q=85' },
    { title: 'El lago de los reflejos serenos', quote: '«La serenidad no es ausencia de ruido, es paz en el centro del pecho.»', img: 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=800&q=85' },
    { title: 'Una tarde dorada sobre el trigo', quote: '«Los mejores atardeceres son aquellos compartidos en silencio cómplice.»', img: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=85' },
    { title: 'Cielo estrellado sobre las montañas', quote: '«Bajo un millón de estrellas, cada suspiro tiene tu nombre grabado.»', img: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=800&q=85' },
    { title: 'El sendero de los jazmines', quote: '«El camino más hermoso siempre es el que recorremos con el alma liviana.»', img: 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=800&q=85' },
    { title: 'Luz de atardecer entre las flores', quote: '«Un cálido recordatorio de que siempre hay belleza al final del día.»', img: 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=800&q=85' }
];

let lastChestIndex = -1;
let lastBottleIndex = -1;
let currentPolaroid = null;

/* ═══════════════════════════════════════════════════════════════════════════
   1. COFRE DE SORPRESAS
   ═══════════════════════════════════════════════════════════════════════════ */
function openSurpriseChest() {
    const dialog = document.getElementById('surprise-chest-dialog');
    if (!dialog) return;

    renderRandomSurprise();
    dialog.showModal();
    playChimeNote(523.25, 0.6);
    setTimeout(() => playChimeNote(659.25, 0.7), 120);
    setTimeout(() => playChimeNote(880.00, 1.0), 240);
}

function renderRandomSurprise() {
    const stage = document.getElementById('chest-content-stage');
    if (!stage) return;

    let nextIdx;
    do {
        nextIdx = Math.floor(Math.random() * SURPRISE_ITEMS.length);
    } while (SURPRISE_ITEMS.length > 1 && nextIdx === lastChestIndex);
    lastChestIndex = nextIdx;

    const item = SURPRISE_ITEMS[nextIdx];

    if (item.type === 'polaroid') {
        stage.innerHTML = `
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
        stage.innerHTML = `
            <div class="surprise-coupon-card">
                <div class="coupon-gold-ribbon">🎫 ${item.couponTitle}</div>
                <div class="coupon-body">
                    <h3 class="coupon-valido">«${item.validoPor}»</h3>
                    <p class="coupon-desc">${item.mensaje}</p>
                    <div class="coupon-code-row">
                        <span class="coupon-code">CÓDIGO: ${item.codigo}</span>
                        <button type="button" class="coupon-redeem-btn" id="coupon-redeem-btn">Canjear Ahora ♡</button>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('coupon-redeem-btn')?.addEventListener('click', (e) => {
            e.currentTarget.textContent = '¡Canjeado con Cariño! ✓';
            e.currentTarget.style.background = '#4ade80';
            e.currentTarget.style.color = '#ffffff';
            playChimeNote(880.00, 1.2);
            showToast('💖 ¡Cupón activado! Se ha guardado en el corazón del jardín.');
        });

    } else if (item.type === 'secret') {
        stage.innerHTML = `
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
    let nextIdx;
    do {
        nextIdx = Math.floor(Math.random() * BOTTLE_MESSAGES.length);
    } while (BOTTLE_MESSAGES.length > 1 && nextIdx === lastBottleIndex);
    lastBottleIndex = nextIdx;

    const msg = BOTTLE_MESSAGES[nextIdx];
    const textEl = document.getElementById('parchment-message-text');
    const authorEl = document.getElementById('parchment-author');
    const scrollBox = document.getElementById('parchment-scroll-box');

    if (scrollBox) {
        scrollBox.style.opacity = '0';
        scrollBox.style.transform = 'translateY(10px) scale(0.97)';
        setTimeout(() => {
            if (textEl) textEl.textContent = msg.text;
            if (authorEl) authorEl.textContent = msg.author;
            scrollBox.style.opacity = '1';
            scrollBox.style.transform = 'translateY(0) scale(1)';
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
    const photo = POLAROID_PHOTOS[Math.floor(Math.random() * POLAROID_PHOTOS.length)];
    currentPolaroid = photo;

    const img = document.getElementById('polaroid-photo-img');
    const title = document.getElementById('polaroid-title-text');
    const quote = document.getElementById('polaroid-quote-text');
    const date = document.getElementById('polaroid-date-text');

    if (img) img.src = photo.img;
    if (title) title.textContent = photo.title;
    if (quote) quote.textContent = photo.quote;
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
    // 1. Botón Cofre de Sorpresas
    const chestBtn = document.getElementById('btn-surprise-chest');
    chestBtn?.addEventListener('click', openSurpriseChest);

    const chestNextBtn = document.getElementById('chest-next-btn');
    chestNextBtn?.addEventListener('click', () => {
        renderRandomSurprise();
        playChimeNote(659.25, 0.6);
    });

    // 2. Botón Botella al Viento
    const bottleBtn = document.getElementById('btn-floating-bottle');
    bottleBtn?.addEventListener('click', openBottleWishes);

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
