<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - HARPA</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body class="login-page">
    <form method="POST" action="{{ route('login') }}" class="card login">
        @csrf
        <h1>HARPA</h1>
        <p>Sistem Deteksi Gejolak Harga Pangan</p>

        @if($errors->any())
            <div class="alert err">{{ $errors->first() }}</div>
        @endif

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Masuk</button>
    </form>
</body>
</html>