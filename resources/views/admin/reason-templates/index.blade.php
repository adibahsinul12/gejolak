@extends('layouts.app')

@section('title', 'Template Alasan')

@section('content')
<div class="page-head">
    <h2>Template Alasan Perubahan Harga</h2>
    <a href="{{ route('admin.reason-templates.create') }}" class="btn">+ Tambah Template</a>
</div>

<table>
    <thead>
        <tr>
            <th>Teks alasan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($templates as $t)
        <tr>
            <td>{{ $t->teks }}</td>
            <td>
                @if($t->aktif)
                    <span class="badge aktif">Aktif</span>
                @else
                    <span class="badge nonaktif">Nonaktif</span>
                @endif
            </td>
            <td class="aksi">
                <a href="{{ route('admin.reason-templates.edit', $t) }}" class="btn">Ubah</a>
                @if($t->aktif)
                    <form method="POST" action="{{ route('admin.reason-templates.destroy', $t) }}"
                          onsubmit="return confirm('Nonaktifkan template ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Nonaktifkan</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="3">Belum ada template alasan.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection