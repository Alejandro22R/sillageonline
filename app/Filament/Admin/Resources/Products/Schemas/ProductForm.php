<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\DetalleCompra;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;

class ProductForm
{
    public static function configure($form)
    {
        return $form
            ->schema([
                // 1. Selector con la lógica de limpieza al guardar
                Select::make('name')
                    ->label('Seleccionar Perfume del Inventario')
                    ->options(function () {
                        return DetalleCompra::query()
                            ->select('nombre_perfume', 'marca_perfume')
                            ->distinct()
                            ->get()
                            ->mapWithKeys(function ($item) {
                                $key = $item->nombre_perfume . '|' . $item->marca_perfume;
                                $label = "{$item->nombre_perfume} ({$item->marca_perfume})";
                                return [$key => $label];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->live()
                    // ESTA ES LA SOLUCIÓN: Antes de guardar, extraemos solo el nombre
                    ->dehydrateStateUsing(fn ($state) => explode('|', $state)[0] ?? $state)
                    ->afterStateUpdated(function ($state, Set $set) {
                        if (blank($state)) return;

                        [$nombre, $marca] = explode('|', $state);

                        $detalle = DetalleCompra::where('nombre_perfume', $nombre)
                            ->where('marca_perfume', $marca)
                            ->latest()
                            ->first();

                        if ($detalle) {
                            $set('marca_perfume', $marca);
                            $set('wholesale_price', $detalle->costo_unitario);

                            $totalStock = DetalleCompra::where('nombre_perfume', $nombre)
                                ->where('marca_perfume', $marca)
                                ->sum('cantidad');
                            $set('stock', $totalStock);
                        }
                    }),

                TextInput::make('marca_perfume')
                    ->label('Marca Detectada')
                    ->readonly()
                    ->required(),

                TextInput::make('retail_price')
                    ->label('Precio de Venta')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('wholesale_price')
                    ->label('Precio de Costo (Última Compra)')
                    ->numeric()
                    ->prefix('$')
                    ->readonly(),

                TextInput::make('stock')
                    ->label('Inventario Total de esta Marca')
                    ->numeric()
                    ->required(),
                TextInput::make('description')
                    ->label('Descripción del Perfume'),

                FileUpload::make('image')
                    ->label('Imagen del Perfume')
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->columnSpanFull(),

                Toggle::make('is_exclusive')
                    ->label('Colección Exclusiva')
                    ->onColor('warning'),

                Toggle::make('is_offer')
                    ->label('Oferta Especial')
                    ->onColor('danger')
                    ->live(),

                TextInput::make('offer_price')
                    ->label('Precio de Oferta')
                    ->numeric()
                    ->prefix('$')
                    ->visible(fn ($get): bool => (bool) $get('is_offer')),
            ]);
    }
}
