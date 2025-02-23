<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin | E-Rapor</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

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
                        <a class="dropdown-item d-flex align-items-center"
                        href="{{ route('admin.profile') }}">
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
            <h1>Mata Pelajaran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Mata Pelajaran</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Input Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Input Mata Pelajaran</h5>
                <form id="subjectForm" action="{{ route('mata_pelajaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="subjectId" name="id"> <!-- Tambahkan input hidden untuk ID -->
                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="subjectName" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan Mata Pelajaran" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <!-- End Input Form -->

        <!-- Black Color Bordered Table -->
        <table class="table table-bordered secondary" id="subjectTable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Mata Pelajaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mata_pelajaran as $index => $subject)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm me-2 edit-btn" data-id="{{ $subject->id }}"
                            data-name="{{ $subject->name }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $subject->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Black Color Bordered Table -->

    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchSubjectsForSidebar(); // Muat data untuk sidebar
        fetchSubjectsForTable(); // Muat data untuk tabel
    });

    // Mengambil daftar mata pelajaran dari database dan menampilkannya di sidebar
    function fetchSubjectsForSidebar() {
        fetch("{{ route('mata_pelajaran.getSubjects.sidebar') }}")
            .then(response => response.json())
            .then(data => {
                const sidebarNav = document.getElementById('nilai-siswa-nav');
                sidebarNav.innerHTML = '';

                data.forEach(subject => {
                    const newNavItem = document.createElement('li');
                    newNavItem.className = 'nav-item';
                    newNavItem.innerHTML = `
                <a class="nav-link collapsed" href="{{ url('nilai') }}?id_mapel=${encodeURIComponent(subject.id)}">
                    <i class="bi bi-circle"></i><span>${subject.name}</span>
                </a>
                `;
                    sidebarNav.appendChild(newNavItem);
                });
            })
            .catch(error => console.error("Error fetching subjects for sidebar:", error));
    }

    document.getElementById("subjectForm").addEventListener("submit", function(e) {
        e.preventDefault(); // Hindari reload halaman

        const subjectId = document.getElementById("subjectId").value; // Ambil ID
        const subjectName = document.getElementById("subjectName").value.trim();
        const mode = document.getElementById("subjectForm").getAttribute("data-mode");

        if (!subjectName) {
            alert("Nama mata pelajaran tidak boleh kosong!");
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Pilih URL dan method berdasarkan mode
        let url = "{{ route('mata_pelajaran.store') }}";
        let method = "POST";
        if (mode === "edit" && subjectId) {
            url = `/admin/mata_pelajaran/${subjectId}`;
            method = "PUT";
        }

        fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    name: subjectName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(mode === "edit" ? "Mata pelajaran berhasil diperbarui!" :
                        "Mata pelajaran berhasil ditambahkan!");
                    fetchSubjectsForSidebar();
                    fetchSubjectsForTable();
                } else {
                    alert("Terjadi kesalahan saat menyimpan data!");
                }
            })
            .catch(error => console.error("Error saving subject:", error));

        document.getElementById("subjectForm").reset();
        document.getElementById("subjectId").value = ""; // Reset ID setelah edit
        document.getElementById("subjectForm").removeAttribute("data-mode"); // Reset mode
    });

    function fetchSubjectsForTable() {
        fetch("{{ route('mata_pelajaran.getSubjects.table') }}")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector("#subjectTable tbody");
                tableBody.innerHTML = ""; // Bersihkan isi tabel sebelum menampilkan data baru

                data.forEach((subject, index) => {
                    const newRow = document.createElement("tr");
                    newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${subject.name}</td>
                    <td>
                        <button class="btn btn-warning btn-sm me-2 edit-btn" data-id="${subject.id}" data-name="${subject.name}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${subject.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                    tableBody.appendChild(newRow);
                });

                // Tambahkan event listener untuk tombol edit dan hapus
                document.querySelectorAll(".edit-btn").forEach(button => {
                    button.addEventListener("click", function() {
                        const subjectId = this.getAttribute("data-id");
                        const subjectName = this.getAttribute("data-name");

                        document.getElementById("subjectName").value = subjectName;
                        document.getElementById("subjectId").value = subjectId; // Set ID untuk edit

                        // Ubah action form untuk update data
                        document.getElementById("subjectForm").setAttribute("data-mode", "edit");
                    });
                });

                document.querySelectorAll(".delete-btn").forEach(button => {
                    button.addEventListener("click", function() {
                        const subjectId = this.getAttribute("data-id");
                        if (!confirm("Apakah Anda yakin ingin menghapus mata pelajaran ini?"))
                            return;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                        fetch(`/admin/mata_pelajaran/${subjectId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": csrfToken
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Mata pelajaran berhasil dihapus!");
                                    fetchSubjectsForSidebar();
                                    fetchSubjectsForTable();
                                } else {
                                    alert("Terjadi kesalahan saat menghapus data!");
                                }
                            })
                            .catch(error => console.error("Error deleting subject:", error));
                    });
                });
            })
            .catch(error => console.error("Error fetching subjects for table:", error));
    }

    function deleteSubject(subjectId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`{{ url('mata_pelajaran') }}/${subjectId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Mata pelajaran berhasil dihapus!");
                    fetchSubjectsForSidebar(); // Perbarui sidebar
                    fetchSubjectsForTable(); // Perbarui tabel
                } else {
                    alert("Terjadi kesalahan saat menghapus data!");
                }
            })
            .catch(error => console.error("Error deleting subject:", error));
    }
    </script>


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
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>