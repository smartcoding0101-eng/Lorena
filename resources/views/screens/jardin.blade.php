        <section class="screen" data-screen="jardin" aria-labelledby="garden-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">
                    <span class="back-link-icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </span>
                    <span>Volver al Atelier</span>
                </a>

                <div class="page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge">SANTUARIO VIVO</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge">PILAR I · MI UNIVERSO</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge">12 ESPECÍMENES &amp; CARTAS DE ADRIÁN</span>
                        </div>
                        <p class="eyebrow">MI UNIVERSO · SANTUARIO BOTÁNICO PERSONAL &amp; PALABRAS DEL CORAZÓN</p>
                        <h1 id="garden-title">El Jardín de <em>Carla Lorena</em></h1>
                        <p>Un santuario vivo donde cada flor custodia una promesa de Adrián, florece a tu tacto con rocío de luz y guarda una biblioteca eterna de palabras expresadas para ti.</p>
                    </div>
                </div>

                <!-- Hero Botánico + Contador Global de Floraciones -->
                <div class="botanical-hero-card luxury-card garden-sanctuary-hero">
                    <div class="botanical-hero-content">
                        <span class="eyebrow">AROMA A FLORES SILVESTRES, ROCÍO MATINAL &amp; AMOR ETERNO</span>
                        <h2>Un rincón para soñar despierta, mi amada Carla Lorena</h2>
                        <p>Diseñado con delicadeza noble, música armónica y 12 especímenes imperiales que despiertan cuando los tocas. Riega cada flor con rocío de luz, despliega su ficha secreta o explora la biblioteca de palabras que Adrián ha escrito para ti.</p>
                        <div class="botanical-hero-tags">
                            <span class="flower-pill">🌹 12 Flores Interactivas</span>
                            <span class="flower-pill">💌 Cartas de Adrián</span>
                            <span class="flower-pill">📚 Biblioteca de Palabras</span>
                            <span class="flower-pill">🦋 Luciérnagas &amp; Mariposas</span>
                        </div>
                    </div>
                    <div class="garden-hero-stats-box">
                        <div class="garden-stat-orb">
                            <span class="garden-stat-number" id="garden-total-blooms-count">12</span>
                            <span class="garden-stat-label">Rocíos de Luz dados hoy</span>
                        </div>
                        <div class="garden-stat-mini-row">
                            <span>✨ 12 Especímenes Reales</span>
                            <span>•</span>
                            <span id="garden-library-total-badge">18 Palabras de Adrián</span>
                        </div>
                    </div>
                </div>

                <!-- Medallón de Amigos (Existente) -->
                <div class="garden-friends-medallion-banner luxury-card">
                    <div class="friends-medallion-badge">
                        <span class="friends-badge-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <span class="friends-badge-ring"></span>
                    </div>
                    <div class="friends-medallion-info">
                        <span class="eyebrow">EL MEDALLÓN DE AMIGOS · VOCES DEL CORAZÓN</span>
                        <h3>Dedicatorias de Amigos</h3>
                        <p>Un espacio donde quienes te quieren dejan plasmado todo lo que piensan de ti, con cariño sincero y buenos deseos.</p>
                    </div>
                    <a href="#amigos" data-go="amigos" class="button button-primary friends-medallion-cta">
                        <span>Ver y dedicar mensajes</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                </div>

                <!-- NUEVO: Altar Interactivo «Susurros de Adrián para Carla Lorena» -->
                <div class="adrian-whisper-sanctuary luxury-card" id="adrian-whisper-sanctuary">
                    <div class="adrian-whisper-aura" aria-hidden="true"></div>
                    <div class="adrian-whisper-header">
                        <div class="adrian-whisper-badge-wrap">
                            <span class="adrian-heart-seal" aria-hidden="true">💌</span>
                            <div>
                                <span class="eyebrow">LATIDOS EN VIVO · DE ADRIÁN PARA MI PRINCESA CARLA LORENA</span>
                                <h2>Cofre de Susurros &amp; Promesas de Adrián</h2>
                            </div>
                        </div>
                        <div class="adrian-whisper-actions">
                            <button type="button" class="button button-outline button-sm" id="btn-adrian-whisper-copy" title="Copiar este mensaje de Adrián">
                                <span>📋 Copiar</span>
                            </button>
                            <button type="button" class="button button-primary button-sm" id="btn-adrian-whisper-next">
                                <span>✨ Escuchar otro latido de Adrián</span>
                            </button>
                        </div>
                    </div>

                    <div class="adrian-whisper-stage" id="adrian-whisper-stage">
                        <div class="adrian-whisper-meta">
                            <span class="adrian-whisper-category" id="adrian-whisper-category">Amor Eterno · Carta I</span>
                            <span class="adrian-whisper-flower-tag" id="adrian-whisper-flower-tag">🌹 Custodiado por la Rosa Damascena</span>
                        </div>
                        <blockquote class="adrian-whisper-quote" id="adrian-whisper-quote">
                            «Mi amada Carla Lorena, si pudiera sembrar una flor por cada vez que tu sonrisa ilumina mi alma, caminaríamos por un jardín infinito donde nunca existiría el invierno.»
                        </blockquote>
                        <div class="adrian-whisper-footer">
                            <cite id="adrian-whisper-signature">— Con todo mi amor, Adrián ♥</cite>
                            <div class="adrian-whisper-QuickNav">
                                <button type="button" class="whisper-dot-btn is-active" data-whisper-idx="0" aria-label="Susurro 1"></button>
                                <button type="button" class="whisper-dot-btn" data-whisper-idx="1" aria-label="Susurro 2"></button>
                                <button type="button" class="whisper-dot-btn" data-whisper-idx="2" aria-label="Susurro 3"></button>
                                <button type="button" class="whisper-dot-btn" data-whisper-idx="3" aria-label="Susurro 4"></button>
                                <button type="button" class="whisper-dot-btn" data-whisper-idx="4" aria-label="Susurro 5"></button>
                                <button type="button" class="whisper-dot-btn" data-whisper-idx="5" aria-label="Susurro 6"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de Clima / Hora del Santuario y Efectos Sensoriales -->
                <div class="garden-interactive-ambient garden-atmosphere-master-bar">
                    <div class="ambient-controls-bar">
                        <span class="ambient-label">🌅 Clima &amp; Luz del Santuario:</span>
                        <div class="sanctuary-time-pills" role="group" aria-label="Clima y hora del jardín">
                            <button type="button" class="sanctuary-time-btn is-active" data-sanctuary-time-btn="spring">
                                <span>☀️ Sol de Primavera</span>
                            </button>
                            <button type="button" class="sanctuary-time-btn" data-sanctuary-time-btn="dawn">
                                <span>🌸 Amanecer Rosado</span>
                            </button>
                            <button type="button" class="sanctuary-time-btn" data-sanctuary-time-btn="sunset">
                                <span>🌅 Atardecer Dorado</span>
                            </button>
                            <button type="button" class="sanctuary-time-btn" data-sanctuary-time-btn="night">
                                <span>🌙 Noche de Luciérnagas</span>
                            </button>
                        </div>
                    </div>

                    <div class="ambient-controls-bar">
                        <span class="ambient-label">🍃 Efectos Sensoriales:</span>
                        <button class="button button-outline button-sm atelier-btn-subtle" type="button" data-garden-ambient="breeze" aria-pressed="false">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"></path>
                            </svg>
                            <span>Brisa Serena</span>
                        </button>
                        <button class="button button-outline button-sm atelier-btn-subtle" type="button" data-garden-ambient="birds" aria-pressed="false">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span>Canto de Aves</span>
                        </button>
                        <button class="button button-outline button-sm atelier-btn-subtle" type="button" data-garden-ambient="petals" aria-pressed="true">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 2a4 4 0 0 0-4 4v1a4 4 0 0 0 8 0V6a4 4 0 0 0-4-4z"></path>
                                <path d="M22 12a4 4 0 0 0-4-4h-1a4 4 0 0 0 0 8h1a4 4 0 0 0 4-4z"></path>
                            </svg>
                            <span>Lluvia de Pétalos</span>
                        </button>
                        <button class="button button-outline button-sm atelier-btn-subtle" type="button" data-garden-ambient="fireflies" id="btn-toggle-fireflies" aria-pressed="true">
                            <span>🦋 Luciérnagas &amp; Mariposas</span>
                        </button>
                        <button class="button button-primary button-sm" type="button" id="btn-garden-bloom-all">
                            <span>💧 Regar Todo el Jardín</span>
                        </button>
                    </div>
                </div>

                <!-- Jardín Virtual Real: Escenario Botánico Interactivo Expandido (12 Flores) -->
                <div class="virtual-garden-stage" id="virtual-garden-stage" data-sanctuary-time="spring">
                    <div class="garden-stage-header">
                        <div class="garden-stage-title">
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge">PARTERRE VIVO · 12 ESPECÍMENES DE LUJO</span>
                            </div>
                            <span class="eyebrow">COLECCIÓN FLORAL PRIVADA &amp; DEDICATORIAS DE ADRIÁN</span>
                            <h2>Jardín Botánico Real de Carla Lorena</h2>
                            <p>Cada tarjeta es un ecosistema vivo: toca <strong>«💧 Rocío de Luz»</strong> para hacer florecer la planta con notas de arpa, despliega su <strong>«Ficha &amp; Palabra de Adrián»</strong> directamente en la tarjeta o abre su pergamino completo.</p>
                        </div>

                        <!-- Filtros Interactivos por Emoción Floral -->
                        <div class="garden-species-filter-bar" id="garden-species-filter-bar" role="tablist" aria-label="Filtrar flores por emoción">
                            <button type="button" class="garden-species-pill is-active" data-flower-filter="all">✨ Todas las Flores (12)</button>
                            <button type="button" class="garden-species-pill" data-flower-filter="amor">🌹 Amor &amp; Pasión (3)</button>
                            <button type="button" class="garden-species-pill" data-flower-filter="calma">🪻 Paz &amp; Serenidad (3)</button>
                            <button type="button" class="garden-species-pill" data-flower-filter="alegria">🌻 Alegría &amp; Luz (3)</button>
                            <button type="button" class="garden-species-pill" data-flower-filter="eternidad">👑 Eternidad &amp; Pureza (3)</button>
                        </div>
                    </div>

                    <div class="garden-interactive-bed" id="garden-interactive-bed">
                        <!-- 1. Rosa Damascena Real -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="rosa-damascena"
                            data-flower-category="amor"
                            data-flower-note="523.25"
                            data-flower-name="Rosa Damascena Real"
                            data-flower-latin="Rosa × damascena"
                            data-flower-origin="Valle de las Rosas, Kazanlak &amp; Damasco"
                            data-flower-fragrance="Notas de miel rosada, rocío de alba y terciopelo cálido"
                            data-flower-bloom-season="Primavera Imperial · Floración Perpetua"
                            data-flower-symbol="Amor Genuino, Nobleza y Fuerza Serena"
                            data-flower-dedication="Para Carla Lorena: La rosa no compite con ninguna otra flor; florece con autenticidad, elegancia insuperable y una fragancia que perdura en el tiempo. Que tu vida tenga siempre esa misma fuerza dulce."
                            data-flower-adrian="«Mi princesa Carla Lorena, entre millones de flores en el mundo, mi corazón siempre te reconocería a ti como su única Rosa Imperial. Eres mi ternura, mi orgullo y mi hogar.» — Adrián"
                            data-flower-secret="Cada uno de sus 36 pétalos guarda un deseo silencioso por tu felicidad absoluta."
                            data-flower-icon="🌹">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-rose">Rosaceae · Reina Floral</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Rosa Damascena">
                                    <defs>
                                        <radialGradient id="roseGlow" cx="50%" cy="45%" r="50%">
                                            <stop offset="0%" stop-color="#e03e67"/>
                                            <stop offset="65%" stop-color="#b91c45"/>
                                            <stop offset="100%" stop-color="#7f1d2e"/>
                                        </radialGradient>
                                        <radialGradient id="roseCore" cx="50%" cy="50%" r="40%">
                                            <stop offset="0%" stop-color="#ffffff"/>
                                            <stop offset="100%" stop-color="#e03e67"/>
                                        </radialGradient>
                                        <linearGradient id="roseStem" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#26a57b"/>
                                            <stop offset="100%" stop-color="#1b7a5a"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M50 68 C50 78 52 88 51 98" stroke="url(#roseStem)" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M49 76 C41 73 34 77 31 82 C37 83 44 80 49 76Z" fill="#26a57b"/>
                                    <path d="M51 82 C59 79 66 82 69 88 C63 89 56 86 51 82Z" fill="#1b7a5a"/>
                                    <path d="M30 46 C24 35 38 24 50 30 C62 24 76 35 70 46 C64 58 36 58 30 46Z" fill="url(#roseGlow)" opacity="0.95"/>
                                    <path d="M24 50 C22 40 32 32 44 34 C42 46 32 56 24 50Z" fill="url(#roseGlow)"/>
                                    <path d="M76 50 C78 40 68 32 56 34 C58 46 68 56 76 50Z" fill="url(#roseGlow)"/>
                                    <path d="M33 55 C27 64 45 72 50 68 C55 72 73 64 67 55 C60 62 40 62 33 55Z" fill="#c0264b"/>
                                    <circle cx="50" cy="46" r="13" fill="url(#roseCore)"/>
                                    <path d="M45 42 C48 39 53 39 55 43 C57 47 52 50 49 48 C46 46 46 44 49 43" stroke="#fff" stroke-width="1.2" stroke-linecap="round" opacity="0.75"/>
                                </svg>
                            </div>
                            <h3>Rosa Damascena</h3>
                            <span class="real-flower-latin">Rosa × damascena</span>
                            <p class="real-flower-desc">«Pétalos aterciopelados con fragancia noble. El símbolo inmortal del amor más sincero, gratitud y devoción.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Valle de Kazanlak &amp; Damasco</span>
                                    <span><strong>🌸 Aroma:</strong> Miel rosada y terciopelo matinal</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Entre millones de flores en el mundo, mi corazón siempre te reconocería a ti como su única Rosa Imperial.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Nobleza &amp; Ternura</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 2. Girasol Dorado Silvestre -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="girasol-dorado"
                            data-flower-category="alegria"
                            data-flower-note="587.33"
                            data-flower-name="Girasol Dorado"
                            data-flower-latin="Helianthus annuus"
                            data-flower-origin="Praderas Soleadas de América &amp; Toscana"
                            data-flower-fragrance="Ámbar cálido, polen dorado, miel silvestre y brisa de verano"
                            data-flower-bloom-season="Solsticio de Verano · Luz Radiante"
                            data-flower-symbol="Energía Radiante, Admiración y Optimismo"
                            data-flower-dedication="Carla Lorena: Eres como el girasol, que siempre busca la luz y tiene la facultad maravillosa de alegrar e iluminar el día de cualquiera con tan solo una sonrisa sincera."
                            data-flower-adrian="«Así como el girasol sigue al sol desde que amanece, mis ojos y mis pensamientos te buscan a ti en cada instante, porque tú eres la luz que da vida a mi mundo.» — Adrián"
                            data-flower-secret="Gira suavemente siguiendo la calidez de tu sonrisa incluso en los días nublados."
                            data-flower-icon="🌻">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-sunflower">Asteraceae · Faro de Luz</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Girasol Dorado">
                                    <defs>
                                        <radialGradient id="sunSeed" cx="50%" cy="50%" r="50%">
                                            <stop offset="0%" stop-color="#542c13"/>
                                            <stop offset="70%" stop-color="#3d1d09"/>
                                            <stop offset="100%" stop-color="#220e03"/>
                                        </radialGradient>
                                        <linearGradient id="sunPetal" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#fff066"/>
                                            <stop offset="60%" stop-color="#f59e0b"/>
                                            <stop offset="100%" stop-color="#d97706"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M50 65 L50 98" stroke="#26a57b" stroke-width="4.5" stroke-linecap="round"/>
                                    <path d="M49 78 C39 74 34 82 28 84 C36 88 45 84 49 78Z" fill="#1b7a5a"/>
                                    <path d="M51 84 C61 80 66 88 72 90 C64 94 55 90 51 84Z" fill="#26a57b"/>
                                    <path d="M50 16 L54 36 L50 40 L46 36 Z" fill="url(#sunPetal)"/>
                                    <path d="M50 74 L54 54 L50 50 L46 54 Z" fill="url(#sunPetal)"/>
                                    <path d="M21 45 L41 49 L45 45 L41 41 Z" fill="url(#sunPetal)"/>
                                    <path d="M79 45 L59 49 L55 45 L59 41 Z" fill="url(#sunPetal)"/>
                                    <path d="M29 24 L45 39 L42 42 L38 39 Z" fill="url(#sunPetal)"/>
                                    <path d="M71 66 L55 51 L58 48 L62 51 Z" fill="url(#sunPetal)"/>
                                    <path d="M71 24 L55 39 L58 42 L62 39 Z" fill="url(#sunPetal)"/>
                                    <path d="M29 66 L45 51 L42 48 L38 51 Z" fill="url(#sunPetal)"/>
                                    <path d="M40 18 L48 37 L44 38 Z" fill="#fbbf24"/>
                                    <path d="M60 18 L52 37 L56 38 Z" fill="#fbbf24"/>
                                    <path d="M77 34 L58 43 L60 47 Z" fill="#fbbf24"/>
                                    <path d="M77 56 L58 47 L60 43 Z" fill="#fbbf24"/>
                                    <path d="M40 72 L48 53 L44 52 Z" fill="#fbbf24"/>
                                    <path d="M60 72 L52 53 L56 52 Z" fill="#fbbf24"/>
                                    <path d="M23 56 L42 47 L40 43 Z" fill="#fbbf24"/>
                                    <path d="M23 34 L42 43 L40 47 Z" fill="#fbbf24"/>
                                    <circle cx="50" cy="45" r="14" fill="url(#sunSeed)"/>
                                    <circle cx="50" cy="45" r="13" stroke="#fef08a" stroke-width="0.8" stroke-dasharray="2 3" opacity="0.6"/>
                                    <circle cx="50" cy="45" r="8" stroke="#f59e0b" stroke-width="0.6" stroke-dasharray="1.5 2" opacity="0.7"/>
                                </svg>
                            </div>
                            <h3>Girasol Dorado</h3>
                            <span class="real-flower-latin">Helianthus annuus</span>
                            <p class="real-flower-desc">«Corola radiante que baila siguiendo los rayos del sol. Representa vitalidad pura, calidez y lealtad incondicional.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Praderas Soleadas &amp; Toscana</span>
                                    <span><strong>🌸 Aroma:</strong> Ámbar cálido, polen y miel silvestre</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Así como el girasol sigue al sol, mis pensamientos te buscan a ti en cada instante porque tú eres mi luz.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Felicidad &amp; Luz</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 3. Tulipán Imperial Rosado -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="tulipan-imperial"
                            data-flower-category="amor"
                            data-flower-note="659.25"
                            data-flower-name="Tulipán Imperial"
                            data-flower-latin="Tulipa gesneriana"
                            data-flower-origin="Jardines Reales de Keukenhof &amp; Anatolia"
                            data-flower-fragrance="Frescura cristalina de pétalos húmedos y almendra dulce"
                            data-flower-bloom-season="Equinoccio de Primavera · Despertar"
                            data-flower-symbol="Gracia, Renacer y Perfección Femenina"
                            data-flower-dedication="Carla Lorena: Cada primavera trae consigo el renacimiento de lo bello. El tulipán simboliza tus nuevos comienzos y esa elegancia natural que no necesita presumir para cautivar."
                            data-flower-adrian="«El tulipán guarda en su cáliz la promesa de un amor sincero y eterno. Contigo, mi amada Lorena, cada día se siente como el primer amanecer de la primavera.» — Adrián"
                            data-flower-secret="Sus pétalos se cierran al anochecer para proteger los sueños más tiernos de tu corazón."
                            data-flower-icon="🌷">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-tulip">Liliaceae · Copa de Gracia</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Tulipán Imperial">
                                    <defs>
                                        <linearGradient id="tulipPetal" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#f87171"/>
                                            <stop offset="50%" stop-color="#ef4444"/>
                                            <stop offset="100%" stop-color="#991b1b"/>
                                        </linearGradient>
                                        <linearGradient id="tulipSide" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#fee2e2"/>
                                            <stop offset="100%" stop-color="#dc2626"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M50 56 C50 72 49 84 50 98" stroke="#26a57b" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M48 94 C34 88 24 64 28 46 C35 58 45 78 48 94Z" fill="#34d399"/>
                                    <path d="M52 94 C66 88 74 68 70 52 C65 64 55 80 52 94Z" fill="#1b7a5a"/>
                                    <path d="M33 34 C30 46 36 60 50 60 C40 56 36 44 38 32 C35 32 34 33 33 34Z" fill="url(#tulipSide)"/>
                                    <path d="M67 34 C70 46 64 60 50 60 C60 56 64 44 62 32 C65 32 66 33 67 34Z" fill="url(#tulipSide)"/>
                                    <path d="M37 32 C43 20 57 20 63 32 C67 48 57 60 50 60 C43 60 33 48 37 32Z" fill="url(#tulipPetal)"/>
                                    <path d="M47 26 C49 22 51 22 53 26 C54 34 52 38 50 40 C48 38 46 34 47 26Z" fill="#ffffff" opacity="0.9"/>
                                </svg>
                            </div>
                            <h3>Tulipán Imperial</h3>
                            <span class="real-flower-latin">Tulipa gesneriana</span>
                            <p class="real-flower-desc">«Silueta impecable que florece con los primeros cantos primaverales. Representa la finura, el cariño verdadero y el renacer continuo.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Jardines de Keukenhof &amp; Anatolia</span>
                                    <span><strong>🌸 Aroma:</strong> Pétalos húmedos y almendra suave</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Contigo, mi amada Lorena, cada día se siente como el primer amanecer de la primavera.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Elegancia &amp; Renacer</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 4. Lavanda de Grasse -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="lavanda-grasse"
                            data-flower-category="calma"
                            data-flower-note="698.46"
                            data-flower-name="Lavanda de Grasse"
                            data-flower-latin="Lavandula angustifolia"
                            data-flower-origin="Colinas Violetas de Provenza &amp; Grasse, Francia"
                            data-flower-fragrance="Bálsamo herbal sereno, brisa de montaña y néctar violeta"
                            data-flower-bloom-season="Tardes de Estío · Calma Profunda"
                            data-flower-symbol="Serenidad, Calma Espiritual y Protección"
                            data-flower-dedication="Que en medio de cualquier tormenta del mundo exterior, encuentres en este jardín un oasis de calma absoluta, donde el aroma a lavanda te recuerde que todo tiene su momento de serenidad."
                            data-flower-adrian="«Cuando el mundo vaya demasiado deprisa, ven a mis brazos, mi Carla Lorena. Yo quiero ser siempre tu refugio de paz, tu silencio dulce y tu lugar seguro.» — Adrián"
                            data-flower-secret="Una sola brisa sobre sus espigas disipa cualquier cansancio y acaricia el alma."
                            data-flower-icon="🪻">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-lavender">Lamiaceae · Esencia de Calma</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Lavanda Silvestre">
                                    <defs>
                                        <linearGradient id="lavenderStem" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#34d399"/>
                                            <stop offset="100%" stop-color="#1b7a5a"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M50 30 L50 96" stroke="url(#lavenderStem)" stroke-width="2.5" stroke-linecap="round"/>
                                    <path d="M40 45 L40 94" stroke="url(#lavenderStem)" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M60 48 L60 94" stroke="url(#lavenderStem)" stroke-width="2" stroke-linecap="round"/>
                                    <ellipse cx="50" cy="24" rx="4" ry="5.5" fill="#a855f7"/>
                                    <ellipse cx="46" cy="30" rx="3.5" ry="4.5" fill="#c084fc"/>
                                    <ellipse cx="54" cy="30" rx="3.5" ry="4.5" fill="#9333ea"/>
                                    <ellipse cx="45" cy="37" rx="4" ry="5" fill="#7e22ce"/>
                                    <ellipse cx="55" cy="37" rx="4" ry="5" fill="#c084fc"/>
                                    <ellipse cx="46" cy="45" rx="3.5" ry="4.5" fill="#a855f7"/>
                                    <ellipse cx="54" cy="45" rx="3.5" ry="4.5" fill="#7e22ce"/>
                                    <ellipse cx="50" cy="52" rx="3.5" ry="4" fill="#9333ea"/>
                                    <ellipse cx="40" cy="40" rx="3" ry="4" fill="#c084fc"/>
                                    <ellipse cx="37" cy="46" rx="3" ry="3.5" fill="#a855f7"/>
                                    <ellipse cx="43" cy="47" rx="3" ry="3.5" fill="#7e22ce"/>
                                    <ellipse cx="40" cy="54" rx="3" ry="3.5" fill="#9333ea"/>
                                    <ellipse cx="60" cy="43" rx="3" ry="4" fill="#c084fc"/>
                                    <ellipse cx="57" cy="49" rx="3" ry="3.5" fill="#7e22ce"/>
                                    <ellipse cx="63" cy="50" rx="3" ry="3.5" fill="#a855f7"/>
                                    <ellipse cx="60" cy="57" rx="3" ry="3.5" fill="#9333ea"/>
                                </svg>
                            </div>
                            <h3>Lavanda de Grasse</h3>
                            <span class="real-flower-latin">Lavandula angustifolia</span>
                            <p class="real-flower-desc">«Espigas violetas aromáticas mecidas por el viento. Concede serenidad al corazón, paz mental y un sueño reparador.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Colinas de Provenza &amp; Grasse</span>
                                    <span><strong>🌸 Aroma:</strong> Bálsamo herbal y néctar violeta</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Yo quiero ser siempre tu refugio de paz, tu silencio dulce y tu lugar seguro.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Paz &amp; Silencio Dulce</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 5. Peonía Real de Seda -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="peonia-seda"
                            data-flower-category="amor"
                            data-flower-note="783.99"
                            data-flower-name="Peonía Real de Seda"
                            data-flower-latin="Paeonia lactiflora"
                            data-flower-origin="Jardines Imperiales de Luoyang"
                            data-flower-fragrance="Seda empolvada, rosa fresca, lichi dulce y néctar imperial"
                            data-flower-bloom-season="Mayo Florido · Esplendor de Seda"
                            data-flower-symbol="Felicidad Plena, Fortuna y Delicadeza"
                            data-flower-dedication="Carla Lorena: La peonía florece con paciencia para revelar capas infinitas de dulzura. Que todos tus sueños se abran paso con esa misma belleza y prosperidad."
                            data-flower-adrian="«Cada capa de la peonía me recuerda todas las virtudes que descubro en ti cada día: tu dulzura, tu inteligencia, tu bondad y esa forma tan hermosa de amar.» — Adrián"
                            data-flower-secret="Considerada durante siglos la flor de las emperatrices y de los amores bendecidos por el destino."
                            data-flower-icon="🌸">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-peony">Paeoniaceae · Flor del Honor</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Peonía de Seda">
                                    <defs>
                                        <radialGradient id="peonyGlow" cx="50%" cy="50%" r="50%">
                                            <stop offset="0%" stop-color="#ffffff"/>
                                            <stop offset="40%" stop-color="#fee2e2"/>
                                            <stop offset="85%" stop-color="#ef4444"/>
                                            <stop offset="100%" stop-color="#991b1b"/>
                                        </radialGradient>
                                    </defs>
                                    <path d="M50 72 L50 98" stroke="#1b7a5a" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M49 82 C38 78 30 84 25 88 C34 91 44 88 49 82Z" fill="#26a57b"/>
                                    <path d="M51 86 C62 82 70 88 75 92 C66 95 56 92 51 86Z" fill="#1b7a5a"/>
                                    <circle cx="50" cy="46" r="26" fill="url(#peonyGlow)" opacity="0.9"/>
                                    <path d="M30 40 C28 28 42 22 52 26 C64 20 74 30 70 42 C74 54 62 66 48 64 C34 66 26 52 30 40Z" fill="#fee2e2" opacity="0.6"/>
                                    <path d="M36 44 C34 36 44 32 50 36 C56 32 66 36 64 44 C66 52 58 58 50 56 C42 58 34 52 36 44Z" fill="#ef4444"/>
                                    <circle cx="50" cy="46" r="8" fill="#ffffff"/>
                                    <circle cx="50" cy="46" r="4" fill="#dc2626"/>
                                </svg>
                            </div>
                            <h3>Peonía de Seda</h3>
                            <span class="real-flower-latin">Paeonia lactiflora</span>
                            <p class="real-flower-desc">«Centenares de velos rosados que se abren con suntuosa gracia. El amuleto tradicional de la felicidad duradera y el cariño noble.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Jardines Imperiales de Luoyang</span>
                                    <span><strong>🌸 Aroma:</strong> Seda empolvada, rosa fresca y lichi</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Cada capa de la peonía me recuerda las infinitas virtudes que admiro en ti cada día.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Ternura &amp; Dicha</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 6. Orquídea Imperial Blanca & Amatista -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="orquidea-imperial"
                            data-flower-category="eternidad"
                            data-flower-note="880.00"
                            data-flower-name="Orquídea Imperial"
                            data-flower-latin="Phalaenopsis amabilis"
                            data-flower-origin="Bosques de Niebla &amp; Santuarios Tropicales"
                            data-flower-fragrance="Vainilla cristalina, rocío exótico y almizcle blanco"
                            data-flower-bloom-season="Floración Lunar · Elegancia Sublime"
                            data-flower-symbol="Belleza Sublime, Admiración Profunda y Exclusividad"
                            data-flower-dedication="Carla Lorena: Como la orquídea que florece con simetría perfecta y delicadeza extraordinaria, tu presencia embellece cada instante con una distinción única."
                            data-flower-adrian="«Eres única e irrepetible, mi Carla Lorena. Como la orquídea más preciada del universo, cuidarte, admirarte y amarte es el privilegio más hermoso de mi vida.» — Adrián"
                            data-flower-secret="Sus alas parecen mariposas blancas detenidas en el tiempo para contemplar tu sonrisa."
                            data-flower-icon="🌺">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-lavender">Orchidaceae · Joya Alada</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Orquídea Imperial">
                                    <path d="M50 58 C50 74 48 86 50 98" stroke="#1b7a5a" stroke-width="3" stroke-linecap="round"/>
                                    <ellipse cx="50" cy="24" rx="9" ry="14" fill="#fdf4ff" stroke="#e879f9" stroke-width="1.2"/>
                                    <ellipse cx="29" cy="42" rx="16" ry="11" transform="rotate(-15 29 42)" fill="#fae8ff" stroke="#d946ef" stroke-width="1.2"/>
                                    <ellipse cx="71" cy="42" rx="16" ry="11" transform="rotate(15 71 42)" fill="#fae8ff" stroke="#d946ef" stroke-width="1.2"/>
                                    <ellipse cx="38" cy="57" rx="10" ry="13" transform="rotate(20 38 57)" fill="#f5d0fe"/>
                                    <ellipse cx="62" cy="57" rx="10" ry="13" transform="rotate(-20 62 57)" fill="#f5d0fe"/>
                                    <circle cx="50" cy="45" r="8" fill="#a21caf"/>
                                    <circle cx="50" cy="44" r="3.5" fill="#fde047"/>
                                </svg>
                            </div>
                            <h3>Orquídea Imperial</h3>
                            <span class="real-flower-latin">Phalaenopsis amabilis</span>
                            <p class="real-flower-desc">«Pétalos como alas de mariposa nacarada. Emblema de distinción sublime, encanto magnético y devoción exquisita.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Bosques de Niebla Tropicales</span>
                                    <span><strong>🌸 Aroma:</strong> Vainilla cristalina y almizcle blanco</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Cuidarte, admirarte y amarte es el privilegio más hermoso de mi vida.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Distinción &amp; Encanto</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 7. Lirio Real Blanco -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="lirio-real"
                            data-flower-category="eternidad"
                            data-flower-note="987.77"
                            data-flower-name="Lirio Real Blanco"
                            data-flower-latin="Lilium candidum"
                            data-flower-origin="Valles Mediterráneos &amp; Jardines Reales"
                            data-flower-fragrance="Néctar blanco luminoso, azahar suave y pureza matinal"
                            data-flower-bloom-season="Alba de Mayo · Luz Inmaculada"
                            data-flower-symbol="Pureza del Alma, Lealtad y Majestad"
                            data-flower-dedication="Carla Lorena: El lirio blanco representa la nobleza de un corazón transparente. Gracias por iluminar la vida con la pureza de tus sentimientos y tu bondad genuina."
                            data-flower-adrian="«Tu alma tiene la pureza y la luz del Lirio Real, mi amada princesa. Mi promesa ante ti es amarte con la misma lealtad limpia y eterna hoy y siempre.» — Adrián"
                            data-flower-secret="Sus estambres dorados brillan bajo la luna como pequeñas estrellas dedicadas a tu nombre."
                            data-flower-icon="⚜️">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-tulip">Liliaceae · Estrella Alba</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Lirio Real Blanco">
                                    <path d="M50 60 L50 98" stroke="#1b7a5a" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M50 14 C56 26 56 36 50 45 C44 36 44 26 50 14Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="1"/>
                                    <path d="M22 36 C34 33 43 38 50 45 C40 48 30 45 22 36Z" fill="#f8fafc" stroke="#cbd5e1" stroke-width="1"/>
                                    <path d="M78 36 C66 33 57 38 50 45 C60 48 70 45 78 36Z" fill="#f8fafc" stroke="#cbd5e1" stroke-width="1"/>
                                    <path d="M28 64 C34 52 42 47 50 45 C46 56 38 63 28 64Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="1"/>
                                    <path d="M72 64 C66 52 58 47 50 45 C54 56 62 63 72 64Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="1"/>
                                    <circle cx="50" cy="45" r="5" fill="#fef08a"/>
                                    <circle cx="46" cy="39" r="2" fill="#f59e0b"/>
                                    <circle cx="54" cy="39" r="2" fill="#f59e0b"/>
                                    <circle cx="50" cy="36" r="2" fill="#f59e0b"/>
                                </svg>
                            </div>
                            <h3>Lirio Real Blanco</h3>
                            <span class="real-flower-latin">Lilium candidum</span>
                            <p class="real-flower-desc">«Cáliz estelar de blancura inmaculada y corona de polen de oro. Símbolo de nobleza espiritual y amor leal.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Valles Mediterráneos Reales</span>
                                    <span><strong>🌸 Aroma:</strong> Néctar blanco luminoso y azahar</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Mi promesa ante ti es amarte con lealtad limpia, profunda y eterna hoy y siempre.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Pureza &amp; Majestad</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 8. Flor de Cerezo Sakura -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="cerezo-sakura"
                            data-flower-category="alegria"
                            data-flower-note="1046.50"
                            data-flower-name="Flor de Cerezo Sakura"
                            data-flower-latin="Prunus serrulata"
                            data-flower-origin="Santuarios de Kioto &amp; Monte Yoshino"
                            data-flower-fragrance="Brisa rosada de primavera, flor de almendro y rocío fresco"
                            data-flower-bloom-season="Hanami de Abril · Lluvia Rosada"
                            data-flower-symbol="Magia del Instante, Dulzura y Esperanza"
                            data-flower-dedication="Carla Lorena: El cerezo en flor nos enseña a atesorar cada segundo juntos como un milagro irrepetible. Que cada día de tu vida esté cubierto de pétalos de ilusión."
                            data-flower-adrian="«Bajo una lluvia de pétalos de Sakura te volvería a elegir mil vidas más, mi Carla Lorena. Cada instante a tu lado es poesía viva.» — Adrián"
                            data-flower-secret="Cuando sus cinco pétalos bailan en el viento, llevan consigo los deseos cumplidos de quienes se aman."
                            data-flower-icon="🌸">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-peony">Rosaceae · Brisa de Kioto</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Flor de Cerezo Sakura">
                                    <path d="M22 86 C38 78 58 68 80 58" stroke="#6b4423" stroke-width="3.2" stroke-linecap="round"/>
                                    <circle cx="50" cy="24" r="12" fill="#fbcfe8"/>
                                    <circle cx="71" cy="39" r="12" fill="#f9a8d4"/>
                                    <circle cx="63" cy="63" r="12" fill="#fbcfe8"/>
                                    <circle cx="37" cy="63" r="12" fill="#f9a8d4"/>
                                    <circle cx="29" cy="39" r="12" fill="#fbcfe8"/>
                                    <circle cx="50" cy="46" r="7" fill="#ec4899"/>
                                    <circle cx="50" cy="46" r="3" fill="#fef08a"/>
                                </svg>
                            </div>
                            <h3>Flor de Cerezo Sakura</h3>
                            <span class="real-flower-latin">Prunus serrulata</span>
                            <p class="real-flower-desc">«Cinco pétalos de porcelana rosada que pintan el cielo de primavera. Celebra la magia de cada instante compartido.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Jardines de Kioto &amp; Monte Yoshino</span>
                                    <span><strong>🌸 Aroma:</strong> Brisa rosada y flor de almendro</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Bajo una lluvia de pétalos de Sakura te volvería a elegir mil vidas más, mi Carla Lorena.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Poesía &amp; Esperanza</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 9. Magnolia Celeste -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="magnolia-celeste"
                            data-flower-category="calma"
                            data-flower-note="523.25"
                            data-flower-name="Magnolia Imperial"
                            data-flower-latin="Magnolia grandiflora"
                            data-flower-origin="Valles Antiguos del Himalaya &amp; Jardines del Sur"
                            data-flower-fragrance="Cítrico perlado, crema de vainilla y brisa de porcelana"
                            data-flower-bloom-season="Primavera Temprana · Dignidad"
                            data-flower-symbol="Dignidad, Dulzura Firme y Armonía"
                            data-flower-dedication="Carla Lorena: La magnolia combina la suavidad más delicada en sus pétalos con una fortaleza admirable en sus raíces. Así es tu corazón: tierno y valiente a la vez."
                            data-flower-adrian="«Admiro tu fuerza serena tanto como tu dulzura, mi amada Lorena. Eres como la magnolia: elegante, luminosa e inolvidable en todo lo que haces.» — Adrián"
                            data-flower-secret="Es una de las primeras flores que existieron en la Tierra, símbolo de un amor que trasciende las eras."
                            data-flower-icon="💮">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-rose">Magnoliaceae · Porcelana Viva</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Magnolia Imperial">
                                    <path d="M50 64 L50 98" stroke="#4b5563" stroke-width="3.5" stroke-linecap="round"/>
                                    <ellipse cx="50" cy="34" rx="11" ry="20" fill="#ffeaf3" stroke="#ff3e9a" stroke-width="1"/>
                                    <ellipse cx="34" cy="44" rx="11" ry="18" transform="rotate(-28 34 44)" fill="#ffeaf3"/>
                                    <ellipse cx="66" cy="44" rx="11" ry="18" transform="rotate(28 66 44)" fill="#ffeaf3"/>
                                    <ellipse cx="42" cy="52" rx="12" ry="14" fill="#ffd2e5"/>
                                    <ellipse cx="58" cy="52" rx="12" ry="14" fill="#ffd2e5"/>
                                    <circle cx="50" cy="48" r="6" fill="#fbbf24"/>
                                </svg>
                            </div>
                            <h3>Magnolia Imperial</h3>
                            <span class="real-flower-latin">Magnolia grandiflora</span>
                            <p class="real-flower-desc">«Cáliz escultural de pétalos nacarados que irradian paz. Representa la armonía entre la ternura y la valentía.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Valles del Himalaya &amp; Sur</span>
                                    <span><strong>🌸 Aroma:</strong> Cítrico perlado y crema de vainilla</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Admiro tu fuerza serena tanto como tu dulzura, mi amada Lorena.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Dignidad &amp; Armonía</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 10. Hortensia Azul de Ensueño -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="hortensia-azul"
                            data-flower-category="calma"
                            data-flower-note="659.25"
                            data-flower-name="Hortensia Azul de Ensueño"
                            data-flower-latin="Hydrangea macrophylla"
                            data-flower-origin="Islas Azores &amp; Jardines de Lluvia Suave"
                            data-flower-fragrance="Rocío celeste, lluvia fresca sobre hojas verdes y musgo dulce"
                            data-flower-bloom-season="Verano Celeste · Gratitud"
                            data-flower-symbol="Gratitud Infinita, Comprensión y Abundancia"
                            data-flower-dedication="Carla Lorena: Cientos de pequeñas flores unidas forman el ramo perfecto de la hortensia, igual que cada pequeño detalle tuyo construye un universo maravilloso."
                            data-flower-adrian="«Gracias por existir, mi Carla Lorena. Cada pétalo azul de esta hortensia es un "gracias" de mi corazón por tu risa, tu compañía y tu amor tan bonito.» — Adrián"
                            data-flower-secret="Sus ramilletes azules guardan el color del cielo despejado después de una lluvia de verano."
                            data-flower-icon="💠">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-lavender">Hydrangeaceae · Nube Celeste</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Hortensia Azul">
                                    <path d="M50 66 L50 98" stroke="#1b7a5a" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="50" cy="44" r="24" fill="#bfdbfe"/>
                                    <circle cx="38" cy="36" r="10" fill="#60a5fa"/>
                                    <circle cx="62" cy="36" r="10" fill="#3b82f6"/>
                                    <circle cx="36" cy="52" r="10" fill="#3b82f6"/>
                                    <circle cx="64" cy="52" r="10" fill="#60a5fa"/>
                                    <circle cx="50" cy="28" r="9" fill="#93c5fd"/>
                                    <circle cx="50" cy="56" r="9" fill="#93c5fd"/>
                                    <circle cx="50" cy="44" r="11" fill="#2563eb"/>
                                    <circle cx="50" cy="44" r="3.5" fill="#fef08a"/>
                                    <circle cx="38" cy="36" r="2.5" fill="#eff6ff"/>
                                    <circle cx="62" cy="36" r="2.5" fill="#eff6ff"/>
                                </svg>
                            </div>
                            <h3>Hortensia de Ensueño</h3>
                            <span class="real-flower-latin">Hydrangea macrophylla</span>
                            <p class="real-flower-desc">«Constelación de florecillas celestes entrelazadas en un bouquet generoso. Expresa gratitud profunda y ternura.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Islas Azores &amp; Jardines Celestes</span>
                                    <span><strong>🌸 Aroma:</strong> Rocío celeste y lluvia fresca</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Cada pétalo azul es un "gracias" de mi corazón por tu risa, tu compañía y tu amor.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Gratitud &amp; Cielo</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 11. Jazmín Nocturno Estrellado -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="jazmin-nocturno"
                            data-flower-category="alegria"
                            data-flower-note="783.99"
                            data-flower-name="Jazmín Estrellado"
                            data-flower-latin="Jasminum officinale"
                            data-flower-origin="Jardines Reales de Andalucía &amp; Cachemira"
                            data-flower-fragrance="Perfume nocturno embriagador, miel blanca y néctar de luna"
                            data-flower-bloom-season="Noches Estrelladas · Romance"
                            data-flower-symbol="Dulzura Nocturna, Romance y Sueños Dorados"
                            data-flower-dedication="Carla Lorena: El jazmín perfuma la noche cuando las estrellas despiertan. Que su fragancia envuelva tus pensamientos más bonitos y llene tu alma de ilusión."
                            data-flower-adrian="«Incluso en la noche más silenciosa, mi amor por ti perfuma cada rincón de mi vida como el jazmín bajo las estrellas. Buenas noches y buenos días siempre contigo, mi princesa.» — Adrián"
                            data-flower-secret="Florece con más intensidad bajo la luz de las luciérnagas y la luna llena."
                            data-flower-icon="🌼">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-sunflower">Oleaceae · Estrella Perfumada</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Jazmín Estrellado">
                                    <path d="M50 58 L50 98" stroke="#1b7a5a" stroke-width="3" stroke-linecap="round"/>
                                    <polygon points="50,15 56,37 79,37 60,50 67,72 50,58 33,72 40,50 21,37 44,37" fill="#fefce8" stroke="#facc15" stroke-width="1.2"/>
                                    <circle cx="50" cy="46" r="7" fill="#f59e0b"/>
                                    <circle cx="50" cy="46" r="3" fill="#ffffff"/>
                                </svg>
                            </div>
                            <h3>Jazmín Estrellado</h3>
                            <span class="real-flower-latin">Jasminum officinale</span>
                            <p class="real-flower-desc">«Pequeñas estrellas blancas de perfume inolvidable que iluminan los senderos nocturnos del jardín.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Jardines de Andalucía &amp; Cachemira</span>
                                    <span><strong>🌸 Aroma:</strong> Miel blanca y néctar de luna</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Mi amor por ti perfuma cada rincón de mi vida como el jazmín bajo las estrellas.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Romance &amp; Estrellas</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>

                        <!-- 12. Camelia Carmesí de Invierno -->
                        <article class="real-flower-card flower-card" tabindex="0"
                            data-flower-id="camelia-carmesi"
                            data-flower-category="eternidad"
                            data-flower-note="880.00"
                            data-flower-name="Camelia Carmesí Real"
                            data-flower-latin="Camellia japonica"
                            data-flower-origin="Colinas Imperiales de Oriente"
                            data-flower-fragrance="Té blanco imperial, madera de rosal y rocío cristalino"
                            data-flower-bloom-season="Pleno Invierno · Amor Inquebrantable"
                            data-flower-symbol="Devoción Inquebrantable, Excelencia y Eternidad"
                            data-flower-dedication="Carla Lorena: La camelia es la única flor capaz de abrir sus pétalos incluso sobre la nieve, demostrando que la belleza verdadera y el amor sincero jamás se rinden."
                            data-flower-adrian="«Como la camelia que florece incluso en el frío más intenso, mi amor por ti es inquebrantable, fiel en toda estación y eterno en cada latido, mi amada Carla Lorena.» — Adrián"
                            data-flower-secret="Cuando una camelia entrega su flor, el cáliz y los pétalos permanecen unidos para siempre, símbolo de dos almas indivisibles."
                            data-flower-icon="🌺">
                            <div class="real-flower-top-meta">
                                <span class="real-flower-badge badge-rose">Theaceae · Flor Inmortal</span>
                                <span class="flower-bloom-counter" data-bloom-badge>💧 <strong data-bloom-num>1</strong></span>
                            </div>
                            <div class="real-flower-visual">
                                <div class="flower-sparkle-ring" aria-hidden="true"></div>
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Camelia Carmesí">
                                    <path d="M50 68 L50 98" stroke="#1b7a5a" stroke-width="3.5" stroke-linecap="round"/>
                                    <circle cx="50" cy="45" r="25" fill="#b8126c"/>
                                    <circle cx="50" cy="45" r="20" fill="#b8126c"/>
                                    <circle cx="50" cy="45" r="15" fill="#ff3e9a"/>
                                    <circle cx="50" cy="45" r="10" fill="#ff3e9a"/>
                                    <circle cx="50" cy="45" r="5" fill="#fde047"/>
                                </svg>
                            </div>
                            <h3>Camelia Carmesí</h3>
                            <span class="real-flower-latin">Camellia japonica</span>
                            <p class="real-flower-desc">«Geometría floral perfecta que florece incluso sobre la escarcha. El emblema supremo de la unión eterna y el amor fiel.»</p>

                            <div class="flower-inline-drawer" hidden>
                                <div class="flower-drawer-meta">
                                    <span><strong>📍 Origen:</strong> Colinas Imperiales de Oriente</span>
                                    <span><strong>🌸 Aroma:</strong> Té blanco imperial y madera de rosal</span>
                                </div>
                                <div class="flower-drawer-adrian">
                                    <strong>💌 Adrián para Carla:</strong>
                                    <p>«Mi amor por ti es inquebrantable, fiel en toda estación y eterno en cada latido.»</p>
                                </div>
                            </div>

                            <div class="flower-card-interactive-actions">
                                <button type="button" class="flower-action-btn flower-water-btn" data-flower-water>
                                    <span>💧 Rocío de Luz</span>
                                </button>
                                <button type="button" class="flower-action-btn flower-drawer-btn" data-flower-toggle-drawer aria-expanded="false">
                                    <span>📖 Ficha &amp; Adrián</span>
                                </button>
                            </div>

                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Unión Eterna &amp; Fe</span>
                                <button type="button" class="real-flower-trigger" data-flower-open-modal>Abrir pergamino ↗</button>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- NUEVO: Biblioteca de Palabras Expresadas de Adrián para Carla Lorena -->
                <div class="adrian-words-library-section luxury-card" id="adrian-words-library-section">
                    <div class="adrian-library-header">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge">ARCHIVO DEL CORAZÓN</span>
                                <span class="atelier-dot">◆</span>
                                <span class="atelier-badge">PALABRAS EXPRESADAS A CARLA LORENA</span>
                            </div>
                            <span class="eyebrow">ANTOLOGÍA ÍNTIMA · DE ADRIÁN PARA CARLA LORENA</span>
                            <h2>Biblioteca de Palabras Expresadas a Carla</h2>
                            <p>Cada pensamiento, promesa, carta de buenos días y declaración de admiración que Adrián ha dedicado a su amada princesa Carla Lorena. Filtra por sentimiento, busca una palabra especial o escucha su melodía.</p>
                        </div>

                        <div class="adrian-library-controls">
                            <div class="adrian-library-search-wrap">
                                <input type="search" id="adrian-library-search" class="adrian-library-search-input" placeholder="🔍 Buscar palabra, flor o promesa para Carla...">
                            </div>
                            @auth
                                <button type="button" class="button button-primary button-sm" id="btn-toggle-adrian-note-form">
                                    <span>✍️ Añadir nueva palabra de Adrián</span>
                                </button>
                            @endauth
                        </div>
                    </div>

                    <!-- Formulario Admin para guardar nuevas palabras en la BD (/garden-notes) -->
                    @auth
                        <form class="adrian-note-creator-form" id="adrian-note-creator-form" hidden>
                            <div class="adrian-form-top">
                                <h3>✍️ Inscribir Nueva Palabra de Adrián para Carla Lorena</h3>
                                <p>Se guardará permanentemente en la Biblioteca de Palabras de este Jardín.</p>
                            </div>
                            <div class="adrian-form-grid">
                                <label class="adrian-field">
                                    <span>Título de la Dedicatoria</span>
                                    <input type="text" name="title" id="adrian-note-title" required maxlength="140" placeholder="Ej: Para tu sonrisa al despertar">
                                </label>
                                <label class="adrian-field">
                                    <span>Categoría / Sentimiento</span>
                                    <select name="mood" id="adrian-note-mood">
                                        <option value="love">💖 Amor Eterno</option>
                                        <option value="gratitude">👑 Admiración &amp; Orgullo</option>
                                        <option value="hope">💍 Promesas del Corazón</option>
                                        <option value="joy">☀️ Buenos Días, Princesa</option>
                                        <option value="calm">🌿 Refugio &amp; Calma</option>
                                    </select>
                                </label>
                                <label class="adrian-field">
                                    <span>Firma</span>
                                    <input type="text" name="author_name" id="adrian-note-author" value="Adrián para mi amada Carla Lorena" maxlength="100">
                                </label>
                            </div>
                            <label class="adrian-field">
                                <span>Palabras expresadas para Carla Lorena</span>
                                <textarea name="content" id="adrian-note-content" rows="3" required maxlength="3000" placeholder="Escribe aquí las palabras que quedarán grabadas en la biblioteca de su jardín..."></textarea>
                            </label>
                            <div class="adrian-form-actions">
                                <button type="button" class="button button-outline button-sm" id="btn-cancel-adrian-note">Cancelar</button>
                                <button type="submit" class="button button-primary button-sm" id="btn-submit-adrian-note">💌 Guardar en la Biblioteca de Carla</button>
                            </div>
                        </form>
                    @endauth

                    <!-- Filtros de la Biblioteca de Palabras -->
                    <div class="adrian-library-filter-pills" id="adrian-library-filter-pills" role="tablist" aria-label="Categorías de la biblioteca de palabras">
                        <button type="button" class="adrian-lib-pill is-active" data-lib-filter="all">✨ Todas las Palabras</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="love">💖 Amor Eterno</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="gratitude">👑 Admiración</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="hope">💍 Promesas</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="joy">☀️ Buenos Días</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="calm">🌿 Refugio &amp; Calma</button>
                        <button type="button" class="adrian-lib-pill" data-lib-filter="fav">⭐ Mis Favoritas</button>
                    </div>

                    <!-- Grilla Dinámica de Tarjetas de Palabras Expresadas -->
                    <div class="adrian-words-grid" id="adrian-words-grid" aria-live="polite">
                        <!-- Renderizado dinámicamente por initGardenSanctuaryExperience() combinando la colección curada de Adrián + notas en BD -->
                    </div>
                </div>

                <div class="garden-quote-box">
                    <span class="quote-flower-mark">❦</span>
                    <blockquote>«Que tu día florezca tan bonito, sereno y lleno de vida como este jardín que nació pensando en ti.»</blockquote>
                    <cite>— Dedicado con todo mi amor por Adrián para mi amada princesa Carla Lorena</cite>
                </div>
            </div>

            <!-- Modal interactivo enriquecido para fichas y cartas de flores -->
            <dialog class="flower-modal" id="flower-modal" aria-labelledby="flower-modal-title">
                <div class="flower-modal-box">
                    <button class="flower-modal-close" type="button" aria-label="Cerrar dedicatoria">✕</button>
                    <span class="flower-modal-icon" aria-hidden="true">🌸</span>
                    <span class="flower-modal-badge" id="flower-modal-symbol">Simbolismo</span>
                    <h2 id="flower-modal-title">Nombre de la Flor</h2>
                    <p class="flower-modal-latin" id="flower-modal-latin">Nombre científico</p>

                    <div class="flower-modal-meta-grid">
                        <div class="flower-modal-meta-item">
                            <span class="meta-kicker">📍 Origen Botánico</span>
                            <strong id="flower-modal-origin">Valle Imperial</strong>
                        </div>
                        <div class="flower-modal-meta-item">
                            <span class="meta-kicker">🌸 Notas de Fragancia</span>
                            <strong id="flower-modal-fragrance">Rocío y pétalos</strong>
                        </div>
                    </div>

                    <p class="flower-modal-text" id="flower-modal-dedication">Mensaje dedicado</p>

                    <div class="flower-modal-adrian-box">
                        <span class="adrian-box-kicker">💌 DE ADRIÁN PARA CARLA CON MUCHO AMOR</span>
                        <blockquote id="flower-modal-adrian">«De Adrián para mi amada Carla Lorena con mucho amor...»</blockquote>
                    </div>

                    <p class="flower-modal-secret" id="flower-modal-secret">✨ Secreto botánico del corazón.</p>

                    <div class="flower-modal-actions-row">
                        <button class="button button-outline button-sm" type="button" id="flower-modal-water-btn">💧 Regar con Rocío de Luz</button>
                        <button class="button button-primary button-sm flower-modal-btn" type="button">Guardar este sentimiento ✿</button>
                    </div>
                </div>
            </dialog>
            <canvas class="garden-petals-canvas" id="garden-petals-canvas" aria-hidden="true"></canvas>
        </section>
