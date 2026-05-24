<?php

namespace App\Filament\Admin\Resources\Ventas\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class VentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12) // Base de 12 columnas para organizar todo
            ->components([

                // --- CABECERA (Línea 1) ---
                Select::make('cliente_id')
                    ->label('Cliente')
                    ->relationship(
                        name: 'cliente',
                        titleAttribute: 'nombre',
                        modifyQueryUsing: fn ($query) => $query->select('*')->selectRaw("CONCAT(nombre, ' ', apellido) as nombre_completo")
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido}")
                    ->searchable(['nombre', 'apellido'])
                    ->preload()
                    ->required()
                    ->columnSpan(7)
                    ->createOptionForm([
                        TextInput::make('nombre')->label('Nombre')->required()->maxLength(255),
                        TextInput::make('apellido')->label('Apellido')->required()->maxLength(255),
                        TextInput::make('cedula')->label('Cédula / Identificación')->maxLength(50),
                        TextInput::make('telefono')->label('Teléfono')->tel()->maxLength(50),
                        TextInput::make('correo')->label('Correo Electrónico')->email()->maxLength(255),
                        Select::make('genero')->label('Género')->options(['Hombre' => 'Hombre', 'Mujer' => 'Mujer']),
                        TextInput::make('direccion')->label('Dirección')->maxLength(505),
                    ]),

                DatePicker::make('fecha_venta')
                    ->label('Fecha de Compra')
                    ->default(now())
                    ->required()
                    ->columnSpan(5),

                Select::make('user_id')
                    ->label('Vendedor')
                    ->relationship('vendedor', 'name')
                    ->default(auth()->id())
                    ->dehydrated()
                    ->required()
                    ->columnSpan(5),

                // --- CUERPO (Línea 2) ---

                Repeater::make('detalles')
                    ->label('Productos de la Factura')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->label('Nombre del Perfume')
                            ->options(Product::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $product = Product::find($state);
                                if ($product) {
                                    $set('precio_unitario', $product->retail_price);

                                    $cantidad = (int) ($get('cantidad') ?? 1);
                                    if ($cantidad > $product->stock) {
                                        $set('cantidad', $product->stock);
                                        $cantidad = $product->stock;
                                    }

                                    $set('subtotal', $cantidad * (float) $product->retail_price);
                                } else {
                                    $set('precio_unitario', 0);
                                    $set('subtotal', 0);
                                }

                                // Ejecuta la función estática para actualizar el contenedor de arriba
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(2),

                        TextInput::make('cantidad')
                            ->label('Cant.')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->live(onBlur: true)
                            ->maxValue(function (Get $get) {
                                $product = Product::find($get('product_id'));
                                return $product ? $product->stock : 1;
                            })
                            ->hint(function (Get $get) {
                                $product = Product::find($get('product_id'));
                                return $product ? "Disponibles: {$product->stock}" : null;
                            })
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                $precio = (float) ($get('precio_unitario') ?? 0);
                                $set('subtotal', (int) $state * $precio);

                                // Ejecuta la función estática para actualizar el contenedor de arriba
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(1),

                        TextInput::make('precio_unitario')
                            ->label('Costo U.')
                            ->prefix('$')
                            ->readonly()
                            ->columnSpan(1),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('$')
                            ->readonly()
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->columnSpan(8)
                    ->addActionLabel('Añadir otro perfume')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::actualizarGranTotal($get, $set);
                    }),

                // El Total de la venta en el lado derecho
                TextInput::make('total_venta')
                    ->label('TOTAL DE LA VENTA')
                    ->numeric()
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(4)
                    ->placeholder(function (Get $get) {
                        // Evita el error de conversión calculando el valor inicial de forma segura como string/numeric nativo
                        $detalles = $get('detalles') ?? [];
                        return (string) collect($detalles)->filter(fn ($item) => !empty($item['subtotal']))->sum('subtotal');
                    })
                    ->extraInputAttributes([
                        'style' => 'font-size: 2.5rem; font-weight: bold; color: #EAB308; border: 2px solid #EAB308; background: transparent; height: 100px; text-align: center;'
                    ]),
            ]);
    }

    /**
     * Helper para despachar el cálculo real hacia la raíz del formulario
     */
    public static function actualizarGranTotal(Get $get, Set $set): void
    {
        // Buscamos los detalles subiendo los niveles del árbol de componentes de Filament v4
        $detalles = $get('detalles') ?? $get('../../detalles') ?? [];

        $total = collect($detalles)
            ->filter(fn ($item) => !empty($item['subtotal']))
            ->sum('subtotal');

        // Seteamos el valor de manera absoluta en ambos contextos para asegurar el refresco visual
        $set('total_venta', $total);
        $set('../../total_venta', $total);
    }
}
