<x-app-sidebar>
    <x-slot name="title">Tambah Category</x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('category.index') }}" style="color:#6b7280;text-decoration:none;">Category</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Tambah Category</span>
    </x-slot>

    <style>
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        .form-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 28px 32px; max-width: 560px;
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 12px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
            color: #374151; margin-bottom: 6px;
        }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1px solid #e5e7eb;
            border-radius: 8px; font-size: 13.5px; font-family: 'Sora', sans-serif;
            color: #1c1917; background: #f9fafb; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s; box-sizing: border-box;
        }
        .form-control:focus { border-color: #ea580c; background: #fff; box-shadow: 0 0 0 3px rgba(234,88,12,0.08); }
        .form-control.is-invalid { border-color: #dc2626; }
        .invalid-feedback { font-size: 12px; color: #dc2626; margin-top: 5px; }

        .form-actions { display: flex; align-items: center; gap: 10px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
        .btn-primary {
            padding: 10px 24px; background: #ea580c; color: #fff; border: none;
            border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,88,12,0.25); }
        .btn-secondary {
            padding: 10px 20px; background: transparent; color: #6b7280;
            border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px;
            font-weight: 600; cursor: pointer; font-family: 'Sora', sans-serif;
            text-decoration: none; transition: all 0.15s;
        }
        .btn-secondary:hover { border-color: #9ca3af; color: #374151; }

        .alert-danger { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
    </style>

    <div class="dash-title">Tambah Category</div>
    <p class="dash-subtitle">Buat category baru untuk pengelompokan paket</p>

    @if($errors->any())
        <div class="alert-danger">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:6px 0 0 16px;padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <div class="form-card">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="nama_category">Nama Category</label>
                <input
                    type="text"
                    id="nama_category"
                    name="nama_category"
                    class="form-control {{ $errors->has('nama_category') ? 'is-invalid' : '' }}"
                    value="{{ old('nama_category') }}"
                    placeholder="Contoh: Paket Premium"
                    autocomplete="off"
                >
                @error('nama_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Category
                </button>
                <a href="{{ route('category.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</x-app-sidebar>