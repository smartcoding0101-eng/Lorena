        <section class="screen" data-screen="destinos" aria-labelledby="dreams-title" hidden>
            <div class="page-shell">
                <a class="back-link" href="#mapa" data-go="mapa">← Volver al mapa</a>
                <div class="page-heading">
                    <div>
                        <p class="eyebrow">Lugares por descubrir</p>
                        <h1 id="dreams-title">Mapa de <em>sueños</em></h1>
                        <p>Destinos de inspiración para llenar de planes el futuro. Cada rincón refleja un horizonte por recorrer juntos.</p>
                    </div>
                    @auth
                        @if(auth()->user()->is_admin || in_array(auth()->id(), [1, 2], true))
                            <a href="#admin" data-go="admin" class="button button-outline button-sm" style="margin-left: auto;">⚙️ Gestionar Destinos</a>
                        @endif
                    @endauth
                </div>

                <div class="destination-grid">
                    @forelse($destinations as $dest)
                        <article class="destination-card">
                            <img src="{{ $dest->image_url }}" alt="{{ $dest->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/mockups/propuesta_b_natural_light.png') }}';">
                            <div>
                                <span class="eyebrow">{{ $dest->location_tag }}</span>
                                <h2>{{ $dest->title }}</h2>
                                <p>{{ $dest->description }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="gallery-empty-state" style="grid-column: 1 / -1; text-align: center; padding: 3rem 1rem;">
                            <span class="note-flower" aria-hidden="true" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">✈️</span>
                            <p style="font-size: 1.1rem; color: #64748b;">Aún no has añadido destinos al mapa de sueños.</p>
                            @auth
                                <a href="#admin" data-go="admin" class="button button-primary button-sm" style="margin-top: 1rem;">+ Añadir Destino desde Panel de Control</a>
                            @endauth
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
