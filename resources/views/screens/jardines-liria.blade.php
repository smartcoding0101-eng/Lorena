        <section class="screen" data-screen="jardines-liria" aria-labelledby="garden3d-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#juegos" data-go="juegos">← Volver a los juegos</a>
                <div class="page-heading">
                        <div><p class="eyebrow">AVENTURA EXPLORABLE · 18 ESCENARIOS</p><h1 id="garden3d-title">Los jardines secretos de <em>Sultana</em></h1><p>Despierta la fuente y el invernadero; luego supera dieciséis nuevos escenarios con aliados, pistas, enemigos y trampas.</p></div>
                    <span class="heading-mark" aria-hidden="true">❀</span>
                </div>
                <section class="garden3d-game" data-garden3d-game aria-label="Aventura 3D por los jardines de Liria">
                    <div class="garden3d-quest" aria-label="Objetivos de la aventura">
                        <div class="garden3d-quest-heading">
                            <div><p class="eyebrow">TU RECORRIDO</p><h2 data-garden3d-quest-title>La fuente silenciosa</h2></div>
                            <span class="garden3d-quest-step" data-garden3d-quest-step>01 / 12</span>
                        </div>
                        <div class="garden3d-quest-track" role="progressbar" aria-label="Progreso de la aventura" aria-valuemin="0" aria-valuemax="18" aria-valuenow="0" data-garden3d-quest-track><span data-garden3d-quest-progress></span></div>
                        <ol class="garden3d-quest-list" aria-label="Dieciocho escenarios de la aventura"></ol>
                    </div>
                    <!-- Franja de Estado y Notificaciones del Jardín -->
                    <div class="garden3d-status-bar" data-garden3d-status-bar>
                        <span class="garden3d-status-icon" aria-hidden="true">❀</span>
                        <p class="garden3d-status-text" data-garden3d-status role="status" aria-live="polite">Carga el jardín para comenzar la exploración.</p>
                    </div>

                    <!-- Barra de Información y Controles del Jardín -->
                    <div class="garden3d-toolbar">
                        <div class="garden3d-toolbar-info">
                            <span class="garden3d-level" data-garden3d-level aria-live="polite">Zona 1 de 12 · La fuente silenciosa</span>
                            <span class="garden3d-collection" data-garden3d-count aria-live="polite">Flores: 0 de 3</span>
                        </div>
                        <div class="garden3d-toolbar-guide">
                            <span class="garden3d-objective" data-garden3d-objective role="group" aria-label="Guía del objetivo">
                                <span class="garden3d-objective-arrow" data-garden3d-objective-arrow aria-hidden="true">↑</span>
                                <span class="garden3d-objective-label" data-garden3d-objective-text>Busca la flor iluminada más cercana</span>
                            </span>
                        </div>
                        <div class="garden3d-toolbar-actions">
                            <button class="button button-outline garden3d-pause" type="button" data-garden3d-pause aria-pressed="false">Pausar</button>
                            <button class="button button-outline" type="button" data-garden3d-reset>Reiniciar el paseo</button>
                        </div>
                    </div>
                    <div class="garden3d-stage" data-garden3d-stage>
                        <!-- Banner Flotante Romántico de Amor para Carla Lorena -->
                        <div class="garden3d-love-banner" data-garden3d-love-banner hidden aria-live="polite">
                            <span class="love-banner-icon" aria-hidden="true">💌</span>
                            <div class="love-banner-text">
                                <strong class="love-banner-title">Dedicatoria para Carla Lorena</strong>
                                <p class="love-banner-quote" data-garden3d-love-quote>«Cada paso en este jardín florece por ti, mi vida.»</p>
                            </div>
                            <span class="love-banner-signature">— Tu Ingeniero Julio Adrián</span>
                        </div>

                        <div class="garden3d-loading" data-garden3d-loading>
                            <span aria-hidden="true">❀</span>
                            <p>Preparando el jardín de Carla Lorena…</p>
                        </div>
                        <div class="garden3d-pause-overlay" data-garden3d-pause-overlay hidden>
                            <span aria-hidden="true">Ⅱ</span><strong>Paseo en pausa</strong><p>Respira un momento. Tu avance se ha guardado.</p>
                            <button class="button button-primary" type="button" data-garden3d-resume>Continuar paseo</button>
                        </div>
                        {{-- Diálogo de confirmación de reinicio --}}
                        <div class="garden3d-confirm-overlay" data-garden3d-confirm-overlay hidden role="alertdialog" aria-modal="true" aria-labelledby="garden3d-confirm-title">
                            <div class="garden3d-confirm-card">
                                <span class="garden3d-confirm-icon" aria-hidden="true">🌿</span>
                                <h3 id="garden3d-confirm-title">¿Reiniciar el paseo?</h3>
                                <p>Se borrarán todas las flores y semillas recogidas, el progreso de escenarios y la posición guardada en este navegador.</p>
                                <p class="garden3d-confirm-sub">Esta acción no se puede deshacer.</p>
                                <div class="garden3d-confirm-actions">
                                    <button class="button button-outline" type="button" data-garden3d-confirm-cancel>Cancelar</button>
                                    <button class="button button-danger" type="button" data-garden3d-confirm-ok>Sí, reiniciar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <article class="garden3d-finale" data-garden3d-finale hidden aria-live="polite">
                        <span class="garden3d-finale-mark" aria-hidden="true">💖</span>
                        <p class="eyebrow">AVENTURA COMPLETADA · PARA CARLA LORENA</p>
                        <h2>El amor siempre hace florecer el camino</h2>
                        <p>Cuando la última semilla tocó la tierra, el árbol del corazón abrió sus ramas y un resplandor dorado iluminó los dieciocho reinos del jardín. Las fuentes volvieron a cantar al unísono y los guardianes reverenciaron la nobleza y bondad de Carla Lorena.</p>
                        <p>«Carla, eres la reina de mi corazón y la luz de mis días. Cada escenario que recorriste fue diseñado con admiración infinita y amor sincero para ti.»</p>
                        <p class="finale-signature-note"><em>Con todo mi amor y cariño para la mujer de mi vida, Tu Ingeniero Julio Adrián ♡</em></p>
                        <button class="button button-primary" type="button" data-garden3d-replay>Volver a recorrer el jardín <span aria-hidden="true">↗</span></button>
                    </article>
                    <div class="garden3d-controls" aria-label="Controles de movimiento">
                        <div class="garden3d-help">
                            <details class="garden3d-howto">
                                <summary>Cómo explorar y completar el capítulo</summary>
                                <div>
                                    <p><strong>Computadora</strong> · WASD o flechas para moverte según la cámara · Mayús para correr · E para interactuar · P para pausar. Arrastra la escena para girar la cámara.</p>
                                    <p><strong>Teléfono o tableta</strong> · mantén pulsadas las flechas para caminar, usa Correr y pulsa la acción cuando estés cerca. Arrastra la escena para mirar alrededor.</p>
                                    <p>Acércate a una flor, a la jardinera o a la fuente para activar la acción contextual. Al despertar el árbol del corazón se abren diez escenarios nuevos. En cada uno, reúne los recuerdos, habla con tu aliada, cumple la acción propia del escenario y alcanza el arco; evita enemigos y trampas, que te hacen perder vidas y te devuelven al inicio del escenario.</p>
                                    <p>La flecha señala el objetivo pendiente más cercano y la lista de arriba muestra los dieciocho escenarios. Al abrir un arco avanzarás automáticamente. El progreso y la posición se guardan en este navegador.</p>
                                </div>
                            </details>
                        </div>
                        <div class="garden3d-touchpad" data-garden3d-touchpad aria-label="Movimiento táctil">
                            <button type="button" data-garden3d-direction="forward" aria-label="Avanzar" aria-pressed="false">↑</button>
                            <button type="button" data-garden3d-direction="left" aria-label="Mover a la izquierda" aria-pressed="false">←</button>
                            <button type="button" data-garden3d-direction="back" aria-label="Retroceder" aria-pressed="false">↓</button>
                            <button type="button" data-garden3d-direction="right" aria-label="Mover a la derecha" aria-pressed="false">→</button>
                            <button class="garden3d-sprint" type="button" data-garden3d-sprint aria-pressed="false">Correr</button>
                            <button class="garden3d-action" type="button" data-garden3d-interact>Interactuar</button>
                        </div>
                    </div>
                    <p class="garden3d-note">Escenario original construido con formas tridimensionales; no incluye fotos de Carla ni requiere conexión para guardar. El capítulo se puede pausar y continuar. Reiniciar borra el avance local únicamente después de confirmar.</p>
                </section>
            </div>
        </section>
