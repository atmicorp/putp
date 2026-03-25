<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\OrderOfferDetail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Order\Mail\CustomerSubmittedItemsMail;
use Modules\Order\Mail\OfferLinkMail;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('order::admin.orders.index', compact('orders'));
    }

    public function create()
    {
        // Ambil semua kategori beserta paket aktifnya
        $categories = Category::with([
            'packages' => fn($q) => $q->where('is_active', true)->orderBy('name'),
        ])->get();
    
        return view('order::admin.orders.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'          => ['required', 'string', 'max:255'],
            'customer_email'         => ['nullable', 'email', 'max:255'],
            'filled_by'              => ['required', 'in:customer,admin'],
    
            // Validasi items hanya jika mode admin
            'items'                  => ['required_if:filled_by,admin', 'array', 'min:1'],
            'items.*.package_id'     => ['required_if:filled_by,admin', 'integer', 'exists:packages,id'],
            'items.*.qty'            => ['required_if:filled_by,admin', 'integer', 'min:1'],
            // custom_price opsional; jika tidak dikirim / null, fallback ke base_price package
            'items.*.custom_price'   => ['nullable', 'numeric', 'min:0'],
        ]);
    
        $order = Order::create([
            'customer_name'  => $data['customer_name'],
            'customer_slug'  => Str::slug($data['customer_name']),
            'customer_email' => $data['customer_email'] ?? '',
            'created_by'     => auth()->id(),
            'status'         => Order::STATUS_DRAFT,
        ]);
    
        if ($data['filled_by'] === 'admin' && !empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $package = Package::findOrFail($item['package_id']);
    
                // Gunakan custom_price jika dikirim, fallback ke base_price
                $unitPrice = isset($item['custom_price']) && $item['custom_price'] !== null
                    ? (float) $item['custom_price']
                    : (float) $package->base_price;
    
                $order->offerDetails()->create([
                    'package_id' => $package->id,
                    'qty'        => $item['qty'],
                    'unit_price' => $unitPrice,
                    'subtotal'   => $unitPrice * $item['qty'],
                ]);
            }
        }
    
        $message = $data['filled_by'] === 'admin'
            ? 'Order berhasil dibuat beserta paket layanan yang dipilih.'
            : 'Order berhasil dibuat. Paket layanan akan dipilih oleh guest melalui token.';
    
        return redirect()->route('admin.orders.show', $order)->with('success', $message);
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

    public function edit(Order $order)
    {
        $order->load(['offer.details.package', 'creator']);

        return view('order::admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Strip thousand separator dari price sebelum validasi
        $items = $request->input('items', []);
        foreach ($items as $i => $item) {
            if (isset($item['price'])) {
                $items[$i]['price'] = str_replace('.', '', $item['price']);
            }
        }
        $request->merge(['items' => $items]);

        $data = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],

            'notes' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],

            'items'              => ['required', 'array', 'min:1'],
            'items.*.id'         => ['required', 'integer', 'exists:order_offer_details,id'],
            'items.*.qty'        => ['required', 'integer', 'min:1'],
            'items.*.price'      => ['required', 'numeric', 'min:0'],

            'offer_file'   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'invoice_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $order->load('offer.details');

        $order->update([
            'customer_name'  => $data['customer_name'],
            'customer_slug'  => Str::slug($data['customer_name']),
            'customer_email' => $data['customer_email'] ?? '',
        ]);

        $offer = $order->offer ?? $order->offer()->create([]);
        $offer->update([
            'notes' => $data['notes'] ?? null,
            'terms' => $data['terms'] ?? null,
        ]);

        $allowedDetailIds = $offer->details()->pluck('id')->all();
        
        foreach ($data['items'] as $item) {
            if (! in_array((int) $item['id'], $allowedDetailIds, true)) {
                continue;
            }
            
            OrderOfferDetail::where('id', $item['id'])
                ->update([
                    'qty'   => (int) $item['qty'],
                    'price' => (float) $item['price'],
                ]);
        }

        $dir = 'orders/' . $order->order_code;
        if ($request->hasFile('offer_file')) {
            $path = $request->file('offer_file')->storeAs($dir, 'penawaran.pdf', 'public');
            $offer->update(['offer_file_path' => $path]);
        }
        if ($request->hasFile('invoice_file')) {
            $path = $request->file('invoice_file')->storeAs($dir, 'invoice.pdf', 'public');
            $offer->update(['invoice_file_path' => $path]);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $allowed = [
            'approved'   => 'processing',
            'processing' => 'done',
        ];

        $currentStatus = $order->status;
        $newStatus     = $request->input('status');

        // Validasi: transisi harus sesuai peta yang diizinkan
        if (!isset($allowed[$currentStatus]) || $allowed[$currentStatus] !== $newStatus) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Status order berhasil diubah ke ' . ucfirst($newStatus) . '.');
    }

    public function notifyInternal(Order $order)
    {
        $order->load(['offer.details.package', 'creator']);

        $internalUser = User::find(2);
        if (! $internalUser || blank($internalUser->email)) {
            return back()->with('error', 'User internal (id=2) tidak ditemukan atau email-nya kosong.');
        }

        Mail::to($internalUser->email)->send(new CustomerSubmittedItemsMail($order));

        return back()->with('success', 'Notifikasi internal berhasil dikirim.');
    }

    public function sendOffer(Order $order)
    {
        $order->load(['offer.details.package']);

        if (blank($order->customer_email)) {
            return back()->with('error', 'Email customer masih kosong. Lengkapi email terlebih dahulu sebelum mengirim penawaran.');
        }

        if (!$order->offer || $order->offer->details->isEmpty()) {
            return back()->with('error', 'Penawaran belum ada / item masih kosong.');
        }

        if (blank($order->offer->offer_file_path) || blank($order->offer->invoice_file_path)) {
            return back()->with('error', 'Upload file penawaran dan invoice terlebih dahulu sebelum mengirim penawaran ke customer.');
        }

        $mail = new OfferLinkMail($order);

        // Attach PDF files if available (public disk)
        if (filled($order->offer->offer_file_path) && Storage::disk('public')->exists($order->offer->offer_file_path)) {
            $mail->attach(Storage::disk('public')->path($order->offer->offer_file_path));
        }
        if (filled($order->offer->invoice_file_path) && Storage::disk('public')->exists($order->offer->invoice_file_path)) {
            $mail->attach(Storage::disk('public')->path($order->offer->invoice_file_path));
        }

        Mail::to($order->customer_email)->send($mail);

        $order->update([
            'status'  => Order::STATUS_OFFERED,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Email penawaran berhasil dikirim ke customer.');
    }
}