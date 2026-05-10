<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagen')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Perfume')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('brand')
                    ->label('Marca')
                    ->searchable(),

                TextColumn::make('retail_price')
                    ->label('Precio')
                    ->money('USD')
                    ->sortable(),

                // SECCIÓN NUEVA: Controles rápidos desde la tabla
                ToggleColumn::make('is_exclusive')
                    ->label('Exclusivo')
                    ->onColor('warning')
                    ->sortable(),

                ToggleColumn::make('is_offer')
                    ->label('Oferta')
                    ->onColor('danger')
                    ->sortable(),
            ])
            ->filters([
                // Aquí van tus filtros si tienes (ej: Filtrar por marca)
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}