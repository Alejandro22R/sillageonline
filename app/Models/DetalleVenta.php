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
        'pago_cuota',
        'numero_cuota',
        'primera_cuota',
        'segunda_cuota',
        'tercera_cuota',
        'precio_unitario',
        'subtotal',


    ];

       protected $casts = [
        'metodo_pago' => 'array',
    ];
    // Relación con la venta principal
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    // Relación con el Perfume (Product)
    // De aquí sacaremos el nombre, la marca y el stock
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class, 'detalle_venta_id');
    }
}
