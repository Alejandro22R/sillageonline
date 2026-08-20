<?php

namespace App\Filament\Admin\Resources\Ventas\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class VentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([

                // --- CABECERA DE LA VENTA (Datos Generales) ---
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
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::actualizarGranTotal($get, $set);
                    })
                    ->columnSpan(5),

                Select::make('user_id')
                    ->label('Vendedor')
                    ->relationship('vendedor', 'name')
                    ->default(auth()->id())
                    ->dehydrated()
                    ->required()
                    ->columnSpan(12),

                // --- CUERPO: REPEATER (Mapea con DetalleVenta) ---
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
                                self::calcularPreciosItem($set, $get, $state);
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(4),

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
                                self::calcularPreciosItem($set, $get, $get('product_id'));
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(2),

                        TextInput::make('precio_unitario')
                            ->label('Costo U.')
                            ->prefix('$')
                            ->readonly()
                            ->columnSpan(3),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('$')
                            ->readonly()
                            ->columnSpan(3),

                        CheckboxList::make('metodo_pago')
                            ->label('Métodos de Pago para este Producto')
                            ->options([
                                'Pago Movil' => 'Pago Movil',
                                'USDT' => 'USDT',
                                'Zinli' => 'Zinli',
                                'Wally' => 'Wally',
                                'Cash' => 'Cash',
                                'Zelle' => 'Zelle',
                            ])
                            ->columns(3)
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                if (!empty($get('product_id'))) {
                                    self::calcularPreciosItem($set, $get, $get('product_id'));
                                }
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(12),
                    ])
                    ->columns(12)
                    ->columnSpan(12)
                    ->addActionLabel('Añadir otro perfume')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::actualizarGranTotal($get, $set);
                    }),

                // --- NUEVO: Opción global de recargo de $5 por Pago Móvil (aparece fuera del repeater) ---
                Select::make('recargo_pago_movil_global')
                    ->label('¿Desea sumarle los $5 adicionales por pago en Bs (Pago Móvil) al total?')
                    ->options([
                        'No' => 'No',
                        'Si' => 'Sí (+ $5)',
                    ])
                    ->default('No')
                    ->required()
                    ->visible(function (Get $get) {
                        $detalles = $get('detalles') ?? [];
                        // Revisa si al menos uno de los productos añadidos tiene 'Pago Movil' seleccionado
                        foreach ($detalles as $item) {
                            $metodos = $item['metodo_pago'] ?? [];
                            if (is_array($metodos) && in_array('Pago Movil', $metodos)) {
                                return true;
                            }
                        }
                        return false;
                    })
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::actualizarGranTotal($get, $set);
                    })
                    ->columnSpan(12),

                TextInput::make('total_venta')
                    ->label('TOTAL DE LA VENTA')
                    ->numeric()
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(12)
                    ->extraInputAttributes([
                        'style' => 'font-size: 2.5rem; font-weight: bold; color: #EAB308; border: 2px solid #EAB308; background: transparent; height: 100px; text-align: center;'
                    ]),
            ]);
    }

    public static function calcularPreciosItem(Set $set, Get $get, $productId): void
    {
        $product = Product::find($productId);

        if ($product) {
            $metodosSeleccionados = $get("metodo_pago") ?? [];

            if (!is_array($metodosSeleccionados)) {
                $metodosSeleccionados = (array) $metodosSeleccionados;
            }

            $metodosDivisa = ['Zinli', 'Wally', 'Zelle', 'USDT', 'Cash'];
            $aplicaPrecioDivisa = !empty(array_intersect($metodosSeleccionados, $metodosDivisa));

            $precioElegido = ($aplicaPrecioDivisa && !empty($product->precio_divisa))
                ? (float) $product->precio_divisa
                : (float) $product->retail_price;

            $set("precio_unitario", $precioElegido);

            $cantidad = (int) ($get("cantidad") ?? 1);
            if ($cantidad > $product->stock) {
                $set("cantidad", $product->stock);
                $cantidad = $product->stock;
            }

            $set("subtotal", $cantidad * $precioElegido);
        } else {
            $set("precio_unitario", 0);
            $set("subtotal", 0);
        }
    }

    public static function actualizarGranTotal(Get $get, Set $set): void
    {
        $detalles = $get('detalles') ?? [];
        $totalVenta = 0;

        foreach ($detalles as $item) {
            $totalVenta += (float) ($item['subtotal'] ?? 0);
        }

        // Si se seleccionó "Sí" en el recargo global, se le suman los $5 al total acumulado
        $recargoGlobal = $get('recargo_pago_movil_global') ?? 'No';
        if ($recargoGlobal === 'Si' && $totalVenta > 0) {
            $totalVenta += 5.0;
        }

        $set('total_venta', $totalVenta);
    }
}
