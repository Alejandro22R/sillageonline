<?php

namespace App\Filament\Admin\Resources\Cuotas\Widgets;

use App\Models\Cuota;
use App\Models\Venta;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Contadores de la cartera de cobros del vendedor con sesión activa: cuántas
 * ventas tiene, cuántas ya cobró completas, cuántas le faltan, cuánto ha
 * recaudado en total y — lo nuevo que se pidió — cuánto saldo le falta por
 * consignar (lo que aún debe recaudar de sus ventas pendientes).
 */
class CuotasStatsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $baseQuery = fn () => Venta::query()->where('user_id', auth()->id());

        $totalVentas = $baseQuery()->count();
        $pagadas = $baseQuery()->where('estado_pago', 'pagado')->count();
        $pendientes = $baseQuery()->where('estado_pago', 'pendiente')->count();

        $recaudado = (float) Cuota::query()
            ->whereHas('venta', fn ($q) => $q->where('user_id', auth()->id()))
            ->sum('monto_cuota');

        $saldoAConsignar = (float) $baseQuery()
            ->where('estado_pago', 'pendiente')
            ->withSum('cuotas as total_pagado', 'monto_cuota')
            ->get()
            ->sum(fn (Venta $venta) => $venta->saldo_pendiente);

        return [
            Stat::make('Ventas en cartera', $totalVentas)
                ->description('Tuyas')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Pagadas', $pagadas)
                ->description('Ventas cobradas por completo')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pendientes', $pendientes)
                ->description('Ventas con saldo por cobrar')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Recaudado', '$' . number_format($recaudado, 2))
                ->description('Total abonado hasta ahora')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Saldo a consignar', '$' . number_format($saldoAConsignar, 2))
                ->description('Lo que aún falta por recaudar')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
