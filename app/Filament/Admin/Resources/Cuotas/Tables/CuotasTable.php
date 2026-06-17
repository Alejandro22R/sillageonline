<?php

namespace App\Filament\Admin\Resources\Cuotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CuotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('DetalleVenta.venta_id')
                    ->label('Codigo de Venta')
                     ->formatStateUsing(fn ($state) => str_pad($state, 6, '0', STR_PAD_LEFT))
    ->searchable(query: function ($query, string $search) {
        // Esto permite buscar quitando los ceros a la izquierda que digite el usuario
        $query->where('venta_id', 'like', "%" . ltrim($search, '0') . "%");
    })
                    ->searchable(),
             TextColumn::make('detalleVenta.id')
    ->label('Cliente - Producto')
    ->formatStateUsing(fn ($record) =>
        ($record->detalleVenta->venta->cliente->nombre ?? 'N/A') . ' - ' .
        ($record->detalleVenta->producto->name ?? 'N/A')
    )
    ->searchable(query: function ($query, string $search) {
        $query->whereHas('detalleVenta.venta.cliente', function ($query) use ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%"); // Asumiendo que tu columna se llama 'cedula'
        });
    }),

                TextColumn::make('numero_cuota')
                    ->label('Número de Cuota')
                    ->searchable(),

                TextColumn::make('monto_cuota')
                    ->label('Monto Cuota')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),

                TextColumn::make('metodo_pago')
                    ->label('Método de Pago')
                    ->searchable(),

                TextColumn::make('cuota_pagada')
                    ->label('Cuota Pagada')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('fecha_pago')
                    ->label('Fecha Pago')
                    ->date()
                    ->sortable(),

                TextColumn::make('estado')
                    ->badge(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->searchable(),

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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
