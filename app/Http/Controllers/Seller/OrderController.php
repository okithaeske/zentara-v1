<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;

        $orders = Order::query()
            ->whereHas('items.product', function ($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->with(['items.product' => function ($q) use ($sellerId) {
                $q->select('id', 'user_id', 'name');
            }])
            ->latest()
            ->paginate(12)
            ->through(function (Order $order) use ($sellerId) {
                $sellerItems = $order->items->filter(fn($it) => optional($it->product)->user_id === $sellerId);
                $order->seller_items_count = $sellerItems->sum('quantity');
                $order->seller_total = round($sellerItems->sum('total'), 2);
                return $order;
            });

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $sellerId = $request->user()->id;
        abort_unless($order->items()->whereHas('product', fn($q) => $q->where('user_id', $sellerId))->exists(), 403);

        $order->load('items.product');
        $sellerItems = $order->items->filter(fn($it) => optional($it->product)->user_id === $sellerId);
        $sellerTotal = round($sellerItems->sum('total'), 2);

        return view('seller.orders.show', [
            'order' => $order,
            'items' => $sellerItems,
            'sellerTotal' => $sellerTotal,
        ]);
    }
}

