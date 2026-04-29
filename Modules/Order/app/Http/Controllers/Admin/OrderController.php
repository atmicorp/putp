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

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('order::admin.orders.index', compact('orders'));
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
        $pics = User::where('role', User::ROLE_PIC)
            ->orderBy('name')
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

            // Validasi items hanya jika mode admin
            'items'                  => ['required_if:filled_by,admin', 'array', 'min:1'],
            'items.*.package_id'     => ['required_if:filled_by,admin', 'integer', 'exists:packages,id'],
            'items.*.qty'            => ['required_if:filled_by,admin', 'integer', 'min:1'],
            'items.*.custom_price'   => ['nullable', 'numeric', 'min:0'],
        ]);

        $contact = Contact::findOrFail($data['contact_id']);

        $order = Order::create([
            'company_id'     => $data['company_id'],
            'contact_id'     => $data['contact_id'],
            'pic_id'         => $data['pic_id'], 
            'customer_name'  => $contact->name,
            'customer_slug'  => Str::slug($contact->name) . '-' . Str::random(6),
            'customer_email' => $contact->email ?? '',
            'created_by'     => auth()->id(),
            'status'         => Order::STATUS_DRAFT,
        ]);

        if ($data['filled_by'] === 'admin' && !empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $package = Package::findOrFail($item['package_id']);

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
        $order->load(['offer.details.package', 'creator', 'company']);

        $guestLink = route('orders.guest.show', [
            'slug'  => $order->company->slug,
            'token' => $order->access_token,
        ]);

        return view('order::admin.orders.show', compact('order', 'guestLink'));
    }

    public function edit(Order $order)
    {
        $order->load(['company', 'contact', 'offer.details.package', 'creator']);

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
            'company'  => ['required', 'string', 'max:255'],
            'contact'  => ['nullable', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255'],

            'notes' => ['nullable', 'string'],
            'terms' => ['nullable', 'string'],

            'items'          => ['required', 'array', 'min:1'],
            'items.*.id'     => ['required', 'integer', 'exists:order_offer_details,id'],
            'items.*.qty'    => ['required', 'integer', 'min:1'],
            'items.*.price'  => ['required', 'numeric', 'min:0'],
            'items.*.nama_mahasiswa' => ['nullable', 'string', 'max:255'],

            'offer_file'   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'invoice_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        // Update atau buat Company
        $company = $order->company
            ? tap($order->company)->update(['name' => $data['company']])
            : Company::create(['name' => $data['company']]);

        // Update atau buat Contact
        $contact = $order->contact
            ? tap($order->contact)->update([
                'name'  => $data['contact'] ?? $order->contact->name,
                'email' => $data['email']   ?? $order->contact->email,
            ])
            : ($data['contact']
                ? $company->contacts()->create([
                    'name'  => $data['contact'],
                    'email' => $data['email'] ?? null,
                ])
                : null);

        $order->update([
            'company_id' => $company->id,
            'contact_id' => $contact?->id,
        ]);

        // Offer
        $order->load('offer.details');
        $offer = $order->offer ?? $order->offer()->create([]);
        $offer->update([
            'notes' => $data['notes'] ?? null,
            'terms' => $data['terms'] ?? null,
        ]);

        // Update items
        $allowedDetailIds = $offer->details()->pluck('id')->all();

        foreach ($data['items'] as $item) {
            if (! in_array((int) $item['id'], $allowedDetailIds, true)) {
                continue;
            }

            OrderOfferDetail::where('id', $item['id'])->update([
                'qty'   => (int) $item['qty'],
                'price' => (float) $item['price'],
                'nama_mahasiswa' => $item['nama_mahasiswa'] ?? null,
            ]);
        }

        // Upload file
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

        if (blank($order->contact->email)) {
            return back()->with('error', 'Email customer masih kosong. Lengkapi email terlebih dahulu sebelum mengirim penawaran.');
        }

        if (!$order->offer || $order->offer->details->isEmpty()) {
            return back()->with('error', 'Penawaran belum ada / item masih kosong.');
        }

        $mail = new OfferLinkMail($order);

        // Attach PDF files if available (public disk)
        if (filled($order->offer->offer_file_path) && Storage::disk('public')->exists($order->offer->offer_file_path)) {
            $mail->attach(Storage::disk('public')->path($order->offer->offer_file_path));
        }
        if (filled($order->offer->invoice_file_path) && Storage::disk('public')->exists($order->offer->invoice_file_path)) {
            $mail->attach(Storage::disk('public')->path($order->offer->invoice_file_path));
        }

        Mail::to($order->contact->email)->send($mail);

        $order->update([
            'status'  => Order::STATUS_OFFERED,
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Email penawaran berhasil dikirim ke customer.');
    }

    public function PermohonanKerjasama(Order $order)
    {
        $order->load(['company', 'contact', 'creator', 'offer.details.package']);

        $pdf = Pdf::loadView('order::admin.orders.permohonan_kerjasama', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("PermohonanKerjasama-{$order->order_code}.pdf");
    }
}