<div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative">

    <style>
        @keyframes marqueeScroll {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marqueeScroll 50s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
        .marquee-mask {
            mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        }
    </style>

    <livewire:store.header />

    {{-- Destellos dorados de fondo (mismo estilo que el catálogo) --}}
    <div class="absolute top-0 left-[-10%] w-[500px] h-[500px] bg-[#D4AF37]/20 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute pointer-events-none" style="bottom:-150px; right:-10%; width:450px; height:450px; background:rgba(212,175,55,0.15); border-radius:9999px; filter:blur(150px);"></div>

    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10 px-4 sm:px-6 lg:px-8 py-12 relative z-10">

        {{-- Imagen del producto --}}
        <div>
            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}"
                 class="w-full rounded-lg shadow-lg shadow-black/60 border border-white/10">
        </div>

        {{-- Información --}}
        <div>
            <h1 class="text-3xl font-bold text-[#D4AF37] mb-2">{{ $product->name }}</h1>
            <p class="text-gray-400 mb-6 uppercase tracking-widest text-xs">{{ $product->marca_perfume ?? '' }}</p>

            {{-- Precio: lo primero que se busca al entrar a una ficha de producto --}}
            <div class="mb-8 p-5 rounded-xl border border-[#D4AF37]/30 bg-gradient-to-br from-[#D4AF37]/10 to-transparent">
                <div class="flex items-end justify-between gap-4 flex-wrap">
                    <div class="flex items-end gap-3">
                        @if ($product->is_offer)
                            <span class="text-base text-gray-500 line-through mb-1">
                                ${{ number_format($product->retail_price, 2) }}
                            </span>
                            <span class="text-4xl sm:text-5xl font-black text-red-500 leading-none">
                                ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                            </span>
                        @else
                            <span class="text-4xl sm:text-5xl font-black text-[#D4AF37] leading-none drop-shadow-[0_0_20px_rgba(212,175,55,0.35)]">
                                ${{ number_format($product->retail_price, 2) }}
                            </span>
                        @endif
                    </div>

                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-green-400">
                            <span class="w-2 h-2 rounded-full bg-green-400"></span> Disponible
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-red-500">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Agotado
                        </span>
                    @endif
                </div>

                <button
                    wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                    @if ($product->stock <= 0) disabled @endif
                    class="mt-5 w-full py-3.5 text-xs font-black uppercase tracking-[0.2em] transition-all duration-300
                        {{ $product->stock > 0
                            ? 'bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black cursor-pointer'
                            : 'bg-transparent border border-gray-700 text-gray-600 cursor-not-allowed' }}"
                >
                    {{ $product->stock > 0 ? 'Añadir al carrito' : 'Agotado' }}
                </button>
            </div>

            {{-- Gráfico de Acordes --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-[#D4AF37] mb-4 uppercase tracking-wide">
                    Acordes Principales
                </h2>

                <div class="flex flex-col gap-1">
                    @foreach ($chords as $chord)
                        @php
                            // Brillo percibido del color de fondo (fórmula YIQ) para
                            // decidir si el texto va en negro o blanco: sobre fondos
                            // claros (crema, lavanda, amarillo pastel...) el texto
                            // blanco se pierde por completo.
                            $hexColor = ltrim($chord->color ?? '#000000', '#');
                            if (strlen($hexColor) === 3) {
                                $hexColor = $hexColor[0].$hexColor[0].$hexColor[1].$hexColor[1].$hexColor[2].$hexColor[2];
                            }
                            $r = hexdec(substr($hexColor, 0, 2) ?: '00');
                            $g = hexdec(substr($hexColor, 2, 2) ?: '00');
                            $b = hexdec(substr($hexColor, 4, 2) ?: '00');
                            $brillo = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
                            $textoOscuro = $brillo > 150;
                        @endphp
                        <div
                            class="h-9 flex items-center rounded-r-full shadow-md shadow-black/40 transition-all duration-700"
                            style="width: {{ max($chord->pivot->intensity, 30) }}%; min-width: 140px; background-color: {{ $chord->color }};"
                        >
                            <span class="w-full text-center {{ $textoOscuro ? 'text-black' : 'text-white' }} text-xs font-bold uppercase tracking-wide px-4 truncate">
                                {{ $chord->name }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pirámide Olfativa --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-[#D4AF37] mb-4 uppercase tracking-wide">
                    Pirámide Olfativa
                </h2>

                @php
                    // Cada etapa se dibuja igual: una tarjeta cuadrada con
                    // borde dorado por nota. Dentro se muestra, en este orden
                    // de prioridad, la imagen subida desde el admin (Notas
                    // Olfativas), luego el emoji de la nota, y si no hay
                    // ninguno de los dos, un ícono genérico según la etapa.
                    $etapasPiramide = [
                        ['label' => 'Notas de Salida',   'notas' => $topNotes,   'tipo' => 'salida'],
                        ['label' => 'Notas de Corazón',  'notas' => $heartNotes, 'tipo' => 'corazon'],
                        ['label' => 'Notas de Fondo',    'notas' => $baseNotes,  'tipo' => 'fondo'],
                    ];
                @endphp

                <div class="space-y-8">
                    @foreach ($etapasPiramide as $etapa)
                        <div>
                            <p class="text-sm text-gray-500 mb-3 uppercase tracking-widest">{{ $etapa['label'] }}</p>

                            @if ($etapa['notas']->isEmpty())
                                <p class="text-white/40 text-sm">—</p>
                            @else
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach ($etapa['notas'] as $nota)
                                        <div class="flex flex-col items-center text-center">
                                            <div class="w-full aspect-square rounded-xl border-2 border-[#D4AF37] overflow-hidden flex items-center justify-center bg-white shadow-md shadow-black/40">
                                                @if ($nota->image)
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($nota->image) }}"
                                                         alt="{{ $nota->name }}"
                                                         class="w-full h-full object-cover">
                                                @elseif ($nota->icon)
                                                    <span style="font-size:32px;line-height:1;">{{ $nota->icon }}</span>
                                                @elseif ($etapa['tipo'] === 'salida')
                                                    <svg class="w-8 h-8 text-[#D4AF37]" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2l1.6 5.2L19 9l-5.4 1.8L12 16l-1.6-5.2L5 9l5.4-1.8L12 2zM5 15l.8 2.6L8.4 18.4 5.8 19.2 5 22l-.8-2.8L1.6 18.4l2.6-.8L5 15zm14 0l.8 2.6 2.6.8-2.6.8L19 22l-.8-2.8-2.6-.8 2.6-.8L19 15z"/>
                                                    </svg>
                                                @elseif ($etapa['tipo'] === 'corazon')
                                                    <svg class="w-8 h-8 text-[#D4AF37]" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 21s-6.7-4.35-9.3-8.1C1 10.2 1.6 6.9 4.3 5.4c2.2-1.2 4.7-.5 6.2 1.4l1.5 1.9 1.5-1.9c1.5-1.9 4-2.6 6.2-1.4 2.7 1.5 3.3 4.8 1.6 7.5C18.7 16.65 12 21 12 21z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-8 h-8 text-[#D4AF37]" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2c1 3-3 4-3 7.5C9 12 10.5 13 12 13s3-1 3-3.5c0-1-.4-1.8-.9-2.6.9.4 3.4 2 3.4 5.6C17.5 16.4 15 19 12 19s-5.5-2.6-5.5-6.5C6.5 8 9 6.2 12 2z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="mt-2 font-bold uppercase tracking-wide text-white leading-tight" style="font-size:11px;">
                                                {{ $nota->name }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- Fragancias que pueden gustarte --}}
    @if ($relacionados->isNotEmpty())
        @php
            // Solo se duplica la lista para el efecto de loop infinito cuando
            // hay suficientes productos; con pocos, la repetición se nota y
            // se ve como una vista duplicada por error.
            $suficientesParaLoop = $relacionados->count() >= 8;
            $itemsCarrusel = $suficientesParaLoop ? $relacionados->concat($relacionados) : $relacionados;
        @endphp
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 relative z-10">
            <h2 class="text-base font-light uppercase tracking-widest border-l-2 border-[#D4AF37] pl-3 mb-4">
                Fragancias que <span class="font-bold text-[#D4AF37]">Pueden Gustarte</span>
            </h2>

            <div
                x-data="{
                    pausado: false,
                    reanudarTimer: null,
                    interactuar() {
                        this.pausado = true;
                        clearTimeout(this.reanudarTimer);
                        // A los 5 segundos sin interacción, retoma la animación
                        // automática justo donde iba (animation-play-state la
                        // reanuda sin saltos).
                        this.reanudarTimer = setTimeout(() => { this.pausado = false }, 5000);
                    }
                }"
                @touchstart="interactuar()"
                @touchmove="interactuar()"
                @mousedown="interactuar()"
                @wheel="interactuar()"
                @scroll="interactuar()"
                class="{{ $suficientesParaLoop ? 'marquee-mask overflow-x-auto overflow-y-hidden hide-scroll' : '' }}"
                style="-webkit-overflow-scrolling: touch;"
            >
                <div
                    class="flex gap-4 {{ $suficientesParaLoop ? 'w-max animate-marquee' : 'flex-wrap justify-center' }}"
                    @if ($suficientesParaLoop) :style="pausado ? 'animation-play-state: paused;' : ''" @endif
                >
                    @foreach ($itemsCarrusel as $sugerido)
                        <a
                            href="{{ route('store.product', $sugerido->slug) }}"
                            style="width: 150px; flex-shrink: 0;"
                            class="group flex flex-col rounded-xl bg-[#0A0A0A] border border-white/10 hover:border-[#D4AF37]/50 transition-all duration-500 overflow-hidden shadow-[0_6px_20px_rgba(0,0,0,0.7)]"
                        >
                            <div style="height: 150px; width: 100%;" class="overflow-hidden relative bg-[#111]">
                                @if ($sugerido->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($sugerido->image) }}" alt="{{ $sugerido->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                                         class="group-hover:scale-110 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                                @endif
                                <div class="absolute bottom-1.5 right-2 text-gray-400 text-[8px] uppercase tracking-widest font-bold drop-shadow-md">
                                    {{ $sugerido->marca_perfume ?? 'Sillage' }}
                                </div>
                            </div>
                            <div class="p-2.5 text-center">
                                <h3 class="text-[11px] font-black uppercase tracking-wide text-white truncate group-hover:text-[#D4AF37] transition-colors">
                                    {{ $sugerido->name }}
                                </h3>
                                <p class="text-sm font-light text-[#D4AF37] mt-1">
                                    ${{ number_format($sugerido->offer_price && $sugerido->is_offer ? $sugerido->offer_price : $sugerido->retail_price, 2) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
