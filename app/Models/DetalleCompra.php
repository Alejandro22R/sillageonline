<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compras';

    protected $fillable = [
        'compra_id',
        'nombre_perfume',
        'marca_perfume',
        'mililitros',
        'cantidad',
        'costo_unitario',
        'subtotal',
    ];

    protected static function booted()
    {
        static::saving(function (DetalleCompra $detalle) {
            $detalle->subtotal = $detalle->cantidad * $detalle->costo_unitario;
        });

        static::saved(function (DetalleCompra $detalle) {
            $detalle->compra->actualizarTotal();
        });

        static::deleted(function (DetalleCompra $detalle) {
            $detalle->compra->actualizarTotal();
        });
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }


}
