<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Basic counts
        $totalUsers = User::count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', 'paid')->count();

        // GMV and Fees (paid orders only)
        $gmv = (float) OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))->sum('total');
        $feeCustomerRate = 0.025;
        $feeSellerRate = 0.03;
        $customerFees = round($gmv * $feeCustomerRate, 2);
        $sellerFees = round($gmv * $feeSellerRate, 2);
        $platformRevenue = round($customerFees + $sellerFees, 2);

        // Last 30 days GMV
        $since = now()->subDays(30);
        $gmv30 = (float) OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid')->where('created_at', '>=', $since))->sum('total');

        // Top sellers by revenue (paid)
        $topSellers = OrderItem::selectRaw('products.user_id as seller_id, SUM(order_items.total) as revenue, SUM(order_items.quantity) as qty')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('products.user_id')
            ->orderByDesc('revenue')
            ->take(5)
            ->get()
            ->map(function ($row) {
                $seller = User::select('id','name','email')->find($row->seller_id);
                return [
                    'seller' => $seller,
                    'revenue' => round((float)$row->revenue, 2),
                    'qty' => (int)$row->qty,
                ];
            });

        return view('dashboards.admin', compact(
            'totalUsers','totalSellers','totalProducts','totalOrders','paidOrders',
            'gmv','gmv30','customerFees','sellerFees','platformRevenue','topSellers'
        ));
    }
}

