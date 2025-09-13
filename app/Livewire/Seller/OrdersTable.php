<?php

namespace App\Livewire\Seller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTable extends Component
{
    use WithPagination;

    public function getRows()
    {
        $sellerId = Auth::id();

        // Aggregate orders containing this seller's products
        return DB::table('orders as o')
            ->join('order_items as oi', 'oi.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->where('p.user_id', $sellerId)
            ->selectRaw('o.id, o.shipping_name, o.status, SUM(oi.total) as seller_total, COUNT(oi.id) as seller_items_count')
            ->groupBy('o.id', 'o.shipping_name', 'o.status')
            ->orderByDesc('o.id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.seller.orders-table', [
            'orders' => $this->getRows(),
        ]);
    }
}

