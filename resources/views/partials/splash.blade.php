    <div id="romantic-splash" class="romantic-splash" aria-modal="true" role="dialog" aria-label="Bienvenida al Jardín de Carla Lorena">
        <div class="splash-backdrop">
            <div class="splash-aurora-glow g-1" aria-hidden="true"></div>
            <div class="splash-aurora-glow g-2" aria-hidden="true"></div>
            <div class="splash-aurora-glow g-3" aria-hidden="true"></div>
        </div>

        <div class="splash-card splash-glassmorphism-card" id="splash-glass-card">
            <!-- Canvas de partículas de polvo de estrellas y desintegración -->
            <canvas id="splash-particle-canvas" class="splash-particle-canvas"></canvas>

            <!-- Mariposas Luminosas -->
            <div class="splash-flutter-butterfly bf-top-left" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 12C10 7 4 4 2 8C0 12 7 15 12 12Z" fill="#fcd34d"/>
                    <path d="M12 12C14 7 20 4 22 8C24 12 17 15 12 12Z" fill="#f59e0b"/>
                    <ellipse cx="12" cy="12" rx="1" ry="4" fill="#92400e"/>
                </svg>
            </div>
            <div class="splash-flutter-butterfly bf-bottom-right" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 12C10 7 4 4 2 8C0 12 7 15 12 12Z" fill="#fbcfe8"/>
                    <path d="M12 12C14 7 20 4 22 8C24 12 17 15 12 12Z" fill="#e11d48"/>
                    <ellipse cx="12" cy="12" rx="1" ry="4" fill="#881337"/>
                </svg>
            </div>

            <!-- Mariquitas de la Buena Fortuna -->
            <div class="splash-ladybug lb-top-right" aria-hidden="true" title="Mariquita de la fortuna">
                <svg viewBox="0 0 26 26" fill="none">
                    <circle cx="13" cy="6" r="3.5" fill="#1e1b18"/>
                    <path d="M11 4 L8 2 M15 4 L18 2" stroke="#1e1b18" stroke-width="1.2" stroke-linecap="round"/>
                    <circle cx="13" cy="14" r="9" fill="#e11d48"/>
                    <line x1="13" y1="5.5" x2="13" y2="23" stroke="#1e1b18" stroke-width="1.2"/>
                    <circle cx="9.5" cy="11.5" r="1.6" fill="#1e1b18"/>
                    <circle cx="16.5" cy="11.5" r="1.6" fill="#1e1b18"/>
                    <circle cx="8" cy="16.5" r="1.5" fill="#1e1b18"/>
                    <circle cx="18" cy="16.5" r="1.5" fill="#1e1b18"/>
                    <ellipse cx="10" cy="10" rx="2" ry="3.5" transform="rotate(-30 10 10)" fill="#ffffff" opacity="0.45"/>
                </svg>
            </div>
            <div class="splash-ladybug lb-bottom-left" aria-hidden="true" title="Mariquita de la paz">
                <svg viewBox="0 0 26 26" fill="none">
                    <circle cx="13" cy="6" r="3.5" fill="#1e1b18"/>
                    <path d="M11 4 L8 2 M15 4 L18 2" stroke="#1e1b18" stroke-width="1.2" stroke-linecap="round"/>
                    <circle cx="13" cy="14" r="9" fill="#f43f5e"/>
                    <line x1="13" y1="5.5" x2="13" y2="23" stroke="#1e1b18" stroke-width="1.2"/>
                    <circle cx="9.5" cy="11.5" r="1.6" fill="#1e1b18"/>
                    <circle cx="16.5" cy="11.5" r="1.6" fill="#1e1b18"/>
                    <circle cx="8" cy="16.5" r="1.5" fill="#1e1b18"/>
                    <circle cx="18" cy="16.5" r="1.5" fill="#1e1b18"/>
                    <ellipse cx="10" cy="10" rx="2" ry="3.5" transform="rotate(-30 10 10)" fill="#ffffff" opacity="0.45"/>
                </svg>
            </div>

            <button type="button" class="splash-close-btn" id="splash-close" aria-label="Cerrar y entrar al jardín">
                <span aria-hidden="true">✕</span>
            </button>

            <div class="splash-content">
                <!-- Bouquet Botánico: Rosa Imperial Flanqueada por Girasoles -->
                <div class="splash-botanical-bouquet" aria-hidden="true">
                    <div class="splash-halo-ring"></div>
                    <div class="splash-aura-pulsar"></div>

                    <!-- Girasol Izquierdo -->
                    <div class="splash-flanking-sunflower sf-left">
                        <svg viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="16" fill="#451a03"/>
                            <circle cx="50" cy="50" r="14" stroke="#fef08a" stroke-width="1" stroke-dasharray="2 2"/>
                            <path d="M50 18 L53 38 L50 42 L47 38 Z" fill="#f59e0b"/>
                            <path d="M50 82 L53 62 L50 58 L47 62 Z" fill="#f59e0b"/>
                            <path d="M18 50 L38 53 L42 50 L38 47 Z" fill="#f59e0b"/>
                            <path d="M82 50 L62 53 L58 50 L62 47 Z" fill="#f59e0b"/>
                            <path d="M26 26 L42 40 L40 43 L36 40 Z" fill="#f59e0b"/>
                            <path d="M74 74 L58 60 L60 57 L64 60 Z" fill="#f59e0b"/>
                            <path d="M74 26 L58 40 L60 43 L64 40 Z" fill="#f59e0b"/>
                            <path d="M26 74 L42 60 L40 57 L36 60 Z" fill="#f59e0b"/>
                        </svg>
                    </div>

                    <!-- Rosa Imperial Central -->
                    <div class="splash-main-rose-wrap">
                        <div class="splash-rose-icon">🌹</div>
                    </div>

                    <!-- Girasol Derecho -->
                    <div class="splash-flanking-sunflower sf-right">
                        <svg viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="16" fill="#451a03"/>
                            <circle cx="50" cy="50" r="14" stroke="#fef08a" stroke-width="1" stroke-dasharray="2 2"/>
                            <path d="M50 18 L53 38 L50 42 L47 38 Z" fill="#f59e0b"/>
                            <path d="M50 82 L53 62 L50 58 L47 62 Z" fill="#f59e0b"/>
                            <path d="M18 50 L38 53 L42 50 L38 47 Z" fill="#f59e0b"/>
                            <path d="M82 50 L62 53 L58 50 L62 47 Z" fill="#f59e0b"/>
                            <path d="M26 26 L42 40 L40 43 L36 40 Z" fill="#f59e0b"/>
                            <path d="M74 74 L58 60 L60 57 L64 60 Z" fill="#f59e0b"/>
                            <path d="M74 26 L58 40 L60 43 L64 40 Z" fill="#f59e0b"/>
                            <path d="M26 74 L42 60 L40 57 L36 60 Z" fill="#f59e0b"/>
                        </svg>
                    </div>

                    <span class="splash-sparkle sp-1">✨</span>
                    <span class="splash-sparkle sp-2">✦</span>
                    <span class="splash-sparkle sp-3">✧</span>
                </div>

                <!-- Insignia Crown Real con brillo -->
                <div class="splash-crown-tag splash-crown-modern">
                    <span class="crown-icon">👑</span>
                    <span class="crown-text">Santuario Sagrado de Carla Lorena</span>
                    <span class="crown-sparkle">✦</span>
                </div>

                <!-- Badges Botánicos con Mariposas, Mariquitas y Girasoles -->
                <div class="splash-nature-badges-row">
                    <span class="splash-nature-pill">🦋 Mariposas</span>
                    <span class="splash-nature-pill">🐞 Mariquitas</span>
                    <span class="splash-nature-pill">🌻 Girasoles</span>
                </div>

                <h2 class="splash-title splash-modern-title">
                    Bienvenida a tu Jardín Secreto,<br>
                    <span class="splash-name splash-name-glow">Carla Lorena</span>
                </h2>

                <p class="splash-verse splash-modern-verse">
                    «Donde cada girasol busca tu sonrisa, las mariposas tejen tus sueños y cada flor late con la ternura más pura para ti.»
                </p>

                <div class="splash-actions">
                    <button type="button" class="splash-enter-btn splash-liquid-btn" id="splash-enter">
                        <span class="splash-btn-shimmer" aria-hidden="true"></span>
                        <span class="splash-btn-content">
                            <span>Entrar a tu refugio</span>
                            <span class="splash-btn-heart" aria-hidden="true">♡</span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Barra de progreso de 8 segundos -->
            <div class="splash-progress-track" title="Ingresando automáticamente en 8 segundos">
                <div class="splash-progress-bar splash-progress-modern" id="splash-progress-bar"></div>
            </div>
        </div>
    </div>

    <a class="skip-link" href="#main">Saltar al contenido</a>