        <section class="screen" data-screen="historias" aria-labelledby="stories-title" hidden>
            <div class="page-shell">
                <!-- Barra de Navegación Estilo Atelier -->
                <div class="screen-nav-bar">
                    <a class="back-link" href="{{ route('home') }}#inicio" data-go="inicio">
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </span>
                        <span>← Ir a Inicio</span>
                    </a>
                    <span class="nav-screen-pill">
                        <span class="nav-pill-dot" aria-hidden="true"></span>
                        <span>Crónica Poética · El Sobre Malva</span>
                    </span>
                    <a class="back-link" href="#mapa" data-go="mapa">
                        <span>Volver al Mapa</span>
                        <span class="back-link-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Cabecera Principal de la Pantalla -->
                <div class="page-heading stories-page-heading">
                    <div>
                        <div class="atelier-badge-strip">
                            <span class="atelier-badge badge-lavender">NARRATIVA INTERACTIVA</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-rose">EL JARDÍN DE CARLA</span>
                            <span class="atelier-dot">◆</span>
                            <span class="atelier-badge badge-live">
                                <span class="live-pulse-dot" aria-hidden="true"></span>
                                <span>TU ELECCIÓN DECIDE EL CAMINO</span>
                            </span>
                        </div>
                        <p class="eyebrow">TÚ ELIGES EL SIGUIENTE CAPÍTULO</p>
                        <h1 id="stories-title" class="shimmer-title">Historias <em>interactivas</em></h1>
                        <p>Una historia viva y poética con dos senderos y un desenlace único para cada una de tus decisiones.</p>
                    </div>
                    <div class="stories-heading-badge" aria-hidden="true" title="Sello de Historias">
                        <span class="stories-floating-seal">✉️</span>
                    </div>
                </div>

                <!-- Contenedor Principal de la Historia -->
                <div class="story-container">
                    <article class="story-card story-card-editorial" data-story-card aria-live="polite">
                        <!-- Aura decorativa de luz y pétalos -->
                        <div class="story-card-aura" aria-hidden="true"></div>

                        <!-- Barra superior del capítulo -->
                        <div class="story-card-topbar">
                            <div class="story-chapter-chip">
                                <span class="story-chip-dot" aria-hidden="true">🌸</span>
                                <span class="story-chapter-text" data-story-chapter>EL SOBRE MALVA · CAPÍTULO 01</span>
                            </div>
                            <div class="story-wax-badge" aria-hidden="true" title="Sello botánico del jardín">
                                <span class="wax-icon">💌</span>
                            </div>
                        </div>

                        <!-- Contenido Narrativo -->
                        <div class="story-card-body">
                            <h2 class="story-headline" data-story-text>Una mañana, junto a la puerta, encontraste un sobre color lavanda.</h2>
                            
                            <div class="story-detail-wrapper">
                                <span class="story-quote-symbol" aria-hidden="true">“</span>
                                <p class="story-detail-text" data-story-detail>No llevaba remitente, solo una pequeña flor dibujada. Dentro había una nota: «Hay un lugar que quiero mostrarte…»</p>
                            </div>
                        </div>

                        <!-- Opciones de Decisión -->
                        <div class="story-choices" data-story-choices>
                            <button class="button button-primary story-choice-btn" type="button" data-story-choice="jardin">
                                <span class="choice-icon" aria-hidden="true">✨</span>
                                <span>Seguir el aroma de las flores</span>
                            </button>
                            <button class="button button-primary story-choice-btn" type="button" data-story-choice="nota">
                                <span class="choice-icon" aria-hidden="true">✨</span>
                                <span>Leer la nota completa</span>
                            </button>
                        </div>
                    </article>

                    <!-- Detalle al pie de la historia -->
                    <div class="story-footer-note">
                        <span class="story-leaf-icon" aria-hidden="true">🌿</span>
                        <p>Cada sendero guarda un pedacito de luz, recuerdos y secretos dedicados a Carla Lorena.</p>
                    </div>
                </div>
            </div>
        </section>
