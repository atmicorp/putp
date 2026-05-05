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
        .dash-title    { font-size: 20px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 20px; }

        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-primary-sm:hover { background: #c2410c; }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* Stats */
        .stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 16px; position: relative; overflow: hidden;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #ea580c; border-radius: 3px 3px 0 0; }
        .stat-card:nth-child(2)::before { background: #f59e0b; }
        .stat-card:nth-child(3)::before { background: #3b82f6; }
        .stat-card:nth-child(4)::before { background: #10b981; }
        .stat-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 26px; font-weight: 700; color: #1c1917; margin-top: 4px; line-height: 1; }
        .stat-desc  { font-size: 11px; color: #9ca3af; margin-top: 4px; }

        /* Table card */
        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }

        /* Toolbar */
        .table-toolbar { padding: 14px 16px; border-bottom: 1px solid #f3f4f6; }
        .toolbar-top {
            display: flex; align-items: center; gap: 8px; margin-bottom: 10px;
        }
        .toolbar-bottom {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 12px; flex: 1;
        }
        .search-wrap input { background: transparent; border: none; outline: none; font-size: 13px; font-family: 'Sora', sans-serif; color: #1c1917; width: 100%; }
        .search-wrap input::placeholder { color: #9ca3af; }
        .record-count { font-size: 12px; color: #9ca3af; font-weight: 500; white-space: nowrap; }

        .filter-select {
            appearance: none;
            background: #f9fafb url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 10px center/12px 9px;
            border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 8px 28px 8px 10px; font-size: 12.5px; font-family: 'Sora', sans-serif;
            color: #1c1917; cursor: pointer; outline: none; flex: 1; min-width: 0;
        }
        .filter-select:focus { border-color: #ea580c; }
        .filter-select.has-value { border-color: #ea580c; background-color: #fff7ed; color: #ea580c; font-weight: 600; }

        .reset-link {
            font-size: 12px; color: #9ca3af; text-decoration: none; font-weight: 500;
            white-space: nowrap; display: flex; align-items: center; gap: 4px;
            padding: 6px 10px; border-radius: 8px; border: 1px solid #e5e7eb;
            background: #fff; transition: all 0.15s;
        }
        .reset-link:hover { color: #dc2626; border-color: #fecaca; background: #fef2f2; }

        /* Desktop table */
        .desktop-table { display: none; }
        .desktop-table table { width: 100%; border-collapse: collapse; }
        .desktop-table thead th {
            padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .desktop-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        .desktop-table tbody tr:last-child { border-bottom: none; }
        .desktop-table tbody tr:hover { background: #fff7ed; }
        .desktop-table td { padding: 14px 20px; font-size: 13.5px; vertical-align: middle; }

        /* Mobile cards */
        .mobile-list { display: block; }
        .mobile-card { padding: 14px 16px; border-bottom: 1px solid #f3f4f6; }
        .mobile-card:last-child { border-bottom: none; }

        .mc-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; margin-bottom: 8px; }
        .pkg-name { font-weight: 600; font-size: 14px; color: #1c1917; }
        .pkg-sub  { font-size: 12px; color: #9ca3af; margin-top: 2px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .mc-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }

        .cat-badge {
            display: inline-flex; padding: 2px 8px;
            background: #f3f4f6; border-radius: 20px;
            font-size: 11px; font-weight: 600; color: #6b7280;
        }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-active   { background: #f0fdf4; color: #16a34a; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
        .dot-active   { background: #16a34a; }
        .dot-inactive { background: #9ca3af; }

        .mc-rows { display: flex; flex-direction: column; gap: 5px; margin-bottom: 10px; }
        .mc-row { display: flex; align-items: center; justify-content: space-between; font-size: 12.5px; }
        .mc-row-label { color: #9ca3af; font-size: 11.5px; }
        .mc-row-val { color: #374151; font-weight: 500; text-align: right; }

        .price-text { font-size: 13.5px; font-weight: 700; color: #1c1917; font-variant-numeric: tabular-nums; }
        .machine-name { font-weight: 500; color: #374151; font-size: 13px; }
        .machine-code { font-size: 11px; color: #9ca3af; display: flex; align-items: center; gap: 3px; margin-top: 2px; }
        .date-text { font-size: 12.5px; color: #6b7280; }

        .mc-actions { display: flex; gap: 6px; }
        .act-btn {
            flex: 1; padding: 7px 0; border-radius: 8px; font-size: 12.5px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: inline-flex; align-items: center; justify-content: center; gap: 4px;
        }
        .act-view         { background: #fff7ed; color: #ea580c; }
        .act-view:hover   { background: #ffedd5; }
        .act-edit         { background: #eff6ff; color: #2563eb; }
        .act-edit:hover   { background: #dbeafe; }
        .act-delete       { background: #f9fafb; color: #9ca3af; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }
        .act-delete-form  { flex: 1; display: flex; }
        .act-delete-form .act-btn { width: 100%; }

        /* Desktop action overrides */
        .dt-act-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s; display: inline-flex; align-items: center;
        }

        /* Pagination */
        .pagination { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid #f3f4f6; flex-wrap: wrap; gap: 8px; }
        .page-info { font-size: 12px; color: #9ca3af; }
        .page-btns { display: flex; gap: 4px; flex-wrap: wrap; }
        .page-btn {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer;
            border: 1px solid #e5e7eb; background: #fff; color: #6b7280;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .page-btn:hover  { border-color: #ea580c; color: #ea580c; }
        .page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
        .page-btn.disabled { opacity: 0.35; pointer-events: none; }

        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-icon  { font-size: 36px; margin-bottom: 10px; }
        .empty-title { font-size: 15px; font-weight: 600; color: #1c1917; }
        .empty-sub   { font-size: 13px; color: #9ca3af; margin-top: 4px; }

        /* Breakpoints */
        @media (min-width: 480px) {
            .stats-row { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 768px) {
            .mobile-list   { display: none; }
            .desktop-table { display: block; }
            .toolbar-top   { flex-wrap: nowrap; }
            .search-wrap   { flex: none; width: 220px; }
            .stats-row     { gap: 16px; }
            .stat-value    { font-size: 30px; }
        }
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

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total</div>
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
            <div class="stat-label">Mesin</div>
            <div class="stat-value">{{ \App\Models\Package::distinct('machine_id')->count('machine_id') }}</div>
            <div class="stat-desc">Mesin terdaftar</div>
        </div>
    </div>

    <div class="table-card">
        <form method="GET" action="{{ route('package.index') }}" id="filterForm">
            <div class="table-toolbar">
                {{-- Row 1: search + record count --}}
                <div class="toolbar-top">
                    <div class="search-wrap">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" name="search" placeholder="Cari package atau mesin..." value="{{ request('search') }}" autocomplete="off">
                    </div>
                    <span class="record-count">{{ $packages->total() }} data</span>
                </div>
                {{-- Row 2: filters --}}
                <div class="toolbar-bottom">
                    <select name="category_id" class="filter-select {{ request('category_id') ? 'has-value' : '' }}" onchange="this.form.submit()">
                        <option value="">Semua Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ request('category_id') == $cat->category_id ? 'selected' : '' }}>{{ $cat->nama_category }}</option>
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
                            <option value="{{ $machine->id }}" {{ request('machine_id') == $machine->id ? 'selected' : '' }}>{{ $machine->name }}</option>
                        @endforeach
                    </select>

                    @if(request()->hasAny(['search', 'category_id', 'status', 'machine_id']))
                        <a href="{{ route('package.index') }}" class="reset-link">
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        @if($packages->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <div class="empty-title">Tidak ada package ditemukan</div>
                <div class="empty-sub">Coba ubah filter atau <a href="{{ route('package.index') }}" style="color:#ea580c;">reset filter</a></div>
            </div>
        @else

            {{-- ===== MOBILE CARDS ===== --}}
            <div class="mobile-list">
                @foreach($packages as $package)
                @php $isActive = $package->is_active; @endphp
                <div class="mobile-card">
                    <div class="mc-top">
                        <div style="flex:1;min-width:0">
                            <div class="pkg-name">{{ $package->name }}</div>
                            @if($package->description)
                                <div class="pkg-sub">{{ $package->description }}</div>
                            @endif
                        </div>
                        <span class="badge badge-{{ $isActive ? 'active' : 'inactive' }}" style="flex-shrink:0">
                            <span class="dot dot-{{ $isActive ? 'active' : 'inactive' }}"></span>
                            {{ $isActive ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mc-chips">
                        @if($package->category)
                            <span class="cat-badge">{{ $package->category->nama_category }}</span>
                        @endif
                        <span class="price-text">Rp {{ number_format($package->base_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="mc-rows">
                        <div class="mc-row">
                            <span class="mc-row-label">Mesin</span>
                            <span class="mc-row-val">
                                {{ $package->machine?->name ?? '-' }}
                                @if($package->machine)
                                    <span style="color:#9ca3af;font-size:11px;font-weight:400"> · {{ $package->machine->code }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="mc-row">
                            <span class="mc-row-label">PIC Operator</span>
                            <span class="mc-row-val">{{ $package->picOperator?->name ?? '-' }}</span>
                        </div>
                        <div class="mc-row">
                            <span class="mc-row-label">Tanggal</span>
                            <span class="mc-row-val">{{ $package->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="mc-actions">
                        <a href="{{ route('package.show', $package) }}" class="act-btn act-view">Detail</a>
                        <a href="{{ route('package.edit', $package) }}" class="act-btn act-edit">Edit</a>
                        <form action="{{ route('package.destroy', $package) }}" method="POST" class="act-delete-form delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn act-delete">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ===== DESKTOP TABLE ===== --}}
            <div class="desktop-table">
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
                        @php $isActive = $package->is_active; @endphp
                        <tr>
                            <td>
                                <div class="pkg-name">{{ $package->name }}</div>
                                @if($package->description)
                                    <span style="font-size:12px;color:#9ca3af;margin-top:2px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block">{{ $package->description }}</span>
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
                            <td><span class="date-text">{{ $package->picOperator?->name ?? '-' }}</span></td>
                            <td><div class="price-text">Rp {{ number_format($package->base_price, 0, ',', '.') }}</div></td>
                            <td>
                                <span class="badge badge-{{ $isActive ? 'active' : 'inactive' }}">
                                    <span class="dot dot-{{ $isActive ? 'active' : 'inactive' }}"></span>
                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td><span class="date-text">{{ $package->created_at->format('d M Y') }}</span></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:4px">
                                    <a href="{{ route('package.show', $package) }}" class="dt-act-btn act-view">Detail</a>
                                    <a href="{{ route('package.edit', $package) }}" class="dt-act-btn act-edit">Edit</a>
                                    <form action="{{ route('package.destroy', $package) }}" method="POST" class="delete-form" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dt-act-btn act-delete" title="Hapus">
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

            @if($packages->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        {{ $packages->firstItem() }}–{{ $packages->lastItem() }} dari {{ $packages->total() }} data
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
        // Search: submit form setelah delay 500ms
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