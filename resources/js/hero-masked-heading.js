import { gsap } from 'gsap';

export class HeroMaskedHeading {
  constructor(containerEl) {
    if (!containerEl) return;
    this.container = containerEl;
    this.content = containerEl.querySelector('.hero-title-content');
    this.canvas = containerEl.querySelector('.hero-masked-canvas');
    this.video = containerEl.querySelector('.hero-masked-video-source');
    this.words = containerEl.querySelectorAll('.hero-word');

    if (!this.canvas || !this.content) return;

    this.ctx = this.canvas.getContext('2d');
    if (!this.ctx) return;

    this.dpr = window.devicePixelRatio || 1;
    this.width = 0;
    this.height = 0;

    // Parallax y Drift
    this.parallax = 24;
    this.drift = 16;
    this.fillScale = 1.32;
    this.offX = 0;
    this.offY = 0;
    this.targetX = 0;
    this.targetY = 0;
    this.clock = 0;

    // Estado de animación de revelado de palabras con GSAP
    this.wordStates = [];
    this.initWordStates();

    this.isActiveScreen = true;
    this.isInViewport = true;
    this.rafId = null;

    this.init();
  }

  initWordStates() {
    this.words = this.container.querySelectorAll('.hero-word');
    this.wordStates = Array.from(this.words).map(() => ({
      alpha: 1,
      yOffset: 0,
      scale: 1,
    }));
  }

  init() {
    this.resize();

    // Iniciar video silenciado para permitir autoplay sin restricciones
    if (this.video) {
      this.video.muted = true;
      this.video.play().catch(() => {});
    }

    // Escucha de resize del contenedor para mantener sincronía pixel-perfect
    this.ro = new ResizeObserver(() => this.resize());
    this.ro.observe(this.container);

    if (document.fonts?.ready) {
      document.fonts.ready.then(() => {
        this.resize();
        this.render();
      }).catch(() => {});
    }

    // Mouse Parallax sobre la ventana
    this.handlePointerMove = (e) => {
      if (!this.isActiveScreen || !this.isInViewport) return;
      const rect = this.container.getBoundingClientRect();
      const nx = ((e.clientX - rect.left) / (rect.width || 1)) * 2 - 1;
      const ny = ((e.clientY - rect.top) / (rect.height || 1)) * 2 - 1;
      this.targetX = -Math.max(-1, Math.min(1, nx)) * this.parallax;
      this.targetY = -Math.max(-1, Math.min(1, ny)) * this.parallax;
    };
    window.addEventListener('pointermove', this.handlePointerMove, { passive: true });

    // IntersectionObserver: pausar renderizado cuando no esté visible
    this.io = new IntersectionObserver(([entry]) => {
      this.isInViewport = entry.isIntersecting;
      if (this.isInViewport && this.isActiveScreen) {
        this.resume();
      } else {
        this.pause();
      }
    });
    this.io.observe(this.container);

    // Navegación SPA por Hash
    this.handleHashChange = () => {
      const hash = window.location.hash || '#inicio';
      this.isActiveScreen = (hash === '#inicio');
      if (this.isActiveScreen && this.isInViewport) {
        this.resize();
        this.resume();
        this.triggerReveal();
      } else {
        this.pause();
      }
    };
    window.addEventListener('hashchange', this.handleHashChange);

    this.triggerReveal();
    this.resume();
  }

  triggerReveal() {
    if (!this.wordStates.length) this.initWordStates();

    // Animación escalonada elegante de cada palabra
    this.wordStates.forEach((st, idx) => {
      st.alpha = 0;
      st.yOffset = 18;
      st.scale = 0.92;

      gsap.killTweensOf(st);
      gsap.to(st, {
        alpha: 1,
        yOffset: 0,
        scale: 1,
        duration: 0.95,
        delay: idx * 0.055,
        ease: 'power3.out',
      });
    });
  }

  resize() {
    this.dpr = window.devicePixelRatio || 1;
    const rect = this.container.getBoundingClientRect();
    if (rect.width === 0 || rect.height === 0) return;

    this.width = Math.ceil(rect.width);
    this.height = Math.ceil(rect.height);

    this.canvas.width = Math.round(this.width * this.dpr);
    this.canvas.height = Math.round(this.height * this.dpr);
    this.canvas.style.width = `${this.width}px`;
    this.canvas.style.height = `${this.height}px`;

    this.ctx.resetTransform?.();
    this.ctx.scale(this.dpr, this.dpr);
  }

  render() {
    if (!this.isActiveScreen || !this.isInViewport) return;

    this.clock += 0.016;

    // Deriva suave (drift) y parallax amortiguado
    const driftX = Math.sin(this.clock * 0.22) * this.drift;
    const driftY = Math.cos(this.clock * 0.18) * (this.drift * 0.55);

    this.offX += (this.targetX + driftX - this.offX) * 0.08;
    this.offY += (this.targetY + driftY - this.offY) * 0.08;

    const ctx = this.ctx;
    const w = this.width;
    const h = this.height;

    ctx.clearRect(0, 0, w, h);

    if (w <= 0 || h <= 0) {
      this.rafId = requestAnimationFrame(() => this.render());
      return;
    }

    const baseRect = this.container.getBoundingClientRect();
    const words = this.container.querySelectorAll('.hero-word');

    // PASO 1: Dibujar cada palabra exactamente donde el navegador la posicionó
    ctx.save();
    ctx.fillStyle = '#ffffff';
    ctx.textBaseline = 'top';

    words.forEach((wordEl, i) => {
      const r = wordEl.getBoundingClientRect();
      if (r.width === 0 || r.height === 0) return;

      const cs = window.getComputedStyle(wordEl);
      ctx.font = `${cs.fontStyle} ${cs.fontWeight} ${cs.fontSize} ${cs.fontFamily}`;

      const wx = r.left - baseRect.left;
      const wy = r.top - baseRect.top;

      const st = this.wordStates[i] || { alpha: 1, yOffset: 0, scale: 1 };

      ctx.save();
      if (st.alpha < 1 || st.yOffset !== 0) {
        ctx.globalAlpha = Math.max(0, Math.min(1, st.alpha));
        ctx.translate(wx, wy + st.yOffset);
        if (st.scale !== 1) ctx.scale(st.scale, st.scale);
        ctx.fillText(wordEl.textContent.trim(), 0, 0);
      } else {
        ctx.fillText(wordEl.textContent.trim(), wx, wy);
      }
      ctx.restore();
    });

    ctx.restore();

    // PASO 2: Enmascaramiento Dual (Fondo Aurora Radiante + Proyección de Video)
    ctx.save();
    ctx.globalCompositeOperation = 'source-in';

    // 2.1 Gradiente Aurora Vibrante Base: Asegura 100% de legibilidad sin zonas oscuras
    const grad = ctx.createLinearGradient(0, 0, w, h);
    grad.addColorStop(0, '#be185d');    // Magenta carmín intenso
    grad.addColorStop(0.28, '#e02482'); // Rosa eléctrico vivo
    grad.addColorStop(0.55, '#ff4d94'); // Rosa orquídea floral
    grad.addColorStop(0.82, '#ff8a6b'); // Coral amanecer
    grad.addColorStop(1, '#8b5cf6');    // Aurora violeta
    ctx.fillStyle = grad;
    ctx.fillRect(0, 0, w, h);

    // 2.2 Proyección Cinemática del Video en modo 'screen'
    const vW = w * this.fillScale;
    const vH = h * this.fillScale;
    const vx = (w - vW) / 2 + this.offX;
    const vy = (h - vH) / 2 + this.offY;

    if (this.video && this.video.readyState >= 2) {
      ctx.save();
      ctx.globalCompositeOperation = 'screen';
      ctx.globalAlpha = 0.94;
      ctx.drawImage(this.video, vx, vy, vW, vH);
      ctx.restore();
    }

    ctx.restore();

    // Una vez renderizado el primer fotograma con éxito, ocultar el texto base del DOM
    if (!this.container.classList.contains('is-canvas-active')) {
      this.container.classList.add('is-canvas-active');
    }

    this.rafId = requestAnimationFrame(() => this.render());
  }

  resume() {
    if (this.rafId) return;
    if (this.video && this.video.paused) {
      this.video.play().catch(() => {});
    }
    this.rafId = requestAnimationFrame(() => this.render());
  }

  pause() {
    if (this.rafId) {
      cancelAnimationFrame(this.rafId);
      this.rafId = null;
    }
    if (this.video && !this.video.paused) {
      this.video.pause();
    }
  }

  destroy() {
    this.pause();
    this.ro?.disconnect();
    this.io?.disconnect();
    window.removeEventListener('pointermove', this.handlePointerMove);
    window.removeEventListener('hashchange', this.handleHashChange);
    this.container.classList.remove('is-canvas-active');
  }
}

export function initHeroMaskedHeading() {
  const container = document.querySelector('[data-hero-masked-heading]');
  if (!container || container._heroMaskedInstance) return null;

  if (window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches) {
    return null;
  }

  const instance = new HeroMaskedHeading(container);
  container._heroMaskedInstance = instance;
  return instance;
}

export default HeroMaskedHeading;
