        <section class="screen" data-screen="mapa" aria-labelledby="map-title" hidden>
            <div class="page-shell">
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Constelación de rincones soñados</p>
                        <h1 id="map-title" class="shimmer-title">El mapa del <em>jardín secreto</em></h1>
                        <p>Cada sendero teje una historia y cada destino guarda un pensamiento para ti. Desliza sobre las islas para iluminar el camino.</p>
                    </div>
                    <span class="heading-mark romantic-spin" aria-hidden="true">❦</span>
                </div>

                <div class="universe-map constellation-map botanical-garden-realm">
                    <!-- Marco Botánico de Enredaderas y Rosas en Acuarela -->
                    <svg class="garden-botanical-frame" viewBox="0 0 1000 500" preserveAspectRatio="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="roseGoldVine" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#40916c" stop-opacity="0.85"/>
                                <stop offset="50%" stop-color="#2d6a4f" stop-opacity="0.95"/>
                                <stop offset="100%" stop-color="#52b788" stop-opacity="0.9"/>
                            </linearGradient>
                            <radialGradient id="roseCoreGlow" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                                <stop offset="60%" stop-color="#d8f3dc" stop-opacity="0.9"/>
                                <stop offset="100%" stop-color="#74c69d" stop-opacity="0"/>
                            </radialGradient>
                            <filter id="fairydust" x="-20%" y="-20%" width="140%" height="140%">
                                <feGaussianBlur stdDeviation="3" result="blur"/>
                                <feComposite in="SourceGraphic" in2="blur" operator="over"/>
                            </filter>
                        </defs>
                        <!-- Enredaderas perimetrales suaves -->
                        <path class="botanical-vine vine-tl" d="M0,0 Q120,30 220,10 T400,0 M0,0 Q30,120 10,240 T0,380" stroke="url(#roseGoldVine)" stroke-width="2.5" fill="none"/>
                        <path class="botanical-vine vine-br" d="M1000,500 Q880,470 780,490 T600,500 M1000,500 Q970,380 990,260 T1000,120" stroke="url(#roseGoldVine)" stroke-width="2.5" fill="none"/>
                    </svg>

                    <svg class="map-paths" viewBox="0 0 1000 640" preserveAspectRatio="none" aria-hidden="true">
                        <defs>
                            <linearGradient id="goldGlow" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f77f00" stop-opacity="0.95"/>
                                <stop offset="50%" stop-color="#fcbf49" stop-opacity="0.95"/>
                                <stop offset="100%" stop-color="#d62828" stop-opacity="0.85"/>
                            </linearGradient>

                            <!-- Símbolo de Corazón Botánico Radiante para el sendero -->
                            <g id="trail-heart-symbol">
                                <path d="M0 -3 C -2.5 -7, -7 -5, -7 0 C -7 4.5, 0 9, 0 10 C 0 9, 7 4.5, 7 0 C 7 -5, 2.5 -7, 0 -3 Z" fill="url(#goldGlow)" filter="drop-shadow(0 0 5px rgba(247, 127, 0, 0.75))"/>
                                <circle cx="0" cy="0" r="1.5" fill="#ffffff" opacity="0.95"/>
                            </g>

                            <!-- Trayectorias definidas para animación de movimiento -->
                            <path id="orbit-path" d="M 500, 80 a 390,240 0 1,0 0.1,0 Z" fill="none"/>
                            <path id="branch-path-1" d="M130 110 C 280 200, 380 280, 500 320 S 720 440, 870 510" fill="none"/>
                            <path id="branch-path-2" d="M820 110 C 680 200, 580 280, 500 320 S 280 440, 130 510" fill="none"/>
                        </defs>

                        <!-- Senderos visibles -->
                        <path class="constellation-trail main-trail" d="M 500, 80 a 390,240 0 1,0 0.1,0 Z"/>
                        <path class="constellation-trail branch-trail-1" d="M130 110 C 280 200, 380 280, 500 320 S 720 440, 870 510"/>
                        <path class="constellation-trail branch-trail-2" d="M820 110 C 680 200, 580 280, 500 320 S 280 440, 130 510"/>

                        <!-- Puntos florecientes fijos -->
                        <circle cx="280" cy="190" r="4" fill="#52b788" class="trail-waypoint"/>
                        <circle cx="720" cy="190" r="4" fill="#f77f00" class="trail-waypoint"/>
                        <circle cx="500" cy="80"  r="4.5" fill="#52b788" class="trail-waypoint"/>
                        <circle cx="500" cy="560" r="4.5" fill="#f77f00" class="trail-waypoint"/>
                        <circle cx="110" cy="320" r="4" fill="#52b788" class="trail-waypoint"/>
                        <circle cx="890" cy="320" r="4" fill="#f77f00" class="trail-waypoint"/>

                        <!-- Corazones en movimiento a lo largo de las líneas -->
                        <!-- Corazón 1: Órbita Elíptica -->
                        <g class="moving-trail-heart">
                            <use href="#trail-heart-symbol"/>
                            <animateMotion dur="14s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#orbit-path"/>
                            </animateMotion>
                        </g>

                        <!-- Corazón 2: Órbita Elíptica (Desfasado) -->
                        <g class="moving-trail-heart">
                            <use href="#trail-heart-symbol"/>
                            <animateMotion dur="14s" begin="-7s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#orbit-path"/>
                            </animateMotion>
                        </g>

                        <!-- Corazón 3: Diagonal 1 (Ida y Vuelta) -->
                        <g class="moving-trail-heart">
                            <use href="#trail-heart-symbol"/>
                            <animateMotion dur="10s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                <mpath href="#branch-path-1"/>
                            </animateMotion>
                        </g>

                        <!-- Corazón 4: Diagonal 2 (Ida y Vuelta Desfasada) -->
                        <g class="moving-trail-heart">
                            <use href="#trail-heart-symbol"/>
                            <animateMotion dur="11s" begin="-5.5s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                <mpath href="#branch-path-2"/>
                            </animateMotion>
                        </g>
                    </svg>

                    <!-- Guirnaldas botánicas flotantes / luciérnagas -->
                    <div class="garden-fireflies" aria-hidden="true">
                        <span class="firefly f-1"></span>
                        <span class="firefly f-2"></span>
                        <span class="firefly f-3"></span>
                        <span class="firefly f-4"></span>
                        <span class="firefly f-5"></span>
                    </div>

                    <!-- Nodos del Jardín Estilo Medallón Botánico -->
                    <a class="map-place place-gallery floral-island luxury-medallion" href="#galeria" data-go="galeria" data-tooltip="Recuerdos preciosos que iluminan el tiempo">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">🌸</span>
                        <strong>Galería</strong>
                        <small>instantes mágicos</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-library floral-island luxury-medallion" href="#biblioteca" data-go="biblioteca" data-tooltip="Palabras, notas dulces y música en calma">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">📖</span>
                        <strong>Rincón de Paz</strong>
                        <small>lectura & música</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-garden floral-island luxury-medallion" href="#jardin" data-go="jardin" data-tooltip="El santuario botánico dedicado para ti">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">🌹</span>
                        <strong>Santuario</strong>
                        <small>flores & calma</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-dreams floral-island luxury-medallion" href="#destinos" data-go="destinos" data-tooltip="Lugares y viajes por descubrir juntos">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">🕊️</span>
                        <strong>Destinos</strong>
                        <small>sueños futuros</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-games floral-island luxury-medallion" href="#juegos" data-go="juegos" data-tooltip="Pequeños juegos para robarte una sonrisa">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">✨</span>
                        <strong>Juegos</strong>
                        <small>momentos alegres</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-stories floral-island luxury-medallion" href="#historias" data-go="historias" data-tooltip="Historias de fantasía donde tú eliges el rumbo">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">👑</span>
                        <strong>Historias</strong>
                        <small>aventura & magia</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-blog floral-island luxury-medallion" href="#blog" data-go="blog" data-tooltip="Notas públicas y destellos de inspiración">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">✍️</span>
                        <strong>El Blog</strong>
                        <small>inspiración</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-entertainment floral-island luxury-medallion" href="#entretenimiento" data-go="entretenimiento" data-tooltip="Tus canciones y videos más queridos">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">🎶</span>
                        <strong>Melodías</strong>
                        <small>rincón privado</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-capsule floral-island luxury-medallion" href="#capsula" data-go="capsula" data-tooltip="Cartas selladas y recuerdos para abrir en el futuro">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">⏳</span>
                        <strong>Cápsula</strong>
                        <small>cartas del futuro</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-amigos floral-island luxury-medallion medallion-friends-pulse" href="#amigos" data-go="amigos" data-tooltip="Dedicatorias de amigos con todo lo que piensan de Carla">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">🌸</span>
                        <strong>Amigos</strong>
                        <small>dedicatorias sinceras</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <a class="map-place place-dedicatoria floral-island luxury-medallion medallion-gold-pulse" href="#dedicatoria" data-go="dedicatoria" data-tooltip="Palabras sinceras y promesas de amor eterno para ti">
                        <span class="medallion-halo"></span>
                        <span class="place-symbol">💌</span>
                        <strong>Dedicatoria</strong>
                        <small>mi espacio para ti</small>
                        <span class="medallion-leaf-accent"></span>
                    </a>

                    <!-- Corazón Central: Rosa Emblema de Carla Lorena (Interactiva) -->
                    <div class="map-center heart-center luxury-heart-emblem" 
                         id="map-center-rose-trigger"
                         role="button" 
                         tabindex="0" 
                         aria-label="Abrir carta de amor, poema y sentimiento para Carla Lorena" 
                         title="Haz clic para abrir la carta de amor, poema y sentimiento de Carla Lorena">
                        <div class="pulse-ring pulse-ring-1"></div>
                        <div class="pulse-ring pulse-ring-2"></div>
                        <span class="emblem-rose-icon">🌹</span>
                        <span class="emblem-heart">♡</span>
                        <small>CARLA</small>
                    </div>

                    <span class="map-sparkle sparkle-one" aria-hidden="true">✧</span>
                    <span class="map-sparkle sparkle-two" aria-hidden="true">✦</span>
                    <span class="map-sparkle sparkle-three" aria-hidden="true">✨</span>
                </div>

                <div class="map-footer">
                    <span><i></i> 11 constelaciones florecientes</span>
                    <span class="map-hint-text">Pasa el cursor sobre un rincón para descubrir su significado</span>
                    <a class="text-link" href="#dedicatoria" data-go="dedicatoria">Leer mi dedicatoria especial <span aria-hidden="true">💌 →</span></a>
                </div>

                <!-- Sección de Cartas Románticas con Sello de Lacre Digital -->
                <div class="love-letters-section">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">NOTAS CON SELLO DE LACRE</p>
                            <h2>Cartas secretas para Carla Lorena</h2>
                        </div>
                        <span class="letters-subtitle">Toca el sello para abrir el mensaje</span>
                    </div>

                    <div class="letters-grid">
                        <article class="wax-letter-card" data-letter="1">
                            <div class="wax-seal-btn" role="button" tabindex="0" aria-label="Romper sello de lacre de la carta 1">
                                <span class="seal-stamp">C</span>
                            </div>
                            <span class="letter-tag">Carta 01 · Para ti</span>
                            <h3>Un pensamiento en el camino</h3>
                            <div class="letter-inner-content">
                                <p>«Si tuviera que elegir un solo motivo para sonreír hoy, elegiría la fortuna de ver florecer tu mundo. Este jardín es solo un reflejo de toda la luz que llevas dentro.»</p>
                                <span class="letter-signature">— Con cariño infinito ♡</span>
                            </div>
                        </article>

                        <article class="wax-letter-card" data-letter="2">
                            <div class="wax-seal-btn" role="button" tabindex="0" aria-label="Romper sello de lacre de la carta 2">
                                <span class="seal-stamp">C</span>
                            </div>
                            <span class="letter-tag">Carta 02 · En calma</span>
                            <h3>La serenidad de tu presencia</h3>
                            <div class="letter-inner-content">
                                <p>«Hay personas que son como un refugio cálido en medio de cualquier tormenta. Gracias por ser esa calma bonita que transforma los días ordinarios en instantes extraordinarios.»</p>
                                <span class="letter-signature">— Siempre para ti ❀</span>
                            </div>
                        </article>

                        <article class="wax-letter-card" data-letter="3">
                            <div class="wax-seal-btn" role="button" tabindex="0" aria-label="Romper sello de lacre de la carta 3">
                                <span class="seal-stamp">C</span>
                            </div>
                            <span class="letter-tag">Carta 03 · Promesa</span>
                            <h3>Lo mejor siempre está por venir</h3>
                            <div class="letter-inner-content">
                                <p>«Que cada pétalo de este jardín te recuerde lo especial que eres, los sueños que esperan cumplirse y que nunca faltarán motivos para celebrar tu sonrisa.»</p>
                                <span class="letter-signature">— Por un sinfín de sonrisas ✨</span>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- El Árbol de los Deseos y Promesas -->
                <div class="wishing-tree-section">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">DETALLES QUE ENAMORAN · RAMAS EN FLOR</p>
                            <h2>El Árbol de los Deseos & Promesas</h2>
                        </div>
                        <span class="letters-subtitle">Toca cada capullo para revelar una dedicatoria secreta</span>
                    </div>

                    <div class="wishing-tree-grid">
                        <button class="wish-bud-card" type="button" data-wish="1" aria-label="Abrir deseo 1">
                            <span class="bud-icon">🌸</span>
                            <span class="bud-tag">Capullo de Luz</span>
                            <h4>Tu Alegría</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Que nunca se apague esa luz tan bonita y contagiosa que tienes. El mundo es más amable y cálido desde que estás en él.»</p>
                                <small>Con admiración sincera</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="2" aria-label="Abrir deseo 2">
                            <span class="bud-icon">🌹</span>
                            <span class="bud-tag">Capullo de Rosa</span>
                            <h4>Tu Fortaleza</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Incluso en los días difíciles, recuerda la inmensa gracia y valentía con la que caminas. Siempre serás inspiración.»</p>
                                <small>Un abrazo al alma</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="3" aria-label="Abrir deseo 3">
                            <span class="bud-icon">🌿</span>
                            <span class="bud-tag">Capullo de Jazmín</span>
                            <h4>Momentos Bonitos</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Deseo que los días que vienen te regalen instantes de paz infinita, risas espontáneas y flores en cada esquina del camino.»</p>
                                <small>Promesa del jardín</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="4" aria-label="Abrir deseo 4">
                            <span class="bud-icon">✨</span>
                            <span class="bud-tag">Capullo Dorado</span>
                            <h4>Nuestros Horizontes</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Por cada sueño que anheles cumplir, aquí habrá un lugar donde celebrar cada logro y recordarte lo valiosa y especial que eres.»</p>
                                <small>Siempre contigo</small>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- El Paseo Romántico de Recuerdos y Momentos en Pareja -->
                <div class="romantic-promenade-section">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">EL PASEO DE LOS RECUERDOS</p>
                            <h2>Momentos de complicidad y cariño</h2>
                        </div>
                        <span class="letters-subtitle">Capítulos grabados en el corazón</span>
                    </div>

                    <div class="promenade-cards-grid">
                        <article class="promenade-card">
                            <div class="promenade-visual">
                                <span class="promenade-silhouette">🌿 ☕ 🌸</span>
                                <span class="promenade-time">Tardes de calma</span>
                            </div>
                            <div class="promenade-body">
                                <h3>La charla sin prisa</h3>
                                <p>Esos momentos donde el tiempo se detiene, un café tibio entre las manos y el silencio cómplice que dice más que mil palabras.</p>
                                <span class="promenade-quote">«Contigo, cualquier lugar se siente hogar.»</span>
                            </div>
                        </article>

                        <article class="promenade-card">
                            <div class="promenade-visual">
                                <span class="promenade-silhouette">✨ 🌙 🌹</span>
                                <span class="promenade-time">Noches bajo las estrellas</span>
                            </div>
                            <div class="promenade-body">
                                <h3>Caminar bajo la luna</h3>
                                <p>Caminar a paso suave mientras el cielo se llena de constelaciones, compartiendo risas y planes futuros que dibujan sonrisas.</p>
                                <span class="promenade-quote">«La mejor compañía es la que ilumina tu noche.»</span>
                            </div>
                        </article>

                        <article class="promenade-card">
                            <div class="promenade-visual">
                                <span class="promenade-silhouette">🎶 🌺 🕊️</span>
                                <span class="promenade-time">Melodías compartidas</span>
                            </div>
                            <div class="promenade-body">
                                <h3>Canciones que unen</h3>
                                <p>Aquellas canciones que suenan y de inmediato traen tu recuerdo, como una fragancia que impregna los sentidos de alegría pura.</p>
                                <span class="promenade-quote">«Tu risa es la melodía favorita de este jardín.»</span>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="space-grid map-shortcuts botanical-shortcuts-grid">
                    <a class="space-card space-card-entertainment luxury-card" href="#entretenimiento" data-go="entretenimiento">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">♫ 🌺</span>
                            <span class="card-number">PRIVADO · CARLA</span>
                        </div>
                        <h3>Espacio de entretenimiento</h3>
                        <p>Tus canciones más queridas y momentos multimedia guardados con ternura.</p>
                        <span class="card-mini-quote">«Donde la música abraza el silencio»</span>
                        <span class="card-arrow" aria-hidden="true">↗</span>
                    </a>

                    <a class="space-card space-card-treasure luxury-card" href="#tesoro" data-go="tesoro">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">⌕ 🗝️</span>
                            <span class="card-number">MISTERIO · EXTRA</span>
                        </div>
                        <h3>Búsqueda del tesoro</h3>
                        <p>Una pequeña pista entre las hojas puede llevar a un secreto dulce.</p>
                        <span class="card-mini-quote">«Un hallazgo esperando por tu sonrisa»</span>
                        <span class="card-arrow" aria-hidden="true">↗</span>
                    </a>

                    <a class="space-card space-card-reading luxury-card" href="#diario" data-go="diario">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">⌑ 📖</span>
                            <span class="card-number">ÍNTIMO · PRIVADO</span>
                        </div>
                        <h3>Mi diario</h3>
                        <p>Un cuaderno de pensamientos personales, protegido y solo visible para ti.</p>
                        <span class="card-mini-quote">«Páginas guardadas en el corazón»</span>
                        <span class="card-arrow" aria-hidden="true">↗</span>
                    </a>

                    <a class="space-card space-card-personal luxury-card" href="#conociendo-carla" data-go="conociendo-carla">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">? 🌸</span>
                            <span class="card-number">RETO · CARIÑO</span>
                        </div>
                        <h3>Conociendo a Carla Lorena</h3>
                        <p>Diez preguntas para celebrar lo que te hace única y una foto de recompensa.</p>
                        <span class="card-mini-quote">«Cada respuesta es una joya tuya»</span>
                        <span class="card-arrow" aria-hidden="true">↗</span>
                    </a>

                    <a class="space-card space-card-personal luxury-card" href="#albumes" data-go="albumes">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">＋ 📸</span>
                            <span class="card-number">TU ESPACIO · FOTOS</span>
                        </div>
                        <h3>Mis álbumes</h3>
                        <p>Tu propio rincón fotográfico para atesorar colecciones de recuerdos bonitos.</p>
                        <span class="card-mini-quote">«Momentos que nunca se olvidan»</span>
                        <span class="card-arrow" aria-hidden="true">↗</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!--  PANTALLA: DEDICATORIAS DE AMIGOS (VOCES DEL CORAZÓN)               -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->