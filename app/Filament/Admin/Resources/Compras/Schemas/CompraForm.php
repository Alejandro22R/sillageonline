<?php

namespace App\Filament\Admin\Resources\Compras\Schemas;

use App\Filament\Forms\Components\BarcodeScannerInput;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get; // Volvemos a tu Get original
use Filament\Schemas\Components\Utilities\Set; // Volvemos a tu Set original
use Filament\Schemas\Schema;

class CompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('proveedor_id')
                    ->label('Proveedor')
                    ->options(\App\Models\Proveedor::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('fecha_compra')
                    ->label('Fecha de Compra')
                    ->default(now())
                    ->required(),

                BarcodeScannerInput::make('escanear_codigo')
                    ->label('Escanear perfume')
                    ->scannerPlaceholder('Escanea el código de barras de la caja')
                    ->helperText('Cada vez que escanees el mismo código, se suma 1 a la cantidad de esa línea en vez de duplicarla.')
                    ->dehydrated(false)
                    ->live()
                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                        if (filled($state)) {
                            self::procesarCodigoEscaneado($state, $get, $set);
                        }
                        $set('escanear_codigo', null);
                    })
                    ->columnSpanFull(),

                Repeater::make('detalles')
                    ->relationship('detalles')
                    ->label('Productos de la Factura')
                    ->schema([
                        TextInput::make('codigo_barras')
                            ->label('Código de Barras')
                            ->readonly()
                            ->placeholder('—')
                            ->dehydrated(),

                        TextInput::make('nombre_perfume')
                            ->label('Nombre del Perfume')
                            ->required(),

                        TextInput::make('marca_perfume')
                            ->label('Marca')
                            ->required(),

                        TextInput::make('mililitros')
                            ->label('ML')
                            ->required(),

                        TextInput::make('cantidad')
                            ->label('Cant.')
                            ->numeric()
                            ->default(1)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularSubtotal($get, $set)),

                        TextInput::make('costo_unitario')
                            ->label('Costo U.')
                            ->numeric()
                            ->prefix('$')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::calcularSubtotal($get, $set)),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('$')
                            ->readonly()
                            ->dehydrated()
                            ->extraInputAttributes(['style' => 'font-weight: bold; color: #10b981;']),
                    ])
                    ->columns(3)
                    ->addActionLabel('Añadir otro perfume')
                    ->live()
                    // Actualiza el total si se añade o elimina un registro
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::actualizarTotalGeneral($get, $set)),

                TextInput::make('total_compra')
                    ->label('TOTAL DE LA COMPRA')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->readonly()
                    ->default(0.00)
                    ->dehydrated()
                    ->extraInputAttributes([
                        'style' => 'background-color: #111827 !important;
                                    color: #fbbf24 !important;
                                    font-size: 1.5rem !important;
                                    font-weight: bold !important;
                                    border: 1px solid #fbbf24;'
                    ]),
            ]);
    }

    protected static function calcularSubtotal(Get $get, Set $set): void
    {
        $cantidad = (float) ($get('cantidad') ?? 0);
        $costo = (float) ($get('costo_unitario') ?? 0);

        // 1. Calculamos y asignamos el subtotal de la fila actual
        $subtotal = $cantidad * $costo;
        $set('subtotal', number_format($subtotal, 2, '.', ''));

        // 2. REACCIONAR EN TIEMPO REAL: Escalamos a la raíz del formulario con '../../'
        // para leer todos los detalles actuales e incluir el cambio recién hecho.
        $detalles = $get('../../detalles') ?? [];
        $total = 0;

        foreach ($detalles as $detalle) {
            $total += (float) ($detalle['subtotal'] ?? 0);
        }

        // 3. Forzamos al campo total_compra (fuera del repeater) a actualizarse ya mismo
        $set('../../total_compra', number_format($total, 2, '.', ''));
    }

    /**
     * Procesa un código recién escaneado dentro del repeater "detalles":
     * si ya hay una línea con ese mismo código, le suma 1 a la cantidad
     * (varias unidades del mismo perfume); si no, agrega una línea
     * nueva, completando nombre/marca/costo desde el producto del
     * catálogo si ya existe uno con ese código de barras.
     */
    protected static function procesarCodigoEscaneado(string $codigo, Get $get, Set $set): void
    {
        $detalles = $get('detalles') ?? [];

        foreach ($detalles as $key => $detalle) {
            if (($detalle['codigo_barras'] ?? null) === $codigo) {
                $nuevaCantidad = (float) ($detalle['cantidad'] ?? 0) + 1;
                $costo = (float) ($detalle['costo_unitario'] ?? 0);

                $detalles[$key]['cantidad'] = $nuevaCantidad;
                $detalles[$key]['subtotal'] = number_format($nuevaCantidad * $costo, 2, '.', '');

                $set('detalles', $detalles);
                self::recalcularTotalDesdeDetalles($detalles, $set);

                return;
            }
        }

        $producto = Product::where('codigo_barras', $codigo)->first();
        $costoInicial = $producto->wholesale_price ?? 0;

        $detalles[] = [
            'codigo_barras'  => $codigo,
            'nombre_perfume' => $producto->name ?? '',
            'marca_perfume'  => $producto->marca_perfume ?? '',
            'mililitros'     => '',
            'cantidad'       => 1,
            'costo_unitario' => $costoInicial,
            'subtotal'       => number_format($costoInicial, 2, '.', ''),
        ];

        $set('detalles', $detalles);
        self::recalcularTotalDesdeDetalles($detalles, $set);
    }

    /**
     * Igual que actualizarTotalGeneral(), pero a partir de un arreglo de
     * detalles ya en mano (en vez de leerlo de nuevo con $get), porque
     * dentro de procesarCodigoEscaneado() el $get del repeater todavía
     * no refleja el $set que se acaba de hacer en esta misma pasada.
     */
    protected static function recalcularTotalDesdeDetalles(array $detalles, Set $set): void
    {
        $total = 0;

        foreach ($detalles as $detalle) {
            $total += (float) ($detalle['subtotal'] ?? 0);
        }

        $set('total_compra', number_format($total, 2, '.', ''));
    }

    protected static function actualizarTotalGeneral(Get $get, Set $set): void
    {
        $detalles = $get('detalles') ?? [];
        $total = 0;

        foreach ($detalles as $detalle) {
            $total += (float) ($detalle['subtotal'] ?? 0);
        }

        $set('total_compra', number_format($total, 2, '.', ''));
    }
}
