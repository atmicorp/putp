<?php

namespace Modules\Order\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(string $slug, string $token)
    {
        $order = Order::where('access_token', $token)
            ->with(['offer.details.package'])
            ->firstOrFail();

        if ($slug !== $order->customer_slug) {
            return redirect()->route('orders.guest.show', [
                'slug'  => $order->customer_slug,
                'token' => $order->access_token,
            ]);
        }

        return view('order::guest.orders.show', compact('order'));
    }
}