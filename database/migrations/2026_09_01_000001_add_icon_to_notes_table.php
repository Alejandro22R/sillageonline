<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permite asignarle un emoji a cada nota olfativa individual (Naranja,
     * Vainilla, Ámbar...), en vez de un solo ícono genérico por etapa de la
     * pirámide (Salida/Corazón/Fondo).
     */
    public function up(): void
    {
        if (! Schema::hasColumn('notes', 'icon')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->string('icon', 10)->nullable()->after('name');
            });
        }

        // Punto de partida: emoji por palabra clave para las notas más
        // comunes, solo donde todavía no tengan uno. Cualquiera se puede
        // ajustar después desde Catálogo > Notas Olfativas.
        $emojisPorPalabraClave = [
            'naranja' => '🍊', 'mandarina' => '🍊', 'pomelo' => '🍊', 'toronja' => '🍊', 'bergamota' => '🍋',
            'limón' => '🍋', 'limon' => '🍋', 'lima' => '🍋', 'cítric' => '🍋', 'citric' => '🍋',
            'manzana' => '🍎', 'pera' => '🍐', 'uva' => '🍇', 'fresa' => '🍓', 'cereza' => '🍒',
            'coco' => '🥥', 'afrutad' => '🍑', 'melocotón' => '🍑', 'melocoton' => '🍑', 'durazno' => '🍑', 'piña' => '🍍', 'pina' => '🍍',
            'vainilla' => '🤎', 'miel' => '🍯', 'caramelo' => '🍬', 'chocolate' => '🍫', 'cacao' => '🍫',
            'café' => '☕', 'cafe' => '☕', 'canela' => '🟤', 'especia' => '🌶️', 'pimienta' => '🌶️',
            'almizcle' => '✨', 'ámbar' => '🟠', 'ambar' => '🟠',
            'rosa' => '🌹', 'jazmín' => '🌸', 'jazmin' => '🌸', 'flor' => '🌸',
            'lavanda' => '💜', 'violeta' => '💜',
            'madera' => '🌳', 'sándalo' => '🌳', 'sandalo' => '🌳', 'cedro' => '🌳', 'roble' => '🌳',
            'cuero' => '🟤', 'tabaco' => '🍂', 'humo' => '💨', 'incienso' => '💨',
            'marino' => '🌊', 'marina' => '🌊', 'acuátic' => '🌊', 'acuatic' => '🌊',
            'verde' => '🌿', 'hierba' => '🌿', 'menta' => '🌿',
            'almendra' => '🌰', 'nuez' => '🌰',
        ];

        foreach ($emojisPorPalabraClave as $palabra => $emoji) {
            DB::table('notes')
                ->whereNull('icon')
                ->where('name', 'like', '%' . $palabra . '%')
                ->update(['icon' => $emoji]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('notes', 'icon')) {
            Schema::table('notes', function (Blueprint $table) {
                $table->dropColumn('icon');
            });
        }
    }
};
