<x-app-sidebar>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="breadcrumb">
        <span class="current">Dashboard</span>
    </x-slot>

    <style>
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            border-radius: 3px 3px 0 0;
        }

        .stat-card:nth-child(1)::before { background: #ea580c; }
        .stat-card:nth-child(2)::before { background: #10b981; }
        .stat-card:nth-child(3)::before { background: #f59e0b; }
        .stat-card:nth-child(4)::before { background: #ef4444; }

        .stat-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .stat-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .stat-value { font-size: 28px; font-weight: 700; color: #1c1917; margin-top: 4px; line-height: 1; }
        .stat-desc  { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .welcome-card {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            border-radius: 14px;
            padding: 32px 36px;
            color: #fff;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            right: -40px; top: -40px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .welcome-title { font-size: 20px; font-weight: 700; margin-bottom: 6px; }
        .welcome-sub   { font-size: 13px; opacity: 0.75; }

        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title { font-size: 14px; font-weight: 700; color: #1c1917; }
        .card-link  { font-size: 12px; color: #ea580c; text-decoration: none; font-weight: 600; }
        .card-link:hover { text-decoration: underline; }

        .card-body { padding: 8px 0; }

        .list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            transition: background 0.1s;
        }

        .list-item:hover { background: #fff7ed; }

        .li-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }

        .li-name  { font-size: 13px; font-weight: 600; color: #1c1917; }
        .li-email { font-size: 11.5px; color: #9ca3af; }
        .li-date  { font-size: 11.5px; color: #9ca3af; margin-left: auto; }

        .activity-item {
            display: flex;
            gap: 12px;
            padding: 10px 20px;
        }

        .act-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .act-text { font-size: 13px; color: #374151; line-height: 1.5; }
        .act-time { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .bottom-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="dash-title">Dashboard</div>
    <p class="dash-subtitle">Welcome back, {{ auth()->user()->name }} 👋</p>

    {{-- Welcome Banner --}}
    <div class="welcome-card">
        <div class="welcome-badge">
            <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="5"/></svg>
            System Online
        </div>
        <div class="welcome-title">You're logged in!</div>
        <div class="welcome-sub">{{ config('app.name') }} Admin Panel — {{ now()->format('l, d F Y') }}</div>
    </div>

    {{-- Stats --}}
    @php
        $totalUsers    = \App\Models\User::count();
        $verifiedUsers = \App\Models\User::whereNotNull('email_verified_at')->count();
        $newThisMonth  = \App\Models\User::whereMonth('created_at', now()->month)->count();
        $unverified    = $totalUsers - $verifiedUsers;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed">👥</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-desc">All registered accounts</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4">✅</div>
            <div class="stat-label">Verified</div>
            <div class="stat-value">{{ $verifiedUsers }}</div>
            <div class="stat-desc">Email confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb">🆕</div>
            <div class="stat-label">New This Month</div>
            <div class="stat-value">{{ $newThisMonth }}</div>
            <div class="stat-desc">{{ now()->format('F Y') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2">⚠️</div>
            <div class="stat-label">Unverified</div>
            <div class="stat-value">{{ $unverified }}</div>
            <div class="stat-desc">Pending verification</div>
        </div>
    </div>

    {{-- Bottom Grid --}}
    <div class="bottom-grid">

        {{-- Recent Users --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Recent Users</span>
                <a href="{{ route('users.index') }}" class="card-link">View all →</a>
            </div>
            <div class="card-body">
                @php
                    $palette = ['#ea580c','#f97316','#06b6d4','#10b981','#f59e0b'];
                    $recent  = \App\Models\User::latest()->take(5)->get();
                @endphp
                @foreach($recent as $u)
                <div class="list-item">
                    <div class="li-avatar" style="background:{{ $palette[$u->id % count($palette)] }}">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="li-name">{{ $u->name }}</div>
                        <div class="li-email">{{ $u->email }}</div>
                    </div>
                    <span class="li-date">{{ $u->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Info --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Quick Info</span>
            </div>
            <div class="card-body" style="padding: 12px 20px;">
                <div class="activity-item">
                    <div class="act-dot" style="background:#ea580c"></div>
                    <div>
                        <div class="act-text">Total <strong>{{ $totalUsers }}</strong> users registered</div>
                        <div class="act-time">All time</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-dot" style="background:#10b981"></div>
                    <div>
                        <div class="act-text"><strong>{{ $verifiedUsers }}</strong> users have verified their email</div>
                        <div class="act-time">{{ $totalUsers > 0 ? round($verifiedUsers / $totalUsers * 100) : 0 }}% verification rate</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-dot" style="background:#f59e0b"></div>
                    <div>
                        <div class="act-text"><strong>{{ $newThisMonth }}</strong> new users this month</div>
                        <div class="act-time">{{ now()->format('F Y') }}</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="act-dot" style="background:#ef4444"></div>
                    <div>
                        <div class="act-text"><strong>{{ $unverified }}</strong> accounts need verification</div>
                        <div class="act-time">Pending action</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-sidebar>