<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Campos para la sección "Perfil Olfativo" de la ficha de producto:
     * longevidad, estela, proporción de uso día/noche y estaciones en
     * las que se recomienda, similar a las fichas de Fragrantica.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'longevidad_horas')) {
                $table->unsignedTinyInteger('longevidad_horas')->nullable()->after('description');
            }
            if (! Schema::hasColumn('products', 'estela')) {
                $table->string('estela')->nullable()->after('longevidad_horas');
            }
            if (! Schema::hasColumn('products', 'uso_dia_pct')) {
                // 0 = solo de noche, 100 = solo de día, 50 = ambos por igual.
                $table->unsignedTinyInteger('uso_dia_pct')->nullable()->after('estela');
            }
            if (! Schema::hasColumn('products', 'temporada_invierno')) {
                $table->boolean('temporada_invierno')->default(false)->after('uso_dia_pct');
            }
            if (! Schema::hasColumn('products', 'temporada_primavera')) {
                $table->boolean('temporada_primavera')->default(false)->after('temporada_invierno');
            }
            if (! Schema::hasColumn('products', 'temporada_verano')) {
                $table->boolean('temporada_verano')->default(false)->after('temporada_primavera');
            }
            if (! Schema::hasColumn('products', 'temporada_otono')) {
                $table->boolean('temporada_otono')->default(false)->after('temporada_verano');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'longevidad_horas',
                'estela',
                'uso_dia_pct',
                'temporada_invierno',
                'temporada_primavera',
                'temporada_verano',
                'temporada_otono',
            ]);
        });
    }
};
