<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BcvService
{
    public static function getTasaUsd(): float
    {
        // Forzamos conexión con encabezados de navegador para evitar bloqueos
        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])
            ->timeout(10)
            ->get('https://pydolarvenezuela-api.vercel.app/api/v1/dolar?page=bcv');

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['monitors']['bcv']['price'])) {
                return (float) $data['monitors']['bcv']['price'];
            }
        }

        // Si llega aquí, es porque la API falló o no conectó.
        // No hay return. El sistema lanzará el error por defecto.
        throw new \Exception("Error: La conexión al servidor de tasas fue rechazada o falló.");
    }
}
