<?php

namespace App\Filament\Admin\Resources\DetalleVentas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DetalleVentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('venta_id')
                    ->relationship('venta', 'id')
                    ->required(),
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cantidad')
                    ->required()
                    ->numeric(),
                TextInput::make('precio_unitario')
                    ->required()
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
            ]);
    }
}
