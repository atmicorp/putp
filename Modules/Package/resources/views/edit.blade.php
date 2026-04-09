<x-app-sidebar>
    <x-slot name="title">Edit Package</x-slot>

    <x-slot name="breadcrumb">
        <span>Package</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('package.index') }}" style="color:#6b7280;text-decoration:none;">Package List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Edit Package</span>
    </x-slot>

    <style>
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; max-width: 720px; }

        .form-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 24px; border-bottom: 1px solid #f3f4f6; background: #fafafa;
        }
        .form-card-header-left { display: flex; align-items: center; gap: 10px; }
        .form-card-header-icon {
            width: 32px; height: 32px; background: #fff7ed; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .form-card-title { font-size: 14px; font-weight: 700; color: #1c1917; }
        .form-card-sub   { font-size: 12px; color: #9ca3af; margin-top: 1px; }

        .pkg-id-badge {
            font-size: 11.5px; font-weight: 600; color: #6b7280;
            background: #f3f4f6; border: 1px solid #e5e7eb;
            padding: 4px 10px; border-radius: 6px;
        }

        .form-card-body { padding: 24px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 20px; }
        .form-group:last-child { margin-bottom: 0; }

        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #374151; margin-bottom: 6px; letter-spacing: 0.1px; }
        .form-label .req { color: #ea580c; margin-left: 2px; }

        .form-control, .form-select-ctrl {
            width: 100%; padding: 9px 12px;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 8px;
            font-size: 13.5px; font-family: 'Sora', sans-serif; color: #1c1917;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
        }
        .form-control:focus, .form-select-ctrl:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.08); }
        .form-control.is-invalid, .form-select-ctrl.is-invalid { border-color: #dc2626; }
        .form-control::placeholder { color: #c4c9d4; }

        .form-select-ctrl {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 10px center; background-size: 12px 9px;
            padding-right: 32px;
        }

        textarea.form-control { resize: vertical; min-height: 88px; }

        .invalid-msg { font-size: 12px; color: #dc2626; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        .input-prefix-wrap { display: flex; }
        .input-prefix {
            display: flex; align-items: center; padding: 0 12px;
            background: #f9fafb; border: 1px solid #e5e7eb; border-right: none;
            border-radius: 8px 0 0 8px; font-size: 12.5px; font-weight: 600; color: #9ca3af;
            white-space: nowrap;
        }
        .input-prefix + .form-control { border-radius: 0 8px 8px 0; }

        .section-label {
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px;
            color: #9ca3af; margin-bottom: 16px; margin-top: 4px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

        /* Toggle */
        .toggle-group { display: flex; align-items: center; gap: 10px; }
        .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; cursor: pointer; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-track { position: absolute; inset: 0; background: #e5e7eb; border-radius: 11px; transition: background 0.2s; }
        .toggle-thumb { position: absolute; width: 16px; height: 16px; top: 3px; left: 3px; background: #fff; border-radius: 50%; transition: transform 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.15); }
        .toggle-switch input:checked ~ .toggle-track { background: #ea580c; }
        .toggle-switch input:checked ~ .toggle-thumb { transform: translateX(18px); }
        .toggle-label { font-size: 13px; color: #374151; font-weight: 500; cursor: pointer; user-select: none; }
        .toggle-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        .form-card-footer {
            display: flex; align-items: center; padding: 16px 24px;
            border-top: 1px solid #f3f4f6; background: #fafafa; gap: 8px;
        }
        .footer-left { margin-right: auto; }
        .btn-view {
            padding: 8px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600;
            background: transparent; border: 1px solid #e5e7eb; color: #6b7280;
            cursor: pointer; font-family: 'Sora', sans-serif; text-decoration: none;
            display: inline-flex; align-items: center; gap: 5px; transition: all 0.15s;
        }
        .btn-view:hover { border-color: #ea580c; color: #ea580c; background: #fff7ed; }
        .btn-cancel {
            padding: 8px 18px; border-radius: 8px; font-size: 13px; font-weight: 600;
            background: #fff; border: 1px solid #e5e7eb; color: #6b7280;
            cursor: pointer; font-family: 'Sora', sans-serif; text-decoration: none; transition: all 0.15s;
        }
        .btn-cancel:hover { border-color: #d1d5db; background: #f9fafb; color: #374151; }
        .btn-submit {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
            background: #ea580c; border: none; color: #fff;
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
        }
        .btn-submit:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }
    </style>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            Terdapat {{ $errors->count() }} kesalahan pada form.
        </div>
    @endif

    <form action="{{ route('package.update', $package) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-card">

            <div class="form-card-header">
                <div class="form-card-header-left">
                    <div class="form-card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <div class="form-card-title">Edit Package</div>
                        <div class="form-card-sub">Perbarui informasi package</div>
                    </div>
                </div>
                <span class="pkg-id-badge">#{{ $package->id }}</span>
            </div>

            <div class="form-card-body">

                <div class="form-row" style="margin-bottom:20px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="name">Nama Package <span class="req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $package->name) }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="cth. Paket Bubut Standar" autofocus>
                        @error('name')
                            <div class="invalid-msg"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="machine_id">Mesin <span class="req">*</span></label>
                        <select id="machine_id" name="machine_id" class="form-select-ctrl {{ $errors->has('machine_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Pilih Mesin --</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ old('machine_id', $package->machine_id) == $machine->id ? 'selected' : '' }}>
                                    {{ $machine->name }} ({{ $machine->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('machine_id')
                            <div class="invalid-msg"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description"
                        class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="Deskripsi singkat tentang package ini...">{{ old('description', $package->description) }}</textarea>
                    @error('description')
                        <div class="invalid-msg"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                    @enderror
                </div>

                <div class="section-label">Harga & Penanggungjawab</div>
                <div class="form-row" style="margin-bottom:20px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="base_price">Base Price <span class="req">*</span></label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" id="base_price" name="base_price" value="{{ old('base_price', $package->base_price) }}"
                                class="form-control {{ $errors->has('base_price') ? 'is-invalid' : '' }}"
                                placeholder="0" min="0" step="1000">
                        </div>
                        @error('base_price')
                            <div class="invalid-msg"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="pic_operator_id">PIC Operator</label>
                        <select id="pic_operator_id" name="pic_operator_id" class="form-select-ctrl {{ $errors->has('pic_operator_id') ? 'is-invalid' : '' }}">
                            <option value="">-- Tidak ada --</option>
                            @foreach($operators as $operator)
                                <option value="{{ $operator->id }}" {{ old('pic_operator_id', $package->pic_operator_id) == $operator->id ? 'selected' : '' }}>
                                    {{ $operator->user->name }} ({{ $operator->user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('pic_operator_id')
                            <div class="invalid-msg"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="section-label">Status</div>
                <div class="form-group">
                    <div class="toggle-group">
                        <label class="toggle-switch" for="is_active">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                            <div class="toggle-track"></div>
                            <div class="toggle-thumb"></div>
                        </label>
                        <div>
                            <div class="toggle-label" id="toggleLabel">{{ $package->is_active ? 'Active' : 'Inactive' }}</div>
                            <div class="toggle-sub">Package nonaktif tidak akan muncul di penawaran</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-card-footer">
                <div class="footer-left">
                    <a href="{{ route('package.show', $package) }}" class="btn-view">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Detail
                    </a>
                </div>
                <a href="{{ route('package.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Update Package
                </button>
            </div>

        </div>
    </form>

    <script>
        const cb = document.getElementById('is_active');
        const lbl = document.getElementById('toggleLabel');
        function sync() { lbl.textContent = cb.checked ? 'Active' : 'Inactive'; lbl.style.color = cb.checked ? '#15803d' : '#6b7280'; }
        cb.addEventListener('change', sync); sync();
    </script>
</x-app-sidebar>