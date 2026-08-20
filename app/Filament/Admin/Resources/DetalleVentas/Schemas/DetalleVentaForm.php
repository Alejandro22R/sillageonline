<?php

namespace App\Filament\Admin\Resources\DetalleVentas\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class DetalleVentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([

                // Relación con la Venta principal
                Select::make('venta_id')
                    ->relationship('venta', 'id')
                    ->required()
                    ->columnSpan(12),

                // Selección del perfume
                Select::make('product_id')
                    ->label('Nombre del Perfume')
                    ->options(Product::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        self::calcularPreciosItem($set, $get, $state);
                    })
                    ->columnSpan(4),

                TextInput::make('cantidad')
                    ->label('Cant.')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->live(onBlur: true)
                    ->maxValue(function (Get $get, $record) {
                        $product = Product::find($get('product_id'));
                        if (!$product) return 1;

                        // SOLUCIÓN PARA EDICIÓN: Si estamos editando ($record existe),
                        // sumamos al stock disponible la cantidad que ya se había comprado en este registro.
                        $cantidadActualEnRegistro = $record ? $record->cantidad : 0;
                        return $product->stock + $cantidadActualEnRegistro;
                    })
                    ->hint(function (Get $get, $record) {
                        $product = Product::find($get('product_id'));
                        if (!$product) return null;

                        $cantidadActualEnRegistro = $record ? $record->cantidad : 0;
                        $stockVirtual = $product->stock + $cantidadActualEnRegistro;
                        return "Disponibles para esta venta: {$stockVirtual}";
                    })
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        $precio = (float) ($get('precio_unitario') ?? 0);
                        $set('subtotal', (int) $state * $precio);
                    })
                    ->columnSpan(2),

                TextInput::make('precio_unitario')
                    ->label('Costo U.')
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(3),

                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(3),

                // Lista de Métodos de Pago
                CheckboxList::make('metodo_pago')
                    ->label('Métodos de Pago para este Producto')
                    ->options([
                        'Pago Movil' => 'Pago Movil',
                        'USDT' => 'USDT',
                        'Zinli' => 'Zinli',
                        'Wally' => 'Wally',
                        'Cash' => 'Cash',
                        'Zelle' => 'Zelle',
                    ])
                    ->columns(3)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        if (!empty($get('product_id'))) {
                            self::calcularPreciosItem($set, $get, $get('product_id'));
                        }
                    })
                    ->columnSpan(12),
            ]);
    }

    public static function calcularPreciosItem(Set $set, Get $get, $productId): void
    {
        $product = Product::find($productId);

        if ($product) {
            $metodosSeleccionados = $get("metodo_pago") ?? [];

            if (!is_array($metodosSeleccionados)) {
                $metodosSeleccionados = (array) $metodosSeleccionados;
            }

            $metodosDivisa = ['Zinli', 'Wally', 'Zelle', 'USDT', 'Cash'];
            $aplicaPrecioDivisa = !empty(array_intersect($metodosSeleccionados, $metodosDivisa));

            $precioElegido = ($aplicaPrecioDivisa && !empty($product->precio_divisa))
                ? (float) $product->precio_divisa
                : (float) $product->retail_price;

            $set("precio_unitario", $precioElegido);

            $cantidad = (int) ($get("cantidad") ?? 1);

            $set("subtotal", $cantidad * $precioElegido);
        } else {
            $set("precio_unitario", 0);
            $set("subtotal", 0);
        }
    }
}
