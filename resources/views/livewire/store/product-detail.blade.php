<div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative">

    <style>
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

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="rounded-lg border border-t-2 border-t-[#D4AF37]/50 border-white/10 bg-white/[0.03] p-4 text-center">
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37]/70 font-bold mb-2">Notas de Salida</p>
                        <p class="text-sm text-gray-200 leading-relaxed">{{ $topNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
                    <div class="rounded-lg border border-t-2 border-t-[#D4AF37] border-white/10 bg-white/[0.03] p-4 text-center">
                        <p class="text-[10px] uppercase tracking-widest text-[#D4AF37] font-bold mb-2">Notas de Corazón</p>
                        <p class="text-sm text-gray-200 leading-relaxed">{{ $heartNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
                    <div class="rounded-lg border border-t-2 border-t-amber-800 border-white/10 bg-white/[0.03] p-4 text-center">
                        <p class="text-[10px] uppercase tracking-widest text-amber-700 font-bold mb-2">Notas de Fondo</p>
                        <p class="text-sm text-gray-200 leading-relaxed">{{ $baseNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
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
                    // El auto-scroll y el arrastre manual mueven la MISMA
                    // propiedad (scrollLeft del contenedor), nunca un
                    // transform aparte: mezclar los dos movimientos era lo
                    // que hacía que el carrusel 'desapareciera' al arrastrar
                    // manualmente hasta el final.
                    iniciarAuto() {
                        if (!{{ $suficientesParaLoop ? 'true' : 'false' }}) return;
                        const avanzar = () => {
                            const el = this.$refs.pista;
                            if (el && !this.pausado) {
                                el.scrollLeft += 0.6;
                                // La lista está duplicada, así que al pasar la
                                // mitad reiniciamos sin salto visible: lo que
                                // sigue es una copia idéntica de lo anterior.
                                const mitad = el.scrollWidth / 2;
                                if (el.scrollLeft >= mitad) {
                                    el.scrollLeft -= mitad;
                                }
                            }
                            requestAnimationFrame(avanzar);
                        };
                        requestAnimationFrame(avanzar);
                    },
                    interactuar() {
                        this.pausado = true;
                        clearTimeout(this.reanudarTimer);
                        // A los 5 segundos sin interacción, retoma el
                        // auto-scroll desde donde haya quedado (incluso si el
                        // usuario arrastró hasta el final de la lista).
                        this.reanudarTimer = setTimeout(() => { this.pausado = false }, 5000);
                    }
                }"
                x-init="iniciarAuto()"
                x-ref="pista"
                @touchstart="interactuar()"
                @touchmove="interactuar()"
                @mousedown="interactuar()"
                @wheel="interactuar()"
                class="{{ $suficientesParaLoop ? 'marquee-mask overflow-x-auto overflow-y-hidden hide-scroll' : '' }}"
                style="-webkit-overflow-scrolling: touch;"
            >
                <div class="flex gap-4 {{ $suficientesParaLoop ? '' : 'flex-wrap justify-center' }}">
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
