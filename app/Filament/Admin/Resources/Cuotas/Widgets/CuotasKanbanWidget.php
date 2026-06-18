<?php

namespace App\Filament\Admin\Resources\Cuotas\Widgets;

use App\Models\Cuota;
use Filament\Widgets\Widget;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class CuotasKanbanWidget extends Widget
{
    use WithPagination;

    protected int | string | array $columnSpan = 'full';

    public string $search = '';
    public string $filterEstado = '';
    public string $filterMetodo = '';

    public static function getView(): string
    {
        return 'filament.admin.resources.cuotas.widgets.cuotas-kanban-widget';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterEstado(): void
    {
        $this->resetPage();
    }

    public function updatingFilterMetodo(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function cuotas()
    {
        return Cuota::query()
            ->with([
                'detalleVenta.venta.cliente',
                'detalleVenta.producto',
            ])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->whereHas('detalleVenta.venta.cliente', fn ($q) =>
                        $q->where('nombre', 'like', "%{$this->search}%")
                          ->orWhere('cedula', 'like', "%{$this->search}%")
                    )->orWhereHas('detalleVenta.producto', fn ($q) =>
                        $q->where('name', 'like', "%{$this->search}%")
                    );
                });
            })
            ->when($this->filterEstado, fn ($q) => $q->where('estado', $this->filterEstado))
            ->when($this->filterMetodo, fn ($q) => $q->where('metodo_pago', $this->filterMetodo))
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'total'      => Cuota::count(),
            'pagadas'    => Cuota::where('estado', 'pagado')->count(),
            'pendientes' => Cuota::where('estado', 'pendiente')->count(),
            'recaudado'  => Cuota::where('estado', 'pagado')->sum('monto_cuota'),
        ];
    }

    #[Computed]
    public function progreso(): array
    {
        return Cuota::query()
            ->selectRaw('detalle_venta_id, MAX(cuota_pagada) as ultima_pagada')
            ->groupBy('detalle_venta_id')
            ->pluck('ultima_pagada', 'detalle_venta_id')
            ->toArray();
    }
}