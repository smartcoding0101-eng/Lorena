        <section class="screen" data-screen="entretenimiento" aria-labelledby="entertainment-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Un rincón privado para escuchar y mirar</p>
                        <h1 id="entertainment-title">El espacio de <em>entretenimiento</em></h1>
                        <p>Música y videos que Carla decida añadir al jardín con reproductor continuo y playlist interactiva.</p>
                    </div>
                    <span class="heading-mark" aria-hidden="true">♫</span>
                </div>
                @auth
                    @if ($errors->any())
                        <div class="form-errors media-errors" role="alert"><p>No se pudo agregar el archivo.</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    @if (session('status'))
                        <p class="form-success" role="status">{{ session('status') }}</p>
                    @endif

                    @php
                        $mediaJsonList = $gardenMedia->map(function ($m) {
                            return [
                                'id' => $m->id,
                                'title' => $m->title,
                                'description' => $m->description,
                                'media_type' => $m->media_type,
                                'source_type' => $m->source_type,
                                'source_url' => $m->source_url,
                                'youtube_embed_url' => $m->youtube_embed_url,
                                'stream_url' => $m->path ? route('garden-media.stream', $m) : null,
                            ];
                        })->values();
                    @endphp

                    <!-- ═══════════════════════════════════════════════════════════════════════ -->
                    <!--  REPRODUCTOR PREMIUM & PLAYLIST INTERACTIVA (ESTILO SPOTIFY / YT MUSIC) -->
                    <!-- ═══════════════════════════════════════════════════════════════════════ -->
                    <div id="entertainment-player-section" class="entertainment-studio" data-media-json='@json($mediaJsonList)'>
                        <!-- Barra Superior: Resumen y Botón Rápido -->
                        <div class="ep-top-bar">
                            <div class="ep-top-info">
                                <span class="ep-eyebrow">REPRODUCTOR EXCLUSIVO DE CARLA</span>
                                <h2 class="ep-studio-title">Mi Espacio de Música & Video</h2>
                            </div>
                            <div class="ep-top-actions">
                                <button type="button" id="ep-toggle-add-btn" class="ep-pill-btn">
                                    <span>＋</span> Guardar enlace o archivo
                                </button>
                            </div>
                        </div>

                        <!-- Cajón Colapsable para Añadir Enlaces o Archivos Rápido -->
                        <div id="ep-add-drawer" class="ep-add-drawer" hidden>
                            <form class="ep-add-form media-upload-form" method="POST" action="{{ route('garden-media.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="ep-add-header">
                                    <span class="ep-add-icon">✨</span>
                                    <h3>Añadir a mi Playlist Privada</h3>
                                </div>
                                <div class="ep-form-grid">
                                    <div class="ep-field">
                                        <label>¿Qué deseas agregar?</label>
                                        <select name="source_type" data-media-source-type required>
                                            <option value="youtube">▶️ Enlace de YouTube</option>
                                            <option value="external_audio">🎧 Enlace directo a un MP3</option>
                                            <option value="upload">⬆️ Subir archivo desde mi dispositivo</option>
                                        </select>
                                    </div>
                                    <div class="ep-field" data-media-upload-fields hidden>
                                        <label>Tipo de contenido</label>
                                        <select name="media_type">
                                            <option value="audio">🎵 Música o Audio</option>
                                            <option value="video">🎬 Video</option>
                                        </select>
                                    </div>
                                    <div class="ep-field">
                                        <label>Título de la canción o video</label>
                                        <input type="text" name="title" maxlength="160" placeholder="Ej. Perfect - Ed Sheeran" required>
                                    </div>
                                    <div class="ep-field" data-media-link-fields>
                                        <label>Enlace HTTPS (YouTube o MP3)</label>
                                        <input type="url" name="source_url" maxlength="2048" placeholder="https://www.youtube.com/watch?v=... o https://.../cancion.mp3">
                                    </div>
                                    <div class="ep-field" data-media-upload-fields hidden>
                                        <label>Archivo local (MP4, MP3, etc.)</label>
                                        <input type="file" name="file" accept="audio/*,video/*">
                                    </div>
                                    <div class="ep-field ep-field-full">
                                        <label>Dedicatoria o recuerdo (opcional)</label>
                                        <input type="text" name="description" maxlength="4000" placeholder="Canción que me recuerda momentos hermosos…">
                                    </div>
                                </div>
                                <div class="ep-add-actions">
                                    <button class="button button-primary" type="submit">🌸 Añadir a mi Playlist</button>
                                </div>
                            </form>
                        </div>

                        <!-- Escenario Principal del Reproductor -->
                        <div class="ep-main-stage">
                            <!-- Columna Izquierda: Pantalla de Video / Carátula de Audio -->
                            <div class="ep-player-card">
                                <div class="ep-media-screen">
                                    <!-- Viewport de Video (YouTube o Video HTML5) -->
                                    <div id="ep-video-viewport" class="ep-video-viewport" hidden></div>

                                    <!-- Carátula de Audio con Efecto Vinilo y Ecualizador Dinámico -->
                                    <div id="ep-audio-art" class="ep-audio-art">
                                        <div class="ep-vinyl-record">
                                            <div class="ep-vinyl-grooves"></div>
                                            <div class="ep-vinyl-center">
                                                <span>🌸</span>
                                            </div>
                                        </div>
                                        <div class="ep-visualizer-wave">
                                            <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles del Track Actual -->
                                <div class="ep-track-header">
                                    <div class="ep-track-meta">
                                        <span id="ep-current-badge" class="ep-badge youtube">🎬 Video</span>
                                        <h3 id="ep-current-title" class="ep-track-title">Selecciona una pista</h3>
                                        <p id="ep-current-artist" class="ep-track-artist">El Jardín de Carla Lorena</p>
                                    </div>
                                    <button type="button" id="ep-btn-fav" class="ep-fav-btn" title="Marcar como favorita">🤍</button>
                                </div>

                                <!-- Barra de Progreso y Tiempos -->
                                <div class="ep-progress-wrap">
                                    <div id="ep-progress-bar" class="ep-progress-bar" role="slider" aria-label="Progreso">
                                        <div id="ep-progress-fill" class="ep-progress-fill" style="width: 0%;"></div>
                                    </div>
                                    <div class="ep-time-labels">
                                        <span id="ep-time-current">0:00</span>
                                        <span id="ep-time-total">0:00</span>
                                    </div>
                                </div>

                                <!-- Barra de Controles de Reproducción -->
                                <div class="ep-controls-bar">
                                    <div class="ep-controls-left">
                                        <button type="button" id="ep-btn-shuffle" class="ep-ctrl-btn" title="Modo aleatorio">🔀</button>
                                    </div>

                                    <div class="ep-controls-center">
                                        <button type="button" id="ep-btn-prev" class="ep-ctrl-btn" title="Anterior">⏮</button>
                                        <button type="button" id="ep-btn-play" class="ep-ctrl-play" title="Reproducir">
                                            <span id="ep-play-icon">▶</span>
                                        </button>
                                        <button type="button" id="ep-btn-next" class="ep-ctrl-btn" title="Siguiente">⏭</button>
                                    </div>

                                    <div class="ep-controls-right">
                                        <button type="button" id="ep-btn-repeat" class="ep-ctrl-btn" title="Repetir">🔁</button>
                                        <div class="ep-volume-wrap">
                                            <span class="ep-vol-icon" aria-hidden="true">🔊</span>
                                            <input type="range" id="ep-volume-slider" min="0" max="100" value="80" aria-label="Volumen">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Derecha: Playlist Interactiva -->
                            <div class="ep-playlist-card">
                                <div class="ep-playlist-header">
                                    <div>
                                        <span class="ep-playlist-eyebrow">COLA DE REPRODUCCIÓN</span>
                                        <h3 class="ep-playlist-title">Mi Playlist <span class="ep-playlist-count">({{ $gardenMedia->count() }})</span></h3>
                                    </div>
                                </div>

                                <!-- Filtros Rápidos -->
                                <div class="ep-filter-chips">
                                    <button type="button" class="ep-chip is-active" data-ep-filter="all">Todos</button>
                                    <button type="button" class="ep-chip" data-ep-filter="music">🎵 Canciones</button>
                                    <button type="button" class="ep-chip" data-ep-filter="video">🎬 Videos</button>
                                    <button type="button" class="ep-chip" data-ep-filter="youtube">▶️ YouTube</button>
                                    <button type="button" class="ep-chip" data-ep-filter="fav">❤️ Favoritos</button>
                                </div>

                                <!-- Lista Scrolleable de Canciones/Videos -->
                                <div id="ep-playlist-items" class="ep-playlist-items">
                                    @forelse ($gardenMedia as $media)
                                        <article class="ep-playlist-track-row" data-id="{{ $media->id }}" data-type="{{ $media->media_type }}" data-source="{{ $media->source_type }}">
                                            <div class="ep-track-main-info">
                                                <h4 class="ep-track-name">{{ $media->title }}</h4>
                                                @if ($media->description)
                                                    <p class="ep-track-desc">{{ $media->description }}</p>
                                                @endif
                                                @if ($media->source_type === 'youtube')
                                                    <div class="ep-track-badge-tag ep-badge-yt" data-youtube-load="true" data-embed="{{ $media->youtube_embed_url }}" referrerpolicy="no-referrer">
                                                        <span>▶️ YouTube ({{ $media->youtube_embed_url }})</span>
                                                    </div>
                                                @elseif ($media->source_type === 'external_audio')
                                                    <div class="ep-track-badge-tag ep-badge-audio">
                                                        <span>🎧 Enlace externo: {{ $media->source_url }}</span>
                                                    </div>
                                                @elseif ($media->media_type === 'video')
                                                    <div class="ep-track-preview-video">
                                                        <video controls preload="none" src="{{ route('garden-media.stream', $media) }}"></video>
                                                    </div>
                                                @else
                                                    <div class="ep-track-preview-audio">
                                                        <audio controls preload="none" src="{{ route('garden-media.stream', $media) }}"></audio>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ep-track-row-actions">
                                                <form method="POST" action="{{ route('garden-media.destroy', $media) }}" onsubmit="return confirm('¿Quitar de la lista?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ep-delete-track-btn" title="Eliminar">🗑️</button>
                                                </form>
                                            </div>
                                        </article>
                                    @empty
                                        <div class="ep-empty-playlist-msg">
                                            <p>Aún no hay canciones ni videos agregados a la lista.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="demo-disclaimer">La colección y los archivos guardados son privados y exclusivos de tu sesión. Al reproducir videos de YouTube o audios de servidores externos, la conexión se realiza directamente con sus proveedores para garantizar fluidez sin consumir almacenamiento en este servidor.</p>
                @else
                    <div class="personal-panel"><span class="personal-avatar" aria-hidden="true">♫</span><div><span class="eyebrow">ACCESO PRIVADO</span><h2>Inicia sesión para entrar</h2><p>Los videos y audios personales solo están disponibles con una sesión autorizada.</p><a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span>↗</span></a></div></div>
                @endauth
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════════════════ -->
        <!--  SECCIÓN: CÁPSULA DEL TIEMPO & CARTAS SECRETAS CON CUENTA REGRESIVA    -->
        <!-- ═══════════════════════════════════════════════════════════════════════ -->