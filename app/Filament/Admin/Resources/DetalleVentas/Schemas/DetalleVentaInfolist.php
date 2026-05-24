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
