<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema; // Ajustado según tu importación personalizada

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Sección de Datos Principales
                Section::make('Información del Perfume')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nombre de la Fragancia')
                                ->required()
                                ->maxLength(255),
                                
                            TextInput::make('brand')
                                ->label('Marca / Casa Perfumera')
                                ->maxLength(255)
                                ->default('Sillage'),

                            TextInput::make('retail_price')
                                ->label('Precio Regular')
                                ->required()
                                ->numeric()
                                ->prefix('$'),
                                
                            FileUpload::make('image')
                                ->label('Imagen del Perfume')
                                ->image()
                                ->directory('products')
                                ->columnSpanFull(),
                                
                            // * Aquí puedes agregar descripción, stock, etc. si los tenías.
                        ]),
                    ]),

                // SECCIÓN NUEVA: Visibilidad en la Tienda (Sillage)
                Section::make('Visibilidad en Sillage')
                    ->description('Controla dónde se muestra esta fragancia en la tienda pública.')
                    ->schema([
                        Toggle::make('is_exclusive')
                            ->label('Colección Exclusiva')
                            ->helperText('Destacar en el primer carrusel superior.')
                            ->onColor('warning'), // Dorado

                        Toggle::make('is_offer')
                            ->label('Oferta Especial')
                            ->helperText('Mostrar en el carrusel de ofertas con etiqueta de descuento.')
                            ->onColor('danger')
                            ->live(), // Hace que el formulario reaccione al instante

                        TextInput::make('offer_price')
                            ->label('Precio de Oferta ($)')
                            ->numeric()
                            ->prefix('$')
                            // El campo de precio de oferta solo aparece si el interruptor está activo
                            ->visible(fn (Get $get): bool => $get('is_offer') === true), 
                    ])->columns(2),
            ]);
    }
}