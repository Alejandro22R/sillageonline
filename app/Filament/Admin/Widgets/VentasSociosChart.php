<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class VentasSociosChart extends ChartWidget
{
    protected ?string $heading = 'Ventas Mensuales por Socio (Perfumes y Recaudación)';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    // Por defecto muestra la cantidad de perfumes vendidos
    public ?string $filter = 'perfumes';

    protected function getFilters(): ?array
    {
        return [
            'perfumes' => '🧴 Cantidad de Perfumes Vendidos',
            'dolares'  => '💵 Total Recaudado ($ USD)',
        ];
    }

    public function getDescription(): ?string
    {
        return $this->filter === 'dolares'
            ? 'Dinero total recaudado en dólares ($ USD) por cada socio mes a mes'
            : 'Cantidad total de perfumes vendidos (unidades) por cada socio mes a mes';
    }

    protected function getData(): array
    {
        $year = now()->year;
        $socios = User::all(); // Deivys, Alejandro, Orlhey y Francisco

        if ($this->filter === 'dolares') {
            // Suma el dinero recaudado (total_venta) de la tabla ventas
            $registros = DB::table('ventas')
                ->whereYear('fecha_venta', $year)
                ->where('estado_pago', 'pagado')
                ->selectRaw('user_id, MONTH(fecha_venta) as mes, SUM(total_venta) as total')
                ->groupBy('user_id', 'mes')
                ->get();
        } else {
            // Suma la cantidad de perfumes vendidos (cantidad) de detalle_ventas
            $registros = DB::table('ventas')
                ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
                ->whereYear('ventas.fecha_venta', $year)
                ->where('ventas.estado_pago', 'pagado')
                ->selectRaw('ventas.user_id, MONTH(ventas.fecha_venta) as mes, SUM(detalle_ventas.cantidad) as total')
                ->groupBy('ventas.user_id', 'mes')
                ->get();
        }

        // Colores para los 4 socios combinados con el tema oscuro de Sillage
        $colores = [
            ['border' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.15)'], // Verde
            ['border' => '#3B82F6', 'bg' => 'rgba(59, 130, 246, 0.15)'], // Azul
            ['border' => '#F43F5E', 'bg' => 'rgba(244, 63, 94, 0.15)'],  // Rosa
            ['border' => '#EAB308', 'bg' => 'rgba(234, 179, 8, 0.15)'],  // Dorado
        ];

        $datasets = [];

        foreach ($socios as $index => $socio) {
            $datosPorMes = [];

            for ($mes = 1; $mes <= 12; $mes++) {
                $fila = $registros->first(
                    fn ($item) => (int) $item->user_id === (int) $socio->id && (int) $item->mes === $mes
                );

                $valor = $fila ? $fila->total : 0;
                $datosPorMes[] = ($this->filter === 'dolares') ? round((float) $valor, 2) : (int) $valor;
            }

            $estilo = $colores[$index % count($colores)];

            $datasets[] = [
                'label' => ucwords($socio->name),
                'data' => $datosPorMes,
                'borderColor' => $estilo['border'],
                'backgroundColor' => $estilo['bg'],
                'borderWidth' => 3,
                'fill' => true,
                'tension' => 0.4,
                'pointRadius' => 4,
                'pointHoverRadius' => 7,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => $this->filter === 'perfumes' ? 0 : 2,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
