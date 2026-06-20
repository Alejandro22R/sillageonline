<div class="space-y-6">

    {{-- ── Stats row ── --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="px-4 py-3 bg-white shadow-sm rounded-xl dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total cuotas</p>
            <p class="mt-1 text-2xl font-semibold text-gray-950 dark:text-white">{{ $this->stats['total'] }}</p>
        </div>
        <div class="px-4 py-3 bg-white shadow-sm rounded-xl dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pagadas</p>
            <p class="mt-1 text-2xl font-semibold text-success-600 dark:text-success-400">{{ $this->stats['pagadas'] }}</p>
        </div>
        <div class="px-4 py-3 bg-white shadow-sm rounded-xl dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Pendientes</p>
            <p class="mt-1 text-2xl font-semibold text-warning-600 dark:text-warning-400">{{ $this->stats['pendientes'] }}</p>
        </div>
        <div class="px-4 py-3 bg-white shadow-sm rounded-xl dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Recaudado</p>
            <p class="mt-1 text-2xl font-semibold text-gray-950 dark:text-white">${{ number_format($this->stats['recaudado'], 2) }}</p>
        </div>
    </div>

    {{-- ── Filtros ── --}}
    <div class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[180px]">
            <x-filament::input.wrapper>
                <x-filament::input
                    wire:model.live.debounce.400ms="search"
                    type="text"
                    placeholder="Buscar cliente, cédula o producto…"
                />
            </x-filament::input.wrapper>
        </div>
        <div>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="pagado">Pagado</option>
                    <option value="pendiente">Pendiente</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
        <div>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filterMetodo">
                    <option value="">Todos los métodos</option>
                    <option value="Pago Movil">Pago Móvil</option>
                    <option value="USDT">USDT</option>
                    <option value="Zinli">Zinli</option>
                    <option value="Wally">Wally</option>
                    <option value="Cash">Cash</option>
                    <option value="Zelle">Zelle</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>

    {{-- ── Grid de tarjetas ── --}}
    @if ($this->cuotas->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center text-gray-400 dark:text-gray-500">
            <x-heroicon-o-banknotes class="w-12 h-12 mb-3 opacity-40" />
            <p class="text-sm">No se encontraron cuotas con los filtros aplicados.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($this->cuotas as $cuota)
                @php
                    $cliente        = $cuota->detalleVenta?->venta?->cliente;
                    $producto       = $cuota->detalleVenta?->producto;
                    $nombreCliente  = $cliente?->nombre ?? 'Sin cliente';
                    $nombreProducto = $producto?->name  ?? 'Sin producto';

                    $palabras  = explode(' ', $nombreCliente);
                    $iniciales = strtoupper(substr($palabras[0] ?? 'X', 0, 1) . substr($palabras[1] ?? '', 0, 1));

                    $avatarTonos = [
                        ['bg' => 'bg-purple-100 dark:bg-purple-900', 'text' => 'text-purple-700 dark:text-purple-300'],
                        ['bg' => 'bg-amber-100  dark:bg-amber-900',  'text' => 'text-amber-700  dark:text-amber-300'],
                        ['bg' => 'bg-teal-100   dark:bg-teal-900',   'text' => 'text-teal-700   dark:text-teal-300'],
                        ['bg' => 'bg-pink-100   dark:bg-pink-900',   'text' => 'text-pink-700   dark:text-pink-300'],
                        ['bg' => 'bg-blue-100   dark:bg-blue-900',   'text' => 'text-blue-700   dark:text-blue-300'],
                    ];
                    $tono = $avatarTonos[$cuota->id % 5];

                    $totalCuotas  = (int) ($cuota->detalleVenta?->numero_cuota ?? 0);
                    $cuotaActual  = (int) $cuota->cuota_pagada;
                    $esPagada     = $cuota->estado === 'pagado';
                    $pagadasHasta = (int) ($this->progreso[$cuota->detalle_venta_id] ?? 0);

                    $ventaId = str_pad($cuota->detalleVenta?->venta_id ?? 0, 6, '0', STR_PAD_LEFT);
                    $editUrl = \App\Filament\Admin\Resources\Cuotas\CuotaResource::getUrl('edit', ['record' => $cuota]);
                @endphp

                <div class="flex flex-col p-5 transition-shadow duration-200 bg-white shadow-sm rounded-xl dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10 hover:shadow-md">

                    {{-- Cabecera --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center min-w-0 gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full {{ $tono['bg'] }} {{ $tono['text'] }} flex items-center justify-center text-sm font-semibold">
                                {{ $iniciales }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate dark:text-white">{{ $nombreCliente }}</p>
                                <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ $nombreProducto }}</p>
                            </div>
                        </div>
                        @if ($esPagada)
                            <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full bg-success-50 dark:bg-success-900/30 px-2.5 py-1 text-xs font-medium text-success-700 dark:text-success-400 ring-1 ring-success-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-success-500"></span>Pagado
                            </span>
                        @else
                            <span class="flex-shrink-0 inline-flex items-center gap-1 rounded-full bg-warning-50 dark:bg-warning-900/30 px-2.5 py-1 text-xs font-medium text-warning-700 dark:text-warning-400 ring-1 ring-warning-600/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-warning-400"></span>Pendiente
                            </span>
                        @endif
                    </div>

                    {{-- Barra de progreso segmentada --}}
                    @if ($totalCuotas > 0)
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-gray-500 dark:text-gray-400">Progreso de cuotas</span>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $pagadasHasta }} / {{ $totalCuotas }}</span>
                            </div>
                            <div class="flex gap-1" role="progressbar" aria-valuenow="{{ $pagadasHasta }}" aria-valuemax="{{ $totalCuotas }}">
                                @for ($i = 1; $i <= $totalCuotas; $i++)
                                    @if ($i < $cuotaActual)
                                        <div class="flex-1 h-2 rounded-full bg-success-500 dark:bg-success-400"></div>
                                    @elseif ($i === $cuotaActual)
                                        <div class="h-2 flex-1 rounded-full {{ $esPagada ? 'bg-success-500 dark:bg-success-400' : 'bg-warning-400' }}"></div>
                                    @else
                                        <div class="flex-1 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                                    @endif
                                @endfor
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Cuota {{ $cuotaActual }} de {{ $totalCuotas }}</p>
                        </div>
                    @endif

                    {{-- Detalles --}}
                    <div class="grid grid-cols-2 pt-4 mt-auto border-t border-gray-100 gap-x-4 gap-y-3 dark:border-white/10">
                        <div>
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-wide">Monto pagado</p>
                            <p class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($cuota->monto_cuota, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-wide">Precio total</p>
                            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">${{ number_format($cuota->precio_perfume ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-wide">Método</p>
                            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-300">{{ $cuota->metodo_pago }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 uppercase tracking-wide">Fecha</p>
                            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-300">
                                {{ $cuota->fecha_pago ? \Carbon\Carbon::parse($cuota->fecha_pago)->format('d M Y') : '—' }}
                            </p>
                        </div>
                    </div>

                    {{-- Descripción --}}
                    @if ($cuota->descripcion)
                        <p class="mt-3 text-xs italic text-gray-400 truncate dark:text-gray-500" title="{{ $cuota->descripcion }}">
                            "{{ $cuota->descripcion }}"
                        </p>
                    @endif

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-3 mt-4 border-t border-gray-100 dark:border-white/10">
                        <span class="font-mono text-[11px] text-gray-400 dark:text-gray-500">Venta #{{ $ventaId }}</span>
                        <a href="{{ $editUrl }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-300 ring-1 ring-gray-950/10 dark:ring-white/10 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <x-heroicon-o-pencil class="w-3.5 h-3.5" />
                            Editar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $this->cuotas->links() }}
        </div>
    @endif

</div>
