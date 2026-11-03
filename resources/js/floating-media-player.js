// ═══════════════════════════════════════════════════════════════════════════
//  REPRODUCTOR FLOTANTE MULTIMEDIA · EL JARDÍN DE CARLA LORENA
//  Soporte: Archivos Locales (Audio/Video), YouTube, URLs en Línea y Streaming
//  Funcionalidad en Segundo Plano (Continuo durante toda la navegación SPA)
// ═══════════════════════════════════════════════════════════════════════════

const STORAGE_PLAYLIST_KEY = 'carla_fmp_playlist';
const STORAGE_VOLUME_KEY = 'carla_fmp_volume';
const STORAGE_LOOP_KEY = 'carla_fmp_loop';
const STORAGE_SHUFFLE_KEY = 'carla_fmp_shuffle';

export class FloatingMediaPlayer {
    constructor() {
        // Elementos principales
        this.widget = document.getElementById('floating-media-player');
        this.compactPill = document.getElementById('floating-player-compact-pill');
        this.dockMusicBtn = document.getElementById('music-toggle-btn');
        this.dragHandle = document.getElementById('fmp-drag-handle');

        // Visores
        this.viewport = document.getElementById('fmp-viewport');
        this.nativeVideo = document.getElementById('fmp-native-video');
        this.nativeAudio = document.getElementById('fmp-native-audio');
        this.youtubeWrapper = document.getElementById('fmp-youtube-wrapper');
        this.youtubeContainer = document.getElementById('fmp-youtube-player');
        this.audioArt = document.getElementById('fmp-audio-art');
        this.vinylDisc = document.getElementById('fmp-vinyl-disc');
        this.visualizerBars = this.audioArt ? this.audioArt.querySelector('.fmp-visualizer-bars') : null;
        this.badgeSource = document.getElementById('fmp-badge-source');

        // Títulos
        this.headerTitle = document.getElementById('fmp-now-playing-title');
        this.trackName = document.getElementById('fmp-track-name');
        this.trackAuthor = document.getElementById('fmp-track-author');

        // Progreso
        this.currentTimeEl = document.getElementById('fmp-current-time');
        this.durationTimeEl = document.getElementById('fmp-duration-time');
        this.seekBarWrap = document.getElementById('fmp-seek-bar-wrap');
        this.seekFill = document.getElementById('fmp-seek-fill');
        this.seekThumb = document.getElementById('fmp-seek-thumb');
        this.seekBuffered = document.getElementById('fmp-seek-buffered');

        // Botones de control
        this.btnPlayPause = document.getElementById('fmp-btn-play-pause');
        this.iconPlay = document.getElementById('fmp-icon-play');
        this.iconPause = document.getElementById('fmp-icon-pause');
        this.btnPrev = document.getElementById('fmp-btn-prev');
        this.btnNext = document.getElementById('fmp-btn-next');
        this.btnShuffle = document.getElementById('fmp-btn-shuffle');
        this.btnLoop = document.getElementById('fmp-btn-loop');
        this.loopBadge = document.getElementById('fmp-loop-badge');
        this.btnToggleVideo = document.getElementById('fmp-btn-toggle-video');
        this.btnMinimize = document.getElementById('fmp-btn-minimize');
        this.btnClose = document.getElementById('fmp-btn-close');

        // Volumen y velocidad
        this.volumeSlider = document.getElementById('fmp-volume-slider');
        this.btnMute = document.getElementById('fmp-btn-mute');
        this.volIcon = document.getElementById('fmp-vol-icon');
        this.btnSpeed = document.getElementById('fmp-btn-speed');

        // Pestañas
        this.tabBtns = document.querySelectorAll('.fmp-tab-btn');
        this.panelLocal = document.getElementById('fmp-panel-local');
        this.panelUrl = document.getElementById('fmp-panel-url');
        this.panelPlaylist = document.getElementById('fmp-panel-playlist');
        this.playlistCountBadge = document.getElementById('fmp-playlist-count');

        // Entradas
        this.dropzone = document.getElementById('fmp-dropzone');
        this.fileInput = document.getElementById('fmp-file-input');
        this.urlForm = document.getElementById('fmp-url-form');
        this.urlInput = document.getElementById('fmp-url-input');
        this.btnAddQueue = document.getElementById('fmp-btn-add-queue');
        this.playlistListEl = document.getElementById('fmp-playlist-list');
        this.btnClearPlaylist = document.getElementById('fmp-btn-clear-playlist');

        // Mini Píldora
        this.pillExpandBtn = document.getElementById('fmp-pill-expand-btn');
        this.pillClickExpand = document.getElementById('fmp-pill-click-expand');
        this.pillTitle = document.getElementById('fmp-pill-title');
        this.pillTime = document.getElementById('fmp-pill-time');
        this.pillPlayBtn = document.getElementById('fmp-pill-play-btn');
        this.pillIconPlay = document.getElementById('fmp-pill-icon-play');
        this.pillIconPause = document.getElementById('fmp-pill-icon-pause');
        this.pillCloseBtn = document.getElementById('fmp-pill-close-btn');

        // Estado interno
        this.playlist = [];
        this.currentIndex = -1;
        this.isPlaying = false;
        this.isMuted = false;
        this.volume = 0.8;
        this.loopMode = 'off'; // 'off' | 'all' | 'one'
        this.isShuffle = false;
        this.playbackRate = 1.0;
        this.speeds = [0.75, 1.0, 1.25, 1.5, 2.0];
        this.activeSourceType = 'none'; // 'audio' | 'video' | 'youtube'

        // YouTube API
        this.ytPlayer = null;
        this.ytTimer = null;
        this.isYtReady = false;

        this.init();
    }

    init() {
        if (!this.widget) return;

        // Cargar preferencias
        const savedVol = localStorage.getItem(STORAGE_VOLUME_KEY);
        if (savedVol !== null) {
            this.volume = parseFloat(savedVol);
            if (this.volumeSlider) this.volumeSlider.value = this.volume;
        }

        const savedLoop = localStorage.getItem(STORAGE_LOOP_KEY);
        if (savedLoop) {
            this.loopMode = savedLoop;
            this.updateLoopUI();
        }

        const savedShuffle = localStorage.getItem(STORAGE_SHUFFLE_KEY);
        if (savedShuffle) {
            this.isShuffle = savedShuffle === '1';
            if (this.btnShuffle) this.btnShuffle.classList.toggle('is-active', this.isShuffle);
        }

        this.loadSavedPlaylist();
        this.setupEventListeners();
        this.setupNativeMediaEvents();
        this.setupDragAndDrop();
        this.setupDraggableWindow();
        this.updatePlaylistUI();

        // Si el volumen inicial es 0
        if (this.volume === 0) {
            this.isMuted = true;
            if (this.volIcon) this.volIcon.textContent = '🔇';
        }
    }

    // ── GESTIÓN DE EVENTOS ─────────────────────────────────────────────────────
    setupEventListeners() {
        // Escuchar mensajes postMessage del reproductor de YouTube
        window.addEventListener('message', (e) => {
            if (this.activeSourceType !== 'youtube' || !e.data || typeof e.data !== 'string') return;
            try {
                const data = JSON.parse(e.data);
                if (data.event === 'infoDelivery' && data.info) {
                    if (typeof data.info.duration === 'number' && data.info.duration > 0) {
                        this.ytDuration = data.info.duration;
                    }
                    if (typeof data.info.currentTime === 'number') {
                        this.updateProgressUI(data.info.currentTime, this.ytDuration || 0);
                    }
                    if (data.info.playerState === 0) {
                        this.handleTrackEnded();
                    } else if (data.info.playerState === 1 && !this.isPlaying) {
                        this.setPlayingState(true);
                    } else if (data.info.playerState === 2 && this.isPlaying) {
                        this.setPlayingState(false);
                    }
                }
            } catch (_) {}
        });

        // Acciones del Header
        this.btnToggleVideo?.addEventListener('click', () => this.toggleVideoViewport());
        this.btnMinimize?.addEventListener('click', () => this.minimizeToPill());
        this.btnClose?.addEventListener('click', () => this.hideWindow(true));

        // Mini Píldora
        this.pillExpandBtn?.addEventListener('click', () => this.restoreFromPill());
        this.pillClickExpand?.addEventListener('click', () => this.restoreFromPill());
        this.pillPlayBtn?.addEventListener('click', () => this.togglePlayPause());
        this.pillCloseBtn?.addEventListener('click', () => {
            if (this.compactPill) this.compactPill.hidden = true;
        });

        // Controles de Reproducción
        this.btnPlayPause?.addEventListener('click', () => this.togglePlayPause());
        this.btnPrev?.addEventListener('click', () => this.playPrev());
        this.btnNext?.addEventListener('click', () => this.playNext());
        this.btnShuffle?.addEventListener('click', () => this.toggleShuffle());
        this.btnLoop?.addEventListener('click', () => this.toggleLoop());

        // Volumen y Mute
        this.volumeSlider?.addEventListener('input', (e) => {
            this.setVolume(parseFloat(e.target.value));
        });
        this.btnMute?.addEventListener('click', () => this.toggleMute());

        // Velocidad
        this.btnSpeed?.addEventListener('click', () => this.cyclePlaybackSpeed());

        // Scrubber / Seek Bar
        if (this.seekBarWrap) {
            let isSeeking = false;
            const onSeek = (e) => {
                const rect = this.seekBarWrap.getBoundingClientRect();
                const pos = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                this.seekToPercent(pos);
            };

            this.seekBarWrap.addEventListener('pointerdown', (e) => {
                isSeeking = true;
                onSeek(e);
                const onPointerMove = (ev) => { if (isSeeking) onSeek(ev); };
                const onPointerUp = () => {
                    isSeeking = false;
                    window.removeEventListener('pointermove', onPointerMove);
                    window.removeEventListener('pointerup', onPointerUp);
                };
                window.addEventListener('pointermove', onPointerMove);
                window.addEventListener('pointerup', onPointerUp);
            });
        }

        // Pestañas
        this.tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-fmp-tab');
                this.switchTab(targetTab);
            });
        });

        // Formulario URL
        this.urlForm?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleUrlSubmit(true);
        });

        this.btnAddQueue?.addEventListener('click', () => {
            this.handleUrlSubmit(false);
        });

        // Limpiar Playlist
        this.btnClearPlaylist?.addEventListener('click', async () => {
            if (await window.showConfirm({ title: '¿Vaciar playlist?', message: '¿Deseas vaciar la lista de reproducción?', confirmText: 'Sí, vaciar', type: 'danger' })) {
                this.clearPlaylist();
            }
        });

        // Cierre al presionar Escape cuando está abierto
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.widget && !this.widget.hidden) {
                this.hideWindow(true);
            }
        });
    }

    // ── EVENTOS DE MEDIA NATIVA ──────────────────────────────────────────────
    setupNativeMediaEvents() {
        const attach = (el) => {
            if (!el) return;
            el.addEventListener('timeupdate', () => {
                if (this.activeSourceType !== 'youtube') {
                    this.updateProgressUI(el.currentTime, el.duration);
                }
            });

            el.addEventListener('loadedmetadata', () => {
                if (this.activeSourceType !== 'youtube') {
                    this.updateProgressUI(el.currentTime, el.duration);
                }
            });

            el.addEventListener('ended', () => {
                this.handleTrackEnded();
            });

            el.addEventListener('play', () => {
                this.setPlayingState(true);
            });

            el.addEventListener('pause', () => {
                this.setPlayingState(false);
            });

            el.addEventListener('error', () => {
                console.warn('Error al reproducir pista nativa:', el.error);
                this.setPlayingState(false);
            });
        };

        attach(this.nativeAudio);
        attach(this.nativeVideo);
    }

    // ── DRAG & DROP DE ARCHIVOS LOCALES ───────────────────────────────────────
    setupDragAndDrop() {
        if (!this.dropzone || !this.fileInput) return;

        ['dragenter', 'dragover'].forEach(name => {
            this.dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.dropzone.classList.add('is-dragover');
            });
        });

        ['dragleave', 'drop'].forEach(name => {
            this.dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.dropzone.classList.remove('is-dragover');
            });
        });

        this.dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer?.files;
            if (files && files.length > 0) {
                this.handleLocalFiles(files);
            }
        });

        this.fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files && files.length > 0) {
                this.handleLocalFiles(files);
            }
        });
    }

    handleLocalFiles(fileList) {
        const newTracks = [];
        for (let i = 0; i < fileList.length; i++) {
            const file = fileList[i];
            const isVideo = file.type.startsWith('video/') || /\.(mp4|webm|ogv|mov)$/i.test(file.name);
            const objectUrl = URL.createObjectURL(file);
            const cleanTitle = file.name.replace(/\.[^/.]+$/, '').replace(/[_-]/g, ' ');

            newTracks.push({
                id: 'local_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
                title: cleanTitle,
                type: isVideo ? 'video' : 'audio',
                url: objectUrl,
                isBlob: true,
                originalName: file.name,
                sourceBadge: isVideo ? 'Video Local' : 'Audio Local'
            });
        }

        if (newTracks.length === 0) return;

        const startIndex = this.playlist.length;
        this.playlist.push(...newTracks);
        this.updatePlaylistUI();

        // Cambiar a pestaña lista
        this.switchTab('tab-playlist');

        // Si nada estaba sonando, reproducir la primera pista cargada
        if (!this.isPlaying || this.currentIndex === -1) {
            this.playTrackAtIndex(startIndex);
        }
    }

    // ── GESTIÓN DE ENLACES (YOUTUBE & WEB STREAMS) ───────────────────────────
    handleUrlSubmit(playImmediately = true) {
        if (!this.urlInput) return;
        const rawUrl = this.urlInput.value.trim();
        if (!rawUrl) return;

        const track = this.parseUrlTrack(rawUrl);
        if (!track) {
            window.showAlert({ title: 'Enlace inválido', message: 'Por favor introduce un enlace válido de YouTube o un archivo multimedia en línea (http/https).', type: 'warning' });
            return;
        }

        this.playlist.push(track);
        this.saveOnlinePlaylist();
        this.updatePlaylistUI();
        this.urlInput.value = '';

        if (playImmediately || this.currentIndex === -1) {
            this.playTrackAtIndex(this.playlist.length - 1);
        } else {
            this.switchTab('tab-playlist');
        }
    }

    parseUrlTrack(url) {
        // Detectar YouTube
        const ytId = this.extractYouTubeId(url);
        if (ytId) {
            return {
                id: 'yt_' + ytId + '_' + Date.now(),
                title: 'YouTube: ' + ytId,
                type: 'youtube',
                url: url,
                youtubeId: ytId,
                isBlob: false,
                sourceBadge: 'YouTube'
            };
        }

        // Enlace directo en línea
        const isVideo = /\.(mp4|webm|ogv|mov)(\?.*)?$/i.test(url);
        const fileName = url.split('/').pop().split('?')[0] || 'Pista en línea';
        const cleanTitle = decodeURIComponent(fileName).replace(/\.[^/.]+$/, '').replace(/[_-]/g, ' ');

        return {
            id: 'web_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
            title: cleanTitle || 'Pista en línea',
            type: isVideo ? 'video' : 'audio',
            url: url,
            isBlob: false,
            sourceBadge: isVideo ? 'Video Web' : 'Audio Web'
        };
    }

    extractYouTubeId(url) {
        try {
            const parsed = new URL(url);
            if (parsed.hostname.includes('youtube.com')) {
                if (parsed.searchParams.get('v')) {
                    return parsed.searchParams.get('v');
                }
                const parts = parsed.pathname.split('/');
                if (parts.includes('shorts') || parts.includes('embed')) {
                    return parts[parts.length - 1];
                }
            } else if (parsed.hostname === 'youtu.be') {
                return parsed.pathname.slice(1).split('?')[0];
            }
        } catch (_) {}
        const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|shorts\/))([A-Za-z0-9_-]{11})/);
        return match ? match[1] : null;
    }

    // ── REPRODUCCIÓN MULTIMEDIA ───────────────────────────────────────────────
    playTrackAtIndex(index) {
        if (index < 0 || index >= this.playlist.length) return;

        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }

        this.currentIndex = index;
        const track = this.playlist[index];
        this.activeSourceType = track.type;
        this.ytDuration = 0;

        // Silenciar sonido del clima si está activo para no saturar
        this.silenceWeatherAmbient();

        // Detener reproductores previos
        this.stopAllPlayback();

        // Actualizar UI de Título y Badges
        this.updateTrackInfoUI(track);

        // Desplegar visor correspondiente
        if (track.type === 'youtube') {
            this.showYouTubeView(track.youtubeId);
        } else if (track.type === 'video') {
            this.showNativeVideoView(track.url);
        } else {
            this.showAudioView(track.url);
        }

        this.updatePlaylistActiveItem();
        this.setPlayingState(true);
    }

    showAudioView(url) {
        if (this.nativeVideo) {
            this.nativeVideo.style.display = 'none';
            this.nativeVideo.src = '';
        }
        if (this.youtubeWrapper) this.youtubeWrapper.style.display = 'none';
        if (this.audioArt) this.audioArt.style.display = 'flex';
        if (this.vinylDisc) this.vinylDisc.classList.add('is-spinning');
        if (this.visualizerBars) this.visualizerBars.classList.add('is-active');

        if (this.nativeAudio) {
            this.nativeAudio.src = url;
            this.nativeAudio.volume = this.isMuted ? 0 : this.volume;
            this.nativeAudio.playbackRate = this.playbackRate;
            this.nativeAudio.play().catch(() => {});
        }
    }

    showNativeVideoView(url) {
        if (this.audioArt) this.audioArt.style.display = 'none';
        if (this.youtubeWrapper) this.youtubeWrapper.style.display = 'none';
        if (this.nativeAudio) {
            this.nativeAudio.pause();
            this.nativeAudio.src = '';
        }

        if (this.nativeVideo) {
            this.nativeVideo.style.display = 'block';
            this.nativeVideo.src = url;
            this.nativeVideo.volume = this.isMuted ? 0 : this.volume;
            this.nativeVideo.playbackRate = this.playbackRate;
            this.nativeVideo.play().catch(() => {});
        }
    }

    showYouTubeView(ytId) {
        if (this.audioArt) this.audioArt.style.display = 'none';
        if (this.nativeVideo) {
            this.nativeVideo.style.display = 'none';
            this.nativeVideo.src = '';
        }
        if (this.nativeAudio) {
            this.nativeAudio.pause();
            this.nativeAudio.src = '';
        }

        if (this.youtubeWrapper) this.youtubeWrapper.style.display = 'flex';
        this.loadYouTubeIframe(ytId);
    }

    loadYouTubeIframe(ytId) {
        if (!this.youtubeContainer) return;

        // Limpiar contenido anterior
        this.youtubeContainer.innerHTML = '';
        clearInterval(this.ytTimer);

        const iframe = document.createElement('iframe');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('height', '100%');
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('allowfullscreen', 'true');
        iframe.src = `https://www.youtube.com/embed/${ytId}?enablejsapi=1&autoplay=1&origin=${encodeURIComponent(window.location.origin)}`;

        this.youtubeContainer.appendChild(iframe);
        this.ytIframe = iframe;

        // Timer para sincronizar tiempo y duración de YouTube mediante postMessage
        this.ytTimer = setInterval(() => {
            if (this.activeSourceType !== 'youtube' || !this.ytIframe?.contentWindow) return;
            try {
                this.ytIframe.contentWindow.postMessage(JSON.stringify({ event: 'listening' }), '*');
            } catch (_) {}
        }, 800);
    }

    stopAllPlayback() {
        clearInterval(this.ytTimer);

        if (this.nativeAudio) {
            try {
                this.nativeAudio.pause();
                this.nativeAudio.currentTime = 0;
            } catch (_) {}
        }
        if (this.nativeVideo) {
            try {
                this.nativeVideo.pause();
                this.nativeVideo.currentTime = 0;
            } catch (_) {}
        }
        if (this.ytIframe?.contentWindow) {
            try {
                this.ytIframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'stopVideo', args: '' }), '*');
            } catch (_) {}
        }

        if (this.vinylDisc) this.vinylDisc.classList.remove('is-spinning');
        if (this.visualizerBars) this.visualizerBars.classList.remove('is-active');
    }

    togglePlayPause() {
        if (this.currentIndex === -1) {
            if (this.playlist.length > 0) {
                this.playTrackAtIndex(0);
            } else {
                this.open();
                this.switchTab('tab-local');
            }
            return;
        }

        if (this.isPlaying) {
            this.pause();
        } else {
            this.resume();
        }
    }

    resume() {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        this.silenceWeatherAmbient();

        if (this.activeSourceType === 'youtube') {
            this.ytIframe?.contentWindow?.postMessage(JSON.stringify({ event: 'command', func: 'playVideo', args: '' }), '*');
        } else if (this.activeSourceType === 'video') {
            this.nativeVideo?.play().catch(() => {});
        } else {
            this.nativeAudio?.play().catch(() => {});
        }

        if (this.vinylDisc) this.vinylDisc.classList.add('is-spinning');
        if (this.visualizerBars) this.visualizerBars.classList.add('is-active');
        this.setPlayingState(true);
    }

    pause() {
        if (this.activeSourceType === 'youtube') {
            this.ytIframe?.contentWindow?.postMessage(JSON.stringify({ event: 'command', func: 'pauseVideo', args: '' }), '*');
        } else if (this.activeSourceType === 'video') {
            this.nativeVideo?.pause();
        } else {
            this.nativeAudio?.pause();
        }

        if (this.vinylDisc) this.vinylDisc.classList.remove('is-spinning');
        if (this.visualizerBars) this.visualizerBars.classList.remove('is-active');
        this.setPlayingState(false);
    }

    playNext() {
        if (this.playlist.length === 0) return;

        if (this.isShuffle) {
            const nextIdx = Math.floor(Math.random() * this.playlist.length);
            this.playTrackAtIndex(nextIdx);
            return;
        }

        let nextIdx = this.currentIndex + 1;
        if (nextIdx >= this.playlist.length) {
            if (this.loopMode === 'all') {
                nextIdx = 0;
            } else {
                this.stopAllPlayback();
                this.setPlayingState(false);
                return;
            }
        }
        this.playTrackAtIndex(nextIdx);
    }

    playPrev() {
        if (this.playlist.length === 0) return;

        let prevIdx = this.currentIndex - 1;
        if (prevIdx < 0) {
            prevIdx = this.playlist.length - 1;
        }
        this.playTrackAtIndex(prevIdx);
    }

    handleTrackEnded() {
        if (this.loopMode === 'one') {
            this.playTrackAtIndex(this.currentIndex);
        } else {
            this.playNext();
        }
    }

    seekToPercent(percent) {
        if (this.activeSourceType === 'youtube') {
            const targetSec = (this.ytDuration && this.ytDuration > 0) ? percent * this.ytDuration : percent * 100;
            this.ytIframe?.contentWindow?.postMessage(JSON.stringify({
                event: 'command',
                func: 'seekTo',
                args: [targetSec, true]
            }), '*');
            return;
        }

        const el = this.activeSourceType === 'video' ? this.nativeVideo : this.nativeAudio;
        if (el && el.duration) {
            el.currentTime = percent * el.duration;
            this.updateProgressUI(el.currentTime, el.duration);
        }
    }

    setVolume(vol) {
        this.volume = Math.max(0, Math.min(1, vol));
        this.isMuted = this.volume === 0;

        localStorage.setItem(STORAGE_VOLUME_KEY, String(this.volume));

        if (this.nativeAudio) this.nativeAudio.volume = this.volume;
        if (this.nativeVideo) this.nativeVideo.volume = this.volume;
        if (this.ytIframe?.contentWindow) {
            this.ytIframe.contentWindow.postMessage(JSON.stringify({
                event: 'command',
                func: 'setVolume',
                args: [this.volume * 100]
            }), '*');
        }

        if (this.volIcon) {
            this.volIcon.textContent = this.isMuted ? '🔇' : (this.volume < 0.4 ? '🔉' : '🔊');
        }
    }

    toggleMute() {
        if (this.isMuted) {
            this.setVolume(this.volume === 0 ? 0.8 : this.volume);
            if (this.volumeSlider) this.volumeSlider.value = this.volume;
        } else {
            this.isMuted = true;
            if (this.nativeAudio) this.nativeAudio.volume = 0;
            if (this.nativeVideo) this.nativeVideo.volume = 0;
            if (this.ytIframe?.contentWindow) {
                this.ytIframe.contentWindow.postMessage(JSON.stringify({ event: 'command', func: 'mute', args: '' }), '*');
            }
            if (this.volIcon) this.volIcon.textContent = '🔇';
        }
    }

    cyclePlaybackSpeed() {
        const curIdx = this.speeds.indexOf(this.playbackRate);
        const nextIdx = (curIdx + 1) % this.speeds.length;
        this.playbackRate = this.speeds[nextIdx];

        if (this.nativeAudio) this.nativeAudio.playbackRate = this.playbackRate;
        if (this.nativeVideo) this.nativeVideo.playbackRate = this.playbackRate;
        if (this.btnSpeed) this.btnSpeed.textContent = this.playbackRate.toFixed(1) + 'x';
    }

    toggleShuffle() {
        this.isShuffle = !this.isShuffle;
        localStorage.setItem(STORAGE_SHUFFLE_KEY, this.isShuffle ? '1' : '0');
        if (this.btnShuffle) this.btnShuffle.classList.toggle('is-active', this.isShuffle);
    }

    toggleLoop() {
        if (this.loopMode === 'off') {
            this.loopMode = 'all';
        } else if (this.loopMode === 'all') {
            this.loopMode = 'one';
        } else {
            this.loopMode = 'off';
        }

        localStorage.setItem(STORAGE_LOOP_KEY, this.loopMode);
        this.updateLoopUI();
    }

    updateLoopUI() {
        if (!this.btnLoop) return;
        this.btnLoop.classList.toggle('is-active', this.loopMode !== 'off');
        if (this.loopBadge) {
            this.loopBadge.style.display = this.loopMode === 'one' ? 'inline' : 'none';
        }
        this.btnLoop.setAttribute('title', `Repetir: ${this.loopMode === 'off' ? 'Desactivado' : (this.loopMode === 'all' ? 'Toda la lista' : 'Pista actual')}`);
    }

    // ── GESTIÓN VISUAL Y UI ───────────────────────────────────────────────────
    updateTrackInfoUI(track) {
        if (this.headerTitle) this.headerTitle.textContent = track.title;
        if (this.trackName) {
            this.trackName.textContent = track.title;
            // Scroll marquee si el título es largo
            this.trackName.classList.toggle('is-marquee', track.title.length > 32);
        }
        if (this.trackAuthor) this.trackAuthor.textContent = track.sourceBadge || 'El Jardín de Carla';
        if (this.badgeSource) this.badgeSource.textContent = track.sourceBadge || 'En línea';

        // Mini Píldora
        if (this.pillTitle) this.pillTitle.textContent = track.title;
    }

    updateProgressUI(currentSec, totalSec) {
        const cur = isNaN(currentSec) ? 0 : currentSec;
        const dur = isNaN(totalSec) || totalSec === Infinity ? 0 : totalSec;

        const curFormatted = this.formatTime(cur);
        const durFormatted = this.formatTime(dur);

        if (this.currentTimeEl) this.currentTimeEl.textContent = curFormatted;
        if (this.durationTimeEl) this.durationTimeEl.textContent = durFormatted;
        if (this.pillTime) this.pillTime.textContent = `${curFormatted} / ${durFormatted}`;

        const pct = dur > 0 ? (cur / dur) * 100 : 0;
        if (this.seekFill) this.seekFill.style.width = pct + '%';
        if (this.seekThumb) this.seekThumb.style.left = pct + '%';
    }

    formatTime(seconds) {
        const s = Math.floor(seconds || 0);
        const mins = Math.floor(s / 60);
        const secs = s % 60;
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    setPlayingState(playing) {
        this.isPlaying = playing;

        // Botón principal
        if (this.iconPlay) this.iconPlay.style.display = playing ? 'none' : 'inline-block';
        if (this.iconPause) this.iconPause.style.display = playing ? 'inline-block' : 'none';

        // Botón de la píldora compacta
        if (this.pillIconPlay) this.pillIconPlay.style.display = playing ? 'none' : 'inline-block';
        if (this.pillIconPause) this.pillIconPause.style.display = playing ? 'inline-block' : 'none';

        // Animación de rotación del disco en la píldora
        const pillDisc = this.compactPill?.querySelector('.fmp-pill-disc');
        if (pillDisc) pillDisc.classList.toggle('is-playing', playing);

        // Notificación en el botón morado del dock
        if (this.dockMusicBtn) {
            this.dockMusicBtn.classList.toggle('is-playing', playing);
            this.dockMusicBtn.setAttribute('aria-pressed', String(playing));
        }

        // Evento global
        window.dispatchEvent(new CustomEvent('floating-media-state-change', {
            detail: { isPlaying: playing, track: this.playlist[this.currentIndex] || null }
        }));
    }

    toggleVideoViewport() {
        if (!this.viewport) return;
        this.viewport.classList.toggle('is-collapsed');
        const isCollapsed = this.viewport.classList.contains('is-collapsed');
        if (this.btnToggleVideo) {
            this.btnToggleVideo.style.opacity = isCollapsed ? '0.5' : '1';
            this.btnToggleVideo.setAttribute('title', isCollapsed ? 'Mostrar pantalla de video' : 'Ocultar pantalla de video (Solo audio)');
        }
    }

    switchTab(tabId) {
        this.tabBtns.forEach(btn => {
            btn.classList.toggle('is-active', btn.getAttribute('data-fmp-tab') === tabId);
        });

        if (this.panelLocal) {
            this.panelLocal.style.display = tabId === 'tab-local' ? 'flex' : 'none';
            this.panelLocal.style.flexDirection = 'column';
            this.panelLocal.style.width = '100%';
        }
        if (this.panelUrl) {
            this.panelUrl.style.display = tabId === 'tab-url' ? 'flex' : 'none';
            this.panelUrl.style.flexDirection = 'column';
            this.panelUrl.style.width = '100%';
        }
        if (this.panelPlaylist) {
            this.panelPlaylist.style.display = tabId === 'tab-playlist' ? 'flex' : 'none';
            this.panelPlaylist.style.flexDirection = 'column';
            this.panelPlaylist.style.width = '100%';
        }
    }

    // ── GESTIÓN DE LA LISTA DE REPRODUCCIÓN ────────────────────────────────────
    updatePlaylistUI() {
        if (this.playlistCountBadge) this.playlistCountBadge.textContent = String(this.playlist.length);
        if (!this.playlistListEl) return;

        if (this.playlist.length === 0) {
            this.playlistListEl.innerHTML = `<li class="fmp-playlist-empty">No hay pistas en la lista. Carga archivos locales o pega un enlace.</li>`;
            return;
        }

        let html = '';
        this.playlist.forEach((item, idx) => {
            const isCur = idx === this.currentIndex;
            const icon = item.type === 'youtube' ? '🎬' : (item.type === 'video' ? '🎥' : '🎵');
            html += `
                <li class="fmp-playlist-item ${isCur ? 'is-current' : ''}" data-idx="${idx}">
                    <div class="fmp-pl-left">
                        <span class="fmp-pl-icon">${icon}</span>
                        <div class="fmp-pl-info">
                            <span class="fmp-pl-name">${this.escapeHtml(item.title)}</span>
                            <span class="fmp-pl-type">${item.sourceBadge}</span>
                        </div>
                    </div>
                    <button type="button" class="fmp-pl-del" data-del-idx="${idx}" title="Eliminar de la lista">✕</button>
                </li>
            `;
        });

        this.playlistListEl.innerHTML = html;

        // Listeners para hacer clic en las pistas
        this.playlistListEl.querySelectorAll('.fmp-playlist-item').forEach(el => {
            el.addEventListener('click', (e) => {
                if (e.target.closest('.fmp-pl-del')) return;
                const idx = parseInt(el.getAttribute('data-idx'), 10);
                this.playTrackAtIndex(idx);
            });
        });

        // Listeners para eliminar pistas
        this.playlistListEl.querySelectorAll('.fmp-pl-del').forEach(delBtn => {
            delBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const idx = parseInt(delBtn.getAttribute('data-del-idx'), 10);
                this.removeTrackAtIndex(idx);
            });
        });
    }

    updatePlaylistActiveItem() {
        if (!this.playlistListEl) return;
        const items = this.playlistListEl.querySelectorAll('.fmp-playlist-item');
        items.forEach((item, idx) => {
            item.classList.toggle('is-current', idx === this.currentIndex);
        });
    }

    removeTrackAtIndex(index) {
        if (index < 0 || index >= this.playlist.length) return;

        const wasCurrent = index === this.currentIndex;
        this.playlist.splice(index, 1);
        this.saveOnlinePlaylist();

        if (wasCurrent) {
            if (this.playlist.length > 0) {
                const nextIdx = Math.min(index, this.playlist.length - 1);
                this.playTrackAtIndex(nextIdx);
            } else {
                this.stopAllPlayback();
                this.currentIndex = -1;
                this.setPlayingState(false);
                if (this.headerTitle) this.headerTitle.textContent = 'Sin reproducción activa';
                if (this.trackName) this.trackName.textContent = 'Carga un archivo o pega un enlace';
            }
        } else if (index < this.currentIndex) {
            this.currentIndex--;
        }

        this.updatePlaylistUI();
    }

    clearPlaylist() {
        this.stopAllPlayback();
        this.playlist = [];
        this.currentIndex = -1;
        this.setPlayingState(false);
        this.saveOnlinePlaylist();
        this.updatePlaylistUI();
        if (this.headerTitle) this.headerTitle.textContent = 'Sin reproducción activa';
        if (this.trackName) this.trackName.textContent = 'Carga un archivo o pega un enlace';
    }

    saveOnlinePlaylist() {
        // Solo guardamos elementos persistentes (no blob URLs que caducan al recargar)
        const persistentTracks = this.playlist.filter(t => !t.isBlob);
        try {
            localStorage.setItem(STORAGE_PLAYLIST_KEY, JSON.stringify(persistentTracks));
        } catch (_) {}
    }

    loadSavedPlaylist() {
        try {
            const raw = localStorage.getItem(STORAGE_PLAYLIST_KEY);
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) {
                    this.playlist = parsed;
                }
            }
        } catch (_) {}
    }

    // ── CONTROL DE VENTANA (MINIMIZAR / EXPANDIR / ARRASTRAR) ─────────────────
    open() {
        if (this.compactPill) this.compactPill.hidden = true;
        if (this.widget) {
            this.widget.hidden = false;
            this.widget.style.transform = 'translate(0, 0) scale(1)';
            this.widget.style.opacity = '1';
        }
    }

    hideWindow(keepBackgroundPlayback = true) {
        if (this.widget) this.widget.hidden = true;
        // Si hay reproducción activa y se ocultó la ventana, mostramos la píldora compacta
        if (keepBackgroundPlayback && this.isPlaying && this.compactPill) {
            this.compactPill.hidden = false;
        }
    }

    minimizeToPill() {
        if (this.widget) this.widget.hidden = true;
        if (this.compactPill) this.compactPill.hidden = false;
    }

    restoreFromPill() {
        if (this.compactPill) this.compactPill.hidden = true;
        this.open();
    }

    toggleOpen() {
        if (!this.widget) return;
        if (this.widget.hidden) {
            this.open();
        } else {
            this.minimizeToPill();
        }
    }

    setupDraggableWindow() {
        if (!this.dragHandle || !this.widget) return;

        let isDragging = false;
        let startX = 0, startY = 0;
        let origX = 0, origY = 0;

        this.dragHandle.addEventListener('pointerdown', (e) => {
            if (e.target.closest('.fmp-header-actions')) return;
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;

            const rect = this.widget.getBoundingClientRect();
            origX = rect.left;
            origY = rect.top;

            this.widget.style.right = 'auto';
            this.widget.style.bottom = 'auto';
            this.widget.style.left = origX + 'px';
            this.widget.style.top = origY + 'px';

            const onPointerMove = (ev) => {
                if (!isDragging) return;
                const dx = ev.clientX - startX;
                const dy = ev.clientY - startY;

                const maxX = window.innerWidth - this.widget.offsetWidth - 10;
                const maxY = window.innerHeight - this.widget.offsetHeight - 10;

                const newX = Math.max(10, Math.min(maxX, origX + dx));
                const newY = Math.max(10, Math.min(maxY, origY + dy));

                this.widget.style.left = newX + 'px';
                this.widget.style.top = newY + 'px';
            };

            const onPointerUp = () => {
                isDragging = false;
                window.removeEventListener('pointermove', onPointerMove);
                window.removeEventListener('pointerup', onPointerUp);
            };

            window.addEventListener('pointermove', onPointerMove);
            window.addEventListener('pointerup', onPointerUp);
        });
    }

    // ── SILENCIADOR DE CLIMA AUTOMÁTICO (REQUISITO 2) ──────────────────────────
    silenceWeatherAmbient() {
        window.dispatchEvent(new CustomEvent('floating-player-play'));
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }
}

// Inicialización global
let globalFloatingMediaPlayer = null;

export function initFloatingMediaPlayer() {
    if (!globalFloatingMediaPlayer) {
        globalFloatingMediaPlayer = new FloatingMediaPlayer();
        window.FloatingMediaPlayer = globalFloatingMediaPlayer;
    }
    return globalFloatingMediaPlayer;
}
