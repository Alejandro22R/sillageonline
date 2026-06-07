<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class Gastos extends ChartWidget
{

    protected ?string $heading = 'Otros Gastos';


protected static ?int $sort = 2; // Mismo sort para ir en la misma fila

protected int | string | array $columnSpan = [
    'lg' => 1, // Ocupa la mitad derecha de la pantalla
];

    protected function getData(): array
    {
        // 1. Consultamos la base de datos agrupando por categoría y sumando los montos
        // Asumo que tu tabla se llama 'expenses'. Si se llama diferente, cambia ese nombre aquí.
        $data = DB::table('expenses')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // 2. Mapeamos las categorías de tu formulario con nombres limpios para el gráfico
        $labelsMapping = [
            'Mercancía'   => 'Compra de Inventario',
            'Publicidad'  => 'Marketing e Instagram',
            'Envío'       => 'Logística (Delivery)',
            'Operaciones' => 'Servicios o Alquiler',
            'Otros'       => 'Otros gastos',
        ];

        $labels = [];
        $totals = [];

        // 3. Llenamos los arrays que necesita Chart.js
        foreach ($data as $row) {
            $labels[] = $labelsMapping[$row->category] ?? $row->category;
            $totals[] = (float) $row->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Gastado ($)',
                    'data' => $totals,
                    // Colores modernos para el diseño de Dona
                    'backgroundColor' => [
                        '#36A2EB', // Azul - Mercancía
                        '#FF6384', // Rosado - Publicidad
                        '#FFCE56', // Amarillo - Envío
                        '#4BC0C0', // Verde menta - Operaciones
                        '#9966FF', // Morado - Otros
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
