<?php

namespace Modules\Order\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman utama keranjang guest.
     * URL: /order/keranjang
     */
    public function index()
    {
        return view('order::guest.orders.cart');
    }

    /**
     * Validasi access token & kembalikan data order sebagai JSON.
     * POST /order/keranjang/validate-token
     */
    public function validateToken(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $order = Order::where('access_token', $request->token)
            ->whereIn('status', [
                Order::STATUS_DRAFT,
                Order::STATUS_OFFERED,
                Order::STATUS_FORM_REQUIRED,
            ])
            ->with(['offer.details.package.category'])
            ->first();

        if (! $order) {
            return response()->json([
                'valid'   => false,
                'message' => 'Kode tidak ditemukan atau order sudah tidak dapat diubah.',
            ], 404);
        }

        // Ambil semua package aktif untuk ditampilkan
        $packages = Package::where('is_active', true)
            ->with('category')
            ->orderBy('name')
            ->get()
            ->map(fn ($p) => [
                'id'            => $p->id,
                'name'          => $p->name,
                'description'   => $p->description,
                'base_price'    => $p->base_price,
                'category_id'   => $p->category_id,
                'category_name' => $p->category?->nama_category,
            ]);

        // Item yang sudah ada di order offer
        $existingItems = $order->offer
            ? $order->offer->details->map(fn ($d) => [
                'package_id' => $d->package_id,
                'qty'        => $d->qty,
                'price'      => $d->price,
                'name'       => $d->package?->name,
            ])
            : collect();

        return response()->json([
            'valid'          => true,
            'order_code'     => $order->order_code,
            'customer_name'  => $order->customer_name,
            'customer_email' => $order->customer_email,
            'status'         => $order->status,
            'existing_items' => $existingItems,
            'packages'       => $packages,
        ]);
    }

    /**
     * Simpan / update pilihan package ke order offer.
     * POST /order/keranjang/submit
     *
     * Aturan:
     * - Token sekali pakai: setelah submit status → form_required, token dikunci (tidak bisa dipakai ulang)
     * - Hanya bisa submit jika status draft atau offered
     */
    public function submit(Request $request)
    {
        $data = $request->validate([
            'token'              => ['required', 'string'],
            'items'              => ['required', 'array', 'min:1'],
            'items.*.package_id' => [
                'required',
                'integer',
                Rule::exists('packages', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],
            'items.*.qty'        => ['required', 'integer', 'min:1'],
        ]);

        $order = Order::where('access_token', $data['token'])
            ->whereIn('status', [
                Order::STATUS_DRAFT,
                Order::STATUS_OFFERED,
            ])
            ->with('offer')
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid, sudah digunakan, atau order tidak dapat diubah.',
            ], 422);
        }

        // Buat offer jika belum ada
        $offer = $order->offer ?? $order->offer()->create([]);

        // Hapus detail lama, ganti dengan pilihan baru
        $offer->details()->delete();

        foreach ($data['items'] as $item) {
            $package = Package::query()
                ->whereKey($item['package_id'])
                ->where('is_active', true)
                ->first();

            if (! $package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paket yang dipilih tidak valid atau sudah tidak tersedia.',
                ], 422);
            }

            $offer->details()->create([
                'package_id' => $item['package_id'],
                'qty'        => $item['qty'],
                'price'      => $package->base_price,
            ]);
        }

        // Kunci token — ubah status ke form_required agar tidak bisa disubmit ulang
        $order->update([
            'status' => Order::STATUS_SUBMIT,
        ]);

        return response()->json([
            'success'    => true,
            'order_code' => $order->order_code,
            'message'    => 'Pilihan berhasil disimpan. Admin akan segera memproses order Anda.',
        ]);
    }

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

    public function approve(string $slug, string $token)
    {
        $order = Order::where('access_token', $token)->firstOrFail();
        $order->update(['status' => Order::STATUS_APPROVED]);
        return redirect()->route('orders.guest.show', ['slug' => $slug, 'token' => $token])
            ->with('success', 'Penawaran berhasil disetujui.');
    }

    public function reject(string $slug, string $token)
    {
        $order = Order::where('access_token', $token)->firstOrFail();
        $order->update(['status' => Order::STATUS_REJECTED]);
        return redirect()->route('orders.guest.show', ['slug' => $slug, 'token' => $token])
            ->with('success', 'Penawaran telah ditolak.');
    }
}