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
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->string('description'); // Ej: "Compra de 10 unidades de 9pm Afnan"
        $table->decimal('amount', 10, 2);
        $table->date('expense_date');
        $table->string('category')->default('Mercancía'); // Mercancía, Publicidad, Envío, Otros
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
