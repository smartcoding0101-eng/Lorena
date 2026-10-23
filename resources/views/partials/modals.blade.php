
    <footer class="site-footer"><a class="brand footer-brand" href="#inicio" data-go="inicio"><span class="brand-mark" aria-hidden="true">✳</span><span><strong>El jardín</strong><small>de Carla Lorena</small></span></a><span>Un universo personal, con cariño de Tu Ingeniero Julio Adrián. <span aria-hidden="true">♡</span></span><a class="footer-settings" href="#ajustes" data-go="ajustes">Privacidad y preferencias</a></footer>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  MODO MUSEO CINEMATOGRÁFICO · LIGHTBOX DE BELLAS ARTES DE CARLA LORENA    -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="image-dialog museum-lightbox-dialog" id="museum-lightbox" aria-label="Modo Museo · Colección Carla Lorena">
        <div class="museum-lightbox-card">
            <!-- Barra superior del modo museo -->
            <header class="museum-lightbox-header">
                <div class="museum-header-left">
                    <span class="museum-badge" id="museum-badge">🌸 FOTOGRAFÍA BOTÁNICA</span>
                    <span class="museum-counter" id="museum-counter">Obra 1 de 6</span>
                </div>
                <div class="museum-header-actions">
                    <button type="button" class="museum-action-btn" id="museum-quote-copy-btn" title="Copiar pensamiento dedicado" aria-label="Copiar pensamiento dedicado">
                        <span aria-hidden="true">📋</span> <span class="museum-btn-text">Copiar Cita</span>
                    </button>
                    <button type="button" class="museum-action-btn" id="museum-zoom-btn" title="Alternar zoom" aria-label="Alternar zoom de imagen">
                        <span aria-hidden="true" id="museum-zoom-icon">🔍</span>
                    </button>
                    <button type="button" class="dialog-close museum-close-btn" aria-label="Cerrar modo museo">✕</button>
                </div>
            </header>

            <!-- Área de exhibición central con flechas de navegación -->
            <div class="museum-stage-wrapper">
                <button type="button" class="museum-nav-arrow museum-prev-btn" id="museum-prev-btn" aria-label="Obra anterior (Flecha Izquierda)" title="Obra anterior">
                    <span aria-hidden="true">‹</span>
                </button>
                
                <div class="museum-photo-frame" id="museum-photo-frame">
                    <img class="dialog-image museum-active-img" id="museum-active-img" src="" alt="">
                </div>

                <button type="button" class="museum-nav-arrow museum-next-btn" id="museum-next-btn" aria-label="Obra siguiente (Flecha Derecha)" title="Obra siguiente">
                    <span aria-hidden="true">›</span>
                </button>
            </div>

            <!-- Paspartú inferior con título, sello de colección y dedicatoria poética -->
            <footer class="museum-lightbox-footer">
                <div class="museum-caption-container">
                    <div class="museum-title-row">
                        <h3 class="dialog-title museum-title" id="museum-title">Título de la obra</h3>
                        <span class="gallery-pill museum-pill" id="museum-collection-pill">Colección Carla</span>
                    </div>
                    <div class="blog-card-divider museum-divider" aria-hidden="true">
                        <span class="divider-line"></span>
                        <span class="divider-rose">❦</span>
                        <span class="divider-line"></span>
                    </div>
                    <p class="museum-quote-text" id="museum-quote">«Dedicatoria poética para Carla...»</p>
                    <div class="museum-keyboard-hints" aria-hidden="true">
                        <small>Navega con <kbd>←</kbd> <kbd>→</kbd> · <kbd>Esc</kbd> para salir</small>
                    </div>
                </div>
            </footer>
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  PASAPORTE DEL JARDÍN SECRETO · BITÁCORA DE SELLOS & LOGROS            -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="passport-dialog" id="passport-dialog" aria-label="Pasaporte del Jardín Secreto">
        <div class="passport-booklet">
            <header class="passport-booklet-header">
                <div class="passport-title-wrap">
                    <span class="passport-gold-emblem">⚜️ ❦ ⚜️</span>
                    <h2 class="passport-title">Pasaporte del Jardín Secreto</h2>
                    <p class="passport-subtitle">Bitácora de rincones y memorias de Carla Lorena</p>
                </div>
                <button type="button" class="dialog-close passport-close-btn" aria-label="Cerrar pasaporte">✕</button>
            </header>

            <div class="passport-progress-card">
                <div class="passport-progress-label">
                    <span>Progreso de Exploración</span>
                    <strong class="passport-progress-status">Coleccionando recuerdos</strong>
                </div>
                <div class="passport-progress-bar-track">
                    <div class="passport-progress-bar-fill" id="passport-progress-fill" style="width: 8%;"></div>
                </div>
            </div>

            <div class="passport-stamps-grid" id="passport-stamps-grid">
                <!-- Se inyecta dinámicamente -->
            </div>

            <footer class="passport-footer">
                <div class="blog-card-divider" aria-hidden="true">
                    <span class="divider-line"></span>
                    <span class="divider-rose">❦</span>
                    <span class="divider-line"></span>
                </div>
                <p class="passport-footer-note">«Cada rincón que visitas queda grabado con un sello imborrable en este jardín.»</p>
            </footer>
        </div>
    </dialog>
    <!-- Diálogo de Detalle Extendido de Sello · 10 Variables Dedicadas a Carla Lorena -->
    <dialog class="passport-detail-dialog" id="passport-detail-dialog" aria-label="Detalle del Rincón Sellado">
        <div class="passport-detail-card" id="passport-detail-card">
            <!-- Se renderiza dinámicamente -->
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  CARTA DEL CORAZÓN CENTRAL DEL MAPA · DEDICADA A CARLA LORENA          -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="map-rose-dialog" id="map-rose-dialog" aria-label="El Corazón del Jardín Secreto · Carta y Poema para Carla Lorena">
        <div class="map-rose-card">
            <!-- Botón de Cierre -->
            <button type="button" class="map-rose-close" id="btn-close-map-rose-dialog" aria-label="Cerrar carta del corazón">✕</button>

            <!-- Encabezado con la Rosa Emblema -->
            <header class="map-rose-header">
                <div class="map-rose-emblem-wrap">
                    <div class="rose-emblem-glow"></div>
                    <span class="rose-emblem-flower">🌹</span>
                    <span class="rose-emblem-heart">♡</span>
                </div>
                <div class="map-rose-header-text">
                    <span class="map-rose-eyebrow">EL CORAZÓN LATIENTE DEL JARDÍN SECRETO</span>
                    <h2 class="map-rose-title">Para Mi Amada Carla Lorena</h2>
                    <p class="map-rose-subtitle">El centro de todas las constelaciones florecientes siempre serás tú.</p>
                </div>
            </header>

            <!-- Pestañas de la Experiencia: Carta · Poema · Sentimiento -->
            <div class="map-rose-tabs" role="tablist" aria-label="Contenido dedicado a Carla">
                <button type="button" class="map-rose-tab is-active" data-rose-tab="carta" role="tab" aria-selected="true">
                    <span>💌 Carta de Amor</span>
                </button>
                <button type="button" class="map-rose-tab" data-rose-tab="poema" role="tab" aria-selected="false">
                    <span>📜 Poema a tu Belleza</span>
                </button>
                <button type="button" class="map-rose-tab" data-rose-tab="sentimiento" role="tab" aria-selected="false">
                    <span>💖 El Sentimiento Puro</span>
                </button>
            </div>

            <div class="map-rose-body">
                <!-- 1. CARTA DE AMOR -->
                <div class="map-rose-tab-content is-active" id="rose-tab-carta" role="tabpanel">
                    <div class="rose-parchment-letter">
                        <div class="rose-watermark" aria-hidden="true">❦</div>
                        <p class="letter-greeting">Mi queridísima Carla Lorena,</p>
                        <p class="letter-paragraph">
                            Si este mapa secreto tiene senderos de rosas, cielos estrellados y santuarios de paz, es únicamente porque cada uno de ellos nació de un latido pensando en ti. En medio de un mundo ruidoso y apresurado, quise construir este universo donde el tiempo se detenga y donde tu sonrisa sea la única brújula que guíe mis días.
                        </p>
                        <p class="letter-paragraph">
                            Tú eres la raíz de toda la belleza que aquí respira. No hay rincón en este jardín que no guarde tu ternura, ni flor que no busque emular tu delicadeza. Gracias por ser mi calma en la tormenta, por iluminar mis amaneceres con la nobleza de tu alma y por enseñarme que el amor más grande se cultiva en los pequeños detalles de cada día.
                        </p>
                        <p class="letter-signature">
                            Eternamente tuyo y a tu lado,<br>
                            <strong>Con todo el amor de mi corazón 🌹</strong>
                        </p>
                    </div>
                </div>

                <!-- 2. POEMA DEDICADO -->
                <div class="map-rose-tab-content" id="rose-tab-poema" role="tabpanel" hidden>
                    <div class="rose-poem-container">
                        <span class="poem-ornament">⚜️ ❦ ⚜️</span>
                        <h3 class="poem-title">Donde Florece Tu Mirada</h3>
                        <div class="poem-verses">
                            <p>
                                Dicen que el rosal florece lento,<br>
                                aguardando el rocío de la mañana,<br>
                                pero ante la gracia de tu aliento,<br>
                                toda primavera se hace temprana.
                            </p>
                            <p>
                                Eres brisa que calma la fatiga,<br>
                                poesía que no necesita rima,<br>
                                la melodía dulce que me abriga,<br>
                                la más radiante flor sobre la cima.
                            </p>
                            <p>
                                Que el cielo te colme de ternura,<br>
                                como este jardín cuida tu huella,<br>
                                pues en tu corazón de luz pura,<br>
                                habita el alma de la más hermosa estrella.
                            </p>
                        </div>
                        <span class="poem-author">— Escrito con devoción infinita para Carla Lorena ♡</span>
                    </div>
                </div>

                <!-- 3. EL SENTIMIENTO PURO -->
                <div class="map-rose-tab-content" id="rose-tab-sentimiento" role="tabpanel" hidden>
                    <div class="rose-sentiment-box">
                        <div class="sentiment-glow-icon">💖</div>
                        <h3 class="sentiment-title">Lo que significa tenerte en mi vida</h3>
                        <p class="sentiment-lead">
                            «Un amor sereno, incondicional y eterno.»
                        </p>
                        <div class="sentiment-cards-row">
                            <div class="sentiment-mini-card">
                                <span class="sc-icon">✨</span>
                                <strong>Mi Refugio</strong>
                                <small>Contigo no necesito fingir nada; en tus brazos todo encuentra su paz.</small>
                            </div>
                            <div class="sentiment-mini-card">
                                <span class="sc-icon">🌷</span>
                                <strong>Mi Certeza</strong>
                                <small>Cada mañana al despertar sé que mi mayor fortuna es poder amarte.</small>
                            </div>
                            <div class="sentiment-mini-card">
                                <span class="sc-icon">💎</span>
                                <strong>Mi Mayor Tesoro</strong>
                                <small>Tu alegría sincera y el brillo bondadoso de tus ojos valen el universo entero.</small>
                            </div>
                        </div>
                        <div class="sentiment-affirmation">
                            «Este jardín nunca marchitará, porque está alimentado por la promesa indestructible de cuidarte, respetarte y amarte en cada segundo de la eternidad.»
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones al pie del modal -->
            <footer class="map-rose-footer">
                <button type="button" class="btn-rose-chime" id="btn-rose-chime" title="Hacer sonar un arpegio de amor">
                    <span>🎶 Melodía del Corazón</span>
                </button>
                <button type="button" class="btn-rose-copy" id="btn-rose-copy-love" title="Guardar esta carta y poema con cariño">
                    <span>💌 Guardar Carta en el Portapapeles</span>
                </button>
            </footer>
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  GUÍA COMPLETA DEL SISTEMA · MANUAL ILUSTRADO DEL JARDÍN SECRETO       -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="system-guide-dialog" id="system-guide-dialog" aria-label="Guía Completa del Jardín Secreto">
        <div class="system-guide-card">
            <!-- Botón de Cierre -->
            <button type="button" class="system-guide-close" id="btn-close-system-guide" aria-label="Cerrar guía">✕</button>

            <!-- Cabecera de la Guía -->
            <header class="system-guide-header">
                <div class="guide-header-icon-wrap">
                    <span class="guide-icon">📖</span>
                    <span class="guide-sparkle">✨</span>
                </div>
                <div>
                    <span class="guide-eyebrow">BRÚJULA &amp; MANUAL DEL JARDÍN SECRETO</span>
                    <h2 class="guide-title">Guía del Sistema para Carla Lorena</h2>
                    <p class="guide-subtitle">Descubre cómo disfrutar cada rincón, secreto, música y juego de tu universo privado.</p>
                </div>
            </header>

            <!-- Barra de Búsqueda Rápida en la Guía -->
            <div class="guide-search-wrap">
                <span class="guide-search-icon">🔍</span>
                <input type="search" class="guide-search-input" id="guide-search-input" placeholder="Buscar un rincón, función o secreto (ej: pasaporte, clima, fotos, sultanina)..." aria-label="Buscar en la guía">
            </div>

            <!-- Pestañas de Navegación Temática -->
            <div class="guide-tabs" role="tablist">
                <button type="button" class="guide-tab is-active" data-guide-tab="mapa" role="tab" aria-selected="true">
                    <span>🗺️ Rincones &amp; Mapa</span>
                </button>
                <button type="button" class="guide-tab" data-guide-tab="clima" role="tab" aria-selected="false">
                    <span>🌦️ Clima &amp; Sonido</span>
                </button>
                <button type="button" class="guide-tab" data-guide-tab="pasaporte" role="tab" aria-selected="false">
                    <span>⚜️ Pasaporte Real</span>
                </button>
                <button type="button" class="guide-tab" data-guide-tab="juegos" role="tab" aria-selected="false">
                    <span>🎮 Juegos &amp; Aventura</span>
                </button>
                <button type="button" class="guide-tab" data-guide-tab="secretos" role="tab" aria-selected="false">
                    <span>✨ Secretos &amp; Docks</span>
                </button>
            </div>

            <!-- Contenido de las Pestañas -->
            <div class="guide-tab-panes">
                <!-- 1. RINCONES & MAPA -->
                <div class="guide-pane is-active" id="guide-pane-mapa" role="tabpanel">
                    <div class="guide-card-grid">
                        <div class="guide-item-card" data-keywords="mapa constelaciones rincones carla rosa centro">
                            <span class="gic-icon">🌹</span>
                            <h4>El Corazón del Mapa</h4>
                            <p>Toca la rosa central de Carla en <code>#mapa</code> para revelar la <strong>Carta de Amor</strong>, el <strong>Poema exclusivo</strong> y los <strong>3 Sentimientos puros</strong>.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="inicio bienvenida rosa encantada">
                            <span class="gic-icon">🏡</span>
                            <h4>Umbral de Bienvenida</h4>
                            <p>Encuentra el retrato botánico, la <em>Rosa Encantada Interactiva</em> y el nuevo <strong>Florecer del Día</strong> con sorpresas diarias.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="galeria fotos museo recuerdos zoom">
                            <span class="gic-icon">🖼️</span>
                            <h4>Salón de Arte &amp; Galería</h4>
                            <p>Disfruta de tus fotos favoritas con el <strong>Modo Museo Velvet</strong>, zoom de alta resolución y pensamientos copiables.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="dedicatoria amor carta pergamino">
                            <span class="gic-icon">💌</span>
                            <h4>Carta del Corazón</h4>
                            <p>Tu santuario de palabras sinceras, con música de arpa sintetizada y versos dedicados a tu sonrisa.</p>
                        </div>
                    </div>
                </div>

                <!-- 2. CLIMA & SONIDO -->
                <div class="guide-pane" id="guide-pane-clima" role="tabpanel" hidden>
                    <div class="guide-card-grid">
                        <div class="guide-item-card" data-keywords="estaciones primavera lluvia verano otono nieve estrellas">
                            <span class="gic-icon">🌦️</span>
                            <h4>Selector de Estaciones</h4>
                            <p>Alterna entre 8 climas con partículas vivas: <em>Primavera Eterna, Lluvia Romántica, Nieve, Estrellas, Burbujas</em> y más.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="sonido volumen brisa lluvia campanillas sintetizador">
                            <span class="gic-icon">🔊</span>
                            <h4>Síntesis Sonora Real</h4>
                            <p>Genera sonido ambiental en tiempo real con Web Audio API. Ajusta el volumen o pulsa el botón maestro <strong>⏻ Apagar Atmósfera</strong>.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="biorritmo hora exterior tiempo real">
                            <span class="gic-icon">⏰</span>
                            <h4>Biorritmo &amp; Clima Exterior</h4>
                            <p>Activa el biorritmo para sincronizar el jardín con la hora del día, o sincronízalo con tu cielo real mediante satélite Open-Meteo.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="cristal empanado ventana vaho">
                            <span class="gic-icon">🪟</span>
                            <h4>Cristal Empañado de Lluvia</h4>
                            <p>Desempaña la ventana con tu ratón o dedo para revelar mensajes secretos y dibuja figuras sobre el vaho.</p>
                        </div>
                    </div>
                </div>

                <!-- 3. PASAPORTE REAL -->
                <div class="guide-pane" id="guide-pane-pasaporte" role="tabpanel" hidden>
                    <div class="guide-card-grid">
                        <div class="guide-item-card" data-keywords="sellos pasaporte bitacora 13">
                            <span class="gic-icon">⚜️</span>
                            <h4>Colección de 13 Sellos</h4>
                            <p>Cada rincón visitado se estampa automáticamente en tu bitácora con un sello de lacre y fecha de descubrimiento.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="10 variables dedicatoria gema flor melodia secreto">
                            <span class="gic-icon">📜</span>
                            <h4>10 Variables por Rincón</h4>
                            <p>Haz clic en cualquier sello para abrir su hoja real: flor emblema, gema, melodía, virtud inspirada y dedicatoria personal.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="teletransporte viajar boton">
                            <span class="gic-icon">🚀</span>
                            <h4>Teletransporte Instantáneo</h4>
                            <p>Usa el botón <em>«Explorar este Rincón Ahora»</em> dentro del detalle de cualquier sello para viajar directo a esa pantalla.</p>
                        </div>
                    </div>
                </div>

                <!-- 4. JUEGOS & AVENTURA -->
                <div class="guide-pane" id="guide-pane-juegos" role="tabpanel" hidden>
                    <div class="guide-card-grid">
                        <div class="guide-item-card" data-keywords="sultana perrita plataformas aventura monedas">
                            <span class="gic-icon">🐾</span>
                            <h4>Sultana la Guardiana</h4>
                            <p>Acompaña a la fiel perrita Sultana en un mini-juego de plataformas interactivo con saltos, monedas y amor incondicional.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="rompecabezas floral puzzle piezas">
                            <span class="gic-icon">🧩</span>
                            <h4>Rompecabezas Floral</h4>
                            <p>Reconstruye hermosas postales de flores uniendo las piezas en el tiempo que desees sin presiones.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="capsula tiempo cartas futuro mensajes">
                            <span class="gic-icon">⏳</span>
                            <h4>Cápsula del Tiempo</h4>
                            <p>Guarda secretos, cartas y anhelos que solo podrán abrirse en fechas especiales del futuro.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="conociendo carla trivia preguntas recompensa">
                            <span class="gic-icon">🌸</span>
                            <h4>Conociendo a Carla Lorena</h4>
                            <p>Un divertido test interactivo de preguntas y curiosidades sobre Carla con una recompensa visual autorizada.</p>
                        </div>
                    </div>
                </div>

                <!-- 5. SECRETOS & DOCKS -->
                <div class="guide-pane" id="guide-pane-secretos" role="tabpanel" hidden>
                    <div class="guide-card-grid">
                        <div class="guide-item-card" data-keywords="dock izquierdo cofre botella camara clima">
                            <span class="gic-icon">🎁</span>
                            <h4>Dock Flotante Izquierdo</h4>
                            <p>Contiene la <strong>Guía del Sistema</strong>, el <strong>Selector de Clima</strong>, la <strong>Postal Polaroid</strong>, la <strong>Botella de Deseos</strong> y el <strong>Cofre Sorpresa</strong>.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="dock derecho notas recuerdos crud">
                            <span class="gic-icon">📝</span>
                            <h4>Notas del Rincón Actual</h4>
                            <p>El botón flotante derecho abre un cajón lateral para leer o añadir memorias y fotos en el rincón en el que estés parada.</p>
                        </div>
                        <div class="guide-item-card" data-keywords="boveda estrellas deseos cosmos">
                            <span class="gic-icon">⭐</span>
                            <h4>Deseos al Cosmos</h4>
                            <p>Lanza deseos a las constelaciones con animaciones de estrellas fugaces y resuena con los anhelos del jardín.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie de la Guía -->
            <footer class="system-guide-footer">
                <span class="guide-footer-quote">«Este universo fue concebido para que nunca olvides lo profundamente especial que eres, Carla Lorena.»</span>
            </footer>
        </div>
    </dialog>
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  DOCK FLOTANTE DERECHO: NOTAS DEL RINCÓN Y CONTROLES DE AUDIO (FLEXBOX)  -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <div class="floating-dock-right" id="floating-dock-right" aria-label="Controles Flotantes del Jardín">
        <!-- 1. Botón Flotante Maestro de Apagado General de Sonido (Kill-Switch) -->
        <button type="button" 
                id="master-audio-floating-btn" 
                class="master-audio-floating-btn" 
                aria-label="Apagado General de Sonido del Jardín" 
                title="Sonido Activo · Clic para Apagado General (Silencio Total)">
        </button>

        <!-- 2. Botón Flotante de Música Ambiental de Fondo -->
        <button type="button" 
                id="music-toggle-btn" 
                class="music-toggle-btn" 
                aria-label="Activar música de fondo" 
                title="Música de fondo" 
                aria-pressed="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
            </svg>
            <span class="dock-tooltip" role="tooltip">Música ambiental</span>
        </button>

        <!-- 3. Botón Flotante de Mensajes de Amor de Adrián -->
        <button type="button" 
                id="love-msg-btn" 
                class="love-msg-btn" 
                aria-label="Recibir un mensaje de amor de Adrián" 
                title="Mensaje de amor de Adrián">
            <span class="love-msg-icon" aria-hidden="true">💌</span>
            <span class="dock-tooltip" role="tooltip">Mensaje de amor</span>
        </button>

        <!-- 4. Botón Flotante para abrir recuerdos y notas del rincón -->
        <button id="corner-crud-trigger" 
                class="corner-crud-trigger" 
                type="button" 
                aria-label="Abrir recuerdos y notas de este rincón" 
                title="Notas y Recuerdos de este rincón">
            <span class="crud-btn-sparkle" aria-hidden="true">✦</span>
            <span class="crud-btn-icon" aria-hidden="true">📝</span>
            <span class="crud-btn-badge" id="corner-notes-count" hidden>0</span>
            <span class="dock-tooltip" role="tooltip">Recuerdos del rincón</span>
        </button>
    </div>

        <!-- Cajón lateral / Drawer de Gestión Contextual -->
        <aside id="corner-crud-drawer" class="corner-drawer" aria-labelledby="corner-drawer-title" hidden>
            <div class="corner-drawer-backdrop" data-drawer-close></div>
            <div class="corner-drawer-panel">
                <header class="corner-drawer-header">
                    <div>
                        <span class="drawer-eyebrow">RINCÓN ACTUAL · <strong id="drawer-screen-name">Inicio</strong></span>
                        <h2 id="corner-drawer-title">Notas & Memorias</h2>
                    </div>
                    <button type="button" class="corner-drawer-close" data-drawer-close aria-label="Cerrar panel">✕</button>
                </header>

                <div class="corner-drawer-tabs">
                    <button type="button" class="corner-tab is-active" data-drawer-tab="list">📖 Ver Notas (<span id="drawer-tab-count">0</span>)</button>
                    @auth
                    <button type="button" class="corner-tab" data-drawer-tab="create">✍️ Nueva Nota / Foto</button>
                    @else
                    <a href="#inicio" data-go="inicio" class="corner-tab corner-tab-login" title="Inicia sesión para escribir">🔒 Iniciar sesión</a>
                    @endauth
                </div>

                <!-- Vista de Lista de Notas -->
                <div class="corner-tab-pane is-active" id="pane-notes-list">
                    <div class="corner-notes-container" id="corner-notes-list">
                        <!-- Renderizado dinámico vía JS -->
                        <div class="corner-empty-state">
                            <span class="empty-icon">🌸</span>
                            <p>Aún no hay notas en este rincón.<br>¡Sé la primera en escribir un recuerdo o pensamiento!</p>
                        </div>
                    </div>
                </div>

                @auth
                <!-- Vista de Formulario de Creación / Edición -->
                <div class="corner-tab-pane" id="pane-notes-form" hidden>
                    <form id="corner-note-form" class="corner-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="note-form-id" value="">
                        <input type="hidden" name="screen_key" id="note-form-screen" value="inicio">
                        
                        <div class="corner-form-row">
                            <label for="note-title">Título o motivo (opcional)</label>
                            <input type="text" id="note-title" name="title" placeholder="Ej: Un pensamiento para hoy, Mi sueño...">
                        </div>

                        <div class="corner-form-row">
                            <label for="note-mood">Tono / Emoción</label>
                            <select id="note-mood" name="mood">
                                <option value="love">💌 Amor y Cariño</option>
                                <option value="gratitude">🌸 Gratitud y Paz</option>
                                <option value="dream">✨ Sueño o Meta</option>
                                <option value="memory">📷 Recuerdo Especial</option>
                                <option value="secret">🌙 Secreto / Íntimo</option>
                            </select>
                        </div>

                        <div class="corner-form-row">
                            <label for="note-content">Mensaje / Nota escrita *</label>
                            <textarea id="note-content" name="content" rows="4" required placeholder="Escribe aquí tus palabras, tus reflexiones o lo que tu corazón sienta..."></textarea>
                        </div>

                        <div class="corner-form-row">
                            <label for="note-author">Firma / Autor</label>
                            <input type="text" id="note-author" name="author_name" value="{{ auth()->user()->name ?? 'Carla Lorena' }}">
                        </div>

                        <div class="corner-form-row">
                            <label for="note-image">Adjuntar fotografía o recuerdo (opcional)</label>
                            <input type="file" id="note-image" name="image" accept="image/*">
                            <div id="note-image-preview" class="note-preview-box" hidden>
                                <img src="" alt="Previsualización">
                                <button type="button" id="note-remove-image-btn">Quitar imagen</button>
                            </div>
                        </div>

                        <div class="corner-form-row corner-checkbox-row">
                            <label>
                                <input type="checkbox" id="note-pinned" name="is_pinned" value="1">
                                <span>Fijar como nota destacada arriba</span>
                            </label>
                        </div>

                        <div class="corner-form-actions">
                            <button type="submit" class="button button-primary" id="note-submit-btn">Guardar recuerdo</button>
                            <button type="button" class="button button-outline" id="note-cancel-btn">Cancelar</button>
                        </div>
                    </form>
                </div>
                @endauth
            </div>
        </aside>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  MINI-REPRODUCTOR FLOTANTE PERSISTENTE (DOCK GLOBAL TIPO SPOTIFY)      -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <aside id="ep-global-dock" class="ep-global-dock" aria-label="Mini reproductor global" hidden>
        <div class="ep-dock-inner">
            <div class="ep-dock-left">
                <div class="ep-dock-thumb">
                    <span id="ep-dock-thumb-icon">🎵</span>
                </div>
                <div class="ep-dock-info">
                    <strong id="ep-dock-title" class="ep-dock-title">Cargando...</strong>
                    <span id="ep-dock-artist" class="ep-dock-artist">El Jardín de Carla Lorena</span>
                </div>
            </div>

            <div class="ep-dock-center">
                <div class="ep-dock-controls">
                    <button type="button" id="ep-dock-btn-prev" class="ep-dock-ctrl-btn" title="Anterior">⏮</button>
                    <button type="button" id="ep-dock-btn-play" class="ep-dock-play-btn" title="Reproducir / Pausar">
                        <span id="ep-dock-play-icon">▶</span>
                    </button>
                    <button type="button" id="ep-dock-btn-next" class="ep-dock-ctrl-btn" title="Siguiente">⏭</button>
                </div>
                <div class="ep-dock-progress-wrap">
                    <div id="ep-dock-progress-bar" class="ep-dock-progress-bar">
                        <div id="ep-dock-progress-fill" class="ep-dock-progress-fill" style="width: 0%;"></div>
                    </div>
                </div>
            </div>

            <div class="ep-dock-right">
                <a href="#entretenimiento" data-go="entretenimiento" class="ep-dock-expand-btn" title="Abrir reproductor completo">
                    <span>↗</span> Ver completo
                </a>
                <button type="button" id="ep-dock-close-btn" class="ep-dock-close-btn" title="Ocultar barra flotante">✕</button>
            </div>
        </div>
    </aside>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  DOCK FLOTANTE IZQUIERDO: BOTONES DE SORPRESAS Y CLIMA ATMOSFÉRICO      -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <div class="floating-dock-left" id="floating-dock-left" aria-label="Rincón de Sorpresas Flotantes">
        <!-- 0. Guía del Sistema (Brújula y Mapa Conceptual) -->
        <button type="button" class="floating-surprise-btn btn-guide-tour" id="btn-open-system-guide" aria-label="Abrir guía interactiva del jardín" title="Guía del Jardín Secreto">
            <span class="floating-surprise-sparkle" aria-hidden="true">💡</span>
            <span class="floating-surprise-icon" aria-hidden="true">📖</span>
            <span class="floating-surprise-tooltip">Guía del Sistema</span>
        </button>

        <!-- 4. Selector de Clima y Estaciones del Jardín -->
        <button type="button" class="floating-surprise-btn btn-weather-season" id="btn-weather-season" aria-label="Cambiar estación o clima del jardín" title="Clima y Estaciones del Jardín" aria-expanded="false" aria-controls="weather-season-popover">
            <span class="floating-surprise-sparkle" aria-hidden="true">🌦️</span>
            <span class="floating-surprise-icon" id="dock-weather-icon" aria-hidden="true">🌸</span>
            <span class="floating-surprise-tooltip" id="dock-weather-tooltip">Clima: Primavera</span>
        </button>

        <!-- 3. Cámara de Recuerdos Polaroid -->
        <button type="button" class="floating-surprise-btn btn-camera" id="btn-polaroid-camera" aria-label="Abrir cámara de recuerdos instantánea" title="Cámara de Recuerdos Polaroid">
            <span class="floating-surprise-icon" aria-hidden="true">📸</span>
            <span class="floating-surprise-tooltip">Postal Polaroid</span>
        </button>

        <!-- 2. Buzón de Botellas al Viento -->
        <button type="button" class="floating-surprise-btn btn-bottle" id="btn-floating-bottle" aria-label="Abrir buzón de botellas y deseos" title="Buzón de Botellas al Viento">
            <span class="floating-surprise-icon" aria-hidden="true">🏺</span>
            <span class="floating-surprise-tooltip">Botella de Deseos</span>
        </button>

        <!-- 1. Cofre de Sorpresas & Recuerdos -->
        <button type="button" class="floating-surprise-btn btn-chest" id="btn-surprise-chest" aria-label="Abrir cofre de sorpresas y recuerdos" title="Cofre de Sorpresas & Recuerdos">
            <span class="floating-surprise-sparkle" aria-hidden="true">✨</span>
            <span class="floating-surprise-icon" aria-hidden="true">🎁</span>
            <span class="floating-surprise-tooltip">Cofre Sorpresa</span>
        </button>
    </div>

    <!-- Menú Popover de Climas y Estaciones del Jardín (Pilar 1, 2, 3, 4) -->
    <div class="weather-season-popover" id="weather-season-popover" role="dialog" aria-label="Selector de Estaciones y Clima" hidden>
        <div class="weather-popover-card">
            <header class="weather-popover-header">
                <div class="weather-header-text">
                    <span class="weather-header-eyebrow">ATMÓSFERA EMOCIONAL</span>
                    <h4 class="weather-header-title">El Clima del Jardín</h4>
                </div>
                <div class="weather-header-actions">
                    <button type="button" class="weather-power-off-btn" id="btn-turn-off-atmosphere" title="Apagar toda la atmósfera (partículas, efectos y sonidos)">
                        <span class="power-icon">⏻</span>
                        <span class="power-text">Apagar Atmósfera</span>
                    </button>
                    <button type="button" class="weather-popover-close" id="btn-close-weather-popover" aria-label="Cerrar selector de clima">✕</button>
                </div>
            </header>

            <div class="weather-popover-body">
                <!-- PILAR 1: Catálogo de Estaciones & Climas -->
                <div class="weather-section-label">
                    <span>SELECCIONA UNA ESTACIÓN</span>
                </div>

                <div class="weather-seasons-grid" role="radiogroup" aria-label="Selecciona una estación">
                    <!-- 1. Primavera -->
                    <button type="button" class="weather-season-opt is-active" data-season="spring" role="radio" aria-checked="true">
                        <span class="season-opt-icon">🌸</span>
                        <div class="season-opt-info">
                            <strong>Primavera Eterna</strong>
                            <small>Pétalos de rosa en vuelo 3D</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 2. Lluvia Romántica -->
                    <button type="button" class="weather-season-opt" data-season="rain" role="radio" aria-checked="false">
                        <span class="season-opt-icon">🌧️</span>
                        <div class="season-opt-info">
                            <strong>Lluvia Romántica</strong>
                            <small>Gotas de cristal y susurro</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 3. Verano Mágico -->
                    <button type="button" class="weather-season-opt" data-season="summer" role="radio" aria-checked="false">
                        <span class="season-opt-icon">☀️</span>
                        <div class="season-opt-info">
                            <strong>Verano Mágico</strong>
                            <small>Luciérnagas y polvo dorado</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 4. Otoño Cálido -->
                    <button type="button" class="weather-season-opt" data-season="autumn" role="radio" aria-checked="false">
                        <span class="season-opt-icon">🍂</span>
                        <div class="season-opt-info">
                            <strong>Otoño Cálido</strong>
                            <small>Hojas de ámbar en remolino</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 5. Invierno Encantado -->
                    <button type="button" class="weather-season-opt" data-season="winter" role="radio" aria-checked="false">
                        <span class="season-opt-icon">❄️</span>
                        <div class="season-opt-info">
                            <strong>Invierno Encantado</strong>
                            <small>Copos de nieve y escarcha</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 6. Noche de Estrellas & Deseos -->
                    <button type="button" class="weather-season-opt" data-season="stars" role="radio" aria-checked="false">
                        <span class="season-opt-icon">🌠</span>
                        <div class="season-opt-info">
                            <strong>Noche de Estrellas</strong>
                            <small>Estrellas fugaces interactivas</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 7. Burbujas de Ensueño -->
                    <button type="button" class="weather-season-opt" data-season="bubbles" role="radio" aria-checked="false">
                        <span class="season-opt-icon">🫧</span>
                        <div class="season-opt-info">
                            <strong>Burbujas de Ensueño</strong>
                            <small>Tócalas para hacerlas explotar</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>

                    <!-- 8. Calma Serena -->
                    <button type="button" class="weather-season-opt" data-season="clear" role="radio" aria-checked="false">
                        <span class="season-opt-icon">✨</span>
                        <div class="season-opt-info">
                            <strong>Calma Serena</strong>
                            <small>Descanso visual y paz</small>
                        </div>
                        <span class="season-opt-check" aria-hidden="true">✓</span>
                    </button>
                </div>

                <!-- PILAR 3: Micro-Ajustes de Intensidad y Sonido -->
                <div class="weather-controls-panel">
                    <!-- Densidad de partículas -->
                    <div class="weather-control-item">
                        <div class="weather-control-title">
                            <span>Densidad de partículas</span>
                        </div>
                        <div class="weather-intensity-selector" role="group" aria-label="Intensidad de partículas">
                            <button type="button" class="weather-intensity-btn" data-intensity="low">Suave</button>
                            <button type="button" class="weather-intensity-btn is-active" data-intensity="medium">Equilibrada</button>
                            <button type="button" class="weather-intensity-btn" data-intensity="high">Intensa</button>
                        </div>
                    </div>

                    <!-- Sonido ambiental y slider de volumen -->
                    <div class="weather-control-item">
                        <div class="weather-sound-control-row">
                            <div class="weather-sound-label">
                                <span class="sound-icon-indicator" id="weather-sound-icon">🔊</span>
                                <div>
                                    <strong>Sonido ambiental</strong>
                                    <small id="weather-sound-desc">Brisa primaveral serena</small>
                                </div>
                            </div>
                            <label class="weather-sound-toggle-switch" title="Activar o desactivar sonido ambiental">
                                <input type="checkbox" id="weather-sound-toggle" checked>
                                <span class="sound-toggle-slider"></span>
                            </label>
                        </div>

                        <div class="weather-volume-row">
                            <span class="vol-icon" aria-hidden="true">🔈</span>
                            <input type="range" class="weather-volume-slider" id="weather-volume-slider" min="0" max="1" step="0.05" value="0.7" title="Volumen ambiental" aria-label="Volumen ambiental">
                            <span class="vol-icon" aria-hidden="true">🔊</span>
                        </div>
                    </div>

                    <!-- Modo Biorritmo Automático según la hora -->
                    <div class="weather-control-item weather-toggle-item">
                        <div>
                            <strong>Biorritmo del Jardín</strong>
                            <small>Cambia el clima según la hora del día</small>
                        </div>
                        <label class="weather-sound-toggle-switch" title="Activar modo automático según la hora">
                            <input type="checkbox" id="weather-biorhythm-toggle">
                            <span class="sound-toggle-slider"></span>
                        </label>
                    </div>

                    <!-- PILAR 4: Sincronización con Clima Exterior Real -->
                    <div class="weather-control-item weather-realsync-item">
                        <div class="realsync-header">
                            <div>
                                <strong>Clima Exterior en Vivo</strong>
                                <small>Sincroniza el jardín con tu cielo real</small>
                            </div>
                            <button type="button" class="btn-weather-realsync" id="btn-weather-realsync" title="Sincronizar con Open-Meteo">
                                <span>🌦️ Sincronizar</span>
                            </button>
                        </div>
                        <span id="weather-real-status" class="weather-real-status" hidden></span>
                    </div>

                    <!-- PILAR 6: Filtros Cromáticos Cinematográficos (Color Grading) -->
                    <div class="weather-control-item">
                        <div class="weather-control-title">
                            <span>Filtro de Iluminación Emocional</span>
                        </div>
                        <div class="weather-grading-selector" role="group" aria-label="Filtro de iluminación">
                            <button type="button" class="weather-grading-btn is-active" data-grading="none" title="Iluminación Natural">🌿 Natural</button>
                            <button type="button" class="weather-grading-btn" data-grading="golden" title="Atardecer Cálido Dorado">🌅 Atardecer</button>
                            <button type="button" class="weather-grading-btn" data-grading="moonlight" title="Luz de Luna y Lavanda">🌙 Luna</button>
                            <button type="button" class="weather-grading-btn" data-grading="rose" title="Acuarela Rosa Romántica">🌸 Acuarela</button>
                            <button type="button" class="weather-grading-btn" data-grading="vintage" title="Bruma Nostálgica">🌧️ Bruma</button>
                        </div>
                    </div>

                    <!-- PILAR 5 & 7 & 8: Experiencias Especiales y Micro-Eventos -->
                    <div class="weather-control-item weather-special-actions-item">
                        <div class="weather-control-title">
                            <span>Experiencias Mágicas Especiales</span>
                        </div>
                        <div class="weather-special-btns-grid">
                            <!-- Pilar 5: Dibujar en Cristal Empañado -->
                            <button type="button" class="weather-special-btn" id="btn-open-misty-window" title="Dibujar en el cristal empañado">
                                <span>🪟 Cristal Empañado</span>
                            </button>

                            <!-- Pilar 7: Bóveda de Deseos a las Estrellas -->
                            <button type="button" class="weather-special-btn" id="btn-open-wish-vault" title="Ver o pedir deseos a las estrellas">
                                <span>⭐ Deseos al Cosmos</span>
                            </button>

                            <!-- Pilar 8: Invocar Arcoíris -->
                            <button type="button" class="weather-special-btn" id="btn-trigger-rainbow" title="Invocar arcoíris celestial">
                                <span>🌈 Arcoíris Suave</span>
                            </button>

                            <!-- Pilar 8: Aurora Boreal Toggle -->
                            <button type="button" class="weather-special-btn" id="btn-toggle-aurora" title="Ondas de aurora boreal">
                                <span>🌌 Aurora Boreal</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="weather-popover-footer">
                <span class="weather-footer-quote">«El tiempo cambia, pero este jardín siempre te espera.»</span>
            </footer>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  PILAR 5: DIALOG CRISTAL EMPAÑADO DE LLUVIA (INTERACTIVO)              -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="misty-window-dialog" id="misty-window-dialog" aria-label="Ventana con cristal empañado">
        <div class="misty-dialog-card">
            <header class="misty-dialog-header">
                <div>
                    <span class="misty-badge">🌧️ TARDE DE LLUVIA &amp; CRISTAL</span>
                    <h3 class="misty-title">Dibuja en la Ventana Empañada</h3>
                    <p class="misty-subtitle">Arrastra tu ratón o dedo para despejar el vaho y revelar el mensaje secreto.</p>
                </div>
                <button type="button" class="misty-close-btn" id="btn-close-misty-dialog" aria-label="Cerrar ventana empañada">✕</button>
            </header>

            <div class="misty-viewport">
                <!-- Capa secreta DEBAJO del canvas - se revela al despejar el vaho -->
                <div class="misty-secret-layer" id="misty-secret-layer" aria-hidden="true">
                    <span class="misty-secret-heart">♡</span>
                    <p class="misty-secret-greeting">Para Carla Lorena</p>
                    <p class="misty-secret-text" id="misty-secret-text">«No importa qué clima haya afuera, en mi corazón siempre hay un rincón cálido reservado para ti.»</p>
                    <small class="misty-secret-author">— Con cariño, siempre</small>
                    <button type="button" class="misty-cycle-quote-btn" id="btn-cycle-misty-quote">✨ Siguiente frase</button>
                </div>
                <!-- Canvas de vaho ENCIMA de la capa secreta -->
                <canvas id="misty-canvas" class="misty-canvas"></canvas>
            </div>

            <footer class="misty-dialog-footer">
                <div class="misty-actions-left">
                    <button type="button" class="misty-tool-btn" id="btn-fog-window-again">
                        🌫️ Volver a empañar
                    </button>
                </div>
                <button type="button" class="misty-btn-primary" id="btn-reveal-secret-heart">
                    💌 Revelar mensaje secreto
                </button>
            </footer>
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  PILAR 7: DIALOG BÓVEDA CELESTIAL DE DESEOS A LAS ESTRELLAS             -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <dialog class="wish-star-dialog" id="wish-star-dialog" aria-label="Bóveda de Deseos a las Estrellas">
        <div class="wish-star-card">
            <!-- Estrellas de fondo decorativas -->
            <div class="wish-star-bg" aria-hidden="true">
                <span class="wish-star-dot" style="top:8%;left:12%;animation-delay:0s"></span>
                <span class="wish-star-dot" style="top:22%;left:78%;animation-delay:0.4s"></span>
                <span class="wish-star-dot" style="top:5%;left:55%;animation-delay:0.8s"></span>
                <span class="wish-star-dot" style="top:40%;left:90%;animation-delay:0.2s"></span>
                <span class="wish-star-dot" style="top:70%;left:5%;animation-delay:0.6s"></span>
                <span class="wish-star-dot" style="top:85%;left:65%;animation-delay:1s"></span>
                <span class="wish-star-dot lg" style="top:15%;left:35%;animation-delay:0.3s"></span>
                <span class="wish-star-dot lg" style="top:60%;left:82%;animation-delay:0.9s"></span>
            </div>

            <header class="wish-star-header">
                <div class="wish-header-content">
                    <div class="wish-header-icon" aria-hidden="true">🌠</div>
                    <div>
                        <span class="wish-eyebrow">✦ NOCHE DE CONSTELACIONES ✦</span>
                        <h3 class="wish-title">Pide un Deseo a las Estrellas</h3>
                        <p class="wish-subtitle">Escribe aquello que tu corazón sueña. Quedará guardado en tu cielo personal.</p>
                    </div>
                </div>
                <button type="button" class="wish-close-btn" id="btn-close-wish-star" aria-label="Cerrar bóveda de deseos">✕</button>
            </header>

            <div class="wish-star-body">
                <!-- Formulario de nuevo deseo -->
                <form id="wish-star-form" class="wish-form">
                    <div class="wish-input-wrapper">
                        <textarea id="wish-star-text" class="wish-star-textarea" rows="3" maxlength="220" placeholder="Escribe aquí tu deseo más sincero, Carla..." required></textarea>
                        <span class="wish-counter" id="wish-star-counter">✏ 0 / 220</span>
                    </div>

                    <div class="wish-types-grid">
                        <label class="wish-type-item">
                            <input type="radio" name="star_type" value="golden" checked>
                            <span class="wish-type-chip chip-golden">🌟 Deseo Dorado</span>
                        </label>
                        <label class="wish-type-item">
                            <input type="radio" name="star_type" value="rose">
                            <span class="wish-type-chip chip-rose">💖 Deseo del Corazón</span>
                        </label>
                        <label class="wish-type-item">
                            <input type="radio" name="star_type" value="purple">
                            <span class="wish-type-chip chip-purple">🔮 Deseo Amatista</span>
                        </label>
                        <label class="wish-type-item">
                            <input type="radio" name="star_type" value="azure">
                            <span class="wish-type-chip chip-azure">💎 Deseo Infinito</span>
                        </label>
                    </div>

                    <div class="wish-form-actions">
                        <button type="submit" class="wish-submit-btn">
                            ✨ Enviar al Cosmos
                        </button>
                    </div>
                </form>

                <!-- Historial de deseos -->
                <div class="wish-collection-container">
                    <div class="wish-collection-header">
                        <h3>🌌 Tu Cielo de Deseos</h3>
                        <span class="wish-count-badge" id="wish-count-badge">0 estrellas</span>
                    </div>
                    <div class="wishes-list" id="wishes-list">
                        <div class="wish-empty-state">
                            <span style="font-size:2rem">✨</span>
                            <p>Aún no has lanzado deseos. ¡Pide el primero y enciende una estrella en tu cielo!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════ -->
    <!--  MODALES DE LAS 3 EXPERIENCIAS DE SORPRESAS FLOTANTES                  -->
    <!-- ═══════════════════════════════════════════════════════════════════════ -->

    <!-- 1. DIALOG: COFRE DE SORPRESAS -->
    <dialog class="surprise-modal-dialog" id="surprise-chest-dialog" aria-label="Cofre de Sorpresas de Carla Lorena">
        <div class="surprise-modal-card chest-card">
            <header class="surprise-modal-header">
                <div>
                    <span class="surprise-emblem">✨ 🎁 ✨</span>
                    <h2 class="surprise-title">Cofre de Sorpresas & Recuerdos</h2>
                </div>
                <button type="button" class="dialog-close surprise-close-btn" aria-label="Cerrar cofre">✕</button>
            </header>

            <div class="chest-content-stage" id="chest-content-stage">
                <!-- Se inyecta dinámicamente: Polaroid Flip, Cupón de Amor o Confidencia -->
            </div>

            <footer class="surprise-modal-footer">
                <button type="button" class="button button-primary surprise-action-btn" id="chest-next-btn">
                    <span>Abrir otra sorpresa</span> <span>🎲</span>
                </button>
                <small class="surprise-hint">Toca la tarjeta para descubrir el reverso</small>
            </footer>
        </div>
    </dialog>

    <!-- 2. DIALOG: BOTELLA AL VIENTO Y DESEOS -->
    <dialog class="surprise-modal-dialog" id="bottle-wishes-dialog" aria-label="Buzón de Botellas al Viento">
        <div class="surprise-modal-card bottle-card">
            <header class="surprise-modal-header">
                <div>
                    <span class="surprise-emblem">🌊 🏺 📜</span>
                    <h2 class="surprise-title">Botellas al Viento & Deseos</h2>
                </div>
                <button type="button" class="dialog-close surprise-close-btn" aria-label="Cerrar buzón">✕</button>
            </header>

            <div class="bottle-tabs">
                <button type="button" class="bottle-tab is-active" id="tab-read-bottle">📜 Mensaje en la Botella</button>
                <button type="button" class="bottle-tab" id="tab-send-wish">🌸 Lanzar un Deseo</button>
            </div>

            <!-- Tab 1: Leer mensaje rescatado -->
            <div class="bottle-pane is-active" id="pane-bottle-read">
                <div class="parchment-scroll-box" id="parchment-scroll-box">
                    <div class="parchment-wax-seal">❦</div>
                    <p class="parchment-text" id="parchment-message-text">«Cargando mensaje del mar del jardín...»</p>
                    <span class="parchment-author" id="parchment-author">— Con todo mi cariño</span>
                </div>
                <div class="bottle-actions">
                    <button type="button" class="button button-outline" id="bottle-fetch-another">Pescar otra botella 🌊</button>
                </div>
            </div>

            <!-- Tab 2: Enviar deseo al viento -->
            <div class="bottle-pane" id="pane-bottle-write" hidden>
                <div class="wish-form-wrap">
                    <p class="wish-intro">Escribe un deseo, un agradecimiento o un pensamiento para Carla. Al liberarlo, flotará como un pétalo de luz sobre el jardín.</p>
                    <textarea class="wish-textarea" id="wish-input" rows="3" placeholder="Escribe tu deseo con el corazón..." maxlength="250"></textarea>
                    <div class="wish-form-footer">
                        <small id="wish-char-count">0 / 250</small>
                        <button type="button" class="button button-primary" id="btn-release-wish">Liberar deseo al jardín ✨</button>
                    </div>
                </div>
                <div class="released-wishes-list" id="released-wishes-list">
                    <!-- Deseos guardados en localStorage -->
                </div>
            </div>
        </div>
    </dialog>

    <!-- 3. DIALOG: CÁMARA POLAROID INSTANTÁNEA -->
    <dialog class="surprise-modal-dialog" id="polaroid-camera-dialog" aria-label="Cámara Polaroid Instantánea">
        <div class="surprise-modal-card polaroid-card">
            <header class="surprise-modal-header">
                <div>
                    <span class="surprise-emblem">📸 🌸 🎞️</span>
                    <h2 class="surprise-title">Instantánea de Recuerdos</h2>
                </div>
                <button type="button" class="dialog-close surprise-close-btn" aria-label="Cerrar cámara">✕</button>
            </header>

            <div class="polaroid-photo-stage">
                <!-- Marco Polaroid clásico con relieve -->
                <div class="polaroid-frame" id="polaroid-frame-element">
                    <div class="polaroid-img-wrapper">
                        <img id="polaroid-photo-img" src="" alt="Recuerdo Polaroid">
                        <span class="polaroid-gold-seal">🌸 Carla</span>
                    </div>
                    <div class="polaroid-caption-band">
                        <h3 class="polaroid-title" id="polaroid-title-text">Flores de domingo</h3>
                        <p class="polaroid-quote" id="polaroid-quote-text">«Para recordarte lo bonito que es florecer despacio.»</p>
                        <div class="polaroid-meta-row">
                            <span class="polaroid-date" id="polaroid-date-text">16 de octubre, 2026</span>
                            <span class="polaroid-stamp">EDICIÓN JARDÍN ❦</span>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="surprise-modal-footer polaroid-footer">
                <button type="button" class="button button-primary" id="polaroid-download-btn">
                    <span>Descargar Postal PNG</span> <span>📥</span>
                </button>
                <button type="button" class="button button-outline" id="polaroid-reroll-btn">
                    <span>Tomar otra foto</span> <span>↻</span>
                </button>
            </footer>
        </div>
    </dialog>

    @auth
    <!-- Modal para Agregar / Editar Tarjetas del Inicio -->
    <dialog class="surprise-modal-dialog" id="admin-home-card-modal" aria-label="Gestionar Tarjetas de Inicio">
        <div class="surprise-modal-card" style="max-width: 580px; width: 92%;">
            <header class="surprise-modal-header">
                <div>
                    <span class="surprise-emblem">✨ 🗂️ 🌸</span>
                    <h2 class="surprise-title" id="admin-home-card-modal-title">Nueva Tarjeta para el Inicio</h2>
                </div>
                <button type="button" class="dialog-close surprise-close-btn" id="btn-close-home-card-modal" aria-label="Cerrar modal">✕</button>
            </header>

            <form id="admin-home-card-form" style="display: flex; flex-direction: column; gap: 14px; margin-top: 14px;">
                <input type="hidden" name="card_id" id="home-card-id" value="">
                
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Título de la Tarjeta *
                        <input type="text" name="title" id="home-card-title" required placeholder="Ej. Rincón de Paz, Galería..." style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px;">
                    </label>
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Ícono / Emblema
                        <input type="text" name="emblem_icon" id="home-card-emblem" placeholder="Ej. ▧ 🌸 o 🕊️" style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px;">
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Subtítulo / Etiqueta superior
                        <input type="text" name="subtitle" id="home-card-subtitle" placeholder="Ej. SERENIDAD, RECUERDOS..." style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px;">
                    </label>
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Orden de aparición
                        <input type="number" name="sort_order" id="home-card-order" value="1" min="1" style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px;">
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Pantalla de Destino *
                        <select name="target_screen" id="home-card-screen" required style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px; background: #fff;">
                            <option value="galeria">La Galería (#galeria)</option>
                            <option value="biblioteca">Rincón de Paz / Biblioteca (#biblioteca)</option>
                            <option value="amigos">Dedicatorias de Amigos (#amigos)</option>
                            <option value="entretenimiento">Música & Video (#entretenimiento)</option>
                            <option value="destinos">Mapa de Sueños (#destinos)</option>
                            <option value="jardin">Santuario Floral (#jardin)</option>
                            <option value="tesoro">Cofre del Tesoro (#tesoro)</option>
                            <option value="historias">Historias & Recuerdos (#historias)</option>
                            <option value="dedicatoria">Dedicatoria Principal (#dedicatoria)</option>
                            <option value="albumes">Álbumes de Fotos (#albumes)</option>
                            <option value="favoritos">Momentos Favoritos (#favoritos)</option>
                            <option value="capsula">Cápsula del Tiempo (#capsula)</option>
                            <option value="diario">Diario Íntimo (#diario)</option>
                            <option value="blog">Crónicas & Blog (#blog)</option>
                            <option value="juegos">Sala de Juegos (#juegos)</option>
                            <option value="conociendo-carla">Quiz Conociendo a Carla (#conociendo-carla)</option>
                            <option value="aventura-sultana">Aventura con Sultana (#aventura-sultana)</option>
                            <option value="sultana-plataformas">Juego de Plataformas (#sultana-plataformas)</option>
                            <option value="rompecabezas">Rompecabezas (#rompecabezas)</option>
                            <option value="bingo-amable">Bingo de Recuerdos (#bingo-amable)</option>
                            <option value="adivina-escena">Adivina la Escena (#adivina-escena)</option>
                            <option value="jardines-liria">Jardines de Liria (#jardines-liria)</option>
                            <option value="carla">Perfil de Carla (#carla)</option>
                            <option value="mapa">Mapa Completo (#mapa)</option>
                        </select>
                    </label>
                    <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                        Diseño / Estilo Visual *
                        <select name="style_variant" id="home-card-variant" required style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px; background: #fff;">
                            <option value="space-card-large">🌸 Rosa Romántico (Destacado)</option>
                            <option value="space-card-reading">📖 Pergamino Cálido (Serenidad)</option>
                            <option value="space-card-entertainment">🎶 Lavanda Silvestre (Melodía)</option>
                            <option value="space-card-dreams">✈️ Menta Esmeralda (Horizontes)</option>
                            <option value="space-card-treasure">✨ Ámbar Dorado (Tesoro)</option>
                            <option value="space-card-personal">💜 Lila Floral (Intimidad)</option>
                        </select>
                    </label>
                </div>

                <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                    Descripción breve *
                    <textarea name="description" id="home-card-desc" rows="2" required placeholder="Instantes y vivencias que iluminan el tiempo..." style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px; resize: vertical;"></textarea>
                </label>

                <label style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; font-weight: 600; color: #4a3b32;">
                    Frase / Cita inspiradora (Opcional)
                    <input type="text" name="quote" id="home-card-quote" placeholder="«Cada imagen guarda un pedacito de sol»" style="padding: 9px 12px; border-radius: 10px; border: 1px solid #d4c2b5; font-family: inherit; font-size: 13px;">
                </label>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="button button-outline" id="btn-cancel-home-card" style="padding: 8px 18px;">Cancelar</button>
                    <button type="submit" class="button button-primary" id="btn-save-home-card" style="padding: 8px 20px;">
                        <span id="btn-save-card-text">Guardar Tarjeta</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>
    @endauth

    <!-- ═══════════════════════════════════════════════════════════════════════
         PILAR 5: Cristal Empañado de Lluvia (Desempañar con dedo o cursor)
         ═══════════════════════════════════════════════════════════════════════ -->
    <dialog id="misty-window-dialog" class="modal-dialog misty-window-dialog" aria-labelledby="misty-dialog-title">
        <div class="misty-dialog-card">
            <header class="misty-dialog-header">
                <div>
                    <span class="misty-badge">🌧️ Experiencia Táctil Romántica</span>
                    <h2 id="misty-dialog-title" class="misty-title">Cristal Empañado de Lluvia</h2>
                    <p class="misty-subtitle">Pasa tu dedo o cursor sobre el cristal para desempañarlo y descubrir el mensaje secreto preparado para ti, Carla Lorena ♡</p>
                </div>
                <button type="button" class="misty-close-btn" id="btn-close-misty-dialog" aria-label="Cerrar ventana">×</button>
            </header>

            <div class="misty-viewport">
                <!-- Capa posterior: Mensaje secreto y diseño romántico -->
                <div class="misty-secret-layer" id="misty-secret-layer">
                    <div class="misty-secret-heart">💖</div>
                    <h3 class="misty-secret-greeting">Para ti, Carla Lorena</h3>
                    <p class="misty-secret-text" id="misty-secret-text">
                        «Eres la luz serena que ilumina cada rincón de este jardín. Ni la lluvia más intensa puede apagar la calidez y ternura que transmites al mundo.»
                    </p>
                    <span class="misty-secret-author">— Con todo el cariño de tu Jardín Secreto ♡</span>
                    <button type="button" class="misty-cycle-quote-btn" id="btn-cycle-misty-quote" title="Leer otro mensaje">
                        💌 Cambiar mensaje secreto
                    </button>
                </div>

                <!-- Capa frontal: Lienzo con efecto empañado interactivo -->
                <canvas class="misty-canvas" id="misty-canvas" width="600" height="380"></canvas>
            </div>

            <footer class="misty-dialog-footer">
                <div class="misty-actions-left">
                    <button type="button" class="misty-tool-btn" id="btn-fog-window-again">
                        <span>🌫️ Volver a Empañar</span>
                    </button>
                    <button type="button" class="misty-tool-btn" id="btn-reveal-secret-heart">
                        <span>✨ Dibujar Corazón Automático</span>
                    </button>
                </div>
                <button type="button" class="misty-btn-primary" id="btn-finish-misty">
                    <span>Listo, guardar en el corazón ♡</span>
                </button>
            </footer>
        </div>
    </dialog>

    <!-- ═══════════════════════════════════════════════════════════════════════
         PILAR 7: Bóveda Celestial de Deseos al Cosmos (Wish Vault)
         ═══════════════════════════════════════════════════════════════════════ -->
    <dialog id="wish-star-dialog" class="modal-dialog wish-star-dialog" aria-labelledby="wish-dialog-title">
        <div class="wish-dialog-card">
            <header class="wish-dialog-header">
                <div>
                    <span class="wish-badge">🌠 Bóveda de Estrellas</span>
                    <h2 id="wish-dialog-title" class="wish-title">Deseos al Firmamento</h2>
                    <p class="wish-subtitle">Confía un anhelo al universo. Cada deseo se convertirá en una estrella radiante que acompañará tus pasos para siempre.</p>
                </div>
                <button type="button" class="wish-close-btn" id="btn-close-wish-dialog" aria-label="Cerrar bóveda">×</button>
            </header>

            <div class="wish-dialog-body">
                <!-- Formulario de nuevo deseo -->
                <form id="wish-star-form" class="wish-form">
                    <label for="wish-star-text" class="wish-label">
                        ¿Qué deseo guarda hoy tu corazón, Carla?
                    </label>
                    <textarea 
                        id="wish-star-text" 
                        class="wish-textarea" 
                        rows="3" 
                        required 
                        placeholder="Ejemplo: Que este nuevo año de vida esté lleno de risas sinceras, paz en el alma y proyectos que florezcan con amor..."
                        maxlength="300"
                    ></textarea>

                    <div class="wish-star-type-selector">
                        <span class="wish-type-label">Elige la luz de tu estrella:</span>
                        <div class="wish-types-grid" role="radiogroup">
                            <label class="wish-type-item">
                                <input type="radio" name="star_type" value="golden" checked>
                                <span class="wish-type-chip chip-golden">🌟 Dorada · Éxito & Paz</span>
                            </label>
                            <label class="wish-type-item">
                                <input type="radio" name="star_type" value="rose">
                                <span class="wish-type-chip chip-rose">💖 Rosa · Amor & Ternura</span>
                            </label>
                            <label class="wish-type-item">
                                <input type="radio" name="star_type" value="purple">
                                <span class="wish-type-chip chip-purple">🔮 Amatista · Sueños Profundos</span>
                            </label>
                            <label class="wish-type-item">
                                <input type="radio" name="star_type" value="azure">
                                <span class="wish-type-chip chip-azure">💎 Zafiro · Serenidad</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="wish-submit-btn" id="btn-submit-wish">
                        <span>Lanzar Deseo al Firmamento 🌠</span>
                    </button>
                </form>

                <!-- Lista de deseos grabados en el firmamento -->
                <div class="wish-collection-container">
                    <div class="wish-collection-header">
                        <h3>Constelación de Tus Deseos Guardados</h3>
                        <span class="wish-count-badge" id="wish-count-badge">0 estrellas</span>
                    </div>
                    <div class="wish-cards-list" id="wishes-list">
                        <!-- Generados dinámicamente por JS -->
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    <div id="flash-effect-overlay" class="flash-effect-overlay" aria-hidden="true" hidden></div>

    <!-- Lienzo Global de Climas y Estaciones Atmosféricas (Toda la interfaz) -->
    <canvas class="global-weather-canvas" id="global-weather-canvas" aria-hidden="true"></canvas>

    <!-- Capa de Filtros Fotográficos Cinematográficos (Pilar 6 - No altera containing block de body) -->
    <div id="atmospheric-color-overlay" class="atmospheric-color-overlay" aria-hidden="true"></div>

    <canvas class="romantic-magic-cursor" id="romantic-magic-cursor" aria-hidden="true"></canvas>
    <div class="map-island-tooltip" id="map-island-tooltip" role="tooltip" hidden></div>
    <div class="toast{{ session('status') ? ' is-visible' : '' }}" role="status" aria-live="polite">{{ session('status') }}</div>
</body>