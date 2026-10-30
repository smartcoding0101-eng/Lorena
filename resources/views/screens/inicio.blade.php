        <section class="screen is-active" data-screen="inicio" aria-labelledby="welcome-title">
            <div class="welcome-wrap cinematic-hero">
                <div class="welcome-copy">
                    <div class="romantic-crown-tag">
                        <span class="crown-icon">👑</span>
                        <span>Dedicado con amor a Carla Lorena</span>
                    </div>
                    <h1 id="welcome-title" class="hero-grand-title">
                        Un universo para<br>
                        <span class="grand-script">hacerte sonreír.</span>
                    </h1>
                    <p class="welcome-text">Bienvenida a tu refugio privado, Carla. Un rincón donde cada pétalo florece a tu ritmo, las historias te pertenecen y los días van más despacio con la belleza de los detalles.</p>

                    <div class="welcome-actions">
                        <a class="button button-primary button-glow" href="#mapa" data-go="mapa">
                            <span>Explorar tu jardín</span> <span class="action-icon" aria-hidden="true">❦</span>
                        </a>
                        <a class="button button-outline" href="#dedicatoria" data-go="dedicatoria">
                            <span>Mi dedicatoria</span> <span aria-hidden="true">💌</span>
                        </a>
                        <a class="button button-outline" href="#jardin" data-go="jardin">
                            <span>Santuario floral</span> <span aria-hidden="true">🌸</span>
                        </a>
                    </div>

                    <div class="hero-quote-badge">
                        <span class="sparkle-flower" aria-hidden="true">❀</span>
                        <span>«Tu presencia hace florecer cualquier rincón del mundo.»</span>
                    </div>

                    <!-- Widget Dinámico: El Florecer del Día (Daily Bloom) -->
                    <div class="daily-bloom-card" id="daily-bloom-card">
                        <div class="daily-bloom-header">
                            <span class="db-badge">🌸 EL FLORECER DE HOY</span>
                            <span class="db-date" id="db-current-date"></span>
                        </div>
                        <p class="db-quote" id="db-quote-text">«Cargando tu pensamiento de hoy...»</p>
                        <div class="db-footer">
                            <span class="db-flower-type" id="db-flower-type">Flor del día: Rosa Carmín</span>
                            <button type="button" class="db-refresh-btn" id="db-refresh-btn" title="Descubrir otro pensamiento">
                                <span>✦ Nuevo florecer</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="welcome-art enchanted-frame" aria-label="Retrato botánico artístico rodeado de flores">
                    <div class="frame-ambient-glow"></div>
                    <div class="frame-oval-border">
                        <img src="{{ asset('images/carla-hero.jpg') }}" alt="Retrato artístico de Carla Lorena en su jardín botánico">
                        <div class="rose-bloom-overlay"></div>
                    </div>

                    <!-- Rosa Encantada Interactiva de Carla -->
                    <div class="interactive-enchanted-rose" id="enchanted-rose-trigger" role="button" tabindex="0" aria-label="Tocar la rosa encantada de Carla Lorena">
                        <div class="rose-halo"></div>
                        <div class="rose-emblem">🌹</div>
                        <span class="rose-pulse-label">Tócame</span>
                    </div>

                    <div class="art-stamp luxury-monogram" aria-hidden="true">
                        <span>CL</span>
                        <small>AMOR & ARTE</small>
                    </div>
                </div>

                <div class="welcome-bottom">
                    <span>CREADO EXCLUSIVAMENTE PARA CARLA LORENA</span>
                    <span>DESLIZA PARA DESCUBRIR <b aria-hidden="true">↓</b></span>
                </div>
            </div>

            <!-- Modal / Revelación de la Rosa Encantada -->
            <dialog class="enchanted-rose-dialog" id="enchanted-rose-dialog">
                <div class="enchanted-rose-box">
                    <button class="enchanted-close-btn" type="button" aria-label="Cerrar dedicatoria">✕</button>
                    <span class="enchanted-big-rose">🌹</span>
                    <span class="eyebrow">EL SECRETO DE LA ROSA</span>
                    <h2>Para Carla Lorena</h2>
                    <blockquote class="enchanted-message">
                        «De todas las flores que existen en este jardín infinito, tú eres la que más luz, alegría y elegancia aporta al mundo. Que nunca dejes de brillar.»
                    </blockquote>
                    <span class="enchanted-signature">— Con todo el corazón ♡</span>
                </div>
            </dialog>

            <section class="home-discover content-width" aria-labelledby="discover-title">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">TU MUNDO A TU MEDIDA</p>
                        <h2 id="discover-title">Rincones que esperan por ti</h2>
                    </div>
                    <div class="heading-actions" style="display: flex; align-items: center; gap: 14px;">
                        @auth
                        <button type="button" id="btn-add-home-card" class="button button-sm button-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 13px;">
                            <span aria-hidden="true">✦</span> Agregar Tarjeta
                        </button>
                        @endauth
                        <a class="text-link" href="#mapa" data-go="mapa">Ver el mapa del jardín secreto <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <div class="space-grid" id="home-space-grid">
                    @forelse($homeCards as $card)
                        <div class="space-card {{ $card->style_variant }} luxury-card"
                             data-card-id="{{ $card->id }}"
                             data-card-title="{{ $card->title }}"
                             data-card-subtitle="{{ $card->subtitle }}"
                             data-card-icon="{{ $card->emblem_icon }}"
                             data-card-desc="{{ $card->description }}"
                             data-card-quote="{{ $card->quote }}"
                             data-card-screen="{{ $card->target_screen }}"
                             data-card-variant="{{ $card->style_variant }}"
                             data-card-order="{{ $card->sort_order }}"
                             style="cursor: pointer;">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">{{ $card->emblem_icon ?: '🌸' }}</span>
                                <span class="card-number">{{ str_pad($card->sort_order ?? $loop->iteration, 2, '0', STR_PAD_LEFT) }} · {{ strtoupper($card->subtitle ?: 'RINCÓN') }}</span>
                                @auth
                                <div class="card-admin-actions" style="margin-left: auto; display: flex; gap: 5px; z-index: 5;">
                                    <button type="button" class="btn-home-card-edit" data-id="{{ $card->id }}" title="Editar tarjeta" style="background: rgba(255,255,255,0.92); border: 1px solid rgba(228, 202, 208, 0.8); border-radius: 6px; padding: 3px 6px; cursor: pointer; font-size: 12px; line-height: 1;">✏️</button>
                                    <button type="button" class="btn-home-card-delete" data-id="{{ $card->id }}" title="Eliminar tarjeta" style="background: rgba(255,255,255,0.92); border: 1px solid rgba(228, 202, 208, 0.8); border-radius: 6px; padding: 3px 6px; cursor: pointer; font-size: 12px; line-height: 1;">🗑️</button>
                                </div>
                                @endauth
                            </div>
                            <a class="space-card-body-link" href="#{{ $card->target_screen }}" data-go="{{ $card->target_screen }}" style="display: flex; flex-direction: column; flex: 1; width: 100%; text-decoration: none; color: inherit;">
                                <h3>{{ $card->title }}</h3>
                                <p>{{ $card->description }}</p>
                                @if($card->quote)
                                    <span class="card-mini-quote">«{{ $card->quote }}»</span>
                                @endif
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </a>
                        </div>
                    @empty
                        <div class="space-card space-card-large luxury-card" style="cursor: pointer;">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">▧ 🌸</span>
                                <span class="card-number">01 · RECUERDOS</span>
                            </div>
                            <a class="space-card-body-link" href="#galeria" data-go="galeria" style="display: flex; flex-direction: column; flex: 1; width: 100%; text-decoration: none; color: inherit;">
                                <h3>La Galería</h3>
                                <p>Instantes y fotografías para revivir recuerdos bonitos que iluminan el tiempo.</p>
                                <span class="card-mini-quote">«Cada imagen guarda un pedacito de sol»</span>
                                <span class="card-arrow" aria-hidden="true">↗</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>
        </section>
