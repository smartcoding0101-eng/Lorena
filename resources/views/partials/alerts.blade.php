{{-- 
    Tarjetas Modernas de Alerta & Notificaciones (Tailwind CSS)
    Sustituye los avisos por defecto de Laravel ("localhost")
--}}

@if (session('status') || session('success') || session('error') || session('warning') || (isset($errors) && $errors->any()))
    <div id="laravel-session-alerts" class="fixed top-5 right-5 z-[999999] flex flex-col gap-3 max-w-md w-[calc(100%-2.5rem)] sm:w-full pointer-events-auto">
        {{-- Alerta de Éxito / Status --}}
        @if (session('status') || session('success'))
            @php
                $msg = session('status') ?? session('success');
            @endphp
            <div class="relative overflow-hidden backdrop-blur-xl bg-emerald-50/95 border border-emerald-300/80 rounded-2xl p-4 shadow-xl shadow-emerald-500/15 text-emerald-950 transition-all duration-300 animate-slide-in-down" role="alert">
                <div class="flex items-start gap-3.5">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-500/15 text-emerald-600 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1 pt-0.5 pr-2">
                        <h4 class="font-semibold text-sm leading-snug tracking-tight mb-0.5">¡Operación completada!</h4>
                        <p class="text-xs sm:text-sm leading-relaxed text-emerald-900/90">{{ $msg }}</p>
                    </div>
                    <button type="button" onclick="this.closest('[role=alert]').remove()" class="flex-shrink-0 -mr-1 -mt-1 p-1.5 rounded-lg opacity-60 hover:opacity-100 hover:bg-emerald-100/60 transition-all text-emerald-900" aria-label="Cerrar notificación">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-200/50 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 w-full animate-shrink-progress"></div>
                </div>
            </div>
        @endif

        {{-- Alerta de Error Flash --}}
        @if (session('error'))
            <div class="relative overflow-hidden backdrop-blur-xl bg-rose-50/95 border border-rose-300/80 rounded-2xl p-4 shadow-xl shadow-rose-500/20 text-rose-950 transition-all duration-300 animate-slide-in-down" role="alert">
                <div class="flex items-start gap-3.5">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center bg-rose-500/15 text-rose-600 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 pt-0.5 pr-2">
                        <h4 class="font-semibold text-sm leading-snug tracking-tight mb-0.5">Atención</h4>
                        <p class="text-xs sm:text-sm leading-relaxed text-rose-900/90">{{ session('error') }}</p>
                    </div>
                    <button type="button" onclick="this.closest('[role=alert]').remove()" class="flex-shrink-0 -mr-1 -mt-1 p-1.5 rounded-lg opacity-60 hover:opacity-100 hover:bg-rose-100/60 transition-all text-rose-900" aria-label="Cerrar notificación">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Errores de Validación de Formulario --}}
        @if (isset($errors) && $errors->any())
            <div class="relative overflow-hidden backdrop-blur-xl bg-white/95 border border-rose-300/90 rounded-2xl p-4 sm:p-5 shadow-2xl shadow-rose-500/20 text-rose-950 transition-all duration-300 animate-slide-in-down" role="alert">
                <div class="flex items-start gap-3.5">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center bg-rose-500/15 text-rose-600 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1 pr-2">
                        <h4 class="font-semibold text-sm leading-snug tracking-tight text-rose-900 mb-1">Por favor verifica los siguientes campos:</h4>
                        <ul class="text-xs text-rose-800/90 space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="this.closest('[role=alert]').remove()" class="flex-shrink-0 -mr-1 -mt-1 p-1.5 rounded-lg opacity-60 hover:opacity-100 hover:bg-rose-50 transition-all text-rose-900" aria-label="Cerrar notificación">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Auto-remover alertas después de 5 segundos si no fueron cerradas manualmente
        setTimeout(() => {
            const container = document.getElementById('laravel-session-alerts');
            if (container) {
                container.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                container.style.opacity = '0';
                container.style.transform = 'translateY(-10px)';
                setTimeout(() => container.remove(), 400);
            }
        }, 5500);
    </script>
@endif

