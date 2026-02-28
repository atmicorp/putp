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

        /* Samakan style input & select */
        .field input,
        .field select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
            transition: all 0.2s ease;
        }

        /* Focus style */
        .field input:focus,
        .field select:focus {
            border-color: #6366f1; /* sesuaikan warna primary kamu */
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        /* Invalid */
        .field .is-invalid {
            border-color: #ef4444;
        }

        /* Custom arrow biar lebih modern */
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

            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                  method="POST">
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
        const colors = ['#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b','#ef4444'];
        const nameInput  = document.getElementById('name');
        const avatarEl   = document.getElementById('avatarEl');
        const avatarName = document.getElementById('avatarName');

        nameInput.addEventListener('input', function () {
            const v = this.value.trim();
            avatarEl.textContent   = v ? v[0].toUpperCase() : '?';
            avatarName.textContent = v || 'New User';
            avatarEl.style.background = v ? colors[v.charCodeAt(0) % colors.length] : '#4f46e5';
        });
    </script>
</x-app-sidebar>