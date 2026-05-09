<div>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen bg-[#050505] text-white font-sans selection:bg-[#D4AF37] selection:text-black overflow-x-hidden relative">
        
        <!-- ========================================== -->
        <!-- HEADER / NAVEGACIÓN PROFESIONAL -->
        <!-- ========================================== -->
        
        <!-- Barra de Anuncios Superior -->
        <div class="bg-black border-b border-[#D4AF37]/30 text-center py-2 text-[10px] sm:text-xs tracking-widest text-[#D4AF37] uppercase z-50 relative">
            <a href="#" class="hover:text-white transition-colors underline underline-offset-4 decoration-[#D4AF37]/50">Atención al cliente lunes a domingo de 7:00 am a 8:00 pm</a>
        </div>

        <!-- Navbar Principal -->
        <nav class="bg-[#050505]/80 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
            <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    <!-- 1. Buscador (Izquierda) -->
                    <div class="flex-1 flex items-center">
                        <div class="relative w-full max-w-xs hidden md:block">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-800 rounded-full leading-5 bg-[#111] text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] text-sm transition-all shadow-inner" placeholder="Busca aquí">
                        </div>
                    </div>

                    <!-- 2. Logo (Centro) -->
                    <div class="flex-shrink-0 flex items-center justify-center flex-1">
                        <span class="text-3xl sm:text-4xl font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-[#D4AF37] cursor-pointer">
                            SILLAGE
                        </span>
                    </div>

                    <!-- 3. Íconos y Usuario (Derecha) -->
                    <div class="flex-1 flex items-center justify-end space-x-4 sm:space-x-6">
                        
                        <div class="flex items-center space-x-4 text-gray-300">
                            <!-- Favoritos -->
                            <button class="hover:text-[#D4AF37] transition-colors relative group">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-[#D4AF37] text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity border border-[#D4AF37]/30 whitespace-nowrap z-50">Favoritos</span>
                            </button>

                            <!-- Regalos -->
                            <button class="hover:text-[#D4AF37] transition-colors relative group">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                                <span class="absolute -bottom-10 left-1/2 -translate-x-1/2 bg-black text-[#D4AF37] text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity border border-[#D4AF37]/30 whitespace-nowrap z-50">Regalos</span>
                            </button>

                            <!-- Carrito con Menú Desplegable -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative hover:text-[#D4AF37] transition-colors group">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span class="absolute -top-2 -right-2 bg-[#D4AF37] text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-[0_0_10px_rgba(212,175,55,0.5)]">
                                        {{ $cartCount }}
                                    </span>
                                </button>

                                <!-- Desplegable del Carrito -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute right-0 mt-4 w-72 sm:w-80 bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.8)] z-[100] overflow-hidden"
                                     style="display: none;">
                                    
                                    <div class="p-4 border-b border-white/10 text-center">
                                        <h3 class="text-[#D4AF37] text-[11px] font-bold uppercase tracking-[0.2em]">Resumen de Pedido</h3>
                                    </div>

                                    <div class="max-h-64 overflow-y-auto hide-scroll p-4 space-y-4">
                                        @php $cart = session('cart', []); @endphp
                                        @forelse($cart as $id => $item)
                                            <div class="flex justify-between items-center text-[11px] border-b border-white/5 pb-3">
                                                <div class="flex-1 pr-4">
                                                    <p class="font-bold text-white uppercase">{{ $item['name'] }}</p>
                                                    <p class="text-gray-500">{{ $item['brand'] ?? 'Sillage' }} x{{ $item['quantity'] }}</p>
                                                </div>
                                                <p class="text-[#D4AF37] font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>
                                        @empty
                                            <div class="text-center py-6">
                                                <p class="text-gray-500 text-[10px] italic uppercase tracking-widest">El carrito está vacío</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    @if(count($cart) > 0)
                                        <div class="p-5 bg-white/5">
                                            <div class="flex justify-between items-center mb-5">
                                                <span class="text-[10px] uppercase text-gray-400">Total Estimado</span>
                                                <span class="text-xl font-bold text-white">${{ number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)), 2) }}</span>
                                            </div>
                                            
                                            <button wire:click="checkoutWhatsApp" class="w-full bg-[#D4AF37] text-black py-3 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-white transition-all shadow-[0_0_20px_rgba(212,175,55,0.2)]">
                                                Pedir por WhatsApp
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Divisor Vertical -->
                        <div class="hidden lg:block h-8 w-px bg-gray-800"></div>

                        <!-- Iniciar Sesión -->
                        <a href="/admin" class="flex items-center space-x-3 cursor-pointer group">
                            <div class="p-2 rounded-full border border-gray-800 group-hover:border-[#D4AF37] transition-colors bg-[#111]">
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-[#D4AF37] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-[10px] text-gray-500 leading-none tracking-wide">Bienvenido</p>
                                <p class="text-sm font-bold text-white group-hover:text-[#D4AF37] transition-colors leading-tight">Iniciar sesión</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ========================================== -->
        <!-- SECCIÓN HERO Y CONTENIDO -->
        <!-- ========================================== -->

        <div class="absolute top-0 left-[-10%] w-[500px] h-[500px] bg-[#D4AF37]/20 rounded-full blur-[150px] pointer-events-none"></div>

        <section class="relative h-[70vh] flex flex-col items-center justify-center text-center px-4" 
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 150)">
            
            <div class="relative z-10 transform transition-all duration-1000 ease-out" 
                 :class="show ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'">
                <p class="text-[#D4AF37] tracking-[0.4em] uppercase text-sm md:text-base mb-6 font-bold">
                    El Arte de la Perfumería Árabe
                </p>
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black uppercase tracking-[0.1em] text-transparent bg-clip-text bg-gradient-to-b from-white via-gray-200 to-[#D4AF37] drop-shadow-[0_0_30px_rgba(212,175,55,0.3)]">
                    Sillage
                </h1>
                <p class="mt-4 text-xl tracking-[0.6em] text-gray-400 uppercase font-light">
                    Parfums
                </p>
            </div>
        </section>

        <main class="relative z-10 max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
            @if($products->isEmpty())
                <div class="text-center py-32 border border-[#D4AF37]/20 rounded-2xl bg-white/5 backdrop-blur-md">
                    <p class="text-2xl text-[#D4AF37] tracking-widest uppercase font-light">La colección se está preparando.</p>
                </div>
            @else
                <div class="mb-24" x-data="{ 
                    scrollNext() { $refs.carousel.scrollBy({ left: 350, behavior: 'smooth' }) },
                    scrollPrev() { $refs.carousel.scrollBy({ left: -350, behavior: 'smooth' }) }
                }">
                    <div class="flex items-end justify-between mb-8">
                        <h2 class="text-3xl md:text-5xl font-light uppercase tracking-widest border-l-2 border-[#D4AF37] pl-4">
                            Colección <span class="font-bold text-[#D4AF37]">Exclusiva</span>
                        </h2>
                        <div class="hidden md:flex gap-4">
                            <button @click="scrollPrev" class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center hover:bg-[#D4AF37] hover:text-black transition-all text-[#D4AF37]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click="scrollNext" class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center hover:bg-[#D4AF37] hover:text-black transition-all text-[#D4AF37]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div x-ref="carousel" class="flex gap-6 overflow-x-auto snap-x snap-mandatory hide-scroll pb-10">
                        @foreach($products as $product)
                            <div class="min-w-[280px] md:min-w-[320px] snap-center group relative rounded-2xl bg-gradient-to-b from-white/5 to-transparent border border-white/10 hover:border-[#D4AF37]/50 transition-all duration-500 overflow-hidden backdrop-blur-sm shadow-2xl hover:-translate-y-2">
                                <div class="h-[350px] w-full overflow-hidden relative bg-black/50">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[#D4AF37]/30 tracking-widest text-xs uppercase">Sin imagen</div>
                                    @endif
                                    <div class="absolute top-4 left-4 bg-black/60 backdrop-blur-md text-[#D4AF37] text-[10px] px-4 py-1.5 uppercase tracking-[0.2em] border border-[#D4AF37]/30 rounded-full">
                                        {{ $product->brand ?? 'Sillage' }}
                                    </div>
                                </div>
                                <div class="p-6 text-center">
                                    <h3 class="text-xl font-bold uppercase tracking-widest text-white truncate">{{ $product->name }}</h3>
                                    <p class="text-2xl font-light text-[#D4AF37] mt-2 mb-6">${{ number_format($product->retail_price, 2) }}</p>
                                    
                                    <button wire:click="addToCart({{ $product->id }})" class="w-full relative overflow-hidden group/btn bg-transparent border border-[#D4AF37] text-[#D4AF37] py-3 tracking-[0.2em] text-xs font-bold uppercase transition-all duration-300">
                                        <span class="relative z-10 group-hover/btn:text-black transition-colors duration-300">Añadir al carrito</span>
                                        <div class="absolute inset-0 h-full w-0 bg-[#D4AF37] transition-all duration-300 ease-out group-hover/btn:w-full z-0"></div>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>