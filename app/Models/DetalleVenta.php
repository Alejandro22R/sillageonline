<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $fillable = [
        'venta_id',
        'product_id',
        'metodo_pago',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'metodo_pago' => 'array',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
