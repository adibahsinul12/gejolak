<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('market')->orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', [
            'user'    => new User(['role' => 'enumerator', 'aktif' => true]),
            'markets' => Market::aktif()->orderBy('jenis')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->data($request);
        $data['password'] = $request->validate(['password' => ['required', 'min:6', 'confirmed']])['password'];

        User::create($data);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user'    => $user,
            'markets' => Market::aktif()->orderBy('jenis')->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->data($request, $user);

        // Password hanya diganti kalau diisi.
        if ($request->filled('password')) {
            $data['password'] = $request->validate(['password' => ['min:6', 'confirmed']])['password'];
        }

        // Pengaman: admin tidak boleh menurunkan atau menonaktifkan dirinya sendiri.
        if ($user->id === auth()->id()) {
            $data['role']  = $user->role;
            $data['aktif'] = true;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna berhasil diperbarui.');
    }

    // Tidak menghapus, hanya menonaktifkan.
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['nama' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.']);
        }

        $user->update(['aktif' => false]);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna dinonaktifkan.');
    }

    private function data(Request $request, ?User $user = null): array
    {
        $data = $request->validate([
            'name'          => ['required', 'max:100'],
            'email'         => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user?->id)],
            'role'          => ['required', 'in:admin,enumerator,pimpinan'],
            'jenis_default' => ['nullable', 'in:produsen,konsumen'],
            'market_id'     => ['nullable', 'exists:markets,id'],
        ]);

        $data['aktif'] = $request->boolean('aktif');

        // Hanya enumerator yang punya jenis bawaan dan pasar.
        if ($data['role'] !== 'enumerator') {
            $data['jenis_default'] = null;
            $data['market_id']     = null;
        }

        return $data;
    }
}