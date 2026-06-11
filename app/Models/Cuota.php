<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuota extends Model
{
    protected $fillable = [
        'detalle_venta_id',
        'numero_cuota',
        'monto_cuota',
        'metodo_pago',
        'cuota_pagada',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
    ];

    // AGREGA ESTO:
    protected $casts = [
        'cuota_pagada' => 'array',
    ];

    public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class, 'detalle_venta_id');
    }
}
