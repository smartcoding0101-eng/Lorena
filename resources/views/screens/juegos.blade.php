        <section class="screen" data-screen="juegos" aria-labelledby="games-title" hidden>
            <div class="page-shell">
                <!-- Barra de Navegación del Atelier de Experiencias -->
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
                        <span>Atelier de Experiencias · El Jardín de Carla</span>
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

                <!-- Cabecera Principal con Estilo Atelier Editorial -->
                <div class="page-heading games-page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge badge-gold">COLECCIÓN PRIVADA</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-rose">PILAR III</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-live">
                                <span class="live-pulse-dot" aria-hidden="true"></span>
                                <span>8 EXPERIENCIAS EN FLOR</span>
                            </span>
                        </div>
                        <p class="eyebrow">EXPERIENCIAS · LÚDICA & MOMENTOS COMPARTIDOS</p>
                        <h1 id="games-title" class="shimmer-title">Experiencias · <em>Juegos que hacen sonreír</em></h1>
                        <p>Una curaduría de pequeños retos, dilemas suaves y crónicas mágicas para disfrutar sin prisa. Cada detalle fue pensado con ternura para ti, Carla Lorena.</p>
                    </div>
                    <div class="games-heading-actions">
                        <button type="button" class="button button-outline atelier-btn-subtle games-random-btn" id="btn-random-game" title="Elegir una experiencia al azar">
                            <span class="atelier-btn-lead-icon" aria-hidden="true">🎲</span>
                            <span class="atelier-btn-label">Experiencia al azar</span>
                            <span class="atelier-btn-arrow" aria-hidden="true">✨</span>
                        </button>
                        <span class="heading-mark romantic-spin" aria-hidden="true">🎮</span>
                    </div>
                </div>

                <!-- Barra Dinámica de Categorías y Filtros -->
                <div class="gallery-toolbar games-filter-toolbar" aria-label="Filtrar juegos por categoría">
                    <div class="filter-group" role="group" aria-label="Categorías de experiencias">
                        <button class="filter-chip is-selected" type="button" data-game-filter="todos" aria-pressed="true">
                            <span class="filter-chip-icon" aria-hidden="true">🌸</span>
                            <span>Todas las experiencias (8)</span>
                        </button>
                        <button class="filter-chip" type="button" data-game-filter="retos" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">🌹</span>
                            <span>Trivias & Retos</span>
                        </button>
                        <button class="filter-chip" type="button" data-game-filter="calma" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">🌷</span>
                            <span>Calma & Bienestar</span>
                        </button>
                        <button class="filter-chip" type="button" data-game-filter="visual" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">🌺</span>
                            <span>Reto Visual</span>
                        </button>
                        <button class="filter-chip" type="button" data-game-filter="aventuras" aria-pressed="false">
                            <span class="filter-chip-icon" aria-hidden="true">👑</span>
                            <span>Aventuras de Sultana</span>
                        </button>
                    </div>
                    <div class="games-toolbar-status" id="games-filter-status">
                        <span class="status-indicator-dot" aria-hidden="true"></span>
                        <span class="gallery-caption">SELECCIÓN LÚDICA EXCLUSIVA · DISFRUTA A TU RITMO</span>
                    </div>
                </div>

                <!-- Cuadrícula Normalizada de Tarjetas de Juegos (Estilo Unificado del Sistema) -->
                <nav class="game-card-grid" aria-label="Elige un juego">
                    <!-- Tarjeta 1: Conociendo a Carla Lorena -->
                    <a class="game-card luxury-card" href="#conociendo-carla" data-go="conociendo-carla" data-game-card data-game-category="retos">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Rosa Real">🌹</span>
                                <span class="card-number">TRIVIA ÍNTIMA · RECOMPENSA</span>
                            </div>
                            <span class="card-badge-subtle">PREMIO</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 3c-3 1.8-5 4.6-5 7.5a5 5 0 0 0 10 0C17 7.6 15 4.8 12 3z"></path>
                                        <path d="M9.2 7.2c1.6 1.5 4 1.5 5.6 0"></path>
                                        <path d="M8 10.2c2.2 1.8 5.8 1.8 8 0"></path>
                                        <path d="M12 15.5V22"></path>
                                        <path d="M12 19c-3 0-4.8-1.6-5-4 2.4 0 4.2 1.2 5 4z"></path>
                                        <path d="M12 18c3 0 4.8-1.6 5-4-2.4 0-4.2 1.2-5 4z"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <div class="game-card-heading">
                                        <span class="game-card-eyebrow">RETO CON AMOR</span>
                                        <h3 class="game-card-title">Conociendo a Carla Lorena</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <div class="game-card-copy">
                                <p class="game-card-desc">Responde preguntas especiales sobre Carla y descubre la recompensa autorizada con ternura.</p>
                            </div>
                            <span class="card-mini-quote">«Cada respuesta acertada es una sonrisa compartida.»</span>
                            <div class="game-card-detail">
                                <div class="game-card-footer">
                                    <span class="badge-floral">10 preguntas · premio privado</span>
                                    <span class="card-arrow" aria-hidden="true">↗</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 2: ¿Qué prefieres? -->
                    <a class="game-card luxury-card" href="#preferencias" data-go="preferencias" data-game-card data-game-category="calma">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Tulipanes Gemelos">🌷</span>
                                <span class="card-number">ELECCIONES LIGERAS · CALMA</span>
                            </div>
                            <span class="card-badge-subtle">SIN JUICIOS</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M7.5 4C5.5 6 5 8.8 6.5 10.8c1.4 1.8 4.1 1.8 5.5 0C13.5 8.8 13 6 11 4L9.2 6.2 7.5 4z"></path>
                                        <path d="M14.5 6.5c1.5 1.5 2 3.8.8 5.5-1.1 1.5-3.2 1.5-4.3 0"></path>
                                        <path d="M9.2 12.2V21"></path>
                                        <path d="M15.2 13.2C14.8 16.5 13 19 9.2 21"></path>
                                        <path d="M9.2 17.5c-2.4-.2-4-1.8-4.2-3.8 2 .1 3.5 1.4 4.2 3.8z"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">DILEMAS TRANQUILOS</span>
                                    <h3 class="game-card-title">¿Qué prefieres?</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Escoge entre dos pequeños placeres de la vida, sin juicios y a tu ritmo sereno.</p>
                            <span class="card-mini-quote">«En las elecciones sencillas habita la paz.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">🌷 5 rondas · a tu ritmo</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 3: Rompecabezas floral -->
                    <a class="game-card luxury-card" href="#rompecabezas" data-go="rompecabezas" data-game-card data-game-category="visual">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Flor Botánica">🌸</span>
                                <span class="card-number">RETO VISUAL · BOTÁNICA</span>
                            </div>
                            <span class="card-badge-subtle">INGENIO</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M12 2.5c-2 2-2.5 4.8 0 6.5 2.5-1.7 2-4.5 0-6.5z"></path>
                                        <path d="M12 21.5c-2-2-2.5-4.8 0-6.5 2.5 1.7 2 4.5 0 6.5z"></path>
                                        <path d="M2.5 12c2-2 4.8-2.5 6.5 0-1.7 2.5-4.5 2-6.5 0z"></path>
                                        <path d="M21.5 12c-2-2-4.8-2.5-6.5 0 1.7 2.5 4.5 2 6.5 0z"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">ARTE EN MOVIMIENTO</span>
                                    <h3 class="game-card-title">Rompecabezas floral</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Desliza las delicadas piezas hasta recomponer la ilustración dorada del jardín botánico.</p>
                            <span class="card-mini-quote">«Paciencia y armonía en cada movimiento.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">🌸 8 piezas · toque</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 4: Bingo de pequeños momentos -->
                    <a class="game-card luxury-card" href="#bingo-amable" data-go="bingo-amable" data-game-card data-game-category="calma">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Manzanilla Radiante">🌻</span>
                                <span class="card-number">PAUSA AMABLE · BIENESTAR</span>
                            </div>
                            <span class="card-badge-subtle">AUTOCUIDADO</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="10.5" r="3.2"></circle>
                                        <path d="M12 3c-1.4 1.5-1.4 3 0 4.3 1.4-1.3 1.4-2.8 0-4.3z"></path>
                                        <path d="M12 18c-1.4-1.5-1.4-3 0-4.3 1.4 1.3 1.4 2.8 0 4.3z"></path>
                                        <path d="M4.5 10.5c1.5-1.4 3-1.4 4.3 0-1.3 1.4-2.8 1.4-4.3 0z"></path>
                                        <path d="M19.5 10.5c-1.5-1.4-3-1.4-4.3 0 1.3 1.4 2.8 1.4 4.3 0z"></path>
                                        <path d="M12 18v4"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">CUIDADO & CARIÑO</span>
                                    <h3 class="game-card-title">Bingo de pequeños momentos</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Marca gestos reconfortantes y cariñosos que te apetezca regalarte el día de hoy.</p>
                            <span class="card-mini-quote">«Consentirte no es un premio, es tu bienestar prioritario.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">9 casillas · sin obligaciones</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 5: Adivina la escena -->
                    <a class="game-card luxury-card" href="#adivina-escena" data-go="adivina-escena" data-game-card data-game-category="retos">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Mariposa Botánica">🌿</span>
                                <span class="card-number">MIRA LOS DETALLES · INTUICIÓN</span>
                            </div>
                            <span class="card-badge-subtle">AGUDEZA</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 6v13"></path>
                                        <path d="M12 9C9 4.5 3.5 5 3.5 9.5c0 3.2 4 4.5 8.5 3.5"></path>
                                        <path d="M12 9c3-4.5 8.5-4 8.5.5 0 3.2-4 4.5-8.5 3.5"></path>
                                        <path d="M12 13c-3.5.5-6.5 2.5-5.5 5.5.8 2.4 4.2 1.8 5.5-1.5"></path>
                                        <path d="M12 13c3.5.5 6.5 2.5 5.5 5.5-.8 2.4-4.2 1.8-5.5-1.5"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">MISTERIO & DETALLES</span>
                                    <h3 class="game-card-title">Adivina la escena</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Interpreta símbolos cotidianos y descubre qué momento memorable relatan.</p>
                            <span class="card-mini-quote">«La magia se esconde en los pequeños recuerdos.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">🌿 4 escenas · pistas</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 6: Las crónicas de la princesa Sultana -->
                    <a class="game-card luxury-card" href="#aventura-sultana" data-go="aventura-sultana" data-game-card data-game-category="aventuras">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Corona Real">👑</span>
                                <span class="card-number">AVENTURA NARRATIVA · NOVELA</span>
                            </div>
                            <span class="card-badge-subtle">FANTASÍA</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 20V11a6 6 0 0 1 12 0v9"></path>
                                        <path d="M4 20h16"></path>
                                        <path d="M12 7.2c-1.8 1.2-2.6 2.8-2.6 4.2a2.6 2.6 0 0 0 5.2 0c0-1.4-.8-3-2.6-4.2z"></path>
                                        <path d="M10.2 9.8c1 .9 2.6.9 3.6 0"></path>
                                        <path d="M12 14v5"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">NOVELA INTERACTIVA</span>
                                    <h3 class="game-card-title">Las crónicas de la princesa Sultana</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Explora un reino de fantasía, toma decisiones y escribe tu propio desenlace.</p>
                            <span class="card-mini-quote">«Tu sabiduría decide el destino del reino de Sultana.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral" data-sultana-card-status>👑 5 capítulos · progreso guardado</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 7: Los jardines secretos de Sultana 3D -->
                    <a class="game-card luxury-card" href="#jardines-liria" data-go="jardines-liria" data-game-card data-game-category="aventuras">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Loto Mágico">🪷</span>
                                <span class="card-number">EXPLORACIÓN 3D · MÁGICA</span>
                            </div>
                            <span class="card-badge-subtle">INMERSIVO</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 3.5c-2.2 3-3.2 6.2-3.2 9a3.2 3.2 0 0 0 6.4 0c0-2.8-1-6-3.2-9z"></path>
                                        <path d="M8.8 11.5C6.2 9.2 3.5 10 2.5 12.8c2.2 2.6 5.5 3.2 9.5 2.2"></path>
                                        <path d="M15.2 11.5c2.6-2.3 5.3-1.5 6.3 1.3-2.2 2.6-5.5 3.2-9.5 2.2"></path>
                                        <path d="M4 18.2c2.5 1.2 5.2 1.8 8 1.8s5.5-.6 8-1.8"></path>
                                        <path d="M7 21c3.2.8 6.8.8 10 0"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">ESPACIO TRIDIMENSIONAL</span>
                                    <h3 class="game-card-title">Los jardines secretos de Sultana</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Acompaña a Sultana en un entorno 3D, encuentra flores y devuelve el agua a la fuente viva.</p>
                            <span class="card-mini-quote">«Caminar entre fuentes y senderos iluminados.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">🪷 Explora · corre · 3D</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tarjeta 8: Sultana y los senderos del alba -->
                    <a class="game-card luxury-card" href="#sultana-plataformas" data-go="sultana-plataformas" data-game-card data-game-category="aventuras">
                        <div class="card-top-bar">
                            <div class="card-top-bar-left">
                                <span class="card-icon-emblem" title="Pétalos al Alba">✨</span>
                                <span class="card-number">PLATAFORMAS · ARCADE</span>
                            </div>
                            <span class="card-badge-subtle">ACCIÓN</span>
                        </div>
                        <div class="game-card-body">
                            <div class="game-card-header-row">
                                <span class="game-card-icon-medallion" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15.5 3.5c2.8 0 4.5 1.8 4.5 4.5 0 3.5-3.5 6-7 6-2 0-3.5-1.2-3.5-3.2 0-3.5 3-7.3 6-7.3z"></path>
                                        <path d="M6.5 11.5c2.2 0 3.5 1.4 3.5 3.4 0 2.6-2.6 4.6-5.2 4.6-1.5 0-2.8-1-2.8-2.5 0-2.6 2.3-5.5 4.5-5.5z"></path>
                                        <path d="M16.5 15c1.8 0 3 1.1 3 2.8 0 2.1-2.1 3.7-4.2 3.7-1.2 0-2.3-.8-2.3-2 0-2.1 1.8-4.5 3.5-4.5z"></path>
                                    </svg>
                                </span>
                                <div class="game-card-title-group">
                                    <span class="game-card-eyebrow">ARCADE BOTÁNICO</span>
                                    <h3 class="game-card-title">Sultana y los senderos del alba</h3>
                                </div>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="game-card-desc">Salta entre plataformas, esquiva sombras y reúne pétalos de rosa para abrir cada portal.</p>
                            <span class="card-mini-quote">«Un salto hacia adelante con gracia y destellos.»</span>
                            <div class="game-card-footer">
                                <span class="badge-floral">✨ 9 niveles · salto doble · destellos</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </div>
                    </a>
                </nav>

                <!-- Estado Vacío cuando un filtro no arroja resultados -->
                <div class="games-empty-state" id="games-filter-empty" hidden>
                    <span class="games-empty-icon" aria-hidden="true">🌸</span>
                    <h3>No hay experiencias en esta categoría</h3>
                    <p>Selecciona otra categoría para seguir disfrutando de las experiencias preparadas con ternura para ti.</p>
                    <button type="button" class="button button-primary" id="btn-reset-game-filter">Ver todas las experiencias</button>
                </div>

                <!-- Panel de Memoria con estilo Atelier Editorial -->
                <div class="memory-panel atelier-memory-panel">
                    <div class="memory-toolbar">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge badge-gold">MINIJUEGO INTEGRADO</span>
                                <span class="atelier-dot">◆</span>
                                <span class="atelier-badge badge-rose">CALMA & ARMONÍA</span>
                            </div>
                            <p class="eyebrow">MEMORIA BOTÁNICA DEL ATELIER</p>
                            <h3 class="atelier-memory-title">Encuentra las parejas de flores</h3>
                        </div>
                        <button class="button button-outline memory-reset atelier-btn-subtle" type="button">
                            <span>Mezclar flores de nuevo</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="2.6"></circle>
                                <path d="M12 3a3.2 3.2 0 0 0-3.2 3.2v1.2a3.2 3.2 0 0 0 6.4 0V6.2A3.2 3.2 0 0 0 12 3z"></path>
                                <path d="M21 12a3.2 3.2 0 0 0-3.2-3.2h-1.2a3.2 3.2 0 0 0 0 6.4h1.2A3.2 3.2 0 0 0 21 12z"></path>
                                <path d="M12 21a3.2 3.2 0 0 0 3.2-3.2v-1.2a3.2 3.2 0 0 0-6.4 0v1.2A3.2 3.2 0 0 0 12 21z"></path>
                                <path d="M3 12a3.2 3.2 0 0 0 3.2 3.2h1.2a3.2 3.2 0 0 0 0-6.4H6.2A3.2 3.2 0 0 0 3 12z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="memory-stats">
                        <span class="stat-pill"><span aria-hidden="true">🔄</span> Intentos <strong data-memory-moves>0</strong></span>
                        <span class="stat-pill"><span aria-hidden="true">🌸</span> Parejas <strong data-memory-pairs>0 / 6</strong></span>
                        <span class="stat-message" data-memory-message role="status" aria-live="polite">Elige dos cartas para revelar su esencia botánica.</span>
                    </div>
                    <div class="memory-board" aria-label="Tablero del juego de memoria"></div>
                </div>
            </div>
        </section>
