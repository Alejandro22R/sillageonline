<div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative">

    <livewire:store.header />

    <div class="absolute top-0 left-[-10%] w-[500px] h-[500px] bg-[#D4AF37]/20 rounded-full blur-[150px] pointer-events-none"></div>

    <section class="relative h-[70vh] flex flex-col items-center justify-center text-center px-4">
        <div class="relative z-10 flex flex-col items-center">

            <img src="{{ asset('img/sillage.png') }}"
                 alt="Sillage Parfums Logo"
                 class="h-24 md:h-32 w-auto object-contain mb-8 animate-fade-in"
            >

            <p class="text-[#D4AF37] tracking-[0.4em] uppercase text-xs md:text-sm mb-4 font-bold">
                El Arte de la Perfumería Árabe
            </p>

            <h1 class="text-7xl md:text-9xl font-cinzel font-bold tracking-[0.1em] text-transparent bg-clip-text bg-gradient-to-b from-white via-gray-200 to-[#D4AF37] drop-shadow-2xl">
                Sillage
            </h1>

            <p class="mt-4 text-xl tracking-[0.6em] text-gray-400 uppercase font-light">
                Parfums
            </p>
        </div>
    </section>

    <main class="relative z-10 max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 pb-32 space-y-32">

        @if($products->isEmpty())
            <div class="text-center py-32 border border-[#D4AF37]/20 rounded-2xl bg-[#0A0A0A] backdrop-blur-md">
                <p class="text-2xl text-[#D4AF37] tracking-widest uppercase font-light">La colección se está preparando.</p>
            </div>
        @else

            @if($exclusivos->count() > 0)
            <section x-data="{
                scrollNext() { $refs.carouselExclusiva.scrollBy({ left: 350, behavior: 'smooth' }) },
                scrollPrev() { $refs.carouselExclusiva.scrollBy({ left: -350, behavior: 'smooth' }) }
            }">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="text-3xl md:text-5xl font-light uppercase tracking-widest border-l-2 border-[#D4AF37] pl-4">Colección <span class="font-bold text-[#D4AF37]">Exclusiva</span></h2>
                    <div class="hidden md:flex gap-4">
                        <button @click="scrollPrev" class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center hover:bg-[#D4AF37] hover:text-black transition-all text-[#D4AF37]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="scrollNext" class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center hover:bg-[#D4AF37] hover:text-black transition-all text-[#D4AF37]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <div x-ref="carouselExclusiva" class="flex gap-6 overflow-x-auto snap-x snap-mandatory hide-scroll pb-10">
                    @foreach($exclusivos as $product)
                        <div class="min-w-[280px] md:min-w-[320px] snap-center group relative flex flex-col justify-between rounded-2xl bg-[#0A0A0A] border border-white/10 hover:border-[#D4AF37]/50 transition-all duration-500 overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.8)] hover:-translate-y-2">
                            <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="block">
                                <div class="h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100 {{ $product->stock <= 0 ? 'grayscale' : '' }}">
                                    @endif
                                    @if($product->stock <= 0)
                                        <div class="absolute inset-0 bg-black/55 z-20"></div>
                                        <div class="absolute top-0 right-0 w-28 h-28 overflow-hidden z-30 pointer-events-none">
                                            <div class="absolute top-[18px] right-[-34px] w-[170px] rotate-45 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest text-center py-1 shadow-lg shadow-black/50 border-y border-white/20">
                                                Agotado
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4 bg-black/80 backdrop-blur-md text-[#D4AF37] text-[10px] font-bold px-3 py-1 uppercase tracking-widest border border-[#D4AF37]/30 rounded shadow-lg">
                                        Exclusiva
                                    </div>
                                </div>
                            </a>
                            <div class="p-6 flex flex-col flex-1 text-center">
                                <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#D4AF37]/90 mb-1 truncate">
                                    {{ $product->marca_perfume ?? 'Sillage' }}
                                </p>
                                <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="hover:text-[#D4AF37] transition-colors">
                                    <h3 class="text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                </a>
                                <p class="text-xl font-light text-[#D4AF37] mt-2 mb-6">${{ number_format($product->retail_price, 2) }}</p>

                                @if($product->stock > 0)
                                    <button wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" class="mt-auto w-full bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black py-3 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                        Añadir al carrito
                                    </button>
                                @else
                                    <button type="button" disabled class="mt-auto w-full bg-transparent border border-gray-700 text-gray-600 py-3 text-[10px] font-black uppercase tracking-[0.2em] cursor-not-allowed">
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            @if($ofertas->count() > 0)
            <section x-data="{
                scrollNext() { $refs.carouselOfertas.scrollBy({ left: 350, behavior: 'smooth' }) },
                scrollPrev() { $refs.carouselOfertas.scrollBy({ left: -350, behavior: 'smooth' }) }
            }">
                <div class="flex items-end justify-between mb-8">
                    <h2 class="text-3xl md:text-5xl font-light uppercase tracking-widest border-l-2 border-red-600 pl-4">Ofertas <span class="font-bold text-red-600">Especiales</span></h2>
                    <div class="hidden md:flex gap-4">
                        <button @click="scrollPrev" class="w-12 h-12 rounded-full border border-red-600/50 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="scrollNext" class="w-12 h-12 rounded-full border border-red-600/50 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                <div x-ref="carouselOfertas" class="flex gap-6 overflow-x-auto snap-x snap-mandatory hide-scroll pb-10">
                    @foreach($ofertas as $product)
                        <div class="min-w-[280px] md:min-w-[320px] snap-center group relative flex flex-col justify-between rounded-2xl bg-[#0A0A0A] border border-white/10 hover:border-red-600/50 transition-all duration-500 overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.8)] hover:-translate-y-2">
                            <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="block">
                                <div class="h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100 {{ $product->stock <= 0 ? 'grayscale' : '' }}">
                                    @endif
                                    @if($product->stock <= 0)
                                        <div class="absolute inset-0 bg-black/55 z-20"></div>
                                        <div class="absolute top-0 right-0 w-28 h-28 overflow-hidden z-30 pointer-events-none">
                                            <div class="absolute top-[18px] right-[-34px] w-[170px] rotate-45 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest text-center py-1 shadow-lg shadow-black/50 border-y border-white/20">
                                                Agotado
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4 z-20 bg-red-600 text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest rounded shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                                        Oferta
                                    </div>
                                </div>
                            </a>
                            <div class="p-6 flex flex-col flex-1 text-center">
                                <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#D4AF37]/90 mb-1 truncate">
                                    {{ $product->marca_perfume ?? 'Sillage' }}
                                </p>
                                <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="hover:text-red-500 transition-colors">
                                    <h3 class="text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                </a>

                                <div class="flex justify-center items-end gap-3 mt-2 mb-6">
                                    <span class="text-sm text-gray-500 line-through mb-1">
                                        ${{ number_format($product->retail_price, 2) }}
                                    </span>
                                    <span class="text-xl font-black text-red-500">
                                        ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                                    </span>
                                </div>

                                @if($product->stock > 0)
                                    <button wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" class="mt-auto w-full bg-transparent border border-red-600/50 text-red-500 hover:bg-red-600 hover:text-white py-3 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                        Aprovechar Oferta
                                    </button>
                                @else
                                    <button type="button" disabled class="mt-auto w-full bg-transparent border border-gray-700 text-gray-600 py-3 text-[10px] font-black uppercase tracking-[0.2em] cursor-not-allowed">
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            <section>
                <div class="mb-8 text-center">
                    <p class="text-[#D4AF37] tracking-[0.3em] uppercase text-xs mb-2 font-bold">Descubre Todas Nuestras Fragancias</p>
                    <h2 class="text-3xl md:text-5xl font-black uppercase tracking-widest text-white">Catálogo <span class="font-light">Completo</span></h2>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-12">
                    <span class="text-[10px] sm:text-xs uppercase tracking-widest text-gray-500 mr-1 sm:mr-2">Ordenar por</span>

                    <button
                        wire:click="setSort('name')"
                        wire:loading.attr="disabled"
                        class="px-4 sm:px-5 py-2 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border transition-all duration-300 {{ $sortBy === 'name' ? 'bg-[#D4AF37] text-black border-[#D4AF37]' : 'bg-transparent text-gray-400 border-white/10 hover:border-[#D4AF37]/50 hover:text-[#D4AF37]' }}"
                    >
                        Nombre A-Z
                    </button>

                    <button
                        wire:click="setSort('marca')"
                        wire:loading.attr="disabled"
                        class="px-4 sm:px-5 py-2 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border transition-all duration-300 {{ $sortBy === 'marca' ? 'bg-[#D4AF37] text-black border-[#D4AF37]' : 'bg-transparent text-gray-400 border-white/10 hover:border-[#D4AF37]/50 hover:text-[#D4AF37]' }}"
                    >
                        Marca
                    </button>
                </div>

                <div
                    wire:loading.class="opacity-30 scale-[0.98] pointer-events-none"
                    wire:target="setSort"
                    class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-8 transition-all duration-300 ease-out"
                >
                    @foreach($products as $product)
                        <div
                            wire:key="product-{{ $sortBy }}-{{ $product->id }}"
                            class="animate-card-in group relative flex flex-col justify-between rounded-2xl bg-[#0A0A0A] border border-white/10 hover:border-[#D4AF37]/50 transition-all duration-500 overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.8)] hover:-translate-y-2 h-full"
                            style="animation-delay: {{ min($loop->index * 40, 400) }}ms"
                        >

                            <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="block">
                                <div class="h-[200px] sm:h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100 {{ $product->stock <= 0 ? 'grayscale' : '' }}">
                                    @endif

                                    @if($product->stock <= 0)
                                        <div class="absolute inset-0 bg-black/55 z-20"></div>
                                        <div class="absolute top-0 right-0 w-20 sm:w-28 h-20 sm:h-28 overflow-hidden z-30 pointer-events-none">
                                            <div class="absolute top-[12px] sm:top-[18px] right-[-30px] sm:right-[-34px] w-[140px] sm:w-[170px] rotate-45 bg-red-600 text-white text-[8px] sm:text-[10px] font-black uppercase tracking-widest text-center py-0.5 sm:py-1 shadow-lg shadow-black/50 border-y border-white/20">
                                                Agotado
                                            </div>
                                        </div>
                                    @endif

                                    @if($product->is_offer)
                                        <div class="absolute top-2 sm:top-4 left-2 sm:left-4 bg-red-600 text-white text-[8px] sm:text-[10px] font-bold px-2 sm:px-2.5 py-0.5 uppercase tracking-widest rounded shadow-lg">Oferta</div>
                                    @elseif($product->is_exclusive)
                                        <div class="absolute top-2 sm:top-4 left-2 sm:left-4 bg-black/80 backdrop-blur-sm text-[#D4AF37] text-[8px] sm:text-[10px] font-bold px-2 sm:px-2.5 py-0.5 uppercase tracking-widest border border-[#D4AF37]/30 rounded shadow-lg">Exclusiva</div>
                                    @endif
                                </div>
                            </a>

                            <div class="p-3 sm:p-6 flex flex-col flex-1 text-center">
                                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.2em] sm:tracking-[0.25em] text-[#D4AF37]/90 mb-0.5 sm:mb-1 truncate">
                                    {{ $product->marca_perfume ?? 'Sillage' }}
                                </p>
                                <a href="{{ route('store.product', $product->slug) }}" wire:navigate class="hover:text-[#D4AF37] transition-colors">
                                    <h3 class="text-sm sm:text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                </a>

                                @if($product->is_offer)
                                    <div class="flex justify-center items-end gap-1 sm:gap-2 mt-1 sm:mt-2 mb-3 sm:mb-6">
                                        <span class="text-[10px] sm:text-xs text-gray-500 line-through mb-0.5 sm:mb-1">
                                            ${{ number_format($product->retail_price, 2) }}
                                        </span>
                                        <span class="text-base sm:text-xl font-black text-red-500">
                                            ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                                        </span>
                                    </div>
                                @else
                                    <p class="text-base sm:text-xl font-light text-[#D4AF37] mt-1 sm:mt-2 mb-3 sm:mb-6">
                                        ${{ number_format($product->retail_price, 2) }}
                                    </p>
                                @endif

                                @if($product->stock > 0)
                                    <button wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" class="mt-auto w-full bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black py-2 sm:py-3 text-[8px] sm:text-[10px] font-black uppercase tracking-[0.1em] sm:tracking-[0.2em] transition-all duration-300">
                                        Añadir
                                    </button>
                                @else
                                    <button type="button" disabled class="mt-auto w-full bg-transparent border border-gray-700 text-gray-600 py-2 sm:py-3 text-[8px] sm:text-[10px] font-black uppercase tracking-[0.1em] sm:tracking-[0.2em] cursor-not-allowed">
                                        Agotado
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        @endif
    </main>
</div>