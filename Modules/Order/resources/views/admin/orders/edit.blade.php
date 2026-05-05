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
        *, *::before, *::after { box-sizing: border-box; }

        /* ── Card ── */
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .card-header {
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .card-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: #fff7ed;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .card-title { font-size: 13.5px; font-weight: 800; color: #111827; }
        .card-sub   { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }
        .card-body  { padding: 18px; }

        /* ── Form Elements ── */
        label {
            display: block; font-size: 11.5px; font-weight: 700;
            color: #374151; margin-bottom: 6px; letter-spacing: 0.1px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%; padding: 10px 12px;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: 13px; color: #111827;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            -webkit-appearance: none;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.08);
        }
        input[type="file"] {
            padding: 8px 12px;
            background: #fafafa;
            cursor: pointer;
            font-size: 12.5px;
        }
        textarea { min-height: 90px; resize: vertical; line-height: 1.55; }

        /* ── Grid ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        @media (max-width: 580px) {
            .grid-2 { grid-template-columns: 1fr; }
        }

        /* ── Help / Error ── */
        .help { font-size: 12px; color: #6b7280; line-height: 1.55; margin-top: 6px; }
        .help code {
            background: #f3f4f6; padding: 1px 5px; border-radius: 4px;
            font-size: 11px; color: #374151;
        }
        .err { font-size: 12px; color: #dc2626; margin-top: 5px; }

        /* ── Items Table ── */
        .table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 10px;
            border: 1px solid #f3f4f6;
        }
        .scroll-hint {
            display: none;
            font-size: 11px; color: #9ca3af;
            text-align: right;
            padding: 0 2px 6px;
            align-items: center; gap: 4px; justify-content: flex-end;
        }
        @media (max-width: 640px) { .scroll-hint { display: flex; } }

        .items { width: 100%; border-collapse: collapse; min-width: 560px; }
        .items th {
            text-align: left; padding: 10px 12px;
            font-size: 10.5px; color: #9ca3af;
            text-transform: uppercase; letter-spacing: .4px;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }
        .items td {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
            vertical-align: top;
        }
        .items tr:last-child td { border-bottom: none; }
        .items tbody tr:hover { background: #fffbf7; }
        .r { text-align: right; }
        .pkg  { font-weight: 700; color: #111827; }
        .muted { font-size: 11.5px; color: #9ca3af; margin-top: 3px; }

        /* number input in table: compact */
        .items td input[type="number"],
        .items td input[type="text"] {
            min-width: 0;
        }
        .items td.r input {
            text-align: right;
        }

        /* ── File Upload Zone ── */
        .file-group { }
        .file-label-row {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 6px; margin-bottom: 6px;
        }
        .file-saved {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 11.5px; font-weight: 600; color: #15803d;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            padding: 3px 10px; border-radius: 20px;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 11px 18px; border-radius: 10px; border: none; cursor: pointer;
            font-size: 13px; font-weight: 700; text-decoration: none;
            transition: all 0.15s; min-height: 44px;
        }
        .btn-primary { background: #ea580c; color: #fff; }
        .btn-primary:hover { background: #c2410c; box-shadow: 0 4px 14px rgba(234,88,12,0.25); }
        .btn-ghost {
            background: #fff; border: 1.5px solid #e5e7eb; color: #374151;
        }
        .btn-ghost:hover { border-color: #ea580c; color: #ea580c; }

        .action-bar {
            display: flex; gap: 10px; flex-wrap: wrap;
            padding: 4px 0 20px;
        }
        @media (max-width: 400px) {
            .action-bar { flex-direction: column; }
            .action-bar .btn { width: 100%; }
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center; padding: 32px 20px; color: #9ca3af;
        }
        .empty-state .icon { font-size: 28px; margin-bottom: 10px; }
        .empty-state .title { font-size: 13.5px; font-weight: 600; color: #374151; }
        .empty-state .desc  { font-size: 12.5px; margin-top: 4px; }
    </style>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ── Item yang Dipilih Customer ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <div class="card-title">Item yang Dipilih Customer</div>
                    <div class="card-sub">Admin dapat menyesuaikan harga satuan dan qty</div>
                </div>
            </div>
            <div class="card-body">
                @php $details = $order->offer?->details ?? collect(); @endphp
                @if($details->isEmpty())
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <div class="title">Belum ada item</div>
                        <div class="desc">Tunggu customer submit dari halaman keranjang.</div>
                    </div>
                @else
                    <div class="scroll-hint">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        Geser untuk lihat selengkapnya
                    </div>
                    <div class="table-wrap">
                        <table class="items">
                            <thead>
                                <tr>
                                    <th>Paket</th>
                                    <th class="r" style="width:100px;">Qty</th>
                                    <th class="r" style="width:160px;">Harga Satuan</th>
                                    <th class="r" style="width:160px;">Nama Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $i => $d)
                                    <tr>
                                        <td>
                                            <div class="pkg">{{ $d->package?->name ?? 'Paket dihapus' }}</div>
                                            <div class="muted">ID: {{ $d->package_id }}</div>
                                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $d->id }}">
                                            @error("items.$i.id")<div class="err">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="number" min="1" name="items[{{ $i }}][qty]"
                                                value="{{ old("items.$i.qty", $d->qty) }}">
                                            @error("items.$i.qty")<div class="err">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="text" inputmode="numeric" name="items[{{ $i }}][price]"
                                                value="{{ number_format(old("items.$i.price", $d->price), 0, ',', '.') }}">
                                            @error("items.$i.price")<div class="err">{{ $message }}</div>@enderror
                                        </td>
                                        <td class="r">
                                            <input type="text" name="items[{{ $i }}][nama_mahasiswa]"
                                                value="{{ old("items.$i.nama_mahasiswa", $d->nama_mahasiswa) }}">
                                            @error("items.$i.nama_mahasiswa")<div class="err">{{ $message }}</div>@enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Catatan & Syarat ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="card-title">Catatan & Syarat</div>
                    <div class="card-sub">Akan ikut ditampilkan di email penawaran</div>
                </div>
            </div>
            <div class="card-body">
                <div class="grid-2">
                    <div>
                        <label>Catatan</label>
                        <textarea name="notes" placeholder="Tambahkan catatan...">{{ old('notes', $order->offer?->notes) }}</textarea>
                        @error('notes')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label>Syarat & Ketentuan</label>
                        <textarea name="terms" placeholder="Tambahkan syarat & ketentuan...">{{ old('terms', $order->offer?->terms) }}</textarea>
                        @error('terms')<div class="err">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Upload File ── --}}
        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="card-title">Upload File (PDF)</div>
                    <div class="card-sub">Wajib sebelum mengirim penawaran ke customer</div>
                </div>
            </div>
            <div class="card-body">
                <div class="grid-2">
                    <div class="file-group">
                        <div class="file-label-row">
                            <label style="margin:0;">File Penawaran (PDF)</label>
                            @if(filled($order->offer?->offer_file_path))
                                <span class="file-saved">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Tersimpan
                                </span>
                            @endif
                        </div>
                        <input type="file" name="offer_file" accept="application/pdf">
                        @if(filled($order->offer?->offer_file_path))
                            <div class="help" style="margin-top:5px;">
                                {{ basename($order->offer->offer_file_path) }}
                            </div>
                        @endif
                        @error('offer_file')<div class="err">{{ $message }}</div>@enderror
                    </div>

                    <div class="file-group">
                        <div class="file-label-row">
                            <label style="margin:0;">File Invoice (PDF)</label>
                            @if(filled($order->offer?->invoice_file_path))
                                <span class="file-saved">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Tersimpan
                                </span>
                            @endif
                        </div>
                        <input type="file" name="invoice_file" accept="application/pdf">
                        @if(filled($order->offer?->invoice_file_path))
                            <div class="help" style="margin-top:5px;">
                                {{ basename($order->offer->invoice_file_path) }}
                            </div>
                        @endif
                        @error('invoice_file')<div class="err">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="help" style="margin-top:14px; padding-top:14px; border-top:1px solid #f3f4f6;">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:-1px;margin-right:3px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    File disimpan ke: <code>storage/app/public/orders/{{ $order->order_code }}/</code>
                </div>
            </div>
        </div>

        {{-- ── Action Bar ── --}}
        <div class="action-bar">
            <button class="btn btn-primary" type="submit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Perubahan
            </button>
            <a class="btn btn-ghost" href="{{ route('admin.orders.show', $order) }}">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Batal
            </a>
        </div>

    </form>

</x-app-sidebar>