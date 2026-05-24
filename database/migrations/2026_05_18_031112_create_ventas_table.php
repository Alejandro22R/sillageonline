<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            // Quién compra
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            // Quién vende
            $table->foreignId('user_id')->constrained('users');

            $table->date('fecha_venta');
            $table->decimal('total_venta', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ventas');
    }
};
