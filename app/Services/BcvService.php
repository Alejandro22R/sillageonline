<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BcvService
{
    public static function getTasaUsd(): float
    {
        // 1. Intentamos conectar a internet
        try {
            $response = Http::withOptions(['verify' => false])
                ->timeout(5)
                ->get('https://pydolarvenezuela-api.vercel.app/api/v1/dolar?page=bcv');

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['monitors']['bcv']['price'])) {
                    // Si llega aquí, devolvemos el precio REAL de internet
                    return (float) $data['monitors']['bcv']['price'];
                }
            }
        } catch (\Exception $e) {
            // Si hay error, no hacemos nada aquí.
        }

        // 2. Si llegamos a esta línea, es porque la conexión falló.
        // Lanzamos una excepción que verás en el Dashboard.
        // ¡Ya no hay return 567.68! Si no hay internet, el sistema se detiene.
        throw new \Exception("NO HAY CONEXIÓN: Verifica tu internet o el bloqueo de red.");
    }
}
