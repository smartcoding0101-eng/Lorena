    <div id="romantic-splash" class="romantic-splash" aria-modal="true" role="dialog" aria-label="Bienvenida al Jardín de Carla Lorena">
        <script>
            (function() {
                try {
                    var search = window.location.search || '';
                    if (search.indexOf('splash=1') !== -1 || search.indexOf('splash=force') !== -1) return;
                    var INACTIVITY_LIMIT_MS = 20 * 60 * 1000; // 20 minutos de inactividad
                    var lastActive = parseInt(localStorage.getItem('carla_splash_last_active') || '0', 10);
                    var splashSeen = localStorage.getItem('carla_splash_seen');
                    var now = Date.now();
                    var currentHash = (window.location.hash || '').replace(/^#/, '').trim();
                    var isHomeEntry = !currentHash || currentHash === 'inicio';
                    var isInactive = !lastActive || (now - lastActive) >= INACTIVITY_LIMIT_MS;

                    // Si ya se mostró y el usuario sigue activo (o navega a sección interna), ocultar inmediatamente sin flash
                    if ((splashSeen && !isInactive) || (!isHomeEntry && splashSeen)) {
                        var splashEl = document.getElementById('romantic-splash');
                        if (splashEl) {
                            splashEl.style.display = 'none';
                            splashEl.setAttribute('data-suppressed', 'true');
                        }
                    }
                } catch (e) {}
            })();
        </script>
        <div class="splash-backdrop">
            <!-- Aurora Borealis luminosa flotante -->
            <div class="splash-aurora-glow g-1" aria-hidden="true"></div>
            <div class="splash-aurora-glow g-2" aria-hidden="true"></div>
            <div class="splash-aurora-glow g-3" aria-hidden="true"></div>
        </div>

        <div class="splash-card splash-glassmorphism-card" id="splash-glass-card">
            <!-- Canvas de partículas de polvo de estrellas, mariposas y desintegración -->
            <canvas id="splash-particle-canvas" class="splash-particle-canvas"></canvas>

            <!-- 1. Mariposas luminosas interactivas (Aleteo y vuelo flotante) -->
            <div class="splash-flutter-butterfly bf-top-left" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 12C10 7 4 4 2 8C0 12 7 15 12 12Z" fill="url(#bfWingGold)"/>
                    <path d="M12 12C14 7 20 4 22 8C24 12 17 15 12 12Z" fill="url(#bfWingGold)"/>
                    <path d="M12 12C10 16 5 19 4 16C3 13 9 13 12 12Z" fill="#fcd34d" opacity="0.85"/>
                    <path d="M12 12C14 16 19 19 20 16C21 13 15 13 12 12Z" fill="#fcd34d" opacity="0.85"/>
                    <ellipse cx="12" cy="12" rx="1" ry="4" fill="#92400e"/>
                </svg>
            </div>
            <div class="splash-flutter-butterfly bf-bottom-right" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 12C10 7 4 4 2 8C0 12 7 15 12 12Z" fill="url(#bfWingRose)"/>
                    <path d="M12 12C14 7 20 4 22 8C24 12 17 15 12 12Z" fill="url(#bfWingRose)"/>
                    <path d="M12 12C10 16 5 19 4 16C3 13 9 13 12 12Z" fill="#ff3e9a" opacity="0.75"/>
                    <path d="M12 12C14 16 19 19 20 16C21 13 15 13 12 12Z" fill="#ff3e9a" opacity="0.75"/>
                    <ellipse cx="12" cy="12" rx="1" ry="4" fill="#3b0a2a"/>
                </svg>
            </div>
            <div class="splash-flutter-butterfly bf-center-fly" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 12C10 7 4 4 2 8C0 12 7 15 12 12Z" fill="#c084fc"/>
                    <path d="M12 12C14 7 20 4 22 8C24 12 17 15 12 12Z" fill="#e879f9"/>
                    <ellipse cx="12" cy="12" rx="0.9" ry="3.5" fill="#581c87"/>
                </svg>
            </div>

            <!-- 2. Mariquitas de la Buena Suerte (Ladybugs botánicas sobre hojas) -->
            <div class="splash-ladybug lb-top-right" aria-hidden="true" title="Mariquita de la fortuna">
                <svg viewBox="0 0 26 26" fill="none">
                    <!-- Cabeza y antenas -->
                    <circle cx="13" cy="6" r="3.5" fill="#260419"/>
                    <path d="M11 4 L8 2 M15 4 L18 2" stroke="#260419" stroke-width="1.2" stroke-linecap="round"/>
                    <!-- Cuerpo rojo brillante -->
                    <circle cx="13" cy="14" r="9" fill="#ff3e9a"/>
                    <!-- Línea de alas -->
                    <line x1="13" y1="5.5" x2="13" y2="23" stroke="#260419" stroke-width="1.2"/>
                    <!-- Manchas negras de la mariquita -->
                    <circle cx="9.5" cy="11.5" r="1.6" fill="#260419"/>
                    <circle cx="16.5" cy="11.5" r="1.6" fill="#260419"/>
                    <circle cx="8" cy="16.5" r="1.5" fill="#260419"/>
                    <circle cx="18" cy="16.5" r="1.5" fill="#260419"/>
                    <circle cx="13" cy="19.5" r="1.4" fill="#260419"/>
                    <!-- Brillo de caparazón -->
                    <ellipse cx="10" cy="10" rx="2" ry="3.5" transform="rotate(-30 10 10)" fill="#ffffff" opacity="0.45"/>
                </svg>
            </div>
            <div class="splash-ladybug lb-bottom-left" aria-hidden="true" title="Mariquita de la paz">
                <svg viewBox="0 0 26 26" fill="none">
                    <circle cx="13" cy="6" r="3.5" fill="#260419"/>
                    <path d="M11 4 L8 2 M15 4 L18 2" stroke="#260419" stroke-width="1.2" stroke-linecap="round"/>
                    <circle cx="13" cy="14" r="9" fill="#ff3e9a"/>
                    <line x1="13" y1="5.5" x2="13" y2="23" stroke="#260419" stroke-width="1.2"/>
                    <circle cx="9.5" cy="11.5" r="1.6" fill="#260419"/>
                    <circle cx="16.5" cy="11.5" r="1.6" fill="#260419"/>
                    <circle cx="8" cy="16.5" r="1.5" fill="#260419"/>
                    <circle cx="18" cy="16.5" r="1.5" fill="#260419"/>
                    <circle cx="13" cy="19.5" r="1.4" fill="#260419"/>
                    <ellipse cx="10" cy="10" rx="2" ry="3.5" transform="rotate(-30 10 10)" fill="#ffffff" opacity="0.45"/>
                </svg>
            </div>

            <!-- Botón de Cerrar Flotante de Cristal -->
            <button type="button" class="splash-close-btn" id="splash-close" aria-label="Cerrar y entrar al jardín">
                <span aria-hidden="true">✕</span>
            </button>

            <div class="splash-content">
                <!-- Emblema Central Botánico: Rosa Imperial + Girasoles Radiantes + Mariquita + Halo Giratorio -->
                <div class="splash-botanical-bouquet" aria-hidden="true">
                    <div class="splash-halo-ring"></div>
                    <div class="splash-aura-pulsar"></div>

                    <!-- Girasol Dorado Lateral Izquierdo -->
                    <div class="splash-flanking-sunflower sf-left">
                        <svg viewBox="0 0 100 100" fill="none">
                            <defs>
                                <radialGradient id="sunCenterMini1" cx="50%" cy="50%" r="50%">
                                    <stop offset="0%" stop-color="#3b0a2a"/>
                                    <stop offset="100%" stop-color="#260419"/>
                                </radialGradient>
                                <linearGradient id="sunPetalGold1" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#fef08a"/>
                                    <stop offset="60%" stop-color="#f59e0b"/>
                                    <stop offset="100%" stop-color="#e0ab00"/>
                                </linearGradient>
                            </defs>
                            <path d="M50 18 L53 38 L50 42 L47 38 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M50 82 L53 62 L50 58 L47 62 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M18 50 L38 53 L42 50 L38 47 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M82 50 L62 53 L58 50 L62 47 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M26 26 L42 40 L40 43 L36 40 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M74 74 L58 60 L60 57 L64 60 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M74 26 L58 40 L60 43 L64 40 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M26 74 L42 60 L40 57 L36 60 Z" fill="url(#sunPetalGold1)"/>
                            <circle cx="50" cy="50" r="16" fill="url(#sunCenterMini1)"/>
                            <circle cx="50" cy="50" r="14" stroke="#fef08a" stroke-width="0.8" stroke-dasharray="2 2" opacity="0.6"/>
                        </svg>
                    </div>

                    <!-- Rosa Imperial Central 3D SVG -->
                    <div class="splash-main-rose-wrap">
                        <svg class="splash-grand-rose-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <radialGradient id="splashRoseGlow" cx="50%" cy="45%" r="50%">
                                    <stop offset="0%" stop-color="#fb7185"/>
                                    <stop offset="50%" stop-color="#ff3e9a"/>
                                    <stop offset="85%" stop-color="#b8126c"/>
                                    <stop offset="100%" stop-color="#3b0a2a"/>
                                </radialGradient>
                                <radialGradient id="splashRoseHeart" cx="50%" cy="50%" r="40%">
                                    <stop offset="0%" stop-color="#ffffff"/>
                                    <stop offset="45%" stop-color="#fed7aa"/>
                                    <stop offset="100%" stop-color="#ff3e9a"/>
                                </radialGradient>
                                <linearGradient id="splashStem" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#34d399"/>
                                    <stop offset="100%" stop-color="#1b7a5a"/>
                                </linearGradient>
                                <linearGradient id="bfWingGold" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#fef08a"/>
                                    <stop offset="100%" stop-color="#f59e0b"/>
                                </linearGradient>
                                <linearGradient id="bfWingRose" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#fbcfe8"/>
                                    <stop offset="100%" stop-color="#ff3e9a"/>
                                </linearGradient>
                            </defs>
                            <!-- Tallo & Hojas con Rocío -->
                            <path d="M50 68 C50 78 52 89 51 98" stroke="url(#splashStem)" stroke-width="3.5" stroke-linecap="round"/>
                            <path d="M49 76 C40 73 33 78 30 83 C36 84 44 80 49 76Z" fill="#34d399"/>
                            <path d="M51 82 C60 79 67 83 70 89 C63 90 56 87 51 82Z" fill="#26a57b"/>
                            <!-- Pétalos de Rosa Sedosa -->
                            <path d="M30 46 C24 35 38 24 50 30 C62 24 76 35 70 46 C64 58 36 58 30 46Z" fill="url(#splashRoseGlow)"/>
                            <path d="M23 48 C21 38 31 31 43 33 C41 45 31 55 23 48Z" fill="url(#splashRoseGlow)" opacity="0.95"/>
                            <path d="M77 48 C79 38 69 31 57 33 C59 45 69 55 77 48Z" fill="url(#splashRoseGlow)" opacity="0.95"/>
                            <path d="M32 55 C26 64 44 73 50 68 C56 73 74 64 68 55 C60 63 40 63 32 55Z" fill="#b8126c"/>
                            <!-- Corazón Iluminado -->
                            <circle cx="50" cy="46" r="14" fill="url(#splashRoseHeart)"/>
                            <circle cx="50" cy="46" r="8" fill="#ffffff" opacity="0.8"/>
                            <circle cx="50" cy="46" r="3.5" fill="#fde047"/>
                        </svg>
                    </div>

                    <!-- Girasol Dorado Lateral Derecho -->
                    <div class="splash-flanking-sunflower sf-right">
                        <svg viewBox="0 0 100 100" fill="none">
                            <path d="M50 18 L53 38 L50 42 L47 38 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M50 82 L53 62 L50 58 L47 62 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M18 50 L38 53 L42 50 L38 47 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M82 50 L62 53 L58 50 L62 47 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M26 26 L42 40 L40 43 L36 40 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M74 74 L58 60 L60 57 L64 60 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M74 26 L58 40 L60 43 L64 40 Z" fill="url(#sunPetalGold1)"/>
                            <path d="M26 74 L42 60 L40 57 L36 60 Z" fill="url(#sunPetalGold1)"/>
                            <circle cx="50" cy="50" r="16" fill="url(#sunCenterMini1)"/>
                            <circle cx="50" cy="50" r="14" stroke="#fef08a" stroke-width="0.8" stroke-dasharray="2 2" opacity="0.6"/>
                        </svg>
                    </div>

                    <!-- Destellos de luz circundantes -->
                    <span class="splash-sparkle sp-1">✨</span>
                    <span class="splash-sparkle sp-2">✦</span>
                    <span class="splash-sparkle sp-3">✧</span>
                    <span class="splash-sparkle sp-4">✨</span>
                </div>

                <!-- Insignia Crown Real con brillo -->
                <div class="splash-crown-tag splash-crown-modern">
                    <span class="crown-icon">👑</span>
                    <span class="crown-text">Santuario Sagrado de Carla Lorena</span>
                    <span class="crown-sparkle">✦</span>
                </div>

                <!-- Badges Botánicos con Mariposas, Mariquitas y Girasoles -->
                <div class="splash-nature-badges-row">
                    <span class="splash-nature-pill">🦋 Mariposas de Luz</span>
                    <span class="splash-nature-pill">🐞 Mariquitas de la Fortuna</span>
                    <span class="splash-nature-pill">🌻 Girasoles Radiantes</span>
                </div>

                <h2 class="splash-title splash-modern-title">
                    Bienvenida a tu Jardín Secreto,<br>
                    <span class="splash-name-glow">Carla Lorena</span>
                </h2>

                <p class="splash-verse splash-modern-verse">
                    «Donde cada girasol busca tu sonrisa, las mariposas tejen tus sueños y cada flor late con la ternura más pura para ti.»
                </p>

                <!-- Botón Principal con Shimmer Líquido y Partículas -->
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

            <!-- Barra de progreso moderna con gradiente iridiscente -->
            <div class="splash-progress-track" title="Ingresando automáticamente en 8 segundos">
                <div class="splash-progress-bar splash-progress-modern" id="splash-progress-bar"></div>
            </div>
        </div>
    </div>

    <a class="skip-link" href="#main">Saltar al contenido</a>
