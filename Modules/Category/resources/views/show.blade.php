<x-app-sidebar>
    <x-slot name="title">Detail Category</x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('category.index') }}" style="color:#6b7280;text-decoration:none;">Category</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Detail Category</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('category.edit', $category) }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
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

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
        @media (max-width: 640px) { .detail-grid { grid-template-columns: 1fr; } }

        .info-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px;
        }
        .info-card-header {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.6px; color: #9ca3af; margin-bottom: 16px;
            padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; gap: 6px;
        }
        .info-row { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-key   { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; }
        .info-value { font-size: 14px; font-weight: 600; color: #1c1917; }
        .info-value.muted { font-weight: 400; color: #6b7280; }

        .cat-id-badge {
            display: inline-flex; padding: 4px 12px; background: #fff7ed;
            border: 1px solid #fed7aa; border-radius: 20px;
            font-size: 13px; font-weight: 700; color: #ea580c;
            font-variant-numeric: tabular-nums;
        }

        /* Packages table */
        .section-title {
            font-size: 15px; font-weight: 700; color: #1c1917; margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-count {
            font-size: 12px; font-weight: 600; background: #f3f4f6;
            color: #6b7280; padding: 2px 8px; border-radius: 20px;
        }

        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }
        td { padding: 13px 20px; font-size: 13px; vertical-align: middle; color: #374151; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 600; color: #9ca3af;
            text-decoration: none; margin-bottom: 20px; transition: color 0.15s;
        }
        .back-link:hover { color: #ea580c; }

        .empty-packages { text-align: center; padding: 36px 20px; color: #9ca3af; font-size: 13px; }
    </style>

    <a href="{{ route('category.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke list
    </a>

    <div class="dash-title">{{ $category->nama_category }}</div>
    <p class="dash-subtitle">Detail informasi category</p>

    <div class="detail-grid">
        <div class="info-card">
            <div class="info-card-header">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Informasi Category
            </div>
            <div class="info-row">
                <span class="info-key">Category ID</span>
                <span class="cat-id-badge">{{ $category->category_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Nama Category</span>
                <span class="info-value">{{ $category->nama_category }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Dibuat</span>
                <span class="info-value muted">{{ $category->created_at?->format('d M Y') ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Terakhir diperbarui</span>
                <span class="info-value muted">{{ $category->updated_at?->format('d M Y') ?? '-' }}</span>
            </div>
        </div>

        <div class="info-card">
            <div class="info-card-header">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                Statistik
            </div>
            <div class="info-row">
                <span class="info-key">Total Package</span>
                <span class="info-value" style="font-size:32px;color:#ea580c;">
                    {{ $category->packages->count() }}
                </span>
            </div>
        </div>
    </div>

    {{-- Packages list --}}
    <div class="section-title">
        Daftar Package
        <span class="section-count">{{ $category->packages->count() }}</span>
    </div>

    <div class="table-card">
        @if($category->packages->isEmpty())
            <div class="empty-packages">Belum ada package dalam category ini.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Package</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->packages as $i => $package)
                        <tr>
                            <td style="color:#9ca3af;font-size:12px;">{{ $i + 1 }}</td>
                            <td style="font-weight:600;color:#1c1917;">{{ $package->name ?? $package->nama ?? '-' }}</td>
                            <td style="color:#6b7280;">{{ $package->description ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-sidebar>