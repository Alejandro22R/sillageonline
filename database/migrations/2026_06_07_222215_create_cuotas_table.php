<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            // Relación con el padre
            $table->foreignId('detalle_venta_id')->constrained('detalle_ventas')->onDelete('cascade');

            $table->integer('numero_cuota');
            $table->decimal('monto_cuota', 10, 2);
            $table->string('metodo_pago')->nullable();
            $table->date('fecha_vencimiento');
            $table->date('fecha_pago')->nullable();

            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
