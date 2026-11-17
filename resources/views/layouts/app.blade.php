<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HARPA') - Deteksi Gejolak Harga Pangan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body>
<header class="topbar">
    <a href="{{ route('dashboard') }}" class="brand">HARPA</a>

    <nav class="menu">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.markets.index') }}">Pasar</a>
            <a href="{{ route('admin.commodities.index') }}">Komoditas</a>
            <a href="{{ route('admin.reason-templates.index') }}">Template Alasan</a>
            <a href="{{ route('admin.users.index') }}">Pengguna</a>
        @endif
    </nav>
    
    <div class="userbox">
        <form method="POST" action="{{ route('jenis.set') }}">
            @csrf
            <select name="jenis" onchange="this.form.submit()">
                <option value="produsen" @selected(session('jenis') === 'produsen')>Produsen</option>
                <option value="konsumen" @selected(session('jenis', 'konsumen') === 'konsumen')>Konsumen</option>
            </select>
        </form>
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </div>
</header>

<main class="container">
    @if(session('ok'))
        <div class="alert ok">{{ session('ok') }}</div>
    @endif
    @if($errors->any())
        <div class="alert err">{{ $errors->first() }}</div>
    @endif

    @yield('content')
</main>
</body>
</html>