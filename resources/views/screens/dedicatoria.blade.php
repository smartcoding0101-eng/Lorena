        <section class="screen dedication-screen" data-screen="dedicatoria" id="screen-dedicatoria" aria-labelledby="dedication-title" hidden>
            <div class="page-shell dedication-shell">

                <!-- 1. Barra de Navegación & Acciones de Lujo -->
                <header class="dedication-nav-bar">
                    <div class="dedication-nav-left">
                        <a class="dedication-nav-btn back-map" href="#mapa" data-go="mapa" title="Volver al Mapa del Jardín Secreto">
                            <span class="nav-icon" aria-hidden="true">🗺️</span>
                            <span>Volver al Mapa</span>
                        </a>
                        <span class="nav-separator" aria-hidden="true">/</span>
                        <span class="dedication-biome-badge">
                            <span class="biome-dot"></span> Rosaleda Imperial · Rubí Real
                        </span>
                    </div>

                    <div class="dedication-nav-actions">
                        <button type="button" class="dedication-tool-btn btn-candlelight" id="btn-dedication-candlelight" title="Encender velas & luciérnagas">
                            <span class="tool-icon">🕯️</span>
                            <span class="tool-label">Luz de Velas</span>
                        </button>

                        <button type="button" class="dedication-tool-btn btn-music-chime" id="btn-dedication-audio" title="Escuchar arpegio de campanas y arpa">
                            <span class="tool-icon">🎵</span>
                            <span class="tool-label">Melodía</span>
                        </button>

                        <button type="button" class="dedication-tool-btn btn-rose-storm" id="btn-dedication-petals-storm" title="Ráfaga de pétalos para Carla">
                            <span class="tool-icon">🌹</span>
                            <span class="tool-label">Lluvia de Rosas</span>
                        </button>

                        <a class="dedication-nav-btn home-link" href="{{ route('home') }}#inicio" data-go="inicio" title="Ir al Inicio">
                            <span class="nav-icon" aria-hidden="true">🌸</span>
                            <span>Inicio</span>
                        </a>
                    </div>
                </header>

                <!-- 2. Encabezado Solemne de la Pantalla -->
                <div class="dedication-header-hero">
                    <div class="dedication-hero-content">
                        <div class="dedication-royal-eyebrow">
                            <span class="eyebrow-icon">👑</span>
                            <span>ROSALEDA IMPERIAL · PÉTALO DE RUBÍ REAL · SANTUARIO DE AMOR</span>
                        </div>
                        <h1 id="dedication-title" class="dedication-main-title">
                            Dedicatorias · <em>Mensajes escritos con el corazón</em>
                        </h1>
                        <p class="dedication-hero-subtitle">
                            Las palabras más sinceras nacen del alma. Este rincón fue esculpido con devoción para recordarte lo inmensamente especial, admirada y amada que eres en cada latido, Carla Lorena.
                        </p>

                        <!-- Badges de Prestigio y Cariño -->
                        <div class="dedication-prestige-badges">
                            <div class="prestige-badge">
                                <span class="badge-icon">💌</span>
                                <div class="badge-texts">
                                    <strong>Dedicado a</strong>
                                    <span>Carla Lorena</span>
                                </div>
                            </div>
                            <div class="prestige-badge">
                                <span class="badge-icon">✍️</span>
                                <div class="badge-texts">
                                    <strong>Autor de corazón</strong>
                                    <span>Julio Adrián</span>
                                </div>
                            </div>
                            <div class="prestige-badge">
                                <span class="badge-icon">🌹</span>
                                <div class="badge-texts">
                                    <strong>Sentimiento</strong>
                                    <span>Amor Eterno & Devoción</span>
                                </div>
                            </div>
                            <div class="prestige-badge">
                                <span class="badge-icon">✨</span>
                                <div class="badge-texts">
                                    <strong>Esencia</strong>
                                    <span>Sinceridad y Dulzura</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Barra de Filtro / Navegación Rápida por Secciones -->
                <nav class="dedication-tab-nav" aria-label="Navegación de secciones de dedicatoria">
                    <button type="button" class="dedication-tab-btn is-active" data-dedication-tab="all">
                        <span>🌟</span> Toda la Experiencia
                    </button>
                    <button type="button" class="dedication-tab-btn" data-dedication-tab="carta">
                        <span>📜</span> Gran Pergamino
                    </button>
                    <button type="button" class="dedication-tab-btn" data-dedication-tab="promesas">
                        <span>💎</span> 4 Promesas Eternas
                    </button>
                    <button type="button" class="dedication-tab-btn" data-dedication-tab="capitulos">
                        <span>🕰️</span> Línea del Corazón
                    </button>
                    <button type="button" class="dedication-tab-btn" data-dedication-tab="sobres">
                        <span>💌</span> Cartas de Ocasión
                    </button>
                    <button type="button" class="dedication-tab-btn" data-dedication-tab="rosas">
                        <span>🌹</span> Ofrenda de Rosas
                    </button>
                </nav>

                <!-- 4. SECCIÓN I: GRAN CARTA PERGAMINO PRINCIPAL -->
                <section class="dedication-section-block" id="dedication-block-carta" data-section-category="carta">
                    <div class="dedication-hero-pergamino">
                        <!-- Marco ornamental de esquinas -->
                        <div class="pergamino-corner-ornament top-left" aria-hidden="true">❦</div>
                        <div class="pergamino-corner-ornament top-right" aria-hidden="true">❦</div>
                        <div class="pergamino-corner-ornament bottom-left" aria-hidden="true">❦</div>
                        <div class="pergamino-corner-ornament bottom-right" aria-hidden="true">❦</div>

                        <div class="pergamino-header-row">
                            <div class="pergamino-royal-stamp">
                                <span class="stamp-icon">👑</span>
                                <span class="stamp-text">PARA CARLA LORENA · ETERNAMENTE</span>
                            </div>

                            <div class="pergamino-interactive-seal" id="interactive-wax-seal" title="Toca el sello de lacre para sentir su latido" tabindex="0" role="button" aria-label="Sello de lacre C y A">
                                <div class="wax-seal-outer">
                                    <div class="wax-seal-inner">
                                        <span class="seal-monogram">C❦A</span>
                                        <span class="seal-rose">🌹</span>
                                    </div>
                                </div>
                                <span class="seal-tooltip-hint">Toca el sello</span>
                            </div>
                        </div>

                        <div class="dedication-body">
                            <h2 class="dedication-subtitle">«A la persona que ilumina cada uno de mis días»</h2>

                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦ 🌹 ❦</span>
                                <span class="divider-line"></span>
                            </div>

                            <div class="dedication-text-content">
                                <p class="dedication-lead">
                                    <span class="dropcap-letter">L</span>orena, construir este jardín es la forma más pura que encontré para plasmar en el mundo digital todo lo que despiertas en mí: amor, pasión, confianza, ternura y sobre todo sinceridad y una alegría que renueva cada instante.
                                </p>

                                <p>
                                    Hay presencias que simplemente hacen que la vida sea más hermosa. Tu forma de ver el mundo, tu carácter noble y dulce, la sencillez de tu personalidad y la manera mágica en la que me enamoraste hacen que todo a tu alrededor florezca con una luz única y radiante.
                                </p>

                                <blockquote class="dedication-quote-box">
                                    <span class="quote-mark-open" aria-hidden="true">“</span>
                                    <p class="quote-text">
                                        «Si el mundo a veces va demasiado deprisa, deseo que este pequeño jardín sea siempre tu refugio: un lugar donde recuerdes tu infinito valor y sepas que siempre hay alguien que piensa en ti con el más tierno, leal y profundo de los cariños.»
                                    </p>
                                    <span class="quote-mark-close" aria-hidden="true">”</span>
                                </blockquote>

                                <p>
                                    Gracias por existir, por compartir tu luz conmigo y por inspirar cada rincón de este espacio. Cada flor, cada verso, cada melodía y cada detalle llevan grabada tu esencia. No hay distancia ni tiempo que logre apagar lo que significas para mí: eres mi inspiración y mi mayor bendición.
                                </p>
                            </div>

                            <div class="dedication-signature-block">
                                <div class="signature-line">
                                    <span class="sig-seal" aria-hidden="true">♡</span>
                                    <div class="sig-names">
                                        <strong>Con todo mi amor y cariño para mi vida, la mujer que amo:</strong>
                                        <span>Tu Ingeniero Julio Adrián</span>
                                    </div>
                                </div>

                                <div class="signature-badges">
                                    <span class="badge-floral">❀ Dedicado de corazón</span>
                                    <span class="badge-floral">✧ Para Carla Lorena</span>
                                    <span class="badge-floral">💍 Amor Verdadero</span>
                                </div>
                            </div>

                            <!-- Barra de utilidades del Pergamino -->
                            <div class="pergamino-actions-bar">
                                <button type="button" class="pergamino-act-btn btn-copy-letter" id="btn-copy-dedication-letter">
                                    <span class="act-icon">📋</span>
                                    <span>Guardar / Copiar carta</span>
                                </button>

                                <button type="button" class="pergamino-act-btn btn-candle-reading" id="btn-letter-candlelight">
                                    <span class="act-icon">🕯️</span>
                                    <span>Leer con luz de velas</span>
                                </button>

                                <button type="button" class="pergamino-act-btn btn-listen-chime" id="btn-letter-audio-chime">
                                    <span class="act-icon">🎵</span>
                                    <span>Escuchar arpegio de campanas</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 5. SECCIÓN II: PILARES DE PROMESAS Y SENTIMIENTOS (4 PROMESAS) -->
                <section class="dedication-section-block" id="dedication-block-promesas" data-section-category="promesas">
                    <div class="section-title-wrap">
                        <span class="section-eyebrow">PACTO DE AMOR Y CUIDADO</span>
                        <h2 class="section-heading-h2">Las 4 Promesas Eternas del Jardín</h2>
                        <p class="section-desc">Principios grabados en la roca y en las flores de este santuario, dedicados a tu paz y alegría.</p>
                    </div>

                    <div class="dedication-pillars-grid">
                        <!-- Promesa I -->
                        <article class="pillar-card pillar-promise garden-tilt-card" data-promise="1">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">🌹 ❦</span>
                                <span class="card-number">PROMESA I · CUIDADO</span>
                            </div>
                            <span class="pillar-icon">🌸</span>
                            <h3>Estar a tu lado</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Prometo celebrar cada uno de tus logros, acompañarte en los días grises, sostener tu mano ante cualquier incertidumbre y ser siempre ese apoyo incondicional en el que puedas descansar con total confianza.</p>
                            <span class="card-mini-quote">«Tu felicidad siempre será mi mayor anhelo.»</span>
                            <button type="button" class="pillar-touch-btn" title="Tocar para sellar la promesa">
                                <span>Sellar promesa</span> <span class="heart-pulse">♡</span>
                            </button>
                        </article>

                        <!-- Promesa II -->
                        <article class="pillar-card pillar-admiration garden-tilt-card" data-promise="2">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">✨ ❦</span>
                                <span class="card-number">PROMESA II · ADMIRACIÓN</span>
                            </div>
                            <span class="pillar-icon">👑</span>
                            <h3>Valorar tu esencia</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Admiro profundamente tu autenticidad, la generosidad de tu alma, tu inteligencia y esa magia tan tuya que transforma lo cotidiano en extraordinario. Nunca dejaré de recordarte lo inmensamente valiosa que eres.</p>
                            <span class="card-mini-quote">«Eres única, irrepetible y maravillosa.»</span>
                            <button type="button" class="pillar-touch-btn" title="Tocar para sellar la promesa">
                                <span>Sellar promesa</span> <span class="heart-pulse">♡</span>
                            </button>
                        </article>

                        <!-- Promesa III -->
                        <article class="pillar-card pillar-calm garden-tilt-card" data-promise="3">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">🌿 ❦</span>
                                <span class="card-number">PROMESA III · SERENIDAD</span>
                            </div>
                            <span class="pillar-icon">🕊️</span>
                            <h3>Ser tu remanso de paz</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Que en este rincón encuentres siempre calma, palabras dulces y la certeza de que tu corazón está a salvo, protegido y valorado como el más bello tesoro. Aquí no hay prisas ni juicios, solo cariño.</p>
                            <span class="card-mini-quote">«Aquí el tiempo se detiene para consentirte.»</span>
                            <button type="button" class="pillar-touch-btn" title="Tocar para sellar la promesa">
                                <span>Sellar promesa</span> <span class="heart-pulse">♡</span>
                            </button>
                        </article>

                        <!-- Promesa IV -->
                        <article class="pillar-card pillar-future garden-tilt-card" data-promise="4">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">💫 ❦</span>
                                <span class="card-number">PROMESA IV · PORVENIR</span>
                            </div>
                            <span class="pillar-icon">💍</span>
                            <h3>Construir sueños juntos</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Prometo seguir diseñando momentos inolvidables a tu lado, creer juntos en metas compartidas y cultivar este sentimiento con la paciencia, devoción y ternura con la que florece la mejor de las rosas.</p>
                            <span class="card-mini-quote">«Lo mejor de nuestra historia aún está por escribirse.»</span>
                            <button type="button" class="pillar-touch-btn" title="Tocar para sellar la promesa">
                                <span>Sellar promesa</span> <span class="heart-pulse">♡</span>
                            </button>
                        </article>
                    </div>
                </section>

                <!-- 6. SECCIÓN III: LÍNEA DEL CORAZÓN (CAPÍTULOS POÉTICOS) -->
                <section class="dedication-section-block" id="dedication-block-capitulos" data-section-category="capitulos">
                    <div class="section-title-wrap">
                        <span class="section-eyebrow">EL CAMINO DE NUESTRAS ALMAS</span>
                        <h2 class="section-heading-h2">Los Capítulos de Nuestro Amor</h2>
                        <p class="section-desc">Pequeños hitos que transformaron nuestras miradas en una complicidad eterna.</p>
                    </div>

                    <div class="dedication-timeline">
                        <div class="timeline-step-item">
                            <div class="timeline-badge">
                                <span>I</span>
                            </div>
                            <div class="timeline-card">
                                <div class="timeline-meta">
                                    <span class="timeline-tag">El Primer Destello</span>
                                    <span class="timeline-icon">✨</span>
                                </div>
                                <h3>Cuando todo comenzó a iluminarse</h3>
                                <p>Aquel instante en que nuestras palabras se cruzaron y sentí, con una certeza inexplicable en el pecho, que había encontrado un alma pura, inteligente y dulce como ninguna otra.</p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-badge">
                                <span>II</span>
                            </div>
                            <div class="timeline-card">
                                <div class="timeline-meta">
                                    <span class="timeline-tag">La Complicidad</span>
                                    <span class="timeline-icon">☕</span>
                                </div>
                                <h3>Risas y confidencias que sanan</h3>
                                <p>Las charlas que se extendían sin que importara la hora, los detalles compartidos, la ternura al escucharnos y la maravillosa sensación de poder ser nosotros mismos con total libertad.</p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-badge">
                                <span>III</span>
                            </div>
                            <div class="timeline-card">
                                <div class="timeline-meta">
                                    <span class="timeline-tag">La Creación del Jardín</span>
                                    <span class="timeline-icon">🌹</span>
                                </div>
                                <h3>Un refugio digital hecho con devoción</h3>
                                <p>Cada línea de código, cada armonía sonora, cada pétalo y cada santuario de este espacio fueron programados pensando únicamente en ti, para dibujarte una sonrisa cada vez que entres.</p>
                            </div>
                        </div>

                        <div class="timeline-step-item">
                            <div class="timeline-badge">
                                <span>IV</span>
                            </div>
                            <div class="timeline-card">
                                <div class="timeline-meta">
                                    <span class="timeline-tag">El Presente y Mañana</span>
                                    <span class="timeline-icon">🕊️</span>
                                </div>
                                <h3>Caminar tomados de la mano</h3>
                                <p>La certeza de que no importa el camino ni los retos que se presenten: a tu lado cualquier sendero se vuelve floreciente, luminoso y lleno de un amor sin final.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 7. SECCIÓN IV: SOBRES DE OCASIÓN (CARTAS SECRETAS ABRIBLES) -->
                <section class="dedication-section-block" id="dedication-block-sobres" data-section-category="sobres">
                    <div class="section-title-wrap">
                        <span class="section-eyebrow">PALABRAS PARA CUANDO LAS NECESITES</span>
                        <h2 class="section-heading-h2">Cartas de Amor para Cada Ocasión</h2>
                        <p class="section-desc">Toca cada sobre para desatar su lazo y leer el mensaje íntimo guardado para ti.</p>
                    </div>

                    <div class="dedication-letters-grid">
                        <!-- Carta 1 -->
                        <article class="dedication-letter-envelope" data-envelope="1">
                            <header class="envelope-header">
                                <span class="envelope-mood-icon">🌙</span>
                                <div>
                                    <span class="envelope-tag">Para la noche</span>
                                    <h3 class="envelope-title">Si te cuesta conciliar el sueño</h3>
                                </div>
                            </header>
                            <p class="envelope-teaser">Un susurro de tranquilidad antes de cerrar los ojos...</p>
                            <button type="button" class="envelope-toggle-btn" aria-expanded="false">
                                <span class="wax-dot">❦</span>
                                <span class="btn-text">Abrir carta</span>
                            </button>
                            <div class="envelope-unfolded-content" hidden>
                                <p class="letter-body-p">«Mi vida, si la noche se hace larga o tus pensamientos no se detienen, inhala hondo y suelta toda carga. Cierra los ojos con la certeza de que estás cuidada, que no estás sola y que en mi corazón habitas con la ternura más dulce. Que las estrellas velen tu descanso, mi reina.»</p>
                                <span class="letter-sig">— Con amor, Adrián</span>
                            </div>
                        </article>

                        <!-- Carta 2 -->
                        <article class="dedication-letter-envelope" data-envelope="2">
                            <header class="envelope-header">
                                <span class="envelope-mood-icon">☀️</span>
                                <div>
                                    <span class="envelope-tag">Para celebrar</span>
                                    <h3 class="envelope-title">Cuando sonrías y brilles hoy</h3>
                                </div>
                            </header>
                            <p class="envelope-teaser">Para cuando consigas una meta o tengas un día feliz...</p>
                            <button type="button" class="envelope-toggle-btn" aria-expanded="false">
                                <span class="wax-dot">❦</span>
                                <span class="btn-text">Abrir carta</span>
                            </button>
                            <div class="envelope-unfolded-content" hidden>
                                <p class="letter-body-p">«¡Qué orgullo inmenso siento por ti, Lorena! Tu esfuerzo, tu inteligencia y tu nobleza son gigantescos. Ver tu rostro iluminado por la felicidad es la mejor recompensa de mi vida. Sigue brillando, porque el mundo entero es más hermoso con tu sonrisa.»</p>
                                <span class="letter-sig">— Con amor, Adrián</span>
                            </div>
                        </article>

                        <!-- Carta 3 -->
                        <article class="dedication-letter-envelope" data-envelope="3">
                            <header class="envelope-header">
                                <span class="envelope-mood-icon">🌧️</span>
                                <div>
                                    <span class="envelope-tag">Para reconfortar</span>
                                    <h3 class="envelope-title">En un día pesado o gris</h3>
                                </div>
                            </header>
                            <p class="envelope-teaser">Un abrazo cálido a la distancia que te envuelve...</p>
                            <button type="button" class="envelope-toggle-btn" aria-expanded="false">
                                <span class="wax-dot">❦</span>
                                <span class="btn-text">Abrir carta</span>
                            </button>
                            <div class="envelope-unfolded-content" hidden>
                                <p class="letter-body-p">«Respira tranquila, amor mío. Los días difíciles solo son nubes pasajeras que no pueden opacar tu grandeza. No tienes que demostrarle nada al mundo ni llevar todas las cargas sobre tus hombros. Hoy solo descansa: yo estoy aquí para cuidarte y recordarte cuánto vales.»</p>
                                <span class="letter-sig">— Con amor, Adrián</span>
                            </div>
                        </article>

                        <!-- Carta 4 -->
                        <article class="dedication-letter-envelope" data-envelope="4">
                            <header class="envelope-header">
                                <span class="envelope-mood-icon">💖</span>
                                <div>
                                    <span class="envelope-tag">Cualquier día</span>
                                    <h3 class="envelope-title">Solo para recordarte que te amo</h3>
                                </div>
                            </header>
                            <p class="envelope-teaser">Sin fecha especial, porque cada día contigo es un regalo...</p>
                            <button type="button" class="envelope-toggle-btn" aria-expanded="false">
                                <span class="wax-dot">❦</span>
                                <span class="btn-text">Abrir carta</span>
                            </button>
                            <div class="envelope-unfolded-content" hidden>
                                <p class="letter-body-p">«No necesito esperar un aniversario ni una ocasión festiva para decirte lo mucho que te amo. Te amo en los martes corrientes, en las mañanas ocupadas y en los atardeceres en calma. Eres la mujer de mi vida y mi más grande bendición.»</p>
                                <span class="letter-sig">— Con amor, Adrián</span>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- 8. SECCIÓN V: DESEO INTERACTIVO & OFRENDA DE ROSAS INFINITAS -->
                <section class="dedication-section-block" id="dedication-block-rosas" data-section-category="rosas">
                    <div class="dedication-interactive-box">
                        <div class="interactive-sparkle-halo" aria-hidden="true"></div>
                        <div class="interactive-heart-emblem-wrap">
                            <span class="interactive-big-heart" aria-hidden="true">💖</span>
                            <span class="interactive-orbit-rose" aria-hidden="true">🌹</span>
                        </div>

                        <div class="interactive-copy">
                            <span class="interactive-eyebrow">OFRENDA VIVA DE FLORES Y CARIÑO</span>
                            <h3>¿Sientes el latido de estas palabras?</h3>
                            <p>Toca el botón para desatar una ráfaga de pétalos dorados y enviar una flor eterna a este rincón. Cada toque queda grabado para Carla.</p>

                            <div class="interactive-counter-row">
                                <span class="counter-badge">
                                    🌹 Rosas florecidas en este rincón: <strong id="dedication-petals-counter">384</strong>
                                </span>
                                <span class="counter-live-pulse" aria-hidden="true">● En vivo</span>
                            </div>
                        </div>

                        <div class="interactive-cta-group">
                            <button class="button button-primary button-glow button-dedication-spark" type="button" id="dedication-spark-btn">
                                <span>🌹 Dejar florecer una rosa para ti</span> <span aria-hidden="true">✨</span>
                            </button>

                            <button class="button button-outline button-dedication-candle" type="button" id="btn-interactive-candlelight">
                                <span>🕯️ Encender luz de velas</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 9. Cierre Poético y Enlaces a Otros Rincones del Jardín -->
                <footer class="dedication-footer-nav">
                    <div class="footer-quote-box">
                        <span class="footer-rose-icon">❦</span>
                        <p>«El jardín florece porque tú existes, Carla Lorena.»</p>
                    </div>

                    <div class="footer-links-grid">
                        <a class="footer-nav-card" href="#familia" data-go="familia">
                            <span class="card-icon">👨‍👩‍👧‍👦</span>
                            <div>
                                <strong>Santuario Familiar</strong>
                                <small>El espacio íntimo de Carla, Adrián y los niños</small>
                            </div>
                            <span class="arrow">→</span>
                        </a>

                        <a class="footer-nav-card" href="#carla" data-go="carla">
                            <span class="card-icon">👑</span>
                            <div>
                                <strong>Mi Espacio</strong>
                                <small>Tus recuerdos, álbumes y notas</small>
                            </div>
                            <span class="arrow">→</span>
                        </a>

                        <a class="footer-nav-card" href="#mapa" data-go="mapa">
                            <span class="card-icon">🗺️</span>
                            <div>
                                <strong>Mapa del Jardín</strong>
                                <small>Explorar todos los 11 santuarios</small>
                            </div>
                            <span class="arrow">→</span>
                        </a>
                    </div>
                </footer>

            </div>
        </section>
