<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Bootstrap</title>

    <!-- Panggil CSS dari folder public -->
    <link rel="stylesheet" href="{{ asset('belajar_laravel/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('belajar_laravel/css/bootstrap.min.css') }}">
</head>
<body>

    <!-- Panggil Header atau bagian lainnya -->
    @include('partials.header')

    <!-- Bagian Konten -->
    <div class="container">
        <h1>Selamat Datang</h1>
        <p>Ini adalah contoh implementasi template Bootstrap di Laravel.</p>
    </div>

    <!-- Panggil JavaScript dari folder public -->
    <script src="{{ asset('belajar_laravel/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('belajar_laravel/js/custom.js') }}"></script>
</body>
</html>
