<?php

namespace App\Filament\Admin\Resources\Ventas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VentaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('cliente')
    ->label('Cliente')
    ->getStateUsing(fn ($record) => $record->cliente
        ? "{$record->cliente->nombre} {$record->cliente->apellido}"
        : 'Sin cliente'),


                TextEntry::make('vendedor.name')
                    ->label('Vendedor'),
                TextEntry::make('fecha_venta')
                    ->date(),
                TextEntry::make('total_venta')
                    ->label('Total')
                    ->money('USD'), // Opcional: para que se vea con formato de moneda
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
