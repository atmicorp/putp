<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.index') }}" style="color:#6b7280;text-decoration:none;">Daftar Customer</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Tambah Baru</span>
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
        }
        .contact-block:last-of-type { margin-bottom: 0; }

        .contact-block-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }
        .contact-block-label {
            font-size: 11px; font-weight: 600;
            color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.4px;
        }
        .btn-remove-contact {
            background: transparent; border: none; cursor: pointer;
            color: #9ca3af; padding: 4px 6px;
            border-radius: 6px; display: flex; align-items: center;
            transition: all .15s;
        }
        .btn-remove-contact:hover { color: #dc2626; background: #fef2f2; }

        /* ── Signature upload ── */
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
        .sig-upload-icon { font-size: 22px; color: #d1d5db; display: block; margin-bottom: 5px; }
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

        /* ── Guide items ── */
        .guide-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .guide-item:last-child { border-bottom: none; padding-bottom: 0; }
        .guide-item:first-child { padding-top: 0; }
        .guide-item-icon { width: 30px; height: 30px; background: #fff7ed; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .guide-item-title { font-size: 10px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; }
        .guide-item-text  { font-size: 12px; color: #6b7280; margin-top: 2px; line-height: 1.45; }

        /* ════════════════════════════════
           MOBILE — single column layout
           ════════════════════════════════ */
        @media (max-width: 768px) {
            .ac-title    { font-size: 18px; }
            .ac-subtitle { font-size: 12px; margin-bottom: 18px; }

            /* Stack into single column */
            .ac-layout {
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            /* Main column full width, no extra margin */
            .ac-main  { width: 100%; }
            .ac-aside { width: 100%; }

            /* Tighten card padding on mobile */
            .ac-card-body  { padding: 14px; }
            .ac-card-header { padding: 11px 14px; }

            /* Contact block tighter */
            .contact-block { padding: 13px; }

            /* Email + Phone still side-by-side on mobile (short fields) */
            /* Jabatan full width, below */
            .ac-row-2 { grid-template-columns: 1fr 1fr; gap: 10px; }

            /* On very small screens, fall to single column */
            @media (max-width: 380px) {
                .ac-row-2 { grid-template-columns: 1fr; }
            }

            /* Save card: on mobile, show action buttons at top before guide */
            .ac-save-card { order: -1; margin-bottom: 12px; }

            /* Compact guide on mobile */
            .guide-item { padding: 8px 0; }
            .guide-item-text { font-size: 11.5px; }

            /* Larger tap targets */
            .btn-primary, .btn-secondary { padding: 13px 20px; font-size: 15px; }
            .btn-add-contact { padding: 12px 16px; font-size: 14px; }
            .ac-input { font-size: 16px; } /* prevents iOS zoom on focus */
        }
    </style>

    <div class="ac-title">Tambah Customer</div>
    <p class="ac-subtitle">Tambah perusahaan beserta kontak terkait</p>

    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data" id="customerForm">
        @csrf

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
                                value="{{ old('name') }}"
                                placeholder="PT. Contoh Indonesia"
                                required>
                            @error('name')
                                <div class="ac-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ac-group">
                            <label class="ac-label">Alamat</label>
                            <textarea name="address"
                                class="ac-input @error('address') is-invalid @enderror"
                                placeholder="Jl. Contoh No. 1, Kota, Provinsi">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="ac-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ac-group">
                            <label class="ac-label">Nomor Telepon</label>
                            <input type="text" name="phone"
                                class="ac-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                placeholder="021-xxxxxxxx">
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

                            {{-- Default contact row --}}
                            <div class="contact-block" data-index="0">
                                <div class="contact-block-header">
                                    <span class="contact-block-label">Kontak #1</span>
                                    <button type="button" class="btn-remove-contact" onclick="removeContact(this)" style="display:none;" aria-label="Hapus kontak">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="ac-group">
                                    <label class="ac-label">Nama <span class="req">*</span></label>
                                    <input type="text" name="contacts[0][name]" class="ac-input" placeholder="Nama lengkap" required>
                                </div>

                                <div class="ac-row-2">
                                    <div class="ac-group">
                                        <label class="ac-label">Email</label>
                                        <input type="email" name="contacts[0][email]" class="ac-input" placeholder="email@co.com">
                                    </div>
                                    <div class="ac-group">
                                        <label class="ac-label">Telepon</label>
                                        <input type="text" name="contacts[0][phone]" class="ac-input" placeholder="08xx">
                                    </div>
                                </div>

                                <div class="ac-group">
                                    <label class="ac-label">Jabatan</label>
                                    <input type="text" name="contacts[0][jabatan]" class="ac-input" placeholder="Misal: Direktur, Manager">
                                </div>

                                <div class="ac-group">
                                    <label class="ac-label">Tanda Tangan <span class="opt">(opsional)</span></label>
                                    <div class="sig-upload">
                                        <input type="file" name="contacts[0][signature]" accept="image/*" onchange="previewSig(this)">
                                        <svg class="sig-upload-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:24px;height:24px;margin:0 auto 5px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                        </svg>
                                        <span class="sig-upload-title">Upload Tanda Tangan</span>
                                        <span class="sig-upload-hint">PNG / JPG, maks. 2MB</span>
                                    </div>
                                </div>
                            </div>{{-- /contact-block --}}

                        </div>{{-- /contactsWrapper --}}

                        <button type="button" class="btn-add-contact" onclick="addContact()">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Kontak
                        </button>

                    </div>
                </div>{{-- /contacts card --}}

            </div>{{-- /ac-main --}}

            {{-- ── Sidebar ── --}}
            <div class="ac-aside">

                <div class="ac-save-card">
                    <div class="ac-save-header">Simpan Data</div>
                    <div class="ac-save-body">
                        <button type="submit" class="btn-primary">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Customer
                        </button>
                        <a href="{{ route('customer.index') }}" class="btn-secondary">Batal</a>
                    </div>
                </div>

                <div class="ac-card">
                    <div class="ac-card-header">
                        <div class="ac-card-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="ac-card-title">Panduan</span>
                    </div>
                    <div class="ac-card-body">

                        <div class="guide-item">
                            <div class="guide-item-icon">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                                </svg>
                            </div>
                            <div>
                                <div class="guide-item-title">Perusahaan</div>
                                <div class="guide-item-text">Nama perusahaan otomatis di-generate sebagai slug unik.</div>
                            </div>
                        </div>

                        <div class="guide-item">
                            <div class="guide-item-icon">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="guide-item-title">Kontak</div>
                                <div class="guide-item-text">Bisa tambah lebih dari satu kontak untuk satu perusahaan.</div>
                            </div>
                        </div>

                        <div class="guide-item">
                            <div class="guide-item-icon">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486"/>
                                </svg>
                            </div>
                            <div>
                                <div class="guide-item-title">Tanda Tangan</div>
                                <div class="guide-item-text">Upload TTD opsional untuk keperluan dokumen resmi.</div>
                            </div>
                        </div>

                    </div>
                </div>{{-- /guide card --}}

            </div>{{-- /ac-aside --}}

        </div>{{-- /ac-layout --}}
    </form>

    <script>
        let contactIndex = 1;

        function addContact() {
            const wrapper = document.getElementById('contactsWrapper');
            const idx = contactIndex++;

            const row = document.createElement('div');
            row.className = 'contact-block';
            row.dataset.index = idx;
            row.innerHTML = `
                <div class="contact-block-header">
                    <span class="contact-block-label">Kontak #${idx + 1}</span>
                    <button type="button" class="btn-remove-contact" onclick="removeContact(this)" aria-label="Hapus kontak">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="ac-group">
                    <label class="ac-label">Nama <span class="req">*</span></label>
                    <input type="text" name="contacts[${idx}][name]" class="ac-input" placeholder="Nama lengkap" required>
                </div>

                <div class="ac-row-2">
                    <div class="ac-group">
                        <label class="ac-label">Email</label>
                        <input type="email" name="contacts[${idx}][email]" class="ac-input" placeholder="email@co.com">
                    </div>
                    <div class="ac-group">
                        <label class="ac-label">Telepon</label>
                        <input type="text" name="contacts[${idx}][phone]" class="ac-input" placeholder="08xx">
                    </div>
                </div>

                <div class="ac-group">
                    <label class="ac-label">Jabatan</label>
                    <input type="text" name="contacts[${idx}][jabatan]" class="ac-input" placeholder="Misal: Direktur, Manager">
                </div>

                <div class="ac-group">
                    <label class="ac-label">Tanda Tangan <span class="opt">(opsional)</span></label>
                    <div class="sig-upload" onclick="this.querySelector('input[type=file]').click()">
                        <input type="file" name="contacts[${idx}][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:24px;height:24px;margin:0 auto 5px;color:#d1d5db;display:block;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        <span class="sig-upload-title">Upload Tanda Tangan</span>
                        <span class="sig-upload-hint">PNG / JPG, maks. 2MB</span>
                    </div>
                </div>
            `;

            wrapper.appendChild(row);
            updateRemoveButtons();
        }

        function removeContact(btn) {
            btn.closest('.contact-block').remove();
            updateRemoveButtons();
            renumberContacts();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.contact-block');
            rows.forEach(row => {
                const btn = row.querySelector('.btn-remove-contact');
                if (btn) btn.style.display = rows.length > 1 ? 'flex' : 'none';
            });
        }

        function renumberContacts() {
            document.querySelectorAll('.contact-block').forEach((row, i) => {
                const label = row.querySelector('.contact-block-label');
                if (label) label.textContent = `Kontak #${i + 1}`;
            });
        }

        function previewSig(input) {
            if (input.files && input.files[0]) {
                const wrap = input.closest('.sig-upload');
                const title = wrap.querySelector('.sig-upload-title');
                const hint  = wrap.querySelector('.sig-upload-hint');
                if (title) title.innerHTML = `<span style="color:#15803d;">✓ ${input.files[0].name}</span>`;
                if (hint)  hint.textContent = 'Klik untuk ganti';
            }
        }
    </script>

</x-app-sidebar>