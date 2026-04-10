<x-app-sidebar>
    <x-slot name="title">Edit Order</x-slot>

    <x-slot name="breadcrumb">
        <span>Order</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.orders.index') }}" style="color:#ea580c;text-decoration:none;">Order List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.orders.show', $order) }}" style="color:#ea580c;text-decoration:none;">{{ $order->order_code }}</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Edit</span>
    </x-slot>

    <style>
        * { box-sizing: border-box; }
        .wrap { max-width: 1100px; }
        .card { background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;margin-bottom:18px; }
        .card-header { padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between; }
        .card-title { font-size:14px;font-weight:800;color:#111827; }
        .card-sub { font-size:12px;color:#9ca3af;margin-top:2px; }
        .card-body { padding:20px; }

        label { display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px; }
        input, textarea { width:100%; padding:10px 12px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:13px; }
        textarea { min-height: 90px; resize: vertical; }

        .grid { display:grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .grid-1 { display:grid; grid-template-columns: 1fr; gap: 14px; }
        .items { width:100%; border-collapse: collapse; }
        .items th { text-align:left; padding:10px 12px; font-size:11px; color:#9ca3af; text-transform:uppercase; letter-spacing:.4px; background:#fafafa; border-bottom:1px solid #f3f4f6; }
        .items td { padding:10px 12px; border-bottom:1px solid #f3f4f6; font-size:13px; vertical-align:top; }
        .items tr:last-child td { border-bottom:none; }
        .r { text-align:right; }
        .pkg { font-weight:700;color:#111827; }
        .muted { font-size:12px;color:#9ca3af;margin-top:3px; }

        .btn {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:10px 14px; border-radius:10px; border:none; cursor:pointer;
            font-size:13px; font-weight:800; text-decoration:none;
        }
        .btn-primary { background:#ea580c; color:#fff; }
        .btn-primary:hover { background:#c2410c; }
        .btn-ghost { background:#fff; border:1.5px solid #e5e7eb; color:#374151; }
        .btn-ghost:hover { border-color:#ea580c; color:#ea580c; }

        .help { font-size:12px;color:#6b7280;line-height:1.55;margin-top:8px; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
    </style>

    <div class="wrap">
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informasi Customer</div>
                        <div class="card-sub">Edit data customer & email untuk pengiriman penawaran</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid">
                        <div>
                            <label>Nama Customer</label>
                            <input name="company" value="{{ old('company', $order->company->name ?? '') }}" required>
                            @error('company')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div><div>
                            <label>Nama Contact</label>
                            <input name="contact" type="text" value="{{ old('contact', $order->contact->name ?? '') }}">
                            @error('contact')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label>Email Customer (opsional sampai siap kirim)</label>
                            <input name="email" type="email" value="{{ old('email', $order->contact->email ?? '') }}">
                            @error('email')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Item yang Dipilih Customer</div>
                        <div class="card-sub">Admin dapat menyesuaikan harga satuan dan qty</div>
                    </div>
                </div>
                <div class="card-body">
                    @php $details = $order->offer?->details ?? collect(); @endphp
                    @if($details->isEmpty())
                        <div class="help">Belum ada item. Tunggu customer submit dari halaman keranjang.</div>
                    @else
                        <table class="items">
                            <thead>
                                <tr>
                                    <th>Paket</th>
                                    <th class="r" style="width:110px;">Qty</th>
                                    <th class="r" style="width:180px;">Harga Satuan</th>
                                    <th class="r" style="width:180px;">Nama Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $i => $d)
                                    <tr>
                                        <td>
                                            <div class="pkg">{{ $d->package?->name ?? 'Paket dihapus' }}</div>
                                            <div class="muted">Package ID: {{ $d->package_id }}</div>
                                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $d->id }}">
                                            @error("items.$i.id")<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="number" min="1" name="items[{{ $i }}][qty]" value="{{ old("items.$i.qty", $d->qty) }}">
                                            @error("items.$i.qty")<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="text" inputmode="numeric" name="items[{{ $i }}][price]" value="{{ number_format(old("items.$i.price", $d->price), 0, ',', '.') }}">
                                            @error("items.$i.price")<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="text" inputmode="text" name="items[{{ $i }}][nama_mahasiswa]" value="{{ old("items.$i.nama_mahasiswa", $d->nama_mahasiswa) }}">
                                            @error("items.$i.nama_mahasiswa")<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Catatan & Syarat</div>
                        <div class="card-sub">Akan ikut di email penawaran</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid">
                        <div>
                            <label>Catatan</label>
                            <textarea name="notes">{{ old('notes', $order->offer?->notes) }}</textarea>
                            @error('notes')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label>Syarat & Ketentuan</label>
                            <textarea name="terms">{{ old('terms', $order->offer?->terms) }}</textarea>
                            @error('terms')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Upload File (PDF)</div>
                        <div class="card-sub">Wajib sebelum kirim penawaran ke customer</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="grid">
                        <div>
                            <label>File Penawaran (PDF)</label>
                            <input type="file" name="offer_file" accept="application/pdf">
                            @if(filled($order->offer?->offer_file_path))
                                <div class="help">Tersimpan: {{ $order->offer->offer_file_path }}</div>
                            @endif
                            @error('offer_file')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label>File Invoice (PDF)</label>
                            <input type="file" name="invoice_file" accept="application/pdf">
                            @if(filled($order->offer?->invoice_file_path))
                                <div class="help">Tersimpan: {{ $order->offer->invoice_file_path }}</div>
                            @endif
                            @error('invoice_file')<div class="help" style="color:#dc2626;">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="help">File disimpan ke storage public: <code>storage/app/public/orders/{ORDER_CODE}/</code>.</div>
                </div>
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <button class="btn btn-primary" type="submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
                <a class="btn btn-ghost" href="{{ route('admin.orders.show', $order) }}">Batal</a>
            </div>
        </form>
    </div>
</x-app-sidebar>

