<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_exclusive')->default(false)->after('retail_price');
            $table->boolean('is_offer')->default(false)->after('is_exclusive');
            // Opcional: Si quieres poner un precio de oferta específico que tache el original
            $table->decimal('offer_price', 10, 2)->nullable()->after('is_offer');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_exclusive', 'is_offer', 'offer_price']);
        });
    }
};