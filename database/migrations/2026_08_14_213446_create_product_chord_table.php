<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_chord', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chord_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('intensity')->default(50); // 1 a 100
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_chord');
    }
};