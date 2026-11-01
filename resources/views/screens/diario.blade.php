        <section class="screen" data-screen="diario" aria-labelledby="diary-title" hidden>
            <div class="page-shell diary-page-shell">
                <div class="diary-top-nav-row">
                    <a class="back-link diary-back-link" href="#carla" data-go="carla">← Volver a mi espacio personal</a>
                    <span class="diary-privacy-ribbon">
                        <span class="diary-privacy-dot" aria-hidden="true"></span>
                        SANTUARIO BAJO LLAVE · LECTURA EXCLUSIVA DE CARLA LORENA
                    </span>
                </div>

                <!-- Hero Banner Editorial del Diario Íntimo -->
                <header class="diary-hero-banner">
                    <div class="diary-hero-copy">
                        <p class="eyebrow diary-eyebrow-crimson">✦ SANTUARIO ÍNTIMO · CONFIDENCIAS DEL CORAZÓN · SOLO VISIBLE CON TU SESIÓN</p>
                        <h1 id="diary-title" class="diary-main-title">Mi <em>diario íntimo</em> · Páginas que abrazan el alma</h1>
                        <p class="diary-hero-lead">
                            Un refugio silencioso de terciopelo y pergamino donde cada pensamiento, gratitud, sueño y recuerdo florece en absoluta intimidad. Estas páginas nunca aparecen en el blog público y no admiten comentarios.
                        </p>
                        <div class="diary-sanctuary-pills">
                            <span class="diary-stat-pill">
                                <strong>📖 {{ isset($diaryPosts) ? $diaryPosts->count() : 0 }}</strong>
                                {{ (isset($diaryPosts) && $diaryPosts->count() === 1) ? 'página guardada' : 'páginas guardadas' }}
                            </span>
                            <span class="diary-stat-pill">
                                <strong>🌹 {{ now()->locale('es')->translatedFormat('d \d\e F, Y') }}</strong>
                                Fecha en el jardín
                            </span>
                            <span class="diary-stat-pill is-crimson-pill">
                                <strong>🔒 Privacidad Absoluta</strong>
                                Cifrado en tu rincón personal
                            </span>
                        </div>
                    </div>

                    <div class="diary-hero-emblem-card" aria-hidden="true">
                        <svg class="diary-emblem-svg" viewBox="0 0 120 120" fill="none">
                            <circle cx="60" cy="60" r="52" fill="#fff5f7" stroke="#e4b8c3" stroke-width="1.5" stroke-dasharray="4 4"/>
                            <rect x="30" y="26" width="60" height="70" rx="10" fill="#ffffff" stroke="#9e2a47" stroke-width="2.2"/>
                            <path d="M40 26V96" stroke="#d4af37" stroke-width="2"/>
                            <path d="M48 44H78M48 54H74M48 64H70" stroke="#c88a99" stroke-width="1.8" stroke-linecap="round"/>
                            <circle cx="62" cy="79" r="10" fill="#fff0f3" stroke="#9e2a47" stroke-width="2"/>
                            <path d="M58 79C58 76.5 60 74.5 62 74.5C64 74.5 66 76.5 66 79C66 82 62 84.5 62 84.5C62 84.5 58 82 58 79Z" fill="#be123c"/>
                            <path d="M78 20C85 20 91 26 91 33C91 41 79 51 74 56L70 52C75 47 84 38 84 32C84 28 81 25 78 25" stroke="#d4af37" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span class="diary-emblem-caption">CÓDICE DE TERCIOPELO</span>
                        <small>Guardado con llave de oro rosa</small>
                    </div>
                </header>

                @auth
                    @if ($errors->any())
                        <div class="form-errors entry-errors diary-alert-box" role="alert">
                            <p><strong>🌹 No se pudo guardar la página en tu diario:</strong></p>
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <p class="form-success diary-status-banner" role="status">✨ {{ session('status') }}</p>
                    @endif

                    <div class="diary-atelier-grid">
                        <!-- Columna Izquierda: Escritorio de Terciopelo y Pergamino -->
                        <div class="diary-composer-panel">
                            <div class="diary-panel-header">
                                <div class="diary-panel-icon" aria-hidden="true">
                                    <svg viewBox="0 0 28 28" fill="none">
                                        <path d="M6 22L10 21L21 10C22.1 8.9 22.1 7.1 21 6C19.9 4.9 18.1 4.9 17 6L6 17L5 21Z" stroke="#9e2a47" stroke-width="1.8" stroke-linejoin="round"/>
                                        <path d="M15.5 7.5L19.5 11.5" stroke="#d4af37" stroke-width="1.8"/>
                                        <path d="M4 24H24" stroke="#9e2a47" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="eyebrow diary-eyebrow-crimson">ESCRITORIO DE CONFIDENCIAS · NUEVA PÁGINA</span>
                                    <h2 class="diary-section-title">Escribir una nueva confidencia</h2>
                                    <p class="diary-section-sub">Deja que tus palabras fluyan con libertad. Puedes elegir una semilla de inspiración o escribir directamente lo que siente tu corazón hoy.</p>
                                </div>
                            </div>

                            <!-- Semillas de inspiración interactivas -->
                            <div class="diary-inspiration-box" aria-label="Semillas de inspiración para tu diario">
                                <span class="diary-inspiration-label">✨ Semillas de inspiración para empezar:</span>
                                <div class="diary-seed-chips">
                                    <button type="button" class="diary-seed-chip" data-diary-seed-title="Lo que hizo sonreír a mi corazón hoy" data-diary-seed-category="Gratitud" data-diary-seed-excerpt="Un instante luminoso que quiero atesorar siempre." data-diary-seed-prompt="Hoy quiero agradecer profundamente por ">
                                        🌹 Gratitud de hoy
                                    </button>
                                    <button type="button" class="diary-seed-chip" data-diary-seed-title="Un recuerdo que abraza el alma" data-diary-seed-category="Memoria" data-diary-seed-excerpt="Al cerrar los ojos, este momento vuelve a brillar." data-diary-seed-prompt="Hay un instante que guardo como una joya en mi memoria: ">
                                        ✨ Recuerdo inolvidable
                                    </button>
                                    <button type="button" class="diary-seed-chip" data-diary-seed-title="Un sueño que empieza a florecer" data-diary-seed-category="Sueños" data-diary-seed-excerpt="Semillas para el futuro que estoy construyendo." data-diary-seed-prompt="En el jardín de mis próximos pasos, sueño con ">
                                        💭 Sueño o anhelo
                                    </button>
                                    <button type="button" class="diary-seed-chip" data-diary-seed-title="Carta íntima para mí misma" data-diary-seed-category="Amor propio" data-diary-seed-excerpt="Palabras dulces para recordar mi propia fuerza y ternura." data-diary-seed-prompt="Querida Carla, hoy quiero recordarte con todo el amor que ">
                                        💌 Nota para mí
                                    </button>
                                </div>
                            </div>

                            <form class="post-create-form diary-create-form" method="POST" action="{{ route('entries.store') }}">
                                @csrf
                                <input type="hidden" name="kind" value="diary">

                                <div class="diary-field-group">
                                    <label for="diary-new-title">🌹 Título de tu página íntima</label>
                                    <input id="diary-new-title" name="title" maxlength="160" value="{{ old('kind') === 'diary' ? old('title') : '' }}" required placeholder="Ej.: Una nota para mí, el perfume de esta tarde…">
                                </div>

                                <div class="diary-field-group">
                                    <label for="diary-new-category">🌸 Tema o estado del corazón <span>(opcional)</span></label>
                                    <input id="diary-new-category" name="category" maxlength="80" value="{{ old('kind') === 'diary' ? old('category') : '' }}" placeholder="Hoy, gratitud, sueños, calma, ideas…">
                                    <div class="diary-mood-tags" aria-label="Temas rápidos">
                                        <button type="button" class="diary-mood-tag" data-diary-mood="Gratitud">🌸 Gratitud</button>
                                        <button type="button" class="diary-mood-tag" data-diary-mood="Reflexión">🕯️ Reflexión</button>
                                        <button type="button" class="diary-mood-tag" data-diary-mood="Sueños">💫 Sueños</button>
                                        <button type="button" class="diary-mood-tag" data-diary-mood="Memoria">📖 Memoria</button>
                                        <button type="button" class="diary-mood-tag" data-diary-mood="Amor propio">❤️ Amor propio</button>
                                    </div>
                                </div>

                                <div class="diary-field-group">
                                    <label for="diary-new-excerpt">✨ Nota breve o susurro destacado <span>(opcional · epígrafe de la página)</span></label>
                                    <textarea id="diary-new-excerpt" name="excerpt" maxlength="500" rows="2" placeholder="Un detalle esencial o frase corta que resuma la emoción de este momento.">{{ old('kind') === 'diary' ? old('excerpt') : '' }}</textarea>
                                </div>

                                <div class="diary-field-group">
                                    <div class="diary-body-label-row">
                                        <label for="diary-new-body">✒️ Entrada privada completa</label>
                                        <span id="diary-word-counter" class="diary-word-counter" aria-live="polite">0 palabras · Privado</span>
                                    </div>
                                    <textarea id="diary-new-body" class="diary-parchment-textarea" name="body" maxlength="30000" rows="7" required placeholder="Escribe sin prisa. Este texto es estrictamente confidencial y nunca será público…">{{ old('kind') === 'diary' ? old('body') : '' }}</textarea>
                                </div>

                                <div class="diary-form-footer">
                                    <span class="diary-seal-note">🔒 Guardado bajo llave en tu cofre personal</span>
                                    <button class="button button-primary diary-submit-btn" type="submit">
                                        🌹 Guardar en mi diario <span aria-hidden="true">↗</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Columna Derecha: Archivo e Historial de Páginas Íntimas -->
                        <div class="diary-archive-panel">
                            <div class="diary-archive-header">
                                <div>
                                    <span class="eyebrow diary-eyebrow-crimson">COFRE DE MEMORIAS · ARCHIVO PERSONAL</span>
                                    <h2 class="diary-section-title">Mis páginas guardadas</h2>
                                    <p class="diary-section-sub">Relee, edita o busca entre tus confidencias pasadas cuando quieras volver a abrazar un recuerdo.</p>
                                </div>
                                <span class="diary-archive-count-badge">
                                    {{ isset($diaryPosts) ? $diaryPosts->count() : 0 }} {{ (isset($diaryPosts) && $diaryPosts->count() === 1) ? 'entrada' : 'entradas' }}
                                </span>
                            </div>

                            @if(isset($diaryPosts) && $diaryPosts->count() > 0)
                                <div class="diary-search-bar">
                                    <label for="diary-search-input" class="sr-only">Buscar en mi diario</label>
                                    <input id="diary-search-input" type="search" class="diary-search-input" placeholder="🔍 Buscar por palabra, título, emoción o tema en tu diario…">
                                </div>
                            @endif

                            <div class="diary-entry-list" id="diary-entry-list">
                                @forelse ($diaryPosts as $post)
                                    @include('posts.manage-card', ['post' => $post])
                                @empty
                                    <div class="diary-empty-sanctuary">
                                        <div class="diary-empty-icon" aria-hidden="true">
                                            <svg viewBox="0 0 64 64" fill="none">
                                                <rect x="14" y="10" width="36" height="44" rx="6" fill="#fff5f7" stroke="#9e2a47" stroke-width="2"/>
                                                <path d="M22 22H42M22 30H38M22 38H34" stroke="#d4af37" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="32" cy="46" r="3" fill="#be123c"/>
                                            </svg>
                                        </div>
                                        <h3>Tu códice íntimo aguarda su primera página</h3>
                                        <p class="empty-albums">Tu primera entrada privada aparecerá aquí. El diario no se publica y permanece siempre bajo tu llave personal.</p>
                                    </div>
                                @endforelse
                            </div>
                            <p id="diary-search-empty" class="diary-search-empty" hidden>No se encontraron páginas en tu diario que coincidan con esa búsqueda.</p>
                        </div>
                    </div>
                @else
                    <!-- Estado sin sesión: Santuario Privado Bajo Llave -->
                    <div class="personal-panel diary-locked-sanctuary">
                        <div class="diary-locked-emblem" aria-hidden="true">
                            <span class="personal-avatar diary-locked-avatar">♡</span>
                            <span class="diary-locked-key-badge">🔒 BAJO LLAVE</span>
                        </div>
                        <div class="diary-locked-content">
                            <span class="eyebrow diary-eyebrow-crimson">CONTENIDO PRIVADO · SANTUARIO ÍNTIMO DE CARLA LORENA</span>
                            <h2>El diario no es público · Cofre de confidencias</h2>
                            <p>
                                Este rincón resguarda las páginas más íntimas, reflexiones, sueños y notas personales de Carla. Ningún texto escrito aquí se publica en el blog ni está abierto a visitantes. Inicia sesión con tu llave personal para escribir o releer tus memorias.
                            </p>
                            <div class="diary-locked-pillars">
                                <span class="diary-pillar-chip">🔒 Cifrado en tu rincón privado</span>
                                <span class="diary-pillar-chip">🌹 Nunca visible en el blog público</span>
                                <span class="diary-pillar-chip">✒️ Escritura libre y sin comentarios</span>
                            </div>
                            <a class="button button-primary diary-login-cta" href="{{ route('login') }}">
                                Entrar a mi espacio <span aria-hidden="true">↗</span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </section>
