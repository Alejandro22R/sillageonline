<x-filament-panels::page>

    @livewire(\App\Filament\Admin\Resources\Cuotas\Widgets\CuotasStatsWidget::class)

    {{-- ── Filtros ── --}}
    <div style="display: flex; gap: 12px; margin: 24px 0; flex-wrap: wrap;">
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            placeholder="Buscar cliente o cédula…"
            style="flex: 1; min-width: 200px; padding: 8px 14px; border: 1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius: 8px; font-size: 14px; background: color-mix(in srgb, currentColor 5%, transparent); color: inherit; outline: none;"
        />
        <select wire:model.live="filterEstado" style="padding: 8px 14px; border: 1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius: 8px; font-size: 14px; background: color-mix(in srgb, currentColor 5%, transparent); color: inherit; min-width: 160px;">
            <option value="">Todos los estados</option>
            <option value="pagado">Pagada</option>
            <option value="pendiente">Pendiente</option>
        </select>
    </div>

    {{-- ── Grid de tarjetas ── --}}
    @if ($ventas->isEmpty())
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 80px 0; text-align: center; opacity: 0.4;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;margin-bottom:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
            <p style="font-size: 14px;">No tienes ventas {{ $filterEstado || $search ? 'con esos filtros' : 'registradas todavía' }}.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px;">
            @foreach ($ventas as $venta)
                @php
                    $cliente = $venta->cliente;
                    $nombreCliente = $cliente ? "{$cliente->nombre} {$cliente->apellido}" : 'Sin cliente';
                    $palabras = explode(' ', $nombreCliente);
                    $iniciales = strtoupper(substr($palabras[0] ?? 'X', 0, 1) . substr($palabras[1] ?? '', 0, 1));
                    $avatarColores = [
                        ['bg' => '#ede9fe', 'text' => '#7c3aed'],
                        ['bg' => '#fef3c7', 'text' => '#b45309'],
                        ['bg' => '#ccfbf1', 'text' => '#0f766e'],
                        ['bg' => '#fce7f3', 'text' => '#be185d'],
                        ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                    ];
                    $color = $avatarColores[$venta->id % 5];
                    $esPagada = $venta->estado_pago === 'pagado';
                    $totalVenta = (float) $venta->total_venta;
                    $totalPagado = (float) ($venta->total_pagado ?? 0);
                    $saldoPendiente = max(0, $totalVenta - $totalPagado);
                    $porcentaje = $esPagada ? 100 : ($totalVenta > 0 ? min(100, round($totalPagado / $totalVenta * 100)) : 0);
                    $ultimoPago = $ultimosPagos[$venta->id] ?? null;
                    $ventaCodigo = str_pad((string) $venta->id, 6, '0', STR_PAD_LEFT);
                @endphp

                <div style="background: color-mix(in srgb, currentColor 5%, transparent); border: 1px solid color-mix(in srgb, currentColor 12%, transparent); border-radius: 14px; padding: 20px; display: flex; flex-direction: column;">

                    {{-- Cabecera --}}
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:16px;">
                        <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                            <div style="flex-shrink:0; width:40px; height:40px; border-radius:50%; background:{{ $color['bg'] }}; color:{{ $color['text'] }}; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600;">
                                {{ $iniciales }}
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:14px; font-weight:600; color:inherit; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $nombreCliente }}</p>
                                <p style="font-size:12px; opacity:0.5; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    Venta #{{ $ventaCodigo }} — {{ $venta->detalles->count() }} {{ \Illuminate\Support\Str::plural('producto', $venta->detalles->count()) }}
                                </p>
                            </div>
                        </div>
                        @if ($esPagada)
                            <span style="flex-shrink:0; display:inline-flex; align-items:center; gap:5px; background:rgba(34,197,94,0.15); color:#22c55e; border:1px solid rgba(34,197,94,0.3); border-radius:99px; padding:3px 10px; font-size:11px; font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;"></span> Pagada
                            </span>
                        @else
                            <span style="flex-shrink:0; display:inline-flex; align-items:center; gap:5px; background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:99px; padding:3px 10px; font-size:11px; font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;"></span> Pendiente
                            </span>
                        @endif
                    </div>

                    {{-- Perfumes de esta venta --}}
                    @if ($venta->detalles->isNotEmpty())
                        <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:16px;">
                            @foreach ($venta->detalles as $detalle)
                                <span style="font-size:11px; padding:3px 8px; border-radius:6px; background:color-mix(in srgb, currentColor 8%, transparent); border:1px solid color-mix(in srgb, currentColor 15%, transparent); color:inherit;">
                                    {{ $detalle->producto->name ?? 'Producto eliminado' }}
                                    @if ($detalle->producto?->marca_perfume)
                                        <span style="opacity:0.5;"> — {{ $detalle->producto->marca_perfume }}</span>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Progreso de pago --}}
                    <div style="margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:11px; opacity:0.5;">Progreso de pago</span>
                            <span style="font-size:11px; font-weight:500; opacity:0.8;">{{ $porcentaje }}%</span>
                        </div>
                        <div style="height:8px; border-radius:99px; background:color-mix(in srgb, currentColor 15%, transparent); overflow:hidden;">
                            <div style="height:100%; width:{{ $porcentaje }}%; border-radius:99px; background:{{ $esPagada ? '#22c55e' : '#f59e0b' }};"></div>
                        </div>
                    </div>

                    {{-- Detalles 2x2 --}}
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; border-top:1px solid color-mix(in srgb, currentColor 12%, transparent); padding-top:14px;">
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Monto pagado</p>
                            <p style="font-size:14px; font-weight:600; color:#22c55e; margin:0;">${{ number_format($totalPagado, 2) }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Saldo pendiente</p>
                            <p style="font-size:14px; font-weight:600; color:{{ $saldoPendiente > 0 ? '#f59e0b' : 'inherit' }}; margin:0;">${{ number_format($saldoPendiente, 2) }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Último método</p>
                            <p style="font-size:14px; opacity:0.8; margin:0;">{{ $ultimoPago['metodo_pago'] ?? '—' }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Última fecha</p>
                            <p style="font-size:14px; opacity:0.8; margin:0;">
                                {{ isset($ultimoPago['fecha_pago']) ? \Carbon\Carbon::parse($ultimoPago['fecha_pago'])->translatedFormat('d M Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    @if (!empty($ultimoPago['descripcion']))
                        <p style="margin-top:10px; font-size:12px; opacity:0.4; font-style:italic; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $ultimoPago['descripcion'] }}">
                            "{{ $ultimoPago['descripcion'] }}"
                        </p>
                    @endif

                    {{-- Footer / acciones --}}
                    <div style="display:flex; align-items:center; flex-wrap:wrap; gap:8px; margin-top:14px; padding-top:12px; border-top:1px solid color-mix(in srgb, currentColor 12%, transparent);">
                        <x-filament::button
                            size="xs"
                            color="success"
                            icon="heroicon-o-banknotes"
                            wire:click="mountAction('registrarPago', { venta: {{ $venta->id }} })"
                        >
                            Registrar pago
                        </x-filament::button>

                        <x-filament::button
                            size="xs"
                            color="gray"
                            icon="heroicon-o-clock"
                            wire:click="mountAction('historial', { venta: {{ $venta->id }} })"
                        >
                            Historial
                        </x-filament::button>

                        <x-filament::button
                            size="xs"
                            :color="$esPagada ? 'gray' : 'primary'"
                            :icon="$esPagada ? 'heroicon-o-arrow-uturn-left' : 'heroicon-o-check-circle'"
                            wire:click="mountAction('marcarPagada', { venta: {{ $venta->id }} })"
                        >
                            {{ $esPagada ? 'Reabrir' : 'Marcar pagada' }}
                        </x-filament::button>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 24px;">
            {{ $ventas->links() }}
        </div>
    @endif

    <x-filament-actions::modals />
</x-filament-panels::page>
