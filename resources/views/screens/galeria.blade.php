        <section class="screen" data-screen="galeria" aria-labelledby="gallery-title" hidden>
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
                            <span class="atelier-badge">ARCHIVO VISUAL</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge">PILAR IV · MI ESPACIO</span>
                        </div>
                        <p class="eyebrow">MI ESPACIO · GALERÍA DE RECUERDOS & SALÓN PRIVADO</p>
                        <h1 id="gallery-title">Galería · <em>Momentos que perduran en el tiempo</em></h1>
                        <p>Cada imagen custodia un fragmento de luz, belleza y memoria viva. Una cuidada selección visual del universo íntimo de Carla Lorena.</p>
                    </div>
                    <a class="button button-outline atelier-btn-subtle gallery-explore-albums-btn" href="#albumes" data-go="albumes">
                        <span class="atelier-btn-lead-icon" aria-hidden="true">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </span>
                        <span class="atelier-btn-label">Explorar álbumes</span>
                        <span class="atelier-btn-arrow" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="7" y1="17" x2="17" y2="7"></line>
                                <polyline points="7 7 17 7 17 17"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>

                <div class="gallery-toolbar">
                    <div class="filter-group" role="group" aria-label="Filtrar galería">
                        <button class="filter-chip is-selected" type="button" data-filter="todos" aria-pressed="true">Todas las obras</button>
                        <button class="filter-chip" type="button" data-filter="foto" aria-pressed="false">Botánica & Naturaleza</button>
                        <button class="filter-chip" type="button" data-filter="video" aria-pressed="false">Postales en Movimiento</button>
                        <button class="filter-chip" type="button" data-filter="familia" aria-pressed="false">Familia</button>
                        <button class="filter-chip" type="button" data-filter="amigos" aria-pressed="false">Círculo Cercano</button>
                        <button class="filter-chip" type="button" data-filter="especiales" aria-pressed="false">Especiales</button>
                    </div>
                    <div class="gallery-toolbar-right">
                        <div class="gallery-grid-size-switcher" role="group" aria-label="Tamaño de cuadrícula de la galería">
                            <span class="gallery-size-label">Cuadrícula:</span>
                            <button type="button" class="gallery-size-btn" data-gallery-grid-size="large" aria-pressed="false" title="Cuadrícula Grande (2 columnas)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="8" height="16" rx="2"></rect>
                                    <rect x="13" y="4" width="8" height="16" rx="2"></rect>
                                </svg>
                                <span>Grande</span>
                            </button>
                            <button type="button" class="gallery-size-btn is-active" data-gallery-grid-size="standard" aria-pressed="true" title="Cuadrícula Estándar (3 columnas)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                                </svg>
                                <span>Estándar</span>
                            </button>
                            <button type="button" class="gallery-size-btn" data-gallery-grid-size="compact" aria-pressed="false" title="Cuadrícula Compacta (4 columnas)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="4.5" height="4.5" rx="1"></rect>
                                    <rect x="9.75" y="3" width="4.5" height="4.5" rx="1"></rect>
                                    <rect x="16.5" y="3" width="4.5" height="4.5" rx="1"></rect>
                                    <rect x="3" y="9.75" width="4.5" height="4.5" rx="1"></rect>
                                    <rect x="9.75" y="9.75" width="4.5" height="4.5" rx="1"></rect>
                                    <rect x="16.5" y="9.75" width="4.5" height="4.5" rx="1"></rect>
                                </svg>
                                <span>Compacta</span>
                            </button>
                        </div>
                        <span class="gallery-caption">IMÁGENES DE DEMOSTRACIÓN · COLECCIÓN PRIVADA · EDICIÓN ATELIER</span>
                    </div>
                </div>

                <div class="gallery-grid luxury-gallery-grid" data-grid-size="standard">
                    <!-- Obra 1: Flores de domingo -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="foto" data-image="https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1400&q=90" data-title="Flores de domingo para Carla" aria-label="Abrir imagen: Flores de domingo">
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
                            <span class="card-number">FOTOGRAFÍA BOTÁNICA</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=900&q=85" alt="Flores silvestres de distintos colores iluminadas por el sol">
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                                <span>Ver obra</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>Flores de domingo</strong>
                                <span class="gallery-pill">Colección Carla</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«Para recordarte lo bonito que es florecer despacio y a tu propio ritmo.»</p>
                        </div>
                    </button>

                    <!-- Obra 2: El lago de los reflejos serenos -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="foto" data-image="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1400&q=90" data-title="El lago de los reflejos serenos" aria-label="Abrir imagen: Aire de montaña">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8"></path>
                                    <path d="m3 16 7-7 4 4 5-6"></path>
                                </svg>
                            </span>
                            <span class="card-number">PAISAJE DE CALMA</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=900&q=85" alt="Lago sereno rodeado de montañas">
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                                <span>Ver obra</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>Aire de montaña</strong>
                                <span class="gallery-pill">Serenidad</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«Un lugar de paz que guarda tu nombre entre sus reflejos.»</p>
                        </div>
                    </button>

                    <!-- Obra 3: Una tarde dorada -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="video" data-image="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=90" data-title="Una tarde dorada" aria-label="Abrir muestra visual: Una tarde dorada">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </span>
                            <span class="card-number">POSTAL EN MOVIMIENTO</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=85" alt="Paisaje de campo al final de la tarde">
                            <span class="video-badge">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                <span>POSTAL DORADA</span>
                            </span>
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                <span>Reproducir</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>Una tarde dorada</strong>
                                <span class="gallery-pill">Luz Cálida</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«La hora mágica cuando el sol abraza la pradera en silencio.»</p>
                        </div>
                    </button>

                    <!-- Obra 4: Cielo estrellado sobre el jardín -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="foto" data-image="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1400&q=90" data-title="Cielo estrellado sobre el jardín" aria-label="Abrir imagen: Bajo las estrellas">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </span>
                            <span class="card-number">NOCHE CELESTIAL</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=900&q=85" alt="Cielo estrellado sobre montañas">
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                                <span>Ver obra</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>Bajo las estrellas</strong>
                                <span class="gallery-pill">Infinito</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«En cada estrella un deseo sincero guardado para ti.»</p>
                        </div>
                    </button>

                    <!-- Obra 5: El sendero de los jazmines -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="foto" data-image="https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1400&q=90" data-title="El sendero de los jazmines" aria-label="Abrir imagen: El camino más bonito">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                    <path d="M2 17l10 5 10-5"></path>
                                    <path d="M2 12l10 5 10-5"></path>
                                </svg>
                            </span>
                            <span class="card-number">SENDERO VERDE · PASEO</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1200&q=85" alt="Camino entre vegetación frondosa">
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                                <span>Ver obra</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>El camino más bonito</strong>
                                <span class="gallery-pill">Caminos Juntos</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«Cualquier camino se vuelve hermoso si nos lleva a sonreír y soñar.»</p>
                        </div>
                    </button>

                    <!-- Obra 6: Luz de atardecer entre las flores -->
                    <button class="gallery-item gallery-museo-card" type="button" data-kind="video" data-image="https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=1400&q=90" data-title="Luz de atardecer entre las flores" aria-label="Abrir muestra visual: Luz de atardecer">
                        <div class="card-top-bar">
                            <span class="card-icon-emblem">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <line x1="12" y1="1" x2="12" y2="3"></line>
                                    <line x1="12" y1="21" x2="12" y2="23"></line>
                                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                </svg>
                            </span>
                            <span class="card-number">POSTAL EN MOVIMIENTO</span>
                        </div>
                        <div class="gallery-photo-frame">
                            <img src="https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=900&q=85" alt="Pradera iluminada por el atardecer">
                            <span class="video-badge">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                <span>POSTAL DORADA</span>
                            </span>
                            <span class="gallery-zoom-badge" aria-hidden="true">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                                <span>Reproducir</span>
                            </span>
                        </div>
                        <div class="gallery-card-caption">
                            <div class="gallery-caption-header">
                                <strong>Luz de atardecer</strong>
                                <span class="gallery-pill">Ocaso Suave</span>
                            </div>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p class="gallery-caption-quote">«Un destello dorado para calmar los pensamientos y abrazar el alma.»</p>
                        </div>
                    </button>
                </div>

                <div class="gallery-empty-state" data-gallery-empty hidden>
                    <span class="note-flower" aria-hidden="true">✿</span>
                    <p>Aún no hay recuerdos catalogados en esta colección específica.</p>
                    <button type="button" class="button button-outline button-sm" data-gallery-reset-filter>Ver todas las obras</button>
                </div>
            </div>
        </section>
