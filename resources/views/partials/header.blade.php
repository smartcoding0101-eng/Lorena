    <header class="site-header">
        <a class="brand" href="#inicio" data-go="inicio" aria-label="El Jardín de Carla Lorena, inicio">
            <span class="brand-mark" aria-hidden="true">✳</span>
            <span><strong>El jardín</strong><small>de Carla Lorena</small></span>
        </a>
        <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">
            <span></span><span></span>
        </button>
        <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
            <a href="{{ route('home') }}#inicio" data-go="inicio">Inicio</a>
            <a href="#mapa" data-go="mapa">Explorar</a>
            <a href="#blog" data-go="blog">Blog</a>
            <a href="#galeria" data-go="galeria">Galería</a>
            <a href="#biblioteca" data-go="biblioteca">Rincón de lectura</a>
            <a href="#dedicatoria" data-go="dedicatoria" class="nav-dedication"><span aria-hidden="true">💌</span> Dedicatoria</a>
            <a class="nav-profile" href="#carla" data-go="carla"><span aria-hidden="true">♡</span> Mi espacio</a>
            <button type="button" class="nav-passport-btn" id="passport-header-trigger" aria-label="Abrir Pasaporte del Jardín Secreto" title="Pasaporte del Jardín Secreto">
                <span class="passport-icon" aria-hidden="true">⚜️</span>
                <span class="passport-label">Pasaporte</span>
                <span class="passport-stamp-badge" id="passport-stamp-count">1/12</span>
            </button>
        </nav>
    </header>
