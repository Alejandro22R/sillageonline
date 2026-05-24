<?php

namespace App\Filament\Admin\Resources\Compras\Schemas;

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

                Repeater::make('detalles')
                    ->relationship('detalles')
                    ->label('Productos de la Factura')
                    ->schema([
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
