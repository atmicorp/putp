<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\OrderOfferDetail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Order\Mail\CustomerSubmittedItemsMail;
use Modules\Order\Mail\OfferLinkMail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type'); // null | 'external' | 'internal'

        $orders = Order::query()
            ->when($type, fn($q) => $q->where('type', $type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'    => Order::count(),
            'external' => Order::where('type', 'external')->count(),
            'internal' => Order::where('type', 'internal')->count(),
            'draft'    => Order::where('status', 'draft')->count(),
            'offered'  => Order::where('status', 'offered')->count(),
            'done'     => Order::where('status', 'done')->count(),
        ];

        return view('order::admin.orders.index', compact('orders', 'stats', 'type'));
    }

    public function create()
    {
        $categories = Category::with([
            'packages' => fn($q) => $q->where('is_active', true)->orderBy('name'),
        ])->get();

        $companies = Company::with('contacts')->orderBy('name')->get();

        $companiesData = $companies->map(fn($c) => [
            'id'       => $c->id,
            'name'     => $c->name,
            'contacts' => $c->contacts->map(fn($ct) => [
                'id'    => $ct->id,
                'name'  => $ct->name,
                'email' => $ct->email ?? null,
                'phone' => $ct->phone ?? null,
            ])->values(),
        ])->values();

        // Ambil semua user dengan role pic
        $pics = User::orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('order::admin.orders.create', compact('categories', 'companies', 'companiesData', 'pics'));
    }

    public function quickCreateCompany(Request $request): JsonResponse
    {
        $request->validate(['name' => 'required|string|max:255']);

        $company = Company::firstOrCreate(
            ['name' => $request->name],
            ['name' => $request->name]
        );

        return response()->json([
            'id'       => $company->id,
            'name'     => $company->name,
            'contacts' => $company->contacts ?? [],
            'created'  => $company->wasRecentlyCreated,
        ]);
    }

    public function quickCreateContact(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:50',
            'jabatan'      => 'nullable|string|max:50',
        ]);

        $contact = Contact::create([
            'company_id' => $request->company_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'jabatan'    => $request->jabatan,
        ]);

        return response()->json([
            'id'       => $contact->id,
            'name'     => $contact->name,
            'jabatan' => $contact->jabatan,
            'email'    => $contact->email,
            'phone'    => $contact->phone,
            'created'  => true,
        ]);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id'             => ['required', 'integer', 'exists:companies,id'],
            'contact_id'             => ['required', 'integer', 'exists:contacts,id'],
            'pic_id'                 => ['required', 'integer', 'exists:users,id'],
            'filled_by'              => ['required', 'in:customer,admin'],

            // Field tambahan — wajib hanya jika mode admin
            'tujuan_pengujian'       => ['required_if:filled_by,admin', 'nullable', 'string', 'max:1000'],
            'waktu_diharapkan'       => ['required_if:filled_by,admin', 'nullable', 'date', 'after_or_equal:today'],
            'keterangan_tambahan'    => ['nullable', 'string', 'max:2000'],

            // Validasi items hanya jika mode admin
            'items'                  => ['required_if:filled_by,admin', 'array', 'min:1'],
            'items.*.package_id'     => ['required_if:filled_by,admin', 'integer', 'exists:packages,id'],
            'items.*.qty'            => ['required_if:filled_by,admin', 'integer', 'min:1'],
            'items.*.custom_price'   => ['nullable', 'numeric', 'min:0'],
        ]);

        $contact = Contact::findOrFail($data['contact_id']);

        $order = Order::create([
            'company_id'          => $data['company_id'],
            'contact_id'          => $data['contact_id'],
            'pic_id'              => $data['pic_id'],
            'customer_name'       => $contact->name,
            'customer_slug'       => Str::slug($contact->name) . '-' . Str::random(6),
            'customer_email'      => $contact->email ?? '',
            'created_by'          => auth()->id(),
            'status'              => $data['filled_by'] === 'admin' ? Order::STATUS_APPROVED : Order::STATUS_DRAFT,
            'type'                => $data['filled_by'] === 'admin' ? Order::TYPE_INTERNAL : Order::TYPE_EXTERNAL,
            'tujuan_pengujian'    => $data['tujuan_pengujian']    ?? null,
            'waktu_diharapkan'    => $data['waktu_diharapkan']    ?? null,
            'keterangan_tambahan' => $data['keterangan_tambahan'] ?? null,
        ]);

        if ($data['filled_by'] === 'admin' && !empty($data['items'])) {
            $offer = $order->offer()->create([
                'notes' => null,
                'terms' => null,
            ]);

            foreach ($data['items'] as $item) {
                $package = Package::findOrFail($item['package_id']);

                $unitPrice = isset($item['custom_price']) && $item['custom_price'] !== null
                    ? (float) $item['custom_price']
                    : (float) $package->base_price;

                $offer->details()->create([
                    'package_id' => $package->id,
                    'qty'        => $item['qty'],
                    'price'      => $unitPrice,
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
        $order->load(['offer.details.package', 'creator', 'company','hasilUjiFiles']);

        $guestLink = route('orders.guest.show', [
            'slug'  => $order->company->slug,
            'token' => $order->access_token,
        ]);

        return view('order::admin.orders.show', compact('order', 'guestLink'));
    }

    public function updateExecution(Request $request, Order $order)
    {
        $validated = $request->validate([
            'waktu_pelaksanaan' => 'nullable|date',
            'lokasi_pelaksanaan' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        // 🔥 ambil ulang instance fresh + relasi lengkap
        $freshOrder = Order::with('offer.details')->find($order->id);

        return response()->json([
            'success' => true,
            'waktu_pelaksanaan' => $freshOrder->waktu_pelaksanaan
                ? \Carbon\Carbon::parse($freshOrder->waktu_pelaksanaan)->translatedFormat('l - d F Y')
                : '-',
            'lokasi_pelaksanaan' => $freshOrder->lokasi_pelaksanaan ?? '-',
            'can_open_pdf' => $freshOrder->canOpenMouKesanggupanPdf(),
        ]);
    }

    public function edit(Order $order)
    {
        $order->load(['company', 'contact', 'offer.details.package', 'creator']);

        return view('order::admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        Log::info('Mulai update order', [
            'order_id'   => $order->id,
            'order_code' => $order->order_code,
            'user_id'    => auth()->id(),
        ]);

        // =========================
        // FORMAT PRICE
        // =========================
        $items = $request->input('items', []);

        foreach ($items as $i => $item) {

            if (isset($item['price'])) {
                $items[$i]['price'] = str_replace('.', '', $item['price']);
            }
        }

        $request->merge([
            'items' => $items
        ]);

        Log::info('Items setelah formatting', [
            'items' => $items
        ]);

        // =========================
        // VALIDATION
        // =========================
        $data = $request->validate([

            'notes' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:order_offer_details,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.nama_mahasiswa' => ['nullable', 'string', 'max:255'],

            'offer_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'invoice_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        Log::info('Validasi berhasil');

        // =========================
        // OFFER
        // =========================
        $order->load('offer.details');

        $offer = $order->offer;

        if (! $offer) {

            $offer = $order->offer()->create([]);

            Log::info('Offer dibuat', [
                'offer_id' => $offer->id
            ]);
        }

        Log::info('Offer sebelum update', [
            'offer_id' => $offer->id,
            'old_notes' => $offer->notes,
            'old_terms' => $offer->terms,
        ]);

        $offer->update([
            'notes' => $data['notes'] ?? null,
            'terms' => $data['terms'] ?? null,
        ]);

        $offer->refresh();

        Log::info('Offer sesudah update', [
            'offer_id' => $offer->id,
            'new_notes' => $offer->notes,
            'new_terms' => $offer->terms,
        ]);

        // =========================
        // UPDATE ITEMS
        // =========================
        $allowedDetailIds = $offer->details()->pluck('id')->all();

        Log::info('Allowed detail ids', [
            'allowed_ids' => $allowedDetailIds
        ]);

        foreach ($data['items'] as $item) {

            Log::info('Memproses item', [
                'item' => $item
            ]);

            if (! in_array((int) $item['id'], $allowedDetailIds, true)) {

                Log::warning('Item tidak termasuk dalam offer', [
                    'detail_id' => $item['id']
                ]);

                continue;
            }

            $detail = OrderOfferDetail::find($item['id']);

            if (! $detail) {

                Log::warning('Detail tidak ditemukan', [
                    'detail_id' => $item['id']
                ]);

                continue;
            }

            Log::info('Detail sebelum update', [
                'detail_id' => $detail->id,
                'old_qty' => $detail->qty,
                'old_price' => $detail->price,
                'old_nama_mahasiswa' => $detail->nama_mahasiswa,
            ]);

            $updated = $detail->update([
                'qty' => (int) $item['qty'],
                'price' => (float) $item['price'],
                'nama_mahasiswa' => $item['nama_mahasiswa'] ?? null,
            ]);

            Log::info('Hasil update detail', [
                'detail_id' => $detail->id,
                'updated' => $updated,
            ]);

            $detail->refresh();

            Log::info('Detail sesudah update', [
                'detail_id' => $detail->id,
                'new_qty' => $detail->qty,
                'new_price' => $detail->price,
                'new_nama_mahasiswa' => $detail->nama_mahasiswa,
            ]);
        }

        // =========================
        // FILE UPLOAD
        // =========================
        $dir = 'orders/' . $order->order_code;

        if ($request->hasFile('offer_file')) {

            $path = $request->file('offer_file')
                ->storeAs($dir, 'penawaran.pdf');

            $offer->update([
                'offer_file_path' => $path
            ]);

            Log::info('Offer file berhasil diupload', [
                'path' => $path
            ]);
        }

        if ($request->hasFile('invoice_file')) {

            $path = $request->file('invoice_file')
                ->storeAs($dir, 'invoice.pdf');

            $offer->update([
                'invoice_file_path' => $path
            ]);

            Log::info('Invoice file berhasil diupload', [
                'path' => $path
            ]);
        }

        Log::info('Selesai update order', [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
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

        if (blank($order->contact->email)) {
            return back()->with('error', 'Email customer masih kosong. Lengkapi email terlebih dahulu sebelum mengirim penawaran.');
        }

        if (! $order->offer || $order->offer->details->isEmpty()) {
            return back()->with('error', 'Penawaran belum ada / item masih kosong.');
        }

        $mail = new OfferLinkMail($order);

        // =========================
        // ATTACH OFFER PDF
        // =========================
        if (
            filled($order->offer->offer_file_path) &&
            Storage::exists($order->offer->offer_file_path)
        ) {

            $mail->attach(
                Storage::path($order->offer->offer_file_path)
            );
        }

        // =========================
        // ATTACH INVOICE PDF
        // =========================
        if (
            filled($order->offer->invoice_file_path) &&
            Storage::exists($order->offer->invoice_file_path)
        ) {

            $mail->attach(
                Storage::path($order->offer->invoice_file_path)
            );
        }

        // =========================
        // SEND MAIL
        // =========================
        Mail::to($order->contact->email)->send($mail);

        // =========================
        // UPDATE STATUS
        // =========================
        $order->update([
            'status'  => Order::STATUS_OFFERED,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Email penawaran berhasil dikirim ke customer.');
    }

    // =====================================================================
    // HASIL UJI FILES
    // =====================================================================

    public function storeHasilUji(Request $request, Order $order)
    {
        $request->validate([
            'hasil_uji_files'   => ['required', 'array', 'min:1'],
            'hasil_uji_files.*' => [
                'required',
                'file',
                'max:20480',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,
                        jpg,jpeg,png,gif,webp,bmp,tiff,
                        mp4,mov,avi,mkv,
                        mp3,wav,
                        zip,rar,7z,
                        txt,csv,json,xml',
            ],
        ]);

        foreach ($request->file('hasil_uji_files') as $file) {

            // Double-check MIME type dari konten file, bukan hanya ekstensi
            $realMime = $file->getMimeType(); // dibaca dari magic bytes file

            $allowedMimes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff',
                'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-matroska',
                'audio/mpeg', 'audio/wav',
                'application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed',
                'text/plain', 'text/csv',
                'application/json', 'application/xml', 'text/xml',
                'application/vnd.oasis.opendocument.text',
                'application/vnd.oasis.opendocument.spreadsheet',
                'application/vnd.oasis.opendocument.presentation',
            ];

            if (!in_array($realMime, $allowedMimes)) {
                return back()
                    ->withErrors(['hasil_uji_files' => "File \"{$file->getClientOriginalName()}\" tidak diizinkan (tipe: {$realMime})."])
                    ->withInput();
            }

            $path = $file->storeAs(
                'hasil-uji/' . $order->id,
                $file->getClientOriginalName(),
                'private'
            );

            \App\Models\OrderFile::create([
                'order_id'       => $order->id,
                'hasil_uji_file' => $path,
                'file_name'      => $file->getClientOriginalName(),
            ]);
        }

        return back()->with('success_hasil_uji', count($request->file('hasil_uji_files')) . ' file berhasil diupload.');
    }

    public function showHasilUji(Order $order, \App\Models\OrderFile $file)
    {
        abort_if($file->order_id !== $order->id, 403);
        abort_unless(Storage::disk('private')->exists($file->hasil_uji_file), 404);

        return Storage::disk('private')->response(
            $file->hasil_uji_file,
            $file->file_name
        );
    }

    public function downloadHasilUji(Order $order, \App\Models\OrderFile $file)
    {
        abort_if($file->order_id !== $order->id, 403);
        abort_unless(Storage::disk('private')->exists($file->hasil_uji_file), 404);

        return Storage::disk('private')->download(
            $file->hasil_uji_file,
            $file->file_name
        );
    }

    public function destroyHasilUji(Order $order, \App\Models\OrderFile $file)
    {
        abort_if($file->order_id !== $order->id, 403);

        Storage::disk('private')->delete($file->hasil_uji_file);
        $file->delete();

        return back()->with('success_hasil_uji', 'File berhasil dihapus.');
    }
}