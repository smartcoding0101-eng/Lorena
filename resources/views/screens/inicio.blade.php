        <section class="screen is-active" data-screen="inicio" aria-labelledby="welcome-title">
            <div class="welcome-wrap cinematic-hero">
                <div class="welcome-copy">
                    <div class="romantic-crown-tag">
                        <span class="crown-icon">✦</span>
                        <span>Bienvenida a mi mundo</span>
                    </div>
                    <h1 id="welcome-title" class="hero-grand-title">
                        La vida es más bonita<br>
                        <span class="grand-script">cuando la vives con el corazón...</span>
                    </h1>
                    <p class="welcome-text">Un universo digital donde la belleza, la naturaleza, los recuerdos y los sueños encuentran su lugar. Creado con devoción para celebrar cada instante y florecer a tu propio ritmo.</p>

                    <div class="welcome-actions">
                        <a class="button button-primary button-glow" href="#galeria" data-go="galeria">
                            <span>Descubrir mi universo</span> <span class="action-icon" aria-hidden="true">→</span>
                        </a>
                        <a class="button button-outline" href="#mapa" data-go="mapa">
                            <span>Explorar el jardín</span> <span aria-hidden="true">✦</span>
                        </a>
                        <a class="button button-outline" href="#dedicatoria" data-go="dedicatoria">
                            <span>Dedicatorias</span> <span aria-hidden="true">💌</span>
                        </a>
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

                <div class="welcome-art enchanted-frame" aria-label="Retrato editorial de Carla Lorena en su jardín">
                    <div class="frame-ambient-glow"></div>
                    <div class="frame-oval-border">
                        <img src="{{ asset('images/carla-hero.jpg') }}" alt="Retrato artístico de Carla Lorena">
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
                        <small>BELLEZA & SUEÑOS</small>
                    </div>
                </div>

                <div class="welcome-bottom">
                    <span>CARLA LORENA · NATURALEZA, BELLEZA Y SUEÑOS</span>
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

            @php
                $isStatusAdmin = auth()->check() && ((auth()->user()->is_admin ?? false) || in_array(auth()->id(), [1, 2], true));
                $statusesList = isset($activeStatuses) ? $activeStatuses : collect();
            @endphp
            <!-- Franja de Estados Efímeros 24h (Estilo WhatsApp · Autoajuste Inteligente) -->
            <div class="content-width home-statuses-wrapper"
                 id="home-statuses-section"
                 data-is-admin="{{ $isStatusAdmin ? '1' : '0' }}">

                <div class="statuses-strip-header">
                    <div class="statuses-strip-title-wrap">
                        <span class="statuses-live-ring-dot" aria-hidden="true"></span>
                        <span class="statuses-eyebrow">INSTANTES EFÍMEROS · 24 HORAS</span>
                        <span class="statuses-count-pill" id="home-statuses-count-pill">{{ $statusesList->count() }} {{ $statusesList->count() === 1 ? 'estado activo' : 'estados activos' }}</span>
                    </div>
                    @if($isStatusAdmin)
                    <button type="button" class="statuses-quick-add-btn" id="btn-header-add-status">
                        <span aria-hidden="true">＋</span> Subir estado (24h)
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="statuses-quick-add-btn" style="text-decoration: none;">
                        <span aria-hidden="true">＋</span> Subir estado (24h)
                    </a>
                    @endif
                </div>

                <div class="home-statuses-strip" id="home-statuses-strip" aria-label="Estados de 24 horas del Jardín de Carla">
                    @if($isStatusAdmin)
                    <!-- Tarjeta del Administrador para Subir Estado Directamente desde Inicio -->
                    <button type="button" class="status-story-card status-create-card" id="btn-open-status-uploader" aria-label="Subir nuevo estado de 24 horas">
                        <div class="status-create-ring-wrap">
                            <span class="status-create-plus" aria-hidden="true">＋</span>
                        </div>
                        <strong class="status-create-title">Nuevo Estado</strong>
                        <span class="status-create-sub">Autoajuste · 24h</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="status-story-card status-create-card" style="text-decoration: none;" aria-label="Iniciar sesión como administrador para subir un estado de 24 horas">
                        <div class="status-create-ring-wrap">
                            <span class="status-create-plus" aria-hidden="true">＋</span>
                        </div>
                        <strong class="status-create-title">Nuevo Estado</strong>
                        <span class="status-create-sub">Admin · Autoajuste 24h</span>
                    </a>
                    @endif

                    @foreach($statusesList as $status)
                    @php
                        $isStatusVideo = ($status->media_type ?? 'image') === 'video';
                    @endphp
                    <article class="status-story-card status-active-item"
                             role="button"
                             tabindex="0"
                             data-status-id="{{ $status->id }}"
                             data-image-url="{{ $status->image_url }}"
                             data-media-type="{{ $status->media_type ?? 'image' }}"
                             data-caption="{{ $status->caption }}"
                             data-time-ago="{{ $status->time_ago }}"
                             data-remaining="{{ $status->remaining_label }}"
                             data-expires-at="{{ $status->expires_at_iso }}"
                             aria-label="Ver estado de Carla: {{ $status->caption ?: 'Instante del jardín' }}">
                        <!-- Fondo difuminado + miniatura autoajustada (foto o video) -->
                        @if($isStatusVideo)
                            <div class="status-card-bg-blur status-video-bg-blur">
                                <video src="{{ $status->image_url }}" muted loop playsinline></video>
                            </div>
                            <video class="status-card-img status-card-video" src="{{ $status->image_url }}" muted loop playsinline></video>
                            <span class="status-video-indicator-badge">🎬 Video</span>
                        @else
                            <div class="status-card-bg-blur" style="background-image: url('{{ $status->image_url }}');"></div>
                            <img class="status-card-img" src="{{ $status->image_url }}" alt="{{ $status->caption ?: 'Estado del jardín' }}" loading="lazy">
                        @endif
                        <div class="status-card-shade"></div>

                        <!-- Cabecera con aro luminoso oro-rosa estilo WhatsApp y contador 24h -->
                        <div class="status-card-top">
                            <span class="status-ring-avatar" aria-hidden="true">
                                <span class="status-ring-inner">🌹</span>
                            </span>
                            <span class="status-ttl-badge" title="Desaparece automáticamente a las 24 horas">⏳ {{ $status->remaining_label }}</span>
                            @if($isStatusAdmin)
                            <button type="button"
                                    class="status-card-delete-btn"
                                    data-delete-status="{{ $status->id }}"
                                    title="Eliminar este estado"
                                    aria-label="Eliminar estado">✕</button>
                            @endif
                        </div>

                        <!-- Pie con frase y tiempo relativo -->
                        <div class="status-card-bottom">
                            @if($status->caption)
                            <p class="status-card-caption">{{ $status->caption }}</p>
                            @endif
                            <span class="status-card-time">{{ $status->time_ago }}</span>
                        </div>
                    </article>
                    @endforeach

                    <div class="status-empty-placeholder" id="home-statuses-empty-msg" @if($statusesList->isNotEmpty()) hidden @endif>
                        <div class="status-empty-content">
                            <div class="status-empty-icon-wrap">
                                <span class="status-empty-icon">🌸</span>
                                <span class="status-empty-sparkle">✨</span>
                            </div>
                            <div class="status-empty-text-wrap">
                                <strong class="status-empty-title">El jardín espera un nuevo destello</strong>
                                <span class="status-empty-desc">Los instantes compartidos florecen aquí durante 24 horas antes de convertirse en recuerdos eternos.</span>
                            </div>
                        </div>
                        @if($isStatusAdmin)
                        <button type="button" class="status-empty-action-btn" onclick="document.getElementById('btn-open-status-uploader')?.click()">
                            <span>✦ Publicar el primer instante</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($isStatusAdmin)
            <!-- Modal de Subida de Estados WhatsApp Premium (Fotos & Videos con Autoajuste) -->
            <dialog class="status-upload-dialog" id="garden-status-upload-dialog" aria-labelledby="status-upload-title">
                <div class="status-upload-card">
                    <header class="status-upload-header">
                        <div class="status-header-title-box">
                            <span class="status-header-badge">
                                <span class="status-badge-dot"></span> ESTADO 24 HORAS · ESTILO WHATSAPP
                            </span>
                            <h3 id="status-upload-title">Crear Nuevo Instante Efímero</h3>
                        </div>
                        <button type="button" class="status-modal-close-btn" id="btn-close-status-upload" aria-label="Cerrar modal">✕</button>
                    </header>

                    <form id="garden-status-upload-form" enctype="multipart/form-data">
                        <!-- Selector Dual: Imagen o Video -->
                        <label class="status-dropzone" id="status-upload-dropzone" for="status-upload-input">
                            <input type="file" id="status-upload-input" name="images[]" accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/quicktime" multiple required hidden>

                            <!-- Estado Vacío del Dropzone -->
                            <div class="status-dropzone-empty" id="status-dropzone-empty">
                                <div class="status-dropzone-icons-duo">
                                    <span class="dropzone-media-icon camera-icon" title="Fotos">📸</span>
                                    <span class="dropzone-media-icon video-icon" title="Videos">🎬</span>
                                </div>
                                <strong class="status-dropzone-headline">Arrastra o elige tus Fotos o Videos</strong>
                                <span class="status-dropzone-sub">Compatible con JPG, PNG, WEBP, MP4 y WEBM</span>
                                <div class="status-dropzone-features">
                                    <span class="dropzone-feat-pill">✨ Autoajuste Vertical & Panorámico</span>
                                    <span class="dropzone-feat-pill">⏳ Expira en 24h</span>
                                </div>
                            </div>

                            <!-- Escenario de Previsualización en Vivo Dual (Foto o Video) -->
                            <div class="status-live-preview-stage" id="status-live-preview-stage" hidden>
                                <div class="status-preview-blur-bg" id="status-preview-blur-bg"></div>
                                <img class="status-preview-main-img" id="status-preview-main-img" src="" alt="Vista previa de imagen" style="display: none;">
                                <video class="status-preview-main-video" id="status-preview-main-video" autoplay muted loop playsinline style="display: none;"></video>
                                <div class="status-preview-overlay-info">
                                    <span class="status-preview-badge" id="status-preview-count-badge">✨ Autoajuste en vivo</span>
                                    <button type="button" class="status-preview-change-btn" id="btn-change-preview-media">Cambiar archivo</button>
                                </div>
                            </div>
                        </label>

                        <!-- Input de Leyenda Estilo WhatsApp -->
                        <div class="status-upload-field">
                            <label for="status-upload-caption" class="status-caption-label">
                                <span>Añadir un pensamiento o frase</span>
                                <span class="status-caption-counter" id="status-caption-counter">0 / 280</span>
                            </label>
                            <div class="status-caption-input-wrap">
                                <input type="text" id="status-upload-caption" name="caption" maxlength="280" placeholder="Escribe un mensaje para tu estado... ✨" autocomplete="off">
                                <div class="status-quick-emojis">
                                    <button type="button" class="btn-quick-emoji" data-emoji="🌹">🌹</button>
                                    <button type="button" class="btn-quick-emoji" data-emoji="✨">✨</button>
                                    <button type="button" class="btn-quick-emoji" data-emoji="💖">💖</button>
                                    <button type="button" class="btn-quick-emoji" data-emoji="🌸">🌸</button>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones del Modal -->
                        <div class="status-upload-actions">
                            <button type="button" class="button button-outline status-btn-cancel" id="btn-cancel-status-upload">Cancelar</button>
                            <button type="submit" class="button button-primary status-btn-submit" id="btn-submit-status-upload">
                                <span>✦ Publicar por 24 horas</span>
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
            @endif

            <!-- Visor de Estados a Pantalla Completa Estilo WhatsApp (Autoajuste Inteligente Dual) -->
            <dialog class="status-viewer-dialog" id="garden-status-viewer-dialog" aria-label="Visor de Estados de 24 horas">
                <div class="status-viewer-shell" id="status-viewer-shell">
                    <!-- Barras de progreso segmentadas estilo WhatsApp -->
                    <div class="status-viewer-progress-track" id="status-viewer-progress-track"></div>

                    <!-- Cabecera del visor -->
                    <header class="status-viewer-header">
                        <div class="status-viewer-author">
                            <span class="status-viewer-avatar">🌹</span>
                            <div class="status-viewer-meta">
                                <strong>El Jardín de Carla</strong>
                                <span id="status-viewer-time">Justo ahora · ⏳ 24h</span>
                            </div>
                        </div>
                        <div class="status-viewer-controls">
                            <button type="button" class="status-viewer-ctrl-btn" id="btn-status-viewer-pause" title="Pausar / Reanudar" aria-label="Pausar o reanudar estado">⏸</button>
                            @if($isStatusAdmin)
                            <button type="button" class="status-viewer-ctrl-btn status-viewer-del-btn" id="btn-status-viewer-delete" title="Eliminar este estado" aria-label="Eliminar estado">🗑️</button>
                            @endif
                            <button type="button" class="status-viewer-ctrl-btn" id="btn-status-viewer-close" title="Cerrar" aria-label="Cerrar visor">✕</button>
                        </div>
                    </header>

                    <!-- Escenario con Autoajuste Inteligente Dual (Fondo difuminado + Imagen o Video 100% completo sin recortes) -->
                    <div class="status-viewer-stage" id="status-viewer-stage">
                        <div class="status-viewer-backdrop-blur" id="status-viewer-backdrop-blur"></div>
                        <img class="status-viewer-main-photo" id="status-viewer-main-photo" src="" alt="Estado de Carla Lorena" style="display: none;">
                        <video class="status-viewer-main-video" id="status-viewer-main-video" playsinline webkit-playsinline style="display: none;"></video>
                        <button type="button" class="status-viewer-nav status-nav-prev" id="btn-status-prev" aria-label="Estado anterior">‹</button>
                        <button type="button" class="status-viewer-nav status-nav-next" id="btn-status-next" aria-label="Siguiente estado">›</button>
                    </div>

                    <!-- Pie con frase / leyenda -->
                    <footer class="status-viewer-footer" id="status-viewer-footer">
                        <p class="status-viewer-caption" id="status-viewer-caption"></p>
                    </footer>
                </div>
            </dialog>

            <!-- Sección Editorial: Rincones que esperan por ti -->
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
                                <span class="card-icon-emblem">🌸</span>
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

            <!-- Banner Editorial de Cierre (Segmento Poético de Despedida) -->
            <div class="content-width home-closing-segment-wrapper">
                <div class="editorial-closing-card">
                    <div class="closing-card-ambient"></div>
                    <span class="closing-eyebrow">✦ EL JARDÍN DE CARLA LORENA ✦</span>
                    <h2 class="closing-quote">«Cada día es una oportunidad para crear algo extraordinario.»</h2>
                    <div class="closing-author-wrap">
                        <span class="closing-rose-icon">🌹</span>
                        <span class="closing-author">Carla Lorena</span>
                        <span class="closing-dot">·</span>
                        <span class="closing-sub">Belleza, Naturaleza y Sueños</span>
                    </div>
                </div>
            </div>
        </section>
