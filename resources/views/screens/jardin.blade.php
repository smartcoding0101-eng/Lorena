        <section class="screen" data-screen="jardin" aria-labelledby="garden-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>

                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Santuario botánico personal</p>
                        <h1 id="garden-title">El jardín de <em>Carla Lorena</em></h1>
                        <p>Un espacio donde cada flor cuenta una historia, transmite calma y florece a tu ritmo.</p>
                    </div>
                    <span class="heading-mark" aria-hidden="true">❀</span>
                </div>

                <div class="botanical-hero-card">
                    <div class="botanical-hero-content">
                        <span class="eyebrow">AROMA A FLORES SILVESTRES</span>
                        <h2>Un rincón para soñar despierta</h2>
                        <p>Diseñado con delicadeza, tonos suaves y flores que invitan a la calma. Toca cualquier rincón para descubrir su significado y sentir la serenidad del jardín.</p>
                        <div class="botanical-hero-tags">
                            <span class="flower-pill">🌸 Peonía Serena</span>
                            <span class="flower-pill">🌹 Rosa Dulce</span>
                            <span class="flower-pill">🌿 Menta Silvestre</span>
                            <span class="flower-pill">🌼 Camomila</span>
                        </div>
                    </div>
                </div>

                <div class="garden-friends-medallion-banner">
                    <div class="friends-medallion-badge">
                        <span class="friends-badge-icon">💌</span>
                        <span class="friends-badge-ring"></span>
                    </div>
                    <div class="friends-medallion-info">
                        <span class="eyebrow">EL MEDALLÓN DE AMIGOS · VOCES DEL CORAZÓN</span>
                        <h3>Dedicatorias de Amigos</h3>
                        <p>Un espacio donde quienes te quieren dejan plasmado todo lo que piensan de ti, con cariño sincero y buenos deseos.</p>
                    </div>
                    <a href="#amigos" data-go="amigos" class="button button-primary friends-medallion-cta">
                        <span>Ver y dedicar mensajes</span> <span>↗</span>
                    </a>
                </div>

                <div class="garden-interactive-ambient">
                    <div class="ambient-controls-bar">
                        <span class="ambient-label">🍃 Atmósfera del Jardín:</span>
                        <button class="button button-outline button-sm" type="button" data-garden-ambient="breeze" aria-pressed="false">
                            <span>🌬️</span> Brisa Serena
                        </button>
                        <button class="button button-outline button-sm" type="button" data-garden-ambient="birds" aria-pressed="false">
                            <span>🕊️</span> Canto de Aves
                        </button>
                        <button class="button button-outline button-sm" type="button" data-garden-ambient="petals" aria-pressed="true">
                            <span>🌸</span> Lluvia de Pétalos
                        </button>
                    </div>
                </div>

                <!-- Jardín Virtual Real: Escenario Botánico Interactivo -->
                <div class="virtual-garden-stage" id="virtual-garden-stage">
                    <div class="garden-stage-header">
                        <div class="garden-stage-title">
                            <span class="eyebrow">PARTERRE BOTÁNICO VIVO</span>
                            <h2>Jardín Botánico Real de Carla</h2>
                            <p>Flores orgánicas en constante floración. Toca cada espécimen para sentir su fragancia virtual y descubrir su mensaje íntimo.</p>
                        </div>
                        <div class="garden-stage-actions">
                            <span class="flower-pill">🌹 Rosa Damascena</span>
                            <span class="flower-pill">🌻 Girasol Dorado</span>
                            <span class="flower-pill">🌷 Tulipán Holandés</span>
                            <span class="flower-pill">🪻 Lavanda Provence</span>
                        </div>
                    </div>

                    <div class="garden-interactive-bed">
                        <!-- 1. Rosa Damascena Real -->
                        <article class="real-flower-card" tabindex="0" role="button" 
                            data-flower-name="Rosa Damascena Real" 
                            data-flower-symbol="Amor Genuino, Nobleza y Fuerza Serena" 
                            data-flower-dedication="Para Carla Lorena: La rosa no compite con ninguna otra flor; florece con autenticidad, elegancia insuperable y una fragancia que perdura en el tiempo. Que tu vida tenga siempre esa misma fuerza dulce." 
                            data-flower-icon="🌹">
                            <div class="real-flower-visual">
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
                                            <stop offset="0%" stop-color="#4e8d5e"/>
                                            <stop offset="100%" stop-color="#2d5737"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Tallo y Hojas -->
                                    <path d="M50 68 C50 78 52 88 51 98" stroke="url(#roseStem)" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M49 76 C41 73 34 77 31 82 C37 83 44 80 49 76Z" fill="#4e8d5e"/>
                                    <path d="M51 82 C59 79 66 82 69 88 C63 89 56 86 51 82Z" fill="#3f754c"/>
                                    <!-- Pétalos Exteriores -->
                                    <path d="M30 46 C24 35 38 24 50 30 C62 24 76 35 70 46 C64 58 36 58 30 46Z" fill="url(#roseGlow)" opacity="0.95"/>
                                    <path d="M24 50 C22 40 32 32 44 34 C42 46 32 56 24 50Z" fill="url(#roseGlow)"/>
                                    <path d="M76 50 C78 40 68 32 56 34 C58 46 68 56 76 50Z" fill="url(#roseGlow)"/>
                                    <path d="M33 55 C27 64 45 72 50 68 C55 72 73 64 67 55 C60 62 40 62 33 55Z" fill="#c0264b"/>
                                    <!-- Corazón de Rosa -->
                                    <circle cx="50" cy="46" r="13" fill="url(#roseCore)"/>
                                    <path d="M45 42 C48 39 53 39 55 43 C57 47 52 50 49 48 C46 46 46 44 49 43" stroke="#fff" stroke-width="1.2" stroke-linecap="round" opacity="0.75"/>
                                </svg>
                            </div>
                            <span class="real-flower-badge badge-rose">Rosaceae · Reina Floral</span>
                            <h3>Rosa Damascena</h3>
                            <span class="real-flower-latin">Rosa × damascena</span>
                            <p class="real-flower-desc">«Pétalos aterciopelados con fragancia noble. El símbolo inmortal del amor más sincero, gratitud y devoción.»</p>
                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Nobleza & Ternura</span>
                                <span class="real-flower-trigger">Tocar dedicatoria ↗</span>
                            </div>
                        </article>

                        <!-- 2. Girasol Dorado Silvestre -->
                        <article class="real-flower-card" tabindex="0" role="button" 
                            data-flower-name="Girasol Dorado" 
                            data-flower-symbol="Energía Radiante, Admiración y Optimismo" 
                            data-flower-dedication="Carla Lorena: Eres como el girasol, que siempre busca la luz y tiene la facultad maravillosa de alegrar e iluminar el día de cualquiera con tan solo una sonrisa sincera." 
                            data-flower-icon="🌻">
                            <div class="real-flower-visual">
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
                                    <!-- Tallo -->
                                    <path d="M50 65 L50 98" stroke="#4a7c59" stroke-width="4.5" stroke-linecap="round"/>
                                    <path d="M49 78 C39 74 34 82 28 84 C36 88 45 84 49 78Z" fill="#3e684a"/>
                                    <path d="M51 84 C61 80 66 88 72 90 C64 94 55 90 51 84Z" fill="#4a7c59"/>
                                    <!-- Corona de Pétalos (8 pétalos angulares) -->
                                    <path d="M50 16 L54 36 L50 40 L46 36 Z" fill="url(#sunPetal)"/>
                                    <path d="M50 74 L54 54 L50 50 L46 54 Z" fill="url(#sunPetal)"/>
                                    <path d="M21 45 L41 49 L45 45 L41 41 Z" fill="url(#sunPetal)"/>
                                    <path d="M79 45 L59 49 L55 45 L59 41 Z" fill="url(#sunPetal)"/>
                                    <path d="M29 24 L45 39 L42 42 L38 39 Z" fill="url(#sunPetal)"/>
                                    <path d="M71 66 L55 51 L58 48 L62 51 Z" fill="url(#sunPetal)"/>
                                    <path d="M71 24 L55 39 L58 42 L62 39 Z" fill="url(#sunPetal)"/>
                                    <path d="M29 66 L45 51 L42 48 L38 51 Z" fill="url(#sunPetal)"/>
                                    <!-- Corona de pétalos intermedios -->
                                    <path d="M40 18 L48 37 L44 38 Z" fill="#fbbf24"/>
                                    <path d="M60 18 L52 37 L56 38 Z" fill="#fbbf24"/>
                                    <path d="M77 34 L58 43 L60 47 Z" fill="#fbbf24"/>
                                    <path d="M77 56 L58 47 L60 43 Z" fill="#fbbf24"/>
                                    <path d="M40 72 L48 53 L44 52 Z" fill="#fbbf24"/>
                                    <path d="M60 72 L52 53 L56 52 Z" fill="#fbbf24"/>
                                    <path d="M23 56 L42 47 L40 43 Z" fill="#fbbf24"/>
                                    <path d="M23 34 L42 43 L40 47 Z" fill="#fbbf24"/>
                                    <!-- Centro del Girasol -->
                                    <circle cx="50" cy="45" r="14" fill="url(#sunSeed)"/>
                                    <circle cx="50" cy="45" r="13" stroke="#fef08a" stroke-width="0.8" stroke-dasharray="2 3" opacity="0.6"/>
                                    <circle cx="50" cy="45" r="8" stroke="#f59e0b" stroke-width="0.6" stroke-dasharray="1.5 2" opacity="0.7"/>
                                </svg>
                            </div>
                            <span class="real-flower-badge badge-sunflower">Asteraceae · Faro de Luz</span>
                            <h3>Girasol Dorado</h3>
                            <span class="real-flower-latin">Helianthus annuus</span>
                            <p class="real-flower-desc">«Corola radiante que baila siguiendo los rayos del sol. Representa vitalidad pura, calidez y lealtad incondicional.»</p>
                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Felicidad & Luz</span>
                                <span class="real-flower-trigger">Tocar dedicatoria ↗</span>
                            </div>
                        </article>

                        <!-- 3. Tulipán Imperial Rosado -->
                        <article class="real-flower-card" tabindex="0" role="button" 
                            data-flower-name="Tulipán Imperial" 
                            data-flower-symbol="Gracia, Renacer y Perfección Femenina" 
                            data-flower-dedication="Carla Lorena: Cada primavera trae consigo el renacimiento de lo bello. El tulipán simboliza tus nuevos comienzos y esa elegancia natural que no necesita presumir para cautivar." 
                            data-flower-icon="🌷">
                            <div class="real-flower-visual">
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
                                    <!-- Tallo esbelto -->
                                    <path d="M50 56 C50 72 49 84 50 98" stroke="#48815b" stroke-width="3.5" stroke-linecap="round"/>
                                    <!-- Hojas grandes estilizadas de tulipán -->
                                    <path d="M48 94 C34 88 24 64 28 46 C35 58 45 78 48 94Z" fill="#589a6f"/>
                                    <path d="M52 94 C66 88 74 68 70 52 C65 64 55 80 52 94Z" fill="#3f7351"/>
                                    <!-- Cáliz del Tulipán -->
                                    <path d="M33 34 C30 46 36 60 50 60 C40 56 36 44 38 32 C35 32 34 33 33 34Z" fill="url(#tulipSide)"/>
                                    <path d="M67 34 C70 46 64 60 50 60 C60 56 64 44 62 32 C65 32 66 33 67 34Z" fill="url(#tulipSide)"/>
                                    <!-- Pétalo central copa -->
                                    <path d="M37 32 C43 20 57 20 63 32 C67 48 57 60 50 60 C43 60 33 48 37 32Z" fill="url(#tulipPetal)"/>
                                    <!-- Destello de pétalo interno -->
                                    <path d="M47 26 C49 22 51 22 53 26 C54 34 52 38 50 40 C48 38 46 34 47 26Z" fill="#ffffff" opacity="0.9"/>
                                </svg>
                            </div>
                            <span class="real-flower-badge badge-tulip">Liliaceae · Copa de Gracia</span>
                            <h3>Tulipán Imperial</h3>
                            <span class="real-flower-latin">Tulipa gesneriana</span>
                            <p class="real-flower-desc">«Silueta impecable que florece con los primeros cantos primaverales. Representa la finura, el cariño verdadero y el renacer continuo.»</p>
                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Elegancia & Renacer</span>
                                <span class="real-flower-trigger">Tocar dedicatoria ↗</span>
                            </div>
                        </article>

                        <!-- 4. Lavanda Provence Silvestre -->
                        <article class="real-flower-card" tabindex="0" role="button" 
                            data-flower-name="Lavanda de Grasse" 
                            data-flower-symbol="Serenidad, Calma Espiritual y Protección" 
                            data-flower-dedication="Que en medio de cualquier tormenta del mundo exterior, encuentres en este jardín un oasis de calma absoluta, donde el aroma a lavanda te recuerde que todo tiene su momento de serenidad." 
                            data-flower-icon="🪻">
                            <div class="real-flower-visual">
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Lavanda Silvestre">
                                    <defs>
                                        <linearGradient id="lavenderStem" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#5a8b66"/>
                                            <stop offset="100%" stop-color="#345c3e"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Tallos -->
                                    <path d="M50 30 L50 96" stroke="url(#lavenderStem)" stroke-width="2.5" stroke-linecap="round"/>
                                    <path d="M40 45 L40 94" stroke="url(#lavenderStem)" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M60 48 L60 94" stroke="url(#lavenderStem)" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Espigas de flor lavanda central -->
                                    <ellipse cx="50" cy="24" rx="4" ry="5.5" fill="#a855f7"/>
                                    <ellipse cx="46" cy="30" rx="3.5" ry="4.5" fill="#c084fc"/>
                                    <ellipse cx="54" cy="30" rx="3.5" ry="4.5" fill="#9333ea"/>
                                    <ellipse cx="45" cy="37" rx="4" ry="5" fill="#7e22ce"/>
                                    <ellipse cx="55" cy="37" rx="4" ry="5" fill="#c084fc"/>
                                    <ellipse cx="46" cy="45" rx="3.5" ry="4.5" fill="#a855f7"/>
                                    <ellipse cx="54" cy="45" rx="3.5" ry="4.5" fill="#7e22ce"/>
                                    <ellipse cx="50" cy="52" rx="3.5" ry="4" fill="#9333ea"/>
                                    <!-- Espigas laterales izquierda -->
                                    <ellipse cx="40" cy="40" rx="3" ry="4" fill="#c084fc"/>
                                    <ellipse cx="37" cy="46" rx="3" ry="3.5" fill="#a855f7"/>
                                    <ellipse cx="43" cy="47" rx="3" ry="3.5" fill="#7e22ce"/>
                                    <ellipse cx="40" cy="54" rx="3" ry="3.5" fill="#9333ea"/>
                                    <!-- Espigas laterales derecha -->
                                    <ellipse cx="60" cy="43" rx="3" ry="4" fill="#c084fc"/>
                                    <ellipse cx="57" cy="49" rx="3" ry="3.5" fill="#7e22ce"/>
                                    <ellipse cx="63" cy="50" rx="3" ry="3.5" fill="#a855f7"/>
                                    <ellipse cx="60" cy="57" rx="3" ry="3.5" fill="#9333ea"/>
                                </svg>
                            </div>
                            <span class="real-flower-badge badge-lavender">Lamiaceae · Esencia de Calma</span>
                            <h3>Lavanda de Grasse</h3>
                            <span class="real-flower-latin">Lavandula angustifolia</span>
                            <p class="real-flower-desc">«Espigas violetas aromáticas mecidas por el viento. Concede serenidad al corazón, paz mental y un sueño reparador.»</p>
                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Paz & Silencio Dulce</span>
                                <span class="real-flower-trigger">Tocar dedicatoria ↗</span>
                            </div>
                        </article>

                        <!-- 5. Peonía Real de Seda -->
                        <article class="real-flower-card" tabindex="0" role="button" 
                            data-flower-name="Peonía Real de Seda" 
                            data-flower-symbol="Felicidad Plena, Fortuna y Delicadeza" 
                            data-flower-dedication="Carla Lorena: La peonía florece con paciencia para revelar capas infinitas de dulzura. Que todos tus sueños se abran paso con esa misma belleza y prosperidad." 
                            data-flower-icon="🌸">
                            <div class="real-flower-visual">
                                <svg class="real-flower-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Peonía de Seda">
                                    <defs>
                                        <radialGradient id="peonyGlow" cx="50%" cy="50%" r="50%">
                                            <stop offset="0%" stop-color="#ffffff"/>
                                            <stop offset="40%" stop-color="#fee2e2"/>
                                            <stop offset="85%" stop-color="#ef4444"/>
                                            <stop offset="100%" stop-color="#991b1b"/>
                                        </radialGradient>
                                    </defs>
                                    <path d="M50 72 L50 98" stroke="#3b6946" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M49 82 C38 78 30 84 25 88 C34 91 44 88 49 82Z" fill="#4d835b"/>
                                    <path d="M51 86 C62 82 70 88 75 92 C66 95 56 92 51 86Z" fill="#3b6946"/>
                                    <!-- Ondulaciones de pétalos sedosos -->
                                    <circle cx="50" cy="46" r="26" fill="url(#peonyGlow)" opacity="0.9"/>
                                    <path d="M30 40 C28 28 42 22 52 26 C64 20 74 30 70 42 C74 54 62 66 48 64 C34 66 26 52 30 40Z" fill="#fee2e2" opacity="0.6"/>
                                    <path d="M36 44 C34 36 44 32 50 36 C56 32 66 36 64 44 C66 52 58 58 50 56 C42 58 34 52 36 44Z" fill="#ef4444"/>
                                    <circle cx="50" cy="46" r="8" fill="#ffffff"/>
                                    <circle cx="50" cy="46" r="4" fill="#dc2626"/>
                                </svg>
                            </div>
                            <span class="real-flower-badge badge-peony">Paeoniaceae · Flor del Honor</span>
                            <h3>Peonía de Seda</h3>
                            <span class="real-flower-latin">Paeonia lactiflora</span>
                            <p class="real-flower-desc">«Centenares de velos rosados que se abren con suntuosa gracia. El amuleto tradicional de la felicidad duradera y el cariño noble.»</p>
                            <div class="real-flower-footer">
                                <span class="real-flower-symbol">Ternura & Dicha</span>
                                <span class="real-flower-trigger">Tocar dedicatoria ↗</span>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="garden-quote-box">
                    <span class="quote-flower-mark">❦</span>
                    <blockquote>«Que tu día florezca tan bonito, sereno y lleno de vida como este jardín.»</blockquote>
                    <cite>— Dedicado con todo el cariño para Carla Lorena</cite>
                </div>
            </div>

            <!-- Modal interactivo para dedicatorias de flores -->
            <dialog class="flower-modal" id="flower-modal" aria-labelledby="flower-modal-title">
                <div class="flower-modal-box">
                    <button class="flower-modal-close" type="button" aria-label="Cerrar dedicatoria">✕</button>
                    <span class="flower-modal-icon" aria-hidden="true">🌸</span>
                    <span class="flower-modal-badge" id="flower-modal-symbol">Simbolismo</span>
                    <h2 id="flower-modal-title">Nombre de la Flor</h2>
                    <p class="flower-modal-text" id="flower-modal-dedication">Mensaje dedicado</p>
                    <button class="button button-primary button-sm flower-modal-btn" type="button">Guardar este sentimiento ✿</button>
                </div>
            </dialog>
            <canvas class="garden-petals-canvas" id="garden-petals-canvas" aria-hidden="true"></canvas>
        </section>
