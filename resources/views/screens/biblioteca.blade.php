        <section class="screen" data-screen="biblioteca" aria-labelledby="library-title" hidden>
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

                <div class="page-heading library-page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge">LITERATURA & CALMA</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge" id="library-daily-date-badge">EDICIÓN DEL DÍA</span>
                        </div>
                        <p class="eyebrow">INSPIRACIÓN · FRASES CÉLEBRES, LECTURAS & REFLEXIONES VIVAS</p>
                        <h1 id="library-title" class="library-crimson-title">Inspiración · <em>Palabras que iluminan el alma</em></h1>
                        <p>Cada día amanece una nueva selección literaria de frases célebres, notas del corazón y versos para enriquecer tu mirada, Carla Lorena. También puedes explorar al azar cuando quieras.</p>
                    </div>
                    <div class="library-heading-actions">
                        <button type="button" class="button button-outline atelier-btn-subtle gallery-explore-albums-btn" id="library-randomize-all-btn" title="Renovar toda la Biblioteca con una selección aleatoria">
                            <span class="atelier-btn-lead-icon" aria-hidden="true">✨</span>
                            <span class="atelier-btn-label">Sorpréndeme hoy</span>
                            <span class="atelier-btn-arrow" aria-hidden="true">↻</span>
                        </button>
                    </div>
                </div>

                <!-- Barra dinámica de temáticas de Frases Célebres -->
                <div class="gallery-toolbar library-dynamic-toolbar" aria-label="Explorar temáticas de frases célebres">
                    <div class="filter-group" role="group" aria-label="Filtrar frases célebres por tema">
                        <button class="filter-chip is-selected" type="button" data-quote-topic="todas" aria-pressed="true">Todas las frases</button>
                        <button class="filter-chip" type="button" data-quote-topic="sabiduria" aria-pressed="false">Vida & Sabiduría</button>
                        <button class="filter-chip" type="button" data-quote-topic="amor" aria-pressed="false">Amor Propio & Luz</button>
                        <button class="filter-chip" type="button" data-quote-topic="literatura" aria-pressed="false">Literatura & Arte</button>
                        <button class="filter-chip" type="button" data-quote-topic="naturaleza" aria-pressed="false">Jardín & Calma</button>
                        <button class="filter-chip" type="button" data-quote-topic="favoritas" aria-pressed="false">♥ Mis Favoritas <span id="library-fav-count">(0)</span></button>
                    </div>
                    <span class="gallery-caption" id="library-edition-status">SELECCIÓN DIARIA AUTOMÁTICA · ROTA CADA 24 HORAS</span>
                </div>

                <div class="library-grid">
                    <!-- Tarjeta 1: Frase Célebre del Día -->
                    <article class="reading-card luxury-card" id="daily-quote-card">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"></path>
                                    <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2 0 4-1 6-1 8z"></path>
                                </svg>
                            </span>
                            <span class="card-number" id="quote-category-badge">FRASE CÉLEBRE DEL DÍA</span>
                        </div>
                        <span class="library-icon" aria-hidden="true">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.18">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </span>
                        <p class="eyebrow" id="quote-eyebrow">CITA INMORTAL SELECCIONADA HOY</p>
                        <h2 class="library-card-red-title" id="quote-title">La belleza de ser auténtica</h2>
                        <div class="blog-card-divider" aria-hidden="true">
                            <span class="divider-line"></span>
                            <span class="divider-rose">❦</span>
                            <span class="divider-line"></span>
                        </div>
                        <blockquote id="quote-text">"La belleza comienza en el instante en que decides ser tú misma."</blockquote>
                        <span class="reading-byline" id="quote-author">— Coco Chanel</span>
                        <span class="card-mini-quote" id="quote-reflection">«Las palabras que te elevan son las que más te pertenecen.»</span>
                        <div class="quote-actions">
                            <div class="quote-action-buttons">
                                <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="next-quote-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                    </svg>
                                    <span>Otra frase célebre</span>
                                </button>
                                <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="fav-quote-btn" aria-pressed="false" title="Guardar en tus frases favoritas">
                                    <span id="fav-quote-icon">♡</span>
                                    <span id="fav-quote-label">Guardar</span>
                                </button>
                                <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="copy-quote-btn" title="Copiar frase célebre">
                                    <span>📋 Copiar</span>
                                </button>
                            </div>
                            <span class="blog-card-seal" aria-hidden="true">❦</span>
                        </div>
                    </article>

                    <!-- Tarjeta 2: Joya Literaria & Sabiduría Clásica del Día -->
                    <article class="music-card luxury-card" id="daily-wisdom-card">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </span>
                            <span class="card-number" id="wisdom-badge">JOYA LITERARIA · PENSAMIENTO DEL DÍA</span>
                        </div>
                        <span class="music-art" aria-hidden="true">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3c-2.5 2-4 4.5-4 7a4 4 0 0 0 8 0c0-2.5-1.5-5-4-7z"></path>
                                <path d="M12 14v8"></path>
                                <path d="M12 18c-2.5 0-4-1.5-4-3.5 2 0 3.5 1 4 3.5z"></path>
                                <path d="M12 17c2.5 0 4-1.5 4-3.5-2 0-3.5 1-4 3.5z"></path>
                            </svg>
                        </span>
                        <div>
                            <p class="eyebrow" id="wisdom-eyebrow">CRÓNICA DE SABIDURÍA & CALMA</p>
                            <h2 class="library-card-red-title" id="wisdom-title">El secreto de las cosas esenciales</h2>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p id="wisdom-body">«He aquí mi secreto, que no puede ser más simple: solo con el corazón se puede ver bien; lo esencial es invisible a los ojos.»</p>
                            <span class="reading-byline" id="wisdom-author">— Antoine de Saint-Exupéry · El Principito</span>
                            <span class="card-mini-quote" id="wisdom-mini">«El tiempo que dedicaste a tu rosa es lo que la hace tan importante.»</span>
                            <div class="music-card-footer">
                                <button class="button button-outline button-sm atelier-btn-subtle" type="button" id="next-wisdom-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                    </svg>
                                    <span>Descubrir otra joya literaria</span>
                                </button>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Estantería botánica de notas (Dinámica cada día + aleatoria) -->
                <div class="botanical-bookshelf">
                    <div class="section-heading">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge">ARCHIVO PERSONAL · ROTA CADA DÍA</span>
                            </div>
                            <p class="eyebrow">PENSAMIENTOS BOTÁNICOS & FRASES DE LUZ</p>
                            <h2 class="library-section-red-title">Pequeñas notas para el corazón</h2>
                        </div>
                        <button type="button" class="button button-outline button-sm atelier-btn-subtle" id="shuffle-notes-btn">
                            <span>🌹 Renovar notas al azar</span>
                        </button>
                    </div>

                    <div class="bookshelf-cards" id="dynamic-bookshelf-cards">
                        <!-- Nota 1 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="0">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">
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
                            <span class="note-pin" aria-hidden="true">🌹</span>
                            <h3 class="library-card-red-title" data-note-title>Sobre florecer a tu propio ritmo</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p data-note-body>«Las flores jamás compiten con la flor vecina; simplemente despliegan su esplendor. Jamás olvides el inmenso valor que guarda tu propio proceso.»</p>
                            <div class="bookshelf-note-footer">
                                <small data-note-author>Para Carla · Con infinita ternura</small>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>

                        <!-- Nota 2 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="1">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                        <path d="M2 17l10 5 10-5"></path>
                                        <path d="M2 12l10 5 10-5"></path>
                                    </svg>
                                </span>
                                <span class="card-number" data-note-badge>NOTA · SERENIDAD</span>
                            </div>
                            <span class="note-pin" aria-hidden="true">🌷</span>
                            <h3 class="library-card-red-title" data-note-title>La paz de los instantes lentos</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p data-note-body>«Una infusión tibia, una mirada al horizonte al atardecer y unos minutos sin urgencias. En la sencillez noble habita la plenitud.»</p>
                            <div class="bookshelf-note-footer">
                                <small data-note-author>Rincón de Lectura · Atelier</small>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>

                        <!-- Nota 3 -->
                        <div class="bookshelf-note luxury-card" data-note-slot="2">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                </span>
                                <span class="card-number" data-note-badge>NOTA · LUZ PROPIA</span>
                            </div>
                            <span class="note-pin" aria-hidden="true">🌸</span>
                            <h3 class="library-card-red-title" data-note-title>Tu brillo inconfundible</h3>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p data-note-body>«Hay personas que dejan una estela inolvidable con solo sonreír, por su nobleza pura y su calidez de corazón. Tú iluminas este espacio, Carla.»</p>
                            <div class="bookshelf-note-footer">
                                <small data-note-author>El Jardín Secreto · Carla Lorena</small>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cuaderno de Poesía & Caligrafía Manuscrita (Dinámico por día y al azar) -->
                <div class="editorial-poetry-section">
                    <div class="section-heading">
                        <div>
                            <div class="atelier-badge-strip">
                                <span class="atelier-badge">CALIGRAFÍA DE AUTOR · POEMA DEL DÍA</span>
                            </div>
                            <p class="eyebrow">VERSOS DEDICADOS · TINTA BOTÁNICA</p>
                            <h2 class="library-section-red-title">Poemas en pergamino de seda</h2>
                        </div>
                        <span class="letters-subtitle">Poesía viva que se renueva cada día</span>
                    </div>

                    <div class="poetry-pergamino-card luxury-card" id="dynamic-poem-card">
                        <div class="pergamino-header">
                            <span class="pergamino-wax" aria-hidden="true">🌹</span>
                            <span class="pergamino-badge library-card-red-title" id="poem-title">Canto al Atardecer</span>
                            <span class="pergamino-date" id="poem-mood">Para leer con una taza de té y silencio amable</span>
                        </div>
                        <div class="pergamino-body">
                            <p class="poem-verse stanza-1" id="poem-stanza-1">
                                «Hay jardines que nacen en la tierra,<br>
                                y otros que florecen en la mirada.<br>
                                Tú llevas contigo la primavera eterna,<br>
                                la risa clara y la paz guardada.»
                            </p>
                            <div class="poem-divider">
                                <span>❦</span>
                            </div>
                            <p class="poem-verse stanza-2" id="poem-stanza-2">
                                «Que ningún invierno apague tu calidez,<br>
                                que los senderos te sean siempre amables,<br>
                                y que al volver aquí encuentres otra vez,<br>
                                motivos para soñar inagotables.»
                            </p>
                        </div>
                        <div class="pergamino-footer">
                            <span class="pergamino-signature" id="poem-signature">Escrito con amor para Carla Lorena</span>
                            <button class="button button-outline button-sm poetry-recite-btn atelier-btn-subtle" type="button" id="next-poem-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                </svg>
                                <span>Descubrir otro poema</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
