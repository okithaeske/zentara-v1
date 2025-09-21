<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items');
        return view('orders.show', compact('order'));
    }
}
