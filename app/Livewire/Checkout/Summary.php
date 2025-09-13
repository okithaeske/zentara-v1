<?php

namespace App\Livewire\Checkout;

use Livewire\Component;

class Summary extends Component
{
    public array $cart = ['items' => [], 'count' => 0, 'subtotal' => 0.0];

    public function mount(): void
    {
        $this->cart = session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0.0]);
    }

    public function render()
    {
        return view('livewire.checkout.summary');
    }
}

