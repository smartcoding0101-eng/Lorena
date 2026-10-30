        <section class="screen" data-screen="sultana-plataformas" aria-labelledby="platformer-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#juegos" data-go="juegos">← Volver a los juegos</a>
                <div class="page-heading">
                    <div><p class="eyebrow">AVENTURA DE PLATAFORMAS · 9 NIVELES</p><h1 id="platformer-title">Sultana y los <em>senderos del alba</em></h1><p>Corre, salta y reúne pétalos en nueve rincones de Sultana. Evita las sombras traviesas o rebótales encima para abrir el arco de salida final.</p></div>
                    <span class="heading-mark" aria-hidden="true">✦</span>
                </div>
                <section class="platformer-game" aria-label="Juego de plataformas de Sultana">
                    <div class="platformer-toolbar">
                        <p data-platformer-status role="status" aria-live="polite">Carga la aventura para empezar.</p>
                        <span data-platformer-level>Nivel 1 de 9</span>
                        <span data-platformer-petals>Pétalos: 0</span>
                        <span data-platformer-relics>Objetos especiales: 0</span>
                        <span data-platformer-lives>Corazones: ♥♥♥</span>
                        <span data-platformer-score>Puntuación: 0</span>
                        <span data-platformer-best-level>Récord del nivel: 0</span>
                        <span data-platformer-best-campaign>Récord de campaña: 0</span>
                    </div>
                    <div class="platformer-settings">
                        <label for="platformer-difficulty">Dificultad</label>
                        <select id="platformer-difficulty" data-platformer-difficulty aria-label="Elegir dificultad">
                            <option value="calm">Serena (5 ♥ · Pacífica)</option>
                            <option value="adventure" selected>Aventura (3 ♥ · Equilibrada)</option>
                            <option value="challenge">Desafío Real (2 ♥ · Sombras veloces)</option>
                        </select>
                        <label for="platformer-level">Escenario</label>
                        <select id="platformer-level" data-platformer-select aria-label="Elegir nivel desbloqueado"></select>
                        <strong data-platformer-ability>Habilidad: Salto y carrera</strong>
                        <button class="button button-outline" type="button" data-platformer-scroll-btn title="Leer carta de amor de Adrián de este escenario">💌 Carta de Adrián</button>
                        <button class="button button-outline" type="button" data-platformer-pause aria-pressed="false">Pausar</button>
                        <button class="button button-outline" type="button" data-platformer-restart>Reiniciar nivel</button>
                        <button class="button button-outline" type="button" data-platformer-clear>Reiniciar avance</button>
                        <button class="button button-primary" type="button" data-platformer-next hidden>Pasar al siguiente ahora</button>
                    </div>

                    <!-- Banner de Pergamino de Amor activo en el escenario -->
                    <div class="platformer-love-banner" data-platformer-love-banner>
                        <span class="love-banner-icon">💌</span>
                        <div class="love-banner-content">
                            <strong data-platformer-letter-title>Carta de Adrián para Carla Lorena</strong>
                            <p data-platformer-letter-snippet>Que cada salto te recuerde lo valiente y maravillosa que eres...</p>
                        </div>
                        <button type="button" class="love-banner-action" data-platformer-read-letter>Leer completa</button>
                    </div>

                    <canvas class="platformer-canvas" data-platformer-canvas aria-label="Escenario lateral de plataformas. Usa flechas o A y D para moverte y espacio para saltar." role="img"></canvas>
                    <div class="platformer-controls" data-platformer-controls aria-label="Controles táctiles del juego">
                        <div class="platformer-dpad">
                            <button type="button" data-platformer-control="left" aria-label="Mover a la izquierda" aria-pressed="false">←</button>
                            <button type="button" data-platformer-control="right" aria-label="Mover a la derecha" aria-pressed="false">→</button>
                        </div>
                        <div class="platformer-actions">
                            <button type="button" data-platformer-control="jump" aria-label="Saltar" aria-pressed="false">Saltar</button>
                            <button type="button" data-platformer-control="action" aria-label="Usar destello protector">Acción</button>
                        </div>
                    </div>
                    <div class="platformer-help">
                        <p><strong>Teclado:</strong> A/D o flechas para moverte, espacio o W para saltar, P para pausar y E/X para el destello del nivel 3.</p>
                        <p>Tienes tres corazones: al perder uno reapareces en el último punto de control; al agotarlos, el nivel actual se reinicia desde el principio y vuelves a intentarlo. El nivel 2 desbloquea salto doble; desde el nivel 3 puedes usar destellos contra los enemigos. Las sombras patrullan, los murciélagos vuelan y los espíritus hacen embestidas breves. Cada escenario tiene objetos especiales propios que recuperan corazones o conceden destellos. Suma puntos por pétalos, reliquias, enemigos vencidos y niveles superados. Los récords se guardan en este navegador; el récord de campaña se obtiene al completar los nueve niveles desde el primero. Al cruzar la salida, el siguiente nivel comienza automáticamente; el botón permite avanzar de inmediato.</p>
                    </div>
                    <section class="platformer-finale" data-platformer-finale aria-labelledby="platformer-finale-title" hidden>
                        <div class="platformer-finale-art">
                            <img src="/sultana-finale.svg" alt="Ilustración de Sultana en el jardín de Sultana, bajo un cielo de estrellas y flores doradas">
                            <p>Ilustración original de demostración; no es una fotografía de Carla.</p>
                        </div>
                        <div class="platformer-finale-story">
                            <p class="eyebrow">EL FINAL · LA LUZ VUELVE A Sultana</p>
                            <h2 id="platformer-finale-title" tabindex="-1">Un jardín para guardar la luz</h2>
                            <p>Cuando la última estrella volvió a encenderse, las flores despertaron y los senderos de Sultana se llenaron de luz. Sultana comprendió que la magia más valiosa no estaba en la corona, sino en todo lo vivido para llegar hasta ella.</p>
                            <p>En el corazón del jardín encontró una carta:</p>
                            <blockquote>Carla Lorena, este pequeño universo fue creado para celebrar la luz que llevas contigo. Que siempre encuentres aquí un rincón para soñar, descansar y sonreír. Con todo mi corazón y mi amor verdadero.<br><span style="display:block; text-align:right; font-weight:600; margin-top:8px; font-size:16px; color:var(--orange-600);">— Con infinito cariño, Adrián 💌</span></blockquote>
                            <p class="platformer-finale-note">La ilustración puede sustituirse por una fotografía tuya autorizada cuando quieras añadirla.</p>
                            <button class="button button-primary" type="button" data-platformer-replay>Volver a jugar desde el inicio</button>
                        </div>
                    </section>

                    <!-- Modal emergente para leer la carta de Adrián del escenario actual -->
                    <dialog class="platformer-letter-modal" data-platformer-letter-modal aria-labelledby="platformer-modal-title">
                        <div class="platformer-letter-card">
                            <button type="button" class="platformer-letter-close" data-platformer-letter-close aria-label="Cerrar carta">✕</button>
                            <div class="platformer-letter-seal">✦ 💌 ✦</div>
                            <span class="platformer-letter-subtitle">Palabras de Adrián para Carla Lorena</span>
                            <h3 id="platformer-modal-title" data-platformer-modal-title>El sendero de las luciérnagas</h3>
                            <div class="platformer-letter-body" data-platformer-modal-text>
                                <!-- Mensaje inyectado por JS -->
                            </div>
                            <div class="platformer-letter-sign">
                                <span>Siempre a tu lado en cada sendero,</span>
                                <strong>Adrián</strong>
                            </div>
                            <button type="button" class="button button-primary" data-platformer-letter-confirm>Continuar mi aventura</button>
                        </div>
                    </dialog>

                    <p class="platformer-note">Escenarios y personajes originales dibujados con formas geométricas. Los niveles desbloqueados y los mejores resultados se guardan solo en este navegador; reiniciar el avance borra ambos. No se sincronizan ni se envían a un servidor.</p>
                </section>
            </div>
        </section>
