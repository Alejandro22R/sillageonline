<div x-data="{ isScrolled: false }" @scroll.window="isScrolled = (window.pageYOffset > 100)">
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }

        .search-dropdown {
            position: fixed;
            top: 84px;
            left: 0;
            width: 100%;
            background: #0A0A0A;
            border-bottom: 1px solid rgba(212,175,55,0.3);
            border-radius: 0;
            box-shadow: 0 20px 50px rgba(0,0,0,0.9);
            overflow: hidden;
            z-index: 9999;
        }

        @media (min-width: 768px) {
            .search-dropdown {
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: 50vw !important;
                border: 1px solid rgba(212,175,55,0.4) !important;
                border-radius: 1rem !important;
            }
        }
    </style>

    <div class="bg-black border-b border-[#D4AF37]/30 text-center py-2 text-[10px] sm:text-xs tracking-widest text-[#D4AF37] uppercase z-50 relative">
        <a href="#" class="hover:text-white transition-colors underline underline-offset-4 decoration-[#D4AF37]/50">Atención al cliente lunes a domingo de 7:00 am a 8:00 pm</a>
    </div>

    <nav class="bg-[#050505]/80 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-2 sm:gap-4">

                <div class="flex-none flex items-center">
                    <a href="/" wire:navigate class="flex items-center gap-1.5 sm:gap-3 group">
                        <img src="{{ asset('img/sillage.png') }}"
                             alt="Sillage Logo"
                             class="h-8 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105"
                        >
                        <div class="flex flex-col">
                            <span class="text-base sm:text-2xl font-cinzel font-bold tracking-[0.15em] sm:tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-[#D4AF37]">
                                Sillage
                            </span>
                            <span class="text-[6px] sm:text-[8px] tracking-[0.4em] uppercase text-gray-500 font-light -mt-1">
                                Parfums
                            </span>
                        </div>
                    </a>
                </div>

                <div class="flex-1 max-w-md relative z-50 mx-1 sm:mx-0">
                    <div class="relative w-full">

                        <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                            <svg class="h-3.5 w-3.5 text-[#D4AF37]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            class="block w-full pl-9 pr-3 py-2 border border-white/10 rounded-full bg-[#111] text-gray-200 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-[#D4AF37] focus:border-[#D4AF37] text-xs md:text-sm transition-all shadow-inner"
                            placeholder="Buscar fragancia..."
                        >

                        @if(strlen($search) >= 2)

                            <div class="search-dropdown">
                                @if($searchResults->count() > 0)
                                    <div style="max-height:60vh; overflow-y:auto; padding:12px;">
                                        @foreach($searchResults as $result)
                                            <a href="{{ route('store.product', $result->slug) }}" wire:navigate class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-colors group">
                                                <div class="w-12 h-12 rounded bg-[#111] border border-white/10 overflow-hidden flex-shrink-0">
                                                    @if($result->image)
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($result->image) }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0 text-left">
                                                    <p class="text-sm font-bold text-white truncate group-hover:text-[#D4AF37] transition-colors">{{ $result->name }}</p>
                                                    <p class="text-[9px] text-gray-400 uppercase tracking-widest truncate">{{ $result->marca_perfume ?? $result->brand }}</p>
                                                </div>
                                                <div class="text-right flex-shrink-0 flex flex-col items-end">
                                                    <p class="text-[#D4AF37] font-bold text-sm mb-1">${{ number_format($result->offer_price ?? $result->retail_price, 2) }}</p>
                                                    <button type="button" wire:click.stop.prevent="addToCart({{ $result->id }})" class="text-[9px] uppercase tracking-widest font-black border border-[#D4AF37] text-[#D4AF37] px-2.5 py-1 rounded hover:bg-[#D4AF37] hover:text-black transition-colors">
                                                        Añadir
                                                    </button>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div style="padding:32px; text-align:center;">
                                        <p class="text-xs text-gray-400">No hay resultados para "<span class="text-white">{{ $search }}</span>"</p>
                                    </div>
                                @endif
                            </div>

                        @endif
                    </div>
                </div>

                <div class="flex-none flex items-center justify-end space-x-2 sm:space-x-6">
                    <div class="flex items-center space-x-2 sm:space-x-4 text-gray-300">
                        <button class="hover:text-[#D4AF37] transition-colors p-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative hover:text-[#D4AF37] transition-colors p-1">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span class="absolute top-0 right-0 bg-[#D4AF37] text-black text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-lg transform translate-x-1 -translate-y-1">
                                    {{ $cartCount }}
                                </span>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-4 w-72 sm:w-80 bg-[#0A0A0A] border border-[#D4AF37]/30 rounded-xl shadow-2xl z-[100] p-4" style="display:none;">
                                <h3 class="text-[#D4AF37] text-xs font-bold uppercase mb-4 tracking-widest">Carrito de Compras</h3>

                                <div class="max-h-64 overflow-y-auto hide-scroll space-y-3 pr-1">
                                    @forelse($cart as $id => $item)
                                        <div class="flex flex-col gap-1.5 border-b border-white/10 pb-3">

                                            <div class="flex justify-between items-start gap-2">
                                                <span class="text-white text-[10px] font-bold uppercase truncate">{{ $item['name'] }}</span>

                                                <button wire:click.stop="removeFromCart({{ $id }})" class="text-gray-500 hover:text-red-500 transition-colors p-0.5 flex-shrink-0" title="Eliminar producto">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </div>

                                            <div class="flex justify-between items-end">

                                                <div class="flex items-center bg-[#111] border border-[#D4AF37]/30 rounded px-1.5 py-0.5 shadow-inner">
                                                    <button wire:click.stop="decreaseQuantity({{ $id }})" class="text-gray-400 hover:text-[#D4AF37] px-1 text-sm font-black transition-colors leading-none">-</button>
                                                    <span class="text-white text-[10px] font-black w-4 text-center select-none">{{ $item['quantity'] }}</span>
                                                    <button wire:click.stop="increaseQuantity({{ $id }})" class="text-gray-400 hover:text-[#D4AF37] px-1 text-sm font-black transition-colors leading-none">+</button>
                                                </div>

                                                <span class="text-[#D4AF37] font-black text-xs">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-[10px] uppercase tracking-widest text-center py-4 font-bold">El carrito está vacío</p>
                                    @endforelse
                                </div>

                                @if($cartCount > 0)
                                    <button wire:click="checkoutWhatsApp" class="w-full bg-[#D4AF37] text-black mt-4 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest">Pedir por WhatsApp</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block h-8 w-px bg-gray-800"></div>

                    <a href="/admin/products" class="p-1.5 sm:p-2 rounded-full border border-gray-800 hover:border-[#D4AF37] transition-colors bg-[#111]">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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

                <div class="max-h-[350px] overflow-y-auto hide-scroll p-5 space-y-4">
                    @forelse($cart as $id => $item)
                        <div class="flex flex-col gap-2 border-b border-white/5 pb-4">

                            <div class="flex justify-between items-start gap-3">
                                <p class="font-bold text-white uppercase tracking-wider text-sm truncate">{{ $item['name'] }}</p>

                                <button wire:click.stop="removeFromCart({{ $id }})" class="text-gray-500 hover:text-red-500 transition-colors p-1 flex-shrink-0" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            <div class="flex justify-between items-end mt-1">
                                <div class="flex items-center bg-[#111] border border-[#D4AF37]/30 rounded-lg px-2 py-1 shadow-inner">
                                    <button wire:click.stop="decreaseQuantity({{ $id }})" class="text-gray-400 hover:text-[#D4AF37] px-2 text-lg font-black transition-colors leading-none">-</button>
                                    <span class="text-white text-xs font-black w-6 text-center select-none">{{ $item['quantity'] }}</span>
                                    <button wire:click.stop="increaseQuantity({{ $id }})" class="text-gray-400 hover:text-[#D4AF37] px-2 text-lg font-black transition-colors leading-none">+</button>
                                </div>

                                <p class="text-[#D4AF37] font-bold text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
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
</div>