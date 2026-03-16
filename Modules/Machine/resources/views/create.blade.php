<x-app-sidebar>
    <x-slot name="title">Add Machine</x-slot>

    <x-slot name="breadcrumb">
        <span>Machine</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('machine.index') }}" style="color: #6b7280; text-decoration: none;">Machine List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Add Machine</span>
    </x-slot>

    <style>
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .form-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            overflow: hidden; max-width: 680px;
        }

        .form-card-header {
            display: flex; align-items: center; gap: 10px;
            padding: 16px 24px; border-bottom: 1px solid #f3f4f6;
            background: #fafafa;
        }
        .form-card-header-icon {
            width: 32px; height: 32px; background: #fff7ed; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .form-card-title { font-size: 14px; font-weight: 700; color: #1c1917; }
        .form-card-sub   { font-size: 12px; color: #9ca3af; margin-top: 1px; }

        .form-card-body { padding: 24px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 560px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }

        .form-label {
            display: block; font-size: 12.5px; font-weight: 600;
            color: #374151; margin-bottom: 6px; letter-spacing: 0.1px;
        }
        .form-label .req { color: #ea580c; margin-left: 2px; }

        .form-control {
            width: 100%; padding: 9px 12px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 8px;
            font-size: 13.5px; font-family: 'Sora', sans-serif; color: #1c1917;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
        }
        .form-control:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.08); }
        .form-control.is-invalid { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }
        .form-control::placeholder { color: #c4c9d4; }

        textarea.form-control { resize: vertical; min-height: 88px; }

        .invalid-msg { font-size: 12px; color: #dc2626; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        .form-hint { font-size: 12px; color: #9ca3af; margin-top: 5px; }

        /* Toggle */
        .toggle-group { display: flex; align-items: center; gap: 10px; }
        .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; cursor: pointer; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-track {
            position: absolute; inset: 0;
            background: #e5e7eb; border-radius: 11px;
            transition: background 0.2s;
        }
        .toggle-thumb {
            position: absolute; width: 16px; height: 16px;
            top: 3px; left: 3px; background: #fff; border-radius: 50%;
            transition: transform 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        .toggle-switch input:checked ~ .toggle-track { background: #ea580c; }
        .toggle-switch input:checked ~ .toggle-thumb { transform: translateX(18px); }
        .toggle-label { font-size: 13px; color: #374151; font-weight: 500; cursor: pointer; user-select: none; }
        .toggle-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        .divider { height: 1px; background: #f3f4f6; margin: 4px 0 20px; }

        .form-card-footer {
            display: flex; align-items: center; justify-content: flex-end; gap: 8px;
            padding: 16px 24px; border-top: 1px solid #f3f4f6; background: #fafafa;
        }

        .btn-cancel {
            padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600;
            background: #fff; border: 1px solid #e5e7eb; color: #6b7280;
            cursor: pointer; font-family: 'Sora', sans-serif; text-decoration: none;
            transition: all 0.15s;
        }
        .btn-cancel:hover { border-color: #d1d5db; background: #f9fafb; color: #374151; }

        .btn-submit {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
            background: #ea580c; border: none; color: #fff;
            cursor: pointer; font-family: 'Sora', sans-serif;
            transition: all 0.15s;
        }
        .btn-submit:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }
    </style>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            Terdapat {{ $errors->count() }} kesalahan pada form.
        </div>
    @endif

    <form action="{{ route('machine.store') }}" method="POST">
        @csrf
        <div class="form-card">

            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="form-card-title">Informasi Mesin</div>
                    <div class="form-card-sub">Isi data mesin baru di bawah ini</div>
                </div>
            </div>

            <div class="form-card-body">

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Mesin <span class="req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="cth. CNC Lathe Machine" autofocus>
                        @error('name')
                            <div class="invalid-msg">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="code">Kode Mesin <span class="req">*</span></label>
                        <input type="text" id="code" name="code" value="{{ old('code') }}"
                            class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                            placeholder="cth. MCH-001">
                        @error('code')
                            <div class="invalid-msg">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsi singkat tentang mesin ini (opsional)...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-msg">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="divider"></div>

                <div class="form-group">
                    <label class="form-label">Status Mesin</label>
                    <div class="toggle-group">
                        <label class="toggle-switch" for="is_active">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                        <div>
                            <div class="toggle-label" id="toggleLabel">Active</div>
                            <div class="toggle-sub">Mesin nonaktif tidak bisa diassign ke operator</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-card-footer">
                <a href="{{ route('machine.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Simpan Mesin
                </button>
            </div>

        </div>
    </form>

    <script>
        const cb    = document.getElementById('is_active');
        const label = document.getElementById('toggleLabel');
        const thumb = document.querySelector('.toggle-thumb');
        function syncToggle() {
            label.textContent = cb.checked ? 'Active' : 'Inactive';
            label.style.color = cb.checked ? '#15803d' : '#6b7280';
        }
        cb.addEventListener('change', syncToggle);
        syncToggle();
    </script>
</x-app-sidebar>