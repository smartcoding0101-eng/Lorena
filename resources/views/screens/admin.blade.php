        @if (auth()->check() && (auth()->user()->is_admin ?? false))
        <section class="screen" data-screen="admin" aria-labelledby="admin-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#carla" data-go="carla">← Volver a mi espacio</a>
                <div class="admin-luxury-header">
                    <div class="admin-luxury-header-content">
                        <span class="admin-badge">Control Maestro & Gestión</span>
                        <h1 id="admin-title" class="admin-luxury-title">Administración del <em>Jardín</em></h1>
                        <p class="admin-luxury-subtitle">Gestión completa de contenido, usuarios y configuración global del sitio.</p>
                    </div>
                    <div class="admin-header-badge-icon" aria-hidden="true">
                        <span class="admin-gear-spin">⚙</span>
                    </div>
                </div>

                <div class="admin-toolbar-luxury">
                    <div class="admin-tabs" role="tablist" aria-label="Módulos de administración">
                        <button class="admin-tab is-active" role="tab" aria-selected="true" data-tab="dashboard">
                            <span class="tab-icon">📊</span>
                            <span>Inicio</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="users">
                            <span class="tab-icon">👥</span>
                            <span>Usuarios</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="profile">
                            <span class="tab-icon">👑</span>
                            <span>Perfil público</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="posts">
                            <span class="tab-icon">✍️</span>
                            <span>Publicaciones</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="quiz">
                            <span class="tab-icon">🧩</span>
                            <span>Quiz Carla</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="albums">
                            <span class="tab-icon">📸</span>
                            <span>Álbumes</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="media">
                            <span class="tab-icon">🎵</span>
                            <span>Media</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="settings">
                            <span class="tab-icon">⚙️</span>
                            <span>Ajustes</span>
                        </button>
                    </div>
                </div>

                <div class="admin-content">
                    <div class="admin-panel is-active" id="admin-dashboard" role="tabpanel" aria-labelledby="admin-dashboard-title">
                        <div class="admin-panel-top">
                            <div>
                                <h2 id="admin-dashboard-title" class="admin-panel-title">Resumen del Jardín</h2>
                                <p class="admin-panel-desc">Métricas y registros activos en el ecosistema de Carla Lorena.</p>
                            </div>
                            <span class="admin-live-pulse"><span class="pulse-dot"></span> Sincronizado en tiempo real</span>
                        </div>
                        <div class="admin-stats-grid">
                            <article class="admin-stat-card stat-users">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon">👤</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-users">{{ $globalAdminStats['users'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Usuarios registrados</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-posts">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon">📝</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-posts">{{ $globalAdminStats['posts'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Publicaciones & Diario</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-quiz">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon">❓</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-quiz">{{ $globalAdminStats['quiz'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Preguntas de Quiz</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-albums">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon">📁</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-albums">{{ $globalAdminStats['albums'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Álbumes de Recuerdos</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-media">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon">🎬</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-media">{{ $globalAdminStats['media'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Música & Multimedia</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                        </div>
                    </div>

                    <!-- ═══════════════════════════ PANEL: USUARIOS ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-users" role="tabpanel" aria-labelledby="admin-users-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                                <span>👥</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Gestión de Accesos</p>
                                <h2 id="admin-users-title" class="ap-title">Miembros del Jardín</h2>
                                <p class="ap-desc">Administra los usuarios con acceso al universo personal de Carla Lorena.</p>
                            </div>
                            <button class="ap-cta-btn" type="button" data-admin-modal="user-create">
                                <span>＋</span> Nuevo usuario
                            </button>
                        </div>
                        <div class="ap-table-wrap">
                            <table class="admin-table" id="admin-users-table">
                                <thead>
                                    <tr>
                                        <th><span class="th-inner"># ID</span></th>
                                        <th><span class="th-inner">✦ Nombre</span></th>
                                        <th><span class="th-inner">✉ Email</span></th>
                                        <th><span class="th-inner">👑 Admin</span></th>
                                        <th><span class="th-inner">🌸 Registro</span></th>
                                        <th><span class="th-inner">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <nav class="admin-pagination" id="admin-users-pagination" aria-label="Paginación usuarios"></nav>
                    </div>

                    <!-- ═══════════════════════════ PANEL: PERFIL PÚBLICO ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-profile" role="tabpanel" aria-labelledby="admin-profile-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);">
                                <span>👑</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Identidad & Presentación</p>
                                <h2 id="admin-profile-title" class="ap-title">Perfil Público de Carla</h2>
                                <p class="ap-desc">Edita la presentación pública de Carla Lorena: su esencia, su historia y su luz.</p>
                            </div>
                        </div>

                        <form class="ap-form" id="admin-profile-form" enctype="multipart/form-data">
                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">🌸</span>
                                    <span>Información Personal</span>
                                </div>
                                <div class="ap-field-group">
                                    <div class="ap-field">
                                        <label class="ap-label" for="admin-profile-profession">Profesión</label>
                                        <input class="ap-input" id="admin-profile-profession" name="profession" maxlength="160" placeholder="Ej.: Médica especialista, Ingeniera...">
                                    </div>
                                </div>
                            </div>

                            <div class="ap-divider"><span>✿</span></div>

                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">📖</span>
                                    <span>Su Historia</span>
                                </div>
                                <div class="ap-field-group">
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-biography">Biografía</label>
                                        <textarea class="ap-textarea" id="admin-profile-biography" name="biography" maxlength="5000" rows="4" placeholder="Una presentación en sus propias palabras, desde el corazón..."></textarea>
                                    </div>
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-education">Estudios & Formación</label>
                                        <textarea class="ap-textarea" id="admin-profile-education" name="education" maxlength="10000" rows="4" placeholder="Carreras, especialidades, certificaciones... una por línea."></textarea>
                                    </div>
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-experience">Experiencia</label>
                                        <textarea class="ap-textarea" id="admin-profile-experience" name="experience" maxlength="10000" rows="4" placeholder="Roles, áreas de trabajo, caminos recorridos..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="ap-divider"><span>✿</span></div>

                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">✨</span>
                                    <span>Su Esencia</span>
                                </div>
                                <div class="ap-field-group">
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-achievements">Logros & Contribuciones</label>
                                        <textarea class="ap-textarea" id="admin-profile-achievements" name="achievements" maxlength="10000" rows="3" placeholder="Proyectos, reconocimientos, huellas dejadas en el mundo..."></textarea>
                                    </div>
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-interests">Pasiones & Intereses</label>
                                        <textarea class="ap-textarea" id="admin-profile-interests" name="interests" maxlength="10000" rows="3" placeholder="Lo que ama, lo que la mueve, lo que la inspira..."></textarea>
                                    </div>
                                    <div class="ap-field ap-field-full">
                                        <label class="ap-label" for="admin-profile-additional">Datos adicionales</label>
                                        <textarea class="ap-textarea" id="admin-profile-additional" name="additional_info" maxlength="10000" rows="3" placeholder="Cualquier otra información importante sobre Carla..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="ap-divider"><span>✿</span></div>

                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">📷</span>
                                    <span>Fotografía Destacada</span>
                                </div>
                                <div class="ap-field-group">
                                    <div class="ap-field ap-file-field">
                                        <label class="ap-label" for="admin-profile-photo">Seleccionar imagen (JPG, PNG, WebP)</label>
                                        <input class="ap-file-input" id="admin-profile-photo" name="featured_photo" type="file" accept="image/jpeg,image/png,image/webp">
                                        <p class="ap-file-hint">Recomendado: 800×800 px o más, formato cuadrado o vertical.</p>
                                    </div>
                                </div>
                                <div id="admin-profile-photo-preview" class="admin-photo-preview" hidden></div>
                            </div>

                            <div class="ap-actions">
                                <button class="ap-btn-primary" type="submit">🌸 Guardar perfil</button>
                                <button class="ap-btn-outline" type="button" id="admin-profile-publish" data-action="publish">✦ Publicar</button>
                                <button class="ap-btn-outline" type="button" id="admin-profile-unpublish" data-action="unpublish" hidden>Despublicar</button>
                                <button class="ap-btn-danger" type="button" id="admin-profile-delete-photo">✕ Quitar foto</button>
                            </div>
                        </form>
                    </div>

                    <!-- ═══════════════════════════ PANEL: PUBLICACIONES ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-posts" role="tabpanel" aria-labelledby="admin-posts-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                                <span>✍️</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Blog & Diario Personal</p>
                                <h2 id="admin-posts-title" class="ap-title">Publicaciones de Carla</h2>
                                <p class="ap-desc">Gestiona los escritos del blog público y las páginas del diario íntimo.</p>
                            </div>
                            <button class="ap-cta-btn" type="button" data-admin-modal="post-create">
                                <span>＋</span> Nueva publicación
                            </button>
                        </div>
                        <div class="ap-filters">
                            <div class="ap-filter-item">
                                <label class="ap-filter-label">Tipo</label>
                                <select class="ap-select" id="admin-posts-kind" aria-label="Filtrar por tipo">
                                    <option value="">Todos los tipos</option>
                                    <option value="blog">📝 Blog</option>
                                    <option value="diary">📔 Diario</option>
                                </select>
                            </div>
                            <div class="ap-filter-item">
                                <label class="ap-filter-label">Estado</label>
                                <select class="ap-select" id="admin-posts-status" aria-label="Filtrar por estado">
                                    <option value="">Todos los estados</option>
                                    <option value="draft">✏️ Borrador</option>
                                    <option value="published">✦ Publicado</option>
                                </select>
                            </div>
                            <div class="ap-filter-item ap-filter-search">
                                <label class="ap-filter-label">Buscar</label>
                                <input class="ap-search" type="search" id="admin-posts-search" placeholder="Buscar por título o contenido…" aria-label="Buscar">
                            </div>
                        </div>
                        <div class="ap-table-wrap">
                            <table class="admin-table" id="admin-posts-table">
                                <thead>
                                    <tr>
                                        <th><span class="th-inner"># ID</span></th>
                                        <th><span class="th-inner">🏷 Tipo</span></th>
                                        <th><span class="th-inner">✦ Título</span></th>
                                        <th><span class="th-inner">Categoría</span></th>
                                        <th><span class="th-inner">Estado</span></th>
                                        <th><span class="th-inner">🌸 Creado</span></th>
                                        <th><span class="th-inner">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <nav class="admin-pagination" id="admin-posts-pagination" aria-label="Paginación posts"></nav>
                    </div>

                    <!-- ═══════════════════════════ PANEL: QUIZ ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-quiz" role="tabpanel" aria-labelledby="admin-quiz-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);">
                                <span>🧩</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Juego Interactivo</p>
                                <h2 id="admin-quiz-title" class="ap-title">Quiz «Conociendo a Carla»</h2>
                                <p class="ap-desc">Configura el quiz de amor, gestiona preguntas y la foto de recompensa especial.</p>
                            </div>
                        </div>

                        <div class="ap-quiz-grid">
                            <!-- Configuración -->
                            <div class="ap-quiz-card">
                                <div class="ap-quiz-card-header">
                                    <span class="ap-quiz-card-icon">⚙️</span>
                                    <h3 class="ap-quiz-card-title">Configuración del Juego</h3>
                                </div>
                                <form class="ap-form" id="admin-quiz-settings-form">
                                    <div class="ap-field">
                                        <label class="ap-label">Intentos permitidos por hora</label>
                                        <input class="ap-input" type="number" name="rate_limit_attempts" min="1" max="100" value="10">
                                    </div>
                                    <div class="ap-field">
                                        <label class="ap-label">Ventana de tiempo (horas)</label>
                                        <input class="ap-input" type="number" name="rate_limit_window" min="1" max="24" value="1">
                                    </div>
                                    <div class="ap-field">
                                        <label class="ap-label">Preguntas requeridas para ganar</label>
                                        <input class="ap-input" type="number" name="questions_required" min="1" max="50" value="10">
                                    </div>
                                    <button class="ap-btn-primary" type="submit">💾 Guardar configuración</button>
                                </form>
                            </div>
                            <!-- Recompensa -->
                            <div class="ap-quiz-card">
                                <div class="ap-quiz-card-header">
                                    <span class="ap-quiz-card-icon">🎁</span>
                                    <h3 class="ap-quiz-card-title">Foto de Recompensa</h3>
                                </div>
                                <div id="admin-quiz-reward-preview" class="admin-photo-preview" hidden></div>
                                <form class="ap-form" id="admin-quiz-reward-form" enctype="multipart/form-data">
                                    <div class="ap-field ap-file-field">
                                        <label class="ap-label" for="admin-quiz-reward-image">Imagen especial (JPG, PNG, WebP ≤ 10 MB)</label>
                                        <input class="ap-file-input" id="admin-quiz-reward-image" name="reward_image" type="file" accept="image/jpeg,image/png,image/webp" required>
                                        <p class="ap-file-hint">Esta imagen se muestra al ganar el quiz. ¡Que sea especial! 💌</p>
                                    </div>
                                    <div class="ap-field ap-consent-field">
                                        <label class="ap-consent-label">
                                            <input type="checkbox" name="reward_authorized" value="1" required>
                                            <span>Confirmo que Carla autorizó esta imagen</span>
                                        </label>
                                    </div>
                                    <div class="ap-actions">
                                        <button class="ap-btn-primary" type="submit">🌸 Subir recompensa</button>
                                        <button class="ap-btn-danger" type="button" id="admin-quiz-reward-delete">✕ Retirar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="ap-divider"><span>✿</span></div>

                        <!-- Preguntas -->
                        <div class="ap-quiz-questions-section">
                            <div class="ap-sub-header">
                                <div>
                                    <h3 class="ap-sub-title">❓ Banco de Preguntas</h3>
                                    <p class="ap-sub-desc">Preguntas que aparecerán en el quiz para conocer mejor a Carla Lorena.</p>
                                </div>
                                <button class="ap-cta-btn" type="button" data-admin-modal="quiz-question-create">＋ Añadir pregunta</button>
                            </div>
                            <div class="ap-table-wrap">
                                <table class="admin-table" id="admin-quiz-questions-table">
                                    <thead>
                                        <tr>
                                            <th><span class="th-inner"># ID</span></th>
                                            <th><span class="th-inner">❓ Pregunta</span></th>
                                            <th><span class="th-inner">Variantes</span></th>
                                            <th><span class="th-inner">✦ Activa</span></th>
                                            <th><span class="th-inner">Acciones</span></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ═══════════════════════════ PANEL: ÁLBUMES ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-albums" role="tabpanel" aria-labelledby="admin-albums-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);">
                                <span>📸</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Galería de Recuerdos</p>
                                <h2 id="admin-albums-title" class="ap-title">Álbumes de Fotografías</h2>
                                <p class="ap-desc">Organiza los momentos especiales de Carla en colecciones llenas de amor.</p>
                            </div>
                            <button class="ap-cta-btn" type="button" data-admin-modal="album-create">
                                <span>＋</span> Nuevo álbum
                            </button>
                        </div>
                        <div class="admin-albums-list" id="admin-albums-list"></div>
                    </div>

                    <!-- ═══════════════════════════ PANEL: MEDIA ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-media" role="tabpanel" aria-labelledby="admin-media-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);">
                                <span>🎵</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Contenido Audiovisual</p>
                                <h2 id="admin-media-title" class="ap-title">Música & Multimedia</h2>
                                <p class="ap-desc">Administra los videos, audios y canciones especiales del jardín de Carla.</p>
                            </div>
                            <button class="ap-cta-btn" type="button" data-admin-modal="media-create">
                                <span>＋</span> Añadir media
                            </button>
                        </div>
                        <div class="ap-filters">
                            <div class="ap-filter-item">
                                <label class="ap-filter-label">Fuente</label>
                                <select class="ap-select" id="admin-media-source" aria-label="Filtrar por fuente">
                                    <option value="">Todas las fuentes</option>
                                    <option value="upload">⬆️ Subidas</option>
                                    <option value="youtube">▶️ YouTube</option>
                                    <option value="external_audio">🎧 MP3 externo</option>
                                </select>
                            </div>
                            <div class="ap-filter-item">
                                <label class="ap-filter-label">Tipo</label>
                                <select class="ap-select" id="admin-media-type" aria-label="Filtrar por tipo">
                                    <option value="">Todos los tipos</option>
                                    <option value="video">🎬 Video</option>
                                    <option value="audio">🎵 Audio</option>
                                </select>
                            </div>
                        </div>
                        <div class="ap-table-wrap">
                            <table class="admin-table" id="admin-media-table">
                                <thead>
                                    <tr>
                                        <th><span class="th-inner"># ID</span></th>
                                        <th><span class="th-inner">Fuente</span></th>
                                        <th><span class="th-inner">🎵 Tipo</span></th>
                                        <th><span class="th-inner">✦ Título</span></th>
                                        <th><span class="th-inner">Tamaño</span></th>
                                        <th><span class="th-inner">🌸 Creado</span></th>
                                        <th><span class="th-inner">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <nav class="admin-pagination" id="admin-media-pagination" aria-label="Paginación media"></nav>
                    </div>

                    <!-- ═══════════════════════════ PANEL: AJUSTES ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-settings" role="tabpanel" aria-labelledby="admin-settings-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap" style="background: linear-gradient(135deg, #f0f9ff 0%, #bae6fd 100%);">
                                <span>⚙️</span>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Configuración del Sistema</p>
                                <h2 id="admin-settings-title" class="ap-title">Ajustes Globales</h2>
                                <p class="ap-desc">Parámetros técnicos y límites del ecosistema de El Jardín de Carla.</p>
                            </div>
                        </div>

                        <form class="ap-form" id="admin-settings-form">
                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">🧩</span>
                                    <span>Quiz — Límites de Juego</span>
                                </div>
                                <div class="ap-field-group ap-field-group-cols">
                                    <div class="ap-field">
                                        <label class="ap-label">Intentos permitidos por hora</label>
                                        <input class="ap-input" type="number" name="quiz_rate_limit_attempts" min="1" max="100">
                                    </div>
                                    <div class="ap-field">
                                        <label class="ap-label">Ventana de tiempo (horas)</label>
                                        <input class="ap-input" type="number" name="quiz_rate_limit_window" min="1" max="24">
                                    </div>
                                    <div class="ap-field">
                                        <label class="ap-label">Preguntas mínimas para ganar</label>
                                        <input class="ap-input" type="number" name="quiz_questions_required" min="1" max="50">
                                    </div>
                                </div>
                            </div>

                            <div class="ap-divider"><span>✿</span></div>

                            <div class="ap-form-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">📁</span>
                                    <span>Archivos & Subidas</span>
                                </div>
                                <div class="ap-field-group ap-field-group-cols">
                                    <div class="ap-field">
                                        <label class="ap-label">Tamaño máximo de archivo (MB)</label>
                                        <input class="ap-input" type="number" name="max_upload_size_mb" min="1" max="500">
                                    </div>
                                </div>
                            </div>

                            <div class="ap-actions">
                                <button class="ap-btn-primary" type="submit">💾 Guardar configuración</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Contenedor Modal Reutilizable para Administración --}}
            <div id="admin-modal-container" class="admin-modal-overlay" hidden>
                <div class="admin-modal-backdrop" data-modal-backdrop></div>
                <div class="admin-modal-card">
                    <header class="admin-modal-header">
                        <h3 id="admin-modal-title" class="admin-modal-title">Administración</h3>
                        <button type="button" id="admin-modal-close" class="admin-modal-close" aria-label="Cerrar modal">✕</button>
                    </header>
                    <div id="admin-modal-body" class="admin-modal-body"></div>
                </div>
            </div>
        </section>
        @endif