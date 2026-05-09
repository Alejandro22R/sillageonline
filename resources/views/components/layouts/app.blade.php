<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Sillage Parfums' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- Cambiamos el fondo a un negro muy oscuro y el texto base a gris claro -->
    <body class="antialiased bg-[#0a0a0a] text-gray-300">
        {{ $slot }}
    </body>
</html>