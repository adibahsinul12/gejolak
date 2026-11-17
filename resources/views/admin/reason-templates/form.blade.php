@extends('layouts.app')

@section('title', $template->exists ? 'Ubah Template Alasan' : 'Tambah Template Alasan')

@section('content')
<div class="card">
    <h2>{{ $template->exists ? 'Ubah Template Alasan' : 'Tambah Template Alasan' }}</h2>

    <form method="POST"
          action="{{ $template->exists ? route('admin.reason-templates.update', $template) : route('admin.reason-templates.store') }}">
        @csrf
        @if($template->exists)
            @method('PUT')
        @endif

        <label>Teks alasan</label>
        <input type="text" name="teks" value="{{ old('teks', $template->teks) }}" required>

        <label class="checkline">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $template->aktif ?? true))>
            Aktif
        </label>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.reason-templates.index') }}" class="btn secondary">Batal</a>
    </form>
</div>
@endsection