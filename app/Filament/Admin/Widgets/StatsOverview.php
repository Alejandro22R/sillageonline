<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Product;
use App\Models\Proveedor;
use App\Models\Compra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    /**
     * 🔒 Control de Acceso nativo para Filament Shield
     */
    public static function canView(): bool
    {
        // Si el usuario no tiene roles, no puede ver el widget bajo ningún concepto
        if (auth()->user()->roles()->count() === 0) {
            return false;
        }

        // Si es administrador o super_admin, se salta la regla y lo ve directo
        if (auth()->user()->hasRole(['admin', 'super_admin', 'Admin', 'Super Admin'])) {
            return true;
        }

        // Comprueba si el rol tiene activada la casilla específica generada por Shield
        return auth()->user()->can('widget_StatsOverview')
            || auth()->user()->can('widget::StatsOverview');
    }

    protected function getStats(): array
    {
        return [
            // Contador de Clientes
            Stat::make('Clientes Registrados', Cliente::count())
                ->description('Total de base de datos')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            // Suma total de Ventas
            Stat::make('Ventas Totales', '$' . number_format(Venta::sum('total_venta'), 2))
                ->description('Ingresos acumulados')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // Suma del Stock de todos los productos
            Stat::make('Productos en Stock', Product::sum('stock'))
                ->description('Unidades disponibles')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            // Suma todos los proveedores registrados
            Stat::make('Proveedores Registrados', Proveedor::count())
                ->description('Total de proveedores únicos')
                ->descriptionIcon('heroicon-m-truck')
                ->color('danger'),

            // Suma total de todas las compras realizadas a proveedores
            Stat::make('Compras Totales', '$' . number_format(Compra::sum('total_compra'), 2))
                ->description('Gastos acumulados')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('original'),
        ];
    }
}
