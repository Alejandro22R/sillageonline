<div class="min-h-screen bg-[#050505] text-white p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-black uppercase tracking-[0.2em] text-[#D4AF37] mb-8">Panel de Socios - Sillage</h1>
        
        <div class="bg-[#111] border border-white/10 rounded-2xl p-6 shadow-2xl">
            <h2 class="text-xl font-light text-white mb-6 border-b border-white/10 pb-4">Añadir / Editar Fragancia</h2>
            
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Nombre del Perfume</label>
                        <input type="text" wire:model="name" class="w-full bg-black border border-gray-800 rounded-lg p-3 text-white focus:border-[#D4AF37] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Marca</label>
                        <input type="text" wire:model="brand" class="w-full bg-black border border-gray-800 rounded-lg p-3 text-white focus:border-[#D4AF37] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-400 mb-2">Precio Regular ($)</label>
                        <input type="number" step="0.01" wire:model="retail_price" class="w-full bg-black border border-gray-800 rounded-lg p-3 text-white focus:border-[#D4AF37] outline-none">
                    </div>
                </div>

                <div class="p-5 bg-black/50 border border-[#D4AF37]/30 rounded-xl mt-6">
                    <h3 class="text-sm font-bold text-[#D4AF37] uppercase tracking-widest mb-4 border-b border-[#D4AF37]/20 pb-2">
                        Visibilidad en la Tienda
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_exclusive" class="sr-only">
                                <div class="block bg-gray-800 w-10 h-6 rounded-full transition-colors" :class="{'bg-[#D4AF37]': $wire.is_exclusive}"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform" :class="{'transform translate-x-4': $wire.is_exclusive}"></div>
                            </div>
                            <div class="ml-3 text-sm">
                                <span class="font-bold text-white">Colección Exclusiva</span>
                                <p class="text-xs text-gray-500">Aparecerá en el primer carrusel.</p>
                            </div>
                        </label>

                        <label class="flex items-center cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_offer" class="sr-only">
                                <div class="block bg-gray-800 w-10 h-6 rounded-full transition-colors" :class="{'bg-[#D4AF37]': $wire.is_offer}"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform" :class="{'transform translate-x-4': $wire.is_offer}"></div>
                            </div>
                            <div class="ml-3 text-sm">
                                <span class="font-bold text-white">Oferta Especial</span>
                                <p class="text-xs text-gray-500">Aparecerá con etiqueta roja de descuento.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-[#D4AF37] text-black px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white transition-all shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                        Guardar Perfume
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>