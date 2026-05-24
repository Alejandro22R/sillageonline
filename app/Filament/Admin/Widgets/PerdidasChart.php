<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class PerdidasChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Balance: Ventas vs Compras (Inversión)';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $añoActual = now()->year;

        // 1. Obtener Ingresos (Ventas) por mes
        $ingresos = Venta::select(
            DB::raw('MONTH(fecha_venta) as mes'),
            DB::raw('SUM(total_venta) as total')
        )
            ->whereYear('fecha_venta', $añoActual)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // 2. Obtener Egresos (Compras) por mes
        // Nota: Asegúrate de que el modelo se llame Compra o DetalleCompra según tu tabla
        $egresos = DB::table('detalle_compras')
            ->select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('SUM(subtotal) as total')
            )
            ->whereYear('created_at', $añoActual)
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
        return 'bar'; // En barras se nota mucho más cuando el rojo supera al verde
    }
}
