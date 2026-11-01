        <section class="screen" data-screen="blog" aria-labelledby="blog-title" hidden>
            <div class="page-shell blog-page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>
                <div class="page-heading"><div><p class="eyebrow">Notas que pueden compartirse</p><h1 id="blog-title">El blog del <em>jardín</em></h1><p>Artículos públicos, pequeñas ideas e inspiración. Sin comentarios: solo lecturas tranquilas.</p></div><span class="heading-mark" aria-hidden="true">✎</span></div>
                @if ($publicProfile)
                    <article class="garden-profile-public" aria-labelledby="garden-profile-name">
                        @if ($publicProfile->featured_photo_path)
                            <img class="garden-profile-photo" src="{{ route('profiles.featured-photo', $publicProfile) }}" alt="Fotografía destacada de {{ $publicProfile->user->name }}">
                        @endif
                        <div class="garden-profile-content">
                            <p class="eyebrow">UN POCO SOBRE MÍ</p>
                            <h2 id="garden-profile-name">{{ $publicProfile->user->name }}</h2>
                            @if ($publicProfile->profession)<p class="garden-profile-profession">{{ $publicProfile->profession }}</p>@endif
                            @if ($publicProfile->biography)<p class="garden-profile-biography">{{ $publicProfile->biography }}</p>@endif
                            <div class="garden-profile-facts">
                                @foreach ([
                                    'Estudios' => $publicProfile->education,
                                    'Experiencia' => $publicProfile->experience,
                                    'Logros y proyectos' => $publicProfile->achievements,
                                    'Intereses' => $publicProfile->interests,
                                    'Otros datos' => $publicProfile->additional_info,
                                ] as $label => $details)
                                    @if ($details)
                                        <section><h3>{{ $label }}</h3><p>{{ $details }}</p></section>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endif
                <div class="blog-tools">
                    <label class="visually-hidden" for="blog-search">Buscar publicaciones</label>
                    <input id="blog-search" data-blog-search type="search" placeholder="Buscar en el blog…" autocomplete="off">
                    <div class="filter-group" role="group" aria-label="Filtrar publicaciones del blog">
                        <button class="filter-chip is-selected" type="button" data-blog-filter="todos" aria-pressed="true">Todas</button>
                        @if ($blogPosts->isEmpty())
                            <button class="filter-chip" type="button" data-blog-filter="inspiracion" aria-pressed="false">Inspiración</button>
                            <button class="filter-chip" type="button" data-blog-filter="pequenas cosas" aria-pressed="false">Pequeñas cosas</button>
                        @else
                            @foreach ($blogPosts->pluck('category')->filter()->unique() as $category)
                                <button class="filter-chip" type="button" data-blog-filter="{{ mb_strtolower($category) }}" aria-pressed="false">{{ $category }}</button>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="blog-post-grid" data-blog-list>
                    @forelse ($blogPosts as $post)
                        <article class="blog-card" data-blog-card data-category="{{ mb_strtolower($post->category ?? '') }}" data-search="{{ mb_strtolower($post->title.' '.$post->excerpt.' '.$post->category) }}">
                            <!-- Barra botánica superior -->
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">✍️ ❦</span>
                                <span class="card-number">{{ $post->category ?: 'NOTAS DEL JARDÍN' }} · BLOG</span>
                            </div>
                            <span class="eyebrow">{{ $post->created_at->translatedFormat('j \d\e F, Y') }}</span>
                            <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
                            <!-- Divisor floral -->
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>{{ $post->excerpt ?: \Illuminate\Support\Str::limit($post->body, 180) }}</p>
                            <span class="card-mini-quote">«Cada historia es un pétalo que florece en el tiempo.»</span>
                            <!-- Footer de la tarjeta -->
                            <div class="blog-card-footer">
                                <a class="text-link" href="{{ route('blog.show', $post->slug) }}">Leer publicación <span>→</span></a>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </article>
                    @empty
                        <article class="blog-card blog-demo-card" data-blog-card data-demo-card data-category="inspiracion" data-search="el arte de ir despacio inspiración">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">✍️ ❦</span>
                                <span class="card-number">INSPIRACIÓN · EJEMPLO</span>
                            </div>
                            <span class="eyebrow">EJEMPLO EDITORIAL</span>
                            <h2>El arte de ir un poco más despacio</h2>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Una nota de demostración sobre hacer espacio para los pequeños momentos de calma del día.</p>
                            <span class="card-mini-quote">«Ir despacio es el arte de notar la belleza del camino.»</span>
                            <div class="blog-card-footer">
                                <span class="text-link">Lectura de muestra</span>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </article>
                        <article class="blog-card blog-demo-card" data-blog-card data-demo-card data-category="pequenas cosas" data-search="guardar luz en los bolsillos pequeñas cosas">
                            <div class="card-top-bar">
                                <span class="card-icon-emblem">🌸 ❦</span>
                                <span class="card-number">PEQUEÑAS COSAS · EJEMPLO</span>
                            </div>
                            <span class="eyebrow">EJEMPLO EDITORIAL</span>
                            <h2>Guardar un poco de luz en los bolsillos</h2>
                            <div class="blog-card-divider" aria-hidden="true">
                                <span class="divider-line"></span>
                                <span class="divider-rose">❦</span>
                                <span class="divider-line"></span>
                            </div>
                            <p>Un texto ficticio para imaginar un cuaderno de ideas, lugares y descubrimientos cotidianos.</p>
                            <span class="card-mini-quote">«La luz más bonita es la que guardamos en los detalles.»</span>
                            <div class="blog-card-footer">
                                <span class="text-link">Lectura de muestra</span>
                                <span class="blog-card-seal" aria-hidden="true">❦</span>
                            </div>
                        </article>
                    @endforelse
                </div>
                <p class="blog-empty" data-blog-empty role="status" hidden>No encontramos publicaciones con esa búsqueda.</p>
                <p class="demo-disclaimer">El blog no admite comentarios. Las tarjetas marcadas como ejemplo son contenido editorial ficticio, no publicaciones de Carla.</p>
                @auth
                    @if ($errors->any())
                        <div class="form-errors entry-errors" role="alert"><p>No se pudo guardar la información.</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    @if (session('status'))
                        <p class="form-success" role="status">{{ session('status') }}</p>
                    @endif

                    <!-- ===============================================================
                         1. MI PERFIL Y FOTOGRAFÍA DESTACADA (ATELIER DE BIOGRAFÍA)
                         =============================================================== -->
                    <section class="editor-section profile-editor-section blog-studio-section" aria-labelledby="profile-editor-title">
                        <header class="blog-studio-header">
                            <div class="blog-studio-header-main">
                                <div class="blog-studio-icon-badge" aria-hidden="true">
                                    <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
                                        <circle cx="18" cy="18" r="16" fill="#fff0f4" stroke="#9e2a47" stroke-width="1.8"/>
                                        <circle cx="18" cy="14" r="4.5" stroke="#9e2a47" stroke-width="1.8"/>
                                        <path d="M10.5 26.5C11.8 22.8 14.6 21 18 21C21.4 21 24.2 22.8 25.5 26.5" stroke="#9e2a47" stroke-width="1.8" stroke-linecap="round"/>
                                        <circle cx="26.5" cy="10.5" r="2.5" fill="#d4af37"/>
                                    </svg>
                                </div>
                                <div class="editor-section-heading blog-studio-heading-copy">
                                    <p class="eyebrow blog-eyebrow-crimson">✦ TU PERFIL · PRIVADO HASTA QUE LO PUBLIQUES</p>
                                    <h2 id="profile-editor-title" class="blog-studio-title">Mi perfil y fotografía destacada</h2>
                                    <p>Completa solo lo que quieras compartir. Estudios y experiencia aceptan una entrada por línea. El borrador y la imagen quedan privados; al publicar, el perfil y su fotografía serán visibles para quienes visiten el blog.</p>
                                </div>
                            </div>

                            <div class="blog-studio-status-pills">
                                @if ($editableProfile?->status === 'published')
                                    <span class="blog-studio-pill is-published">🌸 Perfil publicado en el blog</span>
                                @else
                                    <span class="blog-studio-pill is-draft">🔒 Guardado como borrador privado</span>
                                @endif
                                <span class="blog-studio-pill">🌹 Retrato editorial & biografía</span>
                            </div>
                        </header>

                        <form class="post-create-form garden-profile-form blog-profile-atelier-form" method="POST" action="{{ route('profile.save') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="blog-profile-atelier-grid">
                                <!-- Columna Izquierda: Retrato Principal & Esencia Personal -->
                                <div class="blog-profile-col">
                                    <div class="blog-profile-card-block portrait-uploader-block">
                                        <div class="blog-block-header">
                                            <span class="blog-block-badge">📸 RETRATO PRINCIPAL</span>
                                            <h3>Fotografía destacada del perfil</h3>
                                            <p>Se mostrará en el medallón de presentación de tu blog cuando decidas publicar tu perfil.</p>
                                        </div>

                                        <div class="portrait-upload-frame">
                                            @if ($editableProfile?->featured_photo_path)
                                                <div class="garden-profile-photo-preview">
                                                    <img id="profile-live-photo-img" src="{{ route('profiles.featured-photo', $editableProfile) }}" alt="Vista previa privada de la fotografía destacada actual">
                                                    <div class="portrait-preview-meta">
                                                        <span class="portrait-active-tag">✨ Fotografía activa guardada</span>
                                                        <label class="portrait-remove-check">
                                                            <input type="checkbox" name="remove_photo" value="1">
                                                            Quitar la fotografía actual
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="portrait-empty-placeholder" id="profile-photo-placeholder">
                                                    <div class="portrait-placeholder-circle" aria-hidden="true">🌹</div>
                                                    <div>
                                                        <strong>Retrato de Carla Lorena</strong>
                                                        <span>Sube una imagen vertical o cuadrada para acompañar tu biografía editorial.</span>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="blog-field-unit portrait-file-unit">
                                                <label for="profile-featured-photo">Fotografía principal destacada <span>(JPG, PNG o WebP; máximo 10 MB)</span></label>
                                                <input id="profile-featured-photo" name="featured_photo" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="blog-profile-card-block">
                                        <div class="blog-block-header">
                                            <span class="blog-block-badge">🌹 ESENCIA & PRESENTACIÓN</span>
                                            <h3>Quién soy y qué me inspira</h3>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-profession">Profesión o presentación breve</label>
                                            <input id="profile-profession" name="profession" maxlength="160" value="{{ old('profession', $editableProfile?->profession) }}" placeholder="Ej.: Médica especialista">
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-biography">Sobre mí</label>
                                            <textarea id="profile-biography" name="biography" maxlength="5000" rows="4" placeholder="Una presentación en tus propias palabras.">{{ old('biography', $editableProfile?->biography) }}</textarea>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-interests">Intereses y temas que te inspiran</label>
                                            <textarea id="profile-interests" name="interests" maxlength="10000" rows="3" placeholder="Intereses profesionales, creativos o personales que quieras compartir.">{{ old('interests', $editableProfile?->interests) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Columna Derecha: Trayectoria, Estudios y Logros -->
                                <div class="blog-profile-col">
                                    <div class="blog-profile-card-block">
                                        <div class="blog-block-header">
                                            <span class="blog-block-badge">🎓 TRAYECTORIA & FORMACIÓN</span>
                                            <h3>Recorrido académico, experiencia y logros</h3>
                                            <p>Puedes escribir un hito por línea para que se presente de forma ordenada y elegante.</p>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-education">Estudios y formación <span>(una entrada por línea)</span></label>
                                            <textarea id="profile-education" name="education" maxlength="10000" rows="4" placeholder="Una carrera, especialidad o formación por línea.">{{ old('education', $editableProfile?->education) }}</textarea>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-experience">Experiencia profesional <span>(una entrada por línea)</span></label>
                                            <textarea id="profile-experience" name="experience" maxlength="10000" rows="4" placeholder="Roles, áreas de trabajo o hitos que desees destacar.">{{ old('experience', $editableProfile?->experience) }}</textarea>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-achievements">Logros, proyectos o publicaciones</label>
                                            <textarea id="profile-achievements" name="achievements" maxlength="10000" rows="3" placeholder="Proyectos, reconocimientos o contribuciones.">{{ old('achievements', $editableProfile?->achievements) }}</textarea>
                                        </div>

                                        <div class="blog-field-unit">
                                            <label for="profile-additional">Otros datos relevantes</label>
                                            <textarea id="profile-additional" name="additional_info" maxlength="10000" rows="3" placeholder="Puedes añadir cualquier otra información que consideres importante.">{{ old('additional_info', $editableProfile?->additional_info) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-publish-actions blog-studio-action-bar">
                                <span class="blog-studio-privacy-note">
                                    🔒 Tu perfil permanece privado mientras esté en borrador. Al publicarlo, se mostrará en la cabecera del blog.
                                </span>
                                <div class="blog-studio-action-buttons">
                                    <button class="button button-outline blog-draft-btn" type="submit" name="status" value="draft">
                                        🔒 Guardar como borrador privado
                                    </button>
                                    <button class="button button-primary blog-publish-btn" type="submit" name="status" value="published" onclick="return confirm('¿Publicar el perfil y hacer visibles estos datos y la fotografía destacada en el blog?')">
                                        🌸 Publicar perfil en el blog
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <!-- ===============================================================
                         2. SOLO TÚ PUEDES EDITARLO · MIS BORRADORES Y PUBLICACIONES
                         =============================================================== -->
                    <section class="editor-section blog-editorial-desk-section blog-studio-section" aria-labelledby="blog-editor-title">
                        @php
                            $totalBlogEntries = isset($editableBlogPosts) ? $editableBlogPosts->count() : 0;
                            $publishedBlogCount = isset($editableBlogPosts) ? $editableBlogPosts->where('status', 'published')->count() : 0;
                            $draftBlogCount = isset($editableBlogPosts) ? $editableBlogPosts->where('status', 'draft')->count() : 0;
                        @endphp

                        <header class="blog-studio-header">
                            <div class="blog-studio-header-main">
                                <div class="blog-studio-icon-badge" aria-hidden="true">
                                    <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
                                        <rect x="7" y="6" width="22" height="24" rx="5" fill="#fff0f4" stroke="#9e2a47" stroke-width="1.8"/>
                                        <path d="M12 13H24M12 18H22M12 23H18" stroke="#9e2a47" stroke-width="1.8" stroke-linecap="round"/>
                                        <circle cx="24" cy="24" r="4" fill="#d4af37"/>
                                    </svg>
                                </div>
                                <div class="editor-section-heading blog-studio-heading-copy">
                                    <p class="eyebrow blog-eyebrow-crimson">✦ SOLO TÚ PUEDES EDITARLO · TALLER DE PUBLICACIONES</p>
                                    <h2 id="blog-editor-title" class="blog-studio-title">Mis borradores y publicaciones</h2>
                                    <p>Todo empieza como borrador. Solo se hará público cuando pulses «Publicar» y confirmes la acción.</p>
                                </div>
                            </div>

                            <div class="blog-studio-status-pills">
                                <span class="blog-studio-pill">📚 <strong>{{ $totalBlogEntries }}</strong> {{ $totalBlogEntries === 1 ? 'artículo total' : 'artículos totales' }}</span>
                                <span class="blog-studio-pill is-published">🌸 <strong>{{ $publishedBlogCount }}</strong> {{ $publishedBlogCount === 1 ? 'publicado' : 'publicados' }}</span>
                                <span class="blog-studio-pill is-draft">🌿 <strong>{{ $draftBlogCount }}</strong> {{ $draftBlogCount === 1 ? 'borrador' : 'borradores' }}</span>
                            </div>
                        </header>

                        <div class="blog-desk-grid">
                            <!-- Columna Izquierda: Redactor de Nuevo Artículo -->
                            <div class="blog-desk-composer-card">
                                <div class="blog-block-header">
                                    <span class="blog-block-badge">✍️ NUEVO ARTÍCULO DEL JARDÍN</span>
                                    <h3>Redactar nuevo borrador</h3>
                                    <p>Escribe tu historia con calma; se guardará primero como borrador privado para que puedas revisarla antes de publicarla.</p>
                                </div>

                                <div class="blog-category-quick-picks" aria-label="Categorías sugeridas para el blog">
                                    <span class="blog-quick-picks-label">✨ Categorías sugeridas:</span>
                                    <div class="blog-quick-picks-row">
                                        <button type="button" class="blog-quick-cat-chip" data-blog-pick-category="Inspiración">🌸 Inspiración</button>
                                        <button type="button" class="blog-quick-cat-chip" data-blog-pick-category="Pequeñas cosas">🌿 Pequeñas cosas</button>
                                        <button type="button" class="blog-quick-cat-chip" data-blog-pick-category="Lecturas">📖 Lecturas</button>
                                        <button type="button" class="blog-quick-cat-chip" data-blog-pick-category="Reflexiones">✨ Reflexiones</button>
                                        <button type="button" class="blog-quick-cat-chip" data-blog-pick-category="Vida cotidiana">🌹 Vida cotidiana</button>
                                    </div>
                                </div>

                                <form class="post-create-form blog-atelier-create-form" method="POST" action="{{ route('entries.store') }}">
                                    @csrf
                                    <input type="hidden" name="kind" value="blog">

                                    <div class="blog-field-unit">
                                        <label for="blog-new-title">🌹 Título</label>
                                        <input id="blog-new-title" name="title" maxlength="160" value="{{ old('kind') === 'blog' ? old('title') : '' }}" required placeholder="Una idea para compartir">
                                    </div>

                                    <div class="blog-field-unit">
                                        <label for="blog-new-category">🌸 Categoría <span>(opcional)</span></label>
                                        <input id="blog-new-category" name="category" maxlength="80" value="{{ old('kind') === 'blog' ? old('category') : '' }}" placeholder="Inspiración, lecturas…">
                                    </div>

                                    <div class="blog-field-unit">
                                        <label for="blog-new-excerpt">✨ Resumen <span>(opcional · introducción visible en la tarjeta)</span></label>
                                        <textarea id="blog-new-excerpt" name="excerpt" maxlength="500" rows="2" placeholder="Una introducción para quienes visiten el blog.">{{ old('kind') === 'blog' ? old('excerpt') : '' }}</textarea>
                                    </div>

                                    <div class="blog-field-unit">
                                        <div class="blog-body-label-row">
                                            <label for="blog-new-body">✒️ Texto</label>
                                            <span id="blog-word-counter" class="blog-word-counter" aria-live="polite">0 palabras · Borrador</span>
                                        </div>
                                        <textarea id="blog-new-body" class="blog-parchment-textarea" name="body" maxlength="30000" rows="6" required placeholder="Escribe aquí. El formato será texto sencillo.">{{ old('kind') === 'blog' ? old('body') : '' }}</textarea>
                                    </div>

                                    <div class="blog-composer-footer">
                                        <span class="blog-composer-hint">🌿 Se guarda como borrador privado inicialmente</span>
                                        <button class="button button-primary blog-publish-btn" type="submit">
                                            Guardar como borrador <span aria-hidden="true">↗</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Columna Derecha: Archivo de Borradores y Publicaciones -->
                            <div class="blog-desk-archive-card">
                                <div class="blog-archive-top-header">
                                    <div class="blog-block-header">
                                        <span class="blog-block-badge">🗂️ GESTOR DE PUBLICACIONES</span>
                                        <h3>Archivo de borradores y artículos</h3>
                                        <p>Publica borradores con un clic, retira publicaciones para editarlas en privado o actualiza cualquier texto.</p>
                                    </div>

                                    @if ($totalBlogEntries > 0)
                                        <div class="blog-manage-toolbar">
                                            <div class="blog-manage-status-tabs" role="group" aria-label="Filtrar por estado de publicación">
                                                <button type="button" class="blog-status-tab is-active" data-blog-manage-filter="all">Todos ({{ $totalBlogEntries }})</button>
                                                <button type="button" class="blog-status-tab" data-blog-manage-filter="draft">🌿 Borradores ({{ $draftBlogCount }})</button>
                                                <button type="button" class="blog-status-tab" data-blog-manage-filter="published">🌸 Publicados ({{ $publishedBlogCount }})</button>
                                            </div>
                                            <input id="blog-manage-search" type="search" class="blog-manage-search-input" placeholder="🔍 Filtrar mis borradores o publicaciones por título o tema…">
                                        </div>
                                    @endif
                                </div>

                                <div class="post-manage-list blog-atelier-manage-list">
                                    @forelse ($editableBlogPosts as $post)
                                        @include('posts.manage-card', ['post' => $post])
                                    @empty
                                        <div class="blog-manage-empty-box">
                                            <div class="blog-manage-empty-icon" aria-hidden="true">✍️</div>
                                            <h4>Tu cuaderno editorial está listo para estrenarse</h4>
                                            <p class="empty-albums">Tus borradores aparecerán aquí. Todavía no hay ninguno.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <p id="blog-manage-filter-empty" class="blog-manage-filter-empty" hidden>No hay entradas que coincidan con el filtro seleccionado.</p>
                            </div>
                        </div>
                    </section>
                @endauth
            </div>
        </section>
