@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="page-head">
    <h2>Data Pengguna</h2>
    <a href="{{ route('admin.users.create') }}" class="btn">+ Tambah Pengguna</a>
</div>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Jenis bawaan</th>
            <th>Pasar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ ucfirst($u->role) }}</td>
            <td>{{ $u->jenis_default ? ucfirst($u->jenis_default) : '-' }}</td>
            <td>{{ $u->market?->nama ?? '-' }}</td>
            <td>
                @if($u->aktif)
                    <span class="badge aktif">Aktif</span>
                @else
                    <span class="badge nonaktif">Nonaktif</span>
                @endif
            </td>
            <td class="aksi">
                <a href="{{ route('admin.users.edit', $u) }}" class="btn">Ubah</a>
                @if($u->aktif && $u->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                          onsubmit="return confirm('Nonaktifkan pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Nonaktifkan</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection