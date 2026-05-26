<?php

namespace App\Filament\Admin\Resources\DetalleVentas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DetalleVentaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
              TextEntry::make('venta.id')
    ->label('Venta')
    ->formatStateUsing(fn ($state) => str_pad($state, 6, '0', STR_PAD_LEFT)),


                TextEntry::make('producto.name')
                     ->getStateUsing(function ($record) {
                        return $record->producto ? $record->producto->name : 'Producto no encontrado';
                    })
                    ->label('Producto'),
                TextEntry::make('cantidad')
                    ->numeric(),
                TextEntry::make('metodo_pago')
                    ->label('Método de Pago')
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return implode(', ', $state);
                        }
                        return $state;
                    }),
                TextEntry::make('pago_cuota')
                    ->label('Pago por Cuota'),
                textEntry::make('numero_cuota')
                    ->label('Número de Cuotas')
                    ->placeholder('-'),
                TextEntry::make('primera_cuota')
                    ->label('Primera Cuota')
                      ->placeholder('-'),
                TextEntry::make('segunda_cuota')
                    ->label('Segunda Cuota')
                     ->placeholder('-'),
                TextEntry::make('tercera_cuota')
                    ->label('Tercera Cuota')
                     ->placeholder('-'),
                TextEntry::make('precio_unitario')
                    ->money('USD'),
                TextEntry::make('subtotal')
                    ->money('USD'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
