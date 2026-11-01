<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fdf9f4">
    <title>Acceso privado · El Jardín de Carla</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <a class="skip-link" href="#login">Saltar al formulario</a>

    <!-- Pétalos flotantes decorativos -->
    <div class="login-petals-canvas" aria-hidden="true">
        <span class="lpetal p1">🌸</span>
        <span class="lpetal p2">🌹</span>
        <span class="lpetal p3">🌺</span>
        <span class="lpetal p4">🌸</span>
        <span class="lpetal p5">🌿</span>
        <span class="lpetal p6">🌼</span>
        <span class="lpetal p7">🌹</span>
        <span class="lpetal p8">✨</span>
    </div>

    <main id="login" class="login-card">

        <!-- Barra botánica superior -->
        <div class="login-card-topbar">
            <span class="login-topbar-emblem">❦ 🌹 ❦</span>
            <span class="login-topbar-label">JARDÍN PRIVADO · ACCESO SEGURO</span>
        </div>

        <a class="brand login-brand" href="{{ route('home') }}">
            <span class="brand-mark" aria-hidden="true">✳</span>
            <span><strong>El jardín</strong><small>de Carla</small></span>
        </a>

        <p class="eyebrow">UN RINCÓN SOLO TUYO</p>
        <h1>Qué bonito<br><em>verte de nuevo.</em></h1>

        <p class="login-intro">Inicia sesión para acceder a tus álbumes y recuerdos privados.</p>

        <!-- Quote romántico -->
        <div class="login-mini-quote">
            <span aria-hidden="true">❀</span>
            <em>«Este jardín siempre te espera con flores abiertas.»</em>
        </div>

        @if ($errors->any())
            <div class="form-errors" role="alert">
                <p>No se pudo iniciar sesión.</p>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form class="login-form" method="POST" action="{{ route('login.store') }}">
            @csrf
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" autocomplete="username" maxlength="255" value="{{ old('email') }}" required>
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            <button class="button button-primary" type="submit">Entrar a mi espacio <span aria-hidden="true">↗</span></button>
        </form>

        <!-- Firma del jardín -->
        <div class="login-card-footer-deco">
            <span class="login-lacre">❧</span>
            <small>Protegido con amor · El Jardín de Carla</small>
        </div>

        <a class="back-link" href="{{ route('home') }}">← Volver al jardín</a>
    </main>

    <div class="floating-dock-right" id="floating-dock-right" aria-label="Controles Flotantes del Jardín"></div>
</body>
</html>
