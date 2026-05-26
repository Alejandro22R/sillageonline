<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class PerdidasChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Balance: Ventas vs Compras (Inversión)';

    protected int | string | array $columnSpan = 'full';

    /**
     * 🔒 Control de Acceso nativo para Filament Shield con Cierre de Sesión Seguro
     */
    public static function canView(): bool
    {
        // Si el usuario no tiene roles... 🤬 ¡Mensaje directo con botón POST integrado!
        if (auth()->user()->roles()->count() === 0) {
            abort(403, 'TÚ NO TIENES ROL NI PERMISOS, ASÍ QUE VETE AL CARAJO.<br><br>
                <form action="'.route('filament.admin.auth.logout').'" method="POST" style="display: inline;">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <button type="submit" style="background-color: #EF4444; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: background 0.2s;">
                        Cerrar Sesión de Inmediato
                    </button>
                </form>'
            );
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
