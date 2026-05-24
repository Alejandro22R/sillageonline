<?php

namespace App\Filament\Admin\Resources\DetalleCompras\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DetalleCompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('compra_id')
                    ->relationship('compra', 'id')
                    ->required(),
                TextInput::make('nombre_perfume')
                    ->required(),
                TextInput::make('marca_perfume')
                    ->required(),
                TextInput::make('mililitros')
                    ->required(),
                TextInput::make('cantidad')
                    ->required()
                    ->numeric(),
                TextInput::make('costo_unitario')
                    ->required()
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
