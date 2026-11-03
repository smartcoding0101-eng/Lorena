/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  EL JARDÍN DE CARLA LORENA · DEDICATORIAS DE AMIGOS (VOCES DEL CORAZÓN)
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

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.getAttribute('content');
    const input = document.querySelector('input[name="_token"]');
    return input ? input.value : '';
}

export function initFriendDedications() {
    const form = document.getElementById('friend-dedication-form');
    const authorInput = document.getElementById('friend-author-input');
    const messageInput = document.getElementById('friend-message-input');
    const badgeChips = document.querySelectorAll('.flower-badge-chip');
    const hiddenBadgeInput = document.getElementById('selected-flower-badge');
    const charCounter = document.getElementById('friend-char-count');
    const grid = document.getElementById('friends-dedications-grid');
    const countEl = document.getElementById('dedications-count');
    const emptyWall = document.getElementById('friends-empty-wall');

    // 1. Selector de Flor / Emblema
    badgeChips.forEach(chip => {
        chip.addEventListener('click', () => {
            badgeChips.forEach(c => c.classList.remove('is-selected'));
            chip.classList.add('is-selected');
            if (hiddenBadgeInput) {
                hiddenBadgeInput.value = chip.dataset.badge || '🌸';
            }
            playChimeNote(523.25, 0.3);
        });
    });

    // 2. Contador de caracteres en el textarea
    messageInput?.addEventListener('input', (e) => {
        if (charCounter) {
            charCounter.textContent = `${e.target.value.length} / 600 caracteres`;
        }
    });

    // 3. Envío del Formulario
    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const author = authorInput?.value.trim();
        const message = messageInput?.value.trim();
        const badge = hiddenBadgeInput?.value || '🌸';
        const submitBtn = document.getElementById('friend-submit-btn');

        if (!author || !message) {
            showToast('🌸 Por favor, ingresa tu nombre y un mensaje para Carla.');
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Publicando...';
        }

        try {
            const response = await fetch('/friend-dedications', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({
                    author_name: author,
                    message: message,
                    flower_badge: badge,
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Crear la tarjeta en el DOM
                const newCard = document.createElement('article');
                newCard.className = 'friend-dedication-card is-newly-added';
                newCard.dataset.dedicationId = data.dedication.id;
                newCard.innerHTML = `
                    <div class="card-flower-badge">${data.dedication.flower_badge}</div>
                    <div class="card-content-wrap">
                        <div class="card-meta-top">
                            <strong class="friend-author-name">${escapeHtml(data.dedication.author_name)}</strong>
                            <time class="friend-card-date">hace unos segundos</time>
                        </div>
                        <p class="friend-card-message">«${escapeHtml(data.dedication.message)}»</p>
                    </div>
                `;

                if (emptyWall) emptyWall.remove();
                if (grid) {
                    grid.prepend(newCard);
                }

                if (countEl) {
                    const current = parseInt(countEl.textContent, 10) || 0;
                    countEl.textContent = String(current + 1);
                }

                // Reset de formulario
                form.reset();
                if (hiddenBadgeInput) hiddenBadgeInput.value = '🌸';
                badgeChips.forEach((c, idx) => c.classList.toggle('is-selected', idx === 0));
                if (charCounter) charCounter.textContent = '0 / 600 caracteres';

                // Feedback sensorial
                playChimeNote(523.25, 0.4);
                setTimeout(() => playChimeNote(659.25, 0.4), 120);
                setTimeout(() => playChimeNote(783.99, 0.5), 240);
                setTimeout(() => playChimeNote(1046.50, 1.0), 360);

                showToast('✨ ¡Tu dedicatoria ha florecido en el jardín de Carla!');
            } else {
                showToast(data.message || 'Ocurrió un error al publicar la dedicatoria.');
            }
        } catch (err) {
            console.error('Error publicando dedicatoria:', err);
            showToast('🌸 No se pudo enviar en este momento. Inténtalo de nuevo.');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<span>Publicar dedicatoria en el jardín</span> <span>🌸</span>`;
            }
        }
    });

    // 4. Eliminación de Dedicatoria por el Administrador
    grid?.addEventListener('click', async (e) => {
        const deleteBtn = e.target.closest('.btn-delete-dedication');
        if (!deleteBtn) return;

        const dedicationId = deleteBtn.dataset.deleteId;
        const card = deleteBtn.closest('.friend-dedication-card');

        if (!dedicationId || !card) return;

        if (!await window.showConfirm({ title: '¿Eliminar dedicatoria?', message: '¿Deseas eliminar permanentemente esta dedicatoria del jardín de Carla?', confirmText: 'Sí, eliminar', type: 'danger' })) {
            return;
        }

        try {
            const response = await fetch(`/friend-dedications/${dedicationId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                card.style.transition = 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9) translateY(-10px)';

                setTimeout(() => {
                    card.remove();
                    if (countEl) {
                        const current = parseInt(countEl.textContent, 10) || 1;
                        countEl.textContent = String(Math.max(0, current - 1));
                    }
                }, 300);

                playChimeNote(440.00, 0.6);
                showToast('🗑️ Dedicatoria eliminada del jardín.');
            } else {
                showToast(data.message || 'No se pudo eliminar la dedicatoria.');
            }
        } catch (err) {
            console.error('Error eliminando dedicatoria:', err);
            showToast('Error de conexión al eliminar.');
        }
    });
}

function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
