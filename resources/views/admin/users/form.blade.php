@extends('layouts.app')

@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')

@section('content')
<div class="card">
    <h2>{{ $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna' }}</h2>

    <form method="POST"
          action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label>Peran</label>
        <select name="role" required>
            @foreach(['admin' => 'Admin', 'enumerator' => 'Enumerator', 'pimpinan' => 'Pimpinan'] as $val => $label)
                <option value="{{ $val }}" @selected(old('role', $user->role) === $val)>{{ $label }}</option>
            @endforeach
        </select>

        <label>Jenis bawaan (khusus enumerator)</label>
        <select name="jenis_default">
            <option value="">-</option>
            <option value="produsen" @selected(old('jenis_default', $user->jenis_default) === 'produsen')>Produsen</option>
            <option value="konsumen" @selected(old('jenis_default', $user->jenis_default) === 'konsumen')>Konsumen</option>
        </select>

        <label>Pasar (khusus enumerator)</label>
        <select name="market_id">
            <option value="">-</option>
            @foreach($markets as $m)
                <option value="{{ $m->id }}" @selected((string) old('market_id', $user->market_id) === (string) $m->id)>
                    {{ $m->nama }} ({{ $m->jenis }})
                </option>
            @endforeach
        </select>

        <label>Password {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
        <input type="password" name="password" {{ $user->exists ? '' : 'required' }} autocomplete="new-password">

        <label>Ulangi password</label>
        <input type="password" name="password_confirmation" autocomplete="new-password">

        <label class="checkline">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $user->aktif ?? true))>
            Aktif
        </label>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn secondary">Batal</a>
    </form>
</div>
@endsection