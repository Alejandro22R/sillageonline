<?php

namespace App\Filament\Admin\Resources\DetalleVentas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetalleVentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('venta.id')
                    ->searchable(),
                TextColumn::make('product_id')
                    ->label('Producto')
                    ->getStateUsing(function ($record) {
                        return $record->producto ? $record->producto->name : 'Producto no encontrado';
                    })
                    ->searchable(),
                TextColumn::make('producto.marca_perfume')
                    ->label('Marca')
                    ->searchable(),

                TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('precio_unitario')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->numeric()
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
