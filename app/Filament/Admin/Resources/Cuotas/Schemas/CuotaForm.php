<?php

namespace App\Filament\Admin\Resources\Cuotas\Schemas;

use App\Models\Venta;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class CuotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('venta_id')
                    ->label('Venta')
                    ->options(function () {
                        return static::ventasDisponibles()
                            ->get()
                            ->mapWithKeys(fn (Venta $venta) => [
                                $venta->id => static::etiquetaVenta($venta),
                            ]);
                    })
                    ->getSearchResultsUsing(function (string $search) {
                        return static::ventasDisponibles()
                            ->whereHas('cliente', fn ($q) => $q->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%")
                                ->orWhere('cedula', 'like', "%{$search}%"))
                            ->get()
                            ->mapWithKeys(fn (Venta $venta) => [
                                $venta->id => static::etiquetaVenta($venta),
                            ]);
                    })
                    ->getOptionLabelUsing(fn ($value) => ($venta = Venta::find($value)) ? static::etiquetaVenta($venta) : null)
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),

                TextInput::make('monto_cuota')
                    ->label('Monto del abono')
                    ->numeric()
                    ->minValue(0.01)
                    ->prefix('$')
                    ->helperText(function (Get $get) {
                        $venta = Venta::find($get('venta_id'));

                        return $venta
                            ? 'Saldo pendiente de esta venta: $' . number_format($venta->saldo_pendiente, 2)
                            : null;
                    })
                    ->required(),

                Select::make('metodo_pago')
                    ->label('Método de Pago')
                    ->options([
                        'Pago Movil' => 'Pago Movil', 'USDT' => 'USDT', 'Zinli' => 'Zinli',
                        'Wally' => 'Wally', 'Cash' => 'Cash', 'Zelle' => 'Zelle',
                    ])
                    ->required(),

                DatePicker::make('fecha_pago')
                    ->label('Fecha del Pago')
                    ->default(now())
                    ->required(),

                TextInput::make('descripcion')
                    ->label('Descripción/Detalle')
                    ->placeholder('Ej: Segundo abono en efectivo'),
            ]);
    }

    /**
     * Un vendedor solo puede registrar abonos contra sus propias ventas.
     */
    protected static function ventasDisponibles()
    {
        return Venta::query()
            ->with('cliente')
            ->where('user_id', auth()->id())
            ->latest('fecha_venta');
    }

    protected static function etiquetaVenta(Venta $venta): string
    {
        $cliente = $venta->cliente ? "{$venta->cliente->nombre} {$venta->cliente->apellido}" : 'Sin cliente';

        return sprintf(
            'Venta #%s — %s — $%s',
            str_pad((string) $venta->id, 6, '0', STR_PAD_LEFT),
            $cliente,
            number_format((float) $venta->total_venta, 2),
        );
    }
}
