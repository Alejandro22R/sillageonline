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
