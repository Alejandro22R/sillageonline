<?php

namespace App\Livewire\Store;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Catalog extends Component
{
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
                "brand" => $product->brand
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
        $numero = "584249033492"; // Cambia este número por el tuyo de Panamá

        $mensaje = "¡Hola Sillage Parfums! 🌟 Deseo realizar un pedido:\n\n";
        
        foreach ($cart as $item) {
            $mensaje .= "• " . $item['name'] . " (" . ($item['brand'] ?? 'Sillage') . ") x" . $item['quantity'] . " - $" . ($item['price'] * $item['quantity']) . "\n";
        }

        $mensaje .= "\n*Total a pagar: $" . number_format($total, 2) . "*";
        
        // Limpiamos el carrito tras el pedido
        Session::forget('cart');
        
        return redirect()->away("https://wa.me/" . $numero . "?text=" . urlencode($mensaje));
    }

    public $search = '';

    public function render()
    {
        // 1. Las listas de la página principal (AHORA SIEMPRE ESTÁN COMPLETAS)
        $exclusivos = Product::where('is_exclusive', true)->get();
        $ofertas    = Product::where('is_offer', true)->get();
        $products   = Product::all();

        // 2. Lógica del Dropdown de Búsqueda
        $searchResults = collect(); // Una lista vacía por defecto
        
        // Si el usuario escribió al menos 2 letras, buscamos en la base de datos
        if (strlen($this->search) >= 2) {
            $searchResults = Product::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('brand', 'like', '%' . $this->search . '%')
                ->take(5) // Solo mostramos los 5 mejores resultados para no hacer el menú gigante
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
            'searchResults' => $searchResults, // Pasamos los resultados a la vista
        ]);
    }
}