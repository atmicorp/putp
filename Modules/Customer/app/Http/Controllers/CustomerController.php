<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of companies with their contacts count.
     */
    public function index(Request $request)
    {
        $companies = Company::withCount('contacts')
            ->when($request->search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('contacts', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('customer::index', compact('companies'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * Store a newly created company with its contacts.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                        => 'required|string|max:255',
            'address'                     => 'nullable|string',
            'phone'                       => 'nullable|string|max:50',
            'contacts'                    => 'nullable|array',
            'contacts.*.name'             => 'required|string|max:255',
            'contacts.*.email'            => 'nullable|email|max:255',
            'contacts.*.phone'            => 'nullable|string|max:50',
            'contacts.*.signature'        => 'nullable|image|max:2048',
            'contacts.*.jabatan'          => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $company = Company::create($request->only('name', 'address', 'phone'));

            foreach ($request->contacts ?? [] as $contactData) {
                $signaturePath = null;
                if (isset($contactData['signature']) && $contactData['signature'] instanceof \Illuminate\Http\UploadedFile) {
                    $signaturePath = $contactData['signature']->store('signatures', 'public');
                }

                $company->contacts()->create([
                    'name'           => $contactData['name'],
                    'email'          => $contactData['email'] ?? null,
                    'phone'          => $contactData['phone'] ?? null,
                    'jabatan'        => $contactData['jabatan'] ?? null,
                    'signature_path' => $signaturePath,
                ]);
            }
        });

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Show the specified company with contacts and orders.
     */
    public function show(Company $company)
    {
        $company->load(['contacts', 'orders' => fn ($q) => $q->latest()->take(10)]);

        return view('customer::show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company)
    {
        $company->load('contacts');

        return view('customer::edit', compact('company'));
    }

    /**
     * Update the specified company and sync its contacts.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'                                  => 'required|string|max:255',
            'address'                               => 'nullable|string',
            'phone'                                 => 'nullable|string|max:50',
            'existing_contacts'                     => 'nullable|array',
            'existing_contacts.*.id'                => 'required|exists:contacts,id',
            'existing_contacts.*.name'              => 'required|string|max:255',
            'existing_contacts.*.email'             => 'nullable|email|max:255',
            'existing_contacts.*.phone'             => 'nullable|string|max:50',
            'existing_contacts.*.signature'         => 'nullable|image|max:2048',
            'existing_contacts.*.remove_signature'  => 'nullable|in:0,1',
            'existing_contacts.*._delete'           => 'nullable|in:0,1',
            'new_contacts'                          => 'nullable|array',
            'new_contacts.*.name'                   => 'required|string|max:255',
            'new_contacts.*.email'                  => 'nullable|email|max:255',
            'new_contacts.*.phone'                  => 'nullable|string|max:50',
            'new_contacts.*.signature'              => 'nullable|image|max:2048',
            'existing_contacts.*.jabatan' => 'nullable|string|max:50',
            'new_contacts.*.jabatan'      => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $company) {
            // Update company
            $company->update($request->only('name', 'address', 'phone'));

            // Handle existing contacts
            foreach ($request->existing_contacts ?? [] as $data) {
                $contact = Contact::find($data['id']);
                if (!$contact || $contact->company_id !== $company->id) continue;

                // Mark as deleted
                if (($data['_delete'] ?? '0') === '1') {
                    if ($contact->signature_path) {
                        Storage::disk('public')->delete($contact->signature_path);
                    }
                    $contact->delete();
                    continue;
                }

                // Remove signature if requested
                $signaturePath = $contact->signature_path;
                if (($data['remove_signature'] ?? '0') === '1' && $signaturePath) {
                    Storage::disk('public')->delete($signaturePath);
                    $signaturePath = null;
                }

                // Upload new signature
                if (isset($data['signature']) && $data['signature'] instanceof \Illuminate\Http\UploadedFile) {
                    if ($signaturePath) Storage::disk('public')->delete($signaturePath);
                    $signaturePath = $data['signature']->store('signatures', 'public');
                }

                $contact->update([
                    'name'           => $data['name'],
                    'email'          => $data['email'] ?? null,
                    'phone'          => $data['phone'] ?? null,
                    'jabatan'        => $data['jabatan'] ?? null, 
                    'signature_path' => $signaturePath,
                ]);
            }

            // Create new contacts
            foreach ($request->new_contacts ?? [] as $data) {
                $signaturePath = null;
                if (isset($data['signature']) && $data['signature'] instanceof \Illuminate\Http\UploadedFile) {
                    $signaturePath = $data['signature']->store('signatures', 'public');
                }

                $company->contacts()->create([
                    'name'           => $data['name'],
                    'email'          => $data['email'] ?? null,
                    'phone'          => $data['phone'] ?? null,
                    'jabatan'        => $data['jabatan'] ?? null, 
                    'signature_path' => $signaturePath,
                ]);
            }
        });

        return redirect()->route('customer.show', $company)
            ->with('success', 'Customer berhasil diperbarui.');
    }

    /**
     * Remove the specified company and its contacts.
     */
    public function destroy(Company $company)
    {
        $company->load('contacts');

        // Delete signature files
        foreach ($company->contacts as $contact) {
            if ($contact->signature_path) {
                Storage::disk('public')->delete($contact->signature_path);
            }
        }

        $company->delete(); // SoftDeletes handled by model

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil dihapus.');
    }
}