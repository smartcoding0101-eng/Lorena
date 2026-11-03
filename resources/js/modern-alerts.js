/**
 * Sistema Universal de Alertas y Modales de Confirmación Modernos (Tailwind CSS)
 * Sustituye completamente los diálogos nativos del navegador ("localhost dice:")
 * por tarjetas modernas con glassmorphism, animaciones y paleta Blossom Pop / Rosa Aurora.
 */

// Contenedor persistente de alertas flotantes (Toasts)
function getAlertContainer() {
    let container = document.getElementById('tailwind-alert-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'tailwind-alert-container';
        container.className = 'fixed top-5 right-5 z-[999999] flex flex-col gap-3 pointer-events-none max-w-md w-[calc(100%-2.5rem)] sm:w-full';
        document.body.appendChild(container);
    }
    return container;
}

/**
 * Mostrar una tarjeta moderna de alerta / notificación (Toast)
 * @param {Object|string} options - Configuración o mensaje
 */
export function showAlert(options) {
    if (typeof options === 'string') {
        options = { message: options };
    }

    const {
        title = '',
        message = '',
        type = 'info', // 'success' | 'error' | 'warning' | 'info'
        duration = 4500
    } = options;

    const container = getAlertContainer();

    // Paletas y configuración por tipo
    const typeConfig = {
        success: {
            bg: 'bg-emerald-50/95 border-emerald-300/80 text-emerald-950 shadow-emerald-500/15',
            badgeBg: 'bg-emerald-500/15 text-emerald-600',
            progressBg: 'bg-gradient-to-r from-emerald-500 to-teal-400',
            icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
            defaultTitle: '¡Acción exitosa!'
        },
        error: {
            bg: 'bg-rose-50/95 border-rose-300/80 text-rose-950 shadow-rose-500/20',
            badgeBg: 'bg-rose-500/15 text-rose-600',
            progressBg: 'bg-gradient-to-r from-rose-500 to-red-500',
            icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
            defaultTitle: 'Atención / Error'
        },
        warning: {
            bg: 'bg-amber-50/95 border-amber-300/80 text-amber-950 shadow-amber-500/15',
            badgeBg: 'bg-amber-500/15 text-amber-600',
            progressBg: 'bg-gradient-to-r from-amber-500 to-yellow-400',
            icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            defaultTitle: 'Aviso'
        },
        info: {
            bg: 'bg-white/95 border-pink-200/90 text-stone-900 shadow-pink-500/15',
            badgeBg: 'bg-pink-500/15 text-pink-600',
            progressBg: 'bg-gradient-to-r from-pink-500 via-rose-400 to-orange-400',
            icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            defaultTitle: 'Mensaje del Jardín'
        }
    };

    const cfg = typeConfig[type] || typeConfig.info;
    const finalTitle = title || cfg.defaultTitle;

    // Elemento de la tarjeta de alerta
    const alertCard = document.createElement('div');
    alertCard.role = 'alert';
    alertCard.className = `pointer-events-auto relative overflow-hidden backdrop-blur-xl border rounded-2xl p-4 shadow-xl transition-all duration-300 transform translate-y-[-16px] opacity-0 scale-95 ${cfg.bg}`;

    alertCard.innerHTML = `
        <div class="flex items-start gap-3.5">
            <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center ${cfg.badgeBg} shadow-sm">
                ${cfg.icon}
            </div>
            <div class="flex-1 pt-0.5 pr-2">
                ${finalTitle ? `<h4 class="font-semibold text-sm leading-snug tracking-tight mb-0.5">${escapeHtml(finalTitle)}</h4>` : ''}
                <p class="text-xs sm:text-sm leading-relaxed opacity-90">${escapeHtml(message)}</p>
            </div>
            <button type="button" class="flex-shrink-0 -mr-1 -mt-1 p-1.5 rounded-lg opacity-60 hover:opacity-100 hover:bg-black/5 transition-all text-current" aria-label="Cerrar notificación">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        ${duration > 0 ? `
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/5 overflow-hidden">
                <div class="h-full w-full ${cfg.progressBg} transition-all duration-[${duration}ms] ease-linear alert-progress-bar"></div>
            </div>
        ` : ''}
    `;

    container.appendChild(alertCard);

    // Entrada fluida
    requestAnimationFrame(() => {
        alertCard.classList.remove('translate-y-[-16px]', 'opacity-0', 'scale-95');
        alertCard.classList.add('translate-y-0', 'opacity-100', 'scale-100');
    });

    let dismissTimer = null;

    const dismiss = () => {
        if (!alertCard.parentNode) return;
        alertCard.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
        alertCard.classList.add('translate-y-[-12px]', 'opacity-0', 'scale-95');
        setTimeout(() => {
            if (alertCard.parentNode) alertCard.remove();
        }, 320);
    };

    alertCard.querySelector('button')?.addEventListener('click', () => {
        if (dismissTimer) clearTimeout(dismissTimer);
        dismiss();
    });

    if (duration > 0) {
        // Iniciar barra de progreso
        const bar = alertCard.querySelector('.alert-progress-bar');
        if (bar) {
            bar.style.transition = `width ${duration}ms linear`;
            requestAnimationFrame(() => {
                bar.style.width = '0%';
            });
        }
        dismissTimer = setTimeout(dismiss, duration);
    }

    return dismiss;
}

/**
 * Mostrar un diálogo modal moderno de confirmación (Tailwind CSS)
 * Retorna una Promesa que resuelve a `true` (Confirmado) o `false` (Cancelado).
 * @param {Object|string} options 
 * @returns {Promise<boolean>}
 */
export function showConfirm(options) {
    if (typeof options === 'string') {
        options = { message: options };
    }

    const {
        title = '¿Confirmar acción?',
        message = '¿Estás seguro de que deseas continuar?',
        confirmText = 'Sí, confirmar',
        cancelText = 'Cancelar',
        type = 'danger' // 'danger' | 'warning' | 'primary'
    } = options;

    return new Promise((resolve) => {
        // Remover cualquier confirm previo activo
        document.querySelectorAll('.tailwind-confirm-backdrop').forEach(el => el.remove());

        const backdrop = document.createElement('div');
        backdrop.className = 'tailwind-confirm-backdrop fixed inset-0 z-[9999999] bg-stone-950/50 backdrop-blur-md flex items-center justify-center p-4 transition-opacity duration-200 opacity-0';

        const isDanger = type === 'danger';
        const isWarning = type === 'warning';

        const iconBg = isDanger 
            ? 'bg-gradient-to-br from-rose-500/20 to-red-500/30 text-rose-600 border border-rose-200/50' 
            : isWarning 
                ? 'bg-amber-500/20 text-amber-600 border border-amber-200/50'
                : 'bg-pink-500/20 text-pink-600 border border-pink-200/50';

        const confirmBtnClass = isDanger
            ? 'bg-gradient-to-r from-rose-500 via-pink-600 to-red-600 hover:from-rose-600 hover:to-red-700 shadow-lg shadow-rose-500/30 hover:shadow-rose-500/40'
            : isWarning
                ? 'bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 shadow-lg shadow-amber-500/30 hover:shadow-amber-500/40'
                : 'bg-gradient-to-r from-pink-500 via-rose-500 to-orange-400 hover:opacity-95 shadow-lg shadow-pink-500/30';

        const iconSvg = isDanger
            ? `<svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`
            : isWarning
                ? `<svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
                : `<svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;

        backdrop.innerHTML = `
            <div class="relative w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl p-6 sm:p-7 border border-rose-100 shadow-[0_25px_60px_-15px_rgba(224,36,130,0.28)] transform transition-all duration-300 scale-95 opacity-0 modal-box">
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center ${iconBg} mb-4 shadow-sm">
                        ${iconSvg}
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-rose-950 tracking-tight mb-2">
                        ${escapeHtml(title)}
                    </h3>
                    <p class="text-stone-600 text-sm leading-relaxed mb-6 font-sans max-w-sm">
                        ${escapeHtml(message)}
                    </p>
                </div>
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-rose-100/70">
                    <button type="button" class="btn-cancel px-5 py-2.5 rounded-full text-sm font-semibold text-stone-600 hover:text-stone-900 hover:bg-stone-100 active:scale-95 transition-all">
                        ${escapeHtml(cancelText)}
                    </button>
                    <button type="button" class="btn-confirm px-6 py-2.5 rounded-full text-sm font-semibold text-white ${confirmBtnClass} active:scale-95 transition-all">
                        ${escapeHtml(confirmText)}
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(backdrop);

        const modalBox = backdrop.querySelector('.modal-box');
        const btnCancel = backdrop.querySelector('.btn-cancel');
        const btnConfirm = backdrop.querySelector('.btn-confirm');

        // Animación de entrada
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            modalBox?.classList.remove('scale-95', 'opacity-0');
            modalBox?.classList.add('scale-100', 'opacity-100');
            btnConfirm?.focus();
        });

        const closeWithResult = (result) => {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            modalBox?.classList.remove('scale-100', 'opacity-100');
            modalBox?.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                backdrop.remove();
                resolve(result);
            }, 250);
        };

        btnConfirm?.addEventListener('click', () => closeWithResult(true));
        btnCancel?.addEventListener('click', () => closeWithResult(false));

        // Click en el fondo para cancelar
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) closeWithResult(false);
        });

        // Soporte de teclado (Escape cancela, Enter confirma)
        const keyHandler = (e) => {
            if (e.key === 'Escape') {
                e.preventDefault();
                document.removeEventListener('keydown', keyHandler);
                closeWithResult(false);
            }
        };
        document.addEventListener('keydown', keyHandler);
    });
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

/**
 * Inicialización global: Override de window.alert, interceptor de data-confirm y utilidades globales
 */
export function initModernAlerts() {
    // Exportar a window
    window.showAlert = showAlert;
    window.showToast = showAlert;
    window.showConfirm = showConfirm;

    // Sobrescribir window.alert nativo para que ningún script muestre "localhost dice:"
    const originalAlert = window.alert;
    window.alert = function (msg) {
        const str = String(msg ?? '');
        const isError = /error|fall|incorrect|denegad|no se pudo|revisa/i.test(str);
        const isSuccess = /éxito|guardad|publicad|completad|actualizad|cread/i.test(str);
        showAlert({
            title: isError ? 'Atención' : isSuccess ? '¡Listo!' : 'Mensaje del Jardín',
            message: str,
            type: isError ? 'error' : isSuccess ? 'success' : 'info',
            duration: 5000
        });
    };

    // Interceptar envíos de formularios con data-confirm
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('form[data-confirm]');
        if (form && !form.dataset.confirmed) {
            e.preventDefault();
            e.stopPropagation();

            const message = form.dataset.confirm;
            const isDanger = /eliminar|borrar|quitar|romper|destruir/i.test(message);

            const confirmed = await showConfirm({
                title: isDanger ? '¿Eliminar elemento?' : '¿Confirmar acción?',
                message: message,
                confirmText: isDanger ? 'Sí, continuar' : 'Confirmar',
                cancelText: 'Cancelar',
                type: isDanger ? 'danger' : 'primary'
            });

            if (confirmed) {
                form.dataset.confirmed = 'true';
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }
        }
    }, true);

    // Escuchar toasts iniciales de Laravel si vienen en el DOM
    document.addEventListener('DOMContentLoaded', () => {
        const legacyToast = document.querySelector('.toast[role="status"]');
        if (legacyToast && legacyToast.textContent.trim()) {
            showAlert({
                title: 'Notificación',
                message: legacyToast.textContent.trim(),
                type: 'success',
                duration: 5000
            });
            legacyToast.remove();
        }
    });
}

