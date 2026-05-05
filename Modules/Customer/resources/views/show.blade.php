<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.index') }}" style="color:#6b7280;text-decoration:none;">Customer List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">{{ $company->name }}</span>
    </x-slot>

    <x-slot name="topbarActions">
        <a href="{{ route('customer.edit', $company) }}" class="btn-primary-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Customer
        </a>
    </x-slot>

    <style>
        /* ─── Base ─── */
        .btn-primary-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
            white-space: nowrap;
        }
        .btn-primary-sm:hover { background: #c2410c; }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ─── Hero ─── */
        .hero {
            background: linear-gradient(135deg, #1c1917 0%, #292524 100%);
            border-radius: 14px; padding: 24px 24px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
        }
        .hero-avatar {
            width: 56px; height: 56px; border-radius: 14px;
            background: linear-gradient(135deg, #ea580c, #f97316);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .hero-info { flex: 1; min-width: 0; }
        .hero-name { font-size: 20px; font-weight: 700; color: #fff; letter-spacing: -0.3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .hero-slug { font-size: 12px; color: #a8a29e; margin-top: 3px; font-family: monospace; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .hero-meta { display: flex; gap: 14px; margin-top: 10px; flex-wrap: wrap; }
        .hero-meta-item { display: flex; align-items: center; gap: 5px; font-size: 12.5px; color: #d6d3d1; }
        .hero-meta-icon { color: #f97316; flex-shrink: 0; }
        .hero-badge {
            padding: 4px 12px; background: rgba(234,88,12,0.2); border: 1px solid rgba(234,88,12,0.3);
            border-radius: 20px; font-size: 12px; font-weight: 600; color: #fb923c;
            white-space: nowrap; align-self: flex-start;
        }

        /* ─── Layout ─── */
        .detail-layout { display: grid; grid-template-columns: 1fr 320px; gap: 18px; align-items: start; }

        /* ─── Cards ─── */
        .detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
        .detail-card:last-child { margin-bottom: 0; }
        .detail-card-header {
            padding: 13px 18px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .detail-card-title { font-size: 13.5px; font-weight: 600; color: #1c1917; display: flex; align-items: center; gap: 7px; }
        .detail-card-body { padding: 18px; }

        /* ─── Info Grid ─── */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; }
        .info-cell { padding: 14px 18px; border-bottom: 1px solid #f3f4f6; }
        .info-cell.full { grid-column: 1 / -1; }
        .info-cell:nth-last-child(1),
        .info-cell:nth-last-child(2):not(.full) { border-bottom: none; }
        .info-cell + .info-cell:not(.full) { border-left: 1px solid #f3f4f6; }
        .info-cell-label { font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 4px; }
        .info-cell-value { font-size: 13.5px; color: #1c1917; font-weight: 500; line-height: 1.4; }
        .info-cell-value.muted { color: #9ca3af; font-style: italic; font-weight: 400; }
        .info-cell-value.mono  { font-family: monospace; font-size: 12.5px; }

        /* ─── Contact Cards ─── */
        .contact-card { border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; margin-bottom: 12px; }
        .contact-card:last-child { margin-bottom: 0; }
        .contact-card-header {
            padding: 11px 15px; background: #fafafa; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between; gap: 8px;
        }
        .contact-name { font-size: 13.5px; font-weight: 600; color: #1c1917; }
        .contact-position {
            display: inline-flex; padding: 2px 9px;
            background: #fff7ed; border-radius: 20px; font-size: 11px; font-weight: 600; color: #ea580c;
            white-space: nowrap;
        }
        .contact-body { padding: 13px 15px; }
        .contact-detail-row { display: flex; align-items: center; gap: 8px; margin-bottom: 7px; font-size: 13px; color: #374151; }
        .contact-detail-row:last-child { margin-bottom: 0; }
        .contact-detail-row svg { flex-shrink: 0; color: #9ca3af; }
        .contact-sig { margin-top: 12px; padding-top: 12px; border-top: 1px dashed #e5e7eb; }
        .contact-sig-label { font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 8px; }
        .signature-box {
            display: inline-flex; align-items: center; justify-content: center;
            background: #fff; border: 1px dashed #d1d5db; border-radius: 8px;
            padding: 8px; max-width: 100%;
        }
        .signature-box img { max-height: 80px; max-width: 100%; object-fit: contain; }

        .no-contacts { text-align: center; padding: 28px 20px; }
        .no-contacts-icon { font-size: 28px; margin-bottom: 8px; }
        .no-contacts-text { font-size: 13px; color: #9ca3af; }

        /* ─── Sidebar ─── */
        .side-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
        .side-card:last-child { margin-bottom: 0; }
        .side-card-header { padding: 13px 18px; border-bottom: 1px solid #f3f4f6; font-size: 13px; font-weight: 600; color: #374151; display: flex; align-items: center; gap: 7px; }
        .side-card-body { padding: 18px; }

        .meta-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 13px; }
        .meta-row:last-child { margin-bottom: 0; }
        .meta-key { color: #9ca3af; font-size: 12px; padding-top: 1px; flex-shrink: 0; }
        .meta-val { color: #374151; font-weight: 500; text-align: right; max-width: 170px; word-break: break-word; }

        .btn-block {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: all 0.15s; font-family: 'Sora', sans-serif;
            width: 100%; box-sizing: border-box; border: none; margin-bottom: 8px;
        }
        .btn-block:last-child { margin-bottom: 0; }
        .btn-orange        { background: #ea580c; color: #fff; }
        .btn-orange:hover  { background: #c2410c; }
        .btn-neutral       { background: #f3f4f6; color: #374151; }
        .btn-neutral:hover { background: #e5e7eb; }
        .btn-red-outline         { background: transparent; color: #dc2626; border: 1px solid #fecaca; }
        .btn-red-outline:hover   { background: #fef2f2; }

        .order-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .order-item:last-child { border-bottom: none; }
        .order-id   { font-size: 13px; font-weight: 600; color: #374151; }
        .order-date { font-size: 12px; color: #9ca3af; }

        /* ─── Mobile Quick-Action Bar ─── */
        .mobile-action-bar {
            display: none;
            position: sticky; bottom: 0; left: 0; right: 0; z-index: 50;
            background: #fff; border-top: 1px solid #e5e7eb;
            padding: 10px 16px; gap: 8px;
        }
        .mobile-action-bar .btn-block { margin-bottom: 0; }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            /* Hero */
            .hero { padding: 16px; gap: 14px; border-radius: 12px; margin-bottom: 16px; }
            .hero-avatar { width: 48px; height: 48px; border-radius: 12px; font-size: 17px; }
            .hero-name { font-size: 17px; }
            .hero-slug { font-size: 11px; }
            .hero-meta { gap: 10px; margin-top: 8px; }
            .hero-meta-item { font-size: 12px; }

            /* Stack layout */
            .detail-layout { grid-template-columns: 1fr; gap: 0; }

            /* Sidebar goes below main on mobile */
            .detail-sidebar { order: 2; margin-top: 4px; }
            .detail-main    { order: 1; }

            /* Hide desktop sidebar action card — actions shown in sticky bar */
            .side-card-actions { display: none; }

            /* Show mobile sticky bar */
            .mobile-action-bar { display: flex; }

            /* Info grid: single column on small screens */
            .info-grid { grid-template-columns: 1fr; }
            .info-cell + .info-cell:not(.full) { border-left: none; border-top: 1px solid #f3f4f6; }
            .info-cell.full { grid-column: 1; }
            .info-cell:nth-last-child(1) { border-bottom: none; }
            .info-cell:nth-last-child(2):not(.full) { border-bottom: 1px solid #f3f4f6; }

            /* Cards */
            .detail-card { margin-bottom: 12px; border-radius: 10px; }
            .detail-card-body { padding: 14px; }
            .detail-card-header { padding: 11px 14px; }
            .side-card { border-radius: 10px; margin-bottom: 12px; }
            .side-card-body { padding: 14px; }

            /* Contact cards */
            .contact-body { padding: 12px 14px; }
            .contact-card-header { padding: 10px 14px; }
        }

        @media (max-width: 480px) {
            .hero-meta .hero-meta-item:nth-child(n+3) { display: none; } /* hide overflow meta */
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Hero --}}
    <div class="hero">
        <div class="hero-avatar">{{ strtoupper(substr($company->name, 0, 2)) }}</div>
        <div class="hero-info">
            <div class="hero-name">{{ $company->name }}</div>
            <div class="hero-slug">{{ $company->slug }}</div>
            <div class="hero-meta">
                @if($company->phone)
                    <div class="hero-meta-item">
                        <svg class="hero-meta-icon" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $company->phone }}
                    </div>
                @endif
                @if($company->address)
                    <div class="hero-meta-item">
                        <svg class="hero-meta-icon" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ Str::limit($company->address, 40) }}
                    </div>
                @endif
                <div class="hero-meta-item">
                    <svg class="hero-meta-icon" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    {{ $company->contacts->count() }} Kontak
                </div>
            </div>
        </div>
        <span class="hero-badge">ID #{{ $company->id }}</span>
    </div>

    {{-- Body Layout --}}
    <div class="detail-layout">

        {{-- ── MAIN ── --}}
        <div class="detail-main">
            {{-- Company Info --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Informasi Perusahaan
                    </div>
                </div>
                <div class="detail-card-body" style="padding:0;">
                    <div class="info-grid">
                        <div class="info-cell">
                            <div class="info-cell-label">Nama Perusahaan</div>
                            <div class="info-cell-value">{{ $company->name }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-cell-label">Slug</div>
                            <div class="info-cell-value mono">{{ $company->slug }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-cell-label">Nomor Telepon</div>
                            <div class="info-cell-value {{ !$company->phone ? 'muted' : '' }}">{{ $company->phone ?? 'Tidak diisi' }}</div>
                        </div>
                        <div class="info-cell">
                            <div class="info-cell-label">Terdaftar</div>
                            <div class="info-cell-value">{{ $company->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="info-cell full">
                            <div class="info-cell-label">Alamat</div>
                            <div class="info-cell-value {{ !$company->address ? 'muted' : '' }}">{{ $company->address ?? 'Tidak diisi' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contacts --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        Kontak ({{ $company->contacts->count() }})
                    </div>
                    <a href="{{ route('customer.edit', $company) }}" style="font-size:12px;color:#ea580c;font-weight:600;text-decoration:none;">+ Tambah</a>
                </div>
                <div class="detail-card-body">
                    @if($company->contacts->isEmpty())
                        <div class="no-contacts">
                            <div class="no-contacts-icon">👤</div>
                            <div class="no-contacts-text">Belum ada kontak untuk perusahaan ini</div>
                        </div>
                    @else
                        @foreach($company->contacts as $contact)
                            <div class="contact-card">
                                <div class="contact-card-header">
                                    <div class="contact-name">{{ $contact->name }}</div>
                                    @if($contact->jabatan)
                                        <span class="contact-position">{{ $contact->jabatan }}</span>
                                    @endif
                                </div>
                                <div class="contact-body">
                                    @if($contact->email)
                                        <div class="contact-detail-row">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            {{ $contact->email }}
                                        </div>
                                    @endif
                                    @if($contact->phone)
                                        <div class="contact-detail-row">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $contact->phone }}
                                        </div>
                                    @endif
                                    @if(!$contact->email && !$contact->phone)
                                        <div style="font-size:13px;color:#9ca3af;font-style:italic;">Tidak ada detail kontak</div>
                                    @endif
                                    @if($contact->signature_path)
                                        <div class="contact-sig">
                                            <div class="contact-sig-label">Tanda Tangan</div>
                                            <div class="signature-box">
                                                <img src="{{ $contact->signature_url }}" alt="Tanda Tangan {{ $contact->name }}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="detail-sidebar">
            {{-- Actions (hidden on mobile — replaced by sticky bar) --}}
            <div class="side-card side-card-actions">
                <div class="side-card-header">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Aksi
                </div>
                <div class="side-card-body">
                    <a href="{{ route('customer.edit', $company) }}" class="btn-block btn-orange">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Customer
                    </a>
                    <a href="{{ route('customer.index') }}" class="btn-block btn-neutral">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke List
                    </a>
                    <form action="{{ route('customer.destroy', $company) }}" method="POST" class="delete-form">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-block btn-red-outline">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                            Hapus Customer
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info Data --}}
            <div class="side-card">
                <div class="side-card-header">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Info Data
                </div>
                <div class="side-card-body">
                    <div class="meta-row">
                        <span class="meta-key">ID</span>
                        <span class="meta-val">#{{ $company->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Slug</span>
                        <span class="meta-val" style="font-family:monospace;font-size:12px;">{{ $company->slug }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Total Kontak</span>
                        <span class="meta-val">{{ $company->contacts->count() }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Total Order</span>
                        <span class="meta-val">{{ $company->orders->count() }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Dibuat</span>
                        <span class="meta-val">{{ $company->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Diperbarui</span>
                        <span class="meta-val">{{ $company->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            @if($company->orders->isNotEmpty())
                <div class="side-card">
                    <div class="side-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Order Terkait
                    </div>
                    <div class="side-card-body" style="padding: 0 18px;">
                        @foreach($company->orders->take(5) as $order)
                            <div class="order-item">
                                <div>
                                    <div class="order-id">#{{ $order->id }}</div>
                                    <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                        @if($company->orders->count() > 5)
                            <div style="padding:10px 0;font-size:12px;color:#9ca3af;text-align:center;">
                                +{{ $company->orders->count() - 5 }} order lainnya
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ── MOBILE STICKY ACTION BAR ── --}}
    <div class="mobile-action-bar">
        <a href="{{ route('customer.index') }}" class="btn-block btn-neutral" style="flex:0 0 auto;width:auto;padding:10px 14px;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <a href="{{ route('customer.edit', $company) }}" class="btn-block btn-orange" style="flex:1;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Customer
        </a>
        <form action="{{ route('customer.destroy', $company) }}" method="POST" class="delete-form" style="flex:0 0 auto;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-block btn-red-outline" style="width:auto;padding:10px 14px;margin:0;">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
            </button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                if (confirm('Hapus perusahaan "{{ $company->name }}"? Semua kontak terkait juga akan dihapus.')) e.target.submit();
            });
        });
    </script>
</x-app-sidebar>