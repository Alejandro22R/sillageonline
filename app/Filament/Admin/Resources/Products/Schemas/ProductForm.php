<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

class ProductForm
{
    public static function configure($form)
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nombre de la Fragancia')
                    ->required()
                    ->maxLength(255),
                    
                \Filament\Forms\Components\TextInput::make('brand')
                    ->label('Marca / Casa Perfumera')
                    ->maxLength(255)
                    ->default('Sillage'),

                \Filament\Forms\Components\TextInput::make('retail_price')
                    ->label('Precio Regular')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                    
                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Imagen del Perfume')
                    ->image()
                    ->directory('products')
                    ->disk('public'),
                    
                \Filament\Forms\Components\Toggle::make('is_exclusive')
                    ->label('Colección Exclusiva')
                    ->helperText('Destacar en el primer carrusel superior.')
                    ->onColor('warning'), 

                \Filament\Forms\Components\Toggle::make('is_offer')
                    ->label('Oferta Especial')
                    ->helperText('Mostrar en el carrusel de ofertas con etiqueta de descuento.')
                    ->onColor('danger')
                    ->live(), 

                \Filament\Forms\Components\TextInput::make('offer_price')
                    ->label('Precio de Oferta ($)')
                    ->numeric()
                    ->prefix('$')
                    // LA MAGIA: Quitamos el tipado estricto (\Filament\Forms\Get)
                    // Ahora aceptará el "Get" nativo de tu sistema sin quejarse.
                    ->visible(fn ($get): bool => $get('is_offer') === true), 
            ]);
    }
}