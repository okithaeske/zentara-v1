<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;

        $today = Carbon::today();

        // Revenue today: sum of order items for this seller in PAID orders created today
        $revenueToday = OrderItem::whereHas('order', function ($q) use ($today) {
                $q->whereDate('created_at', $today)->where('status', 'paid');
            })
            ->whereHas('product', fn($q) => $q->where('user_id', $sellerId))
            ->sum('total');

        // Orders to fulfill: count distinct orders with seller items in pending/paid (simplified)
        $ordersToFulfill = Order::whereIn('status', ['paid', 'pending'])
            ->whereHas('items.product', fn($q) => $q->where('user_id', $sellerId))
            ->count();

        // Low stock alerts
        $lowStockThreshold = 5;
        $lowStockCount = Product::where('user_id', $sellerId)
            ->where('stock', '<=', $lowStockThreshold)
            ->count();

        // Recent orders containing seller products
        $recentOrders = Order::whereHas('items.product', fn($q) => $q->where('user_id', $sellerId))
            ->latest()
            ->take(5)
            ->with('items.product')
            ->get()
            ->map(function (Order $order) use ($sellerId) {
                $items = $order->items->filter(fn($it) => optional($it->product)->user_id === $sellerId);
                return [
                    'id' => $order->id,
                    'shipping_name' => $order->shipping_name,
                    'status' => $order->status,
                    'items_count' => $items->sum('quantity'),
                    'total' => round($items->sum('total'), 2),
                ];
            });

        // Top products by quantity sold (paid orders only)
        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as sold, SUM(total) as revenue')
            ->whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->whereHas('product', fn($q) => $q->where('user_id', $sellerId))
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->take(5)
            ->get()
            ->map(function ($row) {
                $product = Product::select('id','name','image_path')->find($row->product_id);
                return [
                    'product' => $product,
                    'sold' => (int) $row->sold,
                    'revenue' => round((float)$row->revenue, 2),
                ];
            });

        return view('dashboards.seller', compact(
            'revenueToday', 'ordersToFulfill', 'lowStockCount', 'recentOrders', 'topProducts'
        ));
    }
}

