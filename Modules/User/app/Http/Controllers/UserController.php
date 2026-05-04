<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('user::index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roles();
        return view('user::form', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'confirmed', Password::min(8)],
            'signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);

        // Upload signature jika ada
        if ($request->hasFile('signature')) {
            $this->uploadSignature($request, $user);
        }

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user::show', compact('user'));
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = $this->roles();

        return view('user::form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user  = User::findOrFail($id);
        $roles = array_keys($this->roles());

        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'      => ['required', 'in:' . implode(',', $roles)],
            'password'  => ['nullable', 'confirmed', Password::min(8)],
            'signature' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Upload signature baru jika ada (hapus yang lama)
        if ($request->hasFile('signature')) {
            $this->uploadSignature($request, $user);
        }

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    // ─── Method baru: uploadSignature() ──────────────────────
    private function uploadSignature(Request $request, User $user): void
    {
        // Hapus file lama jika ada
        if ($user->signature_path && Storage::disk('private')->exists($user->signature_path)) {
            Storage::disk('private')->delete($user->signature_path);
        }

        // Simpan ke: storage/app/private/signatures/{user_id}/
        $path = $request->file('signature')->storeAs(
            'signatures/' . $user->id,
            'signature.' . $request->file('signature')->getClientOriginalExtension(),
            'private'   // disk: storage/app/private
        );

        $user->update(['signature_path' => $path]);
    }

    private function roles(): array
    {
        return [
            'admin'    => 'Admin',
            'operator' => 'Operator',
            'pic'    => 'PIC',
            'manager'    => 'Manager',
        ];
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}