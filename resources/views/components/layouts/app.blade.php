<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Sillage Parfums' }}</title>
        <meta name="description" content="Descubre fragancias de lujo en Sillage Parfums. Los mejores perfumes para hombre y mujer con envíos a todo el país.">
        
        <link rel="icon" type="image/png" href="{{ asset('img/sillage.png') }}">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[#0a0a0a] text-gray-300">
        {{ $slot }}
    </body>
</html>