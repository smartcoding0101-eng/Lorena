        <section class="screen" data-screen="capsula" aria-labelledby="capsule-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Recuerdos sellados para el futuro</p>
                        <h1 id="capsule-title">Cápsula del <em>tiempo</em></h1>
                        <p>Cartas íntimas y recuerdos protegidos que solo se revelan al cumplirse su fecha y hora señalada.</p>
                    </div>
                    <span class="heading-mark" aria-hidden="true">⏳</span>
                </div>

                @auth
                    <div class="tc-container">
                        <!-- Barra de Acción y Creación -->
                        <div class="tc-top-bar">
                            <div class="tc-top-info">
                                <span class="tc-eyebrow">COFRE DE RECUERDOS FUTUROS</span>
                                <h2 class="tc-title">Cartas Selladas con Candado</h2>
                            </div>
                            <button type="button" id="tc-toggle-create-btn" class="ep-pill-btn">
                                <span>✉️</span> Escribir nueva carta sellada
                            </button>
                        </div>

                        <!-- Formulario para Sellar Nueva Carta -->
                        <div id="tc-create-drawer" class="tc-create-drawer" hidden>
                            <form id="tc-form" class="tc-form" enctype="multipart/form-data">
                                @csrf
                                <div class="tc-form-header">
                                    <span class="tc-form-icon">💌</span>
                                    <div>
                                        <h3>Sellar una Carta o Recuerdo</h3>
                                        <p>El mensaje permanecerá cifrado y en secreto hasta la fecha que elijas.</p>
                                    </div>
                                </div>
                                <div class="tc-form-grid">
                                    <div class="ep-field">
                                        <label>Título de la carta o recuerdo *</label>
                                        <input type="text" name="title" required placeholder="Ej. Para leer en nuestro aniversario..." maxlength="160">
                                    </div>
                                    <div class="ep-field">
                                        <label>¿Cuándo se abrirá el candado? *</label>
                                        <input type="datetime-local" name="unlock_at" required min="{{ now()->addMinute()->format('Y-m-d\TH:i') }}">
                                    </div>
                                    <div class="ep-field">
                                        <label>Motivo o Emoción</label>
                                        <select name="mood">
                                            <option value="love">💖 Amor Eterno</option>
                                            <option value="anniversary">💍 Aniversario Especial</option>
                                            <option value="birthday">🎂 Cumpleaños Mágico</option>
                                            <option value="future">🌟 Sueños para el Futuro</option>
                                            <option value="secret">🔒 Confesión Secreta</option>
                                        </select>
                                    </div>
                                    <div class="ep-field">
                                        <label>Firma / De parte de</label>
                                        <input type="text" name="author_name" value="{{ auth()->user()->name ?? 'Carla Lorena' }}" maxlength="100">
                                    </div>
                                    <div class="ep-field ep-field-full">
                                        <label>Mensaje secreto / Palabras del corazón *</label>
                                        <textarea name="message" rows="5" required placeholder="Escribe con total libertad todo lo que deseas que se descubra ese día especial..."></textarea>
                                    </div>
                                    <div class="ep-field ep-field-full">
                                        <label>Adjuntar fotografía de recuerdo (opcional)</label>
                                        <input type="file" name="image" accept="image/*">
                                    </div>
                                </div>
                                <div class="tc-form-actions">
                                    <button type="submit" class="button button-primary" id="tc-submit-btn">
                                        <span>🔒</span> Sellar en el cofre del tiempo
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Lista de Cápsulas con Cuentas Regresivas -->
                        <div id="tc-capsules-grid" class="tc-grid">
                            <!-- Inyectado por JS con tarjetas interactivas y timers en tiempo real -->
                        </div>
                    </div>
                @else
                    <div class="personal-panel">
                        <span class="personal-avatar" aria-hidden="true">⏳</span>
                        <div>
                            <span class="eyebrow">ACCESO PRIVADO</span>
                            <h2>Inicia sesión para entrar a tu cápsula</h2>
                            <p>Las cartas y recuerdos sellados solo están disponibles con una sesión autorizada.</p>
                            <a class="button button-primary" href="{{ route('login') }}">Entrar a mi espacio <span>↗</span></a>
                        </div>
                    </div>
                @endauth
            </div>
        </section>
