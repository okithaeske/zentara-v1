<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        // Buyer can view own order
        if ($order->user_id === $user->id) {
            return true;
        }
        // Sellers can view orders that include their products
        if ($user->isSeller()) {
            return $order->items()->whereHas('product', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();
        }
        return false;
    }
}

