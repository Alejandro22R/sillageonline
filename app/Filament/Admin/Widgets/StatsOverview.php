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
            Stat::make('Clientes Registrados', Cliente::count())
                ->description('Total de base de datos')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Ventas Totales', '$' . number_format(Venta::sum('total_venta'), 2))
                ->description('Ingresos acumulados')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Productos en Stock', Product::sum('stock'))
                ->description('Unidades disponibles')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Proveedores Registrados', Proveedor::count())
                ->description('Total de proveedores únicos')
                ->descriptionIcon('heroicon-m-truck')
                ->color('danger'),

            Stat::make('Compras Totales', '$' . number_format(Compra::sum('total_compra'), 2))
                ->description('Gastos acumulados')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('original'),
        ];
    }
}
