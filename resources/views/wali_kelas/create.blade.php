<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin | E-Rapor</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/sekolah.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/sekolah.jpg') }}" rel="sekolah.jpg">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/sdn.jpg') }}" alt="">
                <span class="d-none d-lg-block">E-Rapor</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">
                    @php
                    $user = Auth::user(); // Ambil pengguna yang sedang login
                    @endphp

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset($user->profile_picture) }}" alt="Profile" class="rounded-circle"
                            style="width: 40px; height: 40px;">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user->name }}</span>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ $user->name }}</h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-siswa-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Data Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-siswa-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link collapsed" href="{{ route('biodata_siswa.create') }}">
                            <i class="bi bi-circle"></i><span>Tambah Data Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link collapsed" href="{{ route('biodata_siswa.kelola') }}">
                            <i class="bi bi-circle"></i><span>Kelola Data Siswa</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Data Siswa Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('mata_pelajaran.create') }}">
                    <i class="bi bi-journal-bookmark"></i><span>Mata Pelajaran</span>
                </a>
            </li><!-- End Mata Pelajaran Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-guru-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Data Guru</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-guru-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link collapsed" href="{{ route('guru.create') }}">
                            <i class="bi bi-circle"></i><span>Tambah Data Guru</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link collapsed" href="{{ route('guru.kelola') }}">
                            <i class="bi bi-circle"></i><span>Kelola Data Guru</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Data Guru Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-walikelas-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Data Wali Kelas</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-walikelas-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="nav-link collapsed" href="{{ route('wali_kelas.create') }}">
                            <i class="bi bi-circle"></i><span>Tambah Data Wali Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link collapsed" href="{{ route('wali_kelas.kelola') }}">
                            <i class="bi bi-circle"></i><span>Kelola Data Wali Kelas</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Data Wali Kelas Nav -->
        </ul>
    </aside><!-- End Sidebar -->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Data Wali Kelas</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Tambah Data Wali Kelas</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="container">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Form Tambah/Simpan Data Wali Kelas</h5>
                                @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <form action="{{ route('wali_kelas.store') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="guru_id" class="col-sm-2 col-form-label">Pilih Guru</label>
                                        <div class="col-sm-10">
                                            <select name="guru_id" class="form-select" required>
                                                <option disabled selected>Pilih Guru</option>
                                                @foreach ($guru as $g)
                                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                        <div class="col-sm-10">
                                            <select name="kelas" class="form-select" required>
                                                <option disabled selected>Pilih Kelas</option>
                                                @for ($i = 1; $i <= 6; $i++) <option value="{{ $i }}">Kelas {{ $i }}
                                                    </option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" id="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" id="password" class="form-control" name="password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" class="btn btn-primary w-100">Tambah Wali
                                                Kelas</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======= Footer ======= -->
            <footer id="footer" class="footer">
                <div class="copyright">
                    &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </footer><!-- End Footer -->

            <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                    class="bi bi-arrow-up-short"></i></a>

            <!-- Vendor JS Files -->
            <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
            <script src=" {{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src=" {{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
            <script src=" {{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
            <script src=" {{ asset('assets/vendor/quill/quill.js') }}"></script>
            <script src=" {{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
            <script src=" {{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
            <script src=" {{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

            <!-- Template Main JS File -->
            <script src=" {{ asset('assets/js/main.js') }}"></script>

</body>

</html>