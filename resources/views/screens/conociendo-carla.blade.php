        <section class="screen" data-screen="conociendo-carla" aria-labelledby="quiz-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#juegos" data-go="juegos">← Volver a los juegos</a>
                <div class="page-heading">
                    <div><p class="eyebrow">Diez preguntas · una recompensa</p><h1 id="quiz-title">Conociendo a <em>Carla Lorena</em></h1><p>Una ronda selecciona diez preguntas al azar. Hay que acertarlas todas; no revelaremos las respuestas correctas.</p></div>
                    <span class="heading-mark" aria-hidden="true">?</span>
                </div>
                <section class="quiz-game-card" aria-label="Partida del cuestionario">
                    <div class="quiz-readiness">
                        <span><strong data-quiz-active-count>{{ $quizActiveCount }}</strong> preguntas activas (necesitas al menos 10)</span>
                        <span class="{{ $quizRewardReady ? 'readiness-ready' : 'readiness-pending' }}">{{ $quizRewardReady ? 'Foto de recompensa preparada' : 'Foto de recompensa pendiente' }}</span>
                    </div>
                    <div class="quiz-intro" data-quiz-intro>
                        <span class="quiz-mark" aria-hidden="true">✿</span>
                        <h2>¿Cuánto sabes de Carla?</h2>
                        <p>Responde diez preguntas escritas. Las respuestas distinguen el contenido, no las mayúsculas ni los acentos. Un error termina la ronda, pero podrás intentar otra más tarde.</p>
                        <button class="button button-primary" type="button" data-quiz-start>Comenzar reto <span aria-hidden="true">↗</span></button>
                    </div>
                    <div class="quiz-play" data-quiz-play hidden>
                        <div class="quiz-progress-heading"><span data-quiz-progress-label>Pregunta 1 de 10</span><progress data-quiz-progress max="10" value="0">0 de 10</progress></div>
                        <h2 data-quiz-question></h2>
                        <form data-quiz-answer-form>
                            <label for="quiz-answer">Tu respuesta</label>
                            <input id="quiz-answer" name="answer" type="text" maxlength="500" autocomplete="off" required>
                            <button class="button button-primary" type="submit">Comprobar respuesta <span aria-hidden="true">→</span></button>
                        </form>
                    </div>
                    <div class="quiz-result" data-quiz-result role="status" aria-live="polite" hidden></div>
                    <div class="quiz-reward" data-quiz-reward hidden>
                        <p class="eyebrow">LAS DIEZ RESPUESTAS FUERON CORRECTAS</p>
                        <h2>¡Has descubierto la sorpresa!</h2>
                        <img data-quiz-reward-image alt="Fotografía de recompensa autorizada por Carla">
                    </div>
                    <button class="button button-outline quiz-restart" type="button" data-quiz-start hidden>Intentar otra partida <span aria-hidden="true">↻</span></button>
                </section>
                <p class="demo-disclaimer">La partida se verifica en el servidor. El límite es de 10 partidas por hora desde una misma dirección de red. La fotografía se entrega solo tras acertar diez respuestas y podrá guardarse una vez revelada.</p>

                @if ($isGardenQuizManager)
                    <section class="quiz-admin" aria-labelledby="quiz-admin-title">
                        <div class="quiz-admin-heading"><p class="eyebrow">SOLO VISIBLE EN TU SESIÓN</p><h2 id="quiz-admin-title">Administrar preguntas y recompensa</h2><p>Las respuestas se guardan como verificadores criptográficos; nunca se envían al navegador. Al editar una pregunta puedes dejar las variantes vacías para conservarlas, o reemplazarlas.</p></div>
                        @if (session('status'))
                            <p class="form-success" role="status">{{ session('status') }}</p>
                        @endif
                        @if ($errors->any())
                            <div class="form-errors" role="alert"><p>No se pudo actualizar la foto.</p><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <form class="quiz-admin-create" data-quiz-create>
                            <label for="quiz-new-question">Nueva pregunta</label>
                            <textarea id="quiz-new-question" name="question" rows="2" maxlength="500" required placeholder="Escribe una pregunta que pueda responderse con claridad."></textarea>
                            <label for="quiz-new-answers">Respuestas aceptadas <span>(una variante por línea; hasta 8)</span></label>
                            <textarea id="quiz-new-answers" name="answer_variants" rows="3" maxlength="1500" required placeholder="Primera respuesta válida&#10;Otra forma de escribirla"></textarea>
                            <label class="quiz-active-control"><input name="is_active" type="checkbox" checked> Incluir en las partidas</label>
                            <button class="button button-primary" type="submit">Guardar pregunta <span aria-hidden="true">＋</span></button>
                        </form>
                        <p class="quiz-admin-feedback" data-quiz-admin-feedback role="status" aria-live="polite"></p>
                        <p class="quiz-question-count" data-quiz-admin-count>{{ $quizActiveCount }} activas · se necesitan 10 para jugar</p>
                        <div class="quiz-question-list" data-quiz-question-list>
                            @foreach ($quizQuestions as $quizQuestion)
                                <article class="quiz-admin-question" data-quiz-admin-question data-question-id="{{ $quizQuestion->id }}" data-was-active="{{ $quizQuestion->is_active ? 'true' : 'false' }}">
                                    <div class="quiz-admin-question-heading"><h3>Pregunta <span data-question-id-label>{{ $quizQuestion->id }}</span></h3><button class="text-link danger-link" type="button" data-quiz-delete>Eliminar</button></div>
                                    <label for="quiz-question-{{ $quizQuestion->id }}">Texto de la pregunta</label>
                                    <textarea id="quiz-question-{{ $quizQuestion->id }}" data-question-text rows="2" maxlength="500">{{ $quizQuestion->question }}</textarea>
                                    <label for="quiz-answers-{{ $quizQuestion->id }}">Reemplazar variantes <span>({{ count($quizQuestion->answer_hashes ?? []) }} guardadas; deja vacío para conservarlas)</span></label>
                                    <textarea id="quiz-answers-{{ $quizQuestion->id }}" data-answer-variants rows="2" maxlength="1500" placeholder="Una variante por línea; nunca se vuelven a mostrar las guardadas."></textarea>
                                    <label class="quiz-active-control"><input data-question-active type="checkbox" @checked($quizQuestion->is_active)> Incluir en las partidas</label>
                                    <button class="button button-outline" type="button" data-quiz-save>Guardar cambios</button>
                                </article>
                            @endforeach
                        </div>
                        <form class="quiz-reward-form" method="POST" enctype="multipart/form-data" action="{{ route('garden-quiz.reward.upload') }}">
                            @csrf
                            <p class="eyebrow">FOTO DE RECOMPENSA</p>
                            <h3>{{ $quizRewardReady ? 'Ya hay una foto autorizada' : 'Elige la foto que aparecerá al acertar 10/10' }}</h3>
                            <label for="quiz-reward-image">Imagen privada <span>(JPG, PNG o WebP; hasta 10 MB)</span></label>
                            <input id="quiz-reward-image" name="reward_image" type="file" accept="image/jpeg,image/png,image/webp" required>
                            <label class="quiz-consent"><input type="checkbox" name="reward_authorized" value="1" required> Confirmo que Carla autorizó mostrar esta imagen a visitantes que completen el reto y entiendo que, una vez revelada, puede guardarse o capturarse.</label>
                            <button class="button button-primary" type="submit">Guardar foto autorizada</button>
                        </form>
                        @if ($quizRewardReady)
                            <form class="quiz-reward-delete" method="POST" action="{{ route('garden-quiz.reward.delete') }}" data-confirm="Retirar la foto pausará las nuevas partidas. ¿Continuar?">
                                @csrf
                                @method('DELETE')
                                <button class="text-link danger-link" type="submit">Retirar y borrar la foto de recompensa</button>
                            </form>
                        @endif
                    </section>
                @endif
            </div>
        </section>
