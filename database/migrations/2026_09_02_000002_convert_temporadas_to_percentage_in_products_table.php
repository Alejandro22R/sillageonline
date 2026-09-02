<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Las estaciones dejan de ser un simple sí/no (boolean) para ser un
     * porcentaje de recomendación (0-100) por estación, mostrado como
     * barra en la ficha de producto.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['temporada_invierno', 'temporada_primavera', 'temporada_verano', 'temporada_otono'] as $campo) {
                if (Schema::hasColumn('products', $campo)) {
                    $table->dropColumn($campo);
                }
            }
        });

        Schema::table('products', function (Blueprint $table) {
            foreach ([
                'temporada_invierno_pct'  => 'uso_dia_pct',
                'temporada_primavera_pct' => 'temporada_invierno_pct',
                'temporada_verano_pct'    => 'temporada_primavera_pct',
                'temporada_otono_pct'     => 'temporada_verano_pct',
            ] as $campo => $after) {
                if (! Schema::hasColumn('products', $campo)) {
                    $table->unsignedTinyInteger($campo)->nullable()->after($after);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'temporada_invierno_pct',
                'temporada_primavera_pct',
                'temporada_verano_pct',
                'temporada_otono_pct',
            ]);
            $table->boolean('temporada_invierno')->default(false);
            $table->boolean('temporada_primavera')->default(false);
            $table->boolean('temporada_verano')->default(false);
            $table->boolean('temporada_otono')->default(false);
        });
    }
};
