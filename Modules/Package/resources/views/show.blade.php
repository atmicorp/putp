<x-app-sidebar>
    <x-slot name="title">Detail Package</x-slot>

    <x-slot name="breadcrumb">
        <span>Package</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('package.index') }}" style="color:#6b7280;text-decoration:none;">Package List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">{{ $package->name }}</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('package.edit', $package) }}" class="btn-secondary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <form action="{{ route('package.destroy', $package) }}" method="POST" id="deleteForm">
            @csrf @method('DELETE')
            <button type="button" onclick="confirmDelete()" class="btn-danger-sm">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                Hapus
            </button>
        </form>
    </x-slot>

    <style>
        .btn-secondary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fff; color: #374151;
            border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif; cursor: pointer;
        }
        .btn-secondary-sm:hover { border-color: #d1d5db; background: #f9fafb; }

        .btn-danger-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fef2f2; color: #dc2626;
            border: 1px solid #fecaca; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-danger-sm:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* Summary Bar */
        .summary-bar {
            display: flex; align-items: center; gap: 16px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 20px 24px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .summary-icon {
            width: 48px; height: 48px; background: #fff7ed; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .summary-name { font-size: 18px; font-weight: 700; color: #1c1917; }
        .summary-price {
            font-size: 22px; font-weight: 800; color: #ea580c;
            font-variant-numeric: tabular-nums; line-height: 1; margin-top: 2px;
        }
        .summary-price-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }

        .summary-divider { width: 1px; height: 40px; background: #e5e7eb; flex-shrink: 0; }

        .summary-meta { display: flex; flex-direction: column; gap: 4px; }
        .summary-meta-row { font-size: 12.5px; color: #6b7280; display: flex; align-items: center; gap: 6px; }
        .summary-meta-row strong { color: #1c1917; font-weight: 600; }

        .summary-badge { margin-left: auto; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-active   { background: #f0fdf4; color: #16a34a; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
        .dot-active   { background: #16a34a; }
        .dot-inactive { background: #9ca3af; }

        /* Grid */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
        .col-full { grid-column: 1 / -1; }

        /* Cards */
        .detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .detail-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px; border-bottom: 1px solid #f3f4f6; background: #fafafa;
        }
        .detail-card-title { font-size: 13px; font-weight: 700; color: #1c1917; display: flex; align-items: center; gap: 6px; }
        .count-pill {
            font-size: 11px; font-weight: 600; color: #6b7280;
            background: #f3f4f6; border: 1px solid #e5e7eb;
            padding: 2px 8px; border-radius: 20px;
        }

        /* Info rows */
        .info-row {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding: 12px 20px; border-bottom: 1px solid #f9fafb; gap: 16px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-key { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; white-space: nowrap; padding-top: 1px; }
        .info-val { font-size: 13.5px; color: #1c1917; font-weight: 500; text-align: right; max-width: 280px; }
        .info-val.muted { color: #9ca3af; font-weight: 400; font-style: italic; }
        .info-val.price { font-size: 15px; font-weight: 800; color: #ea580c; font-variant-numeric: tabular-nums; }

        /* PIC card */
        .pic-row {
            display: flex; align-items: center; gap: 12px; padding: 16px 20px;
        }
        .pic-avatar {
            width: 40px; height: 40px; border-radius: 50%; background: #ea580c;
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; flex-shrink: 0;
        }
        .pic-name { font-size: 14px; font-weight: 700; color: #1c1917; }
        .pic-sub  { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        /* Offer Details table */
        .offers-table { width: 100%; border-collapse: collapse; }
        .offers-table thead th {
            padding: 10px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .offers-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        .offers-table tbody tr:last-child { border-bottom: none; }
        .offers-table tbody tr:hover { background: #fff7ed; }
        .offers-table td { padding: 12px 20px; font-size: 13px; vertical-align: middle; color: #374151; }

        .empty-inline { padding: 32px 20px; text-align: center; }
        .empty-inline-icon { font-size: 28px; margin-bottom: 8px; }
        .empty-inline-text { font-size: 13px; color: #9ca3af; }

        .timestamps { display: flex; gap: 24px; padding: 14px 20px; flex-wrap: wrap; border-top: 1px solid #f3f4f6; }
        .ts-item { display: flex; flex-direction: column; gap: 2px; }
        .ts-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; }
        .ts-value { font-size: 12.5px; color: #6b7280; }

          /* Mobile cards */
        .od-mobile  { display: block; }
        .od-desktop { display: none; }

        .od-card {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .od-card:last-child { border-bottom: none; }

        .od-card-top {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }
        .od-num {
            font-size: 11.5px;
            color: #d1d5db;
            font-weight: 500;
            flex-shrink: 0;
        }
        .od-order {
            font-size: 13.5px;
            font-weight: 600;
            color: #1c1917;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .od-price {
            font-size: 14px;
            font-weight: 800;
            color: #ea580c;
            font-variant-numeric: tabular-nums;
            flex-shrink: 0;
        }
        .od-card-bot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .od-meta {
            font-size: 12px;
            color: #9ca3af;
        }
        .od-meta strong {
            color: #6b7280;
            font-weight: 600;
        }

        @media (min-width: 640px) {
            .od-mobile  { display: none; }
            .od-desktop { display: block; }
    }
    </style>

    {{-- Summary Bar --}}
    @php $status = $package->is_active ? 'active' : 'inactive'; @endphp
    <div class="summary-bar">
        <div class="summary-icon">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <div class="summary-name">{{ $package->name }}</div>
            <div style="font-size:12px;color:#9ca3af;margin-top:3px;">
                {{ $package->machine?->name ?? 'No Machine' }}
                @if($package->machine) &nbsp;·&nbsp; <code style="font-size:11px;">{{ $package->machine->code }}</code> @endif
            </div>
        </div>
        <div class="summary-divider"></div>
        <div>
            <div class="summary-price-label">Base Price</div>
            <div class="summary-price">Rp {{ number_format($package->base_price, 0, ',', '.') }}</div>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-meta">
            <div class="summary-meta-row">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                PIC: <strong>{{ $package->picOperator?->name ?? 'Tidak ada' }}</strong>
            </div>
            <div class="summary-meta-row">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                {{ $package->offerDetails->count() }} offer detail
            </div>
        </div>
        <div class="summary-badge">
            <span class="badge badge-{{ $status }}">
                <span class="dot dot-{{ $status }}"></span>
                {{ $package->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    {{-- Grid --}}
    <div class="detail-grid">

        {{-- Info Umum --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Umum
                </div>
            </div>
            <div class="info-row">
                <span class="info-key">Nama</span>
                <span class="info-val">{{ $package->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Mesin</span>
                <span class="info-val">{{ $package->machine?->name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Kode Mesin</span>
                <span class="info-val">
                    @if($package->machine)
                        <code style="background:#f3f4f6;padding:2px 8px;border-radius:4px;font-size:12px;border:1px solid #e5e7eb;">{{ $package->machine->code }}</code>
                    @else
                        <span class="muted">-</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-key">Base Price</span>
                <span class="info-val price">Rp {{ number_format($package->base_price, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Status</span>
                <span class="info-val">
                    <span class="badge badge-{{ $status }}">
                        <span class="dot dot-{{ $status }}"></span>
                        {{ $package->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-key">Deskripsi</span>
                <span class="info-val {{ !$package->description ? 'muted' : '' }}" style="font-size:13px;">
                    {{ $package->description ?? 'Tidak ada deskripsi' }}
                </span>
            </div>
            <div class="timestamps">
                <div class="ts-item">
                    <span class="ts-label">Dibuat</span>
                    <span class="ts-value">{{ $package->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="ts-item">
                    <span class="ts-label">Diperbarui</span>
                    <span class="ts-value">{{ $package->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- PIC Operator --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    PIC Operator
                </div>
            </div>
            @if($package->picOperator)
                <div class="pic-row">
                    <div class="pic-avatar">{{ strtoupper(substr($package->picOperator->name, 0, 1)) }}</div>
                    <div>
                        <div class="pic-name">{{ $package->picOperator->name }}</div>
                        @if(isset($package->picOperator->code))
                            <div class="pic-sub">{{ $package->picOperator->code }}</div>
                        @endif
                        <div class="pic-sub" style="margin-top:4px;">Penanggungjawab package ini</div>
                    </div>
                </div>
            @else
                <div class="empty-inline">
                    <div class="empty-inline-icon">👤</div>
                    <div class="empty-inline-text">Belum ada PIC operator</div>
                </div>
            @endif
        </div>

        {{-- Offer Details --}}
        <div class="detail-card col-full">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Offer Details
                </div>
                <span class="count-pill">{{ $package->offerDetails->count() }}</span>
            </div>

            @if($package->offerDetails->isEmpty())
                <div class="empty-inline">
                    <div class="empty-inline-icon">📋</div>
                    <div class="empty-inline-text">Package ini belum digunakan di penawaran manapun</div>
                </div>
            @else
                {{-- ===== MOBILE CARDS ===== --}}
                <div class="od-mobile">
                    @foreach($package->offerDetails as $detail)
                    <div class="od-card">
                        <div class="od-card-top">
                            <span class="od-num">#{{ $loop->iteration }}</span>
                            <span class="od-order">{{ $detail->order?->order_code ?? '#'.$detail->id }}</span>
                            <span class="od-price">Rp {{ number_format($detail->price ?? $package->base_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="od-card-bot">
                            <span class="od-meta">Qty: <strong>{{ $detail->qty ?? '-' }}</strong></span>
                            <span class="od-meta">{{ $detail->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- ===== DESKTOP TABLE ===== --}}
                <div class="od-desktop">
                    <table class="offers-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order / Penawaran</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($package->offerDetails as $detail)
                            <tr>
                                <td style="color:#9ca3af;font-size:12.5px;">{{ $loop->iteration }}</td>
                                <td style="font-weight:500;">{{ $detail->order?->order_code ?? '#'.$detail->id }}</td>
                                <td style="color:#6b7280;">{{ $detail->qty ?? '-' }}</td>
                                <td style="font-weight:700;color:#ea580c;font-variant-numeric:tabular-nums;">
                                    Rp {{ number_format($detail->price ?? $package->base_price, 0, ',', '.') }}
                                </td>
                                <td style="color:#9ca3af;font-size:12.5px;">{{ $detail->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script>
        function confirmDelete() {
            if (confirm('Hapus package "{{ addslashes($package->name) }}"? Tindakan ini tidak bisa dibatalkan.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</x-app-sidebar>