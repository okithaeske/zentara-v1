<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;
        $feeRate = 0.10; // 10% platform fee placeholder

        $paidRevenue = OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->whereHas('product', fn($q) => $q->where('user_id', $sellerId))
            ->sum('total');

        $currentBalance = round($paidRevenue * (1 - $feeRate), 2);

        $since = now()->subDays(30);
        $fees30d = OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid')->where('created_at', '>=', $since))
            ->whereHas('product', fn($q) => $q->where('user_id', $sellerId))
            ->sum('total') * $feeRate;
        $fees30d = round($fees30d, 2);

        $nextPayout = null; // placeholder scheduling

        return view('seller.payouts.index', compact('currentBalance', 'nextPayout', 'fees30d'));
    }
}

