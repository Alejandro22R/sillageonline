<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de la Fragancia')
                    ->required(),
                TextInput::make('brand')
                    ->label('Marca (Ej. Lattafa, Afnan)'),
                Textarea::make('description')
                    ->label('Descripción y Notas Olfativas')
                    ->columnSpanFull(),
                TextInput::make('wholesale_price')
                    ->label('Precio al Mayor')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('retail_price')
                    ->label('Precio de Venta (Detal)')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock')
                    ->label('Unidades en Inventario')
                    ->required()
                    ->numeric()
                    ->default(0),
                FileUpload::make('image')
                    ->label('Imagen del Perfume')
                    ->image()
                    ->disk('public')
                    ->directory('products'),
            ]);
    }
}