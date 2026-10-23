<article class="post-manage-card">

    <!-- Barra botánica superior -->
    <div class="manage-card-topbar">
        <span class="manage-topbar-emblem">
            @if($post->kind === 'diary') 📖 @else ✍️ @endif
            ❦
            @if($post->status === 'published') 🌸 @else 🌿 @endif
        </span>
        <span class="manage-topbar-label">{{ $post->kind === 'diary' ? 'DIARIO PRIVADO' : 'BLOG · '.$post->status }}</span>
    </div>

    <div class="post-manage-heading">
        <div>
            <span class="eyebrow">{{ $post->kind === 'diary' ? 'DIARIO PRIVADO' : 'BLOG · '.$post->status }}</span>
            <h3>{{ $post->title }}</h3>
            <p>{{ $post->excerpt ?: 'Sin resumen.' }}</p>
            <!-- Mini-quote romántico -->
            <span class="manage-card-mini-quote">«{{ $post->kind === 'diary' ? 'Pensamiento guardado en el corazón del jardín' : 'Una historia florece lista para compartirse' }}»</span>
        </div>
        <form method="POST" action="{{ route('entries.destroy', $post) }}" data-confirm="¿Eliminar esta entrada? Esta acción no se puede deshacer.">
            @csrf
            @method('DELETE')
            <button class="text-link danger-link" type="submit">Eliminar</button>
        </form>
    </div>

    @if ($post->kind === 'blog' && $post->status === 'published')
        <a class="text-link post-preview-link" href="{{ route('blog.show', $post->slug) }}" target="_blank" rel="noreferrer">Ver publicación pública →</a>
    @endif

    <details class="album-edit post-edit">
        <summary>Editar entrada</summary>
        <form class="post-editor-form" method="POST" action="{{ route('entries.update', $post) }}">
            @csrf
            @method('PUT')
            <label for="entry-title-{{ $post->id }}">Título</label>
            <input id="entry-title-{{ $post->id }}" name="title" maxlength="160" value="{{ $post->title }}" required>
            <label for="entry-category-{{ $post->id }}">Categoría <span>(opcional)</span></label>
            <input id="entry-category-{{ $post->id }}" name="category" maxlength="80" value="{{ $post->category }}">
            <label for="entry-excerpt-{{ $post->id }}">Resumen <span>(opcional)</span></label>
            <textarea id="entry-excerpt-{{ $post->id }}" name="excerpt" maxlength="500" rows="2">{{ $post->excerpt }}</textarea>
            <label for="entry-body-{{ $post->id }}">Texto</label>
            <textarea id="entry-body-{{ $post->id }}" name="body" maxlength="30000" rows="6" required>{{ $post->body }}</textarea>
            <button class="button button-outline" type="submit">Guardar cambios</button>
        </form>
    </details>

    @if ($post->kind === 'blog')
        <div class="post-publication-actions">
            @if ($post->status === 'draft')
                <form method="POST" action="{{ route('entries.publish', $post) }}" data-confirm="Esta entrada pasará a ser visible para cualquier visitante. ¿Publicarla ahora?">
                    @csrf
                    <button class="button button-primary" type="submit">Publicar en el blog <span aria-hidden="true">↗</span></button>
                </form>
            @else
                <form method="POST" action="{{ route('entries.unpublish', $post) }}" data-confirm="Esta entrada dejará de estar visible y volverá a ser un borrador. ¿Continuar?">
                    @csrf
                    <button class="button button-outline" type="submit">Retirar del blog</button>
                </form>
            @endif
        </div>
    @endif

    <!-- Sello decorativo de cierre -->
    <div class="manage-card-seal" aria-hidden="true">
        <span>❦</span>
    </div>
</article>
