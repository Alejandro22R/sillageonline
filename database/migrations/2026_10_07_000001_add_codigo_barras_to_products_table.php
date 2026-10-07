<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Código de barras por producto, para identificarlo al escanear
     * (cámara del teléfono por ahora, pistola lectora más adelante)
     * tanto en el módulo de Productos como al registrar Compras.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'codigo_barras')) {
                $table->string('codigo_barras')->nullable()->unique()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'codigo_barras')) {
                $table->dropColumn('codigo_barras');
            }
        });
    }
};
