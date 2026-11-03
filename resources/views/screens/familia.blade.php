        @php
            $familyAdminActive = isset($isFamilyAdmin) ? (bool) $isFamilyAdmin : (auth()->check() && ((auth()->user()->is_admin ?? false) || in_array(auth()->id(), [1, 2], true)));
            $membersCollection = isset($familyMembers) ? $familyMembers : collect();
            $memoriesCollection = isset($familyMemories) ? $familyMemories : collect();
        @endphp
        <section class="screen"
                 data-screen="familia"
                 id="screen-familia"
                 data-family-unlocked="{{ $familyAdminActive ? '1' : '0' }}"
                 aria-labelledby="family-sanctuary-title"
                 hidden>
            <div class="page-shell family-sanctuary-shell">

                <!-- Barra Superior de Navegación y Estado de Seguridad -->
                <div class="family-top-nav-bar">
                    <a class="family-back-map-btn" href="#mapa" data-go="mapa">
                        <span aria-hidden="true">←</span> Volver al Mapa del Jardín Secreto
                    </a>
                    <div class="family-security-pill" id="family-security-pill">
                        <span class="family-sec-dot {{ $familyAdminActive ? 'is-unlocked' : 'is-locked' }}" id="family-sec-dot"></span>
                        <span id="family-sec-status-text">
                            {{ $familyAdminActive ? '🔒 BÓVEDA FAMILIAR DESBLOQUEADA · MODO ADMINISTRADOR' : '🔐 ACCESO RESTRINGIDO · EXCLUSIVO ADMINISTRADOR' }}
                        </span>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════════════ -->
                <!--  ESTADO 1: PANTALLA DE BLOQUEO CON LOGIN DE ADMINISTRADOR EN VIVO   -->
                <!-- ═══════════════════════════════════════════════════════════════════ -->
                <div class="family-vault-gate" id="family-vault-gate" @if($familyAdminActive) hidden @endif>
                    <div class="family-vault-card">
                        <div class="family-vault-sapphire-emblem" aria-hidden="true">
                            <svg width="78" height="78" viewBox="0 0 84 84" fill="none">
                                <defs>
                                    <radialGradient id="sapphireVaultCore" cx="35%" cy="30%" r="70%">
                                        <stop offset="0%" stop-color="#e0f2fe"/>
                                        <stop offset="45%" stop-color="#38bdf8"/>
                                        <stop offset="80%" stop-color="#1d4ed8"/>
                                        <stop offset="100%" stop-color="#1e1b4b"/>
                                    </radialGradient>
                                    <linearGradient id="sapphireGoldRim" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fef08a"/>
                                        <stop offset="50%" stop-color="#e0ab00"/>
                                        <stop offset="100%" stop-color="#92400e"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="42" cy="42" r="39" fill="rgba(255,255,255,0.92)" stroke="url(#sapphireGoldRim)" stroke-width="2.5"/>
                                <polygon points="42,10 66,24 66,60 42,74 18,60 18,24" fill="url(#sapphireVaultCore)" stroke="url(#sapphireGoldRim)" stroke-width="2"/>
                                <polygon points="42,20 56,29 56,55 42,64 28,55 28,29" fill="none" stroke="rgba(255,255,255,0.65)" stroke-width="1.2"/>
                                <text x="42" y="48" text-anchor="middle" font-size="20">🔒</text>
                            </svg>
                        </div>

                        <span class="family-vault-eyebrow">PÉTALO DE ZAFIRO REAL · RINCÓN N° 12</span>
                        <h1 class="family-vault-title">Santuario Privado · <em>Mi Familia</em></h1>
                        <p class="family-vault-desc">
                            Este rincón guarda el álbum familiar de <strong>Carla Lorena</strong>, <strong>Adrián</strong>, nuestra mascota <strong>Ody</strong> y <strong>nuestros beibys</strong>. Ingresa tu usuario y contraseña de administrador para abrir la bóveda.
                        </p>

                        <form class="family-vault-login-form" id="family-inline-unlock-form" autocomplete="on">
                            <div class="family-vault-field">
                                <label for="family-inline-login">Usuario o Correo de Administrador</label>
                                <input type="text"
                                       id="family-inline-login"
                                       name="login"
                                       required
                                       placeholder="Ej.: carlalorenah o carlalorenah@gmail.com"
                                       autocomplete="username">
                            </div>

                            <div class="family-vault-field">
                                <label for="family-inline-password">Contraseña</label>
                                <input type="password"
                                       id="family-inline-password"
                                       name="password"
                                       required
                                       placeholder="Ingresa tu contraseña de administrador"
                                       autocomplete="current-password">
                            </div>

                            <div class="family-vault-error" id="family-inline-error" role="alert" hidden></div>

                            <button type="submit" class="button button-primary family-vault-submit-btn" id="family-inline-submit-btn">
                                <span>🔓 Desbloquear Álbum Familiar</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════════════ -->
                <!--  ESTADO 2: SANTUARIO & ÁLBUM FAMILIAR INTERACTIVO DESBLOQUEADO      -->
                <!-- ═══════════════════════════════════════════════════════════════════ -->
                <div class="family-sanctuary-content" id="family-sanctuary-content" @if(!$familyAdminActive) hidden @endif>

                    <!-- Hero Editorial de Mi Familia -->
                    <header class="family-hero-banner" id="family-hero-banner">
                        <div class="family-hero-copy">
                            <div class="family-hero-badges">
                                <span class="family-sapphire-pill" id="family-header-pill">💎 ZAFIRO IMPERIAL · N° 12</span>
                                <span class="family-members-pill">👑 Carla Lorena · 💙 Adrián · 🐾 Ody · 🌟 Hijos</span>
                            </div>
                            <h1 id="family-sanctuary-title" class="family-hero-title">
                                Nuestro Álbum Familiar · <em>El Hogar de Nuestro Amor</em>
                            </h1>
                            <p class="family-hero-subtitle" id="family-sanctuary-subtitle">
                                Un santuario vivo e interactivo donde florecen las historias de <strong>Carla Lorena</strong>, <strong>Adrián</strong>, las travesuras de nuestra mascota <strong>Ody</strong> y la luz de <strong>nuestros hijos</strong>.
                            </p>

                            <div class="family-hero-actions">
                                <button type="button" class="button button-primary family-action-btn" id="btn-open-new-member-modal">
                                    <span aria-hidden="true">＋</span> Agregar Hijo / Integrante
                                </button>
                                <button type="button" class="button button-outline family-action-btn" id="btn-open-new-memory-modal">
                                    <span aria-hidden="true">📸</span> Subir Foto al Álbum Familiar
                                </button>
                                <button type="button" class="button button-outline family-action-btn" id="btn-edit-sanctuary-header" title="Editar títulos, textos y colores del santuario">
                                    <span aria-hidden="true">🎨</span> Personalizar Santuario
                                </button>
                            </div>
                        </div>

                        <!-- Estadísticas Dinámicas del Hogar -->
                        <div class="family-hero-stats-card">
                            <div class="family-stat-box">
                                <strong id="family-stat-members-count">{{ $membersCollection->count() }}</strong>
                                <span>Integrantes</span>
                            </div>
                            <div class="family-stat-box">
                                <strong id="family-stat-children-count">{{ $membersCollection->where('category', 'children')->count() }}</strong>
                                <span>Hijos</span>
                            </div>
                            <div class="family-stat-box">
                                <strong>🐾 1</strong>
                                <span>Mascota Ody</span>
                            </div>
                            <div class="family-stat-box">
                                <strong id="family-stat-memories-count">{{ $memoriesCollection->count() }}</strong>
                                <span>Recuerdos</span>
                            </div>
                        </div>
                    </header>

                    <!-- 1. CONSTELACIÓN & ÁRBOL FAMILIAR INTERACTIVO -->
                    <section class="family-constellation-section" aria-label="Árbol y Constelación Familiar Interactiva">
                        <div class="family-section-header">
                            <div>
                                <span class="eyebrow">VÍNCULOS ETERNOS EN TIEMPO REAL</span>
                                <h2>Constelación de Mi Familia</h2>
                            </div>
                            <p class="family-section-hint">Toca cualquier integrante de la constelación para explorar su perfil, editar su retrato o filtrar sus fotos.</p>
                        </div>

                        <div class="family-constellation-grid">
                            <!-- Lienzo Visual del Árbol Familiar -->
                            <div class="family-tree-canvas" id="family-tree-canvas">
                                <!-- Nivel Superior: Pareja Principal (Carla Lorena & Adrián) -->
                                <div class="family-tree-tier tier-parents">
                                    <div class="family-tree-couple-bridge" aria-hidden="true">
                                        <span class="couple-heart-spark">💎 ♡ 👑</span>
                                    </div>
                                    <div class="family-tree-nodes-row" id="family-tree-parents-row"></div>
                                </div>

                                <!-- Conector Central Dorado -->
                                <div class="family-tree-vertical-stem" aria-hidden="true">
                                    <span class="stem-jewel">✦</span>
                                </div>

                                <!-- Nivel Intermedio: Mascota Leal Ody + Semillas del Hogar (Hijos) -->
                                <div class="family-tree-tier tier-children">
                                    <div class="family-tree-nodes-row" id="family-tree-offspring-row"></div>
                                </div>
                            </div>

                            <!-- Tarjeta de Inspección Dinámica del Integrante Seleccionado -->
                            <aside class="family-spotlight-card" id="family-spotlight-card" aria-live="polite">
                                <div class="family-spotlight-photo-stage" id="family-spotlight-photo-stage">
                                    <div class="family-spotlight-blur" id="family-spotlight-blur"></div>
                                    <img class="family-spotlight-img" id="family-spotlight-img" src="/images/carla-hero.jpg" alt="Retrato del integrante seleccionado">
                                    <span class="family-spotlight-avatar-badge" id="family-spotlight-icon">👑</span>
                                    <button type="button" class="family-spotlight-fit-toggle" id="btn-spotlight-fit-toggle" title="Cambiar modo de ajuste (Foto completa / Llenar marco)" aria-label="Cambiar ajuste de imagen">
                                        <span class="fsft-icon" aria-hidden="true">⤢</span>
                                        <span class="fsft-text">Ajuste</span>
                                    </button>
                                </div>
                                <div class="family-spotlight-body">
                                    <span class="family-spotlight-role" id="family-spotlight-role">Corazón del Hogar · Mamá & Luz</span>
                                    <h3 class="family-spotlight-name" id="family-spotlight-name">Carla Lorena</h3>
                                    <span class="family-spotlight-date" id="family-spotlight-date">✦ Reina de Nuestro Jardín</span>
                                    <p class="family-spotlight-bio" id="family-spotlight-bio">
                                        El alma de nuestra familia, quien llena cada rincón de ternura, elegancia, alegría y amor incondicional.
                                    </p>
                                    <blockquote class="family-spotlight-quote" id="family-spotlight-quote">
                                        «La familia es el jardín donde el amor florece para siempre.»
                                    </blockquote>
                                    <div class="family-spotlight-actions">
                                        <button type="button" class="button button-sm button-primary" id="btn-spotlight-edit-member">
                                            ✏️ Editar Perfil / Foto
                                        </button>
                                        <button type="button" class="button button-sm button-outline" id="btn-spotlight-filter-memories">
                                            📸 Ver sus Recuerdos
                                        </button>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </section>

                    <!-- 2. TARJETAS DE INTEGRANTES DE LA FAMILIA (CARLA LORENA, ADRIÁN, ODY E HIJOS) -->
                    <section class="family-members-section" aria-label="Perfiles de los integrantes de la familia">
                        <div class="family-section-header">
                            <div>
                                <span class="eyebrow">PROTAGONISTAS DE NUESTRA HISTORIA</span>
                                <h2>Integrantes de Nuestro Hogar</h2>
                            </div>
                            <button type="button" class="button button-sm button-outline" id="btn-Add-Child-Shortcut">
                                🌟 ＋ Añadir otro Hijo / Integrante
                            </button>
                        </div>

                        <div class="family-members-cards-grid" id="family-members-cards-grid"></div>
                    </section>

                    <!-- 3. ÁLBUM FOTOGRÁFICO FAMILIAR INTERACTIVO -->
                    <section class="family-album-section" id="family-album-section" aria-label="Álbum fotográfico de Mi Familia">
                        <div class="family-album-toolbar">
                            <div class="family-album-title-block">
                                <span class="eyebrow">MEMORIAS INOLVIDABLES · AUTOAJUSTE INTELIGENTE</span>
                                <h2>Álbum de Recuerdos Familiares</h2>
                            </div>

                            <div class="family-album-controls">
                                <div class="family-filter-pills" id="family-filter-pills" role="tablist" aria-label="Filtrar recuerdos por integrante">
                                    <button type="button" class="family-filter-pill is-active" data-family-filter="todos">✨ Toda la Familia</button>
                                    <button type="button" class="family-filter-pill" data-family-filter="carla">👑 Carla Lorena</button>
                                    <button type="button" class="family-filter-pill" data-family-filter="adrian">💎 Adrián</button>
                                    <button type="button" class="family-filter-pill" data-family-filter="ody">🐾 Mascota Ody</button>
                                    <button type="button" class="family-filter-pill" data-family-filter="children">🌟 Nuestros Hijos</button>
                                </div>

                                <div class="family-search-row">
                                    <input type="search"
                                           id="family-memories-search"
                                           class="family-memories-search-input"
                                           placeholder="🔍 Buscar recuerdo por título, historia o integrante...">
                                    <button type="button" class="button button-primary button-sm" id="btn-album-add-photo">
                                        📸 ＋ Nueva Foto Familiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="family-memories-grid" id="family-memories-grid"></div>

                        <div class="family-memories-empty" id="family-memories-empty" hidden>
                            <span style="font-size: 2rem;">💎</span>
                            <strong>Aún no hay recuerdos en esta categoría</strong>
                            <p>Sube una fotografía especial de Carla Lorena, Adrián, Ody o tus hijos para iluminar este rincón.</p>
                        </div>
                    </section>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <!--  MODAL FLOTANTE DE ACCESO RÁPIDO (AL TOCAR EL PÉTALO EN EL MAPA)   -->
            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <dialog class="family-auth-dialog" id="family-quick-auth-dialog" aria-labelledby="family-quick-auth-title">
                <div class="family-auth-modal-card">
                    <button type="button" class="family-modal-close-btn" id="btn-close-family-auth-modal" aria-label="Cerrar">✕</button>
                    <div class="family-auth-modal-badge">💎 ZAFIRO PRIVADO · MI FAMILIA</div>
                    <h3 id="family-quick-auth-title">Acceso Exclusivo de Administrador</h3>
                    <p class="family-auth-modal-sub">
                        Ingresa tu usuario y contraseña de administrador para entrar al álbum familiar de <strong>Carla Lorena, Adrián, Ody y sus hijos</strong>.
                    </p>

                    <form id="family-modal-unlock-form" class="family-vault-login-form">
                        <div class="family-vault-field">
                            <label for="family-modal-login">Usuario o Correo</label>
                            <input type="text" id="family-modal-login" name="login" required placeholder="carlalorenah o carlalorenah@gmail.com" autocomplete="username">
                        </div>
                        <div class="family-vault-field">
                            <label for="family-modal-password">Contraseña</label>
                            <input type="password" id="family-modal-password" name="password" required placeholder="Contraseña de administrador" autocomplete="current-password">
                        </div>
                        <div class="family-vault-error" id="family-modal-error" role="alert" hidden></div>
                        <div class="family-modal-actions">
                            <button type="button" class="button button-outline" id="btn-cancel-family-auth-modal">Cancelar</button>
                            <button type="submit" class="button button-primary" id="family-modal-submit-btn">🔓 Ingresar a Mi Familia</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <!--  MODAL: CREAR / EDITAR PERFIL DE INTEGRANTE O HIJO                  -->
            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <dialog class="family-editor-dialog" id="family-member-editor-dialog" aria-labelledby="family-member-modal-title">
                <div class="family-editor-modal-card">
                    <header class="family-editor-header">
                        <div>
                            <span class="eyebrow">CONSTELACIÓN FAMILIAR · AUTOAJUSTE DE RETRATO</span>
                            <h3 id="family-member-modal-title">Agregar Integrante / Hijo</h3>
                        </div>
                        <button type="button" class="family-modal-close-btn" id="btn-close-member-modal" aria-label="Cerrar">✕</button>
                    </header>

                    <form id="family-member-editor-form" enctype="multipart/form-data">
                        <input type="hidden" id="family-member-id" name="member_id" value="">

                        <label class="family-photo-dropzone" for="family-member-photo-input">
                            <input type="file" id="family-member-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" hidden>
                            <div class="family-dropzone-placeholder" id="family-member-dropzone-empty">
                                <span style="font-size: 2rem;">📸</span>
                                <strong>Seleccionar fotografía del integrante</strong>
                                <small>Se autoajustará automáticamente sin recortar rostros</small>
                            </div>
                            <div class="family-dropzone-preview" id="family-member-dropzone-preview" hidden>
                                <div class="family-dropzone-blur" id="family-member-preview-blur"></div>
                                <img id="family-member-preview-img" src="" alt="Vista previa del integrante">
                            </div>
                        </label>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-member-name">Nombre del Integrante</label>
                                <input type="text" id="family-member-name" name="name" required maxlength="120" placeholder="Ej.: Mateo Adrián / Sofía / Ody">
                            </div>
                            <div class="family-vault-field">
                                <label for="family-member-category">Grupo Familiar</label>
                                <select id="family-member-category" name="category" required>
                                    <option value="children">🌟 Hijo / Hija</option>
                                    <option value="carla">👑 Carla Lorena</option>
                                    <option value="adrian">💎 Adrián</option>
                                    <option value="ody">🐾 Mascota Ody</option>
                                </select>
                            </div>
                        </div>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-member-role">Título Cariñoso / Rol</label>
                                <input type="text" id="family-member-role" name="role_badge" required maxlength="140" placeholder="Ej.: Hijo Amado · Pequeño Sol">
                            </div>
                            <div class="family-vault-field">
                                <label for="family-member-icon">Emblema / Icono</label>
                                <input type="text" id="family-member-icon" name="avatar_icon" maxlength="16" value="🌟" placeholder="🌟, 🌸, 🐾, 👑, 💎">
                            </div>
                        </div>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-member-theme-color">Color de Aura / Constelación</label>
                                <select id="family-member-theme-color" name="theme_color">
                                    <option value="sapphire">💎 Zafiro Imperial (Azul Real)</option>
                                    <option value="rose">🌹 Rosa Real (Fucsia Romance)</option>
                                    <option value="gold">👑 Oro Solar (Dorado Radiante)</option>
                                    <option value="emerald">🌿 Esmeralda Vida (Verde Botánico)</option>
                                    <option value="amethyst">🔮 Amatista Mística (Púrpura Amor)</option>
                                    <option value="amber">🐾 Ámbar Miel (Cálido Ody)</option>
                                    <option value="ruby">🌺 Rubí Pasión (Carmesí Profundo)</option>
                                    <option value="cyan">🩵 Turquesa Cielo (Celeste Sereno)</option>
                                </select>
                            </div>
                            <div class="family-vault-field">
                                <label for="family-member-date">Fecha Especial o Insignia</label>
                                <input type="text" id="family-member-date" name="special_date" maxlength="120" placeholder="Ej.: Nacido con amor · Semilla #1">
                            </div>
                        </div>

                        <div class="family-vault-field">
                            <label for="family-member-quote">Frase o Lema Especial</label>
                            <input type="text" id="family-member-quote" name="favorite_quote" maxlength="280" placeholder="Ej.: «Nuestra alegría de cada mañana»">
                        </div>

                        <div class="family-vault-field">
                            <label for="family-member-bio">semblanza o Dedicatoria Personal</label>
                            <textarea id="family-member-bio" name="bio" rows="3" maxlength="1000" placeholder="Escribe lo que hace único a este integrante de la familia..."></textarea>
                        </div>

                        <div class="family-modal-actions">
                            <button type="button" class="button button-outline" id="btn-cancel-member-modal">Cancelar</button>
                            <button type="submit" class="button button-primary" id="btn-save-member-modal">✨ Guardar Integrante</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <!--  MODAL: SUBIR / EDITAR FOTOGRAFÍA / RECUERDO AL ÁLBUM FAMILIAR      -->
            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <dialog class="family-editor-dialog" id="family-memory-editor-dialog" aria-labelledby="family-memory-modal-title">
                <div class="family-editor-modal-card">
                    <header class="family-editor-header">
                        <div>
                            <span class="eyebrow">ÁLBUM FAMILIAR · AUTOAJUSTE INTELIGENTE</span>
                            <h3 id="family-memory-modal-title">Subir Recuerdo al Álbum Familiar</h3>
                        </div>
                        <button type="button" class="family-modal-close-btn" id="btn-close-memory-modal" aria-label="Cerrar">✕</button>
                    </header>

                    <form id="family-memory-editor-form" enctype="multipart/form-data">
                        <input type="hidden" id="family-memory-id" name="memory_id" value="">

                        <label class="family-photo-dropzone" for="family-memory-image-input">
                            <input type="file" id="family-memory-image-input" name="image" accept="image/jpeg,image/png,image/webp,image/gif" hidden>
                            <div class="family-dropzone-placeholder" id="family-memory-dropzone-empty">
                                <span style="font-size: 2rem;">💎</span>
                                <strong>Selecciona una fotografía familiar</strong>
                                <small>Vertical, horizontal o cuadrada · Se autoajustará sin perder ningún detalle</small>
                            </div>
                            <div class="family-dropzone-preview" id="family-memory-dropzone-preview" hidden>
                                <div class="family-dropzone-blur" id="family-memory-preview-blur"></div>
                                <img id="family-memory-preview-img" src="" alt="Vista previa del recuerdo familiar">
                            </div>
                        </label>

                        <div class="family-vault-field">
                            <label for="family-memory-title">Título del Recuerdo</label>
                            <input type="text" id="family-memory-title" name="title" required maxlength="160" placeholder="Ej.: Tarde de juegos con Adrián, Ody y los niños">
                        </div>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-memory-category">Protagonista / Categoría</label>
                                <select id="family-memory-category" name="category" required>
                                    <option value="todos">✨ Toda la Familia</option>
                                    <option value="carla">👑 Carla Lorena</option>
                                    <option value="adrian">💎 Adrián</option>
                                    <option value="ody">🐾 Mascota Ody</option>
                                    <option value="children">🌟 Nuestros Hijos</option>
                                </select>
                            </div>
                            <div class="family-vault-field">
                                <label for="family-memory-member-select">Vincular a Integrante Específico</label>
                                <select id="family-memory-member-select" name="family_member_id">
                                    <option value="">— General de la categoría —</option>
                                </select>
                            </div>
                        </div>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-memory-date">Fecha o Momento</label>
                                <input type="text" id="family-memory-date" name="memory_date" maxlength="100" placeholder="Ej.: Domingo en familia · 2026">
                            </div>
                            <div class="family-vault-field">
                                <label for="family-memory-tag">Etiqueta Emocional</label>
                                <input type="text" id="family-memory-tag" name="emotion_tag" maxlength="80" placeholder="Ej.: Amor Eterno / Risas con Ody">
                            </div>
                        </div>

                        <div class="family-vault-field">
                            <label for="family-memory-story">Historia de este Momento</label>
                            <textarea id="family-memory-story" name="story" rows="3" maxlength="1500" placeholder="Describe qué ocurrió en esta fotografía para guardarlo por siempre..."></textarea>
                        </div>

                        <div class="family-modal-actions">
                            <button type="button" class="button button-outline" id="btn-cancel-memory-modal">Cancelar</button>
                            <button type="submit" class="button button-primary" id="btn-save-memory-modal">💎 Publicar en el Álbum Familiar</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <!--  VISOR LIGHTBOX A PANTALLA COMPLETA DEL ÁLBUM FAMILIAR              -->
            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <dialog class="family-lightbox-dialog" id="family-memory-lightbox-dialog" aria-label="Visor de recuerdo familiar">
                <div class="family-lightbox-shell">
                    <button type="button" class="family-lightbox-close" id="btn-close-family-lightbox" aria-label="Cerrar visor">✕</button>
                    <div class="family-lightbox-stage">
                        <div class="family-lightbox-blur" id="family-lightbox-blur"></div>
                        <img class="family-lightbox-img" id="family-lightbox-img" src="" alt="Fotografía familiar">
                    </div>
                    <div class="family-lightbox-meta">
                        <div class="family-lightbox-badges">
                            <span class="family-sapphire-pill" id="family-lightbox-tag">Amor Familiar</span>
                            <span class="family-lightbox-date" id="family-lightbox-date">Recuerdo Eterno</span>
                        </div>
                        <h3 id="family-lightbox-title">Recuerdo de Mi Familia</h3>
                        <p id="family-lightbox-story"></p>
                        <div class="family-lightbox-actions" style="margin-top: 14px; display: flex; gap: 10px;">
                            <button type="button" class="button button-sm button-primary" id="btn-lightbox-edit-photo">
                                ✏️ Cambiar / Editar esta Foto
                            </button>
                        </div>
                    </div>
                </div>
            </dialog>

            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <!--  MODAL: PERSONALIZAR TÍTULO, SUBTÍTULO Y COLORES DEL SANTUARIO       -->
            <!-- ═══════════════════════════════════════════════════════════════════ -->
            <dialog class="family-editor-dialog" id="family-sanctuary-header-dialog" aria-labelledby="family-header-modal-title">
                <div class="family-editor-modal-card">
                    <header class="family-editor-header">
                        <div>
                            <span class="eyebrow">ESTILO & AMBIENTACIÓN DEL SANTUARIO</span>
                            <h3 id="family-header-modal-title">Personalizar Título, Texto y Colores</h3>
                        </div>
                        <button type="button" class="family-modal-close-btn" id="btn-close-header-modal" aria-label="Cerrar">✕</button>
                    </header>

                    <form id="family-sanctuary-header-form">
                        <div class="family-vault-field">
                            <label for="family-custom-title-input">Título del Santuario</label>
                            <input type="text" id="family-custom-title-input" name="title" required maxlength="160" placeholder="Ej.: Nuestro Álbum Familiar · El Hogar de Nuestro Amor">
                        </div>

                        <div class="family-vault-field">
                            <label for="family-custom-subtitle-input">Subtítulo o Dedicatoria Principal</label>
                            <textarea id="family-custom-subtitle-input" name="subtitle" rows="3" maxlength="500" placeholder="Escribe la dedicatoria principal que acompaña la cabecera..."></textarea>
                        </div>

                        <div class="family-form-grid-2">
                            <div class="family-vault-field">
                                <label for="family-custom-pill-input">Insignia / Rincón</label>
                                <input type="text" id="family-custom-pill-input" name="pill" maxlength="80" placeholder="Ej.: 💎 ZAFIRO IMPERIAL · N° 12">
                            </div>

                            <div class="family-vault-field">
                                <label for="family-custom-theme-input">Color de Atmósfera del Santuario</label>
                                <select id="family-custom-theme-input" name="theme">
                                    <option value="sapphire">💎 Zafiro Imperial (Azul Real)</option>
                                    <option value="rose">🌹 Rosa Romance (Fucsia Real)</option>
                                    <option value="gold">👑 Oro Sagrado (Dorado de Gala)</option>
                                    <option value="emerald">🌿 Esmeralda Jardín (Verde Botánico)</option>
                                    <option value="amethyst">🔮 Amatista Reina (Púrpura Místico)</option>
                                    <option value="ruby">🌺 Rubí Fuego (Carmesí Pasión)</option>
                                </select>
                            </div>
                        </div>

                        <div class="family-modal-actions">
                            <button type="button" class="button button-outline" id="btn-cancel-header-modal">Cancelar</button>
                            <button type="submit" class="button button-primary" id="btn-save-header-modal">✨ Guardar y Aplicar al Santuario</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <script id="family-initial-json" type="application/json">
                {!! json_encode([
                    'unlocked' => $familyAdminActive,
                    'members' => $membersCollection->values(),
                    'memories' => $memoriesCollection->values(),
                ], JSON_UNESCAPED_UNICODE) !!}
            </script>
        </section>

