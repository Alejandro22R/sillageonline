<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\Product;

class Catalog extends Component
{
    // 'marca' (por defecto: marca y dentro de cada marca por nombre),
    // 'name' (solo nombre A-Z), 'precio_asc', 'precio_desc'.
    public string $sortBy = 'marca';

    public function setSort(string $sort): void
    {
        $this->sortBy = in_array($sort, ['name', 'marca', 'precio_asc', 'precio_desc'])
            ? $sort
            : 'marca';
    }

    public function render()
    {
        $exclusivos = Product::where('is_exclusive', true)->get();
        $ofertas    = Product::where('is_offer', true)->get();

        $query = Product::query()
            // Los agotados siempre al final, sin importar el orden elegido
            ->orderByRaw('CASE WHEN stock <= 0 THEN 1 ELSE 0 END ASC');

        // Precio efectivo: el de oferta si el producto está en oferta y lo tiene, si no el normal.
        $precioEfectivo = 'CASE WHEN is_offer = 1 AND offer_price IS NOT NULL THEN offer_price ELSE retail_price END';

        match ($this->sortBy) {
            'name'        => $query->orderBy('name'),
            'precio_asc'  => $query->orderByRaw("{$precioEfectivo} ASC"),
            'precio_desc' => $query->orderByRaw("{$precioEfectivo} DESC"),
            default       => $query->orderBy('marca_perfume')->orderBy('name'),
        };

        $products = $query->get();

        return view('livewire.store.catalog', [
            'exclusivos' => $exclusivos,
            'ofertas'    => $ofertas,
            'products'   => $products,
        ]);
    }
}
