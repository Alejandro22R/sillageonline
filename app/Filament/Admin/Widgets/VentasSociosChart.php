<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;


class VentasSociosChart extends ChartWidget
{
    protected ?string $heading = 'Rendimiento Mensual por Socio (Perfumes Vendidos)';

    // Lo ponemos en sort = 3 o 4 para que salga justo debajo de tus gráficos actuales
    protected static ?int $sort = 3;

    // Ancho completo para que los 12 meses se vean amplios y elegantes
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'monto';

    protected function getFilters(): ?array
    {
        return [
            'monto' => '💵 Ventas en Dólares ($ USD)',
            'frascos' => '🧴 Cantidad de Perfumes Vendidos',
            'exclusivos' => '💎 Solo Perfumes Exclusivos ($ USD)',
        ];
    }

    protected function getData(): array
    {
        $year = now()->year;
        $socios = User::all();

        if ($this->filter === 'frascos') {
            $registros = DB::table('ventas')
                ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
                ->whereYear('ventas.fecha_venta', $year)
                ->where('ventas.estado_pago', 'pagado')
                ->selectRaw('ventas.user_id, MONTH(ventas.fecha_venta) as mes, SUM(detalle_ventas.cantidad) as total')
                ->groupBy('ventas.user_id', 'mes')
                ->get();
        } elseif ($this->filter === 'exclusivos') {
            $registros = DB::table('ventas')
                ->join('detalle_ventas', 'ventas.id', '=', 'detalle_ventas.venta_id')
                ->join('products', 'detalle_ventas.product_id', '=', 'products.id')
                ->whereYear('ventas.fecha_venta', $year)
                ->where('ventas.estado_pago', 'pagado')
                ->where('products.is_exclusive', 1)
                ->selectRaw('ventas.user_id, MONTH(ventas.fecha_venta) as mes, SUM(detalle_ventas.subtotal) as total')
                ->groupBy('ventas.user_id', 'mes')
                ->get();
        } else {
            $registros = DB::table('ventas')
                ->whereYear('fecha_venta', $year)
                ->where('estado_pago', 'pagado')
                ->selectRaw('user_id, MONTH(fecha_venta) as mes, SUM(total_venta) as total')
                ->groupBy('user_id', 'mes')
                ->get();
        }

        // Paleta que combina con el verde, azul y rosa de tu Dashboard actual
        $colores = [
            ['border' => '#10B981', 'bg' => 'rgba(16, 185, 129, 0.15)'], // Verde (como tu barra de Ventas)
            ['border' => '#3B82F6', 'bg' => 'rgba(59, 130, 246, 0.15)'], // Azul (como tu dona de Logística)
            ['border' => '#F43F5E', 'bg' => 'rgba(244, 63, 94, 0.15)'],  // Rosa/Rojo (como tu dona de Marketing)
            ['border' => '#EAB308', 'bg' => 'rgba(234, 179, 8, 0.15)'],  // Dorado (como tu total de venta)
        ];

        $datasets = [];

        foreach ($socios as $index => $socio) {
            $datosPorMes = [];

            for ($mes = 1; $mes <= 12; $mes++) {
                $fila = $registros->first(
                    fn ($item) => (int) $item->user_id === (int) $socio->id && (int) $item->mes === $mes
                );
                $datosPorMes[] = $fila ? (float) $fila->total : 0;
            }

            $estilo = $colores[$index % count($colores)];

            $datasets[] = [
                'label' => ucwords($socio->name),
                'data' => $datosPorMes,
                'borderColor' => $estilo['border'],
                'backgroundColor' => $estilo['bg'],
                'borderWidth' => 3,
                'fill' => true,
                'tension' => 0.4, // Hace la curva suave y moderna
                'pointRadius' => 4,
                'pointHoverRadius' => 7,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
