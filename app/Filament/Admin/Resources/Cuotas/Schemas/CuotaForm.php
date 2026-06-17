<?php

namespace App\Filament\Admin\Resources\Cuotas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\DetalleVenta;

class CuotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('detalle_venta_id')
    ->label('Venta (Cliente - Producto)')
    ->relationship('detalleVenta', 'id')
    ->getOptionLabelFromRecordUsing(fn ($record) =>
        ($record->venta->cliente->nombre ?? 'N/A') . ' - ' . ($record->producto->name ?? 'N/A')
    )
    ->searchable()
    ->preload()
    ->live()
    // NUEVO: Esto permite buscar por nombre de cliente o nombre de producto
    ->getSearchResultsUsing(function (string $search): array {
        return \App\Models\DetalleVenta::query()
            ->whereHas('venta.cliente', fn ($query) => $query->where('nombre', 'like', "%{$search}%"))
            ->orWhereHas('producto', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->get()
            ->mapWithKeys(fn ($record) => [
                $record->id => ($record->venta->cliente->nombre ?? 'N/A') . ' - ' . ($record->producto->name ?? 'N/A')
            ])
            ->toArray();
    })
    ->afterStateUpdated(function ($state, $set) {
        self::cargarDatos($state, $set);
    })
    ->afterStateHydrated(function ($state, $set) {
        self::cargarDatos($state, $set);
    })
    ->required(),

                TextInput::make('precio_perfume')
                    ->label('Precio del Producto')
                    ->disabled()
                    ->dehydrated()
                    ->prefix('$'),

                TextInput::make('numero_cuota')
                    ->label('Cuotas totales acordadas')
                    ->disabled()
                    ->dehydrated(),

                Select::make('cuota_pagada')
                    ->label('¿Qué número de cuota estás pagando?')
                    ->options(function ($get) {
                        $total = (int) $get('numero_cuota');
                        if ($total <= 0) return [];
                        return collect(range(1, $total))->mapWithKeys(fn ($i) => [$i => "Cuota {$i}"])->toArray();
                    })
                    ->required()
                    ->live(),

                Select::make('metodo_pago')
                    ->options([
                        'Pago Movil' => 'Pago Movil', 'USDT' => 'USDT', 'Zinli' => 'Zinli',
                        'Wally' => 'Wally', 'Cash' => 'Cash', 'Zelle' => 'Zelle',
                    ])
                    ->label('Método de Pago')
                    ->required(),

                TextInput::make('monto_cuota')
                    ->label('Monto Pagado')
                    ->numeric()
                    ->prefix('$')
                    ->required(),

                TextInput::make('descripcion')
                    ->label('Descripción/Detalle')
                    ->placeholder('Ej: Pago de cuota')
                    ->required(),

                DatePicker::make('fecha_pago')
                    ->label('Fecha del Pago')
                    ->default(now()),

                Select::make('estado')
                    ->label('Estado')
                    ->options(['pendiente' => 'Pendiente', 'pagado' => 'Pagado'])
                    ->default('pagado')
                    ->required(),
            ]);
    }

    // Método auxiliar para no duplicar código
    protected static function cargarDatos($state, $set)
    {
        $detalle = DetalleVenta::find($state);
        if ($detalle) {
            $set('precio_perfume', $detalle->precio_unitario ?? 0);
            $set('numero_cuota', $detalle->numero_cuota ?? 0);
        }
    }
}
