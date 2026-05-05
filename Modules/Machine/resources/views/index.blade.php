<x-app-sidebar>
    <x-slot name="title">Machine</x-slot>

    <x-slot name="breadcrumb">
        <span>Machine</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Machine List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('machine.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Machine
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
        .table-toolbar { padding: 14px 16px; border-bottom: 1px solid #f3f4f6; display: flex; flex-direction: column; gap: 10px; }
        .toolbar-row   { display: flex; align-items: center; gap: 8px; }
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
            color: #1c1917; cursor: pointer; outline: none; flex: 1;
        }
        .filter-select:focus { border-color: #ea580c; }

        /* Mobile cards */
        .mobile-list { display: block; }
        .mobile-card {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.1s;
        }
        .mobile-card:last-child { border-bottom: none; }
        .mobile-card:active { background: #fff7ed; }

        .mc-top {
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 10px; margin-bottom: 8px;
        }
        .mc-left { flex: 1; min-width: 0; }
        .machine-name { font-weight: 600; font-size: 14px; color: #1c1917; }
        .machine-desc { font-size: 12px; color: #9ca3af; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .machine-code {
            font-weight: 700; font-size: 11.5px; color: #1c1917;
            font-family: monospace; letter-spacing: 0.3px;
            background: #f3f4f6; padding: 2px 8px; border-radius: 4px;
            border: 1px solid #e5e7eb; white-space: nowrap; flex-shrink: 0;
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

        .mc-meta {
            display: flex; align-items: center; gap: 10px;
            flex-wrap: wrap; margin-bottom: 10px;
        }
        .mc-meta-item { font-size: 12px; color: #9ca3af; display: flex; align-items: center; gap: 4px; }
        .mc-meta-item strong { color: #6b7280; font-weight: 600; }

        .mc-actions { display: flex; gap: 6px; }
        .act-btn {
            flex: 1; padding: 7px 0; border-radius: 8px;
            font-size: 12.5px; font-weight: 600; cursor: pointer;
            text-decoration: none; border: none; font-family: 'Sora', sans-serif;
            transition: all 0.15s; text-align: center;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .act-view         { background: #fff7ed; color: #ea580c; }
        .act-view:hover   { background: #ffedd5; }
        .act-edit         { background: #eff6ff; color: #2563eb; }
        .act-edit:hover   { background: #dbeafe; }
        .act-delete       { background: #f9fafb; color: #9ca3af; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }
        .act-delete-form  { flex: 1; display: flex; }
        .act-delete-form .act-btn { width: 100%; }

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
        .dt-machine-code {
            font-weight: 700; font-size: 12.5px; color: #1c1917;
            font-family: monospace; letter-spacing: 0.3px;
            background: #f3f4f6; padding: 2px 8px; border-radius: 4px; border: 1px solid #e5e7eb;
        }
        .dt-machine-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .dt-machine-desc { font-size: 12px; color: #9ca3af; margin-top: 2px; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .date-text { font-size: 12.5px; color: #6b7280; }
        .dt-actions { display: flex; align-items: center; gap: 4px; }
        .dt-act-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: inline-flex; align-items: center;
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
            .table-toolbar { flex-direction: row; align-items: center; justify-content: space-between; padding: 16px 20px; }
            .toolbar-row   { flex: 1; }
            .search-wrap   { flex: none; width: 260px; }
            .filter-select { flex: none; width: auto; }
            .stat-value    { font-size: 30px; }
        }
    </style>

    <div class="dash-title">Machine</div>
    <p class="dash-subtitle">Data Machine</p>

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
            <div class="stat-value">{{ $machines->total() }}</div>
            <div class="stat-desc">Semua mesin</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ \App\Models\Machine::where('is_active', true)->count() }}</div>
            <div class="stat-desc">Mesin aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Inactive</div>
            <div class="stat-value">{{ \App\Models\Machine::where('is_active', false)->count() }}</div>
            <div class="stat-desc">Mesin nonaktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">w/ Operator</div>
            <div class="stat-value">{{ \App\Models\Machine::has('operators')->count() }}</div>
            <div class="stat-desc">Ada operator</div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="toolbar-row">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari nama atau kode mesin..." id="searchInput">
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <span class="record-count" style="display:none" id="desktopCount">{{ $machines->total() }} records</span>
            </div>
            <span class="record-count" id="mobileCount">{{ $machines->total() }} data</span>
        </div>

        @if($machines->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">⚙️</div>
                <div class="empty-title">Belum ada mesin</div>
                <div class="empty-sub">Tambahkan mesin pertama dengan klik "Add Machine"</div>
            </div>
        @else

            {{-- ===== MOBILE CARDS ===== --}}
            <div class="mobile-list" id="mobileList">
                @foreach($machines as $machine)
                @php $status = $machine->is_active ? 'active' : 'inactive'; @endphp
                <div class="mobile-card" data-search="{{ strtolower($machine->name . ' ' . $machine->code) }}" data-status="{{ $status }}">
                    <div class="mc-top">
                        <div class="mc-left">
                            <div class="machine-name">{{ $machine->name }}</div>
                            @if($machine->description)
                                <div class="machine-desc">{{ $machine->description }}</div>
                            @endif
                        </div>
                        <span class="machine-code">{{ $machine->code }}</span>
                    </div>
                    <div class="mc-meta">
                        <span class="badge badge-{{ $status }}">
                            <span class="dot dot-{{ $status }}"></span>
                            {{ $machine->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="mc-meta-item">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <strong>{{ $machine->operators_count ?? $machine->operators->count() }}</strong> operator
                        </span>
                        <span class="mc-meta-item">{{ $machine->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mc-actions">
                        <a href="{{ route('machine.show', $machine) }}" class="act-btn act-view">Detail</a>
                        <a href="{{ route('machine.edit', $machine) }}" class="act-btn act-edit">Edit</a>
                        <form action="{{ route('machine.destroy', $machine) }}" method="POST" class="act-delete-form delete-form">
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
                            <th>Code</th>
                            <th>Nama Mesin</th>
                            <th>Status</th>
                            <th>Operators</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($machines as $machine)
                        @php $status = $machine->is_active ? 'active' : 'inactive'; @endphp
                        <tr data-search="{{ strtolower($machine->name . ' ' . $machine->code) }}" data-status="{{ $status }}">
                            <td><span class="dt-machine-code">{{ $machine->code }}</span></td>
                            <td>
                                <div class="dt-machine-name">{{ $machine->name }}</div>
                                @if($machine->description)
                                    <div class="dt-machine-desc">{{ $machine->description }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $status }}">
                                    <span class="dot dot-{{ $status }}"></span>
                                    {{ $machine->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td><span class="date-text">{{ $machine->operators_count ?? $machine->operators->count() }} operator</span></td>
                            <td><span class="date-text">{{ $machine->created_at->format('d M Y') }}</span></td>
                            <td>
                                <div class="dt-actions">
                                    <a href="{{ route('machine.show', $machine) }}" class="dt-act-btn act-view">Detail</a>
                                    <a href="{{ route('machine.edit', $machine) }}" class="dt-act-btn act-edit">Edit</a>
                                    <form action="{{ route('machine.destroy', $machine) }}" method="POST" class="delete-form" style="display:inline">
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

            @if($machines->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        {{ $machines->firstItem() }}–{{ $machines->lastItem() }} dari {{ $machines->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $machines->previousPageUrl() ?? '#' }}" class="page-btn {{ $machines->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($machines->getUrlRange(1, $machines->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $machines->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $machines->nextPageUrl() ?? '#' }}" class="page-btn {{ !$machines->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script>
        function filterAll() {
            const q      = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value.toLowerCase();

            // Mobile
            document.querySelectorAll('.mobile-card').forEach(card => {
                const matchQ      = card.dataset.search.includes(q);
                const matchStatus = !status || card.dataset.status === status;
                card.style.display = (matchQ && matchStatus) ? '' : 'none';
            });

            // Desktop
            document.querySelectorAll('#tableBody tr').forEach(row => {
                const matchQ      = row.dataset.search.includes(q);
                const matchStatus = !status || row.dataset.status === status;
                row.style.display = (matchQ && matchStatus) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterAll);
        document.getElementById('statusFilter').addEventListener('change', filterAll);

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus mesin ini?')) form.submit();
            });
        });
    </script>
</x-app-sidebar>