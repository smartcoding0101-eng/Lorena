// ═══════════════════════════════════════════════════════════════════════
//  SISTEMA DE ENTRETENIMIENTO & REPRODUCTOR INTEGRADO DE PLAYLIST
//  Estilo Spotify / YouTube Music · Moderno, Juvenil & Romántico
// ═══════════════════════════════════════════════════════════════════════

let activeNativeAudio = null;
let activeVideoViewport = null;
let setPlayerPauseUI = null;

export function pauseEntertainmentMedia() {
    if (activeNativeAudio) {
        try { activeNativeAudio.pause(); } catch (_) {}
    }
    if (activeVideoViewport) {
        const videos = activeVideoViewport.querySelectorAll('video');
        videos.forEach(v => {
            try { v.pause(); } catch (_) {}
        });
        const iframes = activeVideoViewport.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            try {
                iframe.contentWindow?.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            } catch (_) {}
        });
    }
    if (typeof setPlayerPauseUI === 'function') {
        setPlayerPauseUI();
    }
}

export function initializeEntertainmentPlayer() {
    const container = document.getElementById('entertainment-player-section');
    if (!container) return;

    let playlist = [];
    try {
        const rawData = container.getAttribute('data-media-json');
        playlist = rawData ? JSON.parse(rawData) : [];
    } catch (e) {
        console.error('Error al parsear playlist:', e);
        playlist = [];
    }

    // Estado del reproductor
    let currentIndex = 0;
    let isPlaying = false;
    let isShuffle = false;
    let isRepeat = false;
    let currentFilter = 'all';

    // Elementos del DOM
    const videoViewport = document.getElementById('ep-video-viewport');
    const audioArt = document.getElementById('ep-audio-art');
    const currentTitle = document.getElementById('ep-current-title');
    const currentArtist = document.getElementById('ep-current-artist');
    const currentBadge = document.getElementById('ep-current-badge');
    const playPauseBtn = document.getElementById('ep-btn-play');
    const playIcon = document.getElementById('ep-play-icon');
    const prevBtn = document.getElementById('ep-btn-prev');
    const nextBtn = document.getElementById('ep-btn-next');
    const shuffleBtn = document.getElementById('ep-btn-shuffle');
    const repeatBtn = document.getElementById('ep-btn-repeat');
    const progressBar = document.getElementById('ep-progress-bar');
    const progressFill = document.getElementById('ep-progress-fill');
    const currentTimeEl = document.getElementById('ep-time-current');
    const totalTimeEl = document.getElementById('ep-time-total');
    const volumeSlider = document.getElementById('ep-volume-slider');
    const playlistContainer = document.getElementById('ep-playlist-items');
    const favoriteBtn = document.getElementById('ep-btn-fav');
    const filterButtons = document.querySelectorAll('[data-ep-filter]');
    const quickAddForm = document.getElementById('ep-quick-add-form');

    // Elementos del Mini Dock Global Flotante
    const globalDock = document.getElementById('ep-global-dock');
    const dockTitle = document.getElementById('ep-dock-title');
    const dockArtist = document.getElementById('ep-dock-artist');
    const dockThumbIcon = document.getElementById('ep-dock-thumb-icon');
    const dockPlayBtn = document.getElementById('ep-dock-btn-play');
    const dockPlayIcon = document.getElementById('ep-dock-play-icon');
    const dockPrevBtn = document.getElementById('ep-dock-btn-prev');
    const dockNextBtn = document.getElementById('ep-dock-btn-next');
    const dockProgressFill = document.getElementById('ep-dock-progress-fill');
    const dockCloseBtn = document.getElementById('ep-dock-close-btn');

    // Reproductor de audio HTML5
    const nativeAudio = new Audio();
    nativeAudio.preload = 'metadata';
    activeNativeAudio = nativeAudio;
    activeVideoViewport = videoViewport;
    setPlayerPauseUI = () => {
        isPlaying = false;
        updatePlayIcon();
        if (audioArt) audioArt.classList.remove('is-playing');
    };

    // Manejo de Favoritos en LocalStorage
    const FAV_KEY = 'carla_garden_media_favorites_v1';
    function getFavorites() {
        try {
            return JSON.parse(localStorage.getItem(FAV_KEY)) || [];
        } catch (_) {
            return [];
        }
    }
    function toggleFavorite(id) {
        let favs = getFavorites();
        if (favs.includes(id)) {
            favs = favs.filter(f => f !== id);
        } else {
            favs.push(id);
        }
        localStorage.setItem(FAV_KEY, JSON.stringify(favs));
        renderPlaylist();
        updateFavoriteButtonState();
    }
    function isFav(id) {
        return getFavorites().includes(id);
    }

    // ── Cargar Pista en el Reproductor ──
    function loadTrack(index, autoPlay = true) {
        if (playlist.length === 0 || index < 0 || index >= playlist.length) return;
        currentIndex = index;
        const track = playlist[index];

        // Actualizar textos del reproductor principal
        if (currentTitle) currentTitle.textContent = track.title || 'Sin título';
        if (currentArtist) {
            currentArtist.textContent = track.description || 'El Jardín de Carla Lorena';
        }
        if (currentBadge) {
            currentBadge.textContent = track.source_type === 'youtube'
                ? '🎬 YouTube'
                : (track.media_type === 'video' ? '🎬 Video' : '🎵 Canción');
            currentBadge.className = `ep-badge ${track.source_type}`;
        }

        // Actualizar mini dock global
        if (dockTitle) dockTitle.textContent = track.title || 'Sin título';
        if (dockArtist) dockArtist.textContent = track.description || 'El Jardín de Carla Lorena';
        if (dockThumbIcon) {
            dockThumbIcon.textContent = track.source_type === 'youtube' ? '🎬' : (track.media_type === 'video' ? '🎥' : '🌸');
        }
        checkDockVisibility();

        updateFavoriteButtonState();

        // Limpiar reproducción previa
        nativeAudio.pause();
        nativeAudio.src = '';
        videoViewport.innerHTML = '';

        if (track.source_type === 'youtube') {
            videoViewport.hidden = false;
            audioArt.hidden = true;

            const embedUrl = track.youtube_embed_url;
            const autoplayParam = autoPlay ? '?autoplay=1&enablejsapi=1' : '?enablejsapi=1';
            videoViewport.innerHTML = `
                <iframe src="${embedUrl}${autoplayParam}" 
                    title="${escapeHtml(track.title)}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            `;
            isPlaying = autoPlay;
            updatePlayIcon();
        } else if (track.media_type === 'video') {
            videoViewport.hidden = false;
            audioArt.hidden = true;

            const video = document.createElement('video');
            video.src = track.stream_url;
            video.controls = true;
            video.playsInline = true;
            video.autoplay = autoPlay;
            video.onended = onTrackEnded;
            video.ontimeupdate = () => updateProgress(video.currentTime, video.duration);
            videoViewport.appendChild(video);
            isPlaying = autoPlay;
            updatePlayIcon();
        } else {
            // Audio (MP3 externo o archivo subido)
            videoViewport.hidden = true;
            audioArt.hidden = false;

            const source = track.source_type === 'external_audio' ? track.source_url : track.stream_url;
            nativeAudio.src = source;
            if (autoPlay) {
                nativeAudio.play().then(() => {
                    isPlaying = true;
                    updatePlayIcon();
                }).catch(() => {
                    isPlaying = false;
                    updatePlayIcon();
                });
            } else {
                isPlaying = false;
                updatePlayIcon();
            }
        }

        highlightActivePlaylistItem();
    }

    // ── Actualización de Progreso ──
    function updateProgress(curr, dur) {
        if (isNaN(dur) || dur <= 0) return;
        const percent = (curr / dur) * 100;
        if (progressFill) progressFill.style.width = `${percent}%`;
        if (dockProgressFill) dockProgressFill.style.width = `${percent}%`;
        if (currentTimeEl) currentTimeEl.textContent = formatTime(curr);
        if (totalTimeEl) totalTimeEl.textContent = formatTime(dur);
    }

    nativeAudio.ontimeupdate = () => {
        updateProgress(nativeAudio.currentTime, nativeAudio.duration);
    };

    nativeAudio.onended = onTrackEnded;

    function onTrackEnded() {
        if (isRepeat) {
            loadTrack(currentIndex, true);
        } else {
            playNextTrack();
        }
    }

    function playNextTrack() {
        if (playlist.length === 0) return;
        let nextIndex;
        if (isShuffle) {
            nextIndex = Math.floor(Math.random() * playlist.length);
        } else {
            nextIndex = (currentIndex + 1) % playlist.length;
        }
        loadTrack(nextIndex, true);
    }

    function playPrevTrack() {
        if (playlist.length === 0) return;
        let prevIndex = (currentIndex - 1 + playlist.length) % playlist.length;
        loadTrack(prevIndex, true);
    }

    function togglePlayPause() {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        const track = playlist[currentIndex];
        if (!track) return;

        if (track.source_type === 'youtube') {
            // Recargar iframe si está pausado
            loadTrack(currentIndex, !isPlaying);
            return;
        }

        const video = videoViewport.querySelector('video');
        if (video) {
            if (video.paused) {
                video.play();
                isPlaying = true;
            } else {
                video.pause();
                isPlaying = false;
            }
        } else {
            if (nativeAudio.paused) {
                nativeAudio.play();
                isPlaying = true;
            } else {
                nativeAudio.pause();
                isPlaying = false;
            }
        }
        updatePlayIcon();
        audioArt.classList.toggle('is-playing', isPlaying);
    }

    function updatePlayIcon() {
        if (playIcon) {
            playIcon.textContent = isPlaying ? '⏸' : '▶';
        }
        if (playPauseBtn) {
            playPauseBtn.setAttribute('aria-label', isPlaying ? 'Pausar' : 'Reproducir');
        }
        if (dockPlayIcon) {
            dockPlayIcon.textContent = isPlaying ? '⏸' : '▶';
        }
        if (dockPlayBtn) {
            dockPlayBtn.setAttribute('aria-label', isPlaying ? 'Pausar' : 'Reproducir');
        }
        checkDockVisibility();
    }

    let isDockManuallyClosed = false;
    function checkDockVisibility() {
        if (!globalDock) return;
        const currentHash = (window.location.hash.slice(1) || 'inicio');
        // Mostrar dock si hay reproducción activa o pista cargada Y estamos fuera de #entretenimiento
        const isOutsideEntertainment = currentHash !== 'entretenimiento';
        const shouldShow = isOutsideEntertainment && isPlaying && !isDockManuallyClosed;
        globalDock.hidden = !shouldShow;
    }

    function updateFavoriteButtonState() {
        if (!favoriteBtn || playlist.length === 0) return;
        const track = playlist[currentIndex];
        const fav = isFav(track.id);
        favoriteBtn.textContent = fav ? '❤️' : '🤍';
        favoriteBtn.title = fav ? 'Quitar de favoritos' : 'Añadir a favoritos';
    }

    function highlightActivePlaylistItem() {
        document.querySelectorAll('.ep-item').forEach(item => {
            const idx = Number(item.getAttribute('data-index'));
            item.classList.toggle('is-active', idx === currentIndex);
        });
    }

    // ── Renderizado de Playlist con Filtros ──
    function renderPlaylist() {
        if (!playlistContainer) return;

        let filtered = playlist.map((item, idx) => ({ ...item, originalIndex: idx }));

        if (currentFilter === 'fav') {
            filtered = filtered.filter(item => isFav(item.id));
        } else if (currentFilter === 'music') {
            filtered = filtered.filter(item => item.media_type === 'audio');
        } else if (currentFilter === 'video') {
            filtered = filtered.filter(item => item.media_type === 'video');
        } else if (currentFilter === 'youtube') {
            filtered = filtered.filter(item => item.source_type === 'youtube');
        }

        if (filtered.length === 0) {
            playlistContainer.innerHTML = `
                <div class="ep-empty">
                    <span class="ep-empty-icon">🌸</span>
                    <p>No hay canciones o videos en este filtro.</p>
                </div>
            `;
            return;
        }

        playlistContainer.innerHTML = filtered.map(item => {
            const fav = isFav(item.id);
            const icon = item.source_type === 'youtube'
                ? '▶️'
                : (item.media_type === 'video' ? '🎬' : '🎵');
            return `
                <div class="ep-item ${item.originalIndex === currentIndex ? 'is-active' : ''}" data-index="${item.originalIndex}">
                    <div class="ep-item-play-icon">${icon}</div>
                    <div class="ep-item-info">
                        <strong class="ep-item-title">${escapeHtml(item.title)}</strong>
                        <span class="ep-item-desc">${escapeHtml(item.description || (item.source_type === 'youtube' ? 'YouTube' : 'Audio privado'))}</span>
                    </div>
                    <div class="ep-item-actions">
                        <button type="button" class="ep-item-fav-btn" data-toggle-fav="${item.id}" title="${fav ? 'Quitar de favoritos' : 'Marcar favorito'}">
                            ${fav ? '❤️' : '🤍'}
                        </button>
                        <form method="POST" action="/entertainment/${item.id}" onsubmit="return confirm('¿Quitar de la playlist?');" class="ep-item-del-form">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content') || ''}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="ep-item-del-btn" title="Quitar de mi playlist">🗑️</button>
                        </form>
                    </div>
                </div>
            `;
        }).join('');

        // Clic en fila para reproducir
        playlistContainer.querySelectorAll('.ep-item').forEach(el => {
            el.addEventListener('click', (e) => {
                if (e.target.closest('.ep-item-fav-btn') || e.target.closest('.ep-item-del-form')) return;
                const idx = Number(el.getAttribute('data-index'));
                loadTrack(idx, true);
            });
        });

        // Toggle fav
        playlistContainer.querySelectorAll('[data-toggle-fav]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = Number(btn.getAttribute('data-toggle-fav'));
                toggleFavorite(id);
            });
        });
    }

    // ── Conexión de Controles de Reproducción ──
    playPauseBtn?.addEventListener('click', togglePlayPause);
    nextBtn?.addEventListener('click', playNextTrack);
    prevBtn?.addEventListener('click', playPrevTrack);

    // ── Conexión de Controles del Mini Dock Global ──
    dockPlayBtn?.addEventListener('click', togglePlayPause);
    dockNextBtn?.addEventListener('click', playNextTrack);
    dockPrevBtn?.addEventListener('click', playPrevTrack);
    dockCloseBtn?.addEventListener('click', () => {
        isDockManuallyClosed = true;
        if (globalDock) globalDock.hidden = true;
    });

    // Escuchar navegación por hash para mostrar/ocultar el dock automáticamente
    window.addEventListener('hashchange', () => {
        checkDockVisibility();
    });
    window.addEventListener('popstate', () => {
        checkDockVisibility();
    });

    shuffleBtn?.addEventListener('click', () => {
        isShuffle = !isShuffle;
        shuffleBtn.classList.toggle('is-active', isShuffle);
        shuffleBtn.title = isShuffle ? 'Aleatorio activado' : 'Aleatorio desactivado';
    });

    repeatBtn?.addEventListener('click', () => {
        isRepeat = !isRepeat;
        repeatBtn.classList.toggle('is-active', isRepeat);
        repeatBtn.title = isRepeat ? 'Repetición activada' : 'Repetición desactivada';
    });

    favoriteBtn?.addEventListener('click', () => {
        if (playlist.length === 0) return;
        toggleFavorite(playlist[currentIndex].id);
    });

    progressBar?.addEventListener('click', (e) => {
        const rect = progressBar.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        const video = videoViewport.querySelector('video');
        if (video && video.duration) {
            video.currentTime = pos * video.duration;
        } else if (nativeAudio.duration) {
            nativeAudio.currentTime = pos * nativeAudio.duration;
        }
    });

    volumeSlider?.addEventListener('input', (e) => {
        const val = Number(e.target.value) / 100;
        nativeAudio.volume = val;
        const video = videoViewport.querySelector('video');
        if (video) video.volume = val;
    });

    // Filtros rápidos
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            currentFilter = btn.getAttribute('data-ep-filter');
            renderPlaylist();
        });
    });

    // ── Formulario Rápido de Enlaces ──
    const toggleAddFormBtn = document.getElementById('ep-toggle-add-btn');
    const addDrawer = document.getElementById('ep-add-drawer');
    if (toggleAddFormBtn && addDrawer) {
        toggleAddFormBtn.addEventListener('click', () => {
            addDrawer.hidden = !addDrawer.hidden;
        });
    }

    // ── Inicialización Inicial ──
    renderPlaylist();
    if (playlist.length > 0) {
        loadTrack(0, false);
    }

    // Helpers
    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
}
