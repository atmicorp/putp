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
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-primary-sm:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 20px 24px; position: relative; overflow: hidden;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #ea580c; border-radius: 3px 3px 0 0; }
        .stat-card:nth-child(2)::before { background: #f59e0b; }
        .stat-card:nth-child(3)::before { background: #3b82f6; }
        .stat-card:nth-child(4)::before { background: #10b981; }
        .stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 30px; font-weight: 700; color: #1c1917; margin-top: 6px; line-height: 1; }
        .stat-desc  { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f3f4f6; gap: 12px; flex-wrap: wrap;
        }
        .toolbar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 14px; width: 240px;
        }
        .search-wrap input { background: transparent; border: none; outline: none; font-size: 13px; font-family: 'Sora', sans-serif; color: #1c1917; width: 100%; }
        .search-wrap input::placeholder { color: #9ca3af; }

        .filter-select {
            appearance: none;
            background: #f9fafb url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 10px center/12px 9px;
            border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 8px 32px 8px 12px; font-size: 13px; font-family: 'Sora', sans-serif;
            color: #1c1917; cursor: pointer; outline: none;
        }
        .filter-select:focus { border-color: #ea580c; }
        .filter-select.has-value { border-color: #ea580c; background-color: #fff7ed; color: #ea580c; font-weight: 600; }

        .record-count { font-size: 12px; color: #9ca3af; font-weight: 500; white-space: nowrap; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }
        td { padding: 14px 20px; font-size: 13.5px; vertical-align: middle; }

        .company-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .company-sub  { font-size: 12px; color: #9ca3af; margin-top: 2px; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

        .contact-count {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; background: #eff6ff; border-radius: 20px;
            font-size: 12px; font-weight: 600; color: #2563eb;
        }

        .text-muted { font-size: 12.5px; color: #6b7280; }
        .text-sm    { font-size: 13px; color: #374151; }

        .actions { display: flex; align-items: center; gap: 4px; }
        .act-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s; display: inline-flex; align-items: center;
        }
        .act-view         { background: #fff7ed; color: #ea580c; }
        .act-view:hover   { background: #ffedd5; }
        .act-edit         { background: #eff6ff; color: #2563eb; }
        .act-edit:hover   { background: #dbeafe; }
        .act-delete       { background: transparent; color: #9ca3af; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }

        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-top: 1px solid #f3f4f6; }
        .page-info { font-size: 12.5px; color: #9ca3af; }
        .page-btns { display: flex; gap: 4px; }
        .page-btn {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer;
            border: 1px solid #e5e7eb; background: #fff; color: #6b7280;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .page-btn:hover  { border-color: #ea580c; color: #ea580c; }
        .page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
        .page-btn.disabled { opacity: 0.35; pointer-events: none; }

        .empty-state { text-align: center; padding: 56px 20px; }
        .empty-icon  { font-size: 40px; margin-bottom: 12px; }
        .empty-title { font-size: 15px; font-weight: 600; color: #1c1917; }
        .empty-sub   { font-size: 13px; color: #9ca3af; margin-top: 4px; }
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

    {{-- Table --}}
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
                        <a href="{{ route('customer.index') }}" style="font-size:12px;color:#9ca3af;text-decoration:none;font-weight:500;white-space:nowrap;display:flex;align-items:center;gap:4px;">
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
                            <td>
                                <span class="text-muted">{{ $company->address ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="text-sm">{{ $company->phone ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="contact-count">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                                    {{ $company->contacts_count ?? $company->contacts->count() }} kontak
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $company->created_at->format('d M Y') }}</span>
                            </td>
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

            @if($companies->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        Menampilkan {{ $companies->firstItem() }}–{{ $companies->lastItem() }} dari {{ $companies->total() }} data
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