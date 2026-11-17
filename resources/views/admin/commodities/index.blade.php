@extends('layouts.app')

@section('title', 'Komoditas')

@section('content')
<div class="page-head">
    <h2>Data Komoditas</h2>
    <a href="{{ route('admin.commodities.create') }}" class="btn">+ Tambah Komoditas</a>
</div>

<form method="GET" class="filter">
    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama komoditas">
    <select name="jenis">
        <option value="">Semua jenis</option>
        <option value="produsen" @selected(request('jenis') === 'produsen')>Produsen</option>
        <option value="konsumen" @selected(request('jenis') === 'konsumen')>Konsumen</option>
    </select>
    <button type="submit">Cari</button>
    <a href="{{ route('admin.commodities.index') }}" class="btn secondary">Reset</a>
</form>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Kelompok</th>
            <th>Satuan</th>
            <th>Jenis</th>
            <th>Dipantau</th>
            <th>Alias</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($commodities as $c)
        <tr>
            <td>{{ $c->nama }}</td>
            <td>{{ $c->kelompok ?? '-' }}</td>
            <td>{{ $c->satuan }}</td>
            <td>
                @if($c->untuk_produsen)<span class="badge info">Produsen</span>@endif
                @if($c->untuk_konsumen)<span class="badge info">Konsumen</span>@endif
            </td>
            <td>{{ $c->dipantau ? 'Ya' : '-' }}</td>
            <td>{{ $c->aliases->pluck('alias')->implode(', ') ?: '-' }}</td>
            <td>
                @if($c->aktif)
                    <span class="badge aktif">Aktif</span>
                @else
                    <span class="badge nonaktif">Nonaktif</span>
                @endif
            </td>
            <td class="aksi">
                <a href="{{ route('admin.commodities.edit', $c) }}" class="btn">Ubah</a>
                @if($c->aktif)
                    <form method="POST" action="{{ route('admin.commodities.destroy', $c) }}"
                          onsubmit="return confirm('Nonaktifkan komoditas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Nonaktifkan</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="8">Tidak ada komoditas.</td></tr>
    @endforelse
    </tbody>
</table>
<p>Total: {{ $commodities->count() }} komoditas</p>
@endsection