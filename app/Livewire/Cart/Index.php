<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public array $cart = ['items' => [], 'count' => 0, 'subtotal' => 0.0];

    public function mount(): void
    {
        $this->loadCart();
    }

    protected function loadCart(): void
    {
        $this->cart = session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0.0]);
    }

    protected function saveCart(): void
    {
        $count = 0; $subtotal = 0.0;
        foreach ($this->cart['items'] as $item) {
            $count += (int) $item['qty'];
            $subtotal += ((float) $item['price']) * (int) $item['qty'];
        }
        $this->cart['count'] = $count;
        $this->cart['subtotal'] = round($subtotal, 2);
        session(['cart' => $this->cart]);
    }

    public function updateQty(int $productId, int $qty): void
    {
        if (!isset($this->cart['items'][$productId])) return;
        $product = Product::find($productId);
        if (!$product) return;
        if ($qty <= 0) {
            unset($this->cart['items'][$productId]);
        } else {
            if (!is_null($product->stock) && $qty > (int)$product->stock) {
                $qty = (int)$product->stock;
            }
            $this->cart['items'][$productId]['qty'] = $qty;
        }
        $this->saveCart();
    }

    public function remove(int $productId): void
    {
        unset($this->cart['items'][$productId]);
        $this->saveCart();
    }

    public function clear(): void
    {
        $this->cart = ['items' => [], 'count' => 0, 'subtotal' => 0.0];
        session()->forget('cart');
    }

    public function render()
    {
        return view('livewire.cart.index');
    }
}

