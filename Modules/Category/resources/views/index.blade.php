<x-app-sidebar>
    <x-slot name="title">Category</x-slot>

    <x-slot name="breadcrumb">
        <span>Category</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Category List</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('category.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Category
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

        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }

        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f3f4f6; gap: 12px; flex-wrap: wrap;
        }
        .search-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #f9fafb; border: 1px solid #e5e7eb;
            border-radius: 8px; padding: 8px 14px; width: 260px;
        }
        .search-wrap svg { color: #9ca3af; flex-shrink: 0; }
        .search-wrap input {
            background: transparent; border: none; outline: none;
            font-size: 13px; font-family: 'Sora', sans-serif; color: #1c1917; width: 100%;
        }
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

        .cat-id   { font-weight: 700; font-size: 13px; color: #ea580c; font-variant-numeric: tabular-nums; }
        .cat-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }

        .actions { display: flex; align-items: center; gap: 4px; }
        .act-btn {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s; display: inline-flex; align-items: center; gap: 4px;
        }
        .act-view       { background: #fff7ed; color: #ea580c; }
        .act-view:hover { background: #ffedd5; }
        .act-edit       { background: #eff6ff; color: #2563eb; }
        .act-edit:hover { background: #dbeafe; }
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

    <div class="dash-title">Category</div>
    <p class="dash-subtitle">Kelola data kategori paket</p>

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

    <div class="table-card">
        @if($categories->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🗂️</div>
                <div class="empty-title">Belum ada category</div>
                <div class="empty-sub">Tambahkan category pertama dengan klik "Add Category"</div>
            </div>
        @else
            <div class="table-toolbar">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="searchInput" placeholder="Cari category...">
                </div>
                <span class="record-count">{{ $categories->total() }} kategori</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width:80px;">#</th>
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
                                <span style="font-size:13px;color:#6b7280;">
                                    {{ $category->packages_count ?? $category->packages->count() }} paket
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('category.show', $category) }}" class="act-btn act-view">Detail</a>
                                    <a href="{{ route('category.edit', $category) }}" class="act-btn act-edit">Edit</a>
                                    <form action="{{ route('category.destroy', $category) }}" method="POST" class="delete-form" style="display:inline;">
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

            @if($categories->hasPages())
                <div class="pagination">
                    <span class="page-info">
                        Menampilkan {{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }} data
                    </span>
                    <div class="page-btns">
                        <a href="{{ $categories->previousPageUrl() ?? '#' }}" class="page-btn {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $categories->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach
                        <a href="{{ $categories->nextPageUrl() ?? '#' }}" class="page-btn {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus category ini? Semua package terkait mungkin akan terpengaruh.')) form.submit();
            });
        });
    </script>
</x-app-sidebar>