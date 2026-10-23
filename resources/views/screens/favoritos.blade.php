        <section class="screen" data-screen="favoritos" aria-labelledby="favorites-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#carla" data-go="carla">← Volver a mi espacio</a>
                <div class="page-heading"><div><p class="eyebrow">Tu colección personal</p><h1 id="favorites-title">Mis <em>favoritos</em></h1><p>Fotografías guardadas para volver a encontrarlas fácilmente. Solo tú puedes verlas.</p></div><span class="heading-mark" aria-hidden="true">♡</span></div>
                @auth
                    @if ($favoritePhotos->isNotEmpty())
                        <div class="favorite-photo-grid">
                            @foreach ($favoritePhotos as $photo)
                                <article class="favorite-photo">
                                    <a class="favorite-photo-image" href="{{ route('photos.show', $photo) }}" target="_blank" rel="noreferrer">
                                        <img src="{{ route('photos.show', $photo) }}" alt="{{ $photo->title }}" loading="lazy">
                                    </a>
                                    <div class="favorite-photo-copy">
                                        <span class="eyebrow">{{ $photo->album->title }}</span>
                                        <h2>{{ $photo->title }}</h2>
                                        @if ($photo->description)
                                            <p>{{ $photo->description }}</p>
                                        @endif
                                        <form method="POST" action="{{ route('photos.favorite', $photo) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_favorite" value="0">
                                            <input type="hidden" name="return_to" value="favoritos">
                                            <button class="text-link favorite-toggle" type="submit">Quitar de favoritos</button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="favorites-empty">
                            <span aria-hidden="true">♡</span>
                            <h2>Aún no has guardado favoritos</h2>
                            <p>Desde tus álbumes, marca una fotografía para encontrarla aquí.</p>
                            <a class="button button-primary" href="#albumes" data-go="albumes">Explorar mis álbumes <span aria-hidden="true">↗</span></a>
                        </div>
                    @endif
                @else
                    <div class="personal-panel"><span class="personal-avatar" aria-hidden="true">♡</span><div><span class="eyebrow">CONTENIDO PRIVADO</span><h2>Esta colección es solo tuya</h2><p>Inicia sesión para consultar las fotografías que guardaste.</p><a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span aria-hidden="true">↗</span></a></div></div>
                @endauth
            </div>
        </section>
