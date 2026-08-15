<?php

namespace App\Livewire\Store;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $search = '';

    #[On('add-to-cart')]
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name'     => $product->name,
                'quantity' => 1,
                'price'    => $product->retail_price,
                'brand'    => $product->marca_perfume,
            ];
        }

        Session::put('cart', $cart);
    }

    public function increaseQuantity($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            Session::put('cart', $cart);
        }
    }

    public function decreaseQuantity($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
            } else {
                unset($cart[$productId]);
            }
            Session::put('cart', $cart);
        }
    }

    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }
    }

    public function getTotal()
    {
        $cart = Session::get('cart', []);
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function checkoutWhatsApp()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return;
        }

        $total  = $this->getTotal();
        $numero = '584122894918';

        $mensaje = "¡Hola Sillage Parfums! 🌟 Deseo realizar un pedido:\n\n";

        foreach ($cart as $item) {
            $mensaje .= '• '.$item['name'].' ('.($item['brand'] ?? 'Sillage').') x'.$item['quantity'].' - $'.($item['price'] * $item['quantity'])."\n";
        }

        $mensaje .= "\n*Total a pagar: $".number_format($total, 2).'*';

        Session::forget('cart');

        return redirect()->away('https://wa.me/'.$numero.'?text='.urlencode($mensaje));
    }

    public function render()
    {
        $searchResults = collect();

        if (strlen($this->search) >= 2) {
            $searchResults = Product::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('marca_perfume', 'like', '%'.$this->search.'%')
                ->take(5)
                ->get();
        }

        $cart      = Session::get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('livewire.store.header', [
            'searchResults' => $searchResults,
            'cart'          => $cart,
            'cartCount'     => $cartCount,
        ]);
    }
}