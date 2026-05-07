<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.index') }}" style="color:#6b7280;text-decoration:none;">Daftar Customer</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Edit Customer</span>
    </x-slot>

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; }

        /* ── Page header ── */
        .ac-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .ac-subtitle { font-size: 13px; color: #6b7280; margin-top: 3px; margin-bottom: 24px; }

        /* ── Desktop two-column layout ── */
        .ac-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        /* ── Cards ── */
        .ac-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .ac-card:last-child { margin-bottom: 0; }

        .ac-card-header {
            padding: 13px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ac-card-icon {
            width: 30px; height: 30px;
            background: #fff7ed;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ac-card-title { font-size: 13.5px; font-weight: 600; color: #1c1917; }
        .ac-card-body  { padding: 20px; }

        /* ── Form elements ── */
        .ac-group { margin-bottom: 16px; }
        .ac-group:last-child { margin-bottom: 0; }

        .ac-label {
            display: block;
            font-size: 11px; font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase; letter-spacing: 0.4px;
        }
        .ac-label .req { color: #ea580c; margin-left: 2px; }
        .ac-label .opt { font-weight: 400; color: #9ca3af; text-transform: none; letter-spacing: 0; }

        .ac-input {
            width: 100%; padding: 9px 13px;
            border: 1px solid #e5e7eb; border-radius: 9px;
            font-size: 14px; font-family: inherit;
            color: #1c1917; background: #fff;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .ac-input:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,.1); }
        .ac-input.is-invalid { border-color: #dc2626; }
        .ac-error { font-size: 12px; color: #dc2626; margin-top: 5px; }

        textarea.ac-input { resize: vertical; min-height: 80px; line-height: 1.5; }

        /* ── Two-column grid inside form ── */
        .ac-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        /* ── Contact block ── */
        .contact-block {
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 11px;
            padding: 16px;
            margin-bottom: 12px;
            position: relative;
        }
        .contact-block:last-of-type { margin-bottom: 0; }

        /* Soft-delete overlay */
        .contact-block.is-deleted { opacity: 0.45; pointer-events: none; }
        .contact-block.is-deleted::after {
            content: 'Akan dihapus';
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; color: #dc2626;
            background: rgba(254,242,242,0.6);
            border-radius: 11px;
            pointer-events: all;
        }

        .contact-block-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px; flex-wrap: wrap; gap: 6px;
        }
        .contact-block-meta { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        .contact-block-label {
            font-size: 11px; font-weight: 600;
            color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.4px;
        }
        .badge {
            display: inline-flex; padding: 2px 9px;
            border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-existing { background: #eff6ff; color: #2563eb; }
        .badge-new      { background: #f0fdf4; color: #16a34a; }

        .contact-block-actions { display: flex; align-items: center; gap: 4px; }

        .btn-icon-text {
            background: transparent; border: none; cursor: pointer;
            color: #9ca3af; padding: 5px 8px;
            border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;
            font-size: 12px; font-weight: 600; font-family: inherit;
            transition: all .15s;
        }
        .btn-icon-text:hover       { color: #dc2626; background: #fef2f2; }
        .btn-icon-text.undo:hover  { color: #2563eb; background: #eff6ff; }

        /* ── Signature ── */
        .sig-existing {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 9px;
            margin-bottom: 8px;
        }
        .sig-existing img {
            width: 44px; height: 30px; object-fit: contain;
            border: 1px solid #e5e7eb; border-radius: 5px; background: #fff;
        }
        .sig-existing-label { font-size: 12px; color: #15803d; font-weight: 500; flex: 1; }
        .sig-existing-remove {
            background: none; border: none; cursor: pointer;
            color: #9ca3af; font-size: 11px; font-weight: 600; font-family: inherit;
            padding: 3px 7px; border-radius: 5px;
            transition: all .15s;
        }
        .sig-existing-remove:hover { color: #dc2626; background: #fef2f2; }

        .sig-upload {
            border: 1.5px dashed #e5e7eb; border-radius: 9px;
            padding: 14px 12px; text-align: center;
            cursor: pointer; transition: all .15s;
            position: relative; background: #fff;
        }
        .sig-upload:hover { border-color: #ea580c; background: #fff7ed; }
        .sig-upload input[type="file"] {
            position: absolute; inset: 0; opacity: 0;
            cursor: pointer; width: 100%; height: 100%;
        }
        .sig-upload-title { font-size: 12px; font-weight: 600; color: #6b7280; display: block; }
        .sig-upload-hint  { font-size: 11px; color: #9ca3af; }

        /* ── Add contact button ── */
        .btn-add-contact {
            width: 100%; padding: 10px 16px;
            background: #fff; border: 1.5px dashed #d1d5db;
            border-radius: 9px; font-size: 13px; font-weight: 600;
            color: #6b7280; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            font-family: inherit; transition: all .15s;
            margin-top: 12px;
        }
        .btn-add-contact:hover { border-color: #ea580c; color: #ea580c; background: #fff7ed; }

        /* ── Sidebar save card ── */
        .ac-save-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        .ac-save-header { padding: 13px 18px; border-bottom: 1px solid #f3f4f6; font-size: 13.5px; font-weight: 600; color: #1c1917; }
        .ac-save-body { padding: 18px; display: flex; flex-direction: column; gap: 8px; }

        .btn-primary {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            width: 100%; padding: 11px 20px;
            background: #ea580c; color: #fff;
            border: none; border-radius: 9px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; transition: all .15s;
        }
        .btn-primary:hover { background: #c2410c; box-shadow: 0 4px 14px rgba(234,88,12,.25); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); box-shadow: none; }

        .btn-secondary {
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 11px 20px;
            background: #f3f4f6; color: #374151;
            border: none; border-radius: 9px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; text-decoration: none;
            transition: background .15s;
        }
        .btn-secondary:hover { background: #e5e7eb; }

        .btn-danger {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            width: 100%; padding: 11px 20px;
            background: transparent; color: #dc2626;
            border: 1px solid #fecaca; border-radius: 9px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; text-decoration: none;
            transition: all .15s;
        }
        .btn-danger:hover { background: #fef2f2; }

        /* ── Meta info ── */
        .meta-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 9px 0; border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
        }
        .meta-row:last-child { border-bottom: none; padding-bottom: 0; }
        .meta-row:first-child { padding-top: 0; }
        .meta-label { font-size: 11px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }
        .meta-value { color: #374151; font-weight: 500; font-size: 13px; }

        /* ════════════════════════════════
           MOBILE — single column layout
           ════════════════════════════════ */
        @media (max-width: 768px) {
            .ac-title    { font-size: 18px; }
            .ac-subtitle { font-size: 12px; margin-bottom: 18px; }

            .ac-layout {
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            .ac-main  { width: 100%; }
            .ac-aside { width: 100%; }

            .ac-card-body  { padding: 14px; }
            .ac-card-header { padding: 11px 14px; }

            .contact-block { padding: 13px; }

            /* Save card floats to top on mobile */
            .ac-save-card { order: -1; margin-bottom: 12px; }

            /* On very small screens, contact grid goes single column */
            @media (max-width: 380px) {
                .ac-row-2 { grid-template-columns: 1fr; }
            }

            /* Larger tap targets */
            .btn-primary, .btn-secondary, .btn-danger { padding: 13px 20px; font-size: 15px; }
            .btn-add-contact { padding: 12px 16px; font-size: 14px; }

            /* Prevent iOS zoom on focus */
            .ac-input { font-size: 16px; }
        }
    </style>

    <div class="ac-title">Edit Customer</div>
    <p class="ac-subtitle">Ubah data perusahaan — <strong>{{ $company->name }}</strong></p>

    <form action="{{ route('customer.update', $company) }}" method="POST" enctype="multipart/form-data" id="customerForm">
        @csrf
        @method('PUT')

        <div class="ac-layout">

            {{-- ── Main Column ── --}}
            <div class="ac-main">

                {{-- Company Info --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="ac-card-title">Informasi Perusahaan</span>
                    </div>
                    <div class="ac-card-body">

                        <div class="ac-group">
                            <label class="ac-label">Nama Perusahaan <span class="req">*</span></label>
                            <input type="text" name="name"
                                class="ac-input @error('name') is-invalid @enderror"
                                value="{{ old('name', $company->name) }}"
                                required>
                            @error('name')
                                <div class="ac-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ac-group">
                            <label class="ac-label">Alamat</label>
                            <textarea name="address"
                                class="ac-input @error('address') is-invalid @enderror">{{ old('address', $company->address) }}</textarea>
                            @error('address')
                                <div class="ac-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ac-group">
                            <label class="ac-label">Nomor Telepon</label>
                            <input type="text" name="phone"
                                class="ac-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $company->phone) }}">
                            @error('phone')
                                <div class="ac-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>{{-- /company card --}}

                {{-- Contacts --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                            </svg>
                        </div>
                        <span class="ac-card-title">Kontak Perusahaan</span>
                    </div>
                    <div class="ac-card-body">

                        <div id="contactsWrapper">

                            {{-- Existing contacts --}}
                            @foreach($company->contacts as $i => $contact)
                                <div class="contact-block" data-contact-id="{{ $contact->id }}" id="contact-existing-{{ $contact->id }}">
                                    <input type="hidden" name="existing_contacts[{{ $i }}][id]"      value="{{ $contact->id }}">
                                    <input type="hidden" name="existing_contacts[{{ $i }}][_delete]" value="0" class="delete-flag">

                                    <div class="contact-block-header">
                                        <div class="contact-block-meta">
                                            <span class="contact-block-label">Kontak #{{ $i + 1 }}</span>
                                            <span class="badge badge-existing">Existing</span>
                                        </div>
                                        <div class="contact-block-actions">
                                            <button type="button" class="btn-icon-text btn-delete-contact" onclick="markDeleteContact(this)" aria-label="Hapus kontak">
                                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="ac-group">
                                        <label class="ac-label">Nama <span class="req">*</span></label>
                                        <input type="text"
                                            name="existing_contacts[{{ $i }}][name]"
                                            class="ac-input"
                                            value="{{ old('existing_contacts.'.$i.'.name', $contact->name) }}"
                                            required>
                                    </div>

                                    <div class="ac-row-2">
                                        <div class="ac-group">
                                            <label class="ac-label">Email</label>
                                            <input type="email"
                                                name="existing_contacts[{{ $i }}][email]"
                                                class="ac-input"
                                                value="{{ old('existing_contacts.'.$i.'.email', $contact->email) }}"
                                                placeholder="email@co.com">
                                        </div>
                                        <div class="ac-group">
                                            <label class="ac-label">Telepon</label>
                                            <input type="text"
                                                name="existing_contacts[{{ $i }}][phone]"
                                                class="ac-input"
                                                value="{{ old('existing_contacts.'.$i.'.phone', $contact->phone) }}"
                                                placeholder="08xx">
                                        </div>
                                    </div>

                                    <div class="ac-group">
                                        <label class="ac-label">Jabatan</label>
                                        <input type="text"
                                            name="existing_contacts[{{ $i }}][jabatan]"
                                            class="ac-input"
                                            value="{{ old('existing_contacts.'.$i.'.jabatan', $contact->jabatan) }}"
                                            placeholder="Misal: Direktur, Manager">
                                    </div>

                                    <div class="ac-group">
                                        <label class="ac-label">Tanda Tangan <span class="opt">(opsional)</span></label>

                                        @if($contact->signature_path)
                                            <div class="sig-existing" id="sig-wrap-{{ $contact->id }}">
                                                <img src="{{ $contact->signature_url }}" alt="Tanda tangan">
                                                <span class="sig-existing-label">Tanda tangan tersimpan</span>
                                                <button type="button" class="sig-existing-remove"
                                                    onclick="removeSig(this, 'existing_contacts[{{ $i }}][remove_signature]', 'sig-wrap-{{ $contact->id }}')">
                                                    Hapus TTD
                                                </button>
                                                <input type="hidden" name="existing_contacts[{{ $i }}][remove_signature]" value="0">
                                            </div>
                                        @endif

                                        <div class="sig-upload" onclick="this.querySelector('input[type=file]').click()">
                                            <input type="file"
                                                name="existing_contacts[{{ $i }}][signature]"
                                                accept="image/*"
                                                style="display:none;"
                                                onchange="previewSig(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:22px;height:22px;margin:0 auto 5px;color:#d1d5db;display:block;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                            </svg>
                                            <span class="sig-upload-title">{{ $contact->signature_path ? 'Ganti Tanda Tangan' : 'Upload Tanda Tangan' }}</span>
                                            <span class="sig-upload-hint">PNG / JPG, maks. 2MB</span>
                                        </div>
                                    </div>

                                </div>{{-- /contact-block existing --}}
                            @endforeach

                            {{-- New contacts will be appended here --}}
                            <div id="newContactsWrapper"></div>

                        </div>{{-- /contactsWrapper --}}

                        <button type="button" class="btn-add-contact" onclick="addContact()">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kontak Baru
                        </button>

                    </div>
                </div>{{-- /contacts card --}}

            </div>{{-- /ac-main --}}

            {{-- ── Sidebar ── --}}
            <div class="ac-aside">

                {{-- Save Actions --}}
                <div class="ac-save-card">
                    <div class="ac-save-header">Simpan Perubahan</div>
                    <div class="ac-save-body">
                        <button type="submit" class="btn-primary">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('customer.show', $company) }}" class="btn-secondary">Lihat Detail</a>
                        <a href="{{ route('customer.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </div>

                {{-- Info Data --}}
                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="ac-card-title">Info Data</span>
                    </div>
                    <div class="ac-card-body" style="padding: 14px 18px;">
                        <div class="meta-row">
                            <span class="meta-label">ID</span>
                            <span class="meta-value">#{{ $company->id }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Slug</span>
                            <span class="meta-value">{{ $company->slug }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Dibuat</span>
                            <span class="meta-value">{{ $company->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Total Kontak</span>
                            <span class="meta-value">{{ $company->contacts->count() }} kontak</span>
                        </div>
                    </div>
                </div>

                {{-- Danger Zone --}}
                {{-- Uncomment block di bawah untuk mengaktifkan tombol hapus perusahaan --}}
                {{--
                <div class="ac-card" style="border-color:#fecaca;">
                    <div class="ac-card-header" style="border-bottom-color:#fef2f2;">
                        <div class="ac-card-icon" style="background:#fef2f2;">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <span class="ac-card-title" style="color:#dc2626;">Danger Zone</span>
                    </div>
                    <div class="ac-card-body">
                        <p style="font-size:12px;color:#6b7280;margin-bottom:12px;line-height:1.5;">
                            Menghapus perusahaan akan menghapus semua kontak terkait secara permanen.
                        </p>
                        <form action="{{ route('customer.destroy', $company) }}" method="POST" id="deleteForm">
                            @csrf @method('DELETE')
                            <button type="button" class="btn-danger" onclick="confirmDelete()">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                </svg>
                                Hapus Perusahaan
                            </button>
                        </form>
                    </div>
                </div>
                --}}

            </div>{{-- /ac-aside --}}

        </div>{{-- /ac-layout --}}
    </form>

    <script>
        let newContactIndex = 0;

        function addContact() {
            const wrapper  = document.getElementById('newContactsWrapper');
            const idx      = newContactIndex++;
            const existing = document.querySelectorAll('[data-contact-id]').length;
            const displayNum = existing + idx + 1;

            const row = document.createElement('div');
            row.className = 'contact-block';
            row.innerHTML = `
                <div class="contact-block-header">
                    <div class="contact-block-meta">
                        <span class="contact-block-label">Kontak #${displayNum}</span>
                        <span class="badge badge-new">Baru</span>
                    </div>
                    <div class="contact-block-actions">
                        <button type="button" class="btn-icon-text" onclick="this.closest('.contact-block').remove()" aria-label="Hapus kontak baru">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <div class="ac-group">
                    <label class="ac-label">Nama <span class="req">*</span></label>
                    <input type="text" name="new_contacts[${idx}][name]" class="ac-input" placeholder="Nama lengkap" required>
                </div>

                <div class="ac-row-2">
                    <div class="ac-group">
                        <label class="ac-label">Email</label>
                        <input type="email" name="new_contacts[${idx}][email]" class="ac-input" placeholder="email@co.com">
                    </div>
                    <div class="ac-group">
                        <label class="ac-label">Telepon</label>
                        <input type="text" name="new_contacts[${idx}][phone]" class="ac-input" placeholder="08xx">
                    </div>
                </div>

                <div class="ac-group">
                    <label class="ac-label">Jabatan</label>
                    <input type="text" name="new_contacts[${idx}][jabatan]" class="ac-input" placeholder="Misal: Direktur, Manager">
                </div>

                <div class="ac-group">
                    <label class="ac-label">Tanda Tangan <span class="opt">(opsional)</span></label>
                    <div class="sig-upload" onclick="this.querySelector('input[type=file]').click()">
                        <input type="file" name="new_contacts[${idx}][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:22px;height:22px;margin:0 auto 5px;color:#d1d5db;display:block;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        <span class="sig-upload-title">Upload Tanda Tangan</span>
                        <span class="sig-upload-hint">PNG / JPG, maks. 2MB</span>
                    </div>
                </div>
            `;
            wrapper.appendChild(row);
        }

        function markDeleteContact(btn) {
            const row  = btn.closest('.contact-block');
            const flag = row.querySelector('.delete-flag');
            if (flag) flag.value = '1';
            row.classList.add('is-deleted');
            btn.style.display = 'none';

            const undoBtn = document.createElement('button');
            undoBtn.type      = 'button';
            undoBtn.className = 'btn-icon-text undo';
            undoBtn.style.cssText = 'pointer-events:all; color:#2563eb;';
            undoBtn.innerHTML = `
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6M3 10l6-6"/>
                </svg>
                Urungkan
            `;
            undoBtn.onclick = () => {
                if (flag) flag.value = '0';
                row.classList.remove('is-deleted');
                undoBtn.remove();
                btn.style.display = '';
            };
            row.querySelector('.contact-block-actions').appendChild(undoBtn);
        }

        function removeSig(btn, fieldName, wrapId) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) field.value = '1';
            const wrap = document.getElementById(wrapId);
            if (wrap) wrap.remove();
        }

        function previewSig(input) {
            if (input.files && input.files[0]) {
                const wrap  = input.closest('.sig-upload');
                const title = wrap.querySelector('.sig-upload-title');
                const hint  = wrap.querySelector('.sig-upload-hint');
                if (title) title.innerHTML = `<span style="color:#15803d;">✓ ${input.files[0].name}</span>`;
                if (hint)  hint.textContent = 'Klik untuk ganti';
            }
        }

        function confirmDelete() {
            if (confirm('Hapus perusahaan ini beserta semua kontaknya? Tindakan ini tidak dapat diurungkan.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>

</x-app-sidebar>