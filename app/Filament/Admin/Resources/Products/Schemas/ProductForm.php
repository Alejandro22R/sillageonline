<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

// Dejamos solo la tuya personalizada
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Sección de Datos Principales (Ruta Absoluta)
                \Filament\Forms\Components\Section::make('Información del Perfume')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
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
                                ->columnSpanFull(),
                        ]),
                    ]),

                // SECCIÓN NUEVA: Visibilidad en la Tienda (Ruta Absoluta)
                \Filament\Forms\Components\Section::make('Visibilidad en Sillage')
                    ->description('Controla dónde se muestra esta fragancia en la tienda pública.')
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('is_exclusive')
                            ->label('Colección Exclusiva')
                            ->helperText('Destacar en el primer carrusel superior.')
                            ->onColor('warning'), // Dorado

                        \Filament\Forms\Components\Toggle::make('is_offer')
                            ->label('Oferta Especial')
                            ->helperText('Mostrar en el carrusel de ofertas con etiqueta de descuento.')
                            ->onColor('danger')
                            ->live(), // Reacciona al instante

                        \Filament\Forms\Components\TextInput::make('offer_price')
                            ->label('Precio de Oferta ($)')
                            ->numeric()
                            ->prefix('$')
                            // Usamos la ruta absoluta también para "Get"
                            ->visible(fn (\Filament\Forms\Get $get): bool => $get('is_offer') === true), 
                    ])->columns(2),
            ]);
    }
}