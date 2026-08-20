<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id',
        'user_id',
        'fecha_venta',
        'total_venta',
        'estado_pago',
    ];

    protected $casts = [
        'total_venta' => 'decimal:2',
    ];

    // Relación con el Cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con el Vendedor (User)
    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con los productos vendidos
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    }

    // Relación con los abonos/pagos registrados para esta venta
    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class);
    }

    /**
     * Filtra las ventas que pertenecen a un vendedor específico.
     */
    public function scopeDelVendedor($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getTotalPagadoAttribute(): float
    {
        // Si ya viene precargado con withSum('cuotas as total_pagado', ...)
        // se reutiliza ese valor en vez de lanzar otra consulta.
        if (array_key_exists('total_pagado', $this->attributes)) {
            return (float) $this->attributes['total_pagado'];
        }

        return (float) $this->cuotas()->sum('monto_cuota');
    }

    public function getSaldoPendienteAttribute(): float
    {
        return max(0, (float) $this->total_venta - $this->total_pagado);
    }

    public function getEstaPagadaAttribute(): bool
    {
        return $this->estado_pago === 'pagado';
    }
}
