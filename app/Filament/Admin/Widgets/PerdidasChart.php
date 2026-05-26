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
     * 🔒 Control de Acceso nativo para Filament Shield
     */
    public static function canView(): bool
    {
        // Si el usuario no tiene ningún rol asignado, no puede ver la gráfica
        if (auth()->user()->roles()->count() === 0) {
            return false;
        }

        // Si es administrador o super_admin, pasa directo sin restricciones
        if (auth()->user()->hasRole(['admin', 'super_admin', 'Admin', 'Super Admin'])) {
            return true;
        }

        // Comprueba las variantes del permiso del widget creadas por Filament Shield
        return auth()->user()->can('widget_Balance: Ventas vs Compras (Inversión)')
            || auth()->user()->can('widget::Balance: Ventas vs Compras (Inversión)')
            || auth()->user()->can('widget_PerdidasChart')
            || auth()->user()->can('widget::PerdidasChart');
    }

    protected function getData(): array
    {
        $añoActual = now()->year;

        // 1. Obtener Ingresos (Ventas) por mes usando 'fecha_venta'
        $ingresos = Venta::select(
            DB::raw('MONTH(fecha_venta) as mes'),
            DB::raw('SUM(total_venta) as total')
        )
            ->whereYear('fecha_venta', $añoActual)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // 2. Obtener Egresos (Compras) por mes usando 'fecha_compra'
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
                    'backgroundColor' => '#10B981', // Verde
                    'borderColor' => '#10B981',
                ],
                [
                    'label' => 'Compras (Inversión/Gasto)',
                    'data' => $dataCompras,
                    'backgroundColor' => '#EF4444', // Rojo
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
