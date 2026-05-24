<?php

namespace App\Filament\Admin\Resources\Proveedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProveedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('rif'),
                TextInput::make('contacto'),
                TextInput::make('direccion'),
            ]);
    }
}
