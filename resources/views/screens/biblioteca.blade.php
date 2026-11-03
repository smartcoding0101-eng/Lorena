        <section class="screen library-screen" data-screen="biblioteca" id="screen-biblioteca" aria-labelledby="library-title" hidden>
            <div class="page-shell">
                <!-- Barra de Navegación de la Pantalla -->
                <div class="screen-nav-bar">
                    <a class="back-link" href="{{ route('home') }}#inicio" data-go="inicio">
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </span>
                        <span>← Ir a Inicio</span>
                    </a>
                    <span class="nav-screen-pill">
                        <span class="nav-pill-dot" aria-hidden="true"></span>
                        <span>Atelier Literario · El Jardín de Carla</span>
                    </span>
                    <a class="back-link" href="#mapa" data-go="mapa">
                        <span>Volver al Atelier</span>
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Cabecera Principal de la Biblioteca -->
                <div class="page-heading library-page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge badge-gold">📖 LITERATURA & CALMA</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-rose" id="library-daily-date-badge">EDICIÓN DE HOY</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-live">
                                <span class="live-pulse-dot" aria-hidden="true"></span>
                                <span>ANTOLOGÍA VIVA</span>
                            </span>
                        </div>
                        <p class="eyebrow">INSPIRACIÓN · FRASES CÉLEBRES, LECTURAS & REFLEXIONES VIVAS</p>
                        <h1 id="library-title" class="library-crimson-title shimmer-title">Inspiración · <em>Palabras que iluminan el alma</em></h1>
                        <p>Un santuario de letras escogidas donde cada amanecer florece una nueva selección literaria de frases célebres, pensamientos botánicos y poemas manuscritos dedicados a tu esencia, Carla Lorena. Disfruta de la lectura con calma o descubre nuevos tesoros al azar.</p>
                    </div>
                    <div class="library-heading-actions">
                        <button type="button" class="button button-outline atelier-btn-subtle library-action-btn" id="library-randomize-all-btn" title="Renovar toda la Biblioteca con una selección aleatoria">
                            <span class="atelier-btn-lead-icon" aria-hidden="true">✨</span>
                            <span class="atelier-btn-label">Sorpréndeme hoy</span>
                            <span class="atelier-btn-arrow" aria-hidden="true">↻</span>
                        </button>
                        <button type="button" class="button button-outline atelier-btn-subtle library-action-btn" id="library-chime-hero-btn" title="Escuchar campana de calma y armonía">
                            <span class="atelier-btn-lead-icon" aria-hidden="true">🔔</span>
                            <span class="atelier-btn-label">Melodía de paz</span>
                        </button>
                    </div>
                </div>

                <!-- Barra Dinámica de Temáticas de Frases Célebres -->
                <div class="gallery-toolbar library-dynamic-toolbar" aria-label="Explorar temáticas de frases célebres">
                    <div class="filter-group" role="group" aria-label="Filtrar frases célebres por tema">
                        <button class="filter-chip is-selected" type="button" data-quote-topic="todas" aria-pressed="true">
                            <span class="filter-chip-icon" aria-hidden="true">✨</span>
                            <span>Todas las frases</span>
                        </button>
                        <button class="filter-chip" type="button" data-quote-topic="sabiduria" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">🏛️</span>
                            <span>Vida & Sabiduría</span>
                        </button>
                        <button class="filter-chip" type="button" data-quote-topic="amor" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">💖</span>
                            <span>Amor Propio & Luz</span>
                        </button>
                        <button class="filter-chip" type="button" data-quote-topic="literatura" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">📚</span>
                            <span>Literatura & Arte</span>
                        </button>
                        <button class="filter-chip" type="button" data-quote-topic="naturaleza" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">🌿</span>
                            <span>Jardín & Calma</span>
                        </button>
                        <button class="filter-chip filter-chip-fav" type="button" data-quote-topic="favoritas" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">♥</span>
                            <span>Mis Favoritas <span id="library-fav-count" class="fav-count-pill">(0)</span></span>
                        </button>
                    </div>
                    <div class="library-toolbar-status" id="library-edition-status-box">
                        <span class="status-indicator-dot" aria-hidden="true"></span>
                        <span class="gallery-caption" id="library-edition-status">SELECCIÓN DIARIA AUTOMÁTICA · ROTA CADA 24 HORAS</span>
                    </div>
                </div>

                <!-- Cuadrícula Principal: Frase Célebre del Día + Joya Literaria -->
                <div class="library-grid">
                    <!-- Tarjeta 1: Frase Célebre del Día -->
                    <article class="reading-card luxury-card" id="daily-quote-card">
                        <div class="card-top-bar">
                            <div class="top-bar-left">
                                <span class="card-icon-emblem" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"></path>
                                        <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"></path>
                                    </svg>
                                </span>
                                <span class="card-number" id="quote-category-badge">FRASE CÉLEBRE DEL DÍA</span>
                            </div>
                            <span class="card-badge-subtle">CITA SELECCIONADA</span>
                        </div>

                        <div class="reading-card-inner">
                            <div class="card-watermark" aria-hidden="true">
                                <svg width="78" height="78" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                            </div>

                            <p class="eyebrow" id="quote-eyebrow">CITA INMORTAL SELECCIONADA HOY</p>
                            <h2 class="library-card-red-title" id="quote-title">La belleza de ser auténtica</h2>

                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>

                            <blockquote class="quote-main-content" id="quote-text">
                                «La belleza comienza en el instante en que decides ser tú misma.»
                            </blockquote>

                            <div class="quote-author-row">
                                <span class="author-badge-pill" id="quote-author">— Coco Chanel</span>
                            </div>

                            <!-- Reflexión complementaria en caja vellum -->
                            <div class="quote-reflection-box" id="quote-reflection-container">
                                <div class="reflection-label-row">
                                    <span class="reflection-sparkle" aria-hidden="true">✨</span>
                                    <span class="reflection-label">REFLEXIÓN PARA HOY</span>
                                </div>
                                <p class="card-mini-quote" id="quote-reflection">«Las palabras que te elevan son las que más te pertenecen.»</p>
                            </div>

                            <!-- Barra de Acciones de la Frase -->
                            <div class="quote-actions">
                                <div class="quote-action-buttons">
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="next-quote-btn" title="Mostrar otra frase célebre">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="23 4 23 10 17 10"></polyline>
                                            <polyline points="1 20 1 14 7 14"></polyline>
                                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                        </svg>
                                        <span>Otra frase</span>
                                    </button>
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="fav-quote-btn" aria-pressed="false" title="Guardar en tus frases favoritas">
                                        <span id="fav-quote-icon" aria-hidden="true">♡</span>
                                        <span id="fav-quote-label">Guardar</span>
                                    </button>
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="copy-quote-btn" title="Copiar frase célebre">
                                        <span aria-hidden="true">📋</span>
                                        <span>Copiar</span>
                                    </button>
                                </div>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>
                    </article>

                    <!-- Tarjeta 2: Joya Literaria & Sabiduría Clásica del Día -->
                    <article class="reading-card wisdom-card luxury-card" id="daily-wisdom-card">
                        <div class="card-top-bar">
                            <div class="top-bar-left">
                                <span class="card-icon-emblem" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                    </svg>
                                </span>
                                <span class="card-number" id="wisdom-badge">JOYA LITERARIA · PENSAMIENTO DEL DÍA</span>
                            </div>
                            <span class="card-badge-subtle">CLÁSICO ETERNO</span>
                        </div>

                        <div class="reading-card-inner">
                            <div class="card-watermark" aria-hidden="true">
                                <svg width="78" height="78" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                    <path d="M12 3c-2.5 2-4 4.5-4 7a4 4 0 0 0 8 0c0-2.5-1.5-5-4-7z"></path>
                                    <path d="M12 14v8"></path>
                                    <path d="M12 18c-2.5 0-4-1.5-4-3.5 2 0 3.5 1 4 3.5z"></path>
                                    <path d="M12 17c2.5 0 4-1.5 4-3.5-2 0-3.5 1-4 3.5z"></path>
                                </svg>
                            </div>

                            <p class="eyebrow" id="wisdom-eyebrow">CRÓNICA DE SABIDURÍA & CALMA</p>
                            <h2 class="library-card-red-title" id="wisdom-title">El secreto de las cosas esenciales</h2>

                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>

                            <div class="wisdom-body-content">
                                <p id="wisdom-body">«He aquí mi secreto, que no puede ser más simple: solo con el corazón se puede ver bien; lo esencial es invisible a los ojos.»</p>
                            </div>

                            <div class="quote-author-row">
                                <span class="author-badge-pill author-badge-gold" id="wisdom-author">— Antoine de Saint-Exupéry · El Principito</span>
                            </div>

                            <!-- Cita complementaria en caja vellum -->
                            <div class="quote-reflection-box wisdom-reflection-box">
                                <div class="reflection-label-row">
                                    <span class="reflection-sparkle" aria-hidden="true">🌹</span>
                                    <span class="reflection-label">FRAGMENTO DESTACADO</span>
                                </div>
                                <p class="card-mini-quote" id="wisdom-mini">«El tiempo que dedicaste a tu rosa es lo que la hace tan importante.»</p>
                            </div>

                            <!-- Barra de Acciones de la Joya Literaria -->
                            <div class="quote-actions wisdom-card-footer">
                                <div class="quote-action-buttons">
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="next-wisdom-btn" title="Descubrir otra joya clásica">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="23 4 23 10 17 10"></polyline>
                                            <polyline points="1 20 1 14 7 14"></polyline>
                                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                        </svg>
                                        <span>Otra joya</span>
                                    </button>
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="copy-wisdom-btn" title="Copiar fragmento literario">
                                        <span aria-hidden="true">📋</span>
                                        <span>Copiar</span>
                                    </button>
                                    <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="wisdom-chime-btn" title="Meditar con campana suave">
                                        <span aria-hidden="true">🔔</span>
                                        <span>Meditar</span>
                                    </button>
                                </div>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Estantería Botánica de Notas (Archivo Personal Dinámico) -->
                <div class="botanical-bookshelf">
                    <div class="section-heading bookshelf-section-heading">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge badge-gold">🌿 ARCHIVO PERSONAL · ROTA CADA DÍA</span>
                                <span class="atelier-dot">◆</span>
                                <span class="atelier-badge badge-rose">HERBARIO DE LUZ</span>
                            </div>
                            <p class="eyebrow">PENSAMIENTOS BOTÁNICOS & FRASES DE LUZ</p>
                            <h2 class="library-section-red-title">Pequeñas notas para el corazón</h2>
                            <p class="section-subtitle">Fragmentos de afecto y serenidad dedicados para recordarte tu inmenso valor y acompañar tus momentos de quietud.</p>
                        </div>
                        <div class="bookshelf-actions">
                            <button type="button" class="button button-outline button-sm atelier-btn-subtle" id="shuffle-notes-btn" title="Renovar notas botánicas al azar">
                                <span class="atelier-btn-lead-icon" aria-hidden="true">🌹</span>
                                <span>Renovar notas al azar</span>
                                <span class="atelier-btn-arrow" aria-hidden="true">↻</span>
                            </button>
                        </div>
                    </div>

                    <div class="bookshelf-cards" id="dynamic-bookshelf-cards">
                        <!-- Nota 1 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="0">
                            <div class="card-top-bar">
                                <div class="top-bar-left">
                                    <span class="card-icon-emblem" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M12 2a4 4 0 0 0-4 4v1a4 4 0 0 0 8 0V6a4 4 0 0 0-4-4z"></path>
                                            <path d="M22 12a4 4 0 0 0-4-4h-1a4 4 0 0 0 0 8h1a4 4 0 0 0 4-4z"></path>
                                            <path d="M12 22a4 4 0 0 0 4-4v-1a4 4 0 0 0-8 0v1a4 4 0 0 0 4 4z"></path>
                                            <path d="M2 12a4 4 0 0 0 4 4h1a4 4 0 0 0 0-8H6a4 4 0 0 0-4 4z"></path>
                                        </svg>
                                    </span>
                                    <span class="card-number" data-note-badge>NOTA · DEDICADA</span>
                                </div>
                                <span class="note-wax-brooch" aria-hidden="true">
                                    <span class="note-pin">🌹</span>
                                </span>
                            </div>

                            <div class="bookshelf-note-inner">
                                <h3 class="library-card-red-title" data-note-title>Sobre florecer a tu propio ritmo</h3>
                                <div class="blog-card-divider" aria-hidden="true">
                                    <span class="divider-line"></span>
                                    <span class="divider-rose">❦</span>
                                    <span class="divider-line"></span>
                                </div>
                                <p class="note-text-body" data-note-body>«Las flores jamás compiten con la flor vecina; simplemente despliegan su esplendor. Jamás olvides el inmenso valor que guarda tu propio proceso.»</p>
                                <div class="bookshelf-note-footer">
                                    <small data-note-author>Para Carla · Con infinita ternura</small>
                                    <span class="blog-card-seal" aria-hidden="true">❦</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nota 2 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="1">
                            <div class="card-top-bar">
                                <div class="top-bar-left">
                                    <span class="card-icon-emblem" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                            <path d="M2 17l10 5 10-5"></path>
                                            <path d="M2 12l10 5 10-5"></path>
                                        </svg>
                                    </span>
                                    <span class="card-number" data-note-badge>NOTA · SERENIDAD</span>
                                </div>
                                <span class="note-wax-brooch" aria-hidden="true">
                                    <span class="note-pin">🌷</span>
                                </span>
                            </div>

                            <div class="bookshelf-note-inner">
                                <h3 class="library-card-red-title" data-note-title>La paz de los instantes lentos</h3>
                                <div class="blog-card-divider" aria-hidden="true">
                                    <span class="divider-line"></span>
                                    <span class="divider-rose">❦</span>
                                    <span class="divider-line"></span>
                                </div>
                                <p class="note-text-body" data-note-body>«Una infusión tibia, una mirada al horizonte al atardecer y unos minutos sin urgencias. En la sencillez noble habita la plenitud.»</p>
                                <div class="bookshelf-note-footer">
                                    <small data-note-author>Rincón de Lectura · Atelier</small>
                                    <span class="blog-card-seal" aria-hidden="true">❦</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nota 3 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="2">
                            <div class="card-top-bar">
                                <div class="top-bar-left">
                                    <span class="card-icon-emblem" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                    </span>
                                    <span class="card-number" data-note-badge>NOTA · LUZ PROPIA</span>
                                </div>
                                <span class="note-wax-brooch" aria-hidden="true">
                                    <span class="note-pin">🌸</span>
                                </span>
                            </div>

                            <div class="bookshelf-note-inner">
                                <h3 class="library-card-red-title" data-note-title>Tu brillo inconfundible</h3>
                                <div class="blog-card-divider" aria-hidden="true">
                                    <span class="divider-line"></span>
                                    <span class="divider-rose">❦</span>
                                    <span class="divider-line"></span>
                                </div>
                                <p class="note-text-body" data-note-body>«Hay personas que dejan una estela inolvidable con solo sonreír, por su nobleza pura y su calidez de corazón. Tú iluminas este espacio, Carla.»</p>
                                <div class="bookshelf-note-footer">
                                    <small data-note-author>El Jardín Secreto · Carla Lorena</small>
                                    <span class="blog-card-seal" aria-hidden="true">❦</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════════════════ -->
                <!-- SECCIÓN MAESTRA: CALIGRAFÍA DE AUTOR · POEMA DEL DÍA                   -->
                <!--                 VERSOS DEDICADOS · TINTA BOTÁNICA                      -->
                <!-- ═══════════════════════════════════════════════════════════════════════ -->
                <div class="editorial-poetry-section">
                    <div class="section-heading poetry-section-heading">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge badge-gold">🖋️ CALIGRAFÍA DE AUTOR · POEMA DEL DÍA</span>
                                <span class="atelier-dot">◆</span>
                                <span class="atelier-badge badge-rose">🌹 VERSOS DEDICADOS · TINTA BOTÁNICA</span>
                                <span class="atelier-dot">◆</span>
                                <span class="atelier-badge badge-live">
                                    <span class="live-pulse-dot" aria-hidden="true"></span>
                                    <span>MANUSCRITO VIVO</span>
                                </span>
                            </div>
                            <p class="eyebrow">VERSOS DEDICADOS · TINTA BOTÁNICA & SEDA</p>
                            <h2 class="library-section-red-title">Poemas en pergamino de seda</h2>
                            <p class="section-subtitle">Lírica escrita con devoción y delicadeza para Carla Lorena. Cada amanecer se caligrafía una pieza sobre el pergamino o puedes recorrer la antología completa.</p>
                        </div>
                    </div>

                    <!-- Selector Rápido de la Antología Poética -->
                    <div class="poetry-anthology-nav" role="tablist" aria-label="Antología de Poemas Dedicados">
                        <span class="anthology-nav-label">
                            <span class="anthology-nav-icon" aria-hidden="true">📜</span>
                            <span>ANTOLOGÍA:</span>
                        </span>
                        <div class="anthology-pills-row" id="poetry-anthology-pills">
                            @foreach($gardenPoems as $idx => $p)
                                <button type="button" class="anthology-pill {{ $idx === 0 ? 'is-active' : '' }}" data-poem-jump="{{ $idx }}" role="tab" aria-selected="{{ $idx === 0 ? 'true' : 'false' }}">
                                    <span class="pill-roman">{{ ['I','II','III','IV','V','VI','VII','VIII','IX','X'][$idx % 10] }}</span>
                                    <span class="pill-name">{{ $p->title }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true))
                            <div style="margin-bottom: 1rem; text-align: right;">
                                <a href="#admin" data-go="admin" class="button button-outline button-sm" style="font-size: 11px;">⚙️ Gestionar Poemas en Control Center</a>
                            </div>
                        @endif
                    @endauth

                    <!-- Gran Tarjeta de Pergamino Iluminado -->
                    <div class="poetry-pergamino-card luxury-card" id="dynamic-poem-card">
                        <!-- Cinta de seda carmesí superior -->
                        <div class="pergamino-silk-ribbon" aria-hidden="true">
                            <span class="ribbon-tail"></span>
                        </div>

                        <!-- Filigranas victorianas en las 4 esquinas del pergamino -->
                        <div class="pergamino-corner-filigree corner-top-left" aria-hidden="true">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <path d="M4 40V14C4 8.47715 8.47715 4 14 4H40" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                <path d="M10 34V16C10 12.6863 12.6863 10 16 10H34" stroke="currentColor" stroke-width="1" stroke-dasharray="2 2"/>
                                <circle cx="8" cy="8" r="2.5" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="pergamino-corner-filigree corner-top-right" aria-hidden="true">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <path d="M40 40V14C40 8.47715 35.5228 4 30 4H4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                <path d="M34 34V16C34 12.6863 31.3137 10 28 10H10" stroke="currentColor" stroke-width="1" stroke-dasharray="2 2"/>
                                <circle cx="36" cy="8" r="2.5" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="pergamino-corner-filigree corner-bottom-left" aria-hidden="true">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <path d="M4 4V30C4 35.5228 8.47715 40 14 40H40" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                <path d="M10 10V28C10 31.3137 12.6863 34 16 34H34" stroke="currentColor" stroke-width="1" stroke-dasharray="2 2"/>
                                <circle cx="8" cy="36" r="2.5" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="pergamino-corner-filigree corner-bottom-right" aria-hidden="true">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <path d="M40 4V30C40 35.5228 35.5228 40 30 40H4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                <path d="M34 10V28C34 31.3137 31.3137 34 28 34H10" stroke="currentColor" stroke-width="1" stroke-dasharray="2 2"/>
                                <circle cx="36" cy="36" r="2.5" fill="currentColor"/>
                            </svg>
                        </div>

                        <!-- Cabecera del Pergamino con Sello Real y Título Iluminado -->
                        <div class="pergamino-header">
                            <!-- Medallón de cera lacrada en relieve 3D -->
                            <div class="pergamino-wax-seal-royal" aria-hidden="true">
                                <span class="seal-ring-outer"></span>
                                <span class="seal-core">
                                    <span class="seal-rose-icon">🌹</span>
                                </span>
                            </div>

                            <div class="pergamino-header-text">
                                <div class="pergamino-top-meta">
                                    <span class="pergamino-auth-strip">CALIGRAFÍA DE AUTOR · TINTA BOTÁNICA</span>
                                    <span class="pergamino-meta-dot">❦</span>
                                    <span class="pergamino-dedication-tag">EXCLUSIVO PARA CARLA LORENA</span>
                                </div>

                                <h3 class="pergamino-poem-title" id="poem-title">Canto al Atardecer</h3>

                                <div class="pergamino-mood-chip">
                                    <span class="mood-cup-icon" aria-hidden="true">☕</span>
                                    <span id="poem-mood">Para leer con una taza de té y silencio amable</span>
                                </div>
                            </div>
                        </div>

                        <!-- Cuerpo de Caligrafía con Letra Capitular Iluminada -->
                        <div class="pergamino-body">
                            <!-- Flourish caligráfico de inicio -->
                            <div class="pergamino-calligraphy-opening" aria-hidden="true">
                                <span class="calligraphy-ornament-line"></span>
                                <span class="calligraphy-quill-icon">✒️</span>
                                <span class="calligraphy-ornament-line"></span>
                            </div>

                            <!-- Estrofa 1 -->
                            <div class="poem-stanza-wrapper stanza-wrapper-1">
                                <p class="poem-verse stanza-1" id="poem-stanza-1">
                                    «Hay jardines que nacen en la tierra,<br>
                                    y otros que florecen en la mirada.<br>
                                    Tú llevas contigo la primavera eterna,<br>
                                    la risa clara y la paz guardada.»
                                </p>
                            </div>

                            <!-- Divisor ornamental botánico -->
                            <div class="poem-divider" aria-hidden="true">
                                <span class="poem-divider-flourish">~ ❦ ~</span>
                                <span class="poem-divider-rose-monogram">🌹</span>
                                <span class="poem-divider-flourish">~ ❦ ~</span>
                            </div>

                            <!-- Estrofa 2 -->
                            <div class="poem-stanza-wrapper stanza-wrapper-2">
                                <p class="poem-verse stanza-2" id="poem-stanza-2">
                                    «Que ningún invierno apague tu calidez,<br>
                                    que los senderos te sean siempre amables,<br>
                                    y que al volver aquí encuentres otra vez,<br>
                                    motivos para soñar inagotables.»
                                </p>
                            </div>
                        </div>

                        <!-- Pie de Pergamino con Firma de Autor y Barra de Herramientas -->
                        <div class="pergamino-footer">
                            <div class="pergamino-signature-block">
                                <div class="signature-decorative-seal" aria-hidden="true">
                                    <span class="sig-heart-seal">♡</span>
                                </div>
                                <div class="signature-texts">
                                    <span class="pergamino-signature-label">DEDICATORIA MANUSCRITA:</span>
                                    <span class="pergamino-signature" id="poem-signature">Escrito con amor para Carla Lorena</span>
                                </div>
                            </div>

                            <!-- Botones Interactivos del Pergamino -->
                            <div class="pergamino-action-toolbar">
                                <button class="button button-primary button-sm poetry-action-btn poetry-recite-btn" type="button" id="next-poem-btn" title="Descubrir otro poema de la antología">
                                    <span class="poetry-btn-icon" aria-hidden="true">↻</span>
                                    <span>Descubrir otro poema</span>
                                </button>
                                <button class="button button-outline button-sm poetry-action-btn" type="button" id="poetry-chime-btn" title="Escuchar arpa y campanitas poéticas">
                                    <span class="poetry-btn-icon" aria-hidden="true">♫</span>
                                    <span>Acordes de arpa</span>
                                </button>
                                <button class="button button-outline button-sm poetry-action-btn" type="button" id="copy-poem-btn" title="Copiar poema con su dedicatoria">
                                    <span class="poetry-btn-icon" aria-hidden="true">📋</span>
                                    <span>Copiar poema</span>
                                </button>
                                <button class="button button-outline button-sm poetry-action-btn" type="button" id="toggle-poetry-focus-btn" title="Modo Atril / Lectura Inmersiva">
                                    <span class="poetry-btn-icon" aria-hidden="true">✨</span>
                                    <span id="focus-btn-label">Modo atril</span>
                                </button>
                            </div>

                            <!-- Sello de autenticidad y marca de agua inferior -->
                            <div class="pergamino-auth-watermark" aria-hidden="true">
                                <span class="auth-ornament">⚜</span>
                                <span>ANTOLOGÍA LÍRICA DEL JARDÍN SECRETO · EDICIÓN IMPERIAL DE AUTOR · CARLA LORENA</span>
                                <span class="auth-ornament">⚜</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
