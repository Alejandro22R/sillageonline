<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ApplyHolidayDiscount extends Command
{
    protected $signature = 'promo:holiday {percent? : Porcentaje de descuento (ej: 10)} {--revert : Quita la promoción}';

    protected $description = 'Aplica o revierte descuentos festivos masivos a los productos';

    public function handle()
    {
        // 1. Si pasas --revert, quita la oferta
        if ($this->option('revert')) {
            $this->info('Revirtiendo ofertas de festividad...');

            Product::query()->update([
                'is_offer' => 0,
                'offer_price' => null,
            ]);

            $this->info('✅ Todos los productos han vuelto a su precio normal.');
            return 0;
        }

        // 2. Validar porcentaje
        $percent = $this->argument('percent');

        if (!$percent || !is_numeric($percent) || $percent <= 0 || $percent >= 100) {
            $this->error('Debes indicar un porcentaje válido entre 1 y 99. Ejemplo: php artisan promo:holiday 10');
            return 1;
        }

        $this->info("Aplicando un {$percent}% de descuento a todos los productos...");

        // Factor de descuento (ej: 10% -> 0.90)
        $factor = 1 - ($percent / 100);

        // Actualizar directamente en la base de datos
        Product::query()->update([
            'is_offer' => 1,
            'offer_price' => DB::raw("ROUND(retail_price * {$factor}, 2)"),
        ]);

        $this->info("✅ Promoción aplicada: {$percent}% de descuento activo en todos los productos.");
        return 0;
    }
}

