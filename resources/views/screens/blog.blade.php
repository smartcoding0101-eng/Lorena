        <section class="screen" data-screen="blog" aria-labelledby="blog-title" hidden>
            <div class="page-shell">
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
                    <section class="editor-section profile-editor-section" aria-labelledby="profile-editor-title">
                        <div class="editor-section-heading">
                            <div>
                                <p class="eyebrow">TU PERFIL · PRIVADO HASTA QUE LO PUBLIQUES</p>
                                <h2 id="profile-editor-title">Mi perfil y fotografía destacada</h2>
                                <p>Completa solo lo que quieras compartir. Estudios y experiencia aceptan una entrada por línea. El borrador y la imagen quedan privados; al publicar, el perfil y su fotografía serán visibles para quienes visiten el blog.</p>
                            </div>
                        </div>
                        <form class="post-create-form garden-profile-form" method="POST" action="{{ route('profile.save') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="profile-profession">Profesión o presentación breve</label>
                            <input id="profile-profession" name="profession" maxlength="160" value="{{ old('profession', $editableProfile?->profession) }}" placeholder="Ej.: Médica especialista">

                            <label for="profile-biography">Sobre mí</label>
                            <textarea id="profile-biography" name="biography" maxlength="5000" rows="4" placeholder="Una presentación en tus propias palabras.">{{ old('biography', $editableProfile?->biography) }}</textarea>

                            <label for="profile-education">Estudios y formación</label>
                            <textarea id="profile-education" name="education" maxlength="10000" rows="4" placeholder="Una carrera, especialidad o formación por línea.">{{ old('education', $editableProfile?->education) }}</textarea>

                            <label for="profile-experience">Experiencia profesional</label>
                            <textarea id="profile-experience" name="experience" maxlength="10000" rows="4" placeholder="Roles, áreas de trabajo o hitos que desees destacar.">{{ old('experience', $editableProfile?->experience) }}</textarea>

                            <label for="profile-achievements">Logros, proyectos o publicaciones</label>
                            <textarea id="profile-achievements" name="achievements" maxlength="10000" rows="3" placeholder="Proyectos, reconocimientos o contribuciones.">{{ old('achievements', $editableProfile?->achievements) }}</textarea>

                            <label for="profile-interests">Intereses y temas que te inspiran</label>
                            <textarea id="profile-interests" name="interests" maxlength="10000" rows="3" placeholder="Intereses profesionales, creativos o personales que quieras compartir.">{{ old('interests', $editableProfile?->interests) }}</textarea>

                            <label for="profile-additional">Otros datos relevantes</label>
                            <textarea id="profile-additional" name="additional_info" maxlength="10000" rows="3" placeholder="Puedes añadir cualquier otra información que consideres importante.">{{ old('additional_info', $editableProfile?->additional_info) }}</textarea>

                            <label for="profile-featured-photo">Fotografía principal destacada <span>(JPG, PNG o WebP; máximo 10 MB)</span></label>
                            <input id="profile-featured-photo" name="featured_photo" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            @if ($editableProfile?->featured_photo_path)
                                <div class="garden-profile-photo-preview">
                                    <img src="{{ route('profiles.featured-photo', $editableProfile) }}" alt="Vista previa privada de la fotografía destacada actual">
                                    <label><input type="checkbox" name="remove_photo" value="1"> Quitar la fotografía actual</label>
                                </div>
                            @endif
                            <div class="profile-publish-actions">
                                <button class="button button-outline" type="submit" name="status" value="draft">Guardar como borrador privado</button>
                                <button class="button button-primary" type="submit" name="status" value="published" onclick="return confirm('¿Publicar el perfil y hacer visibles estos datos y la fotografía destacada en el blog?')">Publicar perfil en el blog</button>
                            </div>
                        </form>
                    </section>
                    <section class="editor-section" aria-labelledby="blog-editor-title">
                        <div class="editor-section-heading"><div><p class="eyebrow">SOLO TÚ PUEDES EDITARLO</p><h2 id="blog-editor-title">Mis borradores y publicaciones</h2><p>Todo empieza como borrador. Solo se hará público cuando pulses «Publicar» y confirmes la acción.</p></div></div>
                        <form class="post-create-form" method="POST" action="{{ route('entries.store') }}">
                            @csrf
                            <input type="hidden" name="kind" value="blog">
                            <label for="blog-new-title">Título</label><input id="blog-new-title" name="title" maxlength="160" value="{{ old('kind') === 'blog' ? old('title') : '' }}" required placeholder="Una idea para compartir">
                            <label for="blog-new-category">Categoría <span>(opcional)</span></label><input id="blog-new-category" name="category" maxlength="80" value="{{ old('kind') === 'blog' ? old('category') : '' }}" placeholder="Inspiración, lecturas…">
                            <label for="blog-new-excerpt">Resumen <span>(opcional)</span></label><textarea id="blog-new-excerpt" name="excerpt" maxlength="500" rows="2" placeholder="Una introducción para quienes visiten el blog.">{{ old('kind') === 'blog' ? old('excerpt') : '' }}</textarea>
                            <label for="blog-new-body">Texto</label><textarea id="blog-new-body" name="body" maxlength="30000" rows="5" required placeholder="Escribe aquí. El formato será texto sencillo.">{{ old('kind') === 'blog' ? old('body') : '' }}</textarea>
                            <button class="button button-primary" type="submit">Guardar como borrador <span aria-hidden="true">↗</span></button>
                        </form>
                        <div class="post-manage-list">
                            @forelse ($editableBlogPosts as $post)
                                @include('posts.manage-card', ['post' => $post])
                            @empty
                                <p class="empty-albums">Tus borradores aparecerán aquí. Todavía no hay ninguno.</p>
                            @endforelse
                        </div>
                    </section>
                @endauth
            </div>
        </section>
