{{--
    Perfil Olfativo (longevidad y estela) + Estaciones. Se incluye dos
    veces desde product-detail.blade.php: una para PC (debajo de la
    imagen, columna izquierda) y otra para teléfono (debajo de Uso
    Recomendado, al final), cada una mostrada/ocultada por CSS según el
    tamaño de pantalla, para no repetir el mismo bloque de código dos
    veces.
--}}

{{-- Perfil Olfativo: longevidad y estela --}}
@if ($product->longevidad_horas || $product->estela)
    <div class="mt-6">
        <h2 class="text-xl font-semibold text-[#D4AF37] mb-4 uppercase tracking-wide">
            Perfil Olfativo
        </h2>

        <div class="grid grid-cols-2 gap-3">
            @if ($product->longevidad_horas)
                <div class="rounded-lg border border-[#D4AF37]/30 bg-white/[0.03] p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-[#D4AF37] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37]/70">Longevidad</p>
                        <p class="text-sm font-bold text-[#D4AF37]">{{ $product->longevidad_horas }} h</p>
                    </div>
                </div>
            @endif
            @if ($product->estela)
                <div class="rounded-lg border border-[#D4AF37]/30 bg-white/[0.03] p-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-[#D4AF37] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0M3 14c1.5-1.5 3-1.5 4.5 0s3 1.5 4.5 0 3-1.5 4.5 0 3 1.5 4.5 0"/>
                    </svg>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37]/70">Estela</p>
                        <p class="text-sm font-bold text-[#D4AF37]">{{ $product->estela }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

{{-- Estaciones recomendadas --}}
@php
    $estaciones = [
        'temporada_invierno_pct'  => [
            'label' => 'Invierno',
            'color' => '#60A5FA',
            'icono' => 'M12 2v20M4.93 4.93l14.14 14.14M19.07 4.93L4.93 19.07',
        ],
        'temporada_primavera_pct' => [
            'label' => 'Primavera',
            'color' => '#4ADE80',
            'icono' => 'M12 10a2 2 0 100 4 2 2 0 000-4zM12 10V4M12 14v6M10 12H4m6 0h6',
        ],
        'temporada_verano_pct'    => [
            'label' => 'Verano',
            'color' => '#FACC15',
            'icono' => 'M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36l-1.42 1.42M7.06 16.94l-1.42 1.42m0-12.72l1.42 1.42M16.94 16.94l1.42 1.42M16 12a4 4 0 11-8 0 4 4 0 018 0z',
        ],
        'temporada_otono_pct'     => [
            'label' => 'Otoño',
            'color' => '#FB923C',
            'icono' => 'M12 21c-4-2-7-6-7-11a9 9 0 0114-7c3 3 3 8 0 12-2 2-4 3-7 6zM12 21V9',
        ],
    ];
@endphp
@if (collect(array_keys($estaciones))->contains(fn ($campo) => ($product->{$campo} ?? 0) > 0))
    <div class="mt-6">
        <h2 class="text-xl font-semibold text-[#D4AF37] mb-4 uppercase tracking-wide">
            Estaciones
        </h2>

        <div class="grid grid-cols-2 gap-3">
            @foreach ($estaciones as $campo => $info)
                @php $activa = ($product->{$campo} ?? 0) > 0; @endphp
                <div
                    class="flex items-center justify-between gap-2 rounded-lg px-4 py-3 font-bold uppercase text-xs tracking-wide"
                    style="{{ $activa
                        ? 'background-color:' . $info['color'] . ';color:#000;'
                        : 'background-color:rgba(255,255,255,0.05);color:rgba(255,255,255,0.3);' }}"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $info['icono'] }}"/>
                        </svg>
                        {{ $info['label'] }}
                    </span>
                    @if ($activa)
                        <span class="text-[11px] font-black">{{ $product->{$campo} }}%</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
