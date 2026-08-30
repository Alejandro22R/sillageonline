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
            'topNotes'     => $this->product->notes->where('type', 'top'),
            'heartNotes'   => $this->product->notes->where('type', 'heart'),
            'baseNotes'    => $this->product->notes->where('type', 'base'),
            'chords'       => $this->product->chords->sortByDesc(fn ($chord) => $chord->pivot->intensity),
            'relacionados' => $this->relacionados(),
        ]);
    }

    /**
     * Fragancias en stock para "Fragancias que pueden gustarte": prioriza la
     * misma marca y completa con el resto del catálogo disponible.
     */
    protected function relacionados()
    {
        $base = Product::query()
            ->where('id', '!=', $this->product->id)
            ->where('stock', '>', 0);

        $mismaMarca = (clone $base)
            ->when($this->product->marca_perfume, fn ($q) => $q->where('marca_perfume', $this->product->marca_perfume))
            ->inRandomOrder()
            ->limit(12)
            ->get();

        if ($mismaMarca->count() >= 8) {
            return $mismaMarca;
        }

        $resto = (clone $base)
            ->whereNotIn('id', $mismaMarca->pluck('id'))
            ->inRandomOrder()
            ->limit(12 - $mismaMarca->count())
            ->get();

        return $mismaMarca->concat($resto);
    }
}
