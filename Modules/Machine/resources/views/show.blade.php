<x-app-sidebar>
    <x-slot name="title">Detail Machine</x-slot>

    <x-slot name="breadcrumb">
        <span>Machine</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('machine.index') }}" style="color: #6b7280; text-decoration: none;">Machine List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">{{ $machine->name }}</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('machine.edit', $machine) }}" class="btn-secondary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <form action="{{ route('machine.destroy', $machine) }}" method="POST" id="deleteForm">
            @csrf @method('DELETE')
            <button type="button" onclick="confirmDelete()" class="btn-danger-sm">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                Hapus
            </button>
        </form>
    </x-slot>

    <style>
        .btn-secondary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fff; color: #374151;
            border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif; cursor: pointer;
        }
        .btn-secondary-sm:hover { border-color: #d1d5db; background: #f9fafb; }

        .btn-danger-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #fef2f2; color: #dc2626;
            border: 1px solid #fecaca; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-danger-sm:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* Summary bar */
        .summary-bar {
            display: flex; align-items: center; gap: 12px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 18px 24px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .summary-icon {
            width: 44px; height: 44px; background: #fff7ed; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .summary-name { font-size: 17px; font-weight: 700; color: #1c1917; }
        .summary-code {
            font-size: 12px; font-weight: 700; color: #6b7280;
            background: #f3f4f6; border: 1px solid #e5e7eb;
            padding: 3px 10px; border-radius: 6px; font-family: monospace; margin-top: 3px; display: inline-block;
        }
        .summary-divider { width: 1px; height: 36px; background: #e5e7eb; flex-shrink: 0; }
        .summary-stat { text-align: center; padding: 0 12px; }
        .summary-stat-val { font-size: 20px; font-weight: 700; color: #1c1917; line-height: 1; }
        .summary-stat-lbl { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }
        .summary-badge { margin-left: auto; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-active   { background: #f0fdf4; color: #16a34a; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
        .dot-active   { background: #16a34a; }
        .dot-inactive { background: #9ca3af; }

        /* Grid layout */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
        .col-full { grid-column: 1 / -1; }

        /* Cards */
        .detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }

        .detail-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px; border-bottom: 1px solid #f3f4f6; background: #fafafa;
        }
        .detail-card-title { font-size: 13px; font-weight: 700; color: #1c1917; display: flex; align-items: center; gap: 6px; }
        .count-pill {
            font-size: 11px; font-weight: 600; color: #6b7280;
            background: #f3f4f6; border: 1px solid #e5e7eb;
            padding: 2px 8px; border-radius: 20px;
        }

        /* Info rows */
        .info-list { padding: 4px 0; }
        .info-row {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding: 12px 20px; border-bottom: 1px solid #f9fafb; gap: 16px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-key { font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; white-space: nowrap; padding-top: 1px; }
        .info-val { font-size: 13.5px; color: #1c1917; font-weight: 500; text-align: right; }
        .info-val.muted { color: #9ca3af; font-weight: 400; font-style: italic; }

        /* Operators list */
        .operator-list { padding: 8px 0; }
        .operator-row {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 20px; border-bottom: 1px solid #f9fafb; transition: background 0.1s;
        }
        .operator-row:last-child { border-bottom: none; }
        .operator-row:hover { background: #fff7ed; }
        .operator-avatar {
            width: 34px; height: 34px; border-radius: 50%; background: #ea580c;
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; flex-shrink: 0;
        }
        .operator-name { font-size: 13.5px; font-weight: 600; color: #1c1917; }
        .operator-sub  { font-size: 12px; color: #9ca3af; margin-top: 1px; }

        /* Packages table */
        .packages-table { width: 100%; border-collapse: collapse; }
        .packages-table thead th {
            padding: 10px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .packages-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        .packages-table tbody tr:last-child { border-bottom: none; }
        .packages-table tbody tr:hover { background: #fff7ed; }
        .packages-table td { padding: 12px 20px; font-size: 13px; vertical-align: middle; color: #374151; }

        .empty-inline { padding: 32px 20px; text-align: center; }
        .empty-inline-icon { font-size: 28px; margin-bottom: 8px; }
        .empty-inline-text { font-size: 13px; color: #9ca3af; }

        /* Timestamps */
        .timestamps { display: flex; gap: 24px; padding: 14px 20px; flex-wrap: wrap; }
        .ts-item { display: flex; flex-direction: column; gap: 2px; }
        .ts-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; }
        .ts-value { font-size: 12.5px; color: #6b7280; }
    </style>

    {{-- Summary Bar --}}
    <div class="summary-bar">
        <div class="summary-icon">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="summary-name">{{ $machine->name }}</div>
            <span class="summary-code">{{ $machine->code }}</span>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-stat">
            <div class="summary-stat-val">{{ $machine->operators->count() }}</div>
            <div class="summary-stat-lbl">Operators</div>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-stat">
            <div class="summary-stat-val">{{ $machine->packages->count() }}</div>
            <div class="summary-stat-lbl">Packages</div>
        </div>
        <div class="summary-badge">
            @php $status = $machine->is_active ? 'active' : 'inactive'; @endphp
            <span class="badge badge-{{ $status }}">
                <span class="dot dot-{{ $status }}"></span>
                {{ $machine->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="detail-grid">

        {{-- General Info --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Umum
                </div>
            </div>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-key">Nama</span>
                    <span class="info-val">{{ $machine->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Kode</span>
                    <span class="info-val"><code style="background:#f3f4f6;padding:2px 8px;border-radius:4px;font-size:12.5px;border:1px solid #e5e7eb;">{{ $machine->code }}</code></span>
                </div>
                <div class="info-row">
                    <span class="info-key">Status</span>
                    <span class="info-val">
                        <span class="badge badge-{{ $status }}">
                            <span class="dot dot-{{ $status }}"></span>
                            {{ $machine->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-key">Deskripsi</span>
                    <span class="info-val {{ !$machine->description ? 'muted' : '' }}" style="max-width:240px;text-align:right;">
                        {{ $machine->description ?? 'Tidak ada deskripsi' }}
                    </span>
                </div>
            </div>
            <div class="timestamps" style="border-top:1px solid #f3f4f6;">
                <div class="ts-item">
                    <span class="ts-label">Dibuat</span>
                    <span class="ts-value">{{ $machine->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="ts-item">
                    <span class="ts-label">Diperbarui</span>
                    <span class="ts-value">{{ $machine->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Operators --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Assigned Operators
                </div>
                <span class="count-pill">{{ $machine->operators->count() }}</span>
            </div>

            @if($machine->operators->isEmpty())
                <div class="empty-inline">
                    <div class="empty-inline-icon">👤</div>
                    <div class="empty-inline-text">Belum ada operator yang diassign</div>
                </div>
            @else
                <div class="operator-list">
                    @foreach($machine->operators as $operator)
                        <div class="operator-row">
                            <div class="operator-avatar">{{ strtoupper(substr($operator->user->name, 0, 1)) }}</div>
                            <div>
                                <div class="operator-name">{{ $operator->id }}</div>
                                @if(isset($operator->employee_code))
                                    <div class="operator-sub">{{ $operator->employee_code }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Packages --}}
        <div class="detail-card col-full">
            <div class="detail-card-header">
                <div class="detail-card-title">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Packages
                </div>
                <span class="count-pill">{{ $machine->packages->count() }}</span>
            </div>

            @if($machine->packages->isEmpty())
                <div class="empty-inline">
                    <div class="empty-inline-icon">📦</div>
                    <div class="empty-inline-text">Belum ada package untuk mesin ini</div>
                </div>
            @else
                <table class="packages-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Package</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($machine->packages as $package)
                            <tr>
                                <td style="color:#9ca3af;font-size:12.5px;">{{ $loop->iteration }}</td>
                                <td style="font-weight:500;">{{ $package->name ?? '-' }}</td>
                                <td style="color:#9ca3af;font-size:12.5px;">{{ $package->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

    <script>
        function confirmDelete() {
            if (confirm('Hapus mesin "{{ $machine->name }}"? Tindakan ini tidak bisa dibatalkan.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</x-app-sidebar>