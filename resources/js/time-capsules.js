// ═══════════════════════════════════════════════════════════════════════
//  SISTEMA DE CÁPSULAS DEL TIEMPO & CARTAS SELLADAS CON CUENTA REGRESIVA
//  Estilo Romántico & Misterioso · Carla Lorena
// ═══════════════════════════════════════════════════════════════════════

export function initializeTimeCapsules() {
    const section = document.querySelector('[data-screen="capsula"]');
    if (!section) return;

    const toggleBtn = document.getElementById('tc-toggle-create-btn');
    const drawer = document.getElementById('tc-create-drawer');
    const form = document.getElementById('tc-form');
    const grid = document.getElementById('tc-capsules-grid');
    const submitBtn = document.getElementById('tc-submit-btn');

    let capsules = [];
    let intervalId = null;

    if (toggleBtn && drawer) {
        toggleBtn.addEventListener('click', () => {
            drawer.hidden = !drawer.hidden;
            if (!drawer.hidden) {
                drawer.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    // Cargar cápsulas desde el servidor
    async function fetchCapsules() {
        if (!grid) return;
        try {
            grid.innerHTML = `
                <div class="tc-loading">
                    <span class="tc-loading-icon">⏳</span>
                    <p>Consultando el cofre del tiempo...</p>
                </div>
            `;
            const res = await fetch('/time-capsules', { credentials: 'same-origin' });
            if (!res.ok) throw new Error('No se pudo cargar las cápsulas');
            const data = await res.json();
            capsules = data.capsules || [];
            renderCapsules();
            startCountdownLoop();
            window.refreshPersonalStats?.();
        } catch (e) {
            console.error(e);
            grid.innerHTML = `
                <div class="tc-empty">
                    <p>Inicia sesión o recarga para ver las cartas de la cápsula.</p>
                </div>
            `;
        }
    }

    // Renderizar tarjetas de cápsulas
    function renderCapsules() {
        if (!grid) return;
        if (capsules.length === 0) {
            grid.innerHTML = `
                <div class="tc-empty">
                    <span class="tc-empty-icon">💌</span>
                    <h3>El cofre está esperando su primera carta</h3>
                    <p>Sella un recuerdo, una promesa o una dedicatoria que se revelará en una fecha especial.</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = capsules.map(c => {
            const isUnlocked = c.is_unlocked;
            const moodIcons = {
                love: '💖',
                anniversary: '💍',
                birthday: '🎂',
                future: '🌟',
                secret: '🔒',
            };
            const icon = moodIcons[c.mood] || '💌';

            if (isUnlocked) {
                // Tarjeta Desbloqueada y Abierta
                return `
                    <article class="tc-card is-unlocked" data-capsule-id="${c.id}">
                        <div class="tc-card-ribbon"><span>✨ DESBLOQUEADA</span></div>
                        <div class="tc-card-header">
                            <span class="tc-card-icon">${icon}</span>
                            <div>
                                <h3 class="tc-card-title">${escapeHtml(c.title)}</h3>
                                <span class="tc-card-meta">De: ${escapeHtml(c.author_name)} · Revelada</span>
                            </div>
                        </div>
                        <div class="tc-card-body">
                            <p class="tc-card-message">${escapeHtml(c.message)}</p>
                            ${c.image_url ? `
                                <div class="tc-card-image-wrap">
                                    <img src="${c.image_url}" alt="${escapeHtml(c.title)}" class="tc-card-image">
                                </div>
                            ` : ''}
                        </div>
                        <div class="tc-card-footer">
                            <span class="tc-card-date">✦ Abierta para siempre</span>
                            <button type="button" class="tc-delete-btn" data-delete-capsule="${c.id}" title="Eliminar carta">🗑️</button>
                        </div>
                    </article>
                `;
            } else {
                // Tarjeta Sellada con Candado y Cuenta Regresiva
                return `
                    <article class="tc-card is-locked" data-capsule-id="${c.id}" data-unlock-time="${c.unlock_at}">
                        <div class="tc-card-ribbon is-locked"><span>🔒 SELLADA</span></div>
                        <div class="tc-card-header">
                            <span class="tc-card-icon">${icon}</span>
                            <div>
                                <h3 class="tc-card-title">${escapeHtml(c.title)}</h3>
                                <span class="tc-card-meta">De: ${escapeHtml(c.author_name)}</span>
                            </div>
                        </div>
                        <div class="tc-card-lock-body">
                            <div class="tc-lock-emblem">
                                <span class="tc-lock-icon">🔒</span>
                            </div>
                            <p class="tc-lock-desc">Se abrirá el <strong>${escapeHtml(c.unlock_at_formatted)}</strong></p>
                            
                            <div class="tc-countdown-display" data-countdown-id="${c.id}">
                                <div class="tc-time-col"><span class="tc-time-num tc-days">--</span><small>Días</small></div>
                                <span class="tc-sep">:</span>
                                <div class="tc-time-col"><span class="tc-time-num tc-hours">--</span><small>Horas</small></div>
                                <span class="tc-sep">:</span>
                                <div class="tc-time-col"><span class="tc-time-num tc-minutes">--</span><small>Min</small></div>
                                <span class="tc-sep">:</span>
                                <div class="tc-time-col"><span class="tc-time-num tc-seconds">--</span><small>Seg</small></div>
                            </div>
                        </div>
                        <div class="tc-card-footer">
                            <span class="tc-card-date">⏳ Guardada bajo secreto</span>
                            <button type="button" class="tc-delete-btn" data-delete-capsule="${c.id}" title="Eliminar carta">🗑️</button>
                        </div>
                    </article>
                `;
            }
        }).join('');

        // Conectar botones de borrado
        grid.querySelectorAll('[data-delete-capsule]').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.stopPropagation();
                if (!await window.showConfirm({ title: '¿Romper cápsula?', message: '¿Deseas romper el sello y eliminar esta cápsula para siempre?', confirmText: 'Sí, eliminar', type: 'danger' })) return;
                const id = btn.getAttribute('data-delete-capsule');
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/time-capsules/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                    });
                    if (res.ok) {
                        capsules = capsules.filter(c => c.id != id);
                        renderCapsules();
                        window.refreshPersonalStats?.();
                    }
                } catch (err) {
                    console.error('Error al eliminar cápsula:', err);
                }
            });
        });
    }

    // Bucle en vivo de cuenta regresiva
    function startCountdownLoop() {
        if (intervalId) clearInterval(intervalId);
        updateCountdowns();
        intervalId = setInterval(updateCountdowns, 1000);
    }

    function updateCountdowns() {
        const lockedCards = document.querySelectorAll('.tc-card.is-locked[data-unlock-time]');
        if (lockedCards.length === 0) return;

        const now = new Date().getTime();
        let needRefresh = false;

        lockedCards.forEach(card => {
            const unlockStr = card.getAttribute('data-unlock-time');
            const unlockTime = new Date(unlockStr).getTime();
            const diff = unlockTime - now;

            const display = card.querySelector('.tc-countdown-display');
            if (!display) return;

            if (diff <= 0) {
                needRefresh = true;
                display.innerHTML = '<span class="tc-unlocked-notice">🌸 ¡Ha llegado el momento de abrirla!</span>';
            } else {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                const dEl = display.querySelector('.tc-days');
                const hEl = display.querySelector('.tc-hours');
                const mEl = display.querySelector('.tc-minutes');
                const sEl = display.querySelector('.tc-seconds');

                if (dEl) dEl.textContent = String(days).padStart(2, '0');
                if (hEl) hEl.textContent = String(hours).padStart(2, '0');
                if (mEl) mEl.textContent = String(minutes).padStart(2, '0');
                if (sEl) sEl.textContent = String(seconds).padStart(2, '0');
            }
        });

        if (needRefresh) {
            // Si al menos una se cumplió en este segundo, recargamos la lista
            fetchCapsules();
        }
    }

    // Envío del formulario
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>🔒</span> Sellando carta...';
            }

            try {
                const formData = new FormData(form);
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/time-capsules', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await res.json();
                if (!res.ok) {
                    window.showAlert({ title: 'Error en la cápsula', message: data.message || 'Error al sellar la cápsula. Verifica la fecha.', type: 'error' });
                    return;
                }

                form.reset();
                drawer.hidden = true;
                await fetchCapsules();
                window.refreshPersonalStats?.();
            } catch (err) {
                console.error('Error al crear cápsula:', err);
                window.showAlert({ title: 'Error', message: 'No se pudo guardar la cápsula.', type: 'error' });
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>🔒</span> Sellar en el cofre del tiempo';
                }
            }
        });
    }

    // Escuchar cambios de hash para cargar cápsulas si se navega a #capsula
    window.addEventListener('hashchange', () => {
        if (window.location.hash === '#capsula') {
            fetchCapsules();
        }
    });

    if (window.location.hash === '#capsula') {
        fetchCapsules();
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
