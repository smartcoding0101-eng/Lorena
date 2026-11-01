function playSoftChime(frequency) {
    if (window.__gardenMasterAudioMuted) return;
    try {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;
        const ctx = new AudioCtx();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(frequency || 523.25, ctx.currentTime);
        gain.gain.setValueAtTime(0.045, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.85);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.9);
    } catch (_) {}
}

export function initializeCornerNotes() {
    const drawer = document.getElementById('corner-crud-drawer');
    if (!drawer) return;

    const screenNameEl = document.getElementById('drawer-screen-name');
    const notesListEl = document.getElementById('corner-notes-list');
    const notesCountBadge = document.getElementById('corner-notes-count') || document.getElementById('floating-notes-count-badge');
    const tabCountEl = document.getElementById('drawer-tab-count');
    const noteForm = document.getElementById('corner-note-form');
    const formIdInput = document.getElementById('note-form-id');
    const formScreenInput = document.getElementById('note-form-screen');
    const imageInput = document.getElementById('note-image');
    const imagePreview = document.getElementById('note-image-preview');
    const removeImageBtn = document.getElementById('note-remove-image-btn');
    const cancelBtn = document.getElementById('note-cancel-btn');

    // Filtros interactivos y buscador
    const searchInput = document.getElementById('corner-notes-search-input');
    const moodFilterContainer = document.getElementById('corner-mood-filters');
    let currentMoodFilter = 'all';
    let searchQuery = '';

    // Mapeo amigable de nombres de pantallas
    const screenFriendlyNames = {
        inicio: 'Inicio & Bienvenida',
        mapa: 'Mapa del Jardín Secreto',
        jardin: 'Santuario Botánico',
        familia: 'Mi Familia',
        amigos: 'Dedicatorias de Amigos',
        galeria: 'Galería Fotográfica',
        biblioteca: 'Biblioteca & Música',
        capsula: 'Cápsula del Tiempo',
        destinos: 'Destinos & Sueños',
        blog: 'Blog del Jardín',
        diario: 'Mi Diario Íntimo',
        juegos: 'Rincón de Juegos'
    };

    const moodIcons = {
        love: '💌 Amor y Cariño',
        gratitude: '🌸 Gratitud y Paz',
        dream: '✨ Sueño o Meta',
        memory: '📷 Recuerdo Especial',
        secret: '🌙 Secreto / Íntimo'
    };

    let currentScreenKey = 'inicio';
    let currentNotes = [];

    // Detectar pantalla activa actualmente
    function getActiveScreenKey() {
        const hash = (window.location.hash || '').replace(/^#/, '').trim();
        if (hash && screenFriendlyNames[hash]) return hash;
        const visibleSection = document.querySelector('section.screen:not([hidden])');
        if (visibleSection && visibleSection.dataset.screen) {
            return visibleSection.dataset.screen;
        }
        return 'inicio';
    }

    // Abrir cajón contextual
    window.openCornerNotesDrawer = function(screenKey) {
        currentScreenKey = screenKey || getActiveScreenKey();
        if (screenNameEl) {
            screenNameEl.textContent = screenFriendlyNames[currentScreenKey] || 'Este Rincón';
        }
        if (formScreenInput) {
            formScreenInput.value = currentScreenKey;
        }
        drawer.hidden = false;
        switchTab('list');
        fetchNotesForCurrentScreen();
        playSoftChime(587.33); // Tono musical suave de apertura
    };

    // Cerrar cajón
    const closeButtons = drawer.querySelectorAll('[data-drawer-close]');
    closeButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            drawer.hidden = true;
            resetForm();
        });
    });

    // Pestañas (Ver lista / Crear)
    const tabs = drawer.querySelectorAll('[data-drawer-tab]');
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.drawerTab;
            tabs.forEach(t => t.classList.toggle('is-active', t === tab));
            const listPane = document.getElementById('pane-notes-list');
            const formPane = document.getElementById('pane-notes-form');
            const filterBar = drawer.querySelector('.corner-drawer-filter-bar');
            if (target === 'list') {
                if (listPane) listPane.hidden = false;
                if (formPane) formPane.hidden = true;
                if (filterBar) filterBar.hidden = false;
            } else {
                if (listPane) listPane.hidden = true;
                if (formPane) formPane.hidden = false;
                if (filterBar) filterBar.hidden = true;
            }
        });
    });

    // Cambiar pestañas programáticamente
    const switchTab = (tabName) => {
        const targetTab = drawer.querySelector(`[data-drawer-tab="${tabName}"]`);
        if (targetTab) targetTab.click();
    };

    // Manejo de Filtros por Emoción
    moodFilterContainer?.querySelectorAll('.corner-mood-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            moodFilterContainer.querySelectorAll('.corner-mood-chip').forEach(c => c.classList.remove('is-active'));
            chip.classList.add('is-active');
            currentMoodFilter = chip.dataset.moodFilter || 'all';
            renderNotes(currentNotes);
            playSoftChime(659.25);
        });
    });

    // Buscador interactivo en vivo
    searchInput?.addEventListener('input', (e) => {
        searchQuery = (e.target.value || '').toLowerCase().trim();
        renderNotes(currentNotes);
    });

    // Previsualización de imagen
    if (imageInput) {
        imageInput.addEventListener('change', () => {
            const file = imageInput.files?.[0];
            if (file && imagePreview) {
                const url = URL.createObjectURL(file);
                const img = imagePreview.querySelector('img');
                if (img) img.src = url;
                imagePreview.hidden = false;
            }
        });
    }

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', () => {
            if (imageInput) imageInput.value = '';
            if (imagePreview) imagePreview.hidden = true;
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            resetForm();
            switchTab('list');
        });
    }

    // Resetear formulario
    const resetForm = () => {
        if (!noteForm) return;
        noteForm.reset();
        if (formIdInput) formIdInput.value = '';
        if (formScreenInput) formScreenInput.value = currentScreenKey;
        if (imagePreview) imagePreview.hidden = true;
        const submitBtn = document.getElementById('note-submit-btn');
        if (submitBtn) submitBtn.textContent = 'Guardar recuerdo';
    };

    // Cargar notas desde el backend
    async function fetchNotesForCurrentScreen() {
        try {
            const response = await fetch(`/garden-notes?screen=${encodeURIComponent(currentScreenKey)}`);
            const data = await response.json();
            if (data.success) {
                currentNotes = data.notes || [];
                renderNotes(currentNotes);
            }
        } catch (error) {
            console.error('Error al cargar notas del rincón:', error);
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Renderizar notas en la lista con interactividad y filtros
    function renderNotes(notes) {
        const totalCount = notes.length;
        if (notesCountBadge) {
            notesCountBadge.textContent = String(totalCount);
            notesCountBadge.hidden = totalCount === 0;
        }
        if (tabCountEl) {
            tabCountEl.textContent = String(totalCount);
        }

        if (!notesListEl) return;

        // Aplicar filtros de emoción y búsqueda
        const filteredNotes = notes.filter(n => {
            const matchMood = currentMoodFilter === 'all' || n.mood === currentMoodFilter;
            const searchHaystack = `${n.title || ''} ${n.content || ''} ${n.author_name || ''}`.toLowerCase();
            const matchSearch = !searchQuery || searchHaystack.includes(searchQuery);
            return matchMood && matchSearch;
        });

        if (filteredNotes.length === 0) {
            notesListEl.innerHTML = `
                <div class="corner-empty-state">
                    <span class="empty-icon">${totalCount === 0 ? '🌸' : '🔍'}</span>
                    <p>${totalCount === 0 
                        ? 'Aún no hay notas en este rincón.<br>¡Sé la primera en escribir un recuerdo o pensamiento!' 
                        : 'No se encontraron notas que coincidan con este filtro.<br>Intenta con otra emoción o búsqueda.'}
                    </p>
                </div>
            `;
            return;
        }

        notesListEl.innerHTML = filteredNotes.map(note => `
            <article class="corner-note-card ${note.is_pinned ? 'is-pinned' : ''}" data-note-id="${note.id}">
                ${note.is_pinned ? '<span class="corner-note-pinned-badge">✦ DESTACADA</span>' : ''}
                
                <div class="corner-note-meta">
                    <span class="corner-note-mood" data-mood="${note.mood || 'love'}">
                        ${moodIcons[note.mood] || '💌 Nota de Amor'}
                    </span>
                    <time class="corner-note-time">${note.date_formatted}</time>
                </div>

                ${note.title ? `<h3 class="corner-note-title">${escapeHtml(note.title)}</h3>` : ''}
                
                <div class="corner-note-content">${escapeHtml(note.content)}</div>
                
                ${note.image_url ? `
                    <div class="corner-note-image-wrap">
                        <img src="${note.image_url}" alt="Recuerdo de ${escapeHtml(note.author_name)}" class="corner-note-image" loading="lazy">
                        <div class="corner-note-image-glass-border"></div>
                    </div>
                ` : ''}

                <footer class="corner-note-footer">
                    <span class="corner-note-author">— ${escapeHtml(note.author_name)}</span>
                    <div class="corner-note-actions">
                        <button type="button" class="note-btn-action btn-copy" data-copy-note="${note.id}" title="Copiar texto al portapapeles">
                            <span>📋 Copiar</span>
                        </button>
                        <button type="button" class="note-btn-action btn-edit" data-edit-note="${note.id}" title="Editar nota">
                            <span>✏️ Editar</span>
                        </button>
                        <button type="button" class="note-btn-action btn-delete" data-delete-note="${note.id}" title="Eliminar nota">
                            <span>🗑️ Borrar</span>
                        </button>
                    </div>
                </footer>
            </article>
        `).join('');

        // Enganchar botones de copiar, editar y borrar
        notesListEl.querySelectorAll('[data-copy-note]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const noteId = Number(btn.dataset.copyNote);
                const note = currentNotes.find(n => n.id === noteId);
                if (note && note.content) {
                    const text = `${note.title ? note.title + '\n\n' : ''}${note.content}\n\n— ${note.author_name || 'Adrián'}`;
                    navigator.clipboard.writeText(text);
                    btn.innerHTML = '<span>✓ Copiado</span>';
                    playSoftChime(880);
                    setTimeout(() => {
                        btn.innerHTML = '<span>📋 Copiar</span>';
                    }, 2000);
                }
            });
        });

        notesListEl.querySelectorAll('[data-edit-note]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const noteId = Number(btn.dataset.editNote);
                const note = currentNotes.find(n => n.id === noteId);
                if (note) editNote(note);
            });
        });

        notesListEl.querySelectorAll('[data-delete-note]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const noteId = Number(btn.dataset.deleteNote);
                deleteNote(noteId);
            });
        });
    }

    // Editar nota
    function editNote(note) {
        if (!noteForm) {
            alert('Debes iniciar sesión para editar notas.');
            return;
        }
        formIdInput.value = String(note.id);
        formScreenInput.value = note.screen_key;
        document.getElementById('note-title').value = note.title || '';
        document.getElementById('note-mood').value = note.mood || 'love';
        document.getElementById('note-content').value = note.content || '';
        document.getElementById('note-author').value = note.author_name || '';
        document.getElementById('note-pinned').checked = Boolean(note.is_pinned);

        if (note.image_url && imagePreview) {
            const img = imagePreview.querySelector('img');
            if (img) img.src = note.image_url;
            imagePreview.hidden = false;
        }

        const submitBtn = document.getElementById('note-submit-btn');
        if (submitBtn) submitBtn.textContent = 'Actualizar recuerdo';

        switchTab('create');
        playSoftChime(523.25);
    }

    // Eliminar nota
    async function deleteNote(id) {
        if (!confirm('¿Segura que deseas eliminar este recuerdo de este rincón?')) return;
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/garden-notes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (data.success) {
                currentNotes = currentNotes.filter(n => n.id !== id);
                renderNotes(currentNotes);
            } else {
                alert(data.message || 'No se pudo eliminar la nota.');
            }
        } catch (error) {
            console.error('Error al eliminar nota:', error);
        }
    }

    // Enviar formulario (Crear o Actualizar)
    if (noteForm) {
        noteForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('note-submit-btn');
            if (submitBtn) submitBtn.disabled = true;

            const formData = new FormData(noteForm);
            const noteId = formIdInput.value;
            const isEditing = Boolean(noteId);
            const url = isEditing ? `/garden-notes/${noteId}` : '/garden-notes';

            if (isEditing) {
                formData.append('_method', 'PUT');
            }

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    resetForm();
                    switchTab('list');
                    fetchNotesForCurrentScreen();
                    playSoftChime(783.99); // Chime de éxito
                } else {
                    alert(data.message || 'Hubo un error al guardar tu nota.');
                }
            } catch (error) {
                console.error('Error al guardar nota:', error);
                alert('No se pudo guardar la nota.');
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }

    // Enganchar el botón flotante del Dock Derecho y del Dock Inferior
    const bindNotesButton = (btnId) => {
        const btn = document.getElementById(btnId);
        if (btn) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                window.openCornerNotesDrawer();
            });
        }
    };
    bindNotesButton('corner-crud-trigger');
    bindNotesButton('dock-btn-notes');
    bindNotesButton('compass-btn-notes');

    // Escuchar cambios de rincón / hash para refrescar contexto y contador
    window.addEventListener('hashchange', () => {
        currentScreenKey = getActiveScreenKey();
        if (screenNameEl) {
            screenNameEl.textContent = screenFriendlyNames[currentScreenKey] || 'Este Rincón';
        }
        if (formScreenInput) {
            formScreenInput.value = currentScreenKey;
        }
        fetchNotesForCurrentScreen();
    });

    // Escuchar tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !drawer.hidden) {
            drawer.hidden = true;
            resetForm();
        }
    });

    // Cargar conteo inicial de notas
    fetchNotesForCurrentScreen();
}
