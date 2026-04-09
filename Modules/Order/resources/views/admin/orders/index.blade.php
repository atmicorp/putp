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
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }
        
        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-primary-sm:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }

        .page-header { margin-bottom: 28px; }
        .page-title  { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .page-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }

        .stat-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 20px 24px; position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: #ea580c; border-radius: 3px 3px 0 0;
        }
        .stat-card:nth-child(2)::before { background: #f59e0b; }
        .stat-card:nth-child(3)::before { background: #3b82f6; }
        .stat-card:nth-child(4)::before { background: #10b981; }

        .stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 30px; font-weight: 700; color: #1c1917; margin-top: 6px; line-height: 1; }
        .stat-desc  { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }

        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f3f4f6;
        }

        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 14px; width: 260px;
        }
        .search-wrap input { background: transparent; border: none; outline: none; font-size: 13px; font-family: 'Sora', sans-serif; color: #1c1917; width: 100%; }
        .search-wrap input::placeholder { color: #9ca3af; }

        .record-count { font-size: 12px; color: #9ca3af; font-weight: 500; }

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

        .order-code { font-weight: 700; font-size: 13px; color: #1c1917; font-family: monospace; letter-spacing: 0.3px; }
        .token { font-weight: 700; font-size: 13px; color: #1c1917; font-family: monospace; letter-spacing: 0.3px; }
        .customer-name  { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .customer-email { font-size: 12px; color: #9ca3af; margin-top: 1px; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-draft      { background: #f3f4f6; color: #6b7280; }
        .badege-submit { background: #f3f4f6; color: #27c03e; }
        .badge-offered    { background: #eff6ff; color: #2563eb; }
        .badge-approved   { background: #f0fdf4; color: #16a34a; }
        .badge-rejected   { background: #fef2f2; color: #dc2626; }
        .badge-processing { background: #fff7ed; color: #ea580c; }
        .badge-done       { background: #f0fdf4; color: #15803d; }
        .badge-submit { background: #fefce8; color: #ca8a04; }

        .date-text { font-size: 12.5px; color: #6b7280; }

        .actions { display: flex; align-items: center; gap: 4px; }
        .act-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
        }
        .act-view       { background: #fff7ed; color: #ea580c; }
        .act-view:hover { background: #ffedd5; }
        .act-delete       { background: transparent; color: #9ca3af; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }
        .act-processing       { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .act-processing:hover { background: #ffedd5; }
        .act-done       { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .act-done:hover { background: #dcfce7; }

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

        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .dot-draft      { background: #9ca3af; }
        .dot-submit    { background: #27c03e; }
        .dot-offered    { background: #3b82f6; }
        .dot-approved   { background: #16a34a; }
        .dot-rejected   { background: #dc2626; }
        .dot-processing { background: #ea580c; }
        .dot-done       { background: #15803d; }
        .dot-submit { background: #ca8a04; }
    </style>

    <div class="dash-title">Order</div>
    <p class="dash-subtitle">Data Order</p>

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
            <div class="stat-label">Total Order</div>
            <div class="stat-value">{{ $orders->total() }}</div>
            <div class="stat-desc">Semua order</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Draft</div>
            <div class="stat-value">{{ \App\Models\Order::where('status', 'draft')->count() }}</div>
            <div class="stat-desc">Belum dikirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Offered</div>
            <div class="stat-value">{{ \App\Models\Order::where('status', 'offered')->count() }}</div>
            <div class="stat-desc">Penawaran terkirim</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Done</div>
            <div class="stat-value">{{ \App\Models\Order::where('status', 'done')->count() }}</div>
            <div class="stat-desc">Selesai</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-toolbar">
            <div class="search-wrap">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                <input type="text" placeholder="Cari order atau customer..." id="searchInput">
            </div>
            <span class="record-count">{{ $orders->total() }} records</span>
        </div>

        @if($orders->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <div class="empty-title">Belum ada order</div>
                <div class="empty-sub">Buat order pertama dengan klik "Add Order"</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Token</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Dibuat oleh</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <span class="order-code">{{ $order->order_code }}</span>
                            </td>
                            <td>
                                <span class="token">{{ $order->access_token }}</span>
                            </td>
                            <td>
                                <div class="customer-name">{{ $order->company->name ?? '-'  }}</div>
                                <div class="customer-email">{{ $order->contact->name ?? '-'  }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    <span class="dot dot-{{ $order->status }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="date-text">{{ $order->creator?->name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="date-text">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Detail</a>

                                    @if($order->status === 'approved')
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                                            onsubmit="return confirm('Ubah status ke Processing?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <button type="submit" class="act-btn act-processing">▶ Processing</button>
                                        </form>
                                    @endif

                                    @if($order->status === 'processing')
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                                            onsubmit="return confirm('Tandai order ini sebagai Done?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="act-btn act-done">✓ Done</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $orders->previousPageUrl() ?? '#' }}" class="page-btn {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $orders->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $orders->nextPageUrl() ?? '#' }}" class="page-btn {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</x-app-sidebar>