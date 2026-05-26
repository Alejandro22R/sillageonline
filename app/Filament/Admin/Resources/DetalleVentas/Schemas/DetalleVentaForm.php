<?php

namespace App\Filament\Admin\Resources\DetalleVentas\Schemas;

use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
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
                        self::recalcularCuotas($get, $set);
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

                // Control de Crédito
                Select::make('pago_cuota')
                    ->label('¿Es pago a cuotas / crédito?')
                    ->options([
                        'No' => 'No',
                        'Si' => 'Sí',
                    ])
                    ->default('No')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::recalcularCuotas($get, $set);
                    })
                    ->columnSpan(6),

                Select::make('numero_cuota')
                    ->label('Cantidad de Cuotas')
                    ->options([
                        '2 Cuotas' => '2 Cuotas',
                        '3 Cuotas' => '3 Cuotas',
                    ])
                    ->required(fn (Get $get) => $get('pago_cuota') === 'Si')
                    ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::recalcularCuotas($get, $set);
                    })
                    ->columnSpan(6),

                // Visualización y persistencia de Cuotas distribuidas
                Placeholder::make('primera_cuota_vista')
                    ->label('1ra Cuota')
                    ->content(fn (Get $get) => $get('primera_cuota') ?? 'Calculando...')
                    ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                    ->columnSpan(4),
                Hidden::make('primera_cuota')
                    ->dehydrated(true),

                Placeholder::make('segunda_cuota_vista')
                    ->label('2da Cuota')
                    ->content(fn (Get $get) => $get('segunda_cuota') ?? 'Calculando...')
                    ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                    ->columnSpan(4),
                Hidden::make('segunda_cuota')
                    ->dehydrated(true),

                Placeholder::make('tercera_cuota_vista')
                    ->label('3ra Cuota')
                    ->content(fn (Get $get) => $get('tercera_cuota') ?? 'Calculando...')
                    ->visible(fn (Get $get) => $get('pago_cuota') === 'Si' && $get('numero_cuota') === '3 Cuotas')
                    ->columnSpan(4),
                Hidden::make('tercera_cuota')
                    ->dehydrated(true),
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

            self::recalcularCuotas($get, $set);
        } else {
            $set("precio_unitario", 0);
            $set("subtotal", 0);
            self::limpiarCuotas($set);
        }
    }

    public static function recalcularCuotas(Get $get, Set $set): void
    {
        $subtotal = (float) ($get('subtotal') ?? 0);
        $pagoCuota = $get('pago_cuota') ?? 'No';
        $numeroCuotas = $get('numero_cuota') ?? '';

        $venta = \App\Models\Venta::find($get('venta_id'));
        $fechaBase = $venta ? Carbon::parse($venta->fecha_venta) : now();

        if ($pagoCuota === 'Si' && $subtotal > 0) {
            $fechaCuota1 = $fechaBase->format('d-m-Y');
            $fechaCuota2 = $fechaBase->copy()->addDays(15)->format('d-m-Y');
            $fechaCuota3 = $fechaBase->copy()->addDays(30)->format('d-m-Y');

            if ($numeroCuotas === '2 Cuotas') {
                $montoCuota = round($subtotal / 2, 2);

                $set("primera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota1})");
                $set("segunda_cuota", "\${$montoCuota} (Fecha: {$fechaCuota2})");
                $set("tercera_cuota", null);
            } elseif ($numeroCuotas === '3 Cuotas') {
                $montoCuota = round($subtotal / 3, 2);

                $set("primera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota1})");
                $set("segunda_cuota", "\${$montoCuota} (Fecha: {$fechaCuota2})");
                $set("tercera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota3})");
            } else {
                self::limpiarCuotas($set);
            }
        } else {
            self::limpiarCuotas($set);
        }
    }

    private static function limpiarCuotas(Set $set): void
    {
        $set("primera_cuota", null);
        $set("segunda_cuota", null);
        $set("tercera_cuota", null);
    }
}
