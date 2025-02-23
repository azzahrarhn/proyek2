<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Manajemen Pendidikan</title>
    <!-- Menggunakan CSS dari template -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <!-- Header atau Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manajemen Pendidikan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('biodata_siswa.index') }}">Biodata Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mata_pelajaran.index') }}">Mata Pelajaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('nilai.index') }}">Nilai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Daftar Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mt-5">
        <h1 class="text-center">Selamat Datang di Aplikasi Manajemen Pendidikan</h1>
        <p class="text-center">Gunakan navigasi untuk mengelola data siswa, nilai, dan mata pelajaran.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Biodata Siswa</h5>
                        <p class="card-text">Kelola data siswa secara lengkap dan mudah.</p>
                        <a href="{{ route('biodata_siswa.index') }}" class="btn btn-primary">Lihat Data</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mata Pelajaran</h5>
                        <p class="card-text">Kelola mata pelajaran yang tersedia.</p>
                        <a href="{{ route('mata_pelajaran.index') }}" class="btn btn-primary">Lihat Data</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nilai</h5>
                        <p class="card-text">Kelola nilai siswa, termasuk UTS dan UAS.</p>
                        <a href="{{ route('nilai.index') }}" class="btn btn-primary">Lihat Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            &copy; 2024 Aplikasi Manajemen Pendidikan. All Rights Reserved.
        </div>
    </footer>

    <!-- Menggunakan JavaScript dari template -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
