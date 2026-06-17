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
    Schema::create('cuotas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('detalle_venta_id')->constrained('detalle_ventas')->onDelete('cascade');
        $table->decimal('monto_cuota', 10, 2);
        $table->string('numero_cuota', 50);
        $table->integer('cuota_pagada');
        $table->date('fecha_pago');
        $table->string('metodo_pago')->nullable();
         $table->enum('estado', ['pendiente', 'pagada'])->default('pendiente');
        $table->string('descripcion')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
