<?php

namespace App\Filament\Admin\Resources\Ventas\Pages;

use App\Filament\Admin\Resources\Ventas\VentaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Product;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    /**
     * Se ejecuta automáticamente después de guardar la venta en la base de datos.
     */
    protected function afterCreate(): void
    {
        // Accedemos al registro de la venta recién creada
        $venta = $this->record;

        // Recorremos los detalles de la venta
        // Nota: Asegúrate de que en tu modelo Venta la relación se llame 'detalles'
        foreach ($venta->detalles as $detalle) {

            // Buscamos el producto en la tabla products
            $producto = Product::find($detalle->product_id);

            if ($producto) {
                // Restamos la cantidad vendida al stock actual
                $producto->decrement('stock', $detalle->cantidad);
            }
        }
    }
}
