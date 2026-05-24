<?php

namespace App\Filament\Admin\Resources\Compras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CompraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('proveedor.nombre')
                    ->label('Proveedor'),
                TextEntry::make('fecha_compra')
                    ->date(),
                TextEntry::make('total_compra')
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
