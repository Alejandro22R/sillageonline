<?php

namespace App\Filament\Admin\Resources\Clientes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('apellido')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('cedula')
                    ->label('Cédula/DNI')
                    ->unique('clientes', 'cedula', ignoreRecord: true)
                    ->maxLength(50),
                    
                Select::make('genero')
                    ->label('Género')
                    ->options([
                        'Hombre' => 'Hombre',
                        'Mujer' => 'Mujer',
                    ])
                    ->required()
                    ->default('Hombre'),
                    
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(255),
                    
                TextInput::make('correo')
                    ->label('Correo Electrónico')
                    ->email()
                    ->unique('clientes', 'correo', ignoreRecord: true)
                    ->maxLength(255),
                    
                TextInput::make('direccion')
                    ->label('Dirección')
                    ->maxLength(500),
            ]);
    }
}