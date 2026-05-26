<?php

namespace App\Filament\Admin\Resources\Ventas\Schemas;

use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
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
                    ->columnSpan(12), // Ocupa el ancho completo antes del bloque de productos

                // --- CUERPO: REPEATER (Mapea con DetalleVenta) ---
                Repeater::make('detalles')
                    ->label('Productos de la Factura')
                    ->relationship()
                    ->schema([

                        // Fila 1 del Detalle: Selección del perfume y cantidad
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
                                $precio = (float) ($get('precio_unitario') ?? 0);
                                $set('subtotal', (int) $state * $precio);
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

                        // CORRECCIÓN: método_pago dentro del Repeater mapeado con el modelo DetalleVenta
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
                                // Recalcula los costos del perfume actual en base al método de pago seleccionado
                                if (!empty($get('product_id'))) {
                                    self::calcularPreciosItem($set, $get, $get('product_id'));
                                }
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(12),

                        // Fila 3 del Detalle: Control de Crédito por Perfume
                        Select::make('pago_cuota')
                            ->label('¿Es pago a cuotas / crédito?')
                            ->options([
                                'No' => 'No',
                                'Si' => 'Sí',
                            ])
                            ->default('No')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(6),

                        Select::make('numero_cuota')
                            ->label('Cantidad de Cuotas')
                            ->options([
                                '2 Cuotas' => '2 Cuotas',
                                '3 Cuotas' => '3 Cuotas',
                            ])
                            ->required(fn (Get $get) => $get('pago_cuota') === 'Si')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::actualizarGranTotal($get, $set);
                            })
                            ->columnSpan(6),

                        // --- CAMPOS DE CUOTAS PERSISTENTES ---
                        Placeholder::make('primera_cuota_vista')
                            ->label('1ra Cuota')
                            ->content(fn (Get $get) => $get('primera_cuota') ?? 'Calculando...')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                            ->columnSpan(4),
                        Hidden::make('primera_cuota')
                            ->dehydrated(true),

                        Placeholder::make('segunda_cuota_vista')
                            ->label('2da Cuota')
                            ->content(fn (Get $get) => $get('segunda_cuota') ?? 'Calculando...')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                            ->columnSpan(4),
                        Hidden::make('segunda_cuota')
                            ->dehydrated(true),

                        Placeholder::make('tercera_cuota_vista')
                            ->label('3ra Cuota')
                            ->content(fn (Get $get) => $get('tercera_cuota') ?? 'Calculando...')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si' && $get('numero_cuota') === '3 Cuotas')
                            ->columnSpan(4),
                        Hidden::make('tercera_cuota')
                            ->dehydrated(true),
                    ])
                    ->columns(12) // Estructurado en rejilla de 12 para un diseño responsivo interno completo
                    ->columnSpan(12)
                    ->addActionLabel('Añadir otro perfume')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::actualizarGranTotal($get, $set);
                    }),

                TextInput::make('total_venta')
                    ->label('TOTAL DE LA VENTA')
                    ->numeric()
                    ->prefix('$')
                    ->readonly()
                    ->columnSpan(12)
                    ->placeholder(function (Get $get) {
                        $detalles = $get('detalles') ?? [];
                        return (string) collect($detalles)->filter(fn ($item) => !empty($item['subtotal']))->sum('subtotal');
                    })
                    ->extraInputAttributes([
                        'style' => 'font-size: 2.5rem; font-weight: bold; color: #EAB308; border: 2px solid #EAB308; background: transparent; height: 100px; text-align: center;'
                    ]),
            ]);
    }

    public static function calcularPreciosItem(Set $set, Get $get, $productId): void
    {
        $product = Product::find($productId);

        if ($product) {
            // Evaluamos de forma local el método de pago elegido dentro de esta fila del repeater
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

        $fechaBaseInput = $get('fecha_venta') ?? now();
        $fechaBase = Carbon::parse($fechaBaseInput);

        foreach ($detalles as $key => $item) {
            $subtotalItem = (float) ($item['subtotal'] ?? 0);
            $totalVenta += $subtotalItem;

            $pagoCuota = $item['pago_cuota'] ?? 'No';
            $numeroCuotas = $item['numero_cuota'] ?? '';

            $path = "detalles.{$key}.";

            if ($pagoCuota === 'Si' && $subtotalItem > 0) {
                $fechaCuota1 = $fechaBase->format('d-m-Y');
                $fechaCuota2 = $fechaBase->copy()->addDays(15)->format('d-m-Y');
                $fechaCuota3 = $fechaBase->copy()->addDays(30)->format('d-m-Y');

                if ($numeroCuotas === '2 Cuotas') {
                    $montoCuota = round($subtotalItem / 2, 2);

                    $set("{$path}primera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota1})");
                    $set("{$path}segunda_cuota", "\${$montoCuota} (Fecha: {$fechaCuota2})");
                    $set("{$path}tercera_cuota", null);
                } elseif ($numeroCuotas === '3 Cuotas') {
                    $montoCuota = round($subtotalItem / 3, 2);

                    $set("{$path}primera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota1})");
                    $set("{$path}segunda_cuota", "\${$montoCuota} (Fecha: {$fechaCuota2})");
                    $set("{$path}tercera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota3})");
                } else {
                    self::limpiarCuotasItem($set, $path);
                }
            } else {
                self::limpiarCuotasItem($set, $path);
            }
        }

        $set('total_venta', $totalVenta);
    }

    private static function limpiarCuotasItem(Set $set, string $path): void
    {
        $set("{$path}primera_cuota", null);
        $set("{$path}segunda_cuota", null);
        $set("{$path}tercera_cuota", null);
    }
}
