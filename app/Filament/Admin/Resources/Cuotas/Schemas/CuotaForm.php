<?php

namespace App\Filament\Admin\Resources\Cuotas\Schemas;

use App\Models\DetalleVenta;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\Carbon;

class CuotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('detalle_venta_id')
                ->label('Venta')

                ->relationship('detalleVenta', 'id', fn ($query) => $query->where('pago_cuota', 'Si'))
                ->getOptionLabelFromRecordUsing(fn (DetalleVenta $record) => "Venta #{$record->id} - Total: {$record->subtotal}")
                ->required()
                ->live()

                ->afterStateUpdated(function ($livewire, $state) {
                    $venta = DetalleVenta::find($state);
                    if ($venta) {
                        $numCuotas = (int) filter_var($venta->numero_cuota, FILTER_SANITIZE_NUMBER_INT);
                        $monto = $numCuotas > 0 ? ($venta->subtotal / $numCuotas) : $venta->subtotal;

                        $livewire->form->fill([
                            'detalle_venta_id' => $state,
                            'numero_cuota' => $numCuotas,
                            'monto_cuota' => number_format($monto, 2, '.', ''),
                        ]);
                    }
                }),

            CheckboxList::make('cuota_pagada')
                ->label('Seleccione las cuotas a pagar')
                ->options(function ($get) {
                    $num = (int) $get('numero_cuota');
                    $options = [];
                    for ($i = 1; $i <= $num; $i++) { $options[$i] = "Cuota #{$i}"; }
                    return $options;
                })
                ->columns(3)
                ->dehydrated()
                ->live()
                ->afterStateUpdated(function ($livewire, $state, $get) {
                    if (empty($state)) return;

                    $venta = DetalleVenta::find($get('detalle_venta_id'));
                    if (!$venta) return;

                    // Tomamos la última cuota seleccionada para definir la fecha de vencimiento
                    $ultimaCuota = max($state);

                    $columna = match($ultimaCuota) {
                        1 => 'primera_cuota',
                        2 => 'segunda_cuota',
                        3 => 'tercera_cuota',
                        default => 'primera_cuota',
                    };

                    $textoFecha = $venta->{$columna};
                    if (preg_match('/(\d{2}-\d{2}-\d{4})/', $textoFecha, $matches)) {
                        $fecha = Carbon::createFromFormat('d-m-Y', $matches[1])->format('Y-m-d');
                        $livewire->form->fill(['fecha_vencimiento' => $fecha]);
                    }
                }),

            TextInput::make('numero_cuota')->required()->numeric(),
            TextInput::make('monto_cuota')->required()->numeric(),

            Select::make('metodo_pago')
                ->options([
                    'Pago Movil' => 'Pago Movil', 'USDT' => 'USDT', 'Zinli' => 'Zinli',
                    'Wally' => 'Wally', 'Cash' => 'Cash', 'Zelle' => 'Zelle'
                ])
                ->required(),

            DatePicker::make('fecha_vencimiento')->required(),
            DatePicker::make('fecha_pago'),

            Select::make('estado')
                ->options(['pendiente' => 'Pendiente', 'pagado' => 'Pagado'])
                ->default('pendiente')
                ->required(),
        ]);
    }
}
