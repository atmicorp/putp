<?php

namespace Modules\Order\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        // 1. Validasi Input
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
            // Kolom tambahan dari modal form
            'tujuan_pengujian'    => ['nullable', 'string'],
            'waktu_diharapkan'    => ['nullable', 'string'],
            'keterangan_tambahan' => ['nullable', 'string'],
        ]);

        // 2. Cari Order berdasarkan Token
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

        // 3. Kelola OrderOffer (Penawaran)
        // Buat offer jika belum ada
        $offer = $order->offer ?? $order->offer()->create([]);

        // Hapus detail lama, ganti dengan pilihan baru dari keranjang
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

        // 4. Update Data Utama di Model Order
        // Simpan status baru dan data dari modal form
        $order->update([
            'status'              => Order::STATUS_SUBMIT,
            'tujuan_pengujian'    => $data['tujuan_pengujian'] ?? null,
            'waktu_diharapkan'    => $data['waktu_diharapkan'] ?? null,
            'keterangan_tambahan' => $data['keterangan_tambahan'] ?? null,
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
            ->with(['offer.details.package', 'contact', 'company'])
            ->firstOrFail();

        if ($slug !== $order->company->slug) {
            return redirect()->route('orders.guest.show', [
                'slug'  => $order->company->slug,
                'token' => $order->access_token,
            ]);
        }

        return view('order::guest.orders.show', compact('order'));
    }

    public function sign(Request $request, string $slug, string $token)
    {
        $request->validate([
            'signature' => ['required', 'string'],
        ]);

        $order = Order::where('access_token', $token)
            ->with(['contact', 'company'])
            ->firstOrFail();

        if ($slug !== $order->company->slug) {
            abort(404);
        }

        $dataUri = $request->input('signature');
        $base64  = preg_replace('/^data:image\/\w+;base64,/', '', $dataUri);
        $decoded = base64_decode($base64);

        $filename = 'signatures/contact_' . $order->contact->id . '_' . time() . '.png';
        Storage::disk('local')->put($filename, $decoded);
        $order->contact->update(['signature_path' => $filename]);

        // Langsung approve setelah sign
        $order->update(['status' => Order::STATUS_APPROVED]);

        return redirect()->route('orders.guest.show', [
            'slug'  => $slug,
            'token' => $token,
        ]);
    }

    public function approve(Request $request, string $slug, string $token)
    {
        $order = Order::where('access_token', $token)
            ->with(['contact', 'company'])
            ->firstOrFail();

        if ($slug !== $order->company->slug) abort(404);

        // Guard: must have signature
        if (! $order->contact->signature_path) {
            return back()->with('error', 'Tanda tangan diperlukan sebelum menyetujui penawaran.');
        }

        $order->update(['status' => Order::STATUS_APPROVED]);

        return redirect()->route('orders.guest.show', [
            'slug'  => $slug,
            'token' => $token,
        ]);
    }

    public function reject(string $slug, string $token)
    {
        $order = Order::where('access_token', $token)->firstOrFail();
        $order->update(['status' => Order::STATUS_REJECTED]);
        return redirect()->route('orders.guest.show', ['slug' => $slug, 'token' => $token])
            ->with('success', 'Penawaran telah ditolak.');
    }

    /**
     * Form untuk melihat status order berdasarkan access token.
     * GET /order/status
     */
    public function statusForm()
    {
        return view('order::guest.orders.status');
    }

    /**
     * Proses lookup status order.
     * POST /order/status/lookup
     */
    public function statusLookup(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
        ]);

        $order = Order::where('access_token', $data['token'])
            ->with(['offer.details.package'])
            ->first();

        if (! $order) {
            return back()
                ->withErrors(['token' => 'Kode akses tidak ditemukan.'])
                ->withInput();
        }

        return view('order::guest.orders.status', [
            'order' => $order,
            'token' => $data['token'],
        ]);
    }
}