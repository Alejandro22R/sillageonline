<?php

namespace App\Filament\Admin\Resources\Ventas\Pages;

use App\Filament\Admin\Resources\Ventas\VentaResource;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Collection;

class EditVenta extends EditRecord
{
    protected static string $resource = VentaResource::class;

    /**
     * Cantidad vendida por producto ANTES de guardar los cambios de esta
     * edición (product_id => cantidad total). Se usa para devolver al
     * stock lo que tenían las líneas originales, antes de descontar lo
     * que quede después de guardar.
     *
     * @var Collection<int, int>
     */
    protected Collection $cantidadesAntesDeEditar;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        // Se consulta directo a la base de datos (no el formulario) para
        // capturar los detalles tal como estaban antes de guardar, ya que
        // el repeater todavía no sincronizó los nuevos valores.
        $this->cantidadesAntesDeEditar = $this->record->detalles()
            ->get(['product_id', 'cantidad'])
            ->filter(fn ($detalle) => filled($detalle->product_id))
            ->groupBy('product_id')
            ->map(fn (Collection $items) => (int) $items->sum('cantidad'));
    }

    /**
     * Si el cliente cambia de perfume (o de cantidad) al editar una venta,
     * el perfume que se quita vuelve a aparecer en stock y el que ahora se
     * lleva se descuenta, sin tener que ajustarlo a mano. Como total_venta
     * ya se recalcula en el formulario, el saldo pendiente en Cuotas queda
     * correcto solo con sincronizar también estado_pago aquí.
     */
    protected function afterSave(): void
    {
        // Se toma del estado ya enviado por el formulario (no se vuelve a
        // consultar la base de datos aquí) para no depender de en qué
        // momento exacto Filament termina de sincronizar el repeater con
        // la tabla detalle_ventas.
        $detallesEnviados = collect($this->data['detalles'] ?? []);

        $cantidadesDespuesDeEditar = $detallesEnviados
            ->filter(fn (array $item) => filled($item['product_id'] ?? null))
            ->groupBy('product_id')
            ->map(fn (Collection $items) => (int) $items->sum('cantidad'));

        foreach ($this->cantidadesAntesDeEditar as $productId => $cantidad) {
            Product::whereKey($productId)->increment('stock', $cantidad);
        }

        foreach ($cantidadesDespuesDeEditar as $productId => $cantidad) {
            Product::whereKey($productId)->decrement('stock', $cantidad);
        }

        $this->record->sincronizarEstadoPago();
    }
}
