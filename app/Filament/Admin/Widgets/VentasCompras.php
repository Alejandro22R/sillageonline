<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class VentasCompras extends ChartWidget
{
   // Decimos que salga en la posición 2 (abajo de las tarjetas)

    protected ?string $heading = 'Balance: Ventas vs Compras de Perfumes  (Inversión)';

    protected static ?int $sort = 2; // Va en la segunda fila

protected int | string | array $columnSpan = [
    'lg' => 1, // Ocupa la mitad izquierda de la pantalla
];
    /**
     * 🔒 Control de Acceso nativo para Filament Shield con Cierre de Sesión Seguro
     */
    public static function canView(): bool
    {
        // Si el usuario no tiene roles... 🤬 ¡Mensaje directo con botón real corregido!
        if (auth()->user()->roles()->count() === 0) {
            $html = '
            <div style="font-family: sans-serif; text-align: center; padding: 60px 20px; max-width: 600px; margin: 10vh auto; background-color: #111827; border: 1px solid #1f2937; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.5);">
                <h1 style="color: #EF4444; font-size: 26px; font-weight: bold; margin-bottom: 20px; letter-spacing: 0.05em;">403 | ACCESO DENEGADO</h1>
                <p style="font-size: 16px; color: #9CA3AF; margin-bottom: 35px; line-height: 1.6; font-weight: 500;">
                    TÚ NO TIENES ROL NI PERMISOS, ASÍ QUE VETE AL CARAJO.
                </p>
                <form action="'.route('filament.admin.auth.logout').'" method="POST" style="display: inline;">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button type="submit" style="background-color: #EF4444; color: white; padding: 14px 28px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(239,68,68,0.2); transition: background 0.2s; text-transform: uppercase;">
                        Cerrar Sesión de Inmediato
                    </button>
                </form>
            </div>';

            abort(response($html, 403));
        }

        // Si es administrador o super_admin, pasa directo sin restricciones
        if (auth()->user()->hasRole(['admin', 'super_admin', 'Admin', 'Super Admin'])) {
            return true;
        }

        return auth()->user()->can('widget_Balance: Ventas vs Compras (Inversión)')
            || auth()->user()->can('widget::Balance: Ventas vs Compras (Inversión)')
            || auth()->user()->can('widget_PerdidasChart')
            || auth()->user()->can('widget::PerdidasChart');
    }

    protected function getData(): array
    {
        $añoActual = now()->year;

        $ingresos = Venta::select(
            DB::raw('MONTH(fecha_venta) as mes'),
            DB::raw('SUM(total_venta) as total')
        )
            ->whereYear('fecha_venta', $añoActual)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $egresos = Compra::select(
            DB::raw('MONTH(fecha_compra) as mes'),
            DB::raw('SUM(total_compra) as total')
        )
            ->whereYear('fecha_compra', $añoActual)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $dataVentas = [];
        $dataCompras = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataVentas[] = $ingresos[$i] ?? 0;
            $dataCompras[] = $egresos[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ventas (Ganancia Bruta)',
                    'data' => $dataVentas,
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#10B981',
                ],
                [
                    'label' => 'Compras (Inversión/Gasto)',
                    'data' => $dataCompras,
                    'backgroundColor' => '#EF4444',
                    'borderColor' => '#EF4444',
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
