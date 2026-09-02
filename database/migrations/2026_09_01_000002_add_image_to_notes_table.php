<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * El emoji por nota (icon) no alcanza para representar todas las notas
     * posibles (pachulí, tabaco, madera seca... no tienen un emoji real que
     * les corresponda). Se agrega una imagen subida por el admin, que tiene
     * prioridad sobre el emoji al mostrarla en la ficha del producto.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('notes', 'image')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->string('image')->nullable()->after('icon');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('notes', 'image')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
