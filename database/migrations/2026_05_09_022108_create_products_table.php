<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del perfume (ej. Asad)
            $table->string('brand')->nullable(); // Marca (Lattafa, Afnan, etc.)
            $table->text('description')->nullable(); // Notas olfativas
            $table->decimal('wholesale_price', 8, 2)->nullable(); // Precio al mayor
            $table->decimal('retail_price', 8, 2); // Precio al detal o final
            $table->integer('stock')->default(0); // Cantidad en inventario
            $table->string('image')->nullable(); // Foto del producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
