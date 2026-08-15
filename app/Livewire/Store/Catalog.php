<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\Product;

class Catalog extends Component
{
    public string $sortBy = 'name'; // 'name' | 'marca'

    public function setSort(string $sort): void
    {
        $this->sortBy = in_array($sort, ['name', 'marca']) ? $sort : 'name';
    }

    public function render()
    {
        $exclusivos = Product::where('is_exclusive', true)->get();
        $ofertas    = Product::where('is_offer', true)->get();

        $sortColumn = $this->sortBy === 'marca' ? 'marca_perfume' : 'name';

        $products = Product::query()
            // Los agotados siempre al final, sin importar el orden elegido
            ->orderByRaw('CASE WHEN stock <= 0 THEN 1 ELSE 0 END ASC')
            ->orderBy($sortColumn)
            ->get();

        return view('livewire.store.catalog', [
            'exclusivos' => $exclusivos,
            'ofertas'    => $ofertas,
            'products'   => $products,
        ]);
    }
}