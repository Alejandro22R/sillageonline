<div>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>

    <div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative"
         x-data="{ isScrolled: false }" 
         @scroll.window="isScrolled = (window.pageYOffset > 100)">
        
        <div class="bg-black border-b border-[#D4AF37]/30 text-center py-2 text-[10px] sm:text-xs tracking-widest text-[#D4AF37] uppercase z-50 relative">
            <a href="#" class="hover:text-white transition-colors underline underline-offset-4 decoration-[#D4AF37]/50">Atención al cliente lunes a domingo de 7:00 am a 8:00 pm</a>
        </div>

        <nav class="bg-[#050505]/80 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    <div class="flex-1 flex items-center">
    <a href="/" class="flex items-center gap-3 group">
        <img src="{{ asset('img/sillage.png') }}" 
             alt="Sillage Logo" 
             class="h-10 sm:h-12 w-auto object-contain transition-transform group-hover:scale-105"
        >
        
        <div class="flex flex-col">
            <span class="text-xl sm:text-2xl font-cinzel font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-[#D4AF37]">
                Sillage
            </span>
            <span class="text-[8px] tracking-[0.4em] uppercase text-gray-500 font-light -mt-1">
                Parfums
            </span>
        </div>
    </a>
</div>

                    <div class="flex-1 flex items-center justify-center relative z-50">
                        <div class="relative w-full max-w-md">
                            
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-[#D4AF37]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            
                            <input 
                                wire:model.live.debounce.300ms="search"
                                type="text" 
                                class="block w-full pl-10 pr-4 py-2.5 border border-white/10 rounded-full bg-[#111] text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] text-sm transition-all shadow-inner" 
                                placeholder="Busca tu fragancia favorita..."
                            >

                            @if(strlen($search) >= 2)
                                <div class="absolute top-full left-0 right-0 mt-3 bg-[#0A0A0A] border border-[#D4AF37]/40 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.9)] overflow-hidden z-[100]">
                                    @if($searchResults->count() > 0)
                                        <div class="max-h-[350px] overflow-y-auto hide-scroll p-2">
                                            @foreach($searchResults as $result)
                                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-white/5 transition-colors group">
                                                    <div class="w-12 h-12 rounded bg-[#111] border border-white/10 overflow-hidden flex-shrink-0">
                                                        @if($result->image)
                                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($result->image) }}" class="w-full h-full object-cover">
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="flex-1 min-w-0 text-left">
                                                        <p class="text-sm font-bold text-white truncate group-hover:text-[#D4AF37] transition-colors">{{ $result->name }}</p>
                                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $result->brand }}</p>
                                                    </div>

                                                    <div class="text-right flex-shrink-0 flex flex-col items-end">
                                                        <p class="text-[#D4AF37] font-bold text-sm mb-1">${{ number_format($result->offer_price ?? $result->retail_price, 2) }}</p>
                                                        <button wire:click="addToCart({{ $result->id }})" class="text-[9px] uppercase tracking-widest font-bold border border-[#D4AF37] text-[#D4AF37] px-2 py-1 rounded hover:bg-[#D4AF37] hover:text-black transition-colors">
                                                            Añadir
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="p-6 text-center">
                                            <svg class="w-8 h-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                            <p class="text-sm text-gray-400">No encontramos resultados para "<span class="text-white">{{ $search }}</span>"</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 flex items-center justify-end space-x-4 sm:space-x-6">
                        <div class="flex items-center space-x-4 text-gray-300">
                            <button class="hover:text-[#D4AF37] transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative hover:text-[#D4AF37] transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span class="absolute -top-2 -right-2 bg-[#D4AF37] text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-lg">
                                        {{ $cartCount }}
                                    </span>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-4 w-80 bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl shadow-2xl z-[100] p-4" style="display:none;">
                                    <h3 class="text-[#D4AF37] text-xs font-bold uppercase mb-4 tracking-widest">Carrito de Compras</h3>
                                    <div class="max-h-60 overflow-y-auto hide-scroll space-y-4">
                                        @foreach(session('cart', []) as $item)
                                            <div class="flex justify-between text-xs border-b border-white/5 pb-2">
                                                <span class="text-white uppercase">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                                <span class="text-[#D4AF37] font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($cartCount > 0)
                                        <button wire:click="checkoutWhatsApp" class="w-full bg-[#D4AF37] text-black mt-4 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest">Pedir por WhatsApp</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="hidden lg:block h-8 w-px bg-gray-800"></div>

                        <a href="/admin/products" class="p-2 rounded-full border border-gray-800 hover:border-[#D4AF37] transition-colors bg-[#111]">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    </div>

                </div>
            </div>
        </nav>

        <div x-cloak 
             x-show="isScrolled" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-12"
             class="fixed bottom-6 right-6 sm:bottom-10 sm:right-10 z-[110]">
            
            <div x-data="{ openCart: false }" class="relative" @click.away="openCart = false">
                
                <div x-cloak x-show="openCart"
                     x-transition:enter="transition ease-out duration-200 origin-bottom-right"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150 origin-bottom-right"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute bottom-full right-0 mb-6 w-[320px] sm:w-[400px] bg-[#0A0A0A] border-2 border-[#D4AF37]/40 rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.9)] overflow-hidden">
                    
                    <div class="p-5 border-b border-white/10 flex justify-between items-center bg-[#111]">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <h3 class="text-[#D4AF37] text-sm font-black uppercase tracking-widest">Mi Carrito</h3>
                        </div>
                        <button @click="openCart = false" class="text-gray-400 hover:text-[#D4AF37] transition-colors p-1 bg-white/5 rounded-full">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="max-h-[350px] overflow-y-auto hide-scroll p-5 space-y-5">
                        @php $cart = session('cart', []); @endphp
                        @forelse($cart as $id => $item)
                            <div class="flex justify-between items-center text-sm border-b border-white/5 pb-4">
                                <div class="flex-1 pr-4">
                                    <p class="font-bold text-white uppercase tracking-wider">{{ $item['name'] }}</p>
                                    <p class="text-gray-400 text-xs mt-1">Cantidad: <span class="text-white font-bold">{{ $item['quantity'] }}</span></p>
                                </div>
                                <p class="text-[#D4AF37] font-bold text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                        @empty
                            <div class="py-10 text-center flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <p class="text-gray-500 text-xs italic uppercase tracking-widest">Tu carrito está vacío</p>
                            </div>
                        @endforelse
                    </div>

                    @if(count($cart) > 0)
                        <div class="p-5 bg-gradient-to-t from-black to-transparent border-t border-white/10">
                            <div class="flex justify-between items-end mb-5">
                                <span class="text-xs uppercase text-gray-400 tracking-widest">Total a pagar</span>
                                <span class="text-2xl font-black text-white">${{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)), 2) }}</span>
                            </div>
                            <button wire:click="checkoutWhatsApp" class="w-full bg-[#D4AF37] text-black py-4 rounded-xl text-xs font-black uppercase tracking-[0.2em] hover:bg-white hover:scale-[1.02] active:scale-95 transition-all shadow-[0_0_20px_rgba(212,175,55,0.4)]">
                                Enviar pedido por WhatsApp
                            </button>
                        </div>
                    @endif
                </div>

                <button @click="openCart = !openCart" 
                        class="w-16 h-16 sm:w-20 sm:h-20 bg-[#D4AF37] rounded-full flex items-center justify-center shadow-[0_10px_35px_rgba(212,175,55,0.5)] hover:scale-110 active:scale-95 transition-all relative border-[3px] border-black group">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-black group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 sm:-top-1 sm:-right-1 bg-black text-[#D4AF37] text-xs sm:text-sm font-black px-2.5 py-1 rounded-full border-2 border-[#D4AF37] shadow-lg">
                            {{ $cartCount }}
                        </span>
                    @endif
                </button>
            </div>
        </div>

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
                                <div class="h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100">
                                    @endif
                                    <div class="absolute top-4 left-4 bg-black/80 backdrop-blur-md text-[#D4AF37] text-[10px] font-bold px-3 py-1 uppercase tracking-widest border border-[#D4AF37]/30 rounded shadow-lg">
                                        Exclusiva
                                    </div>
                                    <div class="absolute bottom-4 right-4 text-gray-400 text-[10px] uppercase tracking-widest font-bold drop-shadow-md">
                                        {{ $product->brand ?? 'Sillage' }}
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-1 text-center">
                                    <h3 class="text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                    <p class="text-xl font-light text-[#D4AF37] mt-2 mb-6">${{ number_format($product->retail_price, 2) }}</p>
                                    
                                    <button wire:click="addToCart({{ $product->id }})" class="mt-auto w-full bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black py-3 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                        Añadir al carrito
                                    </button>
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
                                <div class="h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100">
                                    @endif
                                    <div class="absolute top-4 left-4 z-20 bg-red-600 text-white text-[10px] font-black px-3 py-1 uppercase tracking-widest rounded shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                                        Oferta
                                    </div>
                                    <div class="absolute bottom-4 right-4 text-gray-400 text-[10px] uppercase tracking-widest font-bold drop-shadow-md">
                                        {{ $product->brand ?? 'Sillage' }}
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-1 text-center">
                                    <h3 class="text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                    
                                    <div class="flex justify-center items-end gap-3 mt-2 mb-6">
                                        <span class="text-sm text-gray-500 line-through mb-1">
                                            ${{ number_format($product->retail_price, 2) }}
                                        </span>
                                        <span class="text-xl font-black text-red-500">
                                            ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                                        </span>
                                    </div>
                                    
                                    <button wire:click="addToCart({{ $product->id }})" class="mt-auto w-full bg-transparent border border-red-600/50 text-red-500 hover:bg-red-600 hover:text-white py-3 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                        Aprovechar Oferta
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <section>
                    <div class="mb-12 text-center">
                        <p class="text-[#D4AF37] tracking-[0.3em] uppercase text-xs mb-2 font-bold">Descubre Todas Nuestras Fragancias</p>
                        <h2 class="text-3xl md:text-5xl font-black uppercase tracking-widest text-white">Catálogo <span class="font-light">Completo</span></h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                        @foreach($products as $product)
                            <div class="group relative flex flex-col justify-between rounded-2xl bg-[#0A0A0A] border border-white/10 hover:border-[#D4AF37]/50 transition-all duration-500 overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.8)] hover:-translate-y-2 h-full">
                                <div class="h-[320px] w-full overflow-hidden relative bg-[#111]">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100">
                                    @endif
                                    @if($product->is_offer)
                                        <div class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-bold px-2.5 py-0.5 uppercase tracking-widest rounded shadow-lg">Oferta</div>
                                    @elseif($product->is_exclusive)
                                        <div class="absolute top-4 left-4 bg-black/80 backdrop-blur-sm text-[#D4AF37] text-[10px] font-bold px-2.5 py-0.5 uppercase tracking-widest border border-[#D4AF37]/30 rounded shadow-lg">Exclusiva</div>
                                    @endif

                                    <div class="absolute bottom-4 right-4 text-gray-400 text-[10px] uppercase tracking-widest font-bold drop-shadow-md">
                                        {{ $product->brand ?? 'Sillage' }}
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-1 text-center">
                                    <h3 class="text-lg font-black uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                    
                                    @if($product->is_offer)
                                        <div class="flex justify-center items-end gap-2 mt-2 mb-6">
                                            <span class="text-xs text-gray-500 line-through mb-1">
                                                ${{ number_format($product->retail_price, 2) }}
                                            </span>
                                            <span class="text-xl font-black text-red-500">
                                                ${{ number_format($product->offer_price ?? $product->retail_price, 2) }}
                                            </span>
                                        </div>
                                    @else
                                        <p class="text-xl font-light text-[#D4AF37] mt-2 mb-6">
                                            ${{ number_format($product->retail_price, 2) }}
                                        </p>
                                    @endif
                                    
                                    <button wire:click="addToCart({{ $product->id }})" class="mt-auto w-full bg-transparent border border-[#D4AF37]/50 text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black py-3 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                        Añadir al carrito
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

            @endif
        </main>
    </div>
</div>