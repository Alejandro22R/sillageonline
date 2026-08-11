<x-filament-panels::page>

    <!-- Barra de Búsqueda -->
    <div class="mb-6 max-w-md">
        <x-filament::input.wrapper>
            <x-slot name="prefix">
                <x-heroicon-m-magnifying-glass class="w-5 h-5 text-gray-400" />
            </x-slot>
            <x-filament::input
                type="search"
                wire:model.live="search"
                placeholder="Buscar perfume por nombre..."
            />
        </x-filament::input.wrapper>
    </div>

    <!-- Catálogo en Cuadrícula (Grid) -->
    <!-- 2 columnas en móvil, 3 desde sm, 4 desde lg, 5 desde xl -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-5 lg:gap-7">
        @forelse($products as $product)
            <!-- Tarjeta del Perfume -->
            <div class="group relative flex flex-col rounded-2xl overflow-hidden
                        bg-white dark:bg-neutral-900
                        ring-1 ring-neutral-200 dark:ring-neutral-800
                        shadow-sm hover:shadow-2xl hover:shadow-orange-500/10 dark:hover:shadow-orange-500/20
                        transition-all duration-300 hover:-translate-y-1.5">

                <!-- Línea superior de acento naranja, aparece al hover -->
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600
                            scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></div>

                <!-- Imagen -->
                <div class="w-full aspect-[4/5] bg-neutral-950 overflow-hidden relative">
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-heroicon-o-photo class="w-16 h-16 text-neutral-700" />
                        </div>
                    @endif

                    <!-- Badge de stock/novedad opcional -->
                    <div class="absolute top-2 left-2 sm:top-3 sm:left-3 px-2 py-0.5 rounded-full bg-black/60 backdrop-blur-sm">
                        <span class="text-[9px] sm:text-[10px] font-semibold uppercase tracking-widest text-orange-400">Disponible</span>
                    </div>
                </div>

                <!-- Contenido Inferior -->
                <div class="flex flex-col text-left p-2.5 sm:p-4 gap-2 sm:gap-3">

                    <!-- Nombre del Perfume -->
                    <h3 class="text-neutral-900 dark:text-white font-semibold text-sm sm:text-base w-full truncate tracking-wide">
                        {{ $product->name }}
                    </h3>

                    <!-- Placa de Precio Naranja -->
                    <div class="relative flex items-center justify-between rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 overflow-hidden
                                bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500
                                dark:from-orange-600 dark:via-orange-600 dark:to-amber-600
                                shadow-inner ring-1 ring-orange-600/30 dark:ring-orange-400/20">

                        <!-- Brillo diagonal sutil -->
                        <div class="absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent pointer-events-none"></div>

                        <div class="relative flex flex-col leading-tight">
                            <span class="text-[8px] sm:text-[10px] font-medium uppercase tracking-wider text-orange-950/70">USD</span>
                            <span class="text-white font-bold text-xs sm:text-sm drop-shadow-sm">
                                ${{ number_format($product->precio_divisa, 2) }}
                            </span>
                        </div>

                        <div class="relative w-px h-6 sm:h-8 bg-white/30"></div>

                        <div class="relative flex flex-col leading-tight items-end">
                            <span class="text-[8px] sm:text-[10px] font-medium uppercase tracking-wider text-orange-950/70">Bs</span>
                            <span class="text-white font-bold text-xs sm:text-sm drop-shadow-sm">
                                {{ number_format($product->retail_price, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        @empty
            <!-- Mensaje cuando no hay resultados en la búsqueda -->
            <div class="col-span-full flex flex-col items-center justify-center p-8 text-gray-500 dark:text-gray-400">
                <x-heroicon-o-magnifying-glass-minus class="w-12 h-12 mb-3 text-gray-400 dark:text-gray-600" />
                <p class="text-lg font-medium">No se encontraron perfumes con ese nombre.</p>
            </div>
        @endforelse
    </div>

</x-filament-panels::page>