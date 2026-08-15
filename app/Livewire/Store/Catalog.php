<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\Product;

class Catalog extends Component
{
    public function render()
    {
        $exclusivos = Product::where('is_exclusive', true)->get();
        $ofertas    = Product::where('is_offer', true)->get();
        $products   = Product::all();

        return view('livewire.store.catalog', [
            'exclusivos' => $exclusivos,
            'ofertas'    => $ofertas,
            'products'   => $products,
        ]);
    }
}