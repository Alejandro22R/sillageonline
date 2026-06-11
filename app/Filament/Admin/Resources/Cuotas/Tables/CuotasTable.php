<?php

namespace App\Filament\Admin\Resources\Cuotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CuotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('detalleVenta.id')
                    ->searchable(),
                TextColumn::make('numero_cuota')
                    ->numeric()
                    ->label('Total Cuotas')
                    ->sortable(),
                TextColumn::make('monto_cuota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('metodo_pago'),
                TextColumn::make('cuota_pagada')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->sortable(),
                TextColumn::make('fecha_vencimiento')
                    ->date()
                    ->sortable(),
                TextColumn::make('fecha_pago')
                    ->date()
                    ->sortable(),
                TextColumn::make('estado')
                    ->badge(),
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
