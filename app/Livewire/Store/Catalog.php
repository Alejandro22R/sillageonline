<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Catalog extends Component
{
    public $search = '';

    // Función para añadir al carrito usando Sesiones
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        // Si el producto ya está, aumentamos cantidad, si no, lo añadimos
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->retail_price,
                // CORRECCIÓN 1: Usar marca_perfume en lugar de brand
                "brand" => $product->marca_perfume 
            ];
        }

        Session::put('cart', $cart);
        $this->dispatch('cartUpdated');
    }

    // Calcular el total del carrito
    public function getTotal()
    {
        $cart = Session::get('cart', []);
        return array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    // Generar el link de WhatsApp
    public function checkoutWhatsApp()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) return;

        $total = $this->getTotal();
        $numero = "584122894918"; 

        $mensaje = "¡Hola Sillage Parfums! 🌟 Deseo realizar un pedido:\n\n";
        
        foreach ($cart as $item) {
            $mensaje .= "• " . $item['name'] . " (" . ($item['brand'] ?? 'Sillage') . ") x" . $item['quantity'] . " - $" . ($item['price'] * $item['quantity']) . "\n";
        }

        $mensaje .= "\n*Total a pagar: $" . number_format($total, 2) . "*";
        
        // Limpiamos el carrito tras el pedido
        Session::forget('cart');
        
        return redirect()->away("https://wa.me/" . $numero . "?text=" . urlencode($mensaje));
    }

    public function render()
    {
        // 1. Las listas de la página principal
        $exclusivos = Product::where('is_exclusive', true)->get();
        $ofertas    = Product::where('is_offer', true)->get();
        $products   = Product::all();

        // 2. Lógica del Dropdown de Búsqueda
        $searchResults = collect(); 
        
        if (strlen($this->search) >= 2) {
            $searchResults = Product::where('name', 'like', '%' . $this->search . '%')
                // CORRECCIÓN 2: Buscar en la columna 'marca_perfume' en lugar de 'brand'
                ->orWhere('marca_perfume', 'like', '%' . $this->search . '%')
                ->take(5) 
                ->get();
        }

        // 3. Carrito
        $cart = session('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('livewire.store.catalog', [
            'exclusivos'    => $exclusivos,
            'ofertas'       => $ofertas,
            'products'      => $products,
            'cartCount'     => $cartCount,
            'searchResults' => $searchResults,
        ]);
    }
}