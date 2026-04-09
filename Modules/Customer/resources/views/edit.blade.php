<x-app-sidebar>
    <x-slot name="title">Customer</x-slot>

    <x-slot name="breadcrumb">
        <span>Customer</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('customer.index') }}" style="color:#6b7280;text-decoration:none;">Customer List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Edit Customer</span>
    </x-slot>

    <style>
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .form-layout { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }

        .form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
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

        .contact-row {
            background: #fafafa; border: 1px solid #e5e7eb; border-radius: 10px;
            padding: 16px; margin-bottom: 12px; position: relative;
        }
        .contact-row.is-deleted { opacity: 0.45; pointer-events: none; position: relative; }
        .contact-row.is-deleted::after {
            content: 'Akan dihapus'; position: absolute; inset: 0; display: flex;
            align-items: center; justify-content: center; font-size: 13px; font-weight: 600;
            color: #dc2626; background: rgba(254,242,242,0.6); border-radius: 10px;
            pointer-events: all;
        }
        .contact-row-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;
        }
        .contact-row-title { font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.4px; }
        .contact-row-badges { display: flex; align-items: center; gap: 6px; }
        .badge-existing { display: inline-flex; padding: 2px 8px; background: #eff6ff; border-radius: 20px; font-size: 11px; font-weight: 600; color: #2563eb; }
        .badge-new      { display: inline-flex; padding: 2px 8px; background: #f0fdf4; border-radius: 20px; font-size: 11px; font-weight: 600; color: #16a34a; }

        .btn-remove-contact {
            background: transparent; border: none; cursor: pointer; color: #9ca3af;
            padding: 4px 8px; border-radius: 4px; transition: all 0.15s; display: inline-flex; align-items: center; gap: 4px;
            font-size: 12px; font-family: 'Sora', sans-serif;
        }
        .btn-remove-contact:hover { color: #dc2626; background: #fef2f2; }

        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .sig-current {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px;
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; margin-bottom: 8px;
        }
        .sig-current img { width: 40px; height: 28px; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 4px; background: #fff; }
        .sig-current-text { font-size: 12px; color: #15803d; font-weight: 500; flex: 1; }
        .sig-current-remove { background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 11px; font-family: 'Sora',sans-serif; font-weight: 600; padding: 2px 6px; border-radius: 4px; }
        .sig-current-remove:hover { color: #dc2626; background: #fef2f2; }

        .sig-upload {
            border: 1.5px dashed #e5e7eb; border-radius: 8px; padding: 12px;
            text-align: center; cursor: pointer; transition: all 0.15s; position: relative; background: #fafafa;
        }
        .sig-upload:hover { border-color: #ea580c; background: #fff7ed; }
        .sig-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .sig-upload-text { font-size: 12px; color: #9ca3af; }
        .sig-upload-text strong { display: block; color: #6b7280; font-size: 11px; margin-bottom: 2px; }

        .btn-add-contact {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; background: #f3f4f6; color: #374151;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: 1px dashed #d1d5db; width: 100%;
            justify-content: center; transition: all 0.15s; font-family: 'Sora', sans-serif;
            margin-top: 4px;
        }
        .btn-add-contact:hover { background: #fff7ed; border-color: #ea580c; color: #ea580c; }

        .side-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
        .side-card-header { padding: 14px 20px; border-bottom: 1px solid #f3f4f6; font-size: 13px; font-weight: 600; color: #374151; }
        .side-card-body { padding: 20px; }

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
        .btn-danger-outline {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 22px; background: transparent; color: #dc2626;
            border-radius: 8px; font-size: 13px; font-weight: 600;
            border: 1px solid #fecaca; cursor: pointer; transition: all 0.15s; font-family: 'Sora', sans-serif;
            text-decoration: none; width: 100%; justify-content: center; box-sizing: border-box;
        }
        .btn-danger-outline:hover { background: #fef2f2; }
        .btn-gap { display: flex; flex-direction: column; gap: 8px; }

        .meta-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13px; }
        .meta-item:last-child { margin-bottom: 0; }
        .meta-label { color: #9ca3af; font-size: 12px; }
        .meta-value { color: #374151; font-weight: 500; }
    </style>

    <div class="dash-title">Edit Customer</div>
    <p class="dash-subtitle">Ubah data perusahaan — {{ $company->name }}</p>

    <form action="{{ route('customer.update', $company) }}" method="POST" enctype="multipart/form-data" id="customerForm">
        @csrf @method('PUT')

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
                                value="{{ old('name', $company->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $company->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $company->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Existing Contacts --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                        <span class="form-card-title">Kontak Perusahaan</span>
                    </div>
                    <div class="form-card-body">
                        <div id="contactsWrapper">
                            {{-- Existing contacts --}}
                            @foreach($company->contacts as $i => $contact)
                                <div class="contact-row" data-contact-id="{{ $contact->id }}" id="contact-existing-{{ $contact->id }}">
                                    <input type="hidden" name="existing_contacts[{{ $i }}][id]" value="{{ $contact->id }}">
                                    <input type="hidden" name="existing_contacts[{{ $i }}][_delete]" value="0" class="delete-flag">
                                    <div class="contact-row-header">
                                        <div class="contact-row-badges">
                                            <span class="contact-row-title">Kontak #{{ $i + 1 }}</span>
                                            <span class="badge-existing">Existing</span>
                                        </div>
                                        <button type="button" class="btn-remove-contact" onclick="markDeleteContact(this)">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                            Hapus
                                        </button>
                                    </div>
                                    <div class="contact-grid" style="margin-bottom:12px;">
                                        <div class="form-group" style="margin:0;">
                                            <label class="form-label">Nama <span class="req">*</span></label>
                                            <input type="text" name="existing_contacts[{{ $i }}][name]" class="form-control" value="{{ old('existing_contacts.'.$i.'.name', $contact->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="contact-grid" style="margin-bottom:12px;">
                                        <div class="form-group" style="margin:0;">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="existing_contacts[{{ $i }}][email]" class="form-control" value="{{ old('existing_contacts.'.$i.'.email', $contact->email) }}">
                                        </div>
                                        <div class="form-group" style="margin:0;">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" name="existing_contacts[{{ $i }}][phone]" class="form-control" value="{{ old('existing_contacts.'.$i.'.phone', $contact->phone) }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin:0;">
                                        <label class="form-label">Tanda Tangan</label>
                                        @if($contact->signature_path)
                                            <div class="sig-current">
                                                <img src="{{ $contact->signature_url }}" alt="TTD">
                                                <span class="sig-current-text">Tanda tangan tersimpan</span>
                                                <button type="button" class="sig-current-remove" onclick="removeSig(this, 'existing_contacts[{{ $i }}][remove_signature]')">Hapus TTD</button>
                                                <input type="hidden" name="existing_contacts[{{ $i }}][remove_signature]" value="0">
                                            </div>
                                        @endif
                                        <div class="sig-upload" onclick="this.querySelector('input').click()">
                                            <input type="file" name="existing_contacts[{{ $i }}][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                                            <div class="sig-upload-text">
                                                <strong>{{ $contact->signature_path ? 'Ganti Tanda Tangan' : 'Upload Tanda Tangan' }}</strong>
                                                PNG / JPG, maks. 2MB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- New contact rows will be appended here --}}
                            <div id="newContactsWrapper"></div>
                        </div>

                        <button type="button" class="btn-add-contact" onclick="addContact()">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kontak Baru
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="side-card">
                    <div class="side-card-header">Simpan Perubahan</div>
                    <div class="side-card-body">
                        <div class="btn-gap">
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('customer.show', $company) }}" class="btn-secondary">Lihat Detail</a>
                            <a href="{{ route('customer.index') }}" class="btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>

                <div class="side-card">
                    <div class="side-card-header">Info Data</div>
                    <div class="side-card-body">
                        <div class="meta-item">
                            <span class="meta-label">ID</span>
                            <span class="meta-value">#{{ $company->id }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Slug</span>
                            <span class="meta-value">{{ $company->slug }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Dibuat</span>
                            <span class="meta-value">{{ $company->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Total Kontak</span>
                            <span class="meta-value">{{ $company->contacts->count() }}</span>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </form>
    {{-- <div class="side-card">
                    <div class="side-card-header">Danger Zone</div>
                    <div class="side-card-body">
                        <form action="{{ route('customer.destroy', $company) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger-outline">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                                Hapus Perusahaan
                            </button>
                        </form>
                    </div>
                </div> --}}

    <script>
        let newContactIndex = 0;

        function addContact() {
            const wrapper = document.getElementById('newContactsWrapper');
            const idx = newContactIndex++;
            const existingCount = document.querySelectorAll('[data-contact-id]').length;
            const displayNum = existingCount + idx + 1;

            const row = document.createElement('div');
            row.className = 'contact-row';
            row.innerHTML = `
                <div class="contact-row-header">
                    <div class="contact-row-badges">
                        <span class="contact-row-title">Kontak #${displayNum}</span>
                        <span class="badge-new">Baru</span>
                    </div>
                    <button type="button" class="btn-remove-contact" onclick="this.closest('.contact-row').remove()">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Hapus
                    </button>
                </div>
                <div class="contact-grid" style="margin-bottom:12px;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Nama <span class="req">*</span></label>
                        <input type="text" name="new_contacts[${idx}][name]" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                </div>
                <div class="contact-grid" style="margin-bottom:12px;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Email</label>
                        <input type="email" name="new_contacts[${idx}][email]" class="form-control" placeholder="email@perusahaan.com">
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="new_contacts[${idx}][phone]" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tanda Tangan (opsional)</label>
                    <div class="sig-upload" onclick="this.querySelector('input').click()">
                        <input type="file" name="new_contacts[${idx}][signature]" accept="image/*" style="display:none;" onchange="previewSig(this)">
                        <div class="sig-upload-text">
                            <strong>Upload Tanda Tangan</strong>
                            PNG / JPG, maks. 2MB
                        </div>
                    </div>
                </div>
            `;
            wrapper.appendChild(row);
        }

        function markDeleteContact(btn) {
            const row = btn.closest('.contact-row');
            const flag = row.querySelector('.delete-flag');
            if (flag) flag.value = '1';
            row.classList.add('is-deleted');
            btn.style.display = 'none';

            // Add undo button
            const undo = document.createElement('button');
            undo.type = 'button';
            undo.className = 'btn-remove-contact';
            undo.style.cssText = 'pointer-events:all;color:#2563eb;';
            undo.innerHTML = '<svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6M3 10l6-6"/></svg> Urungkan';
            undo.onclick = () => {
                if (flag) flag.value = '0';
                row.classList.remove('is-deleted');
                undo.remove();
                btn.style.display = '';
            };
            row.querySelector('.contact-row-header').appendChild(undo);
        }

        function removeSig(btn, fieldName) {
            const wrap = btn.closest('.sig-current');
            document.querySelector(`[name="${fieldName}"]`).value = '1';
            wrap.remove();
        }

        function previewSig(input) {
            if (input.files && input.files[0]) {
                const wrap = input.closest('.sig-upload');
                const text = wrap.querySelector('.sig-upload-text');
                text.innerHTML = `<strong style="color:#15803d;">✓ ${input.files[0].name}</strong>Klik untuk ganti`;
            }
        }

        document.querySelector('.delete-form')?.addEventListener('submit', e => {
            e.preventDefault();
            if (confirm('Hapus perusahaan ini beserta semua kontaknya?')) e.target.submit();
        });
    </script>
</x-app-sidebar>