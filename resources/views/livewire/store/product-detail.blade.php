<div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative">

    <livewire:store.header />

    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10 px-4 sm:px-6 lg:px-8 py-12">

        {{-- Imagen del producto --}}
        <div>
            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}"
                 class="w-full rounded-lg shadow-lg shadow-black/60 border border-white/10">
        </div>

        {{-- Información --}}
        <div>
            <h1 class="text-3xl font-bold text-[#D4AF37] mb-2">{{ $product->name }}</h1>
            <p class="text-gray-400 mb-6 uppercase tracking-widest text-xs">{{ $product->marca_perfume ?? '' }}</p>


                        {{-- Gráfico de Acordes --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-[#D4AF37] mb-4 uppercase tracking-wide">
                    Acordes Principales
                </h2>

                <div class="flex flex-col gap-1">
                    @foreach ($chords as $chord)
                        <div
                            class="h-9 flex items-center rounded-r-full shadow-md shadow-black/40 transition-all duration-700"
                            style="width: {{ max($chord->pivot->intensity, 30) }}%; min-width: 140px; background-color: {{ $chord->color }};"
                        >
                            <span class="w-full text-center text-white text-xs font-bold uppercase tracking-wide px-4 truncate">
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

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Notas de Salida</p>
                        <p class="text-white">{{ $topNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Notas de Corazón</p>
                        <p class="text-white">{{ $heartNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Notas de Fondo</p>
                        <p class="text-white">{{ $baseNotes->pluck('name')->implode(', ') ?: '—' }}</p>
                    </div>
                </div>
            </div>


            {{-- Precio y añadir al carrito --}}
            <div class="border-t border-white/10 pt-6">
                <p class="text-2xl font-light text-[#D4AF37] mb-4">
                    ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                </p>

                <button
                    wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })"
                    class="w-full bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black py-3 text-xs font-black uppercase tracking-[0.2em] transition-all duration-300"
                >
                    Añadir al carrito
                </button>
            </div>

        </div>
    </div>
</div>