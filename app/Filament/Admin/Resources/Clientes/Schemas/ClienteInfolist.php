<?php

namespace App\Filament\Admin\Resources\Clientes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('apellido'),
                TextEntry::make('cedula'),
                TextEntry::make('telefono'),
                TextEntry::make('correo'),
                TextEntry::make('direccion')
                    ->columnSpanFull(),
                TextEntry::make('genero')
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
