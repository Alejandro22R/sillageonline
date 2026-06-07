<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BcvService
{
    public static function getTasaUsd(): float
    {
        // Nueva fuente: Tasa directa de otro monitor
        $url = 'https://api.exchangerate-api.com/v4/latest/USD';

        $response = Http::timeout(10)->get($url);

        if ($response->successful()) {
            $data = $response->json();
            // Nota: Aquí tendrías que ajustar el cálculo según la moneda que traiga
            // Pero esto es para probar si el VPS SÍ puede conectar a internet
            return (float) $data['rates']['VES'];
        }

        throw new \Exception("La conexión funcionó, pero la fuente de datos no respondió.");
    }
}
