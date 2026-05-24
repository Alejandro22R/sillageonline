<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{
    // Forzamos el nombre de la tabla en plural si es necesario
    protected $table = 'compras';

    protected $fillable = [
        'proveedor_id',
        'fecha_compra',
        'total_compra',
    ];

    /**
     * Relación con el Proveedor.
     * Una compra pertenece a un proveedor de tu tabla 'proveedors'.
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Relación con el Detalle.
     * Una compra tiene muchas líneas de perfumes guardadas en la tabla intermedia.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id');
    }

    /**
     * Método automático para calcular el Total General.
     * Suma los subtotales de la tabla intermedia y los guarda en la cabecera.
     */
    public function actualizarTotal(): void
    {
        // Suma la columna 'subtotal' de todos los detalles asociados a esta compra
        $this->total_compra = $this->detalles()->sum('subtotal');
        $this->save();
    }
}
