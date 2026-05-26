<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sillage Parfums — Acceso</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,600|figtree:300,400,500&display=swap" rel="stylesheet" />

        <style>
            /* Fondo de pantalla completo SIN SCROLL */
            body, html {
                background-color: #000000 !important;
                color: #ffffff !important;
                font-family: 'Figtree', sans-serif;
                margin: 0 !important;
                padding: 0 !important;
                height: 100vh !important;
                width: 100vw !important;
                overflow: hidden !important; /* 🚀 Bloquea por completo cualquier scroll scrollbar */
            }

            .main-container {
                background-color: #000000 !important;
                height: 100vh !important;
                width: 100% !important;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 1rem;
                box-sizing: border-box;
            }

            /* Tarjeta de Login */
            .tarjeta-sillage {
                background: linear-gradient(145deg, #0a0a0a, #121212) !important;
                border: 1px solid rgba(212, 175, 55, 0.25) !important;
                box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.9) !important;
                border-radius: 12px !important;
                width: 100%;
                max-width: 410px;
                padding: 2.2rem 2rem !important;
                box-sizing: border-box;
            }

            /* INPUTS PERFECTOS */
            .input-sillage {
                background-color: #1a1a1a !important;
                border: 1px solid #333333 !important;
                color: #ffffff !important;
                border-radius: 6px !important;
                padding: 0.75rem 1rem !important;
                width: 100% !important;
                box-sizing: border-box;
                font-size: 0.9rem !important;
                transition: all 0.3s ease !important;
            }

            .input-sillage:focus {
                border-color: #d4af37 !important;
                outline: none !important;
                box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
                background-color: #222222 !important;
            }

            /* ELIMINAR ELEMENTOS RESIDUALES Y LOS CANDADOS ROJOS */
            .relative.mt-1 svg,
            .absolute.inset-y-0,
            [class*="right-0"],
            form div relative div,
            form div div svg,
            form span svg,
            .text-red-500 {
                display: none !important;
            }

            /* BOTÓN GRADIENTE DORADO METÁLICO */
            .btn-sillage {
                background: linear-gradient(90deg, #b3923b 0%, #d4af37 50%, #f3e5ab 100%) !important;
                color: #000000 !important;
                border: none !important;
                border-radius: 6px !important;
                padding: 0.85rem !important;
                width: 100% !important;
                font-size: 0.85rem !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.15em !important;
                cursor: pointer;
                transition: all 0.4s ease-in-out !important;
                box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2) !important;
            }

            .btn-sillage:hover {
                background: #000000 !important;
                color: #d4af37 !important;
                box-shadow: 0 0 0 1px #d4af37 !important;
            }

            /* Estilos de tipografía */
            .brand-title {
                font-family: 'Playfair Display', serif;
                color: #d4af37;
                letter-spacing: 0.25em;
                font-size: 2.2rem;
                text-align: center;
                margin: 0 0 0.1rem 0 !important;
            }
        </style>
    </head>
    <body>
        <div class="main-container">

            <div style="text-align: center !important; margin-bottom: 1.5rem !important;">
                <h1 class="brand-title">SILLAGE</h1>
                <p style="color: #888888; font-size: 0.65rem; letter-spacing: 0.3em; text-transform: uppercase; text-align: center; margin: 0; padding: 0;">PARFUMS</p>
            </div>

            <div class="tarjeta-sillage">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
