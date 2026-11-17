@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <h2>Dashboard</h2>
    <p>Peran: <strong>{{ auth()->user()->role }}</strong></p>
    <p>Mode: <strong>{{ ucfirst(session('jenis', 'konsumen')) }}</strong></p>
    <p>Ringkasan harga dan gejolak akan tampil di sini pada tahap berikutnya.</p>
</div>
@endsection