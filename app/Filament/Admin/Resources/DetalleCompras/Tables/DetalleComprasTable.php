<?php

namespace App\Filament\Admin\Resources\DetalleCompras\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetalleComprasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('compra.id')
                    ->searchable(),
                TextColumn::make('nombre_perfume')
                    ->searchable(),
                TextColumn::make('marca_perfume')
                    ->searchable(),
                TextColumn::make('mililitros')
                    ->searchable(),
                TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('costo_unitario')
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
