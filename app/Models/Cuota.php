<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuota extends Model
{
    protected $fillable = [
        'detalle_venta_id',
        'numero_cuota',
        'cuota_pagada',
        'monto_cuota',
        'fecha_pago',
        'metodo_pago',
        'estado',
        'descripcion',
    ];

    public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class, 'detalle_venta_id');
    }
}
