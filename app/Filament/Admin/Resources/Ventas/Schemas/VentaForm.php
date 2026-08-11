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
                        Hidden::make('primera_cuota')->dehydrated(true),

                        Placeholder::make('segunda_cuota_vista')
                            ->label('2da Cuota')
                            ->content(fn (Get $get) => $get('segunda_cuota') ?? 'Calculando...')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si')
                            ->columnSpan(4),
                        Hidden::make('segunda_cuota')->dehydrated(true),

                        Placeholder::make('tercera_cuota_vista')
                            ->label('3ra Cuota')
                            ->content(fn (Get $get) => $get('tercera_cuota') ?? 'Calculando...')
                            ->visible(fn (Get $get) => $get('pago_cuota') === 'Si' && $get('numero_cuota') === '3 Cuotas')
                            ->columnSpan(4),
                        Hidden::make('tercera_cuota')->dehydrated(true),
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

        $fechaBaseInput = $get('fecha_venta') ?? now();
        $fechaBase = Carbon::parse($fechaBaseInput);

        // Actualizamos las cuotas basándonos en el subtotal de cada ítem (o si prefieres repartir el recargo, esto mantiene la lógica proporcional por ítem o total)
        foreach ($detalles as $key => $item) {
            $subtotalItem = (float) ($item['subtotal'] ?? 0);
            $pagoCuota = $item['pago_cuota'] ?? 'No';
            $numeroCuotas = $item['numero_cuota'] ?? '';

            $path = "detalles.{$key}.";

            if ($pagoCuota === 'Si' && $subtotalItem > 0) {
                $fechaCuota1 = $fechaBase->format('d-m-Y');
                $fechaCuota2 = $fechaBase->copy()->addDays(15)->format('d-m-Y');
                $fechaCuota3 = $fechaBase->copy()->addDays(30)->format('d-m-Y');

                // Si quieres que el recargo de los $5 también afecte la cuota en caso de estar activo,
                // podemos prorratearlo o sumárselo al total general de la cuota. Aquí usamos el subtotal del ítem:
                $montoBaseCuota = $subtotalItem;

                // (Opcional) Si deseas sumar proporcionalmente los $5 del recargo global al ítem cuando aplique:
                if ($recargoGlobal === 'Si' && count($detalles) > 0) {
                    $montoBaseCuota += (5.0 / count($detalles));
                }

                if ($numeroCuotas === '2 Cuotas') {
                    $montoCuota = round($montoBaseCuota / 2, 2);

                    $set("{$path}primera_cuota", "\${$montoCuota} (Fecha: {$fechaCuota1})");
                    $set("{$path}segunda_cuota", "\${$montoCuota} (Fecha: {$fechaCuota2})");
                    $set("{$path}tercera_cuota", null);
                } elseif ($numeroCuotas === '3 Cuotas') {
                    $montoCuota = round($montoBaseCuota / 3, 2);

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
