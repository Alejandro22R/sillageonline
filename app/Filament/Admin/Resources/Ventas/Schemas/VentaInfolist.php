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
                TextEntry::make('cliente.id')
                    ->label('Cliente'),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('fecha_venta')
                    ->date(),
                TextEntry::make('total_venta')
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
