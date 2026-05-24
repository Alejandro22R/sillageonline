<?php

namespace App\Filament\Admin\Resources\Ventas\Schemas;

use App\Models\Product;
use App\Models\Cliente; // Importación del modelo Cliente
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
    ->relationship('cliente', 'nombre', function ($query) {
        // Traemos tanto el nombre como el apellido de la base de datos
        return $query->select(['id', 'nombre', 'apellido']);
    })
    // Concatenamos para mostrar ambos en el desplegable
    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido}")
    // Permitimos que el buscador filtre por ambos campos
    ->searchable(['nombre', 'apellido'])
    ->preload()
    ->required()
    ->columnSpan(7)
                    // --- MODAL DE CREACIÓN RÁPIDA ---
                    ->createOptionForm([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required() // Obligatorio
                            ->maxLength(255),
                        TextInput::make('apellido')
                            ->label('Apellido')
                            ->required() // Obligatorio
                            ->maxLength(255),
                        Select::make('genero')
                            ->label('Género')
                            ->options([
                                'Hombre' => 'Hombre',
                                'Mujer' => 'Mujer',

                            ])
                            ->required(), // Obligatorio
                        TextInput::make('cedula')
                            ->label('Cédula/DNI')
                            ->unique('clientes', 'cedula', ignoreRecord: true)
                            ->maxLength(50),
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel(),
                        TextInput::make('correo')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('direccion')
                            ->label('Dirección')
                            ->maxLength(500),
                    ])
                    ->createOptionUsing(fn (array $data): int => Cliente::create($data)->id),

                DatePicker::make('fecha_venta')
                    ->label('Fecha de Compra')
                    ->default(now())
                    ->required()
                    ->columnSpan(5),

                Select::make('user_id')
                    ->label('Vendedor')
                    ->relationship('vendedor', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->columnSpan(5),

                // --- CUERPO (Línea 2) ---

                // El Repeater ocupará el lado izquierdo (8 de 12 columnas)
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
                            ->afterStateUpdated(function (Set $set, $state) {
                                $product = Product::find($state);
                                if ($product) {
                                    $set('precio_unitario', $product->retail_price);
                                    $set('stock_max', $product->stock);
                                }
                            })
                            ->columnSpan(2),

                        TextInput::make('cantidad')
                            ->label('Cant.')
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(fn (Set $set, Get $get, $state) =>
                                $set('subtotal', $state * (float)$get('precio_unitario'))
                            )
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
                        $total = collect($get('detalles'))
                            ->filter(fn ($item) => !empty($item['subtotal']))
                            ->sum('subtotal');
                        $set('total_venta', $total);
                    }),

                // El Total ocupará el lado derecho (4 de 12 columnas)
                TextInput::make('total_venta')
                    ->label('TOTAL DE LA VENTA')
                    ->numeric()
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(4)
                    ->extraInputAttributes([
                        'style' => 'font-size: 2.5rem; font-weight: bold; color: #EAB308; border: 2px solid #EAB308; background: transparent; height: 100px; text-align: center;'
                    ]),
            ]);
    }
}
