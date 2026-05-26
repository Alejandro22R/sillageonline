<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('marca_perfume')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('wholesale_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('retail_price')
                    ->money()
                    ->sortable(),
              TextColumn::make('metodo_pago')
    ->label('Métodos de Pago')
    ->badge() // Los transforma en etiquetas visuales individuales
    ->separator(',') // Le dice a Filament que el contenido es un array y debe separarlo
    ->placeholder('-'),
                TextColumn::make('precio_divisa')
                    ->money()
                    ->placeholder('-'),
                IconColumn::make('is_exclusive')
                    ->boolean(),
                IconColumn::make('is_offer')
                    ->boolean(),
                TextColumn::make('offer_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
