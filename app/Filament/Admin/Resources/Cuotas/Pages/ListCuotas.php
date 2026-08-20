<?php

namespace App\Filament\Admin\Resources\Cuotas\Pages;

use App\Filament\Admin\Resources\Cuotas\CuotaResource;
use App\Models\Cuota;
use App\Models\Venta;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\HtmlString;
use Livewire\WithPagination;

/**
 * La cartera de cobros del vendedor con sesión activa: una tarjeta por
 * venta suya, con lo recaudado, el saldo pendiente y acciones para
 * registrar abonos. No se usa el Table Builder de Filament aquí porque
 * termina renderizando las tarjetas dentro de una tabla — esto es una
 * vista propia con las Actions de Filament solo para los modales.
 */
class ListCuotas extends Page
{
    use WithPagination;

    protected static string $resource = CuotaResource::class;

    protected string $view = 'filament.admin.resources.cuotas.list-cuotas';

    public string $search = '';

    public string $filterEstado = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterEstado(): void
    {
        $this->resetPage();
    }

    /**
     * Únicamente las ventas del usuario con sesión activa, sin excepción.
     */
    public function ventas(): LengthAwarePaginator
    {
        return Venta::query()
            ->where('user_id', auth()->id())
            ->with(['cliente', 'detalles.producto'])
            ->withCount('cuotas')
            ->withSum('cuotas as total_pagado', 'monto_cuota')
            ->when($this->search, function ($query) {
                $query->whereHas('cliente', function ($q) {
                    $q->where('nombre', 'like', "%{$this->search}%")
                        ->orWhere('apellido', 'like', "%{$this->search}%")
                        ->orWhere('cedula', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterEstado, fn ($query) => $query->where('estado_pago', $this->filterEstado))
            ->latest('fecha_venta')
            ->paginate(9);
    }

    /**
     * Trae el último pago registrado de cada venta de la página actual, para
     * mostrarlo en la tarjeta (método, fecha, descripción) sin hacer una
     * consulta N+1 por tarjeta.
     */
    public function ultimosPagos(LengthAwarePaginator $ventas): array
    {
        $ventaIds = collect($ventas->items())->pluck('id');

        return Cuota::query()
            ->whereIn('venta_id', $ventaIds)
            ->orderByDesc('fecha_pago')
            ->orderByDesc('id')
            ->get()
            ->unique('venta_id')
            ->keyBy('venta_id')
            ->toArray();
    }

    protected function getViewData(): array
    {
        $ventas = $this->ventas();

        return [
            'ventas' => $ventas,
            'ultimosPagos' => $this->ultimosPagos($ventas),
        ];
    }

    public function registrarPagoAction(): Action
    {
        return Action::make('registrarPago')
            ->label('Registrar pago')
            ->icon('heroicon-o-banknotes')
            ->color('success')
            ->modalHeading(fn (array $arguments) => 'Registrar pago — Venta #'
                . str_pad((string) ($arguments['venta'] ?? ''), 6, '0', STR_PAD_LEFT))
            ->fillForm(function (array $arguments): array {
                $venta = $this->ventaDelVendedor($arguments['venta']);

                return ['monto_cuota' => $venta->saldo_pendiente];
            })
            ->schema([
                TextInput::make('monto_cuota')
                    ->label('Monto del abono')
                    ->numeric()
                    ->minValue(0.01)
                    ->prefix('$')
                    ->required(),

                Select::make('metodo_pago')
                    ->label('Método de pago')
                    ->options([
                        'Pago Movil' => 'Pago Movil', 'USDT' => 'USDT', 'Zinli' => 'Zinli',
                        'Wally' => 'Wally', 'Cash' => 'Cash', 'Zelle' => 'Zelle',
                    ])
                    ->required(),

                DatePicker::make('fecha_pago')
                    ->label('Fecha del pago')
                    ->default(now())
                    ->required(),

                TextInput::make('descripcion')
                    ->label('Descripción/Detalle')
                    ->placeholder('Ej: Segundo abono en efectivo'),
            ])
            ->action(function (array $arguments, array $data): void {
                $venta = $this->ventaDelVendedor($arguments['venta']);

                Cuota::create([
                    'venta_id' => $venta->id,
                    'monto_cuota' => $data['monto_cuota'],
                    'metodo_pago' => $data['metodo_pago'],
                    'fecha_pago' => $data['fecha_pago'],
                    'descripcion' => $data['descripcion'] ?? null,
                ]);

                Notification::make()->title('Pago registrado')->success()->send();
            });
    }

    public function historialAction(): Action
    {
        return Action::make('historial')
            ->label('Ver historial')
            ->icon('heroicon-o-clock')
            ->color('gray')
            ->modalHeading(fn (array $arguments) => 'Historial de pagos — Venta #'
                . str_pad((string) ($arguments['venta'] ?? ''), 6, '0', STR_PAD_LEFT))
            ->modalContent(function (array $arguments) {
                $venta = $this->ventaDelVendedor($arguments['venta'])->loadMissing('cuotas.registradoPor');

                return $this->historialHtml($venta);
            })
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Cerrar');
    }

    /**
     * Construye el HTML del historial de pagos directamente aquí (sin una
     * vista .blade.php aparte), para no depender de la resolución de una
     * segunda vista.
     */
    protected function historialHtml(Venta $venta): HtmlString
    {
        $filas = '';

        foreach ($venta->cuotas->sortByDesc('fecha_pago') as $cuota) {
            $fecha = $cuota->fecha_pago?->translatedFormat('d M Y');

            $filas .= '<tr style="border-bottom:1px solid color-mix(in srgb, currentColor 10%, transparent);">'
                . '<td style="padding:8px 12px 8px 0;">' . e($cuota->numero_cuota) . '</td>'
                . '<td style="padding:8px 12px 8px 0;">' . e($fecha) . '</td>'
                . '<td style="padding:8px 12px 8px 0; font-weight:600;">$' . number_format($cuota->monto_cuota, 2) . '</td>'
                . '<td style="padding:8px 12px 8px 0;">' . e($cuota->metodo_pago ?? '—') . '</td>'
                . '<td style="padding:8px 12px 8px 0;">' . e($cuota->registradoPor?->name ?? '—') . '</td>'
                . '<td style="padding:8px 0; opacity:0.6;">' . e($cuota->descripcion ?? '—') . '</td>'
                . '</tr>';
        }

        $tabla = $venta->cuotas->isEmpty()
            ? '<p style="text-align:center; padding:24px 0; opacity:0.5; font-size:14px;">Todavía no se ha registrado ningún abono para esta venta.</p>'
            : '<div style="overflow-x:auto;"><table style="width:100%; font-size:13px; border-collapse:collapse;">'
                . '<thead><tr style="text-align:left; text-transform:uppercase; font-size:11px; opacity:0.5; border-bottom:1px solid color-mix(in srgb, currentColor 15%, transparent);">'
                . '<th style="padding:0 12px 8px 0;">#</th>'
                . '<th style="padding:0 12px 8px 0;">Fecha</th>'
                . '<th style="padding:0 12px 8px 0;">Monto</th>'
                . '<th style="padding:0 12px 8px 0;">Método</th>'
                . '<th style="padding:0 12px 8px 0;">Registrado por</th>'
                . '<th style="padding:0;">Descripción</th>'
                . '</tr></thead><tbody>' . $filas . '</tbody></table></div>';

        $html = '<div style="display:flex; flex-direction:column; gap:16px;">'
            . '<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; text-align:center;">'
            . '<div style="border:1px solid color-mix(in srgb, currentColor 15%, transparent); border-radius:10px; padding:12px;">'
            . '<p style="font-size:11px; opacity:0.5; margin:0 0 4px;">Total venta</p>'
            . '<p style="font-size:16px; font-weight:600; margin:0;">$' . number_format($venta->total_venta, 2) . '</p></div>'
            . '<div style="border:1px solid color-mix(in srgb, currentColor 15%, transparent); border-radius:10px; padding:12px;">'
            . '<p style="font-size:11px; opacity:0.5; margin:0 0 4px;">Recaudado</p>'
            . '<p style="font-size:16px; font-weight:600; color:#22c55e; margin:0;">$' . number_format($venta->total_pagado, 2) . '</p></div>'
            . '<div style="border:1px solid color-mix(in srgb, currentColor 15%, transparent); border-radius:10px; padding:12px;">'
            . '<p style="font-size:11px; opacity:0.5; margin:0 0 4px;">Saldo pendiente</p>'
            . '<p style="font-size:16px; font-weight:600; color:' . ($venta->saldo_pendiente > 0 ? '#f59e0b' : 'inherit') . '; margin:0;">$' . number_format($venta->saldo_pendiente, 2) . '</p></div>'
            . '</div>'
            . $tabla
            . '</div>';

        return new HtmlString($html);
    }

    public function marcarPagadaAction(): Action
    {
        return Action::make('marcarPagada')
            ->label('Cambiar estado de la venta')
            ->requiresConfirmation()
            ->modalHeading(function (array $arguments) {
                $venta = $this->ventaDelVendedor($arguments['venta']);

                return $venta->esta_pagada ? 'Reabrir venta' : 'Marcar venta como pagada';
            })
            ->action(function (array $arguments): void {
                $venta = $this->ventaDelVendedor($arguments['venta']);

                $venta->update(['estado_pago' => $venta->esta_pagada ? 'pendiente' : 'pagado']);
            });
    }

    /**
     * Vuelve a verificar la propiedad de la venta en el servidor: los
     * argumentos de una Action llegan desde el navegador y no hay que
     * confiar en ellos, aunque la tarjeta que los dispara ya sea del
     * vendedor correcto.
     */
    protected function ventaDelVendedor(int|string $ventaId): Venta
    {
        return Venta::where('user_id', auth()->id())->findOrFail($ventaId);
    }
}
