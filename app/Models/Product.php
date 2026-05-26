<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // 1. Aquí solo van los nombres puros de las columnas transitables
    protected $fillable = [
        'name',
        'marca_perfume',
        'description',
        'wholesale_price',
        'retail_price',
        'metodo_pago', // <-- Ahora solo el nombre de la columna limpia
        'precio_divisa',
        'stock',
        'image',
        'is_exclusive',
        'is_offer',
        'offer_price'
    ];

    // 2. ESTA PROPIEDAD DEBE IR AFUERA. Esto es lo que le dice a Laravel que lo guarde como array/JSON
    protected $casts = [
        'metodo_pago' => 'array',
    ];

    /**
     * Relación con los detalles de compras.
     */
    public function detallesCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'product_id');
    }
}
