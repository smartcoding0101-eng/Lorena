        <section class="screen" data-screen="aventura-sultana" aria-labelledby="sultana-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#juegos" data-go="juegos">← Volver a los juegos</a>
                <div class="page-heading">
                    <div><p class="eyebrow">Cinco capítulos · tus decisiones dan forma al reino</p><h1 id="sultana-title">Las crónicas de la princesa <em>Sultana</em></h1><p>Una aventura de fantasía con estrategia, acertijos y un romance opcional entre personajes ficticios.</p></div>
                    <span class="heading-mark" aria-hidden="true">✧</span>
                </div>
                <section class="sultana-game" data-sultana-game aria-label="Aventura de la princesa Sultana">
                    <div class="sultana-intro" data-sultana-intro>
                        <span class="sultana-emblem" aria-hidden="true">♕</span>
                        <p class="eyebrow">UNA HISTORIA ORIGINAL</p>
                        <h2>El reino aguarda una nueva guardiana</h2>
                        <p>Sultana es una heroína ficticia, no una biografía de Carla. Recorrerás jardines encantados, aconsejarás al reino y conocerás a dos personajes inventados. Tus elecciones decidirán qué tipo de futuro florece.</p>
                        <button class="button button-primary" type="button" data-sultana-start>Comenzar la aventura <span aria-hidden="true">→</span></button>
                        <button class="button button-outline" type="button" data-sultana-clear hidden>Borrar avance dañado</button>
                        <p data-sultana-save-status role="status" aria-live="polite" hidden></p>
                    </div>
                    <div class="sultana-play" data-sultana-play hidden>
                        <div class="sultana-status">
                            <div class="sultana-progress-copy"><span class="eyebrow" data-sultana-level>NIVEL 01 DE 05</span><span data-sultana-progress-label>Capítulo 1 de 5</span></div>
                            <progress data-sultana-progress value="0" max="5" aria-label="Progreso de la aventura"></progress>
                        </div>
                        <div class="sultana-stats" aria-label="Cualidades desarrolladas">
                            <span>Sabiduría <strong data-sultana-stat="wisdom">0</strong></span>
                            <span>Empatía <strong data-sultana-stat="compassion">0</strong></span>
                            <span>Confianza <strong data-sultana-stat="trust">0</strong></span>
                            <span>Valor <strong data-sultana-stat="courage">0</strong></span>
                            <span>Vínculo <strong data-sultana-stat="romance">0</strong></span>
                        </div>
                        <article class="sultana-scene" data-sultana-scene aria-live="polite">
                            <p class="eyebrow" data-sultana-chapter></p>
                            <h2 data-sultana-scene-title tabindex="-1"></h2>
                            <p data-sultana-scene-copy></p>
                            <p class="sultana-choice-result" data-sultana-feedback role="status" aria-live="polite" hidden></p>
                            <div class="sultana-choices" data-sultana-choices></div>
                            <div class="sultana-ending" data-sultana-ending hidden></div>
                        </article>
                        <div class="sultana-achievements">
                            <div class="sultana-achievements-heading"><p class="eyebrow">LOGROS DEL VIAJE</p><span data-sultana-achievement-count>0 de 5</span></div>
                            <ul data-sultana-achievements aria-label="Logros desbloqueados"></ul>
                        </div>
                        <div class="sultana-save-row">
                            <p data-sultana-save-status role="status" aria-live="polite">El avance se guarda en este navegador.</p>
                            <button class="button button-outline" type="button" data-sultana-reset>Reiniciar aventura</button>
                        </div>
                    </div>
                    <p class="sultana-privacy-note">La aventura es ficticia. El avance se almacena solo en este navegador; no se sincroniza ni requiere iniciar sesión.</p>
                </section>
            </div>
        </section>
