        <section class="screen" id="screen-mapa" data-screen="mapa" aria-labelledby="map-title" hidden>
            <div class="page-shell">
                <div class="page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge">JARDÍN BOTÁNICO INTERACTIVO</span>
                            <span class="atelier-dot">✿</span>
                            <span class="atelier-badge">CONSTELACIÓN DE ROSAS & RECUERDOS</span>
                        </div>
                        <p class="eyebrow">Senderos de seda, pétalos y recuerdos eternos</p>
                        <h1 id="map-title" class="shimmer-title">El mapa del <em>jardín secreto</em></h1>
                        <p>Un universo botánico en flor donde 12 talismanes y rincones atesoran un pensamiento para ti. Desliza sobre cada talismán para iluminar las enredaderas de oro rosa y descubrir su esencia.</p>
                    </div>
                    <span class="heading-mark romantic-spin" aria-hidden="true">🌹</span>
                </div>

                <!-- Barra de Dinamismo y Floración del Jardín -->
                <div class="garden-motion-toolbar prism-toolbar" role="toolbar" aria-label="Controles del Jardín Secreto">
                    <div class="garden-toolbar-left">
                        <span class="garden-status-pill prism-status-pill">
                            <span class="pulse-emerald-dot prism-diamond-dot"></span>
                            <span id="garden-season-label">Rosaleda en Flor · 12 Talismanes en Armonía</span>
                        </span>
                    </div>
                    <div class="garden-toolbar-right">
                        <button type="button" class="garden-motion-btn prism-motion-btn" id="btn-garden-bloom-wave" title="Floración radiante: emitir cascada de pétalos y luz oro-rosa">
                            <span class="btn-icon">🌹</span>
                            <span>Floración Radiante</span>
                        </button>
                        <button type="button" class="garden-motion-btn prism-motion-btn" id="btn-garden-breeze-toggle" title="Aumentar o suavizar la brisa de pétalos y polen dorado">
                            <span class="btn-icon">🌸</span>
                            <span id="label-garden-breeze">Brisa de Pétalos</span>
                        </button>
                        <button type="button" class="garden-motion-btn prism-motion-btn" id="btn-garden-weather-cycle" title="Cambiar la luz del jardín (Atardecer Rosado / Noche de Estrellas / Mañana en Flor)">
                            <span class="btn-icon" id="icon-garden-weather">🌅</span>
                            <span id="label-garden-weather">Atardecer Rosado</span>
                        </button>
                        <button type="button" class="garden-motion-btn is-active prism-motion-btn" id="btn-garden-sound-toggle" title="Activar o pausar la armonía del jardín">
                            <span class="btn-icon">🌷</span>
                            <span id="label-garden-sound">Armonía Activa</span>
                        </button>
                    </div>
                </div>

                <!-- Cápsula Editorial Integrada (Evita colapsos y muestra siempre el rincón activo) -->
                <div class="map-editorial-inspect-bar" id="map-editorial-inspect-bar" aria-live="polite">
                    <span class="mei-emblem" id="mei-emblem">🌹</span>
                    <div class="mei-content">
                        <div class="mei-title-group">
                            <strong class="mei-title" id="mei-title">El Corazón del Jardín de Carla</strong>
                            <span class="mei-badge" id="mei-badge">GRAN ROSA IMPERIAL</span>
                        </div>
                        <p class="mei-quote" id="mei-quote">«Pasa el cursor sobre cualquier flor del mapa para iluminar su sendero y descubrir lo que guarda para ti.»</p>
                    </div>
                    <span class="mei-action-hint" id="mei-action-hint">Explora los 12 talismanes ✿</span>
                </div>

                <!-- Reino Botánico Dinámico con Tecnología Motion 3D -->
                <div class="universe-map constellation-map botanical-garden-realm dynamic-garden-container" 
                     id="dynamic-floral-garden-realm" 
                     data-garden-atmosphere="sunset"
                     data-garden-breeze="normal">

                    <!-- Rayos Solares & Brillo Natural de Sol -->
                    <div class="sun-glamour-layer" aria-hidden="true">
                        <div class="sun-golden-orb"></div>
                        <div class="sun-caustic-light"></div>
                        <div class="sun-lens-flare"></div>
                    </div>

                    <!-- Canvas de Física de Brisa de Pétalos y Polen Luminoso -->
                    <canvas class="garden-motion-canvas" id="garden-motion-canvas" aria-hidden="true"></canvas>

                    <!-- Escenario con Red de Enredaderas Oro-Rosa y Seda Carmesí -->
                    <div class="garden-3d-stage" id="garden-3d-stage">

                        <!-- Red de Enredaderas Orgánicas en Oro-Rosa y Seda Carmesí (SVG) -->
                        <svg class="garden-botanical-frame prism-light-frame" viewBox="0 0 1000 780" preserveAspectRatio="none" aria-hidden="true">
                            <defs>
                                <!-- Gradiente Enredadera Oro-Rosa y Seda Carmesí -->
                                <linearGradient id="roseGoldVineGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#c93b61" stop-opacity="0.72"/>
                                    <stop offset="50%" stop-color="#d4af37" stop-opacity="0.82"/>
                                    <stop offset="100%" stop-color="#e27a96" stop-opacity="0.75"/>
                                </linearGradient>

                                <!-- Gradiente Enredadera Iluminada (Hover) -->
                                <linearGradient id="roseGoldVineLitGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#9e2a47" stop-opacity="1"/>
                                    <stop offset="50%" stop-color="#f59e0b" stop-opacity="1"/>
                                    <stop offset="100%" stop-color="#e11d48" stop-opacity="1"/>
                                </linearGradient>

                                <!-- Fotón de Rocío Floral -->
                                <radialGradient id="diamondPhoton" cx="50%" cy="50%" r="50%">
                                    <stop offset="0%" stop-color="#ffffff"/>
                                    <stop offset="40%" stop-color="#fde68a"/>
                                    <stop offset="75%" stop-color="#f43f5e"/>
                                    <stop offset="100%" stop-color="#be123c" stop-opacity="0"/>
                                </radialGradient>

                                <!-- Gradientes de Fauna: Mariposas & Mariquitas -->
                                <linearGradient id="monarchForewingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ff4b72"/>
                                    <stop offset="50%" stop-color="#fb7185"/>
                                    <stop offset="100%" stop-color="#fde047"/>
                                </linearGradient>
                                <linearGradient id="monarchHindwingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#be123c"/>
                                    <stop offset="100%" stop-color="#fb7185"/>
                                </linearGradient>
                                <linearGradient id="azureForewingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#0284c7"/>
                                    <stop offset="50%" stop-color="#38bdf8"/>
                                    <stop offset="100%" stop-color="#c084fc"/>
                                </linearGradient>
                                <linearGradient id="azureHindwingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#0369a1"/>
                                    <stop offset="100%" stop-color="#818cf8"/>
                                </linearGradient>
                                <linearGradient id="goldForewingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#d97706"/>
                                    <stop offset="50%" stop-color="#fbbf24"/>
                                    <stop offset="100%" stop-color="#fef08a"/>
                                </linearGradient>
                                <linearGradient id="goldHindwingGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#b45309"/>
                                    <stop offset="100%" stop-color="#f59e0b"/>
                                </linearGradient>
                                <radialGradient id="ladybugShellGrad" cx="35%" cy="30%" r="65%">
                                    <stop offset="0%" stop-color="#ff4d6d"/>
                                    <stop offset="45%" stop-color="#e11d48"/>
                                    <stop offset="85%" stop-color="#9f1239"/>
                                    <stop offset="100%" stop-color="#4c0519"/>
                                </radialGradient>
                                <radialGradient id="ladybugShine" cx="30%" cy="25%" r="40%">
                                    <stop offset="0%" stop-color="#ffffff" stop-opacity="0.85"/>
                                    <stop offset="100%" stop-color="#ffffff" stop-opacity="0"/>
                                </radialGradient>

                                <!-- Símbolo de Rocío de Rosa Viajero -->
                                <g id="diamond-spark-symbol">
                                    <circle cx="0" cy="0" r="4" fill="url(#diamondPhoton)"/>
                                    <circle cx="0" cy="0" r="2" fill="#fb7185" stroke="#fde68a" stroke-width="0.8"/>
                                </g>

                                <!-- Símbolo de Capullo Decorativo en las Ramas -->
                                <g id="vine-rosebud-node">
                                    <circle cx="0" cy="0" r="5" fill="#fff5f7" stroke="#d4af37" stroke-width="1.3"/>
                                    <circle cx="0" cy="0" r="2.3" fill="#d4607a"/>
                                </g>

                                <!-- Senderos Curvos Orgánicos Bézier desde el Corazón (500,390) a los 12 Nodos -->
                                <path id="path-gallery"       d="M 500,390 C 370,300 240,210 120,120"  fill="none"/>
                                <path id="path-capsule"       d="M 500,390 C 430,270 350,170 270,105"  fill="none"/>
                                <path id="path-library"       d="M 500,390 C 496,280 504,180 500,85"   fill="none"/>
                                <path id="path-amigos"        d="M 500,390 C 570,270 650,170 730,105"  fill="none"/>
                                <path id="path-dedicatoria"   d="M 500,390 C 650,330 780,270 885,235"  fill="none"/>
                                <path id="path-garden"        d="M 500,390 C 660,395 790,405 905,405"  fill="none"/>
                                <path id="path-entertainment" d="M 500,390 C 640,470 770,530 885,575"  fill="none"/>
                                <path id="path-games"         d="M 500,390 C 560,500 650,600 740,670"  fill="none"/>
                                <path id="path-dreams"        d="M 500,390 C 440,500 350,600 260,670"  fill="none"/>
                                <path id="path-blog"          d="M 500,390 C 360,470 230,530 115,575"  fill="none"/>
                                <path id="path-stories"       d="M 500,390 C 350,335 220,290 100,250"  fill="none"/>
                                <path id="path-family"        d="M 500,390 C 340,395 210,410 95,410"   fill="none"/>

                                <!-- Órbita Floral Elíptica -->
                                <path id="path-ring-orbit" d="M 500, 100 a 410,290 0 1,0 0.1,0 Z" fill="none"/>
                            </defs>

                            <!-- Halo y Anillos Orbitales de Seda Oro-Rosa -->
                            <ellipse cx="500" cy="390" rx="410" ry="290" fill="none" stroke="rgba(212, 96, 122, 0.18)" stroke-width="1.3" stroke-dasharray="6,8" class="prism-orbit-ellipse"/>
                            <ellipse cx="500" cy="390" rx="260" ry="190" fill="none" stroke="rgba(212, 175, 55, 0.24)" stroke-width="1.1" stroke-dasharray="3,6" class="prism-orbit-inner"/>
                            <circle  cx="500" cy="390" r="95"  fill="none" stroke="rgba(201, 59, 97, 0.20)" stroke-width="1" stroke-dasharray="2,5"/>

                            <!-- Enredaderas Curvas de Luz Oro-Rosa y Seda Carmesí hacia los 12 Rincones -->
                            <path d="M 500,390 C 370,300 240,210 120,120"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="galeria"/>
                            <path d="M 500,390 C 430,270 350,170 270,105"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="capsula"/>
                            <path d="M 500,390 C 496,280 504,180 500,85"   class="living-botanical-trail radial-branch prism-light-beam" data-branch="biblioteca"/>
                            <path d="M 500,390 C 570,270 650,170 730,105"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="amigos"/>
                            <path d="M 500,390 C 650,330 780,270 885,235"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="dedicatoria"/>
                            <path d="M 500,390 C 660,395 790,405 905,405"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="jardin"/>
                            <path d="M 500,390 C 640,470 770,530 885,575"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="entretenimiento"/>
                            <path d="M 500,390 C 560,500 650,600 740,670"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="juegos"/>
                            <path d="M 500,390 C 440,500 350,600 260,670"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="destinos"/>
                            <path d="M 500,390 C 360,470 230,530 115,575"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="blog"/>
                            <path d="M 500,390 C 350,335 220,290 100,250"  class="living-botanical-trail radial-branch prism-light-beam" data-branch="historias"/>
                            <path d="M 500,390 C 340,395 210,410 95,410"   class="living-botanical-trail radial-branch prism-light-beam" data-branch="familia"/>

                            <!-- Capullos Luminosos Intermedios en las Enredaderas -->
                            <use href="#vine-rosebud-node" x="310" y="250" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="410" y="230" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="500" y="235" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="590" y="230" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="690" y="250" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="720" y="320" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="710" y="480" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="620" y="535" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="380" y="535" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="290" y="480" class="branch-node-flower prism-vertex-dot"/>
                            <use href="#vine-rosebud-node" x="280" y="320" class="branch-node-flower prism-vertex-dot"/>

                            <!-- Rocío de Luz Viajero en Movimiento Continuo -->
                            <g class="moving-nectar-pulse prism-photon-pulse">
                                <circle cx="0" cy="0" r="3.5" fill="url(#diamondPhoton)"/>
                                <animateMotion dur="16s" repeatCount="indefinite" rotate="auto">
                                    <mpath href="#path-ring-orbit"/>
                                </animateMotion>
                            </g>
                            <g class="moving-nectar-pulse prism-photon-pulse">
                                <use href="#diamond-spark-symbol"/>
                                <animateMotion dur="9s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                    <mpath href="#path-gallery"/>
                                </animateMotion>
                            </g>
                            <g class="moving-nectar-pulse prism-photon-pulse">
                                <use href="#diamond-spark-symbol"/>
                                <animateMotion dur="8s" begin="-2s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                    <mpath href="#path-library"/>
                                </animateMotion>
                            </g>
                            <g class="moving-nectar-pulse prism-photon-pulse">
                                <use href="#diamond-spark-symbol"/>
                                <animateMotion dur="8.5s" begin="-3.5s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                    <mpath href="#path-dedicatoria"/>
                                </animateMotion>
                            </g>
                            <g class="moving-nectar-pulse prism-photon-pulse">
                                <use href="#diamond-spark-symbol"/>
                                <animateMotion dur="10s" begin="-5s" repeatCount="indefinite" rotate="auto" keyPoints="0;1;0" keyTimes="0;0.5;1" calcMode="spline" keySplines="0.4 0 0.6 1; 0.4 0 0.6 1">
                                    <mpath href="#path-games"/>
                                </animateMotion>
                            </g>
                        </svg>

                        <!-- Destellos Botánicos Sutiles -->
                        <div class="prism-light-flares" aria-hidden="true">
                            <span class="prism-flare pf-1">✿</span>
                            <span class="prism-flare pf-2">✦</span>
                            <span class="prism-flare pf-3">❀</span>
                            <span class="prism-flare pf-4">🌸</span>
                            <span class="prism-flare pf-5">✨</span>
                        </div>

                        <!-- ═══════════════════════════════════════════════════════════ -->
                        <!--  FAUNA ENCANTADA: MARIPOSAS & MARIQUITAS DEL JARDÍN SECRETO -->
                        <!-- ═══════════════════════════════════════════════════════════ -->
                        <div class="garden-fauna-layer" id="garden-fauna-layer" aria-label="Mariposas y mariquitas del jardín secreto">
                            <!-- 1. Mariposa Monarca Rosa (Vuelo libre en cuadrante superior izquierdo) -->
                            <div class="garden-creature butterfly-creature butterfly-monarch-rose" 
                                 id="butterfly-monarch-rose" 
                                 role="button" 
                                 tabindex="0" 
                                 data-creature="mariposa-rosa" 
                                 data-message="🦋 Mariposa Monarca: «Mensajera de tus sueños más bellos, Carla»" 
                                 title="Mariposa Monarca · Toca para verla volar" 
                                 aria-label="Mariposa Monarca de Carla">
                                <div class="butterfly-wing-wrap">
                                    <svg class="butterfly-svg butterfly-wing-left" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M22,16 C20,5 12,0 2,1 C-1,9 5,20 22,16 Z" fill="url(#monarchForewingGrad)" stroke="#9f1239" stroke-width="0.8"/>
                                        <path d="M22,16 C17,18 8,21 4,30 C11,32 18,26 22,16 Z" fill="url(#monarchHindwingGrad)" stroke="#9f1239" stroke-width="0.8"/>
                                        <circle cx="8" cy="8" r="1.2" fill="#fff" opacity="0.9"/>
                                        <circle cx="15" cy="6" r="1.1" fill="#fef08a" opacity="0.9"/>
                                        <circle cx="9" cy="25" r="1" fill="#fff" opacity="0.9"/>
                                    </svg>
                                    <div class="butterfly-body-core"></div>
                                    <svg class="butterfly-svg butterfly-wing-right" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M2,16 C4,5 12,0 22,1 C25,9 19,20 2,16 Z" fill="url(#monarchForewingGrad)" stroke="#9f1239" stroke-width="0.8"/>
                                        <path d="M2,16 C7,18 16,21 20,30 C13,32 6,26 2,16 Z" fill="url(#monarchHindwingGrad)" stroke="#9f1239" stroke-width="0.8"/>
                                        <circle cx="16" cy="8" r="1.2" fill="#fff" opacity="0.9"/>
                                        <circle cx="9" cy="6" r="1.1" fill="#fef08a" opacity="0.9"/>
                                        <circle cx="15" cy="25" r="1" fill="#fff" opacity="0.9"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- 2. Mariposa Aguamarina de Ensueño (Vuelo en cuadrante inferior derecho) -->
                            <div class="garden-creature butterfly-creature butterfly-azure-dream" 
                                 id="butterfly-azure-dream" 
                                 role="button" 
                                 tabindex="0" 
                                 data-creature="mariposa-celeste" 
                                 data-message="🦋 Mariposa Aguamarina: «Guiando tus pasos hacia nuevos horizontes felices»" 
                                 title="Mariposa Aguamarina · Toca para verla volar" 
                                 aria-label="Mariposa Aguamarina de Ensueño">
                                <div class="butterfly-wing-wrap">
                                    <svg class="butterfly-svg butterfly-wing-left" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M22,16 C20,5 12,0 2,1 C-1,9 5,20 22,16 Z" fill="url(#azureForewingGrad)" stroke="#0369a1" stroke-width="0.8"/>
                                        <path d="M22,16 C17,18 8,21 4,30 C11,32 18,26 22,16 Z" fill="url(#azureHindwingGrad)" stroke="#0369a1" stroke-width="0.8"/>
                                        <circle cx="8" cy="8" r="1.2" fill="#e0f2fe" opacity="0.95"/>
                                        <circle cx="15" cy="6" r="1.1" fill="#fff" opacity="0.95"/>
                                        <circle cx="9" cy="25" r="1" fill="#e0f2fe" opacity="0.95"/>
                                    </svg>
                                    <div class="butterfly-body-core"></div>
                                    <svg class="butterfly-svg butterfly-wing-right" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M2,16 C4,5 12,0 22,1 C25,9 19,20 2,16 Z" fill="url(#azureForewingGrad)" stroke="#0369a1" stroke-width="0.8"/>
                                        <path d="M2,16 C7,18 16,21 20,30 C13,32 6,26 2,16 Z" fill="url(#azureHindwingGrad)" stroke="#0369a1" stroke-width="0.8"/>
                                        <circle cx="16" cy="8" r="1.2" fill="#e0f2fe" opacity="0.95"/>
                                        <circle cx="9" cy="6" r="1.1" fill="#fff" opacity="0.95"/>
                                        <circle cx="15" cy="25" r="1" fill="#e0f2fe" opacity="0.95"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- 3. Mariposa Oro y Cristal (Revoloteando en cuadrante superior derecho) -->
                            <div class="garden-creature butterfly-creature butterfly-gold-spark" 
                                 id="butterfly-gold-spark" 
                                 role="button" 
                                 tabindex="0" 
                                 data-creature="mariposa-oro" 
                                 data-message="🦋 Mariposa Dorada: «Brillo, alegría y luz eterna para ti»" 
                                 title="Mariposa Dorada · Toca para verla volar" 
                                 aria-label="Mariposa Dorada de la Fortuna">
                                <div class="butterfly-wing-wrap">
                                    <svg class="butterfly-svg butterfly-wing-left" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M22,16 C20,5 12,0 2,1 C-1,9 5,20 22,16 Z" fill="url(#goldForewingGrad)" stroke="#92400e" stroke-width="0.8"/>
                                        <path d="M22,16 C17,18 8,21 4,30 C11,32 18,26 22,16 Z" fill="url(#goldHindwingGrad)" stroke="#92400e" stroke-width="0.8"/>
                                        <circle cx="8" cy="8" r="1.2" fill="#fff" opacity="0.95"/>
                                        <circle cx="15" cy="6" r="1.1" fill="#fff" opacity="0.95"/>
                                        <circle cx="9" cy="25" r="1" fill="#fff" opacity="0.95"/>
                                    </svg>
                                    <div class="butterfly-body-core"></div>
                                    <svg class="butterfly-svg butterfly-wing-right" viewBox="0 0 24 32" aria-hidden="true">
                                        <path d="M2,16 C4,5 12,0 22,1 C25,9 19,20 2,16 Z" fill="url(#goldForewingGrad)" stroke="#92400e" stroke-width="0.8"/>
                                        <path d="M2,16 C7,18 16,21 20,30 C13,32 6,26 2,16 Z" fill="url(#goldHindwingGrad)" stroke="#92400e" stroke-width="0.8"/>
                                        <circle cx="16" cy="8" r="1.2" fill="#fff" opacity="0.95"/>
                                        <circle cx="9" cy="6" r="1.1" fill="#fff" opacity="0.95"/>
                                        <circle cx="15" cy="25" r="1" fill="#fff" opacity="0.95"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- 4. Mariquita 2: Caminando por el sendero hacia Rincón de Paz -->
                            <div class="garden-creature ladybug-creature ladybug-vine-climber" 
                                 id="ladybug-vine-climber" 
                                 role="button" 
                                 tabindex="0" 
                                 data-creature="mariquita-sendero" 
                                 data-message="🐞 Mariquita Caminante: «Recorriendo con amor el sendero hacia tu Rincón de Paz»" 
                                 title="Mariquita del Sendero 🐞 · Toca para verla explorar" 
                                 aria-label="Mariquita Caminante hacia Rincón de Paz">
                                <svg class="ladybug-svg" viewBox="0 0 32 36" aria-hidden="true">
                                    <g stroke="#1e1b18" stroke-width="1.3" stroke-linecap="round" fill="none" class="ladybug-legs">
                                        <path d="M12,12 Q6,9 4,7"/>
                                        <path d="M11,18 Q4,18 2,20"/>
                                        <path d="M12,24 Q5,27 3,31"/>
                                        <path d="M20,12 Q26,9 28,7"/>
                                        <path d="M21,18 Q28,18 30,20"/>
                                        <path d="M20,24 Q27,27 29,31"/>
                                    </g>
                                    <g stroke="#1c1917" stroke-width="1.2" stroke-linecap="round" fill="none" class="ladybug-antennae">
                                        <path d="M14,6 Q11,2 8,2"/>
                                        <path d="M18,6 Q21,2 24,2"/>
                                        <circle cx="8" cy="2" r="1" fill="#1c1917"/>
                                        <circle cx="24" cy="2" r="1" fill="#1c1917"/>
                                    </g>
                                    <ellipse cx="16" cy="8" rx="5.5" ry="4" fill="#1c1917"/>
                                    <circle cx="13" cy="7" r="1" fill="#fff"/>
                                    <circle cx="19" cy="7" r="1" fill="#fff"/>
                                    <circle cx="13.3" cy="7" r="0.5" fill="#000"/>
                                    <circle cx="18.7" cy="7" r="0.5" fill="#000"/>
                                    <ellipse cx="16" cy="20" rx="11" ry="12.5" fill="url(#ladybugShellGrad)" filter="drop-shadow(0 2px 5px rgba(0,0,0,0.25))"/>
                                    <line x1="16" y1="8" x2="16" y2="32.5" stroke="#1c1917" stroke-width="1.2"/>
                                    <circle cx="12" cy="14" r="2.1" fill="#1c1917"/>
                                    <circle cx="20" cy="14" r="2.1" fill="#1c1917"/>
                                    <circle cx="10" cy="21" r="2" fill="#1c1917"/>
                                    <circle cx="22" cy="21" r="2" fill="#1c1917"/>
                                    <circle cx="12.5" cy="27" r="1.8" fill="#1c1917"/>
                                    <circle cx="19.5" cy="27" r="1.8" fill="#1c1917"/>
                                    <circle cx="16" cy="17" r="1.6" fill="#1c1917"/>
                                    <ellipse cx="12.5" cy="15" rx="5" ry="3.5" fill="url(#ladybugShine)"/>
                                </svg>
                            </div>

                            <!-- 5. Mariquita 3: Descansando en el Santuario de Flores -->
                            <div class="garden-creature ladybug-creature ladybug-blossom-rest" 
                                 id="ladybug-blossom-rest" 
                                 role="button" 
                                 tabindex="0" 
                                 data-creature="mariquita-santuario" 
                                 data-message="🐞 Mariquita del Santuario: «Paz, serenidad y dicha para tu corazón»" 
                                 title="Mariquita del Santuario 🐞 · Toca para recibir su calma" 
                                 aria-label="Mariquita del Santuario de Flores">
                                <svg class="ladybug-svg" viewBox="0 0 32 36" aria-hidden="true">
                                    <g stroke="#1e1b18" stroke-width="1.3" stroke-linecap="round" fill="none" class="ladybug-legs">
                                        <path d="M12,12 Q6,9 4,7"/>
                                        <path d="M11,18 Q4,18 2,20"/>
                                        <path d="M12,24 Q5,27 3,31"/>
                                        <path d="M20,12 Q26,9 28,7"/>
                                        <path d="M21,18 Q28,18 30,20"/>
                                        <path d="M20,24 Q27,27 29,31"/>
                                    </g>
                                    <g stroke="#1c1917" stroke-width="1.2" stroke-linecap="round" fill="none" class="ladybug-antennae">
                                        <path d="M14,6 Q11,2 8,2"/>
                                        <path d="M18,6 Q21,2 24,2"/>
                                        <circle cx="8" cy="2" r="1" fill="#1c1917"/>
                                        <circle cx="24" cy="2" r="1" fill="#1c1917"/>
                                    </g>
                                    <ellipse cx="16" cy="8" rx="5.5" ry="4" fill="#1c1917"/>
                                    <circle cx="13" cy="7" r="1" fill="#fff"/>
                                    <circle cx="19" cy="7" r="1" fill="#fff"/>
                                    <circle cx="13.3" cy="7" r="0.5" fill="#000"/>
                                    <circle cx="18.7" cy="7" r="0.5" fill="#000"/>
                                    <ellipse cx="16" cy="20" rx="11" ry="12.5" fill="url(#ladybugShellGrad)" filter="drop-shadow(0 2px 5px rgba(0,0,0,0.25))"/>
                                    <line x1="16" y1="8" x2="16" y2="32.5" stroke="#1c1917" stroke-width="1.2"/>
                                    <circle cx="12" cy="14" r="2.1" fill="#1c1917"/>
                                    <circle cx="20" cy="14" r="2.1" fill="#1c1917"/>
                                    <circle cx="10" cy="21" r="2" fill="#1c1917"/>
                                    <circle cx="22" cy="21" r="2" fill="#1c1917"/>
                                    <circle cx="12.5" cy="27" r="1.8" fill="#1c1917"/>
                                    <circle cx="19.5" cy="27" r="1.8" fill="#1c1917"/>
                                    <circle cx="16" cy="17" r="1.6" fill="#1c1917"/>
                                    <ellipse cx="12.5" cy="15" rx="5" ry="3.5" fill="url(#ladybugShine)"/>
                                </svg>
                            </div>

                            <!-- Toast / Mensaje poético flotante al interactuar con la fauna -->
                            <div class="fauna-toast-bubble" id="fauna-toast-bubble" aria-live="polite"></div>
                        </div>


                        <!-- ═══════════════════════════════════════════════════════════ -->
                        <!--  LOS 11 MEDALLONES BOTÁNICOS DEL JARDÍN DE CARLA LORENA     -->
                        <!-- ═══════════════════════════════════════════════════════════ -->

                        <!-- 1. Galería: Rosa de Atelier -->
                        <a class="map-place place-gallery floral-island luxury-medallion living-flower-node prism-gem-node gem-rose-quartz" 
                           href="#galeria" 
                           data-go="galeria" 
                           data-biome="rose-quartz"
                           data-flower="Rosa de Atelier"
                           data-note="523.25"
                           data-tooltip="Rosa de Atelier: Recuerdos e instantes mágicos que florecen en el tiempo"
                           aria-label="Abrir Galería de recuerdos">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌹</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Galería</strong>
                            <span class="flower-biome-tag prism-tag">Rosa de Atelier</span>
                            <small class="flower-essence-text">instantes mágicos</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 2. Cápsula: Tulipán Eterno -->
                        <a class="map-place place-capsule floral-island luxury-medallion living-flower-node prism-gem-node gem-amethyst" 
                           href="#capsula" 
                           data-go="capsula" 
                           data-biome="amethyst"
                           data-flower="Tulipán Eterno"
                           data-note="587.33"
                           data-tooltip="Tulipán Eterno: Cartas selladas con amor para florecer en el futuro"
                           aria-label="Abrir Cápsula del tiempo">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌷</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Cápsula</strong>
                            <span class="flower-biome-tag prism-tag">Tulipán Eterno</span>
                            <small class="flower-essence-text">cartas del futuro</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 3. Rincón de Paz: Loto de Cristal -->
                        <a class="map-place place-library floral-island luxury-medallion living-flower-node prism-gem-node gem-sapphire" 
                           href="#biblioteca" 
                           data-go="biblioteca" 
                           data-biome="sapphire"
                           data-flower="Loto de Cristal"
                           data-note="659.25"
                           data-tooltip="Loto de Cristal: Frases célebres diarias, poemas y sabiduría para el alma"
                           aria-label="Abrir Rincón de Paz">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🪷</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Rincón de Paz</strong>
                            <span class="flower-biome-tag prism-tag">Loto de Cristal</span>
                            <small class="flower-essence-text">lectura & sabiduría</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 4. Amigos: Ramo de Peonías -->
                        <a class="map-place place-amigos floral-island luxury-medallion living-flower-node prism-gem-node gem-topaz medallion-friends-pulse" 
                           href="#amigos" 
                           data-go="amigos" 
                           data-biome="topaz"
                           data-flower="Peonía Coral"
                           data-note="698.46"
                           data-tooltip="Peonía Coral: Dedicatorias sinceras de las personas que más te quieren"
                           aria-label="Abrir Dedicatorias de amigos">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">💐</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Amigos</strong>
                            <span class="flower-biome-tag prism-tag">Peonía Coral</span>
                            <small class="flower-essence-text">dedicatorias sinceras</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 5. Dedicatoria: Rosaleda Imperial -->
                        <a class="map-place place-dedicatoria floral-island luxury-medallion living-flower-node prism-gem-node gem-ruby medallion-gold-pulse" 
                           href="#dedicatoria" 
                           data-go="dedicatoria" 
                           data-biome="ruby"
                           data-flower="Rosaleda Imperial"
                           data-note="783.99"
                           data-tooltip="Rosaleda Imperial: Cartas y promesas de cariño eterno escritas para ti"
                           aria-label="Abrir Dedicatoria de amor">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">💌</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Dedicatoria</strong>
                            <span class="flower-biome-tag prism-tag">Rosa Imperial</span>
                            <small class="flower-essence-text">mi espacio para ti</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 6. Santuario: Flor de Cerezo -->
                        <a class="map-place place-garden floral-island luxury-medallion living-flower-node prism-gem-node gem-emerald" 
                           href="#jardin" 
                           data-go="jardin" 
                           data-biome="emerald"
                           data-flower="Cerezo en Flor"
                           data-note="880.00"
                           data-tooltip="Cerezo en Flor: El santuario botánico de calma y serenidad dedicado a ti"
                           aria-label="Abrir Santuario">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌸</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Santuario</strong>
                            <span class="flower-biome-tag prism-tag">Cerezo en Flor</span>
                            <small class="flower-essence-text">calma & pureza</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 7. Melodías: Hibisco Armónico -->
                        <a class="map-place place-entertainment floral-island luxury-medallion living-flower-node prism-gem-node gem-tanzanite" 
                           href="#entretenimiento" 
                           data-go="entretenimiento" 
                           data-biome="tanzanite"
                           data-flower="Orquídea Sonora"
                           data-note="987.77"
                           data-tooltip="Orquídea Sonora: Tus canciones, melodías y videos favoritos en el jardín"
                           aria-label="Abrir Melodías">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌺</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Melodías</strong>
                            <span class="flower-biome-tag prism-tag">Orquídea Sonora</span>
                            <small class="flower-essence-text">rincón privado</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 8. Juegos: Girasol Dorado -->
                        <a class="map-place place-games floral-island luxury-medallion living-flower-node prism-gem-node gem-amber" 
                           href="#juegos" 
                           data-go="juegos" 
                           data-biome="amber"
                           data-flower="Girasol Dorado"
                           data-note="1046.50"
                           data-tooltip="Girasol Dorado: Experiencias y juegos de jardín creados para hacerte sonreír"
                           aria-label="Abrir Juegos">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌻</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Juegos</strong>
                            <span class="flower-biome-tag prism-tag">Girasol Dorado</span>
                            <small class="flower-essence-text">momentos alegres</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 9. Destinos: Mariposa & Magnolia -->
                        <a class="map-place place-dreams floral-island luxury-medallion living-flower-node prism-gem-node gem-aquamarine" 
                           href="#destinos" 
                           data-go="destinos" 
                           data-biome="aquamarine"
                           data-flower="Magnolia en Vuelo"
                           data-note="1174.66"
                           data-tooltip="Magnolia en Vuelo: Lugares soñados, metas y horizontes por descubrir"
                           aria-label="Abrir Destinos">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🦋</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Destinos</strong>
                            <span class="flower-biome-tag prism-tag">Magnolia Celeste</span>
                            <small class="flower-essence-text">sueños futuros</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 10. El Blog: Rama Botánica -->
                        <a class="map-place place-blog floral-island luxury-medallion living-flower-node prism-gem-node gem-lapis" 
                           href="#blog" 
                           data-go="blog" 
                           data-biome="lapis"
                           data-flower="Hortensia Lírica"
                           data-note="1318.51"
                           data-tooltip="Hortensia Lírica: Notas personales, crónicas y destellos de inspiración"
                           aria-label="Abrir El Blog">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🌿</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">El Blog</strong>
                            <span class="flower-biome-tag prism-tag">Hortensia Lírica</span>
                            <small class="flower-essence-text">inspiración</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 11. Historias: Roseta de Ensueño -->
                        <a class="map-place place-stories floral-island luxury-medallion living-flower-node prism-gem-node gem-mystic" 
                           href="#historias" 
                           data-go="historias" 
                           data-biome="mystic"
                           data-flower="Jazmín de Ensueño"
                           data-note="1396.91"
                           data-tooltip="Jazmín de Ensueño: Relatos interactivos donde tú eliges cada sendero"
                           aria-label="Abrir Historias">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">🏵️</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Historias</strong>
                            <span class="flower-biome-tag prism-tag">Jazmín Dorado</span>
                            <small class="flower-essence-text">aventura & magia</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- 12. Mi Familia: Zafiro Familiar Imperial (Exclusivo Admin) -->
                        <a class="map-place place-family floral-island luxury-medallion living-flower-node prism-gem-node gem-royal-sapphire medallion-family-vault" 
                           href="#familia" 
                           data-go="familia" 
                           data-family-vault-node="1"
                           data-biome="sapphire"
                           data-flower="Zafiro Familiar"
                           data-note="1567.98"
                           data-tooltip="Zafiro Familiar (Acceso Privado Admin): Álbum de Carla Lorena, Adrián, nuestra mascota Ody y nuestros hijos"
                           aria-label="Abrir Mi Familia (Acceso Privado de Administrador)">
                            <span class="flower-petal-aura prism-caustic-aura"></span>
                            <div class="flower-icon-wrap prism-facet-wrap">
                                <span class="place-symbol">💎</span>
                                <span class="flower-dew-drop prism-sheen-line"></span>
                            </div>
                            <strong class="flower-node-title">Mi Familia</strong>
                            <span class="flower-biome-tag prism-tag">🔒 Zafiro Familiar</span>
                            <small class="flower-essence-text">Familia & Hogar</small>
                            <span class="flower-accent-vine prism-bevel-edge"></span>
                        </a>

                        <!-- ═══════════════════════════════════════════════════════════ -->
                        <!--  NÚCLEO CENTRAL: MEDALLÓN IMPERIAL DE LA GRAN ROSA DE CARLA -->
                        <!-- ═══════════════════════════════════════════════════════════ -->
                        <div class="map-center heart-center luxury-heart-emblem living-grand-rose-core prism-master-core" 
                             id="map-center-rose-trigger"
                             role="button" 
                             tabindex="0" 
                             aria-label="La Gran Rosa Imperial de Carla Lorena: Toca para desplegar una cascada de pétalos y luz" 
                             title="Toca para desplegar la Floración Radiante de Carla Lorena">

                            <!-- Único Medallón Floral de la Gran Rosa Imperial (Sin doble fondo ni diamante) -->
                            <svg class="grand-rose-imperial-svg" viewBox="0 0 140 140" aria-hidden="true">
                                <defs>
                                    <radialGradient id="imperialOuterRim" cx="50%" cy="38%" r="62%">
                                        <stop offset="0%" stop-color="#fffdf9"/>
                                        <stop offset="60%" stop-color="#fff0f4"/>
                                        <stop offset="100%" stop-color="#fbd5e0"/>
                                    </radialGradient>
                                    <linearGradient id="imperialGoldRing" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fef08a"/>
                                        <stop offset="50%" stop-color="#d4af37"/>
                                        <stop offset="100%" stop-color="#9a6b32"/>
                                    </linearGradient>
                                    <radialGradient id="imperialRosePetalOuter" cx="50%" cy="30%" r="70%">
                                        <stop offset="0%" stop-color="#fb7185"/>
                                        <stop offset="65%" stop-color="#e11d48"/>
                                        <stop offset="100%" stop-color="#881337"/>
                                    </radialGradient>
                                    <radialGradient id="imperialRosePetalInner" cx="45%" cy="35%" r="65%">
                                        <stop offset="0%" stop-color="#ffe4e6"/>
                                        <stop offset="50%" stop-color="#f43f5e"/>
                                        <stop offset="100%" stop-color="#9f1239"/>
                                    </radialGradient>
                                </defs>

                                <!-- Único disco imperial perlado con doble bisel de oro rosa -->
                                <circle cx="70" cy="70" r="64" fill="url(#imperialOuterRim)" stroke="url(#imperialGoldRing)" stroke-width="3"/>
                                <circle cx="70" cy="70" r="57" fill="none" stroke="rgba(201, 59, 97, 0.26)" stroke-width="1.2" stroke-dasharray="3,3"/>

                                <!-- Corona de 8 pétalos exteriores de seda carmesí -->
                                <g class="imperial-petals-ring" transform="translate(70, 58)">
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(45)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(90)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(135)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(180)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(225)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(270)"/>
                                    <path d="M0,-33 C10,-26 14,-12 0,-4 C-14,-12 -10,-26 0,-33 Z" fill="url(#imperialRosePetalOuter)" opacity="0.94" transform="rotate(315)"/>

                                    <!-- Pétalos intermedios aterciopelados -->
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(22.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(67.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(112.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(157.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(202.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(247.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(292.5)"/>
                                    <path d="M0,-24 C8,-18 11,-8 0,-2 C-11,-8 -8,-18 0,-24 Z" fill="url(#imperialRosePetalInner)" transform="rotate(337.5)"/>

                                    <!-- Corazón espiral de la rosa y perla central dorada -->
                                    <circle cx="0" cy="0" r="11" fill="#881337" stroke="#fde68a" stroke-width="1.3"/>
                                    <path d="M-5,-2 C-2,-7 5,-6 6,0 C6,5 0,7 -4,4 C-7,1 -3,-3 1,-2" fill="none" stroke="#ffe4e6" stroke-width="1.6" stroke-linecap="round"/>
                                    <circle cx="0" cy="0" r="2.8" fill="#fef08a"/>
                                </g>
                            </svg>

                            <!-- Cartela Imperial Inferior con Mariquita de la Buena Suerte -->
                            <div class="imperial-rose-nameplate">
                                <span class="imperial-spark">✦</span>
                                <span class="imperial-name">CARLA</span>
                                <span class="imperial-spark">✦</span>

                                <!-- Mariquita 1: En la Gran Rosa (Broche de la Buena Suerte de Carla) -->
                                <div class="ladybug-creature ladybug-on-rose" 
                                     id="ladybug-carla-rose" 
                                     role="button" 
                                     tabindex="0" 
                                     data-creature="mariquita-rosa" 
                                     data-message="🐞 Mariquita de la Suerte: «7 bendiciones de dicha y amor infinito para Carla»" 
                                     title="Mariquita de la Suerte 🐞 · Toca para recibir bendiciones" 
                                     aria-label="Mariquita de la Suerte de Carla">
                                    <svg class="ladybug-svg" viewBox="0 0 32 36" aria-hidden="true">
                                        <g stroke="#1e1b18" stroke-width="1.3" stroke-linecap="round" fill="none" class="ladybug-legs">
                                            <path d="M12,12 Q6,9 4,7"/>
                                            <path d="M11,18 Q4,18 2,20"/>
                                            <path d="M12,24 Q5,27 3,31"/>
                                            <path d="M20,12 Q26,9 28,7"/>
                                            <path d="M21,18 Q28,18 30,20"/>
                                            <path d="M20,24 Q27,27 29,31"/>
                                        </g>
                                        <g stroke="#1c1917" stroke-width="1.2" stroke-linecap="round" fill="none" class="ladybug-antennae">
                                            <path d="M14,6 Q11,2 8,2"/>
                                            <path d="M18,6 Q21,2 24,2"/>
                                            <circle cx="8" cy="2" r="1" fill="#1c1917"/>
                                            <circle cx="24" cy="2" r="1" fill="#1c1917"/>
                                        </g>
                                        <ellipse cx="16" cy="8" rx="5.5" ry="4" fill="#1c1917"/>
                                        <circle cx="13" cy="7" r="1" fill="#fff"/>
                                        <circle cx="19" cy="7" r="1" fill="#fff"/>
                                        <circle cx="13.3" cy="7" r="0.5" fill="#000"/>
                                        <circle cx="18.7" cy="7" r="0.5" fill="#000"/>
                                        <ellipse cx="16" cy="20" rx="11" ry="12.5" fill="url(#ladybugShellGrad)" filter="drop-shadow(0 2px 5px rgba(0,0,0,0.25))"/>
                                        <line x1="16" y1="8" x2="16" y2="32.5" stroke="#1c1917" stroke-width="1.2"/>
                                        <circle cx="12" cy="14" r="2.1" fill="#1c1917"/>
                                        <circle cx="20" cy="14" r="2.1" fill="#1c1917"/>
                                        <circle cx="10" cy="21" r="2" fill="#1c1917"/>
                                        <circle cx="22" cy="21" r="2" fill="#1c1917"/>
                                        <circle cx="12.5" cy="27" r="1.8" fill="#1c1917"/>
                                        <circle cx="19.5" cy="27" r="1.8" fill="#1c1917"/>
                                        <circle cx="16" cy="17" r="1.6" fill="#1c1917"/>
                                        <ellipse cx="12.5" cy="15" rx="5" ry="3.5" fill="url(#ladybugShine)"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Destellos botánicos mágicos -->
                        <span class="map-sparkle sparkle-one" aria-hidden="true">✦</span>
                        <span class="map-sparkle sparkle-two" aria-hidden="true">✿</span>
                        <span class="map-sparkle sparkle-three" aria-hidden="true">✨</span>
                        <span class="map-sparkle sparkle-four" aria-hidden="true">🌸</span>
                    </div>

                    <!-- Pod de Inspección Botánica Flotante (Anti-Colisión Inteligente) -->
                    <aside class="floral-inspect-pod prism-inspect-pod" id="floral-inspect-pod" aria-live="polite" hidden>
                        <div class="pod-inner-glass">
                            <span class="pod-flower-emblem" id="pod-flower-emblem">🌹</span>
                            <div class="pod-body">
                                <div class="pod-header-row">
                                    <h4 class="pod-title" id="pod-title">Galería</h4>
                                    <span class="pod-biome-badge" id="pod-biome-badge">Rosa de Atelier</span>
                                </div>
                                <p class="pod-quote" id="pod-quote">«Instantes mágicos que perduran en el tiempo»</p>
                                <span class="pod-hint">Toca para entrar al rincón →</span>
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="map-footer">
                    <span class="footer-species-counter"><i></i> 12 rincones botánicos en armonía perfecta</span>
                    <span class="map-hint-text">Desliza el cursor sobre las flores para iluminar sus enredaderas · Toca cada rincón para abrirlo</span>
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
                        <button class="wish-bud-card" type="button" data-wish="1" aria-label="Abrir deseo 1: Tu Alegría">
                            <div class="bud-icon-wrap">
                                <span class="bud-icon">🌸</span>
                            </div>
                            <span class="bud-tag">Capullo de Luz</span>
                            <h4>Tu Alegría</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Que nunca se apague esa luz tan bonita y contagiosa que tienes. El mundo es más amable y cálido desde que estás en él.»</p>
                                <small>Con admiración sincera</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="2" aria-label="Abrir deseo 2: Tu Fortaleza">
                            <div class="bud-icon-wrap">
                                <span class="bud-icon">🌹</span>
                            </div>
                            <span class="bud-tag">Capullo de Rosa</span>
                            <h4>Tu Fortaleza</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Incluso en los días difíciles, recuerda la inmensa gracia y valentía con la que caminas. Siempre serás inspiración.»</p>
                                <small>Un abrazo al alma</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="3" aria-label="Abrir deseo 3: Momentos Bonitos">
                            <div class="bud-icon-wrap">
                                <span class="bud-icon">🌼</span>
                            </div>
                            <span class="bud-tag">Capullo de Jazmín</span>
                            <h4>Momentos Bonitos</h4>
                            <p class="bud-folded-hint">Toca para abrir ✦</p>
                            <div class="bud-unfolded-msg" hidden>
                                <p>«Deseo que los días que vienen te regalen instantes de paz infinita, risas espontáneas y flores en cada esquina del camino.»</p>
                                <small>Promesa del jardín</small>
                            </div>
                        </button>

                        <button class="wish-bud-card" type="button" data-wish="4" aria-label="Abrir deseo 4: Nuestros Horizontes">
                            <div class="bud-icon-wrap">
                                <span class="bud-icon">🌟</span>
                            </div>
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
                                <div class="promenade-icon-emblem-cluster">
                                    <span class="promenade-icon-flank">🌿</span>
                                    <span class="promenade-icon-center">☕</span>
                                    <span class="promenade-icon-flank">🌸</span>
                                </div>
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
                                <div class="promenade-icon-emblem-cluster">
                                    <span class="promenade-icon-flank">✨</span>
                                    <span class="promenade-icon-center">🌙</span>
                                    <span class="promenade-icon-flank">🌹</span>
                                </div>
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
                                <div class="promenade-icon-emblem-cluster">
                                    <span class="promenade-icon-flank">🎶</span>
                                    <span class="promenade-icon-center">🌺</span>
                                    <span class="promenade-icon-flank">🕊️</span>
                                </div>
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

                <!-- Atajos y Rincones Especiales del Jardín -->
                <div class="map-shortcuts-section">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">RINCONES ÍNTIMOS Y ACTIVIDADES</p>
                            <h2>Senderos especiales de Carla Lorena</h2>
                        </div>
                        <span class="letters-subtitle">Acceso directo a tus espacios favoritos</span>
                    </div>

                    <div class="space-grid map-shortcuts botanical-shortcuts-grid">
                        <!-- 1. Música & Entretenimiento -->
                        <a class="space-card space-card-entertainment luxury-card" href="#entretenimiento" data-go="entretenimiento">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">🎵</span>
                                    <span class="emblem-botanical">🌺</span>
                                </div>
                                <span class="card-number">MÚSICA · VIDEOS</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Música & Entretenimiento</h3>
                                <p>Tus melodías más queridas y momentos multimedia guardados con ternura.</p>
                                <span class="card-mini-quote">«Donde la música abraza el silencio»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>

                        <!-- 2. Búsqueda del tesoro -->
                        <a class="space-card space-card-treasure luxury-card" href="#tesoro" data-go="tesoro">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">🗝️</span>
                                    <span class="emblem-botanical">✨</span>
                                </div>
                                <span class="card-number">PISTAS · MISTERIO</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Búsqueda del Tesoro</h3>
                                <p>Una pequeña pista entre las hojas puede llevarte a un secreto dulce.</p>
                                <span class="card-mini-quote">«Un hallazgo esperando por tu sonrisa»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>

                        <!-- 3. Mi diario íntimo -->
                        <a class="space-card space-card-reading luxury-card" href="#diario" data-go="diario">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">📖</span>
                                    <span class="emblem-botanical">🌿</span>
                                </div>
                                <span class="card-number">ÍNTIMO · REFLEXIÓN</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Mi Diario Íntimo</h3>
                                <p>Un cuaderno de pensamientos personales, protegido y solo para ti.</p>
                                <span class="card-mini-quote">«Páginas guardadas en el corazón»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>

                        <!-- 4. Conociendo a Carla -->
                        <a class="space-card space-card-personal luxury-card" href="#conociendo-carla" data-go="conociendo-carla">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">💎</span>
                                    <span class="emblem-botanical">🌸</span>
                                </div>
                                <span class="card-number">TRIVIA · CARIÑO</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Conociendo a Carla</h3>
                                <p>Diez preguntas para celebrar lo que te hace única, brillante y especial.</p>
                                <span class="card-mini-quote">«Cada respuesta es una joya tuya»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>

                        <!-- 5. Álbumes -->
                        <a class="space-card space-card-personal luxury-card" href="#albumes" data-go="albumes">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">📸</span>
                                    <span class="emblem-botanical">🌷</span>
                                </div>
                                <span class="card-number">FOTOS · RECUERDOS</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Álbum de Recuerdos</h3>
                                <p>Tu rincón fotográfico para atesorar colecciones de momentos bonitos.</p>
                                <span class="card-mini-quote">«Instantes que perduran siempre»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>

                        <!-- 6. Juegos del jardín -->
                        <a class="space-card space-card-dreams luxury-card" href="#juegos" data-go="juegos">
                            <div class="card-top-bar">
                                <div class="card-icon-emblem">
                                    <span class="emblem-glyph">🌻</span>
                                    <span class="emblem-botanical">🎮</span>
                                </div>
                                <span class="card-number">JUEGOS · ALEGRÍA</span>
                            </div>
                            <div class="space-card-body">
                                <h3>Juegos del Jardín</h3>
                                <p>Experiencias interactivas y dinámicas creadas para hacerte sonreír.</p>
                                <span class="card-mini-quote">«Momentos de alegría y complicidad»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </div>
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════════ -->
        <!--  PANTALLA: DEDICATORIAS DE AMIGOS (VOCES DEL CORAZÓN)               -->
        <!-- ═══════════════════════════════════════════════════════════════════ -->