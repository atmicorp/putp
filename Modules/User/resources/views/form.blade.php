<x-app-sidebar>
    <x-slot name="title">{{ isset($user) ? 'Edit User' : 'Create User' }}</x-slot>

    <x-slot name="breadcrumb">
        <span>Management</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('users.index') }}" style="color:#6b7280;text-decoration:none;">Users</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">{{ isset($user) ? 'Edit' : 'Create' }}</span>
    </x-slot>

    <style>
        .form-page { max-width: 580px; }

        .page-header { margin-bottom: 28px; }
        .page-title  { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .page-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .form-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }

        .form-section {
            padding: 28px 32px;
        }

        .form-section + .form-section {
            border-top: 1px solid #f3f4f6;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #9ca3af;
            margin-bottom: 20px;
        }

        .avatar-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 32px;
            background: #f9fafb;
            border-bottom: 1px solid #f3f4f6;
        }

        .avatar-preview {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #ea580c;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            flex-shrink: 0;
            transition: background 0.3s;
        }

        .avatar-meta strong { display: block; font-size: 14px; font-weight: 600; color: #1c1917; }
        .avatar-meta span   { font-size: 12px; color: #9ca3af; }

        .field { margin-bottom: 18px; }
        .field:last-child { margin-bottom: 0; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .required { color: #ef4444; margin-left: 2px; }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13.5px;
            font-family: 'Sora', sans-serif;
            color: #1c1917;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
            box-sizing: border-box;
        }

        input:focus {
            background: #fff;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
        }

        input::placeholder { color: #c4c4cf; }

        input.is-invalid { border-color: #ef4444; }
        input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #ef4444;
            font-weight: 500;
            margin-top: 6px;
        }

        .hint { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: color 0.15s;
        }

        .back-link:hover { color: #1c1917; }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: #ea580c;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-primary:hover {
            background: #c2410c;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(234,88,12,0.25);
        }

        .field input,
        .field select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .field input:focus,
        .field select:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.1);
            outline: none;
        }

        .field .is-invalid {
            border-color: #ef4444;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 35px;
        }

        .select-wrapper::after {
            content: "▾";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 14px;
            color: #666;
        }

        /* ── Signature Dropzone ─────────────────────────── */
        .signature-upload-area {
            border: 2px dashed #e5e7eb;
            border-radius: 10px;
            padding: 28px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f9fafb;
        }

        .signature-upload-area:hover,
        .signature-upload-area.drag-over {
            border-color: #ea580c;
            background: #fff7ed;
        }

        .signature-upload-area.has-file {
            border-color: #10b981;
            background: #f0fdf4;
            cursor: default;
        }

        .signature-upload-area.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .dropzone-icon {
            margin-bottom: 10px;
            opacity: 0.5;
        }

        .dropzone-label-main {
            margin: 0 0 4px;
            font-size: 13px;
            color: #374151;
            font-weight: 500;
        }

        .dropzone-label-sub {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
        }

        .signature-current-preview {
            margin-bottom: 14px;
            padding: 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
            display: inline-block;
        }

        .signature-current-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 500;
        }
    </style>

    <div class="form-page">
        <div class="page-header">
            <h1 class="page-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h1>
            <p class="page-subtitle">{{ isset($user) ? 'Update the account details below.' : 'Fill in the information to create a new account.' }}</p>
        </div>

        <div class="form-card">

            {{-- Avatar preview --}}
            <div class="avatar-row">
                <div class="avatar-preview" id="avatarEl">
                    {{ isset($user) ? strtoupper(substr($user->name, 0, 1)) : '?' }}
                </div>
                <div class="avatar-meta">
                    <strong id="avatarName">{{ isset($user) ? $user->name : 'New User' }}</strong>
                    <span>Auto-generated avatar</span>
                </div>
            </div>

            {{-- enctype wajib untuk upload file --}}
            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                {{-- Basic info --}}
                <div class="form-section">
                    <div class="section-title">Basic Information</div>

                    <div class="field">
                        <label for="name">Full Name <span class="required">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name ?? '') }}"
                            placeholder="e.g. John Doe"
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                            required
                            autocomplete="name"
                        >
                        @error('name')
                            <div class="error-msg">
                                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email ?? '') }}"
                            placeholder="e.g. john@example.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            required
                            autocomplete="email"
                        >
                        @error('email')
                            <div class="error-msg">
                                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="role">Role <span class="required">*</span></label>

                        <div class="select-wrapper">
                            <select
                                id="role"
                                name="role"
                                class="{{ $errors->has('role') ? 'is-invalid' : '' }}"
                                required
                            >
                                @foreach($roles as $roleValue => $roleLabel)
                                    <option value="{{ $roleValue }}"
                                        @selected(old('role', $user->role ?? 'staff') === $roleValue)
                                    >
                                        {{ $roleLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('role')
                            <div class="error-msg">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Password --}}
                <div class="form-section">
                    <div class="section-title">{{ isset($user) ? 'Change Password' : 'Password' }}</div>

                    <div class="grid-2">
                        <div class="field">
                            <label for="password">
                                Password
                                @if(!isset($user)) <span class="required">*</span> @endif
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="{{ isset($user) ? 'Leave blank to keep' : 'Min. 8 characters' }}"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                {{ !isset($user) ? 'required' : '' }}
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="error-msg">
                                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation">
                                Confirm Password
                                @if(!isset($user)) <span class="required">*</span> @endif
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Repeat password"
                                {{ !isset($user) ? 'required' : '' }}
                                autocomplete="new-password"
                            >
                        </div>
                    </div>

                    @if(isset($user))
                        <p class="hint">Leave both fields blank to keep the current password.</p>
                    @endif
                </div>

                {{-- Tanda Tangan --}}
                <div class="form-section">
                    <div class="section-title">Tanda Tangan</div>

                    {{-- Preview tanda tangan yang sudah ada (hanya di edit) --}}
                    @if(isset($user) && $user->hasSignature())
                        <div class="field">
                            <p class="signature-current-label">Tanda tangan saat ini:</p>
                            <div class="signature-current-preview">
                                <img
                                    src="{{ route('signature.show', $user->id) }}"
                                    alt="Tanda Tangan {{ $user->name }}"
                                    style="max-height:80px; max-width:240px; display:block;"
                                >
                            </div>
                        </div>
                    @endif

                    <div class="field">
                        <label for="signature">
                            {{ isset($user) && $user->hasSignature() ? 'Ganti Tanda Tangan' : 'Upload Tanda Tangan' }}
                        </label>

                        {{-- Dropzone area --}}
                        <div
                            class="signature-upload-area {{ $errors->has('signature') ? 'is-invalid' : '' }}"
                            id="signatureDropzone"
                        >
                            {{-- Hidden file input --}}
                            <input
                                type="file"
                                id="signature"
                                name="signature"
                                accept="image/png,image/jpeg,image/jpg"
                                style="display:none;"
                            >

                            {{-- Default state --}}
                            <div id="dropzoneContent">
                                <div class="dropzone-icon">
                                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </div>
                                <p class="dropzone-label-main">Klik untuk upload atau drag &amp; drop</p>
                                <p class="dropzone-label-sub">PNG, JPG — maks. 2MB</p>
                            </div>

                            {{-- Preview state (hidden by default) --}}
                            <div id="dropzonePreview" style="display:none;">
                                <img
                                    id="previewImg"
                                    style="max-height:80px; max-width:240px; display:block; margin:0 auto; border-radius:6px;"
                                    alt="Preview tanda tangan"
                                >
                                <p style="margin:10px 0 4px; font-size:13px; color:#10b981; font-weight:600;">
                                    ✓ File siap diupload
                                </p>
                                <button
                                    type="button"
                                    id="removeSig"
                                    style="font-size:12px;color:#ef4444;background:none;border:none;cursor:pointer;font-weight:500;padding:0;"
                                >
                                    ✕ Hapus pilihan
                                </button>
                            </div>
                        </div>

                        @error('signature')
                            <div class="error-msg">
                                <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </div>
                        @enderror

                        <p class="hint">
                            Tanda tangan disimpan secara private dan hanya dapat diakses oleh admin.
                            {{ isset($user) && $user->hasSignature() ? 'Upload baru akan menggantikan tanda tangan sebelumnya.' : '' }}
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="form-footer">
                    <a href="{{ route('users.index') }}" class="back-link">
                        ← Back to Users
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ isset($user) ? 'Save Changes' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Avatar live preview ──────────────────────────────────
        const colors     = ['#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b','#ef4444'];
        const nameInput  = document.getElementById('name');
        const avatarEl   = document.getElementById('avatarEl');
        const avatarName = document.getElementById('avatarName');

        nameInput.addEventListener('input', function () {
            const v = this.value.trim();
            avatarEl.textContent      = v ? v[0].toUpperCase() : '?';
            avatarName.textContent    = v || 'New User';
            avatarEl.style.background = v ? colors[v.charCodeAt(0) % colors.length] : '#4f46e5';
        });

        // ── Signature dropzone ───────────────────────────────────
        const dropzone    = document.getElementById('signatureDropzone');
        const sigInput    = document.getElementById('signature');
        const dropContent = document.getElementById('dropzoneContent');
        const dropPreview = document.getElementById('dropzonePreview');
        const previewImg  = document.getElementById('previewImg');
        const removeSig   = document.getElementById('removeSig');

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                dropContent.style.display = 'none';
                dropPreview.style.display = 'block';
                dropzone.classList.add('has-file');
                dropzone.classList.remove('is-invalid');
            };
            reader.readAsDataURL(file);
        }

        function resetDropzone() {
            sigInput.value            = '';
            previewImg.src            = '';
            dropContent.style.display = 'block';
            dropPreview.style.display = 'none';
            dropzone.classList.remove('has-file');
        }

        // Klik area → buka file picker (hanya jika belum ada file)
        dropzone.addEventListener('click', function (e) {
            if (e.target === removeSig) return;
            if (!dropzone.classList.contains('has-file')) {
                sigInput.click();
            }
        });

        // File dipilih via input
        sigInput.addEventListener('change', function () {
            if (this.files[0]) showPreview(this.files[0]);
        });

        // Hapus pilihan
        removeSig.addEventListener('click', function (e) {
            e.stopPropagation();
            resetDropzone();
        });

        // Drag & drop
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            if (!this.classList.contains('has-file')) {
                this.classList.add('drag-over');
            }
        });

        dropzone.addEventListener('dragleave', function () {
            this.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drag-over');

            const file = e.dataTransfer.files[0];
            if (!file) return;

            const allowed = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!allowed.includes(file.type)) {
                alert('Format tidak didukung. Gunakan PNG atau JPG.');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file melebihi 2MB.');
                return;
            }

            // Assign file ke input agar ikut tersubmit form
            const dt = new DataTransfer();
            dt.items.add(file);
            sigInput.files = dt.files;

            showPreview(file);
        });
    </script>
</x-app-sidebar>