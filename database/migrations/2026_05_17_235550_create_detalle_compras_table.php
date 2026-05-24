<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');

            // Campos independientes para escribir los datos del perfume comprado
            $table->string('nombre_perfume');
            $table->string('marca_perfume');
            $table->string('mililitros'); // ej: "100 ml", "200 ml"

            $table->integer('cantidad');
            $table->decimal('costo_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('detalle_compras');
    }
};
