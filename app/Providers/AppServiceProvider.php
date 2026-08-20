<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Añadimos esto
use App\Models\Cuota;
use App\Observers\CuotaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Detecta si estás accediendo desde un túnel seguro (Cloudflare) y fuerza HTTPS
        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }

        // Cada vez que se registra/borra un abono, recalcula si la venta
        // ya quedó pagada por completo.
        Cuota::observe(CuotaObserver::class);
    }
}