@extends('layouts.app')

@section('title', $commodity->exists ? 'Ubah Komoditas' : 'Tambah Komoditas')

@section('content')
<div class="card">
    <h2>{{ $commodity->exists ? 'Ubah Komoditas' : 'Tambah Komoditas' }}</h2>

    <form method="POST"
          action="{{ $commodity->exists ? route('admin.commodities.update', $commodity) : route('admin.commodities.store') }}">
        @csrf
        @if($commodity->exists)
            @method('PUT')
        @endif

        <label>Nama komoditas</label>
        <input type="text" name="nama" value="{{ old('nama', $commodity->nama) }}" required>

        <label>Satuan</label>
        <input type="text" name="satuan" value="{{ old('satuan', $commodity->satuan) }}" required>

        <label>Kelompok (opsional)</label>
        <input type="text" name="kelompok" value="{{ old('kelompok', $commodity->kelompok) }}">

        <label>Jenis (centang minimal satu)</label>
        <label class="checkline">
            <input type="hidden" name="untuk_produsen" value="0">
            <input type="checkbox" name="untuk_produsen" value="1" @checked(old('untuk_produsen', $commodity->untuk_produsen))>
            Produsen
        </label>
        <label class="checkline">
            <input type="hidden" name="untuk_konsumen" value="0">
            <input type="checkbox" name="untuk_konsumen" value="1" @checked(old('untuk_konsumen', $commodity->untuk_konsumen))>
            Konsumen
        </label>

        <label class="checkline">
            <input type="hidden" name="dipantau" value="0">
            <input type="checkbox" name="dipantau" value="1" @checked(old('dipantau', $commodity->dipantau))>
            Dipantau gejolak (ikut deteksi)
        </label>

        <label>Alias nama (satu per baris, opsional)</label>
        <textarea name="aliases" rows="4" placeholder="Contoh: Garam Halus Beryodium">{{ old('aliases', $commodity->exists ? $commodity->aliases->pluck('alias')->implode("\n") : '') }}</textarea>

        <label class="checkline">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $commodity->aktif ?? true))>
            Aktif
        </label>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.commodities.index') }}" class="btn secondary">Batal</a>
    </form>
</div>
@endsection