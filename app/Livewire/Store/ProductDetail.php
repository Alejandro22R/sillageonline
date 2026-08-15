<?php

namespace App\Livewire\Store;

use App\Models\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['notes', 'chords'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.store.product-detail', [
            'topNotes'   => $this->product->notes->where('type', 'top'),
            'heartNotes' => $this->product->notes->where('type', 'heart'),
            'baseNotes'  => $this->product->notes->where('type', 'base'),
            'chords'     => $this->product->chords->sortByDesc(fn ($chord) => $chord->pivot->intensity),
        ]);
    }
}