<?php

namespace App\Filament\Admin\Resources\Ventas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('cliente.nombre')
    ->label('Cliente')
    ->formatStateUsing(fn ($record) => $record->cliente
        ? "{$record->cliente->nombre} {$record->cliente->apellido}"
        : 'Sin cliente'
    )
    ->searchable(query: function ($query, string $search) {
        $query->whereHas('cliente', function ($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('apellido', 'like', "%{$search}%");
        });
    }),

                // CAMBIO AQUÍ: Usamos la relación para mostrar el nombre
                TextColumn::make('vendedor.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('fecha_venta')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_venta')
                    ->label('Total')
                    ->money('USD') // Opcional: para que se vea con formato de moneda
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
            ->actions([ // Cambiado de recordActions a actions para mayor compatibilidad
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([ // Cambiado de toolbarActions a bulkActions
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
