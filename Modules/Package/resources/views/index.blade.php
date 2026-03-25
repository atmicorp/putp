<x-app-sidebar>
    <x-slot name="title">Package</x-slot>

    <x-slot name="breadcrumb">
        <span>Package</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Package List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('package.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Package
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
            border-radius: 8px; padding: 8px 14px; width: 220px;
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

        .pkg-name    { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .pkg-sub     { font-size: 12px; color: #9ca3af; margin-top: 2px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

        .cat-badge {
            display: inline-flex; padding: 2px 8px;
            background: #f3f4f6; border-radius: 20px;
            font-size: 11px; font-weight: 600; color: #6b7280;
        }

        .price-text { font-size: 13.5px; font-weight: 700; color: #1c1917; font-variant-numeric: tabular-nums; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-active   { background: #f0fdf4; color: #16a34a; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
        .dot-active   { background: #16a34a; }
        .dot-inactive { background: #9ca3af; }

        .date-text { font-size: 12.5px; color: #6b7280; }
        .machine-name { font-weight: 500; color: #374151; font-size: 13px; }
        .machine-code { font-size: 11px; color: #9ca3af; display: flex; align-items: center; gap: 3px; margin-top: 2px; }

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

    <div class="dash-title">Package</div>
    <p class="dash-subtitle">Data Package</p>

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
            <div class="stat-label">Total Package</div>
            <div class="stat-value">{{ $packages->total() }}</div>
            <div class="stat-desc">Semua package</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ \App\Models\Package::where('is_active', true)->count() }}</div>
            <div class="stat-desc">Package aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Inactive</div>
            <div class="stat-value">{{ \App\Models\Package::where('is_active', false)->count() }}</div>
            <div class="stat-desc">Package nonaktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Mesin</div>
            <div class="stat-value">{{ \App\Models\Package::distinct('machine_id')->count('machine_id') }}</div>
            <div class="stat-desc">Mesin terdaftar</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        {{-- Filter form — server-side, bukan JS filter --}}
        <form method="GET" action="{{ route('package.index') }}" id="filterForm">
            <div class="table-toolbar">
                <div class="toolbar-left">
                    <div class="search-wrap">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari package atau mesin..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </div>

                    <select name="category_id" class="filter-select {{ request('category_id') ? 'has-value' : '' }}" onchange="this.form.submit()">
                        <option value="">Semua Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ request('category_id') == $cat->category_id ? 'selected' : '' }}>
                                {{ $cat->nama_category }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="filter-select {{ request('status') !== null && request('status') !== '' ? 'has-value' : '' }}" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <select name="machine_id" class="filter-select {{ request('machine_id') ? 'has-value' : '' }}" onchange="this.form.submit()">
                        <option value="">Semua Mesin</option>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}" {{ request('machine_id') == $machine->id ? 'selected' : '' }}>
                                {{ $machine->name }}
                            </option>
                        @endforeach
                    </select>

                    @if(request()->hasAny(['search', 'category_id', 'status', 'machine_id']))
                        <a href="{{ route('package.index') }}" style="font-size:12px;color:#9ca3af;text-decoration:none;font-weight:500;white-space:nowrap;display:flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
                <span class="record-count">{{ $packages->total() }} records</span>
            </div>
        </form>

        @if($packages->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <div class="empty-title">Tidak ada package ditemukan</div>
                <div class="empty-sub">Coba ubah filter atau <a href="{{ route('package.index') }}" style="color:#ea580c;">reset filter</a></div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Nama Package</th>
                        <th>Category</th>
                        <th>Mesin</th>
                        <th>PIC Operator</th>
                        <th>Base Price</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>
                                <div class="pkg-name">{{ $package->name }}</div>
                                @if($package->description)
                                    <span class="pkg-sub">{{ $package->description }}</span>
                                @endif
                            </td>
                            <td>
                                @if($package->category)
                                    <span class="cat-badge">{{ $package->category->nama_category }}</span>
                                @else
                                    <span style="color:#d1d5db;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="machine-name">{{ $package->machine?->name ?? '-' }}</div>
                                @if($package->machine)
                                    <div class="machine-code">
                                        <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $package->machine->code }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="date-text">{{ $package->picOperator?->name ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="price-text">Rp {{ number_format($package->base_price, 0, ',', '.') }}</div>
                            </td>
                            <td>
                                @php $isActive = $package->is_active; @endphp
                                <span class="badge badge-{{ $isActive ? 'active' : 'inactive' }}">
                                    <span class="dot dot-{{ $isActive ? 'active' : 'inactive' }}"></span>
                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <span class="date-text">{{ $package->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('package.show', $package) }}" class="act-btn act-view">Detail</a>
                                    <a href="{{ route('package.edit', $package) }}" class="act-btn act-edit">Edit</a>
                                    <form action="{{ route('package.destroy', $package) }}" method="POST" class="delete-form" style="display:inline;">
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

            @if($packages->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        Menampilkan {{ $packages->firstItem() }}–{{ $packages->lastItem() }} dari {{ $packages->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $packages->previousPageUrl() ?? '#' }}" class="page-btn {{ $packages->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($packages->getUrlRange(1, $packages->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $packages->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $packages->nextPageUrl() ?? '#' }}" class="page-btn {{ !$packages->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script>
        // Search input: submit form on Enter or after short delay
        const searchInput = document.querySelector('input[name="search"]');
        let searchTimer;
        searchInput?.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => searchInput.closest('form').submit(), 500);
        });

        // Delete confirm
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus package ini?')) form.submit();
            });
        });
    </script>
</x-app-sidebar>