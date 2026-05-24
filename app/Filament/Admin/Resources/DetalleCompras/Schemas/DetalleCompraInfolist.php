<?php

namespace App\Filament\Admin\Resources\DetalleCompras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DetalleCompraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('compra.id')
                    ->label('Compra'),
                TextEntry::make('nombre_perfume'),
                TextEntry::make('marca_perfume'),
                TextEntry::make('mililitros'),
                TextEntry::make('cantidad')
                    ->numeric(),
                TextEntry::make('costo_unitario')
                    ->numeric(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
