// ═══════════════════════════════════════════════════════════════════════
//  SISTEMA GLOBAL DE NOTAS & RECUERDOS CONTEXTUALES (CRUD POR PANTALLA)
// ═══════════════════════════════════════════════════════════════════════

const screenNames = {
    'inicio': 'Inicio & Bienvenida',
    'albumes': 'Álbumes de Recuerdos',
    'lectura': 'Rincón de Lectura',
    'suenos': 'Castillo de Sueños',
    'tesoro': 'Búsqueda del Tesoro',
    'personal': 'Perfil de Carla',
    'entretenimiento': 'Entretenimiento & Música',
    'juegos': 'Jardín de Juegos',
    'jardines-liria': 'Jardín 3D de Sultana',
    'sultana-plataformas': 'Sultana y los Senderos del Alba',
    'conociendo-carla': '¿Cuánto conoces a Carla?',
    'ajustes': 'Ajustes & Preferencias'
};

const moodIcons = {
    'love': '💌 Amor',
    'gratitude': '🌸 Gratitud',
    'dream': '✨ Sueño',
    'memory': '📷 Recuerdo',
    'secret': '🌙 Íntimo'
};

let currentScreenKey = 'inicio';
let currentNotes = [];

export function initializeCornerNotes() {
    const triggerBtn = document.getElementById('corner-crud-trigger');
    const drawer = document.getElementById('corner-crud-drawer');
    const screenNameEl = document.getElementById('drawer-screen-name');
    const notesCountBadge = document.getElementById('corner-notes-count');
    const tabCountEl = document.getElementById('drawer-tab-count');
    const notesListEl = document.getElementById('corner-notes-list');
    const noteForm = document.getElementById('corner-note-form');
    const formScreenInput = document.getElementById('note-form-screen');
    const formIdInput = document.getElementById('note-form-id');
    const imageInput = document.getElementById('note-image');
    const imagePreview = document.getElementById('note-image-preview');
    const removeImageBtn = document.getElementById('note-remove-image-btn');
    const cancelBtn = document.getElementById('note-cancel-btn');

    if (!triggerBtn || !drawer) return;

    // Detectar pantalla actual
    const updateActiveScreen = () => {
        const hash = window.location.hash.replace('#', '') || 'inicio';
        currentScreenKey = hash;
        if (screenNameEl) {
            screenNameEl.textContent = screenNames[hash] || hash;
        }
        if (formScreenInput) {
            formScreenInput.value = hash;
        }
        fetchNotesForCurrentScreen();
    };

    // Abrir drawer
    triggerBtn.addEventListener('click', () => {
        drawer.hidden = false;
        fetchNotesForCurrentScreen();
    });

    // Cerrar drawer
    drawer.querySelectorAll('[data-drawer-close]').forEach((el) => {
        el.addEventListener('click', () => {
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
            if (target === 'list') {
                if (listPane) listPane.hidden = false;
                if (formPane) formPane.hidden = true;
            } else {
                if (listPane) listPane.hidden = true;
                if (formPane) formPane.hidden = false;
            }
        });
    });

    // Cambiar pestañas programáticamente
    const switchTab = (tabName) => {
        const targetTab = drawer.querySelector(`[data-drawer-tab="${tabName}"]`);
        if (targetTab) targetTab.click();
    };

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

    // Renderizar notas en la lista
    function renderNotes(notes) {
        const count = notes.length;
        if (notesCountBadge) {
            notesCountBadge.textContent = String(count);
            notesCountBadge.hidden = count === 0;
        }
        if (tabCountEl) {
            tabCountEl.textContent = String(count);
        }

        if (!notesListEl) return;

        if (count === 0) {
            notesListEl.innerHTML = `
                <div class="corner-empty-state">
                    <span class="empty-icon">🌸</span>
                    <p>Aún no hay notas en este rincón.<br>¡Sé la primera en escribir un recuerdo o pensamiento!</p>
                </div>
            `;
            return;
        }

        notesListEl.innerHTML = notes.map(note => `
            <article class="corner-note-card ${note.is_pinned ? 'is-pinned' : ''}" data-note-id="${note.id}">
                ${note.is_pinned ? '<span class="corner-note-pinned-badge">✦ DESTACADA</span>' : ''}
                <div class="corner-note-meta">
                    <span class="corner-note-mood">${moodIcons[note.mood] || '💌 Nota'}</span>
                    <time>${note.date_formatted}</time>
                </div>
                ${note.title ? `<h3 class="corner-note-title">${escapeHtml(note.title)}</h3>` : ''}
                <div class="corner-note-content">${escapeHtml(note.content)}</div>
                ${note.image_url ? `<img src="${note.image_url}" alt="Recuerdo de ${escapeHtml(note.author_name)}" class="corner-note-image" loading="lazy">` : ''}
                <footer class="corner-note-footer">
                    <span class="corner-note-author">— ${escapeHtml(note.author_name)}</span>
                    <div class="corner-note-actions">
                        <button type="button" class="note-btn-action btn-edit" data-edit-note="${note.id}" title="Editar nota">✏️ Editar</button>
                        <button type="button" class="note-btn-action btn-delete" data-delete-note="${note.id}" title="Eliminar nota">🗑️ Borrar</button>
                    </div>
                </footer>
            </article>
        `).join('');

        // Enganchar botones de editar y borrar
        notesListEl.querySelectorAll('[data-edit-note]').forEach(btn => {
            btn.addEventListener('click', () => {
                const noteId = Number(btn.dataset.editNote);
                const note = currentNotes.find(n => n.id === noteId);
                if (note) editNote(note);
            });
        });

        notesListEl.querySelectorAll('[data-delete-note]').forEach(btn => {
            btn.addEventListener('click', () => {
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
                fetchNotesForCurrentScreen();
            } else {
                alert(data.message || 'No se pudo eliminar la nota.');
            }
        } catch (e) {
            console.error('Error eliminando nota:', e);
            alert('Error al intentar eliminar. Por favor verifica si tu sesión está activa.');
        }
    }

    // Guardar (Crear o Actualizar)
    if (noteForm) {
        noteForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('note-submit-btn');
            if (submitBtn) submitBtn.disabled = true;

            const noteId = formIdInput.value;
            const isEditing = Boolean(noteId);
            const url = isEditing ? `/garden-notes/${noteId}` : '/garden-notes';

            const formData = new FormData(noteForm);
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
                } else {
                    alert(data.message || 'Ocurrió un error al guardar.');
                }
            } catch (err) {
                console.error('Error al guardar nota:', err);
                alert('No se pudo guardar. Revisa que tu sesión esté activa y los campos sean válidos.');
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }

    // Escuchar cambios de hash para actualizar contexto
    window.addEventListener('hashchange', updateActiveScreen);
    window.addEventListener('popstate', updateActiveScreen);

    // Inicialización al cargar
    updateActiveScreen();
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
