<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Customer List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('customer.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Customer
        </a>
    </x-slot>

    <style>
        /* ─── Base ─── */
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 24px; }

        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
            white-space: nowrap;
        }
        .btn-primary-sm:hover { background: #c2410c; }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ─── Stats ─── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 16px 18px; position: relative; overflow: hidden;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #ea580c; border-radius: 3px 3px 0 0; }
        .stat-card:nth-child(2)::before { background: #f59e0b; }
        .stat-card:nth-child(3)::before { background: #3b82f6; }
        .stat-card:nth-child(4)::before { background: #10b981; }
        .stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 26px; font-weight: 700; color: #1c1917; margin-top: 4px; line-height: 1; }
        .stat-desc  { font-size: 11px; color: #b0b8c4; margin-top: 4px; }

        /* ─── Table Card ─── */
        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }

        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; border-bottom: 1px solid #f3f4f6; gap: 10px; flex-wrap: wrap;
        }
        .toolbar-left { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; }

        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 12px; flex: 1; min-width: 0;
        }
        .search-wrap input { background: transparent; border: none; outline: none; font-size: 13px; font-family: 'Sora', sans-serif; color: #1c1917; width: 100%; min-width: 0; }
        .search-wrap input::placeholder { color: #9ca3af; }

        .reset-link {
            font-size: 12px; color: #9ca3af; text-decoration: none; font-weight: 500;
            white-space: nowrap; display: flex; align-items: center; gap: 4px; flex-shrink: 0;
        }

        .record-count { font-size: 12px; color: #9ca3af; font-weight: 500; white-space: nowrap; flex-shrink: 0; }

        /* ─── Desktop Table ─── */
        .desktop-table { display: block; }
        .mobile-cards  { display: none; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }
        td { padding: 13px 16px; font-size: 13px; vertical-align: middle; }

        .company-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .company-sub  { font-size: 11.5px; color: #b0b8c4; margin-top: 2px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

        .contact-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 9px; background: #eff6ff; border-radius: 20px;
            font-size: 12px; font-weight: 600; color: #2563eb;
        }

        .text-muted { font-size: 12.5px; color: #6b7280; }
        .text-sm    { font-size: 13px; color: #374151; }

        .actions { display: flex; align-items: center; gap: 4px; }
        .act-btn {
            padding: 5px 11px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s; display: inline-flex; align-items: center;
        }
        .act-view       { background: #fff7ed; color: #ea580c; }
        .act-view:hover { background: #ffedd5; }
        .act-edit       { background: #eff6ff; color: #2563eb; }
        .act-edit:hover { background: #dbeafe; }
        .act-delete       { background: transparent; color: #9ca3af; padding: 5px 8px; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }

        /* ─── Mobile Cards ─── */
        .cust-card {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .cust-card:last-child { border-bottom: none; }

        .cust-card-header {
            display: flex; align-items: flex-start; justify-content: space-between; gap: 8px;
            margin-bottom: 10px;
        }
        .cust-card-name { font-weight: 700; font-size: 14px; color: #1c1917; line-height: 1.3; }
        .cust-card-slug { font-size: 11.5px; color: #b0b8c4; margin-top: 2px; }

        .cust-card-body {
            display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
            margin-bottom: 12px;
        }
        .cust-info-item { display: flex; flex-direction: column; gap: 2px; }
        .cust-info-label {
            font-size: 10px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px; color: #b0b8c4;
        }
        .cust-info-value { font-size: 12.5px; color: #374151; font-weight: 500; }
        .cust-info-value.muted { color: #9ca3af; font-weight: 400; }

        .cust-card-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 10px; border-top: 1px solid #f9fafb;
        }

        .mobile-actions { display: flex; gap: 6px; align-items: center; }
        .mob-act-view   { padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 600; background: #fff7ed; color: #ea580c; text-decoration: none; font-family: 'Sora', sans-serif; }
        .mob-act-edit   { padding: 6px 14px; border-radius: 7px; font-size: 12px; font-weight: 600; background: #eff6ff; color: #2563eb; text-decoration: none; font-family: 'Sora', sans-serif; }
        .mob-act-delete { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 7px; background: transparent; border: none; color: #9ca3af; cursor: pointer; font-family: 'Sora', sans-serif; }
        .mob-act-delete:hover { background: #fef2f2; color: #dc2626; }

        /* ─── Pagination ─── */
        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid #f3f4f6; flex-wrap: wrap; gap: 8px; }
        .page-info { font-size: 12px; color: #9ca3af; }
        .page-btns { display: flex; gap: 4px; flex-wrap: wrap; }
        .page-btn {
            min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer;
            border: 1px solid #e5e7eb; background: #fff; color: #6b7280;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
            padding: 0 6px;
        }
        .page-btn:hover  { border-color: #ea580c; color: #ea580c; }
        .page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
        .page-btn.disabled { opacity: 0.35; pointer-events: none; }

        /* ─── Empty State ─── */
        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-icon  { font-size: 36px; margin-bottom: 10px; }
        .empty-title { font-size: 15px; font-weight: 600; color: #1c1917; }
        .empty-sub   { font-size: 13px; color: #9ca3af; margin-top: 4px; }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .dash-title    { font-size: 18px; }
            .dash-subtitle { font-size: 12px; margin-bottom: 16px; }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-bottom: 16px;
            }
            .stat-card  { padding: 12px 14px; }
            .stat-value { font-size: 22px; }
            .stat-desc  { display: none; }

            .desktop-table { display: none; }
            .mobile-cards  { display: block; }

            .table-toolbar { padding: 12px 14px; }
        }

        @media (max-width: 480px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .stat-card  { padding: 10px 12px; }
            .stat-label { font-size: 10px; }
            .stat-value { font-size: 20px; }

            .pagination { flex-direction: column; align-items: flex-start; }
        }
    </style>

    <div class="dash-title">Customer</div>
    <p class="dash-subtitle">Data Perusahaan & Kontak</p>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Company</div>
            <div class="stat-value">{{ $companies->total() }}</div>
            <div class="stat-desc">Semua perusahaan</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Contact</div>
            <div class="stat-value">{{ \App\Models\Contact::count() }}</div>
            <div class="stat-desc">Semua kontak terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Punya Order</div>
            <div class="stat-value">{{ \App\Models\Company::has('orders')->count() }}</div>
            <div class="stat-desc">Perusahaan dengan order</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Baru Bulan Ini</div>
            <div class="stat-value">{{ \App\Models\Company::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}</div>
            <div class="stat-desc">Didaftarkan bulan ini</div>
        </div>
    </div>

    {{-- Table / Cards --}}
    <div class="table-card">
        <form method="GET" action="{{ route('customer.index') }}" id="filterForm">
            <div class="table-toolbar">
                <div class="toolbar-left">
                    <div class="search-wrap">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari perusahaan atau kontak..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </div>
                    @if(request()->hasAny(['search']))
                        <a href="{{ route('customer.index') }}" class="reset-link">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
                <span class="record-count">{{ $companies->total() }} records</span>
            </div>
        </form>

        @if($companies->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🏢</div>
                <div class="empty-title">Tidak ada customer ditemukan</div>
                <div class="empty-sub">Coba ubah filter atau <a href="{{ route('customer.index') }}" style="color:#ea580c;">reset filter</a></div>
            </div>
        @else

            {{-- ── DESKTOP TABLE ── --}}
            <div class="desktop-table">
                <table>
                    <thead>
                        <tr>
                            <th>Perusahaan</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Kontak</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>
                                    <div class="company-name">{{ $company->name }}</div>
                                    <span class="company-sub">{{ $company->slug }}</span>
                                </td>
                                <td><span class="text-muted">{{ $company->address ?? '—' }}</span></td>
                                <td><span class="text-sm">{{ $company->phone ?? '—' }}</span></td>
                                <td>
                                    <span class="contact-badge">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                                        {{ $company->contacts_count ?? $company->contacts->count() }}
                                    </span>
                                </td>
                                <td><span class="text-muted">{{ $company->created_at->format('d M Y') }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('customer.show', $company) }}" class="act-btn act-view">Detail</a>
                                        <a href="{{ route('customer.edit', $company) }}" class="act-btn act-edit">Edit</a>
                                        <form action="{{ route('customer.destroy', $company) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="act-btn act-delete" title="Hapus">
                                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ── MOBILE CARDS ── --}}
            <div class="mobile-cards">
                @foreach($companies as $company)
                    <div class="cust-card">
                        <div class="cust-card-header">
                            <div>
                                <div class="cust-card-name">{{ $company->name }}</div>
                                <div class="cust-card-slug">{{ $company->slug }}</div>
                            </div>
                            <span class="contact-badge" style="flex-shrink:0;margin-top:2px;">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                                {{ $company->contacts_count ?? $company->contacts->count() }} kontak
                            </span>
                        </div>

                        <div class="cust-card-body">
                            <div class="cust-info-item">
                                <span class="cust-info-label">Alamat</span>
                                <span class="cust-info-value {{ !$company->address ? 'muted' : '' }}">
                                    {{ $company->address ?? '—' }}
                                </span>
                            </div>
                            <div class="cust-info-item">
                                <span class="cust-info-label">Telepon</span>
                                <span class="cust-info-value {{ !$company->phone ? 'muted' : '' }}">
                                    {{ $company->phone ?? '—' }}
                                </span>
                            </div>
                            <div class="cust-info-item">
                                <span class="cust-info-label">Terdaftar</span>
                                <span class="cust-info-value">{{ $company->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="cust-card-footer">
                            <div class="mobile-actions">
                                <a href="{{ route('customer.show', $company) }}" class="mob-act-view">Detail</a>
                                <a href="{{ route('customer.edit', $company) }}" class="mob-act-edit">Edit</a>
                                <form action="{{ route('customer.destroy', $company) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="mob-act-delete" title="Hapus">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($companies->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        {{ $companies->firstItem() }}–{{ $companies->lastItem() }} dari {{ $companies->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $companies->previousPageUrl() ?? '#' }}" class="page-btn {{ $companies->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($companies->getUrlRange(1, $companies->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $companies->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $companies->nextPageUrl() ?? '#' }}" class="page-btn {{ !$companies->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif

        @endif
    </div>

    <script>
        const searchInput = document.querySelector('input[name="search"]');
        let searchTimer;
        searchInput?.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => searchInput.closest('form').submit(), 500);
        });

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus perusahaan ini? Semua kontak terkait juga akan terhapus.')) form.submit();
            });
        });
    </script>
</x-app-sidebar>