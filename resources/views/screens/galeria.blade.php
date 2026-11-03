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
                        <span class="gallery-caption">IMÁGENES DE DEMOSTRACIÓN · COLECCIÓN PRIVADA VIVA · EDICIÓN ATELIER</span>
                    </div>
                </div>

                <div class="gallery-grid luxury-gallery-grid" data-grid-size="standard">
                    @forelse($galleryItems as $idx => $item)
                        <button class="gallery-item gallery-museo-card" type="button" data-kind="{{ $item->category }}" data-image="{{ $item->image_url }}" data-title="{{ $item->title }}" aria-label="Abrir imagen: {{ $item->title }}">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">
                                    @if($item->category === 'video')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    @elseif($item->category === 'familia')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                    @elseif($item->category === 'amigos')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    @elseif($item->category === 'especiales')
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                    @else
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M12 2a4 4 0 0 0-4 4v1a4 4 0 0 0 8 0V6a4 4 0 0 0-4-4z"></path>
                                            <path d="M22 12a4 4 0 0 0-4-4h-1a4 4 0 0 0 0 8h1a4 4 0 0 0 4-4z"></path>
                                            <path d="M12 22a4 4 0 0 0 4-4v-1a4 4 0 0 0-8 0v1a4 4 0 0 0 4 4z"></path>
                                            <path d="M2 12a4 4 0 0 0 4 4h1a4 4 0 0 0 0-8H6a4 4 0 0 0-4 4z"></path>
                                        </svg>
                                    @endif
                                </span>
                                <span class="card-number">{{ $item->tag_label ?: 'FOTOGRAFÍA BOTÁNICA' }}</span>
                                @auth
                                    @if(auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true))
                                        <a href="#admin" data-go="admin" class="gallery-card-edit-badge" title="Editar en Centro de Control" style="margin-left: auto; font-size: 10px; color: #b8126c; background: rgba(255, 62, 154, 0.12); padding: 2px 7px; border-radius: 999px; text-decoration: none; border: 1px solid rgba(255, 62, 154, 0.25);">✏️ Editar</a>
                                    @endif
                                @endauth
                            </div>
                            <div class="gallery-photo-frame">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="{{ $idx < 4 ? 'eager' : 'lazy' }}" onerror="this.onerror=null;this.src='{{ asset('images/mockups/propuesta_b_natural_light.png') }}';">
                                @if($item->category === 'video')
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
                                @else
                                    <span class="gallery-zoom-badge" aria-hidden="true">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            <line x1="11" y1="8" x2="11" y2="14"></line>
                                            <line x1="8" y1="11" x2="14" y2="11"></line>
                                        </svg>
                                        <span>Ver obra</span>
                                    </span>
                                @endif
                            </div>
                            <div class="gallery-card-caption">
                                <div class="gallery-caption-header">
                                    <strong>{{ $item->title }}</strong>
                                    <span class="gallery-pill">{{ $item->pill ?: 'Colección Carla' }}</span>
                                </div>
                                <div class="blog-card-divider" aria-hidden="true">
                                    <span class="divider-line"></span>
                                    <span class="divider-rose">❦</span>
                                    <span class="divider-line"></span>
                                </div>
                                @if($item->quote)
                                    <p class="gallery-caption-quote">{{ $item->quote }}</p>
                                @endif
                            </div>
                        </button>
                    @empty
                        <div class="gallery-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
                            <span class="note-flower" aria-hidden="true" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">✿</span>
                            <p style="font-size: 1.1rem; color: #64748b;">Aún no hay obras registradas en la galería.</p>
                            @auth
                                <a href="#admin" data-go="admin" class="button button-primary button-sm" style="margin-top: 1rem;">+ Gestionar en Panel de Control</a>
                            @endauth
                        </div>
                    @endforelse
                </div>

                <div class="gallery-empty-state" data-gallery-empty hidden>
                    <span class="note-flower" aria-hidden="true">✿</span>
                    <p>Aún no hay recuerdos catalogados en esta colección específica.</p>
                    <button type="button" class="button button-outline button-sm" data-gallery-reset-filter>Ver todas las obras</button>
                </div>
            </div>
        </section>
