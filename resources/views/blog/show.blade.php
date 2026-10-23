<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $post->excerpt ?: 'Una publicación de El Jardín de Carla.' }}">
    <title>{{ $post->title }} · El Jardín de Carla</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#article">Saltar a la publicación</a>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}#inicio" aria-label="Volver a El Jardín de Carla">
            <span class="brand-mark" aria-hidden="true">✳</span>
            <span><strong>El jardín</strong><small>de Carla</small></span>
        </a>
        <nav class="main-nav" aria-label="Navegación principal">
            <a href="{{ route('home') }}#blog">Blog</a>
            <a class="nav-profile" href="{{ route('home') }}#carla"><span aria-hidden="true">♡</span> Mi espacio</a>
        </nav>
    </header>

    <main id="article" class="post-page">
        <a class="back-link" href="{{ route('home') }}#blog">← Volver al blog</a>

        <article class="blog-article-card">
            <!-- Barra botánica superior del artículo -->
            <div class="blog-article-topbar">
                <span class="blog-topbar-emblem">✍️ ❦ 🌸</span>
                <span class="blog-topbar-label">{{ $post->category ?: 'NOTAS DEL JARDÍN' }} · PUBLICACIÓN</span>
            </div>

            <p class="eyebrow">{{ $post->category ?: 'NOTAS DEL JARDÍN' }} · {{ $post->created_at->translatedFormat('j \d\e F, Y') }}</p>
            <h1>{{ $post->title }}</h1>

            @if ($post->excerpt)
                <p class="post-page-excerpt">{{ $post->excerpt }}</p>
            @endif

            <!-- Separador floral -->
            <div class="blog-floral-divider" aria-hidden="true">
                <span class="divider-petal">🌸</span>
                <span class="divider-line"></span>
                <span class="divider-rose">❦</span>
                <span class="divider-line"></span>
                <span class="divider-petal">🌸</span>
            </div>

            <p class="post-page-byline">Desde El Jardín de Carla</p>
            <div class="post-page-body">{{ $post->body }}</div>

            <!-- Quote al final -->
            <div class="blog-end-quote">
                <span class="end-quote-mark">❦</span>
                <em>«Cada palabra escrita es un pétalo guardado en el tiempo.»</em>
            </div>
        </article>
    </main>

    <footer class="site-footer">
        <a class="brand footer-brand" href="{{ route('home') }}#inicio">
            <span class="brand-mark" aria-hidden="true">✳</span>
            <span><strong>El jardín</strong><small>de Carla</small></span>
        </a>
        <span>Publicado en el blog público. ♡</span>
        <a class="footer-settings" href="{{ route('home') }}#blog">Más historias</a>
    </footer>
</body>
</html>
