        <section class="screen" data-screen="albumes" aria-labelledby="albums-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#carla" data-go="carla">← Volver a mi espacio</a>
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Colecciones personales & Recuerdos</p>
                        <h1 id="albums-title">Mis <em>álbumes</em></h1>
                        <p>Tus colecciones son privadas y solo tú puedes verlas.</p>
                    </div>
                    <div class="scrapbook-toggle-wrap">
                        <button type="button" id="toggle-scrapbook-view-btn" class="button button-outline button-sm">
                            <span class="scrapbook-icon">📖</span> <span id="scrapbook-btn-text">Modo Libro Scrapbook</span>
                        </button>
                    </div>
                </div>
                @auth
                    <form class="album-create-form" method="POST" action="{{ route('albums.store') }}">
                        @csrf
                        <div><label for="new-album-title">Nombre del álbum</label><input id="new-album-title" name="title" maxlength="120" placeholder="Por ejemplo, Días de primavera" required></div>
                        <div><label for="new-album-description">Descripción <span>(opcional)</span></label><input id="new-album-description" name="description" maxlength="4000" placeholder="¿Qué quieres guardar aquí?"></div>
                        <button class="button button-primary" type="submit">＋ Crear un álbum</button>
                    </form>
                    @if ($errors->any())
                        <div class="form-errors album-errors" role="alert"><p>No se pudo guardar. Revisa los campos e inténtalo de nuevo.</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    <div class="owned-albums">
                        @forelse ($albums as $album)
                            <article class="owned-album">
                                <div class="owned-album-heading"><div><span class="eyebrow">ÁLBUM PRIVADO · {{ $album->photos->count() }} FOTOGRAFÍAS</span><h2>{{ $album->title }}</h2><p>{{ $album->description ?: 'Una colección para guardar pequeños momentos.' }}</p></div>
                                    <form method="POST" action="{{ route('albums.destroy', $album) }}" data-confirm="¿Eliminar este álbum y sus fotografías? Esta acción no se puede deshacer.">@csrf @method('DELETE')<button class="text-link danger-link" type="submit">Eliminar álbum</button></form>
                                </div>
                                <details class="album-edit"><summary>Editar título o descripción</summary><form class="album-edit-form" method="POST" action="{{ route('albums.update', $album) }}">@csrf @method('PUT')<label for="album-title-{{ $album->id }}">Título</label><input id="album-title-{{ $album->id }}" name="title" maxlength="120" value="{{ $album->title }}" required><label for="album-description-{{ $album->id }}">Descripción</label><textarea id="album-description-{{ $album->id }}" name="description" maxlength="4000" rows="2">{{ $album->description }}</textarea><button class="button button-outline" type="submit">Guardar cambios</button></form></details>
                                <form class="photo-upload-form" method="POST" enctype="multipart/form-data" action="{{ route('albums.photos.store', $album) }}">@csrf<label for="photo-{{ $album->id }}">Añadir fotografías <span>(JPG, PNG o WebP; hasta 10 MB)</span></label><input id="photo-{{ $album->id }}" name="photo" type="file" accept="image/jpeg,image/png,image/webp" required><label for="photo-title-{{ $album->id }}">Título</label><input id="photo-title-{{ $album->id }}" name="title" maxlength="120" placeholder="Título de la fotografía" required><label for="photo-description-{{ $album->id }}">Descripción <span>(opcional)</span></label><input id="photo-description-{{ $album->id }}" name="description" maxlength="4000" placeholder="Añade un detalle"><button class="button button-outline" type="submit">Subir al álbum <span>↗</span></button></form>
                                @if ($album->photos->isNotEmpty())
                                    <div class="owned-photo-grid">
                                        @foreach ($album->photos as $photo)
                                            <article class="owned-photo">
                                                <a href="{{ route('photos.show', $photo) }}" target="_blank" rel="noreferrer"><img src="{{ route('photos.show', $photo) }}" alt="{{ $photo->title }}" loading="lazy"></a>
                                                <form method="POST" action="{{ route('photos.update', $photo) }}">@csrf @method('PUT')<label class="visually-hidden" for="photo-edit-title-{{ $photo->id }}">Título de {{ $photo->title }}</label><input id="photo-edit-title-{{ $photo->id }}" name="title" maxlength="120" value="{{ $photo->title }}" required><label class="visually-hidden" for="photo-edit-description-{{ $photo->id }}">Descripción de {{ $photo->title }}</label><input name="description" maxlength="4000" value="{{ $photo->description }}" placeholder="Descripción"><button class="text-link" type="submit">Guardar texto</button></form>
                                                <div class="owned-photo-actions"><form method="POST" action="{{ route('photos.favorite', $photo) }}">@csrf @method('PATCH')<input type="hidden" name="is_favorite" value="{{ $photo->is_favorite ? '0' : '1' }}"><input type="hidden" name="return_to" value="albumes"><button class="text-link favorite-toggle" type="submit" aria-label="{{ $photo->is_favorite ? 'Quitar de favoritos' : 'Guardar en favoritos' }}">{{ $photo->is_favorite ? '♥ En favoritos' : '♡ Guardar favorito' }}</button></form><form method="POST" action="{{ route('photos.destroy', $photo) }}" data-confirm="¿Eliminar esta fotografía?">@csrf @method('DELETE')<button class="text-link danger-link" type="submit">Eliminar</button></form></div>
                                            </article>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @empty
                            <div class="empty-albums"><span class="note-flower" aria-hidden="true">✿</span><p>Tu primer álbum aparecerá aquí cuando lo crees.</p></div>
                        @endforelse
                    </div>
                @else
                    <div class="personal-panel"><span class="personal-avatar" aria-hidden="true">♡</span><div><span class="eyebrow">CONTENIDO PRIVADO</span><h2>Inicia sesión para ver tus álbumes</h2><p>El contenido personal no está disponible sin una cuenta autorizada.</p><a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span>↗</span></a></div></div>
                @endauth
            </div>
        </section>
