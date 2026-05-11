<x-app-sidebar>
    <x-slot name="title">Order</x-slot>

    <x-slot name="breadcrumb">
        <span>Order</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Order List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('admin.orders.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Order
        </a>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600&display=swap');

        * { box-sizing: border-box; }
        body, .ol-wrap { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Page Header ── */
        .page-header { margin-bottom: 20px; }
        .page-title  { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; color: #1c1917; line-height: 1.2; }
        .page-subtitle { font-size: 12.5px; color: #9ca3af; margin-top: 4px; font-weight: 500; }

        /* ── Button ── */
        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 9px; font-size: 13px; font-weight: 700;
            text-decoration: none; transition: all 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-primary-sm:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }

        /* ── Alert ── */
        .alert {
            padding: 11px 14px; border-radius: 10px; font-size: 12.5px;
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 600;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ── Stats Grid — 2x2 mobile, 4-col desktop ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: #fff; border: 1px solid #f0ede9; border-radius: 16px;
            padding: 14px 16px; position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; border-radius: 0 0 16px 16px;
        }
        .stat-card:nth-child(1)::after { background: #ea580c; }
        .stat-card:nth-child(2)::after { background: #f59e0b; }
        .stat-card:nth-child(3)::after { background: #3b82f6; }
        .stat-card:nth-child(4)::after { background: #10b981; }

        .stat-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #9ca3af; }
        .stat-value { font-size: 28px; font-weight: 800; color: #1c1917; margin-top: 4px; line-height: 1; letter-spacing: -1px; }
        .stat-desc  { font-size: 11px; color: #c4b5ad; margin-top: 5px; font-weight: 500; }

        /* ── Table Card ── */
        .table-card { background: #fff; border: 1px solid #f0ede9; border-radius: 16px; overflow: hidden; }

        /* ── Toolbar ── */
        .table-toolbar {
            display: flex; flex-direction: column; gap: 10px;
            padding: 14px 16px; border-bottom: 1px solid #f9f7f5;
        }
        .toolbar-top {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
        }
        .table-toolbar-title { font-size: 13px; font-weight: 800; color: #1c1917; }
        .record-count { font-size: 11px; color: #9ca3af; font-weight: 600; white-space: nowrap; }

        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #fafafa; border: 1.5px solid #f0ede9;
            border-radius: 9px; padding: 8px 12px; width: 100%;
            transition: border-color 0.15s;
        }
        .search-wrap:focus-within { border-color: #ea580c; background: #fff; }
        .search-wrap input {
            background: transparent; border: none; outline: none;
            font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1c1917; width: 100%;
        }
        .search-wrap input::placeholder { color: #c4b5ad; }

        /* ── Badges & Dots ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 700;
            white-space: nowrap;
        }
        .badge-draft      { background: #f3f4f6; color: #6b7280; }
        .badge-submit     { background: #fefce8; color: #ca8a04; }
        .badge-offered    { background: #eff6ff; color: #2563eb; }
        .badge-approved   { background: #f0fdf4; color: #16a34a; }
        .badge-rejected   { background: #fef2f2; color: #dc2626; }
        .badge-processing { background: #fff7ed; color: #ea580c; }
        .badge-done       { background: #f0fdf4; color: #15803d; }

        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .dot-draft      { background: #9ca3af; }
        .dot-submit     { background: #ca8a04; }
        .dot-offered    { background: #3b82f6; }
        .dot-approved   { background: #16a34a; }
        .dot-rejected   { background: #dc2626; }
        .dot-processing { background: #ea580c; }
        .dot-done       { background: #15803d; }

        /* ── Action Buttons ── */
        .actions { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
        .act-btn {
            padding: 5px 11px; border-radius: 7px; font-size: 11.5px; font-weight: 700;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.15s;
            white-space: nowrap;
        }
        .act-view             { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .act-view:hover       { background: #ffedd5; }
        .act-delete           { background: transparent; color: #9ca3af; border: 1px solid #f0ede9; }
        .act-delete:hover     { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .act-processing       { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .act-processing:hover { background: #ffedd5; }
        .act-done             { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .act-done:hover       { background: #dcfce7; }

        /* ── Mobile Order Cards ── */
        .mobile-orders { display: flex; flex-direction: column; }
        .mob-card {
            padding: 14px 16px; border-bottom: 1px solid #f9f7f5;
            display: flex; flex-direction: column; gap: 9px;
            transition: background 0.1s;
        }
        .mob-card:last-child { border-bottom: none; }
        .mob-card:hover { background: #fff7ed; }

        .mob-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
        .mob-row-center { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

        .mob-codes { display: flex; flex-direction: column; gap: 3px; }
        .order-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px; font-weight: 600; color: #ea580c; letter-spacing: 0.3px;
        }
        .token {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px; font-weight: 600; color: #9ca3af; letter-spacing: 0.2px;
        }
        .customer-name  { font-size: 13.5px; font-weight: 700; color: #1c1917; }
        .customer-email { font-size: 11px; color: #9ca3af; margin-top: 2px; font-weight: 500; }
        .date-text      { font-size: 11.5px; color: #9ca3af; font-weight: 500; }
        .cost-text      { font-size: 12.5px; font-weight: 700; color: #1c1917; }

        .mob-divider { height: 1px; background: #f9f7f5; }

        /* ── Desktop Table (hidden on mobile) ── */
        .desktop-table { display: none; }
        .desktop-table table { width: 100%; border-collapse: collapse; }
        .desktop-table thead th {
            padding: 10px 20px; text-align: left; font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .desktop-table tbody tr { border-bottom: 1px solid #f9f7f5; transition: background 0.1s; }
        .desktop-table tbody tr:last-child { border-bottom: none; }
        .desktop-table tbody tr:hover { background: #fff7ed; }
        .desktop-table td { padding: 13px 20px; font-size: 13px; vertical-align: middle; }
        .desktop-table .order-code { color: #1c1917; }

        /* ── Pagination ── */
        .pagination {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px;
            padding: 12px 16px; border-top: 1px solid #f9f7f5;
        }
        .page-info { font-size: 11.5px; color: #9ca3af; font-weight: 500; }
        .page-btns { display: flex; gap: 4px; }
        .page-btn {
            min-width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 7px; font-size: 12.5px; font-weight: 600; cursor: pointer;
            border: 1.5px solid #f0ede9; background: #fff; color: #6b7280;
            text-decoration: none; transition: all 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif; padding: 0 6px;
        }
        .page-btn:hover  { border-color: #ea580c; color: #ea580c; }
        .page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
        .page-btn.disabled { opacity: 0.35; pointer-events: none; }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 56px 20px; }
        .empty-icon  { font-size: 40px; margin-bottom: 12px; }
        .empty-title { font-size: 15px; font-weight: 700; color: #1c1917; }
        .empty-sub   { font-size: 12.5px; color: #9ca3af; margin-top: 4px; }

        /* ══════════════════════════════
           BREAKPOINTS
        ══════════════════════════════ */
        @media (min-width: 900px) {
            .stats-row { grid-template-columns: repeat(4, 1fr); gap: 14px; }

            .table-toolbar { flex-direction: row; align-items: center; gap: 12px; }
            .toolbar-top { flex: none; }
            .search-wrap { width: 280px; }

            .mobile-orders { display: none; }
            .desktop-table { display: block; }
        }

        @media (max-width: 360px) {
            .stat-value { font-size: 22px; }
            .stat-card  { padding: 12px 12px; }
        }

        /* Stats — 3-col on mobile, 6-col desktop */
        .stats-row {
            grid-template-columns: repeat(3, 1fr);
        }
        @media (min-width: 900px) {
            .stats-row { grid-template-columns: repeat(6, 1fr); }
        }

        /* Warna accent per type */
        .stat-card:nth-child(1)::after { background: #ea580c; }
        .stat-card:nth-child(2)::after { background: #6366f1; } /* external - indigo */
        .stat-card:nth-child(3)::after { background: #0ea5e9; } /* internal - sky */
        .stat-card:nth-child(4)::after { background: #f59e0b; }
        .stat-card:nth-child(5)::after { background: #3b82f6; }
        .stat-card:nth-child(6)::after { background: #10b981; }

        /* Type Filter Tabs */
        .type-filter {
            display: flex; gap: 4px; flex-wrap: wrap;
        }
        .type-btn {
            padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700;
            text-decoration: none; color: #6b7280; background: #f3f4f6;
            border: 1.5px solid transparent; transition: all 0.15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .type-btn:hover  { background: #e5e7eb; color: #1c1917; }
        .type-btn.active { background: #fff7ed; color: #ea580c; border-color: #fed7aa; }
        .type-btn.active-ext { background: #eef2ff; color: #4f46e5; border-color: #c7d2fe; }
        .type-btn.active-int { background: #f0f9ff; color: #0284c7; border-color: #bae6fd; }
    </style>

    <div class="page-header">
        <div class="page-title">Order</div>
        <p class="page-subtitle">Data Order</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ═══ Stats ═══ --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Order</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-desc">Semua order</div>
        </div>
        <div class="stat-card stat-external">
            <div class="stat-label">External</div>
            <div class="stat-value">{{ $stats['external'] }}</div>
            <div class="stat-desc">Order eksternal</div>
        </div>
        <div class="stat-card stat-internal">
            <div class="stat-label">Internal</div>
            <div class="stat-value">{{ $stats['internal'] }}</div>
            <div class="stat-desc">Order internal</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Draft</div>
            <div class="stat-value">{{ $stats['draft'] }}</div>
            <div class="stat-desc">Belum dikirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Offered</div>
            <div class="stat-value">{{ $stats['offered'] }}</div>
            <div class="stat-desc">Penawaran terkirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Done</div>
            <div class="stat-value">{{ $stats['done'] }}</div>
            <div class="stat-desc">Selesai</div>
        </div>
    </div>

    {{-- ═══ Table Card ═══ --}}
    <div class="table-card">
        <div class="table-toolbar">
            <div class="toolbar-top">
                <div>
                    <div class="table-toolbar-title">Daftar Order</div>
                </div>
                <div class="type-filter">
                    <a href="{{ route('admin.orders.index') }}"
                    class="type-btn {{ !$type ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('admin.orders.index', ['type' => 'external']) }}"
                    class="type-btn type-btn-ext {{ $type === 'external' ? 'active-ext' : '' }}">External</a>
                    <a href="{{ route('admin.orders.index', ['type' => 'internal']) }}"
                    class="type-btn type-btn-int {{ $type === 'internal' ? 'active-int' : '' }}">Internal</a>
                </div>
                <span class="record-count">{{ $orders->total() }} records</span>
            </div>
            <div class="search-wrap">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#c4b5ad" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari order atau customer..." id="searchInput">
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <div class="empty-title">Belum ada order</div>
                <div class="empty-sub">Buat order pertama dengan klik "Add Order"</div>
            </div>
        @else

            {{-- Mobile Cards --}}
            <div class="mobile-orders">
                @foreach($orders as $order)
                    <div class="mob-card">
                        <div class="mob-row">
                            <div>
                                <div class="customer-name">{{ $order->company->name ?? '-' }}</div>
                                <div class="customer-email">{{ $order->contact->name ?? '-' }}</div>
                            </div>
                            <span class="badge badge-{{ $order->status }}">
                                <span class="dot dot-{{ $order->status }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        <div class="mob-row-center">
                            <div class="mob-codes">
                                <span class="order-code">{{ $order->order_code }}</span>
                                <span class="token">{{ $order->access_token }}</span>
                            </div>
                            <div style="text-align:right">
                                <div class="cost-text">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                <div class="date-text">{{ $order->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="actions">
                            <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Detail →</a>

                            @if($order->status === 'approved')
                                <form id="processingForm-{{ $order->id }}" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="button" class="act-btn act-processing"
                                        onclick="confirmProcessing('{{ $order->id }}', '{{ $order->order_code }}')">▶ Processing</button>
                                </form>
                            @endif

                            @if($order->status === 'processing')
                                <form id="doneForm-{{ $order->id }}" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="done">
                                    <button type="button" class="act-btn act-done"
                                        onclick="confirmDone('{{ $order->id }}', '{{ $order->order_code }}')">✓ Done</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop Table --}}
            <div class="desktop-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Token</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Total Cost</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><span class="order-code">{{ $order->order_code }}</span></td>
                                <td><span class="token">{{ $order->access_token }}</span></td>
                                <td>
                                    <div class="customer-name">{{ $order->company->name ?? '-' }}</div>
                                    <div class="customer-email">{{ $order->contact->name ?? '-' }}</div>
                                </td>
                                <td><span class="date-text">{{ $order->created_at->format('d M Y') }}</span></td>
                                <td><span class="date-text">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        <span class="dot dot-{{ $order->status }}"></span>
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Detail</a>

                                        @if($order->status === 'approved')
                                            <form id="processingForm-{{ $order->id }}" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="button" class="act-btn act-processing"
                                                    onclick="confirmProcessing('{{ $order->id }}', '{{ $order->order_code }}')">▶ Processing</button>
                                            </form>
                                        @endif

                                        @if($order->status === 'processing')
                                            <form id="doneForm-{{ $order->id }}" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="done">
                                                <button type="button" class="act-btn act-done"
                                                    onclick="confirmDone('{{ $order->id }}', '{{ $order->order_code }}')">✓ Done</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $orders->previousPageUrl() ?? '#' }}" class="page-btn {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $orders->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $orders->nextPageUrl() ?? '#' }}" class="page-btn {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmProcessing(id, code) {
            Swal.fire({
                title: 'Ubah ke Processing?',
                text: `Order ${code} akan diubah statusnya ke Processing.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Processing!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`processingForm-${id}`).submit();
                }
            });
        }

        function confirmDone(id, code) {
            Swal.fire({
                title: 'Tandai Done?',
                text: `Order ${code} akan ditandai sebagai selesai.`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Done!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`doneForm-${id}`).submit();
                }
            });
        }

        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
            document.querySelectorAll('.mob-card').forEach(card => {
                card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</x-app-sidebar>