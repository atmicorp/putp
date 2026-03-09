<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Order\Mail\OfferLinkMail;


use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\OrderOfferDetail;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('order::admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $packages = Package::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('order::admin.orders.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],

            'items'              => ['required', 'array', 'min:1'],
            'items.*.package_id' => ['required', 'integer', 'exists:packages,id'],
            'items.*.qty'        => ['required', 'integer', 'min:1'],
            'items.*.price'      => ['required', 'numeric', 'min:0'],

            'notes' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],
        ]);

        $order = Order::create([
            'customer_name'  => $data['customer_name'],
            'customer_slug'  => Str::slug($data['customer_name']),
            'customer_email' => $data['customer_email'],
            'created_by'     => auth()->id(),
            'status'         => Order::STATUS_DRAFT,
        ]);

        $offer = OrderOffer::create([
            'order_id' => $order->id,
            'notes'    => $data['notes'] ?? null,
            'terms'    => $data['terms'] ?? null,
        ]);

        foreach ($data['items'] as $item) {
            OrderOfferDetail::create([
                'order_offer_id' => $offer->id,
                'package_id'     => $item['package_id'],
                'qty'            => $item['qty'],
                'price'          => $item['price'],
            ]);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order + penawaran berhasil dibuat.');
    }

    public function show(Order $order)
    {
        $order->load(['offer.details.package', 'creator']);

        $guestLink = route('orders.guest.show', [
            'slug'  => $order->customer_slug,
            'token' => $order->access_token,
        ]);

        return view('order::admin.orders.show', compact('order', 'guestLink'));
    }

    public function sendOffer(Order $order)
    {
        $order->load(['offer.details.package']);

        if (!$order->offer || $order->offer->details->isEmpty()) {
            return back()->with('error', 'Penawaran belum ada / item masih kosong.');
        }

        Mail::to($order->customer_email)->send(new OfferLinkMail($order));

        $order->update([
            'status'  => Order::STATUS_OFFERED,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Email penawaran berhasil dikirim ke customer.');
    }
}