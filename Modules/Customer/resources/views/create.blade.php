<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.index') }}" style="color:#6b7280;text-decoration:none;">Customer List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Add Customer</span>
    </x-slot>

    <style>
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .form-layout { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }

        .form-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;
        }
        .form-card-header {
            padding: 16px 24px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; gap: 10px;
        }
        .form-card-title { font-size: 14px; font-weight: 600; color: #1c1917; }
        .form-card-body  { padding: 24px; }

        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label {
            display: block; font-size: 12px; font-weight: 600;
            color: #374151; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.4px;
        }
        .form-label .req { color: #ea580c; margin-left: 2px; }

        .form-control {
            width: 100%; padding: 9px 14px; border: 1px solid #e5e7eb;
            border-radius: 8px; font-size: 13.5px; font-family: 'Sora', sans-serif;
            color: #1c1917; background: #fff; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s; box-sizing: border-box;
        }
        .form-control:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.1); }
        .form-control.is-invalid { border-color: #dc2626; }
        .invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 5px; }

        textarea.form-control { resize: vertical; min-height: 80px; }

        /* Contact rows */
        .contacts-section { margin-top: 0; }
        .contact-row {
            background: #fafafa; border: 1px solid #e5e7eb; border-radius: 10px;
            padding: 16px; margin-bottom: 12px; position: relative;
        }
        .contact-row-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;
        }
        .contact-row-title { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; }
        .btn-remove-contact {
            background: transparent; border: none; cursor: pointer; color: #9ca3af;
            padding: 4px; border-radius: 4px; transition: all 0.15s; display: flex; align-items: center;
        }
        .btn-remove-contact:hover { color: #dc2626; background: #fef2f2; }

        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .contact-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }

        .btn-add-contact {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #f3f4f6; color: #374151;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: 1px dashed #d1d5db; width: 100%;
            justify-content: center; transition: all 0.15s; font-family: 'Sora', sans-serif;
            margin-top: 4px;
        }
        .btn-add-contact:hover { background: #fff7ed; border-color: #ea580c; color: #ea580c; }

        /* Signature upload */
        .sig-upload {
            border: 1.5px dashed #e5e7eb; border-radius: 8px; padding: 12px;
            text-align: center; cursor: pointer; transition: all 0.15s; position: relative; background: #fafafa;
        }
        .sig-upload:hover { border-color: #ea580c; background: #fff7ed; }
        .sig-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .sig-upload-text { font-size: 12px; color: #9ca3af; }
        .sig-upload-text strong { display: block; color: #6b7280; font-size: 11px; margin-bottom: 2px; }

        /* Sidebar card */
        .side-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
        .side-card-header { padding: 14px 20px; border-bottom: 1px solid #f3f4f6; font-size: 13px; font-weight: 600; color: #374151; }
        .side-card-body { padding: 20px; }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 22px; background: #ea580c; color: #fff;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.15s; font-family: 'Sora', sans-serif; width: 100%; justify-content: center;
        }
        .btn-primary:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 22px; background: #f3f4f6; color: #374151;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            border: none; cursor: pointer; transition: all 0.15s; font-family: 'Sora', sans-serif;
            text-decoration: none; width: 100%; justify-content: center; box-sizing: border-box;
        }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-gap { display: flex; flex-direction: column; gap: 8px; }

        .info-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 14px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-icon { width: 32px; height: 32px; border-radius: 8px; background: #fff7ed; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .info-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.4px; }
        .info-text  { font-size: 13px; color: #374151; margin-top: 1px; }
    </style>

    <div class="dash-title">Add Customer</div>
    <p class="dash-subtitle">Tambah perusahaan beserta kontak terkait</p>

    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data" id="customerForm">
        @csrf

        <div class="form-layout">
            {{-- Main column --}}
            <div>
                {{-- Company Info --}}
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-card-header">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="form-card-title">Informasi Perusahaan</span>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label">Nama Perusahaan <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="PT. Contoh Indonesia" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Jl. Contoh No. 1, Kota, Provinsi">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="021-xxxxxxxx">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Contacts --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        <span class="form-card-title">Kontak Perusahaan</span>
                    </div>
                    <div class="form-card-body">
                        <div class="contacts-section" id="contactsWrapper">
                            {{-- Default 1 contact row --}}
                            <div class="contact-row" data-index="0">
                                <div class="contact-row-header">
                                    <span class="contact-row-title">Kontak #1</span>
                                    <button type="button" class="btn-remove-contact" onclick="removeContact(this)" style="display:none;">
                                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="contact-grid" style="margin-bottom:12px;">
                                    <div class="form-group" style="margin:0;">
                                        <label class="form-label">Nama <span class="req">*</span></label>
                                        <input type="text" name="contacts[0][name]" class="form-control" placeholder="Nama lengkap" required>
                                    </div>
                                </div>
                                <div class="contact-grid" style="margin-bottom:12px;">
                                    <div class="form-group" style="margin:0;">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="contacts[0][email]" class="form-control" placeholder="email@perusahaan.com">
                                    </div>
                                    <div class="form-group" style="margin:0;">
                                        <label class="form-label">Telepon</label>
                                        <input type="text" name="contacts[0][phone]" class="form-control" placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>
                                <div class="form-group" style="margin:0;">
                                    <label class="form-label">Tanda Tangan (opsional)</label>
                                    <div class="sig-upload" onclick="this.querySelector('input').click()">
                                        <input type="file" name="contacts[0][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                                        <div class="sig-upload-text">
                                            <strong>Upload Tanda Tangan</strong>
                                            PNG / JPG, maks. 2MB
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn-add-contact" onclick="addContact()">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kontak
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="side-card">
                    <div class="side-card-header">Simpan Data</div>
                    <div class="side-card-body">
                        <div class="btn-gap">
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Simpan Customer
                            </button>
                            <a href="{{ route('customer.index') }}" class="btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>

                <div class="side-card">
                    <div class="side-card-header">Panduan</div>
                    <div class="side-card-body">
                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                            </div>
                            <div>
                                <div class="info-label">Perusahaan</div>
                                <div class="info-text">Isi nama perusahaan yang akan otomatis di-generate sebagai slug.</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <div class="info-label">Kontak</div>
                                <div class="info-text">Bisa menambah lebih dari satu kontak untuk satu perusahaan.</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486"/></svg>
                            </div>
                            <div>
                                <div class="info-label">Tanda Tangan</div>
                                <div class="info-text">Upload TTD opsional untuk keperluan dokumen resmi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        let contactIndex = 1;

        function addContact() {
            const wrapper = document.getElementById('contactsWrapper');
            const idx = contactIndex++;

            const row = document.createElement('div');
            row.className = 'contact-row';
            row.dataset.index = idx;
            row.innerHTML = `
                <div class="contact-row-header">
                    <span class="contact-row-title">Kontak #${idx + 1}</span>
                    <button type="button" class="btn-remove-contact" onclick="removeContact(this)">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="contact-grid" style="margin-bottom:12px;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Nama <span class="req">*</span></label>
                        <input type="text" name="contacts[${idx}][name]" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="contacts[${idx}][position]" class="form-control" placeholder="Direktur, Manager, dll">
                    </div>
                </div>
                <div class="contact-grid" style="margin-bottom:12px;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Email</label>
                        <input type="email" name="contacts[${idx}][email]" class="form-control" placeholder="email@perusahaan.com">
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="contacts[${idx}][phone]" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tanda Tangan (opsional)</label>
                    <div class="sig-upload" onclick="this.querySelector('input').click()">
                        <input type="file" name="contacts[${idx}][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                        <div class="sig-upload-text">
                            <strong>Upload Tanda Tangan</strong>
                            PNG / JPG, maks. 2MB
                        </div>
                    </div>
                </div>
            `;
            wrapper.appendChild(row);
            updateRemoveButtons();
        }

        function removeContact(btn) {
            btn.closest('.contact-row').remove();
            updateRemoveButtons();
            renumberContacts();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.contact-row');
            rows.forEach(row => {
                const btn = row.querySelector('.btn-remove-contact');
                if (btn) btn.style.display = rows.length > 1 ? 'flex' : 'none';
            });
        }

        function renumberContacts() {
            document.querySelectorAll('.contact-row').forEach((row, i) => {
                const title = row.querySelector('.contact-row-title');
                if (title) title.textContent = `Kontak #${i + 1}`;
            });
        }

        function previewSig(input) {
            if (input.files && input.files[0]) {
                const wrap = input.closest('.sig-upload');
                const text = wrap.querySelector('.sig-upload-text');
                text.innerHTML = `<strong style="color:#15803d;">✓ ${input.files[0].name}</strong>Klik untuk ganti`;
            }
        }
    </script>
</x-app-sidebar>