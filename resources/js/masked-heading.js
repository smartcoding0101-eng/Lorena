import { gsap } from 'gsap';

const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

const SPOT_MASK = `radial-gradient(circle var(--mh-spot-r, 160px) at var(--mh-spot-x, 50%) var(--mh-spot-y, 50%), ${Array.from(
  { length: 9 },
  (_, i) => {
    const t = i / 8;
    const u = clamp((t - 0.1) / 0.9, 0, 1);
    return `rgba(0, 0, 0, ${(u * u * u * (u * (u * 6 - 15) + 10)).toFixed(3)}) ${(t * 100).toFixed(1)}%`;
  }
).join(', ')})`;

export class MaskedHeadingEngine {
  constructor(rootEl, options = {}) {
    if (!rootEl) return;
    this.root = rootEl;

    // Leer atributos data-* si existen para permitir configuración directa en HTML
    const ds = rootEl.dataset || {};

    this.settings = {
      text: options.text || ds.text || rootEl.getAttribute('data-text') || rootEl.textContent.trim(),
      mediaType: options.mediaType || ds.mediaType || 'video',
      src: options.src || ds.src || '/reel.mp4',
      poster: options.poster || ds.poster || '/reel-poster.jpg',
      fillScale: parseFloat(options.fillScale || ds.fillScale || 1.25),
      parallax: parseFloat(options.parallax || ds.parallax || 26),
      drift: parseFloat(options.drift || ds.drift || 18),
      hoverZoom: parseFloat(options.hoverZoom || ds.hoverZoom || 0),
      brightness: parseFloat(options.brightness || ds.brightness || 1),
      saturation: parseFloat(options.saturation || ds.saturation || 1),
      grayscale: options.grayscale ?? (ds.grayscale === 'true'),
      tint: options.tint || ds.tint || '',
      spotlight: options.spotlight ?? (ds.spotlight === 'true'),
      spotlightRadius: parseFloat(options.spotlightRadius || ds.spotlightRadius || 180),
      outline: options.outline ?? (ds.outline === 'true'),
      outlineColor: options.outlineColor || ds.outlineColor || '',
      outlineWidth: parseFloat(options.outlineWidth || ds.outlineWidth || 1),
      reveal: options.reveal || ds.reveal || 'scale',
      duration: parseFloat(options.duration || ds.duration || 1.1),
      stagger: parseFloat(options.stagger || ds.stagger || 0.09),
      trigger: options.trigger || ds.trigger || 'view',
      align: options.align || ds.align || 'left',
      weight: options.weight || ds.weight || 700,
      tracking: parseFloat(options.tracking || ds.tracking || -0.03),
      lineHeight: parseFloat(options.lineHeight || ds.lineHeight || 1.06),
      textScale: parseFloat(options.textScale || ds.textScale || 0.095),
    };

    this.offset = { x: 0, y: 0, tx: 0, ty: 0, zoom: 0, px: 0, py: 0, sx: 0, sy: 0, lit: false };
    this.paint = { transform: '', filter: '', spot: '' };
    this.raf = 0;
    this.alive = true;
    this.visible = true;
    this.hovering = false;
    this.lastTime = 0;
    this.clock = 0;
    this.tween = null;

    this.initDOM();
    this.bindEvents();
    this.sync();
    this.setupReveal();
  }

  initDOM() {
    this.root.classList.add('masked-heading');
    this.root.style.textAlign = this.settings.align;
    this.root.style.fontWeight = this.settings.weight;
    this.root.style.letterSpacing = `${this.settings.tracking}em`;
    this.root.style.lineHeight = this.settings.lineHeight;

    const clipId = `mh-${Math.random().toString(36).substring(2, 9)}`;
    this.clipId = clipId;

    // Extraer palabras respetando si existen etiquetas con clases especiales (ej. grand-script)
    let wordsData = [];
    const existingWords = this.root.querySelectorAll('.masked-heading__word');

    if (existingWords && existingWords.length > 0) {
      existingWords.forEach((wEl, idx) => {
        const text = wEl.firstChild ? wEl.firstChild.textContent.trim() : wEl.textContent.trim();
        const isScript = wEl.classList.contains('grand-script') || !!wEl.closest('.grand-script');
        wordsData.push({ text, isScript, el: wEl });
      });
    } else {
      const rawText = String(this.settings.text).replace(/\s+/g, ' ').trim();
      const splitted = rawText.split(' ').filter(Boolean);
      wordsData = splitted.map((word) => {
        // Detectar si la palabra forma parte de la segunda frase poética ("cuando la vives con el corazón...")
        const isScript = /cuando|vives|coraz[oó]n|sueño/i.test(word);
        return { text: word, isScript };
      });
    }

    this.words = wordsData;
    this.glyphs = [];
    wordsData.forEach((w, wIdx) => {
      Array.from(w.text).forEach((char) => {
        this.glyphs.push({ char, w: wIdx, isScript: w.isScript });
      });
    });

    // Construir estructura interna
    this.root.innerHTML = `
      <span class="masked-heading__measure">
        ${this.words.map((w, i) => `
          <span class="masked-heading__word ${w.isScript ? 'grand-script' : ''}">
            ${w.text}<i class="masked-heading__baseline"></i>
          </span>
        `).join('')}
      </span>

      <svg class="masked-heading__defs" aria-hidden="true" focusable="false">
        <defs>
          <clipPath id="${clipId}" clipPathUnits="userSpaceOnUse">
            ${this.glyphs.map((g) => `<text>${g.char}</text>`).join('')}
          </clipPath>
        </defs>
      </svg>

      <span class="masked-heading__reveal">
        <span class="masked-heading__clip" style="clip-path: url(#${clipId}); --mh-spot-r: ${Math.max(1, this.settings.spotlightRadius)}px;">
          <span class="masked-heading__media">
            ${this.settings.mediaType === 'video'
              ? `<video class="masked-heading__source" src="${this.settings.src}" poster="${this.settings.poster}" autoplay muted loop playsinline preload="auto">
                   <source src="${this.settings.src}" type="video/mp4">
                   <source src="${this.settings.src.replace(/\.mp4$/, '.webm')}" type="video/webm">
                   <source src="/videos/blooming-rose.webm" type="video/webm">
                 </video>`
              : `<img class="masked-heading__source" src="${this.settings.src || this.settings.poster}" alt="" draggable="false">`
            }
          </span>
          ${this.settings.tint ? `<span class="masked-heading__tint" style="background: ${this.settings.tint};"></span>` : ''}
          ${this.settings.spotlight ? `
            <span class="masked-heading__spot masked-heading__spot--tone" style="mask-image: ${SPOT_MASK}; -webkit-mask-image: ${SPOT_MASK};"></span>
            <span class="masked-heading__spot masked-heading__spot--shade" style="mask-image: ${SPOT_MASK}; -webkit-mask-image: ${SPOT_MASK};"></span>
          ` : ''}
        </span>
      </span>

      ${this.settings.outline ? `
        <svg class="masked-heading__outline" aria-hidden="true" focusable="false" style="stroke: ${this.settings.outlineColor || 'currentColor'}; stroke-width: ${Math.max(0, this.settings.outlineWidth)};">
          ${this.glyphs.map((g) => `<text>${g.char}</text>`).join('')}
        </svg>
      ` : ''}
    `;

    // Cachear referencias DOM
    this.measure = this.root.querySelector('.masked-heading__measure');
    this.reveal = this.root.querySelector('.masked-heading__reveal');
    this.clip = this.root.querySelector('.masked-heading__clip');
    this.media = this.root.querySelector('.masked-heading__media');
    this.source = this.root.querySelector('.masked-heading__source');

    this.wordEls = [...this.root.querySelectorAll('.masked-heading__word')];
    this.baseEls = [...this.root.querySelectorAll('.masked-heading__baseline')];
    this.glyphEls = [...this.root.querySelectorAll('.masked-heading__defs text')];
    this.lineEls = this.settings.outline ? [...this.root.querySelectorAll('.masked-heading__outline text')] : [];

    this.boxes = [];
    this.states = this.glyphs.map(() => ({ x: 0, y: 0, s: 1 }));

    // Fallback si el video genera error: usar poster
    if (this.source && this.source.tagName === 'VIDEO') {
      this.source.addEventListener('error', () => {
        if (this.media && this.settings.poster) {
          this.media.innerHTML = `<img class="masked-heading__source" src="${this.settings.poster}" alt="" draggable="false">`;
          this.source = this.media.querySelector('img');
        }
      });
    }
  }

  sync() {
    if (!this.root || !this.measure) return;

    // Calcular tamaño de fuente responsivo
    const s = this.settings;
    const computedFontSize = clamp(this.root.clientWidth * s.textScale, 26, 120);
    this.root.style.fontSize = `${computedFontSize.toFixed(1)}px`;

    const cs = window.getComputedStyle(this.measure);
    const fontPx = parseFloat(cs.fontSize) || 48;
    const rootRect = this.root.getBoundingClientRect();
    const ratio = this.root.offsetWidth ? (rootRect.width / this.root.offsetWidth) || 1 : 1;
    const range = document.createRange();
    const boxes = [];
    let index = 0;

    for (let w = 0; w < this.wordEls.length; w += 1) {
      const box = this.wordEls[w];
      const base = this.baseEls[w];
      const node = box?.firstChild;
      if (!box || !base || !node || node.nodeType !== 3) {
        index += Array.from(box?.textContent ?? '').length;
        continue;
      }

      const boxRect = box.getBoundingClientRect();
      const baseline = base.offsetTop;
      let offset = 0;

      for (const char of Array.from(node.data)) {
        range.setStart(node, offset);
        range.setEnd(node, offset + char.length);
        offset += char.length;

        const r = range.getBoundingClientRect();
        const x = box.offsetLeft + (r.left - boxRect.left) / ratio;
        const width = r.width / ratio;

        boxes[index] = {
          x,
          y: baseline,
          w: width,
          cx: x + width / 2,
          cy: baseline - fontPx * 0.36,
          lc: 0,
          boxEl: box,
        };
        index += 1;
      }
    }

    const lines = new Map();
    for (const box of boxes) {
      if (!box) continue;
      const line = lines.get(box.y) ?? { left: Infinity, right: -Infinity };
      line.left = Math.min(line.left, box.x);
      line.right = Math.max(line.right, box.x + box.w);
      lines.set(box.y, line);
    }

    for (const box of boxes) {
      if (!box) continue;
      const line = lines.get(box.y);
      if (line) box.lc = (line.left + line.right) / 2;
    }

    this.boxes = boxes;

    // Asignar atributos y tipografías al SVG
    for (let i = 0; i < boxes.length; i += 1) {
      const box = boxes[i];
      if (!box) continue;

      const wordCs = window.getComputedStyle(box.boxEl || this.measure);
      for (const el of [this.glyphEls[i], this.lineEls[i]]) {
        if (!el) continue;
        el.setAttribute('x', box.x.toFixed(2));
        el.setAttribute('y', `${box.y}`);
        el.style.fontFamily = wordCs.fontFamily;
        el.style.fontSize = wordCs.fontSize;
        el.style.fontWeight = wordCs.fontWeight;
        el.style.fontStyle = wordCs.fontStyle;
        el.style.letterSpacing = wordCs.letterSpacing;
      }
    }

    this.renderGlyphs();
    this.place();
  }

  renderGlyphs() {
    const boxes = this.boxes;
    const states = this.states;
    for (let i = 0; i < this.glyphEls.length; i += 1) {
      const glyph = this.glyphEls[i];
      if (!glyph) continue;
      const box = boxes[i];
      const st = states[i];
      if (!box || !st || (st.x === 0 && st.y === 0 && st.s === 1)) {
        if (glyph.hasAttribute('transform')) glyph.removeAttribute('transform');
        continue;
      }
      const s = Math.max(st.s, 0.0001);
      const tx = box.cx * (1 - s) + st.x * (box.cx - box.lc);
      const ty = box.cy * (1 - s) + st.y;
      glyph.setAttribute('transform', `translate(${tx.toFixed(2)} ${ty.toFixed(2)}) scale(${s.toFixed(4)})`);
    }
  }

  place() {
    if (!this.root || !this.media) return;
    const s = this.settings;
    const off = this.offset;
    const scale = s.fillScale * (1 + Math.max(0, off.zoom));
    const maxX = Math.max(0, ((scale - 1) / 2) * this.root.clientWidth);
    const maxY = Math.max(0, ((scale - 1) / 2) * this.root.clientHeight);

    const transform = `translate3d(${clamp(off.x, -maxX, maxX).toFixed(2)}px, ${clamp(off.y, -maxY, maxY).toFixed(2)}px, 0) scale(${scale.toFixed(4)})`;
    const filter = `brightness(${s.brightness}) saturate(${s.saturation})${s.grayscale ? ' grayscale(1)' : ''}`;

    if (this.paint.transform !== transform) {
      this.paint.transform = transform;
      this.media.style.transform = transform;
    }
    if (this.paint.filter !== filter) {
      this.paint.filter = filter;
      this.media.style.filter = filter;
    }

    if (this.clip && s.spotlight) {
      const spot = `${off.sx.toFixed(1)}px ${off.sy.toFixed(1)}px`;
      if (this.paint.spot !== spot) {
        this.paint.spot = spot;
        this.clip.style.setProperty('--mh-spot-x', `${off.sx.toFixed(1)}px`);
        this.clip.style.setProperty('--mh-spot-y', `${off.sy.toFixed(1)}px`);
      }
    }
  }

  bindEvents() {
    this.ro = new ResizeObserver(() => this.sync());
    this.ro.observe(this.root);

    if (document.fonts?.ready) {
      document.fonts.ready.then(() => this.alive && this.sync()).catch(() => {});
    }

    const motionQuery = window.matchMedia?.('(prefers-reduced-motion: reduce)');

    const frame = (now) => {
      this.raf = 0;
      const dt = this.lastTime ? Math.min(0.05, (now - this.lastTime) / 1000) : 0;
      this.lastTime = now;
      const s = this.settings;
      const off = this.offset;
      const still = !!motionQuery?.matches;

      if (still) {
        off.x = 0;
        off.y = 0;
        off.zoom = 0;
      } else {
        this.clock += dt;
        const dx = Math.sin(this.clock * 0.21) * s.drift;
        const dy = Math.cos(this.clock * 0.17) * s.drift * 0.6;
        const ease = 1 - Math.exp(-dt / 0.18);
        off.x += (off.tx + dx - off.x) * ease;
        off.y += (off.ty + dy - off.y) * ease;
        off.zoom += ((this.hovering ? s.hoverZoom : 0) - off.zoom) * (1 - Math.exp(-dt / 0.35));
      }

      if (s.spotlight) {
        const w = this.root.clientWidth;
        const h = this.root.clientHeight;
        let gx = w / 2;
        let gy = h / 2;
        if (this.hovering) {
          gx = off.px;
          gy = off.py;
        } else if (!still) {
          gx = w * (0.5 + 0.36 * Math.sin(this.clock * 0.37));
          gy = h * (0.5 + 0.22 * Math.sin(this.clock * 0.61 + 0.9));
        }

        if (!off.lit || still) {
          off.sx = gx;
          off.sy = gy;
          off.lit = true;
        } else {
          const follow = 1 - Math.exp(-dt / (this.hovering ? 0.12 : 0.6));
          off.sx += (gx - off.sx) * follow;
          off.sy += (gy - off.sy) * follow;
        }
      } else {
        off.lit = false;
      }

      this.place();
      if (this.visible && !still && this.alive) {
        this.raf = requestAnimationFrame(frame);
      }
    };

    const wake = () => {
      if (this.raf || !this.alive) return;
      this.lastTime = 0;
      this.raf = requestAnimationFrame(frame);
    };
    this.wake = wake;

    const onMove = (e) => {
      const s = this.settings;
      const r = this.root.getBoundingClientRect();
      const nx = ((e.clientX - r.left) / (r.width || 1)) * 2 - 1;
      const ny = ((e.clientY - r.top) / (r.height || 1)) * 2 - 1;
      this.offset.tx = clamp(nx, -1, 1) * -Math.max(0, s.parallax);
      this.offset.ty = clamp(ny, -1, 1) * -Math.max(0, s.parallax);
      this.offset.px = ((e.clientX - r.left) / (r.width || 1)) * this.root.clientWidth;
      this.offset.py = ((e.clientY - r.top) / (r.height || 1)) * this.root.clientHeight;
      if (s.spotlight) wake();
    };

    const onEnter = (e) => {
      this.hovering = e.pointerType !== 'touch';
      onMove(e);
      wake();
    };

    const onLeave = () => {
      this.hovering = false;
      this.offset.tx = 0;
      this.offset.ty = 0;
      wake();
    };

    this.io = new IntersectionObserver(([entry]) => {
      this.visible = entry.isIntersecting;
      if (this.visible) wake();
    });
    this.io.observe(this.root);

    this.root.addEventListener('pointermove', onMove);
    this.root.addEventListener('pointerenter', onEnter);
    this.root.addEventListener('pointerleave', onLeave);
    wake();

    // Reducir motion
    if (this.source && this.source.tagName === 'VIDEO' && motionQuery?.matches) {
      this.source.pause();
    }
  }

  setupReveal() {
    const layer = this.reveal;
    if (!this.root || !layer || !this.states.length) return;

    const s = this.settings;
    const em = () => parseFloat(window.getComputedStyle(this.root).fontSize) || 48;
    const wordDelay = (i) => (this.glyphs[i]?.w || 0) * s.stagger;
    const letterDelay = (i) => i * s.stagger * 0.35;

    const clearLayer = () => {
      gsap.set(layer, { opacity: 1, scale: 1 });
      layer.style.clipPath = '';
      layer.style.filter = '';
    };

    const settle = () => {
      this.states.forEach((st) => {
        st.x = 0;
        st.y = 0;
        st.s = 1;
      });
      this.renderGlyphs();
      clearLayer();
    };

    const rest = () => {
      const size = em();
      if (s.reveal === 'rise') {
        this.states.forEach((st) => {
          st.y = size * 1.15;
        });
      } else if (s.reveal === 'scale') {
        this.states.forEach((st) => {
          st.y = size * 0.1;
          st.s = 0;
        });
      } else if (s.reveal === 'blur') {
        this.states.forEach((st) => {
          st.x = 0.22;
        });
        gsap.set(layer, { opacity: 0 });
        layer.style.filter = `blur(${(size * 0.3).toFixed(2)}px)`;
      } else if (s.reveal === 'wipe') {
        layer.style.clipPath = 'inset(0% 100% 0% 0%)';
      } else if (s.reveal === 'fade') {
        gsap.set(layer, { opacity: 0, scale: 1.08 });
      }
      this.renderGlyphs();
    };

    const reduce = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches;
    if (s.reveal === 'none' || reduce) {
      settle();
      return;
    }

    const play = () => {
      this.tween?.kill();
      const size = em();

      if (s.reveal === 'rise') {
        clearLayer();
        this.tween = gsap.fromTo(
          this.states,
          { x: 0, y: size * 1.15, s: 1 },
          { y: 0, duration: s.duration, stagger: wordDelay, ease: 'power4.out', overwrite: 'auto', onUpdate: () => this.renderGlyphs() }
        );
        this.renderGlyphs();
      } else if (s.reveal === 'scale') {
        clearLayer();
        this.tween = gsap.fromTo(
          this.states,
          { x: 0, y: size * 0.1, s: 0 },
          { y: 0, s: 1, duration: s.duration, stagger: letterDelay, ease: 'expo.out', overwrite: 'auto', onUpdate: () => this.renderGlyphs() }
        );
        this.renderGlyphs();
      } else if (s.reveal === 'blur') {
        const focus = { blur: size * 0.3, opacity: 0 };
        gsap.set(layer, { scale: 1, opacity: 0 });
        layer.style.clipPath = '';
        layer.style.filter = `blur(${focus.blur.toFixed(2)}px)`;

        const timeline = gsap.timeline({ onUpdate: () => this.renderGlyphs() });
        timeline.fromTo(this.states, { x: 0.22, y: 0, s: 1 }, { x: 0, duration: s.duration * 1.2, ease: 'expo.out' }, 0);
        timeline.to(
          focus,
          {
            blur: 0,
            opacity: 1,
            duration: s.duration * 1.2,
            ease: 'power2.out',
            onUpdate: () => {
              layer.style.filter = focus.blur > 0.05 ? `blur(${focus.blur.toFixed(2)}px)` : '';
              layer.style.opacity = focus.opacity.toFixed(3);
            },
          },
          0
        );
        this.tween = timeline;
        this.renderGlyphs();
      } else if (s.reveal === 'wipe') {
        settle();
        layer.style.clipPath = 'inset(0% 100% 0% 0%)';
        const state = { p: 100 };
        this.tween = gsap.to(state, {
          p: 0,
          duration: s.duration,
          ease: 'power3.inOut',
          overwrite: 'auto',
          onUpdate: () => {
            layer.style.clipPath = `inset(0% ${state.p}% 0% 0%)`;
          },
        });
      } else {
        settle();
        this.tween = gsap.fromTo(
          layer,
          { opacity: 0, scale: 1.08 },
          { opacity: 1, scale: 1, duration: s.duration, ease: 'power3.out', overwrite: 'auto' }
        );
      }
    };

    this.play = play;

    if (s.trigger === 'hover') {
      settle();
      this.root.addEventListener('pointerenter', play);
    } else if (s.trigger === 'view') {
      settle();
      rest();
      const viewObserver = new IntersectionObserver(
        (entries) => {
          if (entries.some((e) => e.isIntersecting)) {
            play();
            viewObserver.disconnect();
          }
        },
        { threshold: 0.25 }
      );
      viewObserver.observe(this.root);
    } else {
      play();
    }
  }

  destroy() {
    this.alive = false;
    cancelAnimationFrame(this.raf);
    this.ro?.disconnect();
    this.io?.disconnect();
    this.tween?.kill();
  }
}

/**
 * Función de inicialización automática para el Hero principal y elementos con data-masked-heading.
 */
export function initMaskedHeading() {
  const elements = document.querySelectorAll('[data-masked-heading]');
  const instances = [];

  elements.forEach((el) => {
    if (el._maskedHeadingInstance) return;
    const inst = new MaskedHeadingEngine(el);
    el._maskedHeadingInstance = inst;
    instances.push(inst);
  });

  // Re-sincronizar cuando la pantalla de inicio (#inicio) vuelve a ser visible
  window.addEventListener('hashchange', () => {
    if (window.location.hash === '#inicio' || !window.location.hash) {
      setTimeout(() => {
        instances.forEach((inst) => {
          inst.sync();
          if (typeof inst.play === 'function') inst.play();
        });
      }, 150);
    }
  });

  return instances;
}

export default MaskedHeadingEngine;

