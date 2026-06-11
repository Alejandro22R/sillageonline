<?php

namespace App\Filament\Admin\Resources\Cuotas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CuotaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('detalleVenta.id')
                    ->label('Detalle venta'),
                TextEntry::make('numero_cuota')
                    ->label('Total Cuotas')
                    ->numeric(),
                TextEntry::make('monto_cuota')
                    ->label('Monto Cuota')
                    ->numeric(),
                TextEntry::make('metodo_pago')
                    ->label('Método de Pago'),
                TextEntry::make('cuota_pagada')
                    ->label('Cuota Pagada')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                TextEntry::make('fecha_vencimiento')
                    ->label('Fecha Vencimiento')
                    ->date(),
                TextEntry::make('fecha_pago')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('estado')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
