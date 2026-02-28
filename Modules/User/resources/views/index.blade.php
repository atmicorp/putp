<x-app-sidebar>
    <x-slot name="title">Users</x-slot>

    <x-slot name="breadcrumb">
        <span>Management</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Users</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('users.create') }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add User
        </a>
    </x-slot>

    <style>
        .btn-primary-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #ea580c;
            color: #fff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
            font-family: 'Sora', sans-serif;
        }
        .btn-primary-sm:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }

        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .page-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: #ea580c;
            border-radius: 3px 3px 0 0;
        }

        .stat-card:nth-child(2)::before { background: #10b981; }
        .stat-card:nth-child(3)::before { background: #f59e0b; }

        .stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 30px; font-weight: 700; color: #1c1917; margin-top: 6px; line-height: 1; }
        .stat-desc  { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .table-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 14px;
            width: 260px;
        }

        .search-wrap input {
            background: transparent;
            border: none;
            outline: none;
            font-size: 13px;
            font-family: 'Sora', sans-serif;
            color: #1c1917;
            width: 100%;
        }

        .search-wrap input::placeholder { color: #9ca3af; }

        .record-count { font-size: 12px; color: #9ca3af; font-weight: 500; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 11px 20px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9ca3af;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }

        td { padding: 14px 20px; font-size: 13.5px; vertical-align: middle; }

        .user-cell { display: flex; align-items: center; gap: 12px; }

        .u-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }

        .u-name  { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .u-email { font-size: 12px; color: #9ca3af; margin-top: 1px; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-verified   { background: #f0fdf4; color: #16a34a; }
        .badge-unverified { background: #fffbeb; color: #d97706; }

        .date-text { font-size: 12.5px; color: #6b7280; }

        .actions { display: flex; align-items: center; gap: 4px; }

        .act-btn {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            font-family: 'Sora', sans-serif;
            transition: all 0.15s;
        }

        .act-edit       { background: #fff7ed; color: #ea580c; }
        .act-edit:hover { background: #ffedd5; }

        .act-delete       { background: transparent; color: #9ca3af; }
        .act-delete:hover { background: #fef2f2; color: #dc2626; }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid #f3f4f6;
        }

        .page-info { font-size: 12.5px; color: #9ca3af; }
        .page-btns { display: flex; gap: 4px; }

        .page-btn {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px;
            font-size: 13px; font-weight: 500;
            cursor: pointer;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.15s;
            font-family: 'Sora', sans-serif;
        }

        .page-btn:hover  { border-color: #ea580c; color: #ea580c; }
        .page-btn.active { background: #ea580c; border-color: #ea580c; color: #fff; }
        .page-btn.disabled { opacity: 0.35; pointer-events: none; }

        .empty-state { text-align: center; padding: 56px 20px; }
        .empty-icon  { font-size: 40px; margin-bottom: 12px; }
        .empty-title { font-size: 15px; font-weight: 600; color: #1c1917; }
        .empty-sub   { font-size: 13px; color: #9ca3af; margin-top: 4px; }
    </style>

    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">✕ {{ session('error') }}</div>
    @endif

    <div class="page-header">
        <h1 class="page-title">User Management</h1>
        <p class="page-subtitle">Manage all registered user accounts</p>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-desc">All registered accounts</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Verified</div>
            <div class="stat-value">{{ $users->getCollection()->where('email_verified_at', '!=', null)->count() }}</div>
            <div class="stat-desc">Email confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Unverified</div>
            <div class="stat-value">{{ $users->getCollection()->whereNull('email_verified_at')->count() }}</div>
            <div class="stat-desc">Pending verification</div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="search-wrap">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#9ca3af;flex-shrink:0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Search by name or email...">
            </div>
            <span class="record-count">{{ $users->total() }} total records</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="width:140px">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($users as $user)
                @php
                    $palette = ['#ea580c','#f97316','#06b6d4','#10b981','#f59e0b','#ef4444'];
                    $color   = $palette[$user->id % count($palette)];
                    $initial = strtoupper(substr($user->name, 0, 1));
                    $num     = $loop->iteration + ($users->currentPage() - 1) * $users->perPage();
                @endphp
                <tr>
                    <td style="color:#d1d5db;font-size:12px;font-weight:500">{{ $num }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="u-avatar" style="background:{{ $color }}">{{ $initial }}</div>
                            <div>
                                <div class="u-name">{{ $user->name }}</div>
                                <div class="u-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge badge-verified">
                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Verified
                            </span>
                        @else
                            <span class="badge badge-unverified">
                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 102 0V6zm-1 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                Unverified
                            </span>
                        @endif
                    </td>
                    <td class="date-text">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('users.edit', $user->id) }}" class="act-btn act-edit">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn act-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">👤</div>
                            <div class="empty-title">No users found</div>
                            <div class="empty-sub">Start by adding your first user</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
        <div class="pagination">
            <span class="page-info">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} results
            </span>
            <div class="page-btns">
                <a href="{{ $users->previousPageUrl() ?? '#' }}"
                   class="page-btn {{ $users->onFirstPage() ? 'disabled' : '' }}">‹</a>
                @for($i = 1; $i <= $users->lastPage(); $i++)
                    <a href="{{ $users->url($i) }}"
                       class="page-btn {{ $users->currentPage() == $i ? 'active' : '' }}">{{ $i }}</a>
                @endfor
                <a href="{{ $users->nextPageUrl() ?? '#' }}"
                   class="page-btn {{ !$users->hasMorePages() ? 'disabled' : '' }}">›</a>
            </div>
        </div>
        @endif
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#tableBody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</x-app-sidebar>