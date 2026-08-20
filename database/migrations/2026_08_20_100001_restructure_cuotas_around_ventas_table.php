<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reestructura el módulo de Cuotas: los pagos (cuotas) pasan a registrarse
     * contra la VENTA completa (venta_id) en lugar de una sola línea de
     * producto (detalle_venta_id). Esto es lo que realmente pasa en el
     * negocio: un cliente abona a su compra, no a un perfume suelto de la
     * factura, y el campo del que dependía el módulo viejo para saber
     * "cuántas cuotas se acordaron" (detalle_ventas.numero_cuota) nunca
     * existió como columna real: siempre llegaba vacío.
     *
     * También se elimina el estado por-cuota ('pendiente'/'pagado'): ese
     * estado ahora vive a nivel de la venta completa (ventas.estado_pago),
     * que es donde tiene sentido preguntar "¿esta compra ya se terminó de
     * pagar?".
     *
     * Cada paso verifica hasColumn() antes de tocar el esquema, por si en
     * algún entorno ya se había aplicado parcialmente a mano.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('ventas', 'estado_pago')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->enum('estado_pago', ['pendiente', 'pagado'])
                    ->default('pendiente')
                    ->after('total_venta');
            });
        }

        if (! Schema::hasColumn('cuotas', 'venta_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->foreignId('venta_id')->nullable()->after('id')->constrained('ventas')->cascadeOnDelete();
            });
        }

        if (! Schema::hasColumn('cuotas', 'user_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('venta_id')->constrained('users')->nullOnDelete();
            });
        }

        // Backfill: recupera la venta a la que pertenecía cada cuota antigua
        // a través de la línea de producto (detalle_venta_id -> venta_id).
        if (Schema::hasColumn('cuotas', 'detalle_venta_id')) {
            DB::table('cuotas')
                ->join('detalle_ventas', 'cuotas.detalle_venta_id', '=', 'detalle_ventas.id')
                ->update(['cuotas.venta_id' => DB::raw('detalle_ventas.venta_id')]);
        }

        // Si una venta terminó de pagarse según los registros viejos, refleja
        // ese estado en la venta antes de descartar la columna 'estado'.
        if (Schema::hasColumn('cuotas', 'estado')) {
            $ventaIdsPagados = DB::table('cuotas')
                ->where('estado', 'pagado')
                ->whereNotNull('venta_id')
                ->distinct()
                ->pluck('venta_id');

            if ($ventaIdsPagados->isNotEmpty()) {
                DB::table('ventas')->whereIn('id', $ventaIdsPagados)->update(['estado_pago' => 'pagado']);
            }
        }

        if (Schema::hasColumn('cuotas', 'detalle_venta_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->dropForeign(['detalle_venta_id']);
            });

            Schema::table('cuotas', function (Blueprint $table) {
                $table->dropColumn('detalle_venta_id');
            });
        }

        $columnasViejasRestantes = array_filter(
            ['cuota_pagada', 'estado'],
            fn (string $columna) => Schema::hasColumn('cuotas', $columna)
        );

        if (! empty($columnasViejasRestantes)) {
            Schema::table('cuotas', function (Blueprint $table) use ($columnasViejasRestantes) {
                $table->dropColumn($columnasViejasRestantes);
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('cuotas', 'detalle_venta_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->foreignId('detalle_venta_id')->nullable()->after('id')->constrained('detalle_ventas')->cascadeOnDelete();
            });
        }

        if (! Schema::hasColumn('cuotas', 'cuota_pagada')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->integer('cuota_pagada')->nullable();
            });
        }

        if (! Schema::hasColumn('cuotas', 'estado')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente');
            });
        }

        if (Schema::hasColumn('cuotas', 'venta_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->dropForeign(['venta_id']);
            });
        }

        if (Schema::hasColumn('cuotas', 'user_id')) {
            Schema::table('cuotas', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        $columnasNuevas = array_filter(
            ['venta_id', 'user_id'],
            fn (string $columna) => Schema::hasColumn('cuotas', $columna)
        );

        if (! empty($columnasNuevas)) {
            Schema::table('cuotas', function (Blueprint $table) use ($columnasNuevas) {
                $table->dropColumn($columnasNuevas);
            });
        }

        if (Schema::hasColumn('ventas', 'estado_pago')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->dropColumn('estado_pago');
            });
        }
    }
};
