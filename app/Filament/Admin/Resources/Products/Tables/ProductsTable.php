<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular(),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Perfume')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('brand')
                    ->label('Marca')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('retail_price')
                    ->label('Precio')
                    ->money('USD')
                    ->sortable(),

                // Controles rápidos desde la tabla
                \Filament\Tables\Columns\ToggleColumn::make('is_exclusive')
                    ->label('Exclusivo')
                    ->onColor('warning')
                    ->sortable(),

                \Filament\Tables\Columns\ToggleColumn::make('is_offer')
                    ->label('Oferta')
                    ->onColor('danger')
                    ->sortable(),
            ])
            ->filters([
                // Filtros vacíos
            ])
            // VACIADO TOTAL: Eliminamos cualquier clase conflictiva
            ->actions([]) 
            ->bulkActions([]);
    }
}