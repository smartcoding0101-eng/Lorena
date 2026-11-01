        <section class="screen" data-screen="carla" aria-labelledby="personal-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">MI ESPACIO · UN LUGAR SOLO PARA MÍ</p>
                        <h1 id="personal-title">Mi Espacio · <em>Un lugar solo para mí</em></h1>
                        <p>Tu refugio privado para guardar tus recuerdos, pensamientos y momentos más preciados. Aquí también se construyen sueños.</p>
                    </div>
                    <span class="heading-mark" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                </div>

                @auth
                    <div class="personal-panel personal-panel-luxury">
                        <div class="personal-avatar-wrap">
                            <span class="personal-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            <span class="avatar-sparkle">✨</span>
                        </div>
                        <div class="personal-panel-info">
                            <span class="eyebrow">SESIÓN PRIVADA · BIENVENIDA</span>
                            <h2>Hola, {{ auth()->user()->name }}</h2>
                            <p>Este universo conserva cada uno de tus momentos, palabras guardadas y preferencias con infinito aprecio.</p>
                            <div class="personal-panel-actions">
                                <a class="button button-primary" href="#albumes" data-go="albumes">Ver mis álbumes <span>↗</span></a>
                                <a class="button button-outline personal-settings" href="#ajustes" data-go="ajustes"><span class="setting-icon" aria-hidden="true">⚙️</span> Preferencias</a>
                            </div>
                        </div>
                        <form class="personal-logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="button button-outline logout-btn" type="submit" title="Cerrar sesión segura">Cerrar sesión</button>
                        </form>
                    </div>

                    <div class="personal-overview personal-overview-luxury" aria-label="Resumen de mi espacio">
                        <a class="overview-stat" href="#albumes" data-go="albumes">
                            <strong>{{ $personalStats['albums'] }}</strong>
                            <span>Álbumes</span>
                            <small>Colecciones de fotos</small>
                        </a>
                        <a class="overview-stat" href="#albumes" data-go="albumes">
                            <strong>{{ $personalStats['photos'] }}</strong>
                            <span>Fotografías</span>
                            <small>Momentos guardados</small>
                        </a>
                        <a class="overview-stat" href="#favoritos" data-go="favoritos">
                            <strong>{{ $personalStats['favorites'] }}</strong>
                            <span>Favoritos</span>
                            <small>Tus preferidas</small>
                        </a>
                        <a class="overview-stat" href="#blog" data-go="blog">
                            <strong>{{ $personalStats['drafts'] }}</strong>
                            <span>Borradores</span>
                            <small>Escritos en pausa</small>
                        </a>
                        <a class="overview-stat" href="#diario" data-go="diario">
                            <strong>{{ $personalStats['diary'] }}</strong>
                            <span>Entradas</span>
                            <small>Diario personal</small>
                        </a>
                    </div>

                    <div class="personal-section-heading">
                        <span class="eyebrow">NAVEGACIÓN RÁPIDA</span>
                        <h2>Accesos directos a tus rincones</h2>
                    </div>

                    <nav class="personal-shortcuts personal-shortcuts-luxury" aria-label="Accesos rápidos de mi espacio">
                        <a class="personal-shortcut-card luxury-card" href="#favoritos" data-go="favoritos">
                            <div class="shortcut-icon-circle icon-heart"><span>♡</span></div>
                            <div class="shortcut-text">
                                <strong>Mis favoritos</strong>
                                <p>Tus fotografías y momentos más entrañables para revivir al instante.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>

                        <a class="personal-shortcut-card luxury-card" href="#diario" data-go="diario">
                            <div class="shortcut-icon-circle icon-diary"><span>⌑</span></div>
                            <div class="shortcut-text">
                                <strong>Mi diario personal</strong>
                                <p>Un espacio confidencial para tus reflexiones, confidencias y memorias.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>

                        <a class="personal-shortcut-card luxury-card" href="#blog" data-go="blog">
                            <div class="shortcut-icon-circle icon-profile"><span>✿</span></div>
                            <div class="shortcut-text">
                                <strong>Mi perfil destacado</strong>
                                <p>Edita tu biografía, presentación, trayectoria y fotografía de portada.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>

                        <a class="personal-shortcut-card luxury-card" href="#entretenimiento" data-go="entretenimiento">
                            <div class="shortcut-icon-circle icon-music"><span>♫</span></div>
                            <div class="shortcut-text">
                                <strong>Entretenimiento & Música</strong>
                                <p>Colección de piezas sonoras y videos que acompañan tus horas.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>

                        <a class="personal-shortcut-card luxury-card" href="#blog" data-go="blog">
                            <div class="shortcut-icon-circle icon-blog"><span>✎</span></div>
                            <div class="shortcut-text">
                                <strong>Gestionar mi blog</strong>
                                <p>Revisa publicaciones, edita artículos o redacta nuevos textos inspirados.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>

                        @if (auth()->check() && (auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true)))
                        <a class="personal-shortcut-card luxury-card" href="#admin" data-go="admin">
                            <div class="shortcut-icon-circle icon-admin"><span>⚙</span></div>
                            <div class="shortcut-text">
                                <strong>Panel de administración</strong>
                                <p>Gestión global de seguridad, preguntas del quiz y configuración del jardín.</p>
                            </div>
                            <span class="shortcut-arrow-action" aria-hidden="true">→</span>
                        </a>
                        @endif
                    </nav>
                @else
                    <div class="personal-panel personal-panel-luxury personal-panel-guest">
                        <div class="personal-avatar-wrap">
                            <span class="personal-avatar" aria-hidden="true">C</span>
                            <span class="avatar-sparkle">✦</span>
                        </div>
                        <div class="personal-panel-info">
                            <span class="eyebrow">ACCESO PRIVADO</span>
                            <h2>Hola, Carla</h2>
                            <p>Inicia sesión para abrir tus álbumes confidenciales, escribir en tu diario y descubrir todo lo que este rincón guarda para ti.</p>
                            <a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span>↗</span></a>
                        </div>
                    </div>
                @endauth
            </div>
        </section>
