    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="#inicio" data-go="inicio" aria-label="Carla Lorena, inicio">
                <span class="brand-mark" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Flor de Loto Botánica Editorial -->
                        <path d="M12 3c-1.5 3-3.8 5.5-3.8 8.5a3.8 3.8 0 0 0 7.6 0C15.8 8.5 13.5 6 12 3z"/>
                        <path d="M12 11.5c-2.4-1.2-6.2-.5-7.2 2.2-1 2.8 1.4 5.3 4.4 5.3 1.8 0 2.8-.8 2.8-.8"/>
                        <path d="M12 11.5c2.4-1.2 6.2-.5 7.2 2.2 1 2.8-1.4 5.3-4.4 5.3-1.8 0-2.8-.8-2.8-.8"/>
                        <circle cx="12" cy="11.5" r="0.9" fill="currentColor"/>
                    </svg>
                </span>
                <span class="brand-text-wrap">
                    <strong>Carla Lorena</strong>
                    <small>El Jardín · Belleza · Sueños</small>
                </span>
            </a>

            <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-nav">
                <span></span><span></span>
            </button>

            <nav class="main-nav" id="main-nav" aria-label="Navegación principal">
                <a href="{{ route('home') }}#inicio" data-go="inicio" class="nav-item">Inicio</a>
                <a href="#familia" data-go="familia" class="nav-item nav-family-link" title="Santuario y Álbum Familiar">
                    <span class="nav-icon" aria-hidden="true">👨‍👩‍👧‍👦</span>
                    <span>Mi Familia</span>
                </a>
                <a href="#galeria" data-go="galeria" class="nav-item">Mi Universo</a>
                <a href="#biblioteca" data-go="biblioteca" class="nav-item">Inspiración</a>
                <a href="#juegos" data-go="juegos" class="nav-item">Experiencias</a>
                <a href="#carla" data-go="carla" class="nav-item">Mi Espacio</a>
                <a href="#dedicatoria" data-go="dedicatoria" class="nav-item">Dedicatorias</a>
                <a href="#mapa" data-go="mapa" title="Mapa del Jardín" class="nav-item nav-map-link">
                    <svg class="nav-svg-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/>
                        <line x1="9" y1="3" x2="9" y2="18"/>
                        <line x1="15" y1="6" x2="15" y2="21"/>
                    </svg>
                    <span>Mapa</span>
                </a>

                @auth
                <a href="#admin" data-go="admin" class="nav-item nav-admin-link" title="Panel de Control">
                    <svg class="nav-svg-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    <span>Control</span>
                </a>
                @endauth

                <button type="button" class="nav-passport-btn" id="passport-header-trigger" aria-label="Abrir Pasaporte del Jardín Secreto" title="Pasaporte del Jardín Secreto">
                    <span class="passport-icon" aria-hidden="true">⚜️</span>
                    <span class="passport-label">Pasaporte</span>
                    <span class="passport-stamp-badge" id="passport-stamp-count">1/13</span>
                </button>
            </nav>
        </div>
    </header>
