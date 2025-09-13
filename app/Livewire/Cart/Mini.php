<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;

class Mini extends Component
{
    public bool $open = false;
    public array $cart = ['items' => [], 'count' => 0, 'subtotal' => 0.0];

    protected $listeners = [
        'mini-cart-open' => 'open',
        'cart-updated' => 'loadCart',
    ];

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $this->cart = session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0.0]);
    }

    public function open(): void
    {
        $this->loadCart();
        $this->open = true;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function remove(int $productId): void
    {
        $items = $this->cart['items'];
        unset($items[$productId]);
        $this->cart['items'] = $items;
        $this->recalc();
    }

    protected function recalc(): void
    {
        $count = 0; $subtotal = 0.0;
        foreach ($this->cart['items'] as $item) { $count += (int)$item['qty']; $subtotal += (float)$item['price'] * (int)$item['qty']; }
        $this->cart['count'] = $count; $this->cart['subtotal'] = round($subtotal, 2);
        session(['cart' => $this->cart]);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart.mini');
    }
}

