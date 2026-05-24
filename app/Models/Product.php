<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'marca_perfume', // Se llenará desde el detalle
        'description',
        'wholesale_price',
        'retail_price',
        'stock',
        'image',
        'is_exclusive',
        'is_offer',
        'offer_price'
    ];

    /**
     * Relación con los detalles de compras.
     * Esto permite que el producto sepa qué se ha comprado de él.
     */
    public function detallesCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'product_id');
    }
}
