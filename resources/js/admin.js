// ═══════════════════════════════════════════════════════════════════════
//  SISTEMA ADMINISTRATIVO GLOBAL — EL JARDÍN DE CARLA LORENA
//  Interactividad completa, modales elegantes, CRUD reactivo y feedback tierno
// ═══════════════════════════════════════════════════════════════════════

export function initializeAdminSystem() {
    const adminScreen = document.querySelector('[data-screen="admin"]');
    if (!adminScreen) return;

    const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // ── Notificaciones Toast Dulces ──
    function notify(message, isError = false) {
        let toastEl = document.getElementById('admin-toast');
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.id = 'admin-toast';
            toastEl.className = 'admin-toast';
            document.body.appendChild(toastEl);
        }
        toastEl.textContent = message;
        toastEl.className = `admin-toast show ${isError ? 'is-error' : 'is-success'}`;
        clearTimeout(toastEl._timer);
        toastEl._timer = setTimeout(() => {
            toastEl.className = 'admin-toast';
        }, 4000);
    }

    // ── Contenedor de Modales ──
    const modalContainer = document.getElementById('admin-modal-container');
    const modalTitle = document.getElementById('admin-modal-title');
    const modalBody = document.getElementById('admin-modal-body');
    const modalCloseBtn = document.getElementById('admin-modal-close');

    function openModal(title, contentHtml) {
        if (!modalContainer) return;
        modalTitle.textContent = title;
        modalBody.innerHTML = contentHtml;
        modalContainer.hidden = false;
        modalContainer.classList.add('is-open');
    }

    function closeModal() {
        if (!modalContainer) return;
        modalContainer.hidden = true;
        modalContainer.classList.remove('is-open');
        modalBody.innerHTML = '';
    }

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    modalContainer?.addEventListener('click', (e) => {
        if (e.target === modalContainer || e.target.hasAttribute('data-modal-backdrop')) closeModal();
    });

    // ── Helper para peticiones Fetch JSON ──
    async function apiRequest(url, method = 'GET', body = null) {
        const headers = {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        };
        const options = { method, headers };

        if (body) {
            if (body instanceof FormData) {
                options.body = body;
            } else {
                headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(body);
            }
        }

        try {
            const res = await fetch(url, options);
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error en la operación');
                throw new Error(errorMsg);
            }
            return data;
        } catch (err) {
            notify(`✕ ${err.message}`, true);
            throw err;
        }
    }

    // ── 1. USUARIOS ──
    async function loadUsers(page = 1) {
        const tbody = document.querySelector('#admin-users-table tbody');
        const pagination = document.getElementById('admin-users-pagination');
        if (!tbody) return;
        tbody.innerHTML = `<tr><td colspan="6" class="admin-table-loading">Cargando miembros con cariño… 🌸</td></tr>`;

        try {
            const data = await apiRequest(`/admin/users?page=${page}`);
            const users = data.users?.data || [];
            if (users.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="admin-table-empty">No hay miembros registrados aún.</td></tr>`;
                return;
            }

            tbody.innerHTML = users.map(user => `
                <tr>
                    <td><strong>#${user.id}</strong></td>
                    <td><strong>${escapeHtml(user.name)}</strong></td>
                    <td>${escapeHtml(user.email)}</td>
                    <td>
                        <button class="ap-badge-toggle ${user.is_admin ? 'is-active' : ''}" data-toggle-admin="${user.id}" title="${user.is_admin ? 'Quitar privilegios' : 'Hacer administrador'}">
                            ${user.is_admin ? '👑 Administrador' : '✦ Miembro'}
                        </button>
                    </td>
                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="table-actions">
                            <button class="ap-action-btn edit" data-edit-user='${JSON.stringify(user)}' title="Editar usuario">✏️</button>
                            ${user.id !== 1 ? `<button class="ap-action-btn delete" data-delete-user="${user.id}" title="Eliminar usuario">🗑️</button>` : ''}
                        </div>
                    </td>
                </tr>
            `).join('');

            renderPagination(pagination, data.users, loadUsers);
            attachUserEvents();
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="6" class="admin-table-empty">Error al cargar usuarios.</td></tr>`;
        }
    }

    function attachUserEvents() {
        document.querySelectorAll('[data-toggle-admin]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.toggleAdmin;
                try {
                    await apiRequest(`/admin/users/${id}/toggle-admin`, 'POST');
                    notify('Rol de usuario actualizado con éxito 🌸');
                    loadUsers();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-delete-user]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.deleteUser;
                if (!confirm('¿Segura que deseas eliminar este usuario del jardín?')) return;
                try {
                    await apiRequest(`/admin/users/${id}`, 'DELETE');
                    notify('Usuario eliminado del jardín');
                    loadUsers();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-edit-user]').forEach(btn => {
            btn.onclick = () => {
                const user = JSON.parse(btn.dataset.editUser);
                openUserModal(user);
            };
        });
    }

    function openUserModal(user = null) {
        const isEdit = Boolean(user);
        const title = isEdit ? 'Editar Usuario del Jardín' : 'Nuevo Miembro del Jardín';
        const html = `
            <form id="admin-user-modal-form" class="ap-form">
                <div class="ap-field">
                    <label class="ap-label">Nombre Completo</label>
                    <input class="ap-input" type="text" name="name" required value="${isEdit ? escapeHtml(user.name) : ''}" placeholder="Ej. Carla Lorena">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Correo Electrónico</label>
                    <input class="ap-input" type="email" name="email" required value="${isEdit ? escapeHtml(user.email) : ''}" placeholder="ejemplo@jardindecarla.com">
                </div>
                <div class="ap-field">
                    <label class="ap-label">${isEdit ? 'Nueva Contraseña (dejar en blanco para conservar)' : 'Contraseña'}</label>
                    <input class="ap-input" type="password" name="password" ${isEdit ? '' : 'required'} minlength="8" placeholder="Mínimo 8 caracteres">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Confirmar Contraseña</label>
                    <input class="ap-input" type="password" name="password_confirmation" ${isEdit ? '' : 'required'} minlength="8" placeholder="Repite la contraseña">
                </div>
                <div class="ap-actions">
                    <button class="ap-btn-primary" type="submit">${isEdit ? '💾 Guardar Cambios' : '🌸 Crear Miembro'}</button>
                    <button class="ap-btn-outline" type="button" data-modal-close>Cancelar</button>
                </div>
            </form>
        `;
        openModal(title, html);

        const form = document.getElementById('admin-user-modal-form');
        form.querySelector('[data-modal-close]').onclick = closeModal;
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());
            if (isEdit && !payload.password) {
                delete payload.password;
                delete payload.password_confirmation;
            }

            try {
                if (isEdit) {
                    await apiRequest(`/admin/users/${user.id}`, 'PUT', payload);
                    notify('Usuario actualizado con éxito 🌸');
                } else {
                    await apiRequest('/admin/users', 'POST', payload);
                    notify('Nuevo usuario añadido al jardín 🌸');
                }
                closeModal();
                loadUsers();
            } catch (_) {}
        };
    }

    // ── 2. PERFIL PÚBLICO ──
    async function loadProfile() {
        try {
            const data = await apiRequest('/admin/profile');
            const profile = data.profile;
            if (!profile) return;

            const form = document.getElementById('admin-profile-form');
            if (!form) return;

            form.profession.value = profile.profession || '';
            form.biography.value = profile.biography || '';
            form.education.value = profile.education || '';
            form.experience.value = profile.experience || '';
            form.achievements.value = profile.achievements || '';
            form.interests.value = profile.interests || '';
            form.additional_info.value = profile.additional_info || '';

            const preview = document.getElementById('admin-profile-photo-preview');
            const deletePhotoBtn = document.getElementById('admin-profile-delete-photo');
            if (profile.featured_photo_path && preview) {
                preview.innerHTML = `<img src="/storage/${profile.featured_photo_path}" alt="Foto de Carla" style="max-height: 180px; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.1);">`;
                preview.hidden = false;
                if (deletePhotoBtn) deletePhotoBtn.hidden = false;
            } else if (preview) {
                preview.hidden = true;
                if (deletePhotoBtn) deletePhotoBtn.hidden = true;
            }

            const publishBtn = document.getElementById('admin-profile-publish');
            const unpublishBtn = document.getElementById('admin-profile-unpublish');
            if (publishBtn && unpublishBtn) {
                const isPublished = profile.status === 'published';
                publishBtn.hidden = isPublished;
                unpublishBtn.hidden = !isPublished;
            }
        } catch (_) {}
    }

    const profileForm = document.getElementById('admin-profile-form');
    if (profileForm) {
        profileForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(profileForm);
            const payload = {
                profession: formData.get('profession'),
                biography: formData.get('biography'),
                education: formData.get('education'),
                experience: formData.get('experience'),
                achievements: formData.get('achievements'),
                interests: formData.get('interests'),
                additional_info: formData.get('additional_info')
            };

            try {
                await apiRequest('/admin/profile', 'PUT', payload);

                // Si seleccionó foto, subirla
                const photoInput = document.getElementById('admin-profile-photo');
                if (photoInput && photoInput.files.length > 0) {
                    const photoData = new FormData();
                    photoData.append('featured_photo', photoInput.files[0]);
                    await apiRequest('/admin/profile/photo', 'POST', photoData);
                }

                notify('Perfil de Carla Lorena guardado con cariño 🌸');
                loadProfile();
            } catch (_) {}
        };

        document.getElementById('admin-profile-publish')?.addEventListener('click', async () => {
            try {
                await apiRequest('/admin/profile/publish', 'POST');
                notify('✦ Perfil publicado para todo el jardín');
                loadProfile();
            } catch (_) {}
        });

        document.getElementById('admin-profile-unpublish')?.addEventListener('click', async () => {
            try {
                await apiRequest('/admin/profile/unpublish', 'POST');
                notify('Perfil puesto en borrador');
                loadProfile();
            } catch (_) {}
        });

        document.getElementById('admin-profile-delete-photo')?.addEventListener('click', async () => {
            if (!confirm('¿Deseas quitar la fotografía destacada?')) return;
            try {
                await apiRequest('/admin/profile/photo', 'DELETE');
                notify('Fotografía retirada');
                loadProfile();
            } catch (_) {}
        });
    }

    // ── 3. PUBLICACIONES & DIARIO ──
    async function loadPosts(page = 1) {
        const tbody = document.querySelector('#admin-posts-table tbody');
        const pagination = document.getElementById('admin-posts-pagination');
        if (!tbody) return;

        const kind = document.getElementById('admin-posts-kind')?.value || '';
        const status = document.getElementById('admin-posts-status')?.value || '';
        const search = document.getElementById('admin-posts-search')?.value || '';

        tbody.innerHTML = `<tr><td colspan="7" class="admin-table-loading">Buscando publicaciones… ✍️</td></tr>`;

        try {
            const url = `/admin/posts?page=${page}&kind=${encodeURIComponent(kind)}&status=${encodeURIComponent(status)}&search=${encodeURIComponent(search)}`;
            const data = await apiRequest(url);
            const posts = data.posts?.data || [];

            if (posts.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="admin-table-empty">No hay publicaciones encontradas.</td></tr>`;
                return;
            }

            tbody.innerHTML = posts.map(post => `
                <tr>
                    <td><strong>#${post.id}</strong></td>
                    <td><span class="ap-badge-kind ${post.kind}">${post.kind === 'diary' ? '📔 Diario' : '📝 Blog'}</span></td>
                    <td><strong>${escapeHtml(post.title)}</strong></td>
                    <td>${escapeHtml(post.category || 'General')}</td>
                    <td>
                        <button class="ap-badge-toggle ${post.status === 'published' ? 'is-active' : ''}" data-toggle-post="${post.id}" data-current-status="${post.status}">
                            ${post.status === 'published' ? '✦ Publicado' : '✏️ Borrador'}
                        </button>
                    </td>
                    <td>${new Date(post.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="table-actions">
                            <button class="ap-action-btn edit" data-edit-post='${JSON.stringify(post)}' title="Editar">✏️</button>
                            <button class="ap-action-btn delete" data-delete-post="${post.id}" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            renderPagination(pagination, data.posts, loadPosts);
            attachPostEvents();
        } catch (_) {
            tbody.innerHTML = `<tr><td colspan="7" class="admin-table-empty">Error al cargar publicaciones.</td></tr>`;
        }
    }

    function attachPostEvents() {
        document.querySelectorAll('[data-toggle-post]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.togglePost;
                const currentStatus = btn.dataset.currentStatus;
                const endpoint = currentStatus === 'published' ? `/admin/posts/${id}/unpublish` : `/admin/posts/${id}/publish`;
                try {
                    await apiRequest(endpoint, 'POST');
                    notify('Estado de la publicación actualizado 🌸');
                    loadPosts();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-delete-post]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.deletePost;
                if (!confirm('¿Segura que deseas eliminar esta publicación?')) return;
                try {
                    await apiRequest(`/admin/posts/${id}`, 'DELETE');
                    notify('Publicación eliminada');
                    loadPosts();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-edit-post]').forEach(btn => {
            btn.onclick = () => {
                const post = JSON.parse(btn.dataset.editPost);
                openPostModal(post);
            };
        });
    }

    function openPostModal(post = null) {
        const isEdit = Boolean(post);
        const title = isEdit ? 'Editar Publicación' : 'Nueva Publicación o Entrada de Diario';
        const html = `
            <form id="admin-post-modal-form" class="ap-form">
                <div class="ap-field">
                    <label class="ap-label">Tipo de entrada</label>
                    <select class="ap-select" name="kind" required ${isEdit ? 'disabled' : ''}>
                        <option value="blog" ${isEdit && post.kind === 'blog' ? 'selected' : ''}>📝 Blog Público</option>
                        <option value="diary" ${isEdit && post.kind === 'diary' ? 'selected' : ''}>📔 Diario Íntimo</option>
                    </select>
                </div>
                <div class="ap-field">
                    <label class="ap-label">Título</label>
                    <input class="ap-input" type="text" name="title" required maxlength="160" value="${isEdit ? escapeHtml(post.title) : ''}" placeholder="Título romántico e inspirador…">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Categoría</label>
                    <input class="ap-input" type="text" name="category" maxlength="80" value="${isEdit ? escapeHtml(post.category || '') : ''}" placeholder="Ej. Poesía, Reflexiones, Recuerdos…">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Extracto breve</label>
                    <input class="ap-input" type="text" name="excerpt" maxlength="500" value="${isEdit ? escapeHtml(post.excerpt || '') : ''}" placeholder="Una frase o resumen para cautivar al lector…">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Contenido completo</label>
                    <textarea class="ap-textarea" name="body" required rows="6" maxlength="30000" placeholder="Escribe aquí con libertad y belleza…">${isEdit ? escapeHtml(post.body) : ''}</textarea>
                </div>
                <div class="ap-field">
                    <label class="ap-label">Estado inicial</label>
                    <select class="ap-select" name="status" required>
                        <option value="published" ${isEdit && post.status === 'published' ? 'selected' : ''}>✦ Publicado de inmediato</option>
                        <option value="draft" ${isEdit && post.status === 'draft' ? 'selected' : ''}>✏️ Guardar como Borrador</option>
                    </select>
                </div>
                <div class="ap-actions">
                    <button class="ap-btn-primary" type="submit">${isEdit ? '💾 Guardar Cambios' : '🌸 Publicar'}</button>
                    <button class="ap-btn-outline" type="button" data-modal-close>Cancelar</button>
                </div>
            </form>
        `;
        openModal(title, html);

        const form = document.getElementById('admin-post-modal-form');
        form.querySelector('[data-modal-close]').onclick = closeModal;
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());

            try {
                if (isEdit) {
                    await apiRequest(`/admin/posts/${post.id}`, 'PUT', payload);
                    notify('Publicación actualizada con éxito 🌸');
                } else {
                    await apiRequest('/admin/posts', 'POST', payload);
                    notify('¡Nueva publicación creada en el jardín! 🌸');
                }
                closeModal();
                loadPosts();
            } catch (_) {}
        };
    }

    document.getElementById('admin-posts-kind')?.addEventListener('change', () => loadPosts(1));
    document.getElementById('admin-posts-status')?.addEventListener('change', () => loadPosts(1));
    document.getElementById('admin-posts-search')?.addEventListener('input', debounce(() => loadPosts(1), 350));

    // ── 4. QUIZ «CONOCIENDO A CARLA» ──
    async function loadQuizData() {
        // Cargar configuración y recompensa
        try {
            const data = await apiRequest('/admin/quiz-settings');
            const settings = data.settings || {};
            const form = document.getElementById('admin-quiz-settings-form');
            if (form) {
                if (settings.rate_limit_attempts) form.rate_limit_attempts.value = settings.rate_limit_attempts;
                if (settings.rate_limit_window) form.rate_limit_window.value = settings.rate_limit_window;
                if (settings.questions_required) form.questions_required.value = settings.questions_required;
            }

            const preview = document.getElementById('admin-quiz-reward-preview');
            const deleteBtn = document.getElementById('admin-quiz-reward-delete');
            if (settings.reward_image_path && preview) {
                preview.innerHTML = `<img src="/storage/${settings.reward_image_path}" alt="Recompensa Quiz" style="max-height: 160px; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.1);">`;
                preview.hidden = false;
                if (deleteBtn) deleteBtn.hidden = false;
            } else if (preview) {
                preview.hidden = true;
                if (deleteBtn) deleteBtn.hidden = true;
            }
        } catch (_) {}

        // Cargar preguntas
        loadQuizQuestions();
    }

    async function loadQuizQuestions() {
        const tbody = document.querySelector('#admin-quiz-questions-table tbody');
        if (!tbody) return;
        tbody.innerHTML = `<tr><td colspan="5" class="admin-table-loading">Cargando preguntas de amor… 🧩</td></tr>`;

        try {
            const data = await apiRequest('/admin/quiz-questions');
            const questions = data.questions || [];
            if (questions.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="admin-table-empty">No hay preguntas creadas aún. Añade la primera con el botón de arriba.</td></tr>`;
                return;
            }

            tbody.innerHTML = questions.map(q => `
                <tr>
                    <td><strong>#${q.id}</strong></td>
                    <td><strong>${escapeHtml(q.question)}</strong></td>
                    <td><span class="ap-badge-count">${(q.answer_hashes || []).length} respuestas válidas</span></td>
                    <td>
                        <button class="ap-badge-toggle ${q.is_active ? 'is-active' : ''}" data-toggle-quiz-q="${q.id}">
                            ${q.is_active ? '✦ Activa' : 'Desactivada'}
                        </button>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="ap-action-btn edit" data-edit-quiz-q='${JSON.stringify(q)}' title="Editar">✏️</button>
                            <button class="ap-action-btn delete" data-delete-quiz-q="${q.id}" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            attachQuizQuestionEvents();
        } catch (_) {
            tbody.innerHTML = `<tr><td colspan="5" class="admin-table-empty">Error al cargar preguntas.</td></tr>`;
        }
    }

    function attachQuizQuestionEvents() {
        document.querySelectorAll('[data-toggle-quiz-q]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.toggleQuizQ;
                try {
                    await apiRequest(`/admin/quiz-questions/${id}/toggle`, 'POST');
                    notify('Estado de pregunta actualizado 🌸');
                    loadQuizQuestions();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-delete-quiz-q]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.deleteQuizQ;
                if (!confirm('¿Segura que deseas eliminar esta pregunta del quiz?')) return;
                try {
                    await apiRequest(`/admin/quiz-questions/${id}`, 'DELETE');
                    notify('Pregunta eliminada');
                    loadQuizQuestions();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-edit-quiz-q]').forEach(btn => {
            btn.onclick = () => {
                const q = JSON.parse(btn.dataset.editQuizQ);
                openQuizQuestionModal(q);
            };
        });
    }

    function openQuizQuestionModal(q = null) {
        const isEdit = Boolean(q);
        const title = isEdit ? 'Editar Pregunta del Quiz' : 'Añadir Pregunta sobre Carla Lorena';
        const html = `
            <form id="admin-quiz-q-form" class="ap-form">
                <div class="ap-field">
                    <label class="ap-label">Pregunta</label>
                    <input class="ap-input" type="text" name="question" required maxlength="500" value="${isEdit ? escapeHtml(q.question) : ''}" placeholder="¿Cuál es el postre o flor favorita de Carla?">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Variantes de respuesta correcta (separadas por coma o saltos)</label>
                    <textarea class="ap-textarea" name="variants" required rows="3" placeholder="Ej: Tulipán, tulipanes, Tulipan, TULIPANES">${isEdit ? 'Conservar respuestas actuales (o escribe nuevas aquí)' : ''}</textarea>
                    <p class="ap-file-hint">Permite admitir tildes, plurales y mayúsculas sin penalizar al jugador.</p>
                </div>
                <div class="ap-field ap-consent-field">
                    <label class="ap-consent-label">
                        <input type="checkbox" name="is_active" value="1" ${isEdit ? (q.is_active ? 'checked' : '') : 'checked'}>
                        <span>Pregunta activa en el quiz</span>
                    </label>
                </div>
                <div class="ap-actions">
                    <button class="ap-btn-primary" type="submit">${isEdit ? '💾 Guardar Cambios' : '🌸 Añadir Pregunta'}</button>
                    <button class="ap-btn-outline" type="button" data-modal-close>Cancelar</button>
                </div>
            </form>
        `;
        openModal(title, html);

        const form = document.getElementById('admin-quiz-q-form');
        form.querySelector('[data-modal-close]').onclick = closeModal;
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const rawVariants = formData.get('variants');
            const variants = rawVariants.split(/[\n,]+/).map(v => v.trim()).filter(Boolean);

            const payload = {
                question: formData.get('question'),
                is_active: formData.get('is_active') === '1'
            };
            if (variants.length > 0 && variants[0] !== 'Conservar respuestas actuales (o escribe nuevas aquí)') {
                payload.answer_variants = variants;
            }

            try {
                if (isEdit) {
                    await apiRequest(`/admin/quiz-questions/${q.id}`, 'PUT', payload);
                    notify('Pregunta actualizada con éxito 🌸');
                } else {
                    if (!payload.answer_variants || payload.answer_variants.length === 0) {
                        notify('Debes ingresar al menos una respuesta válida', true);
                        return;
                    }
                    await apiRequest('/admin/quiz-questions', 'POST', payload);
                    notify('Pregunta añadida al quiz 🌸');
                }
                closeModal();
                loadQuizQuestions();
            } catch (_) {}
        };
    }

    const quizSettingsForm = document.getElementById('admin-quiz-settings-form');
    if (quizSettingsForm) {
        quizSettingsForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(quizSettingsForm);
            const payload = {
                rate_limit_attempts: Number(formData.get('rate_limit_attempts')),
                rate_limit_window: Number(formData.get('rate_limit_window')),
                questions_required: Number(formData.get('questions_required'))
            };
            try {
                await apiRequest('/admin/quiz-settings', 'PUT', payload);
                notify('Configuración del quiz guardada con éxito 🌸');
            } catch (_) {}
        };
    }

    const quizRewardForm = document.getElementById('admin-quiz-reward-form');
    if (quizRewardForm) {
        quizRewardForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(quizRewardForm);
            try {
                await apiRequest('/admin/quiz-reward', 'POST', formData);
                notify('🌸 Foto de recompensa subida con éxito');
                loadQuizData();
            } catch (_) {}
        };

        document.getElementById('admin-quiz-reward-delete')?.addEventListener('click', async () => {
            if (!confirm('¿Deseas retirar la fotografía de recompensa del quiz?')) return;
            try {
                await apiRequest('/admin/quiz-reward', 'DELETE');
                notify('Foto de recompensa retirada');
                loadQuizData();
            } catch (_) {}
        });
    }

    // ── 5. ÁLBUMES DE FOTOGRAFÍAS ──
    async function loadAlbums() {
        const list = document.getElementById('admin-albums-list');
        if (!list) return;
        list.innerHTML = `<div class="admin-table-loading">Cargando álbumes de recuerdos… 📸</div>`;

        try {
            const data = await apiRequest('/admin/albums');
            const albums = data.albums?.data || [];

            if (albums.length === 0) {
                list.innerHTML = `
                    <div class="admin-empty-state">
                        <span class="empty-icon">📸</span>
                        <h3>No hay álbumes creados aún</h3>
                        <p>Crea el primer álbum para atesorar los momentos más hermosos de Carla.</p>
                        <button class="ap-cta-btn" type="button" data-admin-modal="album-create">＋ Nuevo álbum</button>
                    </div>
                `;
                list.querySelector('[data-admin-modal="album-create"]')?.addEventListener('click', () => openAlbumModal());
                return;
            }

            list.innerHTML = albums.map(album => `
                <div class="ap-album-card">
                    <div class="ap-album-card-header">
                        <div>
                            <h3 class="ap-album-title">📁 ${escapeHtml(album.title)}</h3>
                            <p class="ap-album-desc">${escapeHtml(album.description || 'Sin descripción')}</p>
                        </div>
                        <span class="ap-badge-count">${album.photos_count || 0} fotos</span>
                    </div>
                    <div class="ap-album-actions">
                        <button class="ap-btn-outline" data-manage-album="${album.id}">🖼️ Gestionar Fotos</button>
                        <button class="ap-action-btn edit" data-edit-album='${JSON.stringify(album)}'>✏️</button>
                        <button class="ap-action-btn delete" data-delete-album="${album.id}">🗑️</button>
                    </div>
                </div>
            `).join('');

            attachAlbumEvents();
        } catch (_) {
            list.innerHTML = `<div class="admin-table-empty">Error al cargar álbumes.</div>`;
        }
    }

    function attachAlbumEvents() {
        document.querySelectorAll('[data-delete-album]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.deleteAlbum;
                if (!confirm('¿Segura que deseas eliminar este álbum y todas sus fotos?')) return;
                try {
                    await apiRequest(`/admin/albums/${id}`, 'DELETE');
                    notify('Álbum eliminado');
                    loadAlbums();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-edit-album]').forEach(btn => {
            btn.onclick = () => {
                const album = JSON.parse(btn.dataset.editAlbum);
                openAlbumModal(album);
            };
        });

        document.querySelectorAll('[data-manage-album]').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.manageAlbum;
                openAlbumPhotosModal(id);
            };
        });
    }

    function openAlbumModal(album = null) {
        const isEdit = Boolean(album);
        const title = isEdit ? 'Editar Álbum' : 'Nuevo Álbum de Recuerdos';
        const html = `
            <form id="admin-album-form" class="ap-form">
                <div class="ap-field">
                    <label class="ap-label">Título del álbum</label>
                    <input class="ap-input" type="text" name="title" required maxlength="120" value="${isEdit ? escapeHtml(album.title) : ''}" placeholder="Ej. Sonrisas de Primavera, Viajes…">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Descripción o dedicatoria</label>
                    <textarea class="ap-textarea" name="description" rows="3" maxlength="4000" placeholder="Unas palabras para acompañar esta colección…">${isEdit ? escapeHtml(album.description || '') : ''}</textarea>
                </div>
                <div class="ap-actions">
                    <button class="ap-btn-primary" type="submit">${isEdit ? '💾 Guardar Cambios' : '🌸 Crear Álbum'}</button>
                    <button class="ap-btn-outline" type="button" data-modal-close>Cancelar</button>
                </div>
            </form>
        `;
        openModal(title, html);

        const form = document.getElementById('admin-album-form');
        form.querySelector('[data-modal-close]').onclick = closeModal;
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());

            try {
                if (isEdit) {
                    await apiRequest(`/admin/albums/${album.id}`, 'PUT', payload);
                    notify('Álbum actualizado 🌸');
                } else {
                    await apiRequest('/admin/albums', 'POST', payload);
                    notify('¡Nuevo álbum creado con cariño! 🌸');
                }
                closeModal();
                loadAlbums();
            } catch (_) {}
        };
    }

    async function openAlbumPhotosModal(albumId) {
        const title = 'Fotografías del Álbum';
        const html = `
            <div class="album-photos-manager">
                <form id="admin-add-photo-form" class="ap-form ap-file-field" enctype="multipart/form-data">
                    <h4 style="margin: 0 0 10px; font-family: var(--serif-editorial);">＋ Añadir Foto al Álbum</h4>
                    <div class="ap-field">
                        <label class="ap-label">Título de la foto</label>
                        <input class="ap-input" type="text" name="title" required placeholder="Ej. Atardecer juntos">
                    </div>
                    <div class="ap-field">
                        <label class="ap-label">Archivo de imagen</label>
                        <input class="ap-file-input" type="file" name="photo" accept="image/*" required>
                    </div>
                    <div class="ap-actions" style="margin-top: 10px; padding-top: 10px;">
                        <button class="ap-btn-primary" type="submit">🌸 Subir Fotografía</button>
                    </div>
                </form>
                <div class="ap-divider"><span>✿</span></div>
                <div id="album-photos-grid" class="album-photos-grid">Cargando fotos…</div>
            </div>
        `;
        openModal(title, html);

        const grid = document.getElementById('album-photos-grid');
        async function loadPhotos() {
            try {
                const data = await apiRequest(`/admin/albums/${albumId}/photos`);
                const photos = data.photos?.data || [];
                if (photos.length === 0) {
                    grid.innerHTML = `<p class="admin-table-empty">Este álbum aún no tiene fotos. ¡Sube la primera!</p>`;
                    return;
                }
                grid.innerHTML = photos.map(photo => `
                    <div class="photo-card-item">
                        <img src="/storage/${photo.path}" alt="${escapeHtml(photo.title)}">
                        <div class="photo-info">
                            <strong>${escapeHtml(photo.title)}</strong>
                            <div class="photo-actions">
                                <button class="fav-btn ${photo.is_favorite ? 'is-fav' : ''}" data-fav-photo="${photo.id}">${photo.is_favorite ? '❤️ Favorita' : '🤍'}</button>
                                <button class="del-btn" data-del-photo="${photo.id}">🗑️</button>
                            </div>
                        </div>
                    </div>
                `).join('');

                grid.querySelectorAll('[data-fav-photo]').forEach(b => {
                    b.onclick = async () => {
                        await apiRequest(`/admin/photos/${b.dataset.favPhoto}/favorite`, 'POST');
                        loadPhotos();
                    };
                });

                grid.querySelectorAll('[data-del-photo]').forEach(b => {
                    b.onclick = async () => {
                        if (!confirm('¿Eliminar esta foto del álbum?')) return;
                        await apiRequest(`/admin/albums/${albumId}/photos/${b.dataset.delPhoto}`, 'DELETE');
                        notify('Foto eliminada');
                        loadPhotos();
                        loadAlbums();
                    };
                });
            } catch (_) {
                grid.innerHTML = `<p class="admin-table-empty">Error al cargar fotos.</p>`;
            }
        }

        loadPhotos();

        const form = document.getElementById('admin-add-photo-form');
        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            try {
                await apiRequest(`/admin/albums/${albumId}/photos`, 'POST', formData);
                notify('🌸 Foto añadida al álbum');
                form.reset();
                loadPhotos();
                loadAlbums();
            } catch (_) {}
        };
    }

    // ── 6. MEDIA & AUDIS/VIDEOS ──
    async function loadMedia(page = 1) {
        const tbody = document.querySelector('#admin-media-table tbody');
        const pagination = document.getElementById('admin-media-pagination');
        if (!tbody) return;

        const sourceType = document.getElementById('admin-media-source')?.value || '';
        const mediaType = document.getElementById('admin-media-type')?.value || '';

        tbody.innerHTML = `<tr><td colspan="7" class="admin-table-loading">Cargando archivos multimedia… 🎵</td></tr>`;

        try {
            const url = `/admin/media?page=${page}&source_type=${encodeURIComponent(sourceType)}&media_type=${encodeURIComponent(mediaType)}`;
            const data = await apiRequest(url);
            const mediaList = data.media?.data || [];

            if (mediaList.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="admin-table-empty">No hay archivos multimedia encontrados.</td></tr>`;
                return;
            }

            tbody.innerHTML = mediaList.map(m => `
                <tr>
                    <td><strong>#${m.id}</strong></td>
                    <td><span class="ap-badge-kind ${m.source_type}">${m.source_type}</span></td>
                    <td>${m.media_type === 'video' ? '🎬 Video' : '🎵 Audio'}</td>
                    <td><strong>${escapeHtml(m.title)}</strong></td>
                    <td>${m.file_size ? `${(m.file_size / (1024 * 1024)).toFixed(1)} MB` : 'Enlace'}</td>
                    <td>${new Date(m.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="table-actions">
                            <button class="ap-action-btn edit" data-edit-media='${JSON.stringify(m)}' title="Editar">✏️</button>
                            <button class="ap-action-btn delete" data-delete-media="${m.id}" title="Eliminar">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('');

            renderPagination(pagination, data.media, loadMedia);
            attachMediaEvents();
        } catch (_) {
            tbody.innerHTML = `<tr><td colspan="7" class="admin-table-empty">Error al cargar media.</td></tr>`;
        }
    }

    function attachMediaEvents() {
        document.querySelectorAll('[data-delete-media]').forEach(btn => {
            btn.onclick = async () => {
                const id = btn.dataset.deleteMedia;
                if (!confirm('¿Segura que deseas eliminar este archivo multimedia?')) return;
                try {
                    await apiRequest(`/admin/media/${id}`, 'DELETE');
                    notify('Archivo multimedia eliminado');
                    loadMedia();
                } catch (_) {}
            };
        });

        document.querySelectorAll('[data-edit-media]').forEach(btn => {
            btn.onclick = () => {
                const media = JSON.parse(btn.dataset.editMedia);
                openMediaModal(media);
            };
        });
    }

    function openMediaModal(media = null) {
        const isEdit = Boolean(media);
        const title = isEdit ? 'Editar Multimedia' : 'Añadir Archivo Multimedia';
        const html = `
            <form id="admin-media-form" class="ap-form" enctype="multipart/form-data">
                <div class="ap-field">
                    <label class="ap-label">Título</label>
                    <input class="ap-input" type="text" name="title" required maxlength="160" value="${isEdit ? escapeHtml(media.title) : ''}" placeholder="Ej. Melodía serena del jardín">
                </div>
                <div class="ap-field">
                    <label class="ap-label">Tipo de Contenido</label>
                    <select class="ap-select" name="media_type" required>
                        <option value="audio" ${isEdit && media.media_type === 'audio' ? 'selected' : ''}>🎵 Audio / Canción</option>
                        <option value="video" ${isEdit && media.media_type === 'video' ? 'selected' : ''}>🎬 Video</option>
                    </select>
                </div>
                ${!isEdit ? `
                    <div class="ap-field">
                        <label class="ap-label">Fuente</label>
                        <select class="ap-select" id="media-source-select" name="source_type" required>
                            <option value="upload">⬆️ Subir archivo directo (MP3, MP4, WebM)</option>
                            <option value="youtube">▶️ Enlace de YouTube</option>
                            <option value="external_audio">🎧 Enlace MP3 externo (HTTPS)</option>
                        </select>
                    </div>
                    <div id="media-upload-field" class="ap-field ap-file-field">
                        <label class="ap-label">Seleccionar Archivo</label>
                        <input class="ap-file-input" type="file" name="file" accept="audio/*,video/*">
                    </div>
                    <div id="media-link-field" class="ap-field" hidden>
                        <label class="ap-label">URL del Recurso</label>
                        <input class="ap-input" type="url" name="source_url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                ` : ''}
                <div class="ap-field">
                    <label class="ap-label">Descripción</label>
                    <textarea class="ap-textarea" name="description" rows="3" maxlength="4000" placeholder="Dedicatoria o detalles sobre esta melodía…">${isEdit ? escapeHtml(media.description || '') : ''}</textarea>
                </div>
                <div class="ap-actions">
                    <button class="ap-btn-primary" type="submit">${isEdit ? '💾 Guardar Cambios' : '🌸 Añadir Media'}</button>
                    <button class="ap-btn-outline" type="button" data-modal-close>Cancelar</button>
                </div>
            </form>
        `;
        openModal(title, html);

        const form = document.getElementById('admin-media-form');
        form.querySelector('[data-modal-close]').onclick = closeModal;

        const sourceSelect = document.getElementById('media-source-select');
        const uploadField = document.getElementById('media-upload-field');
        const linkField = document.getElementById('media-link-field');

        if (sourceSelect) {
            sourceSelect.onchange = () => {
                const isUpload = sourceSelect.value === 'upload';
                uploadField.hidden = !isUpload;
                linkField.hidden = isUpload;
            };
        }

        form.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            try {
                if (isEdit) {
                    await apiRequest(`/admin/media/${media.id}`, 'PUT', {
                        title: formData.get('title'),
                        description: formData.get('description'),
                        media_type: formData.get('media_type')
                    });
                    notify('Multimedia actualizado 🌸');
                } else {
                    await apiRequest('/admin/media', 'POST', formData);
                    notify('¡Multimedia añadido con éxito! 🌸');
                }
                closeModal();
                loadMedia();
            } catch (_) {}
        };
    }

    document.getElementById('admin-media-source')?.addEventListener('change', () => loadMedia(1));
    document.getElementById('admin-media-type')?.addEventListener('change', () => loadMedia(1));

    // ── 7. AJUSTES GLOBALES ──
    async function loadSettings() {
        try {
            const data = await apiRequest('/admin/settings');
            const form = document.getElementById('admin-settings-form');
            if (!form) return;

            form.quiz_rate_limit_attempts.value = data.quiz_rate_limit_attempts || 10;
            form.quiz_rate_limit_window.value = data.quiz_rate_limit_window || 1;
            form.quiz_questions_required.value = data.quiz_questions_required || 10;
            form.max_upload_size_mb.value = data.max_upload_size_mb || 100;
        } catch (_) {}
    }

    const settingsForm = document.getElementById('admin-settings-form');
    if (settingsForm) {
        settingsForm.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(settingsForm);
            const payload = {
                quiz_rate_limit_attempts: Number(formData.get('quiz_rate_limit_attempts')),
                quiz_rate_limit_window: Number(formData.get('quiz_rate_limit_window')),
                quiz_questions_required: Number(formData.get('quiz_questions_required')),
                max_upload_size_mb: Number(formData.get('max_upload_size_mb'))
            };

            try {
                await apiRequest('/admin/settings', 'PUT', payload);
                notify('Configuración global del jardín guardada 🌸');
            } catch (_) {}
        };
    }

    // ── Conexión de Botones de Modal CTA ──
    document.querySelectorAll('[data-admin-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalType = btn.dataset.adminModal;
            if (modalType === 'user-create') openUserModal();
            else if (modalType === 'post-create') openPostModal();
            else if (modalType === 'quiz-question-create') openQuizQuestionModal();
            else if (modalType === 'album-create') openAlbumModal();
            else if (modalType === 'media-create') openMediaModal();
        });
    });

    // ── Conexión con los Tabs de Administración ──
    const adminTabs = document.querySelectorAll('.admin-tab[data-tab]');
    const adminPanels = document.querySelectorAll('.admin-panel');

    function switchAdminTab(tabName) {
        const targetId = 'admin-' + tabName;

        adminTabs.forEach(t => {
            const isActive = t.getAttribute('data-tab') === tabName;
            t.classList.toggle('is-active', isActive);
            t.setAttribute('aria-selected', String(isActive));
        });

        adminPanels.forEach(panel => {
            if (panel.id === targetId) {
                panel.classList.add('is-active');
                panel.removeAttribute('hidden');
            } else {
                panel.classList.remove('is-active');
                panel.setAttribute('hidden', '');
            }
        });

        if (tabName === 'users') loadUsers();
        else if (tabName === 'profile') loadProfile();
        else if (tabName === 'posts') loadPosts();
        else if (tabName === 'quiz') loadQuizData();
        else if (tabName === 'albums') loadAlbums();
        else if (tabName === 'media') loadMedia();
        else if (tabName === 'season-audios') loadSeasonAudios();
        else if (tabName === 'settings') loadSettings();
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  MÓDULO: SONIDOS DEL CLIMA Y ESTACIONES
    // ═══════════════════════════════════════════════════════════════════════
    const seasonAudioForm = document.getElementById('admin-season-audio-form');
    const seasonAudioTable = document.getElementById('admin-season-audios-table');
    const seasonAudioTbody = seasonAudioTable?.querySelector('tbody');
    const seasonAudioFilter = document.getElementById('filter-season-audios');
    const seasonAudioRefreshBtn = document.getElementById('btn-refresh-season-audios');
    const seasonAudioUploadStatus = document.getElementById('season-audio-upload-status');
    const seasonAudioSubmitBtn = document.getElementById('btn-submit-season-audio');

    const seasonNamesMap = {
        'spring': '🌸 Primavera',
        'rain': '🌧️ Lluvia',
        'summer': '☀️ Verano',
        'autumn': '🍂 Otoño',
        'winter': '❄️ Invierno',
        'stars': '🌠 Estrellas',
        'bubbles': '🫧 Burbujas',
        'clear': '✨ Calma'
    };

    let currentPlayingAudio = null;

    async function loadSeasonAudios() {
        if (!seasonAudioTbody) return;
        seasonAudioTbody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align: center; padding: 24px; color: var(--text-muted);">
                    Cargando sonidos del clima...
                </td>
            </tr>
        `;

        const filter = seasonAudioFilter?.value || '';
        const url = `/admin/season-audios${filter ? '?season=' + encodeURIComponent(filter) : ''}`;
        let data = null;
        try {
            data = await apiRequest(url);
        } catch (_) {
            seasonAudioTbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 24px; color: var(--frambuesa);">
                        No se pudieron cargar los sonidos. Intenta nuevamente.
                    </td>
                </tr>
            `;
            return;
        }

        const audios = data?.audios || [];
        if (audios.length === 0) {
            seasonAudioTbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 32px; color: var(--text-muted);">
                        No hay sonidos cargados para esta estación. ¡Sube tus audios arriba!
                    </td>
                </tr>
            `;
            return;
        }

        seasonAudioTbody.innerHTML = audios.map(audio => {
            const seasonLabel = seasonNamesMap[audio.season] || audio.season;
            const sizeMb = (audio.file_size / (1024 * 1024)).toFixed(2);
            const statusBadge = audio.is_active
                ? '<span class="status-badge is-active" style="color: #059669; font-weight: 600;">✓ Activo</span>'
                : '<span class="status-badge" style="color: var(--text-muted);">Inactivo</span>';

            return `
                <tr data-audio-id="${audio.id}">
                    <td><strong>#${audio.id}</strong></td>
                    <td><span class="season-badge" style="display: inline-block; padding: 4px 10px; border-radius: 9999px; background: rgba(209,77,114,0.08); font-size: 12px; font-weight: 600;">${escapeHtml(seasonLabel)}</span></td>
                    <td>
                        <strong style="display: block; color: var(--text-primary); font-size: 13.5px;">${escapeHtml(audio.title || 'Sin título')}</strong>
                        <small style="color: var(--text-muted); font-size: 11px;">${escapeHtml(audio.original_name || '')}</small>
                    </td>
                    <td>
                        <audio controls preload="none" src="${escapeHtml(audio.url)}" style="height: 32px; width: 180px;"></audio>
                    </td>
                    <td><span style="font-size: 12px; color: var(--text-muted);">${sizeMb} MB</span></td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="row-actions" style="display: flex; gap: 6px; align-items: center;">
                            <button type="button" class="btn-action-sm btn-toggle-audio" data-id="${audio.id}" title="${audio.is_active ? 'Desactivar audio' : 'Activar audio'}" style="padding: 4px 8px; font-size: 11px; border-radius: 6px; border: 1px solid var(--border-editorial); background: #fff; cursor: pointer;">
                                ${audio.is_active ? '⏸ Pausar' : '▶ Activar'}
                            </button>
                            <button type="button" class="btn-action-sm btn-delete-audio" data-id="${audio.id}" title="Eliminar sonido" style="padding: 4px 8px; font-size: 11px; border-radius: 6px; border: 1px solid #fee2e2; background: #fef2f2; color: #dc2626; cursor: pointer;">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        // Eventos para botones de activar/desactivar y borrar
        seasonAudioTbody.querySelectorAll('.btn-toggle-audio').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.getAttribute('data-id');
                btn.disabled = true;
                try {
                    await apiRequest(`/admin/season-audios/${id}/toggle`, 'POST');
                    notify('Estado del audio actualizado con éxito.');
                    loadSeasonAudios();
                    if (window.reloadGardenSeasonAudios) window.reloadGardenSeasonAudios();
                } catch (_) {
                    btn.disabled = false;
                }
            });
        });

        seasonAudioTbody.querySelectorAll('.btn-delete-audio').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.getAttribute('data-id');
                if (!confirm('¿Estás seguro de que deseas eliminar este audio de la estación?')) return;
                btn.disabled = true;
                try {
                    await apiRequest(`/admin/season-audios/${id}`, 'DELETE');
                    notify('Audio eliminado correctamente.');
                    loadSeasonAudios();
                    if (window.reloadGardenSeasonAudios) window.reloadGardenSeasonAudios();
                } catch (_) {
                    btn.disabled = false;
                }
            });
        });
    }

    seasonAudioFilter?.addEventListener('change', () => loadSeasonAudios());
    seasonAudioRefreshBtn?.addEventListener('click', () => loadSeasonAudios());

    // Subida múltiple o individual de audios
    if (seasonAudioForm) {
        seasonAudioForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(seasonAudioForm);
            const fileInput = document.getElementById('season-audio-files');

            if (!fileInput?.files || fileInput.files.length === 0) {
                notify('Por favor selecciona al menos un archivo de audio.', true);
                return;
            }

            if (seasonAudioSubmitBtn) seasonAudioSubmitBtn.disabled = true;
            if (seasonAudioUploadStatus) {
                seasonAudioUploadStatus.style.display = 'inline';
                seasonAudioUploadStatus.textContent = 'Subiendo ' + fileInput.files.length + ' audio(s)... por favor espera.';
            }

            try {
                const response = await fetch('/admin/season-audios', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json().catch(() => ({}));

                if (response.ok && data.success) {
                    notify(data.message || 'Audios cargados con éxito.');
                    seasonAudioForm.reset();
                    loadSeasonAudios();
                    if (window.reloadGardenSeasonAudios) window.reloadGardenSeasonAudios();
                } else {
                    notify(data.error || data.message || 'Error al subir los audios. Revisa el tamaño y formato.', true);
                }
            } catch (err) {
                notify('Ocurrió un error en la conexión al subir.', true);
            } finally {
                if (seasonAudioSubmitBtn) seasonAudioSubmitBtn.disabled = false;
                if (seasonAudioUploadStatus) seasonAudioUploadStatus.style.display = 'none';
            }
        });
    }

    adminTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabName = tab.getAttribute('data-tab');
            switchAdminTab(tabName);
        });
    });

    // Cargar tab inicial si ya está activo
    const activeTab = document.querySelector('.admin-tab.is-active')?.getAttribute('data-tab');
    if (activeTab && activeTab !== 'dashboard') {
        const tabEl = document.querySelector(`.admin-tab[data-tab="${activeTab}"]`);
        tabEl?.click();
    }

    // ── Helpers ──
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function renderPagination(container, paginator, loadFn) {
        if (!container || !paginator || paginator.last_page <= 1) {
            if (container) container.innerHTML = '';
            return;
        }

        const { current_page, last_page } = paginator;
        let html = '';

        if (current_page > 1) {
            html += `<button type="button" data-page="${current_page - 1}">← Anterior</button>`;
        }

        for (let i = 1; i <= last_page; i++) {
            if (i === 1 || i === last_page || (i >= current_page - 2 && i <= current_page + 2)) {
                html += `<button type="button" class="${i === current_page ? 'active' : ''}" data-page="${i}">${i}</button>`;
            } else if (i === current_page - 3 || i === current_page + 3) {
                html += `<span>…</span>`;
            }
        }

        if (current_page < last_page) {
            html += `<button type="button" data-page="${current_page + 1}">Siguiente →</button>`;
        }

        container.innerHTML = html;
        container.querySelectorAll('button[data-page]').forEach(b => {
            b.onclick = () => loadFn(Number(b.dataset.page));
        });
    }
}
