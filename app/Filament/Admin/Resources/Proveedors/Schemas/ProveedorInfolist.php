<?php

namespace App\Filament\Admin\Resources\Proveedors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProveedorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('rif')
                    ->placeholder('-'),
                TextEntry::make('contacto')
                    ->placeholder('-'),
                TextEntry::make('direccion')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
