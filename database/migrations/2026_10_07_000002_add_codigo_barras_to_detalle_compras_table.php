<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Código de barras por línea de compra, para poder registrar la
     * compra escaneando los perfumes en vez de escribirlos a mano, y
     * detectar cuando el mismo código se escanea más de una vez (varias
     * unidades del mismo perfume).
     */
    public function up(): void
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            if (! Schema::hasColumn('detalle_compras', 'codigo_barras')) {
                $table->string('codigo_barras')->nullable()->after('compra_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            if (Schema::hasColumn('detalle_compras', 'codigo_barras')) {
                $table->dropColumn('codigo_barras');
            }
        });
    }
};
