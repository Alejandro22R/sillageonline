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
}
