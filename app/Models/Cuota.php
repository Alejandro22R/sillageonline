<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Un abono/pago registrado contra una Venta completa.
 *
 * El "número de cuota" se asigna solo (es el consecutivo del abono dentro
 * de esa venta: 1er abono, 2do abono...), y quién registró el pago queda
 * guardado en user_id para tener trazabilidad de cobros.
 */
class Cuota extends Model
{
    protected $fillable = [
        'venta_id',
        'user_id',
        'numero_cuota',
        'monto_cuota',
        'fecha_pago',
        'metodo_pago',
        'descripcion',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'monto_cuota' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Cuota $cuota) {
            if (empty($cuota->numero_cuota) && $cuota->venta_id) {
                $venta = Venta::find($cuota->venta_id);
                $cuota->numero_cuota = $venta ? $venta->cuotas()->count() + 1 : 1;
            }

            if (empty($cuota->user_id) && auth()->check()) {
                $cuota->user_id = auth()->id();
            }

            if (empty($cuota->fecha_pago)) {
                $cuota->fecha_pago = now();
            }
        });
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Usuario (vendedor) que registró este abono.
     */
    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
