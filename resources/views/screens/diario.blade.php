        <section class="screen" data-screen="diario" aria-labelledby="diary-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#carla" data-go="carla">← Volver a mi espacio</a>
                <div class="page-heading"><div><p class="eyebrow">Solo visible con tu sesión</p><h1 id="diary-title">Mi <em>diario</em></h1><p>Estas entradas nunca aparecen en el blog público y no tienen comentarios.</p></div><span class="heading-mark" aria-hidden="true">⌑</span></div>
                @auth
                    @if ($errors->any())
                        <div class="form-errors entry-errors" role="alert"><p>No se pudo guardar la entrada.</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    @if (session('status'))
                        <p class="form-success" role="status">{{ session('status') }}</p>
                    @endif
                    <form class="post-create-form diary-create-form" method="POST" action="{{ route('entries.store') }}">
                        @csrf
                        <input type="hidden" name="kind" value="diary">
                        <label for="diary-new-title">Título</label><input id="diary-new-title" name="title" maxlength="160" value="{{ old('kind') === 'diary' ? old('title') : '' }}" required placeholder="Una nota para mí">
                        <label for="diary-new-category">Tema <span>(opcional)</span></label><input id="diary-new-category" name="category" maxlength="80" value="{{ old('kind') === 'diary' ? old('category') : '' }}" placeholder="Hoy, ideas…">
                        <label for="diary-new-excerpt">Nota breve <span>(opcional)</span></label><textarea id="diary-new-excerpt" name="excerpt" maxlength="500" rows="2" placeholder="Un detalle que quieras recordar.">{{ old('kind') === 'diary' ? old('excerpt') : '' }}</textarea>
                        <label for="diary-new-body">Entrada privada</label><textarea id="diary-new-body" name="body" maxlength="30000" rows="5" required placeholder="Este texto no será público.">{{ old('kind') === 'diary' ? old('body') : '' }}</textarea>
                        <button class="button button-primary" type="submit">Guardar en mi diario <span aria-hidden="true">↗</span></button>
                    </form>
                    <div class="diary-entry-list">
                        @forelse ($diaryPosts as $post)
                            @include('posts.manage-card', ['post' => $post])
                        @empty
                            <p class="empty-albums">Tu primera entrada privada aparecerá aquí. El diario no se publica.</p>
                        @endforelse
                    </div>
                @else
                    <div class="personal-panel"><span class="personal-avatar" aria-hidden="true">♡</span><div><span class="eyebrow">CONTENIDO PRIVADO</span><h2>El diario no es público</h2><p>Inicia sesión para escribir o leer tus entradas personales.</p><a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span aria-hidden="true">↗</span></a></div></div>
                @endauth
            </div>
        </section>
