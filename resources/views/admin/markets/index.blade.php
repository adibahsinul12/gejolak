@extends('layouts.app')

@section('title', 'Pasar')

@section('content')
<div class="page-head">
    <h2>Data Pasar</h2>
    <a href="{{ route('admin.markets.create') }}" class="btn">+ Tambah Pasar</a>
</div>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($markets as $m)
        <tr>
            <td>{{ $m->nama }}</td>
            <td>{{ ucfirst($m->jenis) }}</td>
            <td>{{ $m->lokasi ?? '-' }}</td>
            <td>
                @if($m->aktif)
                    <span class="badge aktif">Aktif</span>
                @else
                    <span class="badge nonaktif">Nonaktif</span>
                @endif
            </td>
            <td class="aksi">
                <a href="{{ route('admin.markets.edit', $m) }}" class="btn">Ubah</a>
                @if($m->aktif)
                    <form method="POST" action="{{ route('admin.markets.destroy', $m) }}"
                          onsubmit="return confirm('Nonaktifkan pasar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Nonaktifkan</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="5">Belum ada data pasar.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection