<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryTable extends Component
{
    use WithPagination;

    public int $lowStockThreshold = 5;

    public function getRows()
    {
        return Product::where('user_id', Auth::id())
            ->orderBy('stock')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.seller.inventory-table', [
            'products' => $this->getRows(),
            'lowStockThreshold' => $this->lowStockThreshold,
        ]);
    }
}

