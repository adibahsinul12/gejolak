@extends('layouts.app')

@section('title', $market->exists ? 'Ubah Pasar' : 'Tambah Pasar')

@section('content')
<div class="card">
    <h2>{{ $market->exists ? 'Ubah Pasar' : 'Tambah Pasar' }}</h2>

    <form method="POST"
          action="{{ $market->exists ? route('admin.markets.update', $market) : route('admin.markets.store') }}">
        @csrf
        @if($market->exists)
            @method('PUT')
        @endif

        <label>Nama pasar</label>
        <input type="text" name="nama" value="{{ old('nama', $market->nama) }}" required>

        <label>Jenis</label>
        <select name="jenis" required>
            <option value="konsumen" @selected(old('jenis', $market->jenis) === 'konsumen')>Konsumen</option>
            <option value="produsen" @selected(old('jenis', $market->jenis) === 'produsen')>Produsen</option>
        </select>

        <label>Lokasi (opsional)</label>
        <input type="text" name="lokasi" value="{{ old('lokasi', $market->lokasi) }}">

        <label class="checkline">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $market->aktif ?? true))>
            Aktif
        </label>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.markets.index') }}" class="btn secondary">Batal</a>
    </form>
</div>
@endsection