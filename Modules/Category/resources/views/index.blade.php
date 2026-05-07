<x-app-sidebar>
    <x-slot name="title">Category</x-slot>

    <x-slot name="breadcrumb">
        <span>Category</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Category List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('category.create') }}" class="ac-btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Category
        </a>
    </x-slot>

    <style>
        /* ── Reset ── */
        *, *::before, *::after { box-sizing: border-box; }

        /* ── Page header ── */
        .ac-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .ac-subtitle { font-size: 13px; color: #6b7280; margin-top: 3px; margin-bottom: 24px; }

        /* ── Topbar button ── */
        .ac-btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: inherit;
        }
        .ac-btn-primary-sm:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }

        /* ── Alerts ── */
        .ac-alert {
            padding: 12px 16px; border-radius: 10px; font-size: 13px;
            margin-bottom: 18px; display: flex; align-items: center; gap: 8px; font-weight: 500;
        }
        .ac-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .ac-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ── Table card ── */
        .ac-table-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }

        /* ── Toolbar ── */
        .ac-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 18px; border-bottom: 1px solid #f3f4f6;
            gap: 10px; flex-wrap: wrap;
        }
        .ac-search {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 13px;
            flex: 1; max-width: 280px;
        }
        .ac-search svg { color: #9ca3af; flex-shrink: 0; }
        .ac-search input {
            background: transparent; border: none; outline: none;
            font-size: 13px; font-family: inherit; color: #1c1917; width: 100%;
        }
        .ac-search input::placeholder { color: #9ca3af; }
        .ac-record-count { font-size: 12px; color: #9ca3af; font-weight: 500; white-space: nowrap; }

        /* ── Desktop table ── */
        .ac-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        thead th {
            padding: 11px 18px; text-align: left;
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #9ca3af; background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }
        td { padding: 13px 18px; font-size: 13.5px; vertical-align: middle; }

        .cat-id   { font-weight: 700; font-size: 13px; color: #ea580c; font-variant-numeric: tabular-nums; }
        .cat-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .cat-count { font-size: 13px; color: #6b7280; }

        .ac-actions { display: flex; align-items: center; gap: 4px; flex-wrap: nowrap; }
        .act-btn {
            padding: 5px 11px; border-radius: 6px;
            font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: inherit; transition: all 0.15s;
            display: inline-flex; align-items: center; gap: 4px;
            white-space: nowrap;
        }
        .act-view         { background: #fff7ed; color: #ea580c; }
        .act-view:hover   { background: #ffedd5; }
        .act-edit         { background: #eff6ff; color: #2563eb; }
        .act-edit:hover   { background: #dbeafe; }
        .act-delete       { background: transparent; color: #9ca3af; padding: 5px 8px; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }

        /* ── Mobile card list (hidden on desktop) ── */
        .ac-mobile-list { display: none; }
        .ac-mobile-item {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        .ac-mobile-item:last-child { border-bottom: none; }
        .ac-mobile-top {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 10px; margin-bottom: 8px;
        }
        .ac-mobile-name { font-size: 14px; font-weight: 600; color: #1c1917; }
        .ac-mobile-id   { font-size: 12px; color: #ea580c; font-weight: 700; margin-top: 2px; }
        .ac-mobile-meta {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 10px; flex-wrap: wrap;
        }
        .ac-pill {
            display: inline-flex; padding: 3px 9px;
            border-radius: 20px; font-size: 11px; font-weight: 600;
            background: #f3f4f6; color: #6b7280;
        }
        .ac-mobile-actions {
            display: flex; align-items: center; gap: 6px;
        }
        .ac-mobile-actions .act-btn { flex: 1; justify-content: center; }

        /* ── Pagination ── */
        .ac-pagination {
            display: flex; align-items: center; justify-content: space-between;
            padding: 13px 18px; border-top: 1px solid #f3f4f6;
            flex-wrap: wrap; gap: 10px;
        }
        .ac-page-info { font-size: 12px; color: #9ca3af; }
        .ac-page-btns { display: flex; gap: 4px; flex-wrap: wrap; }
        .ac-page-btn {
            min-width: 32px; height: 32px; padding: 0 6px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px; font-size: 13px; font-weight: 500;
            cursor: pointer; border: 1px solid #e5e7eb;
            background: #fff; color: #6b7280;
            text-decoration: none; transition: all 0.15s; font-family: inherit;
        }
        .ac-page-btn:hover   { border-color: #ea580c; color: #ea580c; }
        .ac-page-btn.active  { background: #ea580c; border-color: #ea580c; color: #fff; }
        .ac-page-btn.disabled { opacity: 0.35; pointer-events: none; }

        /* ── Empty state ── */
        .ac-empty { text-align: center; padding: 56px 20px; }
        .ac-empty-icon  { font-size: 40px; margin-bottom: 12px; }
        .ac-empty-title { font-size: 15px; font-weight: 600; color: #1c1917; }
        .ac-empty-sub   { font-size: 13px; color: #9ca3af; margin-top: 4px; }

        /* ════════════════════════════════
           MOBILE
           ════════════════════════════════ */
        @media (max-width: 768px) {
            .ac-title    { font-size: 18px; }
            .ac-subtitle { font-size: 12px; margin-bottom: 18px; }

            /* Hide desktop table, show mobile card list */
            .ac-table-wrap { display: none; }
            .ac-mobile-list { display: block; }

            /* Toolbar: search full width */
            .ac-toolbar { padding: 12px 14px; }
            .ac-search  { max-width: 100%; flex: 1; }

            /* Pagination compact */
            .ac-pagination { padding: 12px 14px; }
            .ac-page-info  { font-size: 11px; }

            /* Alert */
            .ac-alert { font-size: 12px; padding: 10px 13px; }
        }
    </style>

    <div class="ac-title">Category</div>
    <p class="ac-subtitle">Kelola data kategori paket</p>

    @if(session('success'))
        <div class="ac-alert ac-alert-success">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ac-alert ac-alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="ac-table-card">

        @if($categories->isEmpty())
            <div class="ac-empty">
                <div class="ac-empty-icon">🗂️</div>
                <div class="ac-empty-title">Belum ada category</div>
                <div class="ac-empty-sub">Tambahkan category pertama dengan klik "Add Category"</div>
            </div>
        @else

            {{-- Toolbar --}}
            <div class="ac-toolbar">
                <div class="ac-search">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari category...">
                </div>
                <span class="ac-record-count">{{ $categories->total() }} kategori</span>
            </div>

            {{-- ── Desktop Table ── --}}
            <div class="ac-table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Category ID</th>
                            <th>Nama Category</th>
                            <th>Jumlah Package</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $i => $category)
                            <tr>
                                <td style="color:#9ca3af;font-size:12px;">{{ $categories->firstItem() + $i }}</td>
                                <td><span class="cat-id">{{ $category->category_id }}</span></td>
                                <td><span class="cat-name">{{ $category->nama_category }}</span></td>
                                <td>
                                    <span class="cat-count">
                                        {{ $category->packages_count ?? $category->packages->count() }} paket
                                    </span>
                                </td>
                                <td>
                                    <div class="ac-actions">
                                        <a href="{{ route('category.show', $category) }}" class="act-btn act-view">Detail</a>
                                        <a href="{{ route('category.edit', $category) }}" class="act-btn act-edit">Edit</a>
                                        <form action="{{ route('category.destroy', $category) }}" method="POST" class="delete-form" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="act-btn act-delete" title="Hapus">
                                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                                    <path d="M10 11v6M14 11v6"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ── Mobile Card List ── --}}
            <div class="ac-mobile-list">
                @foreach($categories as $i => $category)
                    <div class="ac-mobile-item" data-search="{{ strtolower($category->category_id . ' ' . $category->nama_category) }}">
                        <div class="ac-mobile-top">
                            <div>
                                <div class="ac-mobile-name">{{ $category->nama_category }}</div>
                                <div class="ac-mobile-id">{{ $category->category_id }}</div>
                            </div>
                            <span class="ac-pill">
                                {{ $category->packages_count ?? $category->packages->count() }} paket
                            </span>
                        </div>
                        <div class="ac-mobile-actions">
                            <a href="{{ route('category.show', $category) }}" class="act-btn act-view">Detail</a>
                            <a href="{{ route('category.edit', $category) }}" class="act-btn act-edit">Edit</a>
                            <form action="{{ route('category.destroy', $category) }}" method="POST" class="delete-form" style="display:contents;">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn act-delete" title="Hapus" style="flex:0;">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($categories->hasPages())
                <div class="ac-pagination">
                    <span class="ac-page-info">
                        {{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }} data
                    </span>
                    <div class="ac-page-btns">
                        <a href="{{ $categories->previousPageUrl() ?? '#' }}"
                           class="ac-page-btn {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="ac-page-btn {{ $page == $categories->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                        <a href="{{ $categories->nextPageUrl() ?? '#' }}"
                           class="ac-page-btn {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

        @endif
    </div>{{-- /ac-table-card --}}

    <script>
        /* ── Search: works on both table rows AND mobile cards ── */
        document.getElementById('searchInput')?.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();

            /* Desktop rows */
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });

            /* Mobile cards */
            document.querySelectorAll('.ac-mobile-item').forEach(item => {
                const haystack = (item.dataset.search || item.textContent).toLowerCase();
                item.style.display = haystack.includes(q) ? '' : 'none';
            });
        });

        /* ── Delete confirmation ── */
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus category ini? Semua package terkait mungkin akan terpengaruh.')) {
                    form.submit();
                }
            });
        });
    </script>

</x-app-sidebar>