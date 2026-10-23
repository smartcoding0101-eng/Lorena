        <section class="screen" data-screen="amigos" aria-labelledby="friends-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>

                <div class="page-heading">
                    <div>
                        <p class="eyebrow">VOCES SINCERAS · EL JARDÍN DE LA AMISTAD</p>
                        <h1 id="friends-title" class="shimmer-title">Dedicatorias de <em>Amigos</em></h1>
                        <p>«Palabras y cariño que florecen para Carla. Todo lo que tus amigos piensan, agradecen y guardan en el corazón para ti.»</p>
                    </div>
                    <a class="button button-outline" href="#jardin" data-go="jardin">
                        <span>🌸 Ir al santuario floral</span> <span>↗</span>
                    </a>
                </div>

                <div class="friends-layout-grid">
                    <!-- Formulario para dedicar un mensaje -->
                    <div class="friends-form-card">
                        <div class="friends-form-header">
                            <span class="friends-form-icon">✍️ ❦</span>
                            <h2>Dedicar unas palabras a Carla</h2>
                            <p>Cuéntale a Carla qué piensas de ella, qué admiras de su forma de ser o un recuerdo especial que atesoras.</p>
                        </div>

                        <form id="friend-dedication-form" class="friend-dedication-form">
                            <div class="friends-input-group">
                                <label for="friend-author-input">Tu nombre o apodo cariñoso:</label>
                                <input type="text" id="friend-author-input" name="author_name" placeholder="Ej. Sofía, Carlos, Tu amiga del alma..." maxlength="60" required>
                            </div>

                            <div class="friends-input-group">
                                <label>Elige una flor para acompañar tu mensaje:</label>
                                <div class="flower-badge-selector" id="flower-badge-selector">
                                    <button type="button" class="flower-badge-chip is-selected" data-badge="🌸">🌸 Peonía</button>
                                    <button type="button" class="flower-badge-chip" data-badge="🌷">🌷 Tulipán</button>
                                    <button type="button" class="flower-badge-chip" data-badge="🌻">🌻 Girasol</button>
                                    <button type="button" class="flower-badge-chip" data-badge="💌">💌 Carta</button>
                                    <button type="button" class="flower-badge-chip" data-badge="✨">✨ Estrella</button>
                                    <button type="button" class="flower-badge-chip" data-badge="🦋">🦋 Mariposa</button>
                                </div>
                                <input type="hidden" id="selected-flower-badge" name="flower_badge" value="🌸">
                            </div>

                            <div class="friends-input-group">
                                <label for="friend-message-input">Tu dedicatoria o pensamiento sincero:</label>
                                <textarea id="friend-message-input" name="message" rows="4" placeholder="Escribe aquí con cariño todo lo que piensas de Carla Lorena..." maxlength="600" required></textarea>
                                <div class="textarea-counter">
                                    <small id="friend-char-count">0 / 600 caracteres</small>
                                </div>
                            </div>

                            <button type="submit" class="button button-primary friend-submit-btn" id="friend-submit-btn">
                                <span>Publicar dedicatoria en el jardín</span> <span>🌸</span>
                            </button>
                        </form>
                    </div>

                    <!-- Muro de dedicatorias publicadas -->
                    <div class="friends-wall-wrapper">
                        <div class="wall-header-bar">
                            <h3>Pétalos & Cartas de Amigos (<span id="dedications-count">{{ $friendDedications->count() }}</span>)</h3>
                            @auth
                            <span class="admin-badge-indicator" title="Estás navegando como Administrador: puedes eliminar dedicatorias">🛡️ Modo Admin Activo</span>
                            @endauth
                        </div>

                        <div class="friends-dedications-grid" id="friends-dedications-grid">
                            @forelse($friendDedications as $dedication)
                            <article class="friend-dedication-card" data-dedication-id="{{ $dedication->id }}">
                                <div class="card-flower-badge">{{ $dedication->flower_badge }}</div>
                                <div class="card-content-wrap">
                                    <div class="card-meta-top">
                                        <strong class="friend-author-name">{{ $dedication->author_name }}</strong>
                                        <time class="friend-card-date">{{ $dedication->created_at->diffForHumans() }}</time>
                                    </div>
                                    <p class="friend-card-message">«{{ $dedication->message }}»</p>
                                    
                                    @auth
                                    <div class="admin-card-actions">
                                        <button type="button" class="btn-delete-dedication" data-delete-id="{{ $dedication->id }}" title="Eliminar esta dedicatoria (Solo Administrador)">
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                    @endauth
                                </div>
                            </article>
                            @empty
                            <div class="friends-empty-wall" id="friends-empty-wall">
                                <span class="empty-wall-icon">🌸</span>
                                <h4>Aún no hay dedicatorias publicadas</h4>
                                <p>Sé la primera persona en escribirle a Carla lo que piensas de ella y dejar tu flor en este jardín.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
