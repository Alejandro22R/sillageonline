<div style="padding: 0;">

    {{-- ── Stats row ── --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px;">
        @foreach ([
            ['label' => 'Total cuotas',  'value' => $this->stats['total'],      'color' => 'inherit'],
            ['label' => 'Pagadas',        'value' => $this->stats['pagadas'],    'color' => '#22c55e'],
            ['label' => 'Pendientes',     'value' => $this->stats['pendientes'], 'color' => '#f59e0b'],
            ['label' => 'Recaudado',      'value' => '$' . number_format($this->stats['recaudado'], 2), 'color' => 'inherit'],
        ] as $stat)
        <div style="background: color-mix(in srgb, currentColor 5%, transparent); border: 1px solid color-mix(in srgb, currentColor 15%, transparent); border-radius: 12px; padding: 16px 20px;">
            <p style="font-size: 12px; color: color-mix(in srgb, currentColor 50%, transparent); margin: 0 0 4px;">{{ $stat['label'] }}</p>
            <p style="font-size: 24px; font-weight: 600; color: {{ $stat['color'] }}; margin: 0;">{{ $stat['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Filtros ── --}}
    <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            placeholder="Buscar cliente, cédula o producto…"
            style="flex: 1; min-width: 200px; padding: 8px 14px; border: 1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius: 8px; font-size: 14px; background: color-mix(in srgb, currentColor 5%, transparent); color: inherit; outline: none;"
        />
        <select wire:model.live="filterEstado" style="padding: 8px 14px; border: 1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius: 8px; font-size: 14px; background: color-mix(in srgb, currentColor 5%, transparent); color: inherit; min-width: 160px;">
            <option value="">Todos los estados</option>
            <option value="pagado">Pagado</option>
            <option value="pendiente">Pendiente</option>
        </select>
        <select wire:model.live="filterMetodo" style="padding: 8px 14px; border: 1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius: 8px; font-size: 14px; background: color-mix(in srgb, currentColor 5%, transparent); color: inherit; min-width: 160px;">
            <option value="">Todos los métodos</option>
            <option value="Pago Movil">Pago Móvil</option>
            <option value="USDT">USDT</option>
            <option value="Zinli">Zinli</option>
            <option value="Wally">Wally</option>
            <option value="Cash">Cash</option>
            <option value="Zelle">Zelle</option>
        </select>
    </div>

    {{-- ── Grid de tarjetas ── --}}
    @if ($this->cuotas->isEmpty())
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 80px 0; text-align: center; opacity: 0.4;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:48px;height:48px;margin-bottom:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
            <p style="font-size: 14px;">No se encontraron cuotas con los filtros aplicados.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
            @foreach ($this->cuotas as $cuota)
                @php
                    $cliente        = $cuota->detalleVenta?->venta?->cliente;
                    $producto       = $cuota->detalleVenta?->producto;
                    $nombreCliente  = $cliente?->nombre ?? 'Sin cliente';
                    $nombreProducto = $producto?->name  ?? 'Sin producto';
                    $palabras       = explode(' ', $nombreCliente);
                    $iniciales      = strtoupper(substr($palabras[0] ?? 'X', 0, 1) . substr($palabras[1] ?? '', 0, 1));
                    $avatarColores  = [
                        ['bg' => '#ede9fe', 'text' => '#7c3aed'],
                        ['bg' => '#fef3c7', 'text' => '#b45309'],
                        ['bg' => '#ccfbf1', 'text' => '#0f766e'],
                        ['bg' => '#fce7f3', 'text' => '#be185d'],
                        ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                    ];
                    $color        = $avatarColores[$cuota->id % 5];
                    $totalCuotas  = (int) ($cuota->detalleVenta?->numero_cuota ?? 0);
                    $cuotaActual  = (int) $cuota->cuota_pagada;
                    $esPagada     = $cuota->estado === 'pagado';
                    $pagadasHasta = (int) ($this->progreso[$cuota->detalle_venta_id] ?? 0);
                    $ventaId      = str_pad($cuota->detalleVenta?->venta_id ?? 0, 6, '0', STR_PAD_LEFT);
                    $editUrl      = \App\Filament\Admin\Resources\Cuotas\CuotaResource::getUrl('edit', ['record' => $cuota]);
                @endphp

                <div style="background: color-mix(in srgb, currentColor 5%, transparent); border: 1px solid color-mix(in srgb, currentColor 12%, transparent); border-radius: 14px; padding: 20px;">

                    {{-- Cabecera --}}
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:16px;">
                        <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                            <div style="flex-shrink:0; width:40px; height:40px; border-radius:50%; background:{{ $color['bg'] }}; color:{{ $color['text'] }}; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600;">
                                {{ $iniciales }}
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:14px; font-weight:600; color:inherit; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $nombreCliente }}</p>
                                <p style="font-size:12px; opacity:0.5; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $nombreProducto }}</p>
                            </div>
                        </div>
                        @if ($esPagada)
                            <span style="flex-shrink:0; display:inline-flex; align-items:center; gap:5px; background:rgba(34,197,94,0.15); color:#22c55e; border:1px solid rgba(34,197,94,0.3); border-radius:99px; padding:3px 10px; font-size:11px; font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;"></span> Pagado
                            </span>
                        @else
                            <span style="flex-shrink:0; display:inline-flex; align-items:center; gap:5px; background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:99px; padding:3px 10px; font-size:11px; font-weight:500;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;"></span> Pendiente
                            </span>
                        @endif
                    </div>

                    {{-- Barra de progreso segmentada --}}
                    @if ($totalCuotas > 0)
                        <div style="margin-bottom:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span style="font-size:11px; opacity:0.5;">Progreso de cuotas</span>
                                <span style="font-size:11px; font-weight:500; opacity:0.8;">{{ $pagadasHasta }} / {{ $totalCuotas }}</span>
                            </div>
                            <div style="display:flex; gap:3px;">
                                @for ($i = 1; $i <= $totalCuotas; $i++)
                                    @if ($i < $cuotaActual)
                                        <div style="height:8px; flex:1; border-radius:99px; background:#22c55e;"></div>
                                    @elseif ($i === $cuotaActual)
                                        <div style="height:8px; flex:1; border-radius:99px; background:{{ $esPagada ? '#22c55e' : '#f59e0b' }};"></div>
                                    @else
                                        <div style="height:8px; flex:1; border-radius:99px; background:color-mix(in srgb, currentColor 15%, transparent);"></div>
                                    @endif
                                @endfor
                            </div>
                            <p style="margin-top:6px; font-size:11px; opacity:0.4;">Cuota {{ $cuotaActual }} de {{ $totalCuotas }}</p>
                        </div>
                    @endif

                    {{-- Detalles 2x2 --}}
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; border-top:1px solid color-mix(in srgb, currentColor 12%, transparent); padding-top:14px;">
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Monto pagado</p>
                            <p style="font-size:14px; font-weight:600; color:inherit; margin:0;">${{ number_format($cuota->monto_cuota, 2) }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Precio total</p>
                            <p style="font-size:14px; opacity:0.6; margin:0;">${{ number_format($cuota->precio_perfume ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Método</p>
                            <p style="font-size:14px; opacity:0.8; margin:0;">{{ $cuota->metodo_pago }}</p>
                        </div>
                        <div>
                            <p style="font-size:10px; text-transform:uppercase; letter-spacing:.05em; opacity:0.4; margin:0 0 2px;">Fecha</p>
                            <p style="font-size:14px; opacity:0.8; margin:0;">
                                {{ $cuota->fecha_pago ? \Carbon\Carbon::parse($cuota->fecha_pago)->translatedFormat('d M Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    @if ($cuota->descripcion)
                        <p style="margin-top:10px; font-size:12px; opacity:0.4; font-style:italic; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $cuota->descripcion }}">
                            "{{ $cuota->descripcion }}"
                        </p>
                    @endif

                    {{-- Footer --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-top:14px; padding-top:12px; border-top:1px solid color-mix(in srgb, currentColor 12%, transparent);">
                        <span style="font-family:monospace; font-size:11px; opacity:0.4;">Venta #{{ $ventaId }}</span>
                        <a href="{{ $editUrl }}" style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; font-size:12px; font-weight:500; color:inherit; border:1px solid color-mix(in srgb, currentColor 20%, transparent); border-radius:8px; text-decoration:none; background:transparent; opacity:0.7;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Editar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div style="margin-top: 24px;">
            {{ $this->cuotas->links() }}
        </div>
    @endif

</div>