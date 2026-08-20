<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * El formulario de Ventas ya capturaba el método de pago de cada línea
     * (CheckboxList "metodo_pago") pero la tabla nunca tuvo esa columna, así
     * que guardar una venta con método de pago seleccionado fallaba con un
     * error de SQL ("Unknown column"). Se agrega la columna que faltaba.
     *
     * Se verifica hasColumn() antes de crear/soltar por si en algún entorno
     * la columna ya se había agregado manualmente.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('detalle_ventas', 'metodo_pago')) {
            Schema::table('detalle_ventas', function (Blueprint $table) {
                $table->json('metodo_pago')->nullable()->after('subtotal');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('detalle_ventas', 'metodo_pago')) {
            Schema::table('detalle_ventas', function (Blueprint $table) {
                $table->dropColumn('metodo_pago');
            });
        }
    }
};
