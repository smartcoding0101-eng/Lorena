        <section class="screen" data-screen="carla" aria-labelledby="personal-title" hidden>
            <div class="page-shell carla-page-shell">
                <!-- Barra de Navegación del Santuario Privado -->
                <div class="screen-nav-bar carla-nav-bar">
                    <a class="back-link" href="#mapa" data-go="mapa">
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </span>
                        <span>Volver al mapa</span>
                    </a>
                    <span class="nav-screen-pill">
                        <span class="nav-pill-dot" aria-hidden="true"></span>
                        <span>Santuario Privado · El Jardín de Carla</span>
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

                <!-- Cabecera Editorial Principal -->
                <div class="page-heading carla-page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge badge-gold">SANTUARIO PRIVADO</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-rose">PILAR IV · UN LUGAR SOLO PARA TI</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-live">
                                <span class="live-pulse-dot" aria-hidden="true"></span>
                                <span>CONFIDENCIAL & PROTEGIDO</span>
                            </span>
                        </div>
                        <p class="eyebrow">MI ESPACIO · UN LUGAR SOLO PARA MÍ · EL JARDÍN DE CARLA</p>
                        <h1 id="personal-title" class="shimmer-title">Mi Espacio · <em>Un santuario solo para mí</em></h1>
                        <p class="carla-page-heading-desc">Tu refugio privado para atesorar recuerdos, pensamientos íntimos, cápsulas selladas y melodías queridas. Un rincón protegido donde florecen tus momentos más especiales.</p>
                    </div>
                    <span class="heading-mark romantic-spin" aria-hidden="true">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                </div>

                @auth
                    <!-- 1. Gran Hero de Bienvenida del Santuario -->
                    <div class="carla-sanctuary-hero luxury-card">
                        <div class="carla-hero-backdrop-glow" aria-hidden="true"></div>
                        <div class="carla-avatar-container">
                            <div class="carla-avatar-portal">
                                <span class="carla-avatar-letter">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                                <span class="carla-avatar-sparkle" aria-hidden="true">✨</span>
                            </div>
                            <span class="carla-session-badge">
                                <span class="session-indicator-dot"></span>
                                <span>Sesión Privada Activa</span>
                            </span>
                        </div>

                        <div class="carla-hero-content">
                            <div class="carla-hero-eyebrow-row">
                                <span class="eyebrow">SANTUARIO ABIERTO · BIENVENIDA A TU REFUGIO</span>
                            </div>
                            <h2>Hola, {{ auth()->user()->name }}</h2>
                            <p>Este universo conserva cada uno de tus momentos, palabras guardadas y preferencias con infinito aprecio. Nadie más tiene acceso a lo que atesoras aquí.</p>
                            
                            <div class="carla-hero-actions">
                                <a class="button button-primary carla-btn-primary" href="#diario" data-go="diario">
                                    <span class="carla-btn-icon" aria-hidden="true">✍️</span>
                                    <span>Escribir en mi Diario</span>
                                    <span class="carla-btn-arrow" aria-hidden="true">→</span>
                                </a>
                                <a class="button button-outline carla-btn-outline" href="#albumes" data-go="albumes">
                                    <span class="carla-btn-icon" aria-hidden="true">🖼️</span>
                                    <span>Ver mis Álbumes</span>
                                </a>
                                <a class="button button-outline carla-btn-outline" href="#capsula" data-go="capsula">
                                    <span class="carla-btn-icon" aria-hidden="true">⏳</span>
                                    <span>Cápsulas del Tiempo</span>
                                </a>
                                <a class="button button-outline carla-settings-pill" href="#ajustes" data-go="ajustes" title="Ajustes y preferencias de tu espacio">
                                    <span class="setting-icon" aria-hidden="true">⚙️</span>
                                    <span>Preferencias</span>
                                </a>
                            </div>
                        </div>

                        <div class="carla-hero-logout-dock">
                            <form class="personal-logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="button button-outline logout-btn carla-logout-btn" type="submit" title="Cerrar sesión segura de tu rincón">
                                    <span aria-hidden="true">🔒</span>
                                    <span>Cerrar sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- 2. Cinta de Métricas e Indicadores Vivos del Santuario -->
                    <div class="carla-metrics-ribbon" aria-label="Resumen de tesoros en mi espacio">
                        <a class="carla-metric-card" href="#albumes" data-go="albumes">
                            <div class="metric-icon-wrap icon-album">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="albums">{{ $personalStats['albums'] }}</strong>
                                <span>Álbumes</span>
                                <small>Colecciones de fotos</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>

                        <a class="carla-metric-card" href="#albumes" data-go="albumes">
                            <div class="metric-icon-wrap icon-photos">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                    <circle cx="12" cy="13" r="4"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="photos">{{ $personalStats['photos'] }}</strong>
                                <span>Fotografías</span>
                                <small>Momentos guardados</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>

                        <a class="carla-metric-card" href="#favoritos" data-go="favoritos">
                            <div class="metric-icon-wrap icon-heart">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="favorites">{{ $personalStats['favorites'] }}</strong>
                                <span>Favoritos</span>
                                <small>Tus preferidas</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>

                        <a class="carla-metric-card" href="#diario" data-go="diario">
                            <div class="metric-icon-wrap icon-diary">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="diary">{{ $personalStats['diary'] }}</strong>
                                <span>Entradas</span>
                                <small>Diario personal</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>

                        <a class="carla-metric-card" href="#capsula" data-go="capsula">
                            <div class="metric-icon-wrap icon-capsule">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="capsules">{{ $personalStats['capsules'] }}</strong>
                                <span>Cápsulas</span>
                                <small>Cartas selladas</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>

                        <a class="carla-metric-card" href="#blog" data-go="blog">
                            <div class="metric-icon-wrap icon-blog">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <div class="metric-data">
                                <strong data-metric-count="drafts">{{ $personalStats['drafts'] }}</strong>
                                <span>Borradores</span>
                                <small>Notas en pausa</small>
                            </div>
                            <span class="metric-hover-arrow" aria-hidden="true">↗</span>
                        </a>
                    </div>

                    <!-- 3. Barra de Acciones Rápidas Inspiradoras -->
                    <div class="carla-quick-bar luxury-card">
                        <div class="quick-bar-heading">
                            <span class="quick-bar-sparkle">✨</span>
                            <div>
                                <span class="eyebrow">ACCIONES INMEDIATAS</span>
                                <h3>¿Qué te inspira hoy, Carla?</h3>
                            </div>
                        </div>
                        <div class="quick-bar-pills">
                            <a class="quick-pill" href="#diario" data-go="diario">
                                <span class="quick-pill-emoji">✍️</span>
                                <span>Nueva página íntima</span>
                            </a>
                            <a class="quick-pill" href="#albumes" data-go="albumes">
                                <span class="quick-pill-emoji">📸</span>
                                <span>Añadir fotografías</span>
                            </a>
                            <a class="quick-pill" href="#capsula" data-go="capsula">
                                <span class="quick-pill-emoji">✉️</span>
                                <span>Sellar carta con candado</span>
                            </a>
                            <a class="quick-pill" href="#entretenimiento" data-go="entretenimiento">
                                <span class="quick-pill-emoji">🎵</span>
                                <span>Escuchar melodías</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Categorías Estructuradas del Santuario -->
                    <div class="carla-sanctuary-sections">
                        <!-- SECCIÓN 1: MEMORIAS ÍNTIMAS & TESOROS GUARDADOS -->
                        <section class="sanctuary-group" aria-labelledby="group-memories-title">
                            <div class="sanctuary-group-header">
                                <div class="sanctuary-group-badge">
                                    <span class="group-badge-icon">💎</span>
                                    <span>PILAR DE TESOROS</span>
                                </div>
                                <h2 id="group-memories-title">Memorias Íntimas &amp; Momentos Guardados</h2>
                                <p>Tus fotografías confidenciales, álbumes temáticos y cofres sellados bajo estricta privacidad.</p>
                            </div>

                            <div class="carla-cards-grid">
                                <!-- Tarjeta: Mis Álbumes -->
                                <a class="carla-shortcut-card luxury-card" href="#albumes" data-go="albumes">
                                    <div class="card-icon-circle icon-album-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Mis Álbumes</strong>
                                            <span class="card-count-badge" data-metric-count="albums">{{ $personalStats['albums'] }}</span>
                                        </div>
                                        <p>Colecciones de fotos ordenadas con delicadeza para revivir tus mejores instantes.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: Mis Favoritos -->
                                <a class="carla-shortcut-card luxury-card" href="#favoritos" data-go="favoritos">
                                    <div class="card-icon-circle icon-heart-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Mis favoritos</strong>
                                            <span class="card-count-badge" data-metric-count="favorites">{{ $personalStats['favorites'] }}</span>
                                        </div>
                                        <p>Tus fotografías y momentos más entrañables para encontrarlos con un solo toque.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: Mi Diario Personal -->
                                <a class="carla-shortcut-card luxury-card" href="#diario" data-go="diario">
                                    <div class="card-icon-circle icon-diary-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Mi Diario Íntimo</strong>
                                            <span class="card-count-badge" data-metric-count="diary">{{ $personalStats['diary'] }}</span>
                                        </div>
                                        <p>Un espacio confidencial para tus reflexiones, confidencias y memorias del corazón.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: Cápsulas del Tiempo -->
                                <a class="carla-shortcut-card luxury-card" href="#capsula" data-go="capsula">
                                    <div class="card-icon-circle icon-capsule-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Cápsulas del Tiempo</strong>
                                            <span class="card-count-badge" data-metric-count="capsules">{{ $personalStats['capsules'] }}</span>
                                        </div>
                                        <p>Cartas selladas con fecha y candado que solo se revelan en su momento señalado.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>
                            </div>
                        </section>

                        <!-- SECCIÓN 2: ARMONÍA, INSPIRACIÓN & EXPRESIÓN -->
                        <section class="sanctuary-group" aria-labelledby="group-expression-title">
                            <div class="sanctuary-group-header">
                                <div class="sanctuary-group-badge">
                                    <span class="group-badge-icon">🌸</span>
                                    <span>PILAR DE INSPIRACIÓN</span>
                                </div>
                                <h2 id="group-expression-title">Armonía, Expresión &amp; Música</h2>
                                <p>Rincones sonoros, palabras de amor compartidas y artículos que inspiran el espíritu.</p>
                            </div>

                            <div class="carla-cards-grid">
                                <!-- Tarjeta: Entretenimiento & Música -->
                                <a class="carla-shortcut-card luxury-card" href="#entretenimiento" data-go="entretenimiento">
                                    <div class="card-icon-circle icon-music-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 18V5l12-2v13"/>
                                            <circle cx="6" cy="18" r="3"/>
                                            <circle cx="18" cy="16" r="3"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Entretenimiento &amp; Música</strong>
                                            <span class="card-count-badge" data-metric-count="media">{{ $personalStats['media'] }}</span>
                                        </div>
                                        <p>Colección de piezas sonoras y videos que acompañan tus horas con serenidad y dulzura.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: Dedicatoria de Amor -->
                                <a class="carla-shortcut-card luxury-card" href="#dedicatoria" data-go="dedicatoria">
                                    <div class="card-icon-circle icon-letter-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                            <polyline points="22,6 12,13 2,6"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Carta &amp; Dedicatoria</strong>
                                            <span class="card-tag-pill">Con Amor</span>
                                        </div>
                                        <p>Un espacio creado para recordarte lo inmensamente especial e irreemplazable que eres.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: Voces Sinceras (Amigos) -->
                                <a class="carla-shortcut-card luxury-card" href="#amigos" data-go="amigos">
                                    <div class="card-icon-circle icon-friends-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Voces de la Amistad</strong>
                                            <span class="card-tag-pill">Medallón</span>
                                        </div>
                                        <p>Mensajes y dedicatorias de las personas queridas que iluminan tu camino con afecto.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                <!-- Tarjeta: El Blog del Jardín -->
                                <a class="carla-shortcut-card luxury-card" href="#blog" data-go="blog">
                                    <div class="card-icon-circle icon-blog-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                            <polyline points="10 9 9 9 8 9"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>El Blog del Jardín</strong>
                                            <span class="card-count-badge" data-metric-count="drafts">{{ $personalStats['drafts'] }}</span>
                                        </div>
                                        <p>Revisa publicaciones, edita artículos o redacta nuevos textos compartibles.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>
                            </div>
                        </section>

                        <!-- SECCIÓN 3: CUIDADO PERSONAL & GESTIÓN MAESTRA -->
                        <section class="sanctuary-group" aria-labelledby="group-settings-title">
                            <div class="sanctuary-group-header">
                                <div class="sanctuary-group-badge">
                                    <span class="group-badge-icon">⚙️</span>
                                    <span>PILAR DE CUIDADO</span>
                                </div>
                                <h2 id="group-settings-title">Cuidado, Ajustes &amp; Seguridad</h2>
                                <p>Personalización de tu entorno, control de privacidad y herramientas maestras del jardín.</p>
                            </div>

                            <div class="carla-cards-grid">
                                <!-- Tarjeta: Preferencias & Privacidad -->
                                <a class="carla-shortcut-card luxury-card" href="#ajustes" data-go="ajustes">
                                    <div class="card-icon-circle icon-settings-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3"/>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Preferencias &amp; Privacidad</strong>
                                            <span class="card-tag-pill">Ajustes</span>
                                        </div>
                                        <p>Configura temas visuales, audios de ambiente, contraseñas y privacidad segura.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>

                                @if (auth()->check() && (auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true)))
                                <!-- Tarjeta: Panel de Administración -->
                                <a class="carla-shortcut-card luxury-card card-admin-highlight" href="#admin" data-go="admin">
                                    <div class="card-icon-circle icon-admin-bg">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        </svg>
                                    </div>
                                    <div class="card-text">
                                        <div class="card-title-row">
                                            <strong>Panel de Administración</strong>
                                            <span class="card-tag-pill is-gold">Maestro</span>
                                        </div>
                                        <p>Gestión global de seguridad, preguntas del quiz, miembros y configuración del jardín.</p>
                                    </div>
                                    <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                                </a>
                                @endif
                            </div>
                        </section>
                    </div>

                    <!-- 5. Tarjeta Poética / Susurro del Santuario -->
                    <div class="carla-whisper-sanctuary luxury-card">
                        <div class="whisper-floral-corner top-left" aria-hidden="true">❦</div>
                        <div class="whisper-floral-corner bottom-right" aria-hidden="true">❦</div>
                        <div class="whisper-content">
                            <span class="whisper-eyebrow">✦ SUSURRO DEL JARDÍN PARA CARLA LORENA ✦</span>
                            <blockquote class="whisper-quote">
                                «En este rincón florecen tus recuerdos más sinceros. Cada flor, cada palabra y cada melodía fueron pensadas para recordarte lo inmensamente amada y especial que eres en cada instante.»
                            </blockquote>
                            <div class="whisper-signature">
                                <span>Con infinito amor &amp; devoción,</span>
                                <strong>El Jardín de Carla Lorena</strong>
                            </div>
                            <div class="whisper-links">
                                <a class="button button-outline whisper-btn" href="#jardin" data-go="jardin">
                                    <span>🌹 Pasear por el Jardín Botánico</span>
                                </a>
                                <a class="button button-outline whisper-btn" href="#juegos" data-go="juegos">
                                    <span>🎮 Ir al Atelier de Experiencias</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Vista Especial para Visitantes / Puerta del Santuario -->
                    <div class="carla-guest-vault luxury-card">
                        <div class="guest-vault-emblem-wrap">
                            <div class="guest-vault-emblem">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    <circle cx="12" cy="16" r="1.5"/>
                                </svg>
                            </div>
                            <span class="guest-sparkle">✦</span>
                        </div>

                        <div class="guest-vault-info">
                            <span class="eyebrow">UMBRAL PRIVADO · ACCESO EXCLUSIVO</span>
                            <h2>El Santuario de Carla Lorena</h2>
                            <p>Este rincón es un cofre personal reservado bajo llave. Guarda fotografías confidenciales, páginas del diario íntimo y cápsulas del tiempo selladas para el porvenir.</p>

                            <div class="guest-features-strip">
                                <div class="guest-feature-item">
                                    <span class="guest-feat-icon">🔒</span>
                                    <div>
                                        <strong>Privacidad Absoluta</strong>
                                        <small>Solo visible con tus credenciales seguras</small>
                                    </div>
                                </div>
                                <div class="guest-feature-item">
                                    <span class="guest-feat-icon">📖</span>
                                    <div>
                                        <strong>Diario Íntimo</strong>
                                        <small>Pensamientos y confidencias protegidas</small>
                                    </div>
                                </div>
                                <div class="guest-feature-item">
                                    <span class="guest-feat-icon">⏳</span>
                                    <div>
                                        <strong>Cápsulas del Tiempo</strong>
                                        <small>Cartas con fecha de apertura futura</small>
                                    </div>
                                </div>
                            </div>

                            <div class="guest-vault-actions">
                                <a class="button button-primary guest-login-cta" href="{{ route('login') }}">
                                    <span>Entrar a mi espacio con mi llave</span>
                                    <span aria-hidden="true">🗝️</span>
                                </a>
                                <a class="button button-outline" href="#jardin" data-go="jardin">
                                    <span>Explorar el Jardín Público</span>
                                    <span aria-hidden="true">🌸</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </section>