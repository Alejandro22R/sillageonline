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
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 2rem;">
        @forelse($products as $product)
            <!-- Tarjeta del Perfume -->
            <div class="group flex flex-col rounded-2xl overflow-hidden bg-white dark:bg-neutral-900 ring-1 ring-neutral-200 dark:ring-neutral-800 shadow-sm hover:shadow-xl hover:shadow-neutral-900/10 dark:hover:shadow-black/40 transition-all duration-300 hover:-translate-y-1">

                <!-- Imagen -->
                <div class="w-full aspect-[4/5] bg-neutral-950 overflow-hidden relative">
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <!-- Sombreado inferior sutil para separar la imagen del contenido -->
                        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-heroicon-o-photo class="w-16 h-16 text-neutral-700" />
                        </div>
                    @endif
                </div>

                <!-- Contenido Inferior -->
                <div class="flex flex-col text-left p-4 gap-3">

                    <!-- Nombre del Perfume -->
                    <h3 class="text-neutral-900 dark:text-white font-semibold text-base w-full truncate tracking-wide">
                        {{ $product->name }}
                    </h3>

                    <!-- Placa de Precio (dorada, adaptable a claro/oscuro) -->
                    <div class="relative flex items-center justify-between rounded-lg px-3 py-2 overflow-hidden
                                bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600
                                dark:from-amber-600 dark:via-yellow-600 dark:to-amber-700
                                shadow-inner ring-1 ring-amber-600/30 dark:ring-amber-400/20">

                        <!-- Brillo diagonal sutil -->
                        <div class="absolute inset-0 bg-gradient-to-br from-white/25 via-transparent to-transparent pointer-events-none"></div>

                        <div class="relative flex flex-col leading-tight">
                            <span class="text-[10px] font-medium uppercase tracking-wider text-amber-950/70">PRECIO DIVISAS</span>
                            <span class="text-neutral-950 font-bold text-sm">
                                ${{ number_format($product->precio_divisa, 2) }}
                            </span>
                        </div>

                        <div class="relative w-px h-8 bg-neutral-950/20"></div>

                        <div class="relative flex flex-col leading-tight items-end">
                            <span class="text-[10px] font-medium uppercase tracking-wider text-amber-950/70">PRECIO BCV</span>
                            <span class="text-neutral-950 font-bold text-sm">
                                ${{ number_format($product->retail_price, 2, ',', '.') }}
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