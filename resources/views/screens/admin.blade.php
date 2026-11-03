        @if (auth()->check() && (auth()->user()->is_admin ?? false))
        <section class="screen" data-screen="admin" aria-labelledby="admin-title" hidden>
            <div class="page-shell">
                <!-- Barra de Navegación del Centro de Control -->
                <div class="screen-nav-bar carla-nav-bar">
                    <a class="back-link" href="#carla" data-go="carla">
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </span>
                        <span>Volver a mi espacio</span>
                    </a>
                    <span class="nav-screen-pill">
                        <span class="nav-pill-dot" aria-hidden="true"></span>
                        <span>Control Center · El Jardín de Carla</span>
                    </span>
                    <a class="back-link" href="#jardin" data-go="jardin">
                        <span>Ir al Jardín Secreto</span>
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Cabecera de Administración Luxury -->
                <div class="admin-luxury-header">
                    <div class="admin-luxury-header-content">
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge badge-gold">CENTRO DE CONTROL</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-rose">GESTIÓN EDITORIAL</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-live">
                                <span class="live-pulse-dot" aria-hidden="true"></span>
                                <span>SESIÓN ADMINISTRADOR ACTIVA</span>
                            </span>
                        </div>
                        <h1 id="admin-title" class="admin-luxury-title">Control Center · <em>Gestión editorial</em></h1>
                        <p class="admin-luxury-subtitle">Gestión integral de contenidos, biografías, memorias fotográficas, música, atmósferas climáticas y miembros del universo Carla Lorena.</p>
                    </div>
                    <div class="admin-header-badge-icon" aria-hidden="true">
                        <svg width="34" height="34" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                            <circle cx="18" cy="18" r="15" stroke="currentColor" stroke-width="1.3" stroke-dasharray="3 2" opacity="0.45"/>
                            <path d="M18 7C14.5 7 12 10 12 13.5C12 17.5 15.5 20 18 22C20.5 20 24 17.5 24 13.5C24 10 21.5 7 18 7Z" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M18 10C16 10 14.8 11.6 14.8 13.4C14.8 15.5 16.5 16.8 18 18C19.5 16.8 21.2 15.5 21.2 13.4C21.2 11.6 20 10 18 10Z" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M18 22V29M18 25C15 25 13 23.2 12.5 21.5M18 26.5C21 26.5 23 24.7 23.5 23" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="admin-toolbar-luxury">
                    <div class="admin-tabs" role="tablist" aria-label="Módulos de administración">
                        <button class="admin-tab is-active" role="tab" aria-selected="true" data-tab="dashboard">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3.5C9.2 3.5 7 6 7 9C7 12.4 9.8 14.6 12 16.2C14.2 14.6 17 12.4 17 9C17 6 14.8 3.5 12 3.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <path d="M12 6.5C10.5 6.5 9.5 7.7 9.5 9.1C9.5 10.8 10.8 11.9 12 12.8C13.2 11.9 14.5 10.8 14.5 9.1C14.5 7.7 13.5 6.5 12 6.5Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 16.2V21M12 18.5C9.5 18.5 7.8 17 7.2 15.5M12 19.5C14.5 19.5 16.2 18 16.8 16.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg></span>
                            <span>Inicio</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="profile">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 17L5.8 8.5L9.8 12L12 6.5L14.2 12L18.2 8.5L20 17H4Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M5 19.5H19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <circle cx="12" cy="4.2" r="1.2" fill="currentColor"/>
                            </svg></span>
                            <span>Perfil público</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="posts">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M19.5 4.5C15.5 4.5 11.2 7.2 9.2 11.2L7 17L12.8 14.8C16.8 12.8 19.5 8.5 19.5 4.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <path d="M14.5 9.5L5 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <path d="M4.5 20H11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg></span>
                            <span>Publicaciones</span>
                        </button>
                                                <button class="admin-tab" role="tab" aria-selected="false" data-tab="gallery">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/>
                                <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                <polyline points="21 15 16 10 5 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg></span>
                            <span>Galería & Arte</span>
                        </button>

<button class="admin-tab" role="tab" aria-selected="false" data-tab="albums">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3.5" y="4.5" width="17" height="15" rx="3.5" fill="currentColor" fill-opacity="0.14" stroke="currentColor" stroke-width="1.6"/>
                                <circle cx="9" cy="9.5" r="1.8" fill="currentColor"/>
                                <path d="M4.5 17L9.5 12.8L13.2 15.8L16.5 13L19.8 16.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg></span>
                            <span>Álbumes</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="media">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M9 17.5V6.8L19 4.8V15.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="6.8" cy="17.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
                                <circle cx="16.8" cy="15.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
                            </svg></span>
                            <span>Media</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="season-audios">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 9.5H15.5C17.2 9.5 18.5 8.2 18.5 6.5C18.5 4.8 17.2 3.5 15.5 3.5C14 3.5 12.8 4.5 12.6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <path d="M3 13.5H18.5C20.2 13.5 21.5 14.8 21.5 16.5C21.5 18.2 20.2 19.5 18.5 19.5C17 19.5 15.8 18.5 15.6 17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <path d="M5 17.2H11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <circle cx="7.5" cy="6" r="1.3" fill="currentColor"/>
                            </svg></span>
                            <span>Sonidos del Clima</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="quiz">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3.5C13.8 3.5 15 5 15 6.8C15 7.4 14.8 8 14.5 8.5C15 8.2 15.6 8 16.2 8C18 8 19.5 9.2 19.5 11C19.5 12.8 18 14 16.2 14C15.6 14 15 13.8 14.5 13.5C14.8 14 15 14.6 15 15.2C15 17 13.8 18.5 12 18.5C10.2 18.5 9 17 9 15.2C9 14.6 9.2 14 9.5 13.5C9 13.8 8.4 14 7.8 14C6 14 4.5 12.8 4.5 11C4.5 9.2 6 8 7.8 8C8.4 8 9 8.2 9.5 8.5C9.2 8 9 7.4 9 6.8C9 5 10.2 3.5 12 3.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                <circle cx="12" cy="11" r="2.2" fill="currentColor"/>
                                <path d="M12 18.5V21.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg></span>
                            <span>Quiz Carla</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="users">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="9" cy="8.5" r="3.2" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M3.8 19.2C3.8 16.1 6.1 14 9 14C11.9 14 14.2 16.1 14.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <path d="M17.5 6.2C16.2 6.2 15.2 7.3 15.2 8.7C15.2 10.4 16.5 11.4 17.5 12.2C18.5 11.4 19.8 10.4 19.8 8.7C19.8 7.3 18.8 6.2 17.5 6.2Z" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M15.2 15C17.8 15.2 19.8 16.9 20.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg></span>
                            <span>Usuarios</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="traffic">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg></span>
                            <span>Tráfico & Visitas</span>
                        </button>
                        <button class="admin-tab" role="tab" aria-selected="false" data-tab="settings">
                            <span class="tab-icon"><svg class="admin-svg-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="3.2" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M12 3V5.5M12 18.5V21M3 12H5.5M18.5 12H21M5.6 5.6L7.4 7.4M16.6 16.6L18.4 18.4M18.4 5.6L16.6 7.4M7.4 16.6L5.6 18.4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            </svg></span>
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
                            <article class="admin-stat-card stat-posts">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon"><svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M19.5 4.5C15.5 4.5 11.2 7.2 9.2 11.2L7 17L12.8 14.8C16.8 12.8 19.5 8.5 19.5 4.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                        <path d="M14.5 9.5L5 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                        <path d="M4.5 20H11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    </svg></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-posts">{{ $globalAdminStats['posts'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Publicaciones & Diario</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-albums">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon"><svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="3.5" y="4.5" width="17" height="15" rx="3.5" fill="currentColor" fill-opacity="0.14" stroke="currentColor" stroke-width="1.6"/>
                                        <circle cx="9" cy="9.5" r="1.8" fill="currentColor"/>
                                        <path d="M4.5 17L9.5 12.8L13.2 15.8L16.5 13L19.8 16.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-albums">{{ $globalAdminStats['albums'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Álbumes de Recuerdos</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-media">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon"><svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M9 17.5V6.8L19 4.8V15.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="6.8" cy="17.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
                                        <circle cx="16.8" cy="15.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
                                    </svg></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-media">{{ $globalAdminStats['media'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Música & Multimedia</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-quiz">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon"><svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M12 3.5C13.8 3.5 15 5 15 6.8C15 7.4 14.8 8 14.5 8.5C15 8.2 15.6 8 16.2 8C18 8 19.5 9.2 19.5 11C19.5 12.8 18 14 16.2 14C15.6 14 15 13.8 14.5 13.5C14.8 14 15 14.6 15 15.2C15 17 13.8 18.5 12 18.5C10.2 18.5 9 17 9 15.2C9 14.6 9.2 14 9.5 13.5C9 13.8 8.4 14 7.8 14C6 14 4.5 12.8 4.5 11C4.5 9.2 6 8 7.8 8C8.4 8 9 8.2 9.5 8.5C9.2 8 9 7.4 9 6.8C9 5 10.2 3.5 12 3.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                        <circle cx="12" cy="11" r="2.2" fill="currentColor"/>
                                        <path d="M12 18.5V21.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    </svg></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-quiz">{{ $globalAdminStats['quiz'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Preguntas de Quiz</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                            <article class="admin-stat-card stat-users">
                                <div class="stat-card-icon-wrap">
                                    <span class="admin-stat-icon"><svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <circle cx="9" cy="8.5" r="3.2" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-width="1.6"/>
                                        <path d="M3.8 19.2C3.8 16.1 6.1 14 9 14C11.9 14 14.2 16.1 14.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                        <path d="M17.5 6.2C16.2 6.2 15.2 7.3 15.2 8.7C15.2 10.4 16.5 11.4 17.5 12.2C18.5 11.4 19.8 10.4 19.8 8.7C19.8 7.3 18.8 6.2 17.5 6.2Z" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M15.2 15C17.8 15.2 19.8 16.9 20.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    </svg></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="stat-users">{{ $globalAdminStats['users'] ?? 0 }}</strong>
                                    <span class="stat-card-label">Usuarios registrados</span>
                                </div>
                                <div class="stat-card-decor"></div>
                            </article>
                        </div>
                    </div>

                    <!-- ═══════════════════════════ PANEL: PERFIL PÚBLICO ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-profile" role="tabpanel" aria-labelledby="admin-profile-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M4 17L5.8 8.5L9.8 12L12 6.5L14.2 12L18.2 8.5L20 17H4Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
            <path d="M5 19.5H19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <circle cx="12" cy="4.2" r="1.2" fill="currentColor"/>
        </svg>
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
                                    <span class="ap-section-icon">🌹</span>
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

                            <div class="ap-divider"><span>✿</span></div>

                            <div class="ap-form-section" id="admin-hero-photos-section">
                                <div class="ap-section-label">
                                    <span class="ap-section-icon">🖼️</span>
                                    <span>Fotografías del Hero Principal (Carrusel de Retratos)</span>
                                </div>
                                <p class="ap-file-hint" style="margin-bottom: 12px;">
                                    Puedes cargar múltiples fotografías para el retrato de Carla en la pantalla de Inicio. Se auto-ajustan automáticamente para cualquier orientación (horizontal, vertical o cuadrada) y rotan en un carrusel dinámico y elegante.
                                </p>
                                <div class="ap-field-group">
                                    <div class="ap-field ap-file-field">
                                        <label class="ap-label" for="admin-hero-multi-photos">Seleccionar una o más fotos (JPG, PNG, WebP)</label>
                                        <input class="ap-file-input" id="admin-hero-multi-photos" name="hero_photos[]" type="file" multiple accept="image/jpeg,image/png,image/webp">
                                        <p class="ap-file-hint">Puedes seleccionar varios archivos a la vez manteniendo presionada la tecla Ctrl o Shift.</p>
                                    </div>
                                    <div style="margin-top: 10px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                        <button class="ap-btn-primary" type="button" id="admin-upload-hero-photos-btn" style="padding: 10px 22px;">
                                            <span>📤 Subir fotografías seleccionadas</span>
                                        </button>
                                        <span id="admin-hero-upload-status" class="admin-upload-status" style="font-size: 13px; color: #b8126c; font-weight: 500;"></span>
                                    </div>
                                </div>

                                <div class="admin-hero-gallery-wrap" style="margin-top: 18px;">
                                    <h4 style="font-size: 14px; font-weight: 600; color: #3b0a2a; margin-bottom: 10px;">Fotografías activas en el carrusel de Inicio:</h4>
                                    <div id="admin-hero-photos-grid" class="admin-hero-photos-grid">
                                        <div class="admin-table-loading" style="padding: 20px; text-align: center; color: #b8126c;">Cargando fotos del hero... 🌸</div>
                                    </div>
                                </div>
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
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M19.5 4.5C15.5 4.5 11.2 7.2 9.2 11.2L7 17L12.8 14.8C16.8 12.8 19.5 8.5 19.5 4.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
            <path d="M14.5 9.5L5 19" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M4.5 20H11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
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

                    <!-- ═══════════════════════════ PANEL: ÁLBUMES ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-albums" role="tabpanel" aria-labelledby="admin-albums-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="3.5" y="4.5" width="17" height="15" rx="3.5" fill="currentColor" fill-opacity="0.14" stroke="currentColor" stroke-width="1.6"/>
            <circle cx="9" cy="9.5" r="1.8" fill="currentColor"/>
            <path d="M4.5 17L9.5 12.8L13.2 15.8L16.5 13L19.8 16.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
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
                    
                    <!-- Panel: Galería de Arte, Momentos, Destinos y Poemas -->
                    <div class="admin-panel" id="admin-gallery" role="tabpanel" aria-labelledby="admin-gallery-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="4" stroke="currentColor" stroke-width="1.8"/>
                                    <circle cx="8.5" cy="8.5" r="2" fill="currentColor"/>
                                    <path d="M21 15L16 10L6 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Curaduría Visual & Poética</p>
                                <h2 id="admin-gallery-title" class="ap-title">Galería, Destinos & Poemas</h2>
                                <p class="ap-desc">Administra en tiempo real las obras fotográficas (#galeria), el mapa de sueños (#destinos) y los versos del pergamino (#biblioteca).</p>
                            </div>
                        </div>

                        <!-- Sub-Navegación de Galería -->
                        <div class="admin-subtabs-pills">
                            <button type="button" class="admin-subtab admin-subtab-pill is-active" id="subtab-btn-art" data-subtab="art">🌸 Galería de Obras</button>
                            <button type="button" class="admin-subtab admin-subtab-pill" id="subtab-btn-dest" data-subtab="dest">✈️ Mapa de Sueños</button>
                            <button type="button" class="admin-subtab admin-subtab-pill" id="subtab-btn-poem" data-subtab="poem">📜 Antología Poética</button>
                        </div>

                        <!-- SUBPANEL 1: OBRAS DE LA GALERÍA -->
                        <div class="admin-subpanel is-active" id="subpanel-art">
                            <div class="admin-curation-card">
                                <div class="curation-card-header">
                                    <div class="curation-card-badge">
                                        <span class="curation-badge-icon">🌸</span>
                                        <div>
                                            <h3 id="gallery-form-title-text" class="curation-badge-title">Añadir Nueva Obra a la Galería</h3>
                                            <p class="curation-badge-sub">Organiza los detalles de la obra y adjunta o enlaza la imagen correspondiente</p>
                                        </div>
                                    </div>
                                    <div id="gallery-mode-badge" class="curation-mode-pill">Modo Creación</div>
                                </div>

                                <form id="admin-gallery-form" class="ap-form" enctype="multipart/form-data">
                                    <input type="hidden" id="gallery-item-id" name="item_id" value="">
                                    
                                    <div class="gallery-editorial-grid">
                                        <!-- Columna Izquierda: Información Editorial -->
                                        <div class="gallery-col-meta">
                                            <div class="ap-field">
                                                <label class="ap-label" for="gallery-input-title">Título de la Obra *</label>
                                                <input type="text" id="gallery-input-title" name="title" class="ap-input" placeholder="Ej.: Flores de domingo al amanecer" required>
                                            </div>

                                            <div class="gallery-meta-row-two">
                                                <div class="ap-field">
                                                    <label class="ap-label" for="gallery-input-category">Colección / Categoría *</label>
                                                    <select id="gallery-input-category" name="category" class="ap-select" required>
                                                        <option value="foto">🌸 Fotografía Botánica (foto)</option>
                                                        <option value="video">🎬 Postal en Movimiento (video)</option>
                                                        <option value="familia">🏡 Familia y Hogar (familia)</option>
                                                        <option value="amigos">✨ Amigos del Alma (amigos)</option>
                                                        <option value="especiales">💎 Obras Especiales (especiales)</option>
                                                    </select>
                                                </div>

                                                <div class="ap-field">
                                                    <label class="ap-label" for="gallery-input-pill">Pill / Distintivo</label>
                                                    <input type="text" id="gallery-input-pill" name="pill" class="ap-input" placeholder="Ej.: Colección Carla, Serenidad">
                                                </div>
                                            </div>

                                            <div class="ap-field">
                                                <label class="ap-label" for="gallery-input-tag">Etiqueta Superior</label>
                                                <input type="text" id="gallery-input-tag" name="tag_label" class="ap-input" placeholder="Ej.: FOTOGRAFÍA BOTÁNICA · ATELIER">
                                            </div>

                                            <div class="ap-field">
                                                <label class="ap-label" for="gallery-input-quote">Cita Poética / Pensamiento</label>
                                                <textarea id="gallery-input-quote" name="quote" class="ap-textarea" rows="2" placeholder="«Para recordarte lo bonito que es florecer despacio...»"></textarea>
                                            </div>
                                        </div>

                                        <!-- Columna Derecha: Medio Visual & Vista Previa en Vivo -->
                                        <div class="gallery-col-media">
                                            <label class="ap-label">Fotografía de la Obra</label>
                                            
                                            <!-- Live Preview Box -->
                                            <div class="gallery-preview-wrapper" id="gallery-preview-container">
                                                <div class="gallery-preview-inner" id="gallery-preview-box">
                                                    <div class="gallery-preview-empty" id="gallery-preview-placeholder">
                                                        <span class="preview-empty-icon">🖼️</span>
                                                        <span class="preview-empty-text">Sin imagen seleccionada</span>
                                                        <small class="preview-empty-sub">Carga un archivo o escribe una URL para previsualizar</small>
                                                    </div>
                                                    <img id="gallery-preview-img" src="" alt="Vista previa" class="gallery-preview-image" style="display: none;">
                                                </div>
                                            </div>

                                            <!-- Custom Dropzone -->
                                            <div class="ap-file-dropzone" id="gallery-dropzone">
                                                <input type="file" id="gallery-input-file" name="image" class="dropzone-file-input" accept="image/*">
                                                <div class="dropzone-content">
                                                    <span class="dropzone-icon">📁</span>
                                                    <div class="dropzone-text">
                                                        <strong id="gallery-dropzone-label">Seleccionar archivo del dispositivo</strong>
                                                        <span class="dropzone-hint">JPG, PNG, WebP o GIF hasta 10MB</span>
                                                    </div>
                                                    <button type="button" class="dropzone-btn">Examinar</button>
                                                </div>
                                            </div>

                                            <!-- URL fallback -->
                                            <div class="ap-field" style="margin-top: 4px;">
                                                <label class="ap-label" for="gallery-input-url" style="font-size: 0.72rem; color: #884d63;">O Enlace directo de Imagen (URL)</label>
                                                <input type="url" id="gallery-input-url" name="image_url" class="ap-input" placeholder="https://ejemplo.com/fotografia.jpg">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Actions Bar -->
                                    <div class="curation-form-actions">
                                        <div class="actions-left">
                                            <button type="submit" class="ap-cta-btn" id="gallery-submit-btn">
                                                <span>🌸</span>
                                                <span id="gallery-submit-btn-text">Guardar en Galería</span>
                                            </button>
                                            <button type="button" class="ap-btn-cancel" id="gallery-cancel-edit-btn" style="display: none;">
                                                <span>✕</span> Cancelar Edición
                                            </button>
                                        </div>
                                        <div class="actions-right">
                                            <span id="gallery-form-status" class="curation-status-pill"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Listado de Obras Actuales -->
                            <div class="admin-gallery-items-container" style="margin-top: 36px;">
                                <div class="ap-sub-header">
                                    <div>
                                        <h4 class="ap-sub-title">Obras Publicadas Actualmente</h4>
                                        <p class="ap-sub-desc">Todas las piezas sincronizadas y visibles para los visitantes del jardín.</p>
                                    </div>
                                </div>
                                <div id="admin-gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                                    <!-- Renderizado vía JS -->
                                </div>
                            </div>
                        </div>

                        <!-- SUBPANEL 2: DESTINOS -->
                        <div class="admin-subpanel" id="subpanel-dest" style="display: none;">
                            <div class="admin-curation-card">
                                <div class="curation-card-header">
                                    <div class="curation-card-badge">
                                        <span class="curation-badge-icon">✈️</span>
                                        <div>
                                            <h3 id="dest-form-title-text" class="curation-badge-title">Añadir Destino al Mapa de Sueños</h3>
                                            <p class="curation-badge-sub">Define los lugares soñados y las aventuras que esperan en el horizonte</p>
                                        </div>
                                    </div>
                                    <div id="dest-mode-badge" class="curation-mode-pill">Modo Creación</div>
                                </div>

                                <form id="admin-dest-form" class="ap-form" enctype="multipart/form-data">
                                    <input type="hidden" id="dest-item-id" name="dest_id" value="">
                                    
                                    <div class="gallery-editorial-grid">
                                        <div class="gallery-col-meta">
                                            <div class="gallery-meta-row-two">
                                                <div class="ap-field">
                                                    <label class="ap-label" for="dest-input-title">Título del Destino *</label>
                                                    <input type="text" id="dest-input-title" name="title" class="ap-input" placeholder="Ej.: Un verano junto al mar" required>
                                                </div>
                                                <div class="ap-field">
                                                    <label class="ap-label" for="dest-input-tag">Lugar / Tag *</label>
                                                    <input type="text" id="dest-input-tag" name="location_tag" class="ap-input" placeholder="Ej.: ITALIA · COSTA AMALFITANA" required>
                                                </div>
                                            </div>

                                            <div class="ap-field">
                                                <label class="ap-label" for="dest-input-desc">Descripción del Sueño *</label>
                                                <textarea id="dest-input-desc" name="description" class="ap-textarea" rows="3" placeholder="Calles de colores, agua tranquila y tardes sin prisa." required></textarea>
                                            </div>
                                        </div>

                                        <div class="gallery-col-media">
                                            <label class="ap-label">Fotografía del Destino</label>
                                            
                                            <div class="gallery-preview-wrapper" id="dest-preview-container">
                                                <div class="gallery-preview-inner" id="dest-preview-box">
                                                    <div class="gallery-preview-empty" id="dest-preview-placeholder">
                                                        <span class="preview-empty-icon">🗺️</span>
                                                        <span class="preview-empty-text">Sin imagen seleccionada</span>
                                                        <small class="preview-empty-sub">Carga un archivo o escribe una URL para previsualizar</small>
                                                    </div>
                                                    <img id="dest-preview-img" src="" alt="Vista previa" class="gallery-preview-image" style="display: none;">
                                                </div>
                                            </div>

                                            <div class="ap-file-dropzone" id="dest-dropzone">
                                                <input type="file" id="dest-input-file" name="image" class="dropzone-file-input" accept="image/*">
                                                <div class="dropzone-content">
                                                    <span class="dropzone-icon">📁</span>
                                                    <div class="dropzone-text">
                                                        <strong id="dest-dropzone-label">Seleccionar archivo del dispositivo</strong>
                                                        <span class="dropzone-hint">JPG, PNG, WebP hasta 10MB</span>
                                                    </div>
                                                    <button type="button" class="dropzone-btn">Examinar</button>
                                                </div>
                                            </div>

                                            <div class="ap-field" style="margin-top: 4px;">
                                                <label class="ap-label" for="dest-input-url" style="font-size: 0.72rem; color: #884d63;">O Enlace directo de Imagen (URL)</label>
                                                <input type="url" id="dest-input-url" name="image_url" class="ap-input" placeholder="https://ejemplo.com/destino.jpg">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="curation-form-actions">
                                        <div class="actions-left">
                                            <button type="submit" class="ap-cta-btn" id="dest-submit-btn">
                                                <span>✈️</span>
                                                <span id="dest-submit-btn-text">Guardar Destino</span>
                                            </button>
                                            <button type="button" class="ap-btn-cancel" id="dest-cancel-edit-btn" style="display: none;">
                                                <span>✕</span> Cancelar
                                            </button>
                                        </div>
                                        <div class="actions-right">
                                            <span id="dest-form-status" class="curation-status-pill"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="admin-dest-items-container" style="margin-top: 36px;">
                                <div class="ap-sub-header">
                                    <div>
                                        <h4 class="ap-sub-title">Destinos Registrados</h4>
                                        <p class="ap-sub-desc">Puntos del mapa que esperan ser descubiertos por Carla Lorena.</p>
                                    </div>
                                </div>
                                <div id="admin-dest-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                                    <!-- Renderizado vía JS -->
                                </div>
                            </div>
                        </div>

                        <!-- SUBPANEL 3: POEMAS -->
                        <div class="admin-subpanel" id="subpanel-poem" style="display: none;">
                            <div class="admin-curation-card">
                                <div class="curation-card-header">
                                    <div class="curation-card-badge">
                                        <span class="curation-badge-icon">📜</span>
                                        <div>
                                            <h3 id="poem-form-title-text" class="curation-badge-title">Añadir Poema a la Antología</h3>
                                            <p class="curation-badge-sub">Escribe versos y pensamientos que quedarán grabados en el pergamino</p>
                                        </div>
                                    </div>
                                    <div id="poem-mode-badge" class="curation-mode-pill">Modo Creación</div>
                                </div>

                                <form id="admin-poem-form" class="ap-form">
                                    <input type="hidden" id="poem-item-id" name="poem_id" value="">
                                    
                                    <div class="gallery-meta-row-two" style="margin-bottom: 16px;">
                                        <div class="ap-field">
                                            <label class="ap-label" for="poem-input-title">Título del Poema *</label>
                                            <input type="text" id="poem-input-title" name="title" class="ap-input" placeholder="Ej.: Canto al Atardecer de Primavera" required>
                                        </div>
                                        <div class="ap-field">
                                            <label class="ap-label" for="poem-input-mood">Ocasión / Estado de ánimo</label>
                                            <input type="text" id="poem-input-mood" name="mood" class="ap-input" placeholder="Ej.: Para leer con una taza de té y silencio amable">
                                        </div>
                                    </div>

                                    <div class="gallery-meta-row-two" style="margin-bottom: 16px;">
                                        <div class="ap-field">
                                            <label class="ap-label" for="poem-input-s1">Primera Estrofa * (Usa saltos de línea)</label>
                                            <textarea id="poem-input-s1" name="stanza1" class="ap-textarea" rows="4" placeholder="Hay jardines que nacen en la tierra,&#10;y otros que florecen en la mirada..." required></textarea>
                                        </div>
                                        <div class="ap-field">
                                            <label class="ap-label" for="poem-input-s2">Segunda Estrofa (Opcional)</label>
                                            <textarea id="poem-input-s2" name="stanza2" class="ap-textarea" rows="4" placeholder="Que ningún invierno apague tu calidez,&#10;porque en ti siempre amanece abril..."></textarea>
                                        </div>
                                    </div>

                                    <div class="ap-field" style="margin-bottom: 18px;">
                                        <label class="ap-label" for="poem-input-sig">Firma / Dedicatoria</label>
                                        <input type="text" id="poem-input-sig" name="signature" class="ap-input" placeholder="Ej.: Escrito con devoción para Carla Lorena, mi Beiby">
                                    </div>

                                    <div class="curation-form-actions">
                                        <div class="actions-left">
                                            <button type="submit" class="ap-cta-btn" id="poem-submit-btn">
                                                <span>📜</span>
                                                <span id="poem-submit-btn-text">Guardar Poema</span>
                                            </button>
                                            <button type="button" class="ap-btn-cancel" id="poem-cancel-edit-btn" style="display: none;">
                                                <span>✕</span> Cancelar
                                            </button>
                                        </div>
                                        <div class="actions-right">
                                            <span id="poem-form-status" class="curation-status-pill"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="admin-poem-items-container" style="margin-top: 36px;">
                                <div class="ap-sub-header">
                                    <div>
                                        <h4 class="ap-sub-title">Antología de Versos Publicados</h4>
                                        <p class="ap-sub-desc">Poemas y cartas del alma expuestos en el pergamino interactivo.</p>
                                    </div>
                                </div>
                                <div id="admin-poem-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
                                    <!-- Renderizado vía JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="admin-panel" id="admin-media" role="tabpanel" aria-labelledby="admin-media-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M9 17.5V6.8L19 4.8V15.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="6.8" cy="17.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
            <circle cx="16.8" cy="15.5" r="2.5" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.6"/>
        </svg>
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

                    <!-- ═══════════════════════════ PANEL: SONIDOS DEL CLIMA ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-season-audios" role="tabpanel" aria-labelledby="admin-season-audios-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M4 9.5H15.5C17.2 9.5 18.5 8.2 18.5 6.5C18.5 4.8 17.2 3.5 15.5 3.5C14 3.5 12.8 4.5 12.6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M3 13.5H18.5C20.2 13.5 21.5 14.8 21.5 16.5C21.5 18.2 20.2 19.5 18.5 19.5C17 19.5 15.8 18.5 15.6 17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M5 17.2H11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <circle cx="7.5" cy="6" r="1.3" fill="currentColor"/>
        </svg>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Atmósfera y Sonido Ambiental</p>
                                <h2 id="admin-season-audios-title" class="ap-title">Sonidos de las Estaciones</h2>
                                <p class="ap-desc">Carga música, efectos y melodías reales (MP3, WAV, OGG) para cada estación del jardín. Puedes subir varios sonidos a la vez.</p>
                            </div>
                        </div>

                        <!-- Tarjeta de subida de audios -->
                        <div class="ap-card" style="margin-bottom: 24px; padding: 24px; background: #ffffff; border-radius: 20px; border: 1.5px solid #ffd2e5; box-shadow: 0 8px 24px rgba(181, 48, 79, 0.05);">
                            <h3 style="margin: 0 0 14px 0; font-size: 16px; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                                <span>📤</span> Subir Audios por Estación
                            </h3>
                            <form id="admin-season-audio-form" enctype="multipart/form-data">
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(220px, 100%), 1fr)); gap: 16px; margin-bottom: 16px;">
                                    <div>
                                        <label for="season-audio-select" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                            1. SELECCIONA UNA ESTACIÓN *
                                        </label>
                                        <select id="season-audio-select" name="season" class="ap-select" required style="width: 100%;">
                                            <option value="spring">🌸 Primavera Eterna</option>
                                            <option value="rain">🌧️ Lluvia Romántica</option>
                                            <option value="summer">☀️ Verano Mágico</option>
                                            <option value="autumn">🍂 Otoño Cálido</option>
                                            <option value="winter">❄️ Invierno Encantado</option>
                                            <option value="stars">🌠 Noche de Estrellas</option>
                                            <option value="bubbles">🫧 Burbujas de Ensueño</option>
                                            <option value="clear">✨ Calma Serena</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="season-audio-title" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                            2. Título o Descripción (Opcional)
                                        </label>
                                        <input type="text" id="season-audio-title" name="title" class="ap-input" placeholder="Ej: Brisa con piano suave" style="width: 100%;" maxlength="160">
                                    </div>
                                </div>

                                <div style="margin-bottom: 18px;">
                                    <label for="season-audio-files" style="display: block; font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em;">
                                        3. Seleccionar archivo(s) de audio (MP3, WAV, OGG, AAC - Máx 30MB c/u)
                                    </label>
                                    <input type="file" id="season-audio-files" name="files[]" multiple accept="audio/*,.mp3,.wav,.ogg,.oga,.m4a,.aac" class="ap-file-input" required style="width: 100%;">
                                    <small style="display: block; margin-top: 5px; color: var(--text-muted); font-size: 11.5px;">
                                        💡 Puedes seleccionar múltiples archivos a la vez manteniendo presionada la tecla Ctrl / Shift.
                                    </small>
                                </div>

                                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                                    <span id="season-audio-upload-status" style="font-size: 12px; color: var(--frambuesa); display: none;"></span>
                                    <button type="submit" class="ap-cta-btn" id="btn-submit-season-audio">
                                        <span>⬆️</span> Cargar Sonidos
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Filtro por estación y listado de audios subidos -->
                        <div class="ap-filters" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div class="ap-filter-item">
                                <label class="ap-filter-label" for="filter-season-audios">Filtrar por estación:</label>
                                <select class="ap-select" id="filter-season-audios" aria-label="Filtrar por estación">
                                    <option value="">Todas las estaciones</option>
                                    <option value="spring">🌸 Primavera</option>
                                    <option value="rain">🌧️ Lluvia</option>
                                    <option value="summer">☀️ Verano</option>
                                    <option value="autumn">🍂 Otoño</option>
                                    <option value="winter">❄️ Invierno</option>
                                    <option value="stars">🌠 Estrellas</option>
                                    <option value="bubbles">🫧 Burbujas</option>
                                    <option value="clear">✨ Calma</option>
                                </select>
                            </div>
                            <button type="button" class="button button-outline" id="btn-refresh-season-audios" style="padding: 6px 14px; font-size: 12px;">
                                🔄 Actualizar lista
                            </button>
                        </div>

                        <div class="ap-table-wrap">
                            <table class="admin-table" id="admin-season-audios-table">
                                <thead>
                                    <tr>
                                        <th><span class="th-inner"># ID</span></th>
                                        <th><span class="th-inner">Estación</span></th>
                                        <th><span class="th-inner">✦ Título / Archivo</span></th>
                                        <th><span class="th-inner">▶ Reproducir</span></th>
                                        <th><span class="th-inner">Tamaño</span></th>
                                        <th><span class="th-inner">Estado</span></th>
                                        <th><span class="th-inner">Acciones</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 24px; color: var(--text-muted);">
                                            Cargando sonidos del clima...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ═══════════════════════════ PANEL: QUIZ ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-quiz" role="tabpanel" aria-labelledby="admin-quiz-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 3.5C13.8 3.5 15 5 15 6.8C15 7.4 14.8 8 14.5 8.5C15 8.2 15.6 8 16.2 8C18 8 19.5 9.2 19.5 11C19.5 12.8 18 14 16.2 14C15.6 14 15 13.8 14.5 13.5C14.8 14 15 14.6 15 15.2C15 17 13.8 18.5 12 18.5C10.2 18.5 9 17 9 15.2C9 14.6 9.2 14 9.5 13.5C9 13.8 8.4 14 7.8 14C6 14 4.5 12.8 4.5 11C4.5 9.2 6 8 7.8 8C8.4 8 9 8.2 9.5 8.5C9.2 8 9 7.4 9 6.8C9 5 10.2 3.5 12 3.5Z" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
            <circle cx="12" cy="11" r="2.2" fill="currentColor"/>
            <path d="M12 18.5V21.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
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
                                    <span class="ap-quiz-card-icon">🏵️</span>
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
                                    <button class="ap-btn-primary" type="submit">🌸 Guardar configuración</button>
                                </form>
                            </div>
                            <!-- Recompensa -->
                            <div class="ap-quiz-card">
                                <div class="ap-quiz-card-header">
                                    <span class="ap-quiz-card-icon">🌹</span>
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
                                    <h3 class="ap-sub-title">🌸 Banco de Preguntas</h3>
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

                    <!-- ═══════════════════════════ PANEL: USUARIOS ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-users" role="tabpanel" aria-labelledby="admin-users-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="9" cy="8.5" r="3.2" fill="currentColor" fill-opacity="0.16" stroke="currentColor" stroke-width="1.6"/>
            <path d="M3.8 19.2C3.8 16.1 6.1 14 9 14C11.9 14 14.2 16.1 14.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M17.5 6.2C16.2 6.2 15.2 7.3 15.2 8.7C15.2 10.4 16.5 11.4 17.5 12.2C18.5 11.4 19.8 10.4 19.8 8.7C19.8 7.3 18.8 6.2 17.5 6.2Z" fill="currentColor" fill-opacity="0.22" stroke="currentColor" stroke-width="1.5"/>
            <path d="M15.2 15C17.8 15.2 19.8 16.9 20.2 19.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
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

                    <!-- ═══════════════════════════ PANEL: TRÁFICO & VISITAS ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-traffic" role="tabpanel" aria-labelledby="admin-traffic-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-sapphire">
                                <svg class="admin-svg-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                            </div>
                            <div class="ap-header-text">
                                <p class="ap-eyebrow">Auditoría y Monitoreo en Tiempo Real</p>
                                <h2 id="admin-traffic-title" class="ap-title">Tráfico y Presencia de Usuarios</h2>
                                <p class="ap-desc">Supervisión en vivo de visitantes, miembros autenticados, pantallas recorridas y tiempo de permanencia.</p>
                            </div>
                            <div style="display:flex; gap:10px;">
                                <button class="ap-cta-btn" type="button" id="btn-refresh-traffic" style="background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);">
                                    <span>🔄</span> Actualizar en vivo
                                </button>
                                <button class="ap-btn-secondary" type="button" id="btn-purge-traffic" title="Purgar registros antiguos">
                                    <span>🗑️</span> Purgar antiguos
                                </button>
                            </div>
                        </div>

                        <!-- Métricas / KPIs de Tráfico -->
                        <div class="admin-stats-grid" style="margin-bottom: 24px;">
                            <article class="admin-stat-card stat-online">
                                <div class="stat-card-icon-wrap" style="background: rgba(34, 197, 94, 0.15); color: #16a34a;">
                                    <span class="live-pulse-dot" style="width: 14px; height: 14px; background: #22c55e;"></span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="traffic-stat-online">0</strong>
                                    <span class="stat-card-label">En Línea Ahora (5 min)</span>
                                </div>
                            </article>
                            <article class="admin-stat-card stat-visits">
                                <div class="stat-card-icon-wrap" style="background: rgba(14, 165, 233, 0.15); color: #0284c7;">
                                    <span>👥</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="traffic-stat-visits">0</strong>
                                    <span class="stat-card-label">Visitas Hoy (Páginas)</span>
                                </div>
                            </article>
                            <article class="admin-stat-card stat-uniques">
                                <div class="stat-card-icon-wrap" style="background: rgba(244, 63, 94, 0.15); color: #e11d48;">
                                    <span>🌸</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="traffic-stat-uniques">0</strong>
                                    <span class="stat-card-label">Visitantes Únicos Hoy</span>
                                </div>
                            </article>
                            <article class="admin-stat-card stat-registered">
                                <div class="stat-card-icon-wrap" style="background: rgba(234, 179, 8, 0.15); color: #ca8a04;">
                                    <span>👑</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="traffic-stat-registered">0</strong>
                                    <span class="stat-card-label">Registrados Activos Hoy</span>
                                </div>
                            </article>
                            <article class="admin-stat-card stat-topscreen">
                                <div class="stat-card-icon-wrap" style="background: rgba(168, 85, 247, 0.15); color: #9333ea;">
                                    <span>⭐</span>
                                </div>
                                <div class="stat-card-data">
                                    <strong id="traffic-stat-topscreen" style="font-size: 1.4rem;">inicio</strong>
                                    <span class="stat-card-label">Pantalla Más Popular</span>
                                </div>
                            </article>
                        </div>

                        <!-- Barra de Filtros y Búsqueda -->
                        <div class="ap-filter-bar" style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:18px; align-items:center;">
                            <div class="ap-field" style="margin:0; min-width:180px;">
                                <select class="ap-input" id="traffic-filter-type">
                                    <option value="all">✦ Todos los visitantes</option>
                                    <option value="registered">👑 Solo Usuarios Registrados</option>
                                    <option value="guests">🌐 Solo Invitados Anónimos</option>
                                    <option value="online">🟢 Solo Conectados Ahora</option>
                                </select>
                            </div>
                            <div class="ap-field" style="margin:0; min-width:160px;">
                                <select class="ap-input" id="traffic-filter-screen">
                                    <option value="all">🗺️ Todas las pantallas</option>
                                    <option value="inicio">🌸 Inicio</option>
                                    <option value="galeria">🖼️ Galería</option>
                                    <option value="mapa">🗺️ Mapa</option>
                                    <option value="carla">👑 Carla Lorena</option>
                                    <option value="familia">💎 Mi Familia</option>
                                    <option value="jardin">🌷 Jardín</option>
                                    <option value="blog">✍️ Blog</option>
                                    <option value="diario">📖 Diario</option>
                                    <option value="juegos">🎮 Juegos</option>
                                    <option value="admin">⚙️ Admin</option>
                                </select>
                            </div>
                            <div class="ap-field" style="margin:0; min-width:150px;">
                                <select class="ap-input" id="traffic-filter-range">
                                    <option value="today">📅 Hoy</option>
                                    <option value="7days">📅 Últimos 7 días</option>
                                    <option value="30days">📅 Últimos 30 días</option>
                                    <option value="all">📅 Todo el historial</option>
                                </select>
                            </div>
                            <div class="ap-field" style="margin:0; flex:1; min-width:220px;">
                                <input class="ap-input" type="search" id="traffic-search-input" placeholder="Buscar por IP, usuario, navegador o dispositivo...">
                            </div>
                        </div>

                        <!-- Tabla de Auditoría de Tráfico -->
                        <div class="ap-table-wrap">
                            <table class="admin-table" id="admin-traffic-table">
                                <thead>
                                    <tr>
                                        <th><span class="th-inner"># ID</span></th>
                                        <th><span class="th-inner">👤 Tipo / Usuario</span></th>
                                        <th><span class="th-inner">📱 Dispositivo & Navegador</span></th>
                                        <th><span class="th-inner">📍 Pantalla / Ruta</span></th>
                                        <th><span class="th-inner">🌐 Dirección IP</span></th>
                                        <th><span class="th-inner">⏱ Tiempo Activo</span></th>
                                        <th><span class="th-inner">🕒 Última Actividad</span></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <nav class="admin-pagination" id="admin-traffic-pagination" aria-label="Paginación tráfico"></nav>
                    </div>

                    <!-- ═══════════════════════════ PANEL: AJUSTES ═══════════════════════════ -->
                    <div class="admin-panel" id="admin-settings" role="tabpanel" aria-labelledby="admin-settings-title" hidden>
                        <div class="ap-header">
                            <div class="ap-header-icon-wrap ap-icon-rose">
                                <svg class="admin-svg-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="3.2" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="1.6"/>
            <path d="M12 3V5.5M12 18.5V21M3 12H5.5M18.5 12H21M5.6 5.6L7.4 7.4M16.6 16.6L18.4 18.4M18.4 5.6L16.6 7.4M7.4 16.6L5.6 18.4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
        </svg>
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
                                    <span class="ap-section-icon">🌸</span>
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
                                    <span class="ap-section-icon">🌷</span>
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
                                <button class="ap-btn-primary" type="submit">🌸 Guardar configuración</button>
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