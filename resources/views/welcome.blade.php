<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#faf7f1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer">
    <meta name="description" content="Un jardín digital para explorar historias, recuerdos y lugares especiales.">
    <link rel="manifest" href="/manifest.json">
    <title>El Jardín de Carla Lorena</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-theme="{{ auth()->check() ? (auth()->user()->preferences['theme'] ?? 'rose') : 'rose' }}">
    {{-- Splash Romántico de Bienvenida --}}
    @include('partials.splash')

    {{-- Navegación y Cabecera Principal --}}
    @include('partials.header')

    {{-- Canvas de Transición Cinemática de Pétalos --}}
    <canvas id="page-petal-transition-canvas" class="page-petal-transition-canvas" aria-hidden="true"></canvas>

    <main id="main">
        @include('screens.inicio')
        @include('screens.mapa')
        @include('screens.amigos')
        @include('screens.jardin')
        @include('screens.galeria')
        @include('screens.biblioteca')
        @include('screens.entretenimiento')
        @include('screens.capsula')
        @include('screens.destinos')
        @include('screens.blog')
        @include('screens.diario')
        @include('screens.juegos')
        @include('screens.aventura-sultana')
        @include('screens.jardines-liria')
        @include('screens.sultana-plataformas')
        @include('screens.conociendo-carla')
        @include('screens.tesoro')
        @include('screens.historias')
        @include('screens.preferencias')
        @include('screens.rompecabezas')
        @include('screens.bingo-amable')
        @include('screens.adivina-escena')
        @include('screens.dedicatoria')
        @include('screens.carla')
        @include('screens.albumes')
        @include('screens.favoritos')
        @include('screens.ajustes')
        @include('screens.admin')
    </main>

    {{-- Diálogos Modales, Efectos y Toasts --}}
    @include('partials.modals')
</body>
</html>
