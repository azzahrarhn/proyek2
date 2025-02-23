<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Charts / Chart.js - NiceAdmin Bootstrap Template</title>
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
            <a href="index" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/sdn.jpg') }}" alt="">
                <span class="d-none d-lg-block">E-Rapot</span>
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
                            <span>Wali Kelas</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('profile_wali_kelas.index') }}">
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
                <a class="nav-link " href="../dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#nilai-siswa-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Nilai Siswa</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="nilai-siswa-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <!-- Daftar Mata Pelajaran akan ditambahkan di sini -->
                </ul>
            </li><!-- End Nilai Siswa Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="../chart/index">
                    <i class="bi bi-bar-chart"></i><span>Chart</span>
                </a>
            </li><!-- End Charts Nav -->
        </ul>
    </aside><!-- End Sidebar -->

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchSubjectsForSidebar();
    });

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
    </script>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Chart</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Charts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Grafik Nilai Rapor Siswa</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#printModal">
                                    <i class="bi bi-printer"></i> Cetak Rapor
                                </button>
                            </div>

                            <!-- Chart Canvas -->
                            <canvas id="lineChart" style="max-height: 400px;"></canvas>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Ambil data dari atribut HTML (tanpa langsung dari PHP)
                                let labels = JSON.parse(document.getElementById("chartLabels").textContent);
                                let data = JSON.parse(document.getElementById("chartData").textContent);

                                if (labels.length === 0 || data.length === 0) {
                                    alert("Tidak ada data untuk ditampilkan!");
                                    return;
                                }

                                const ctx = document.getElementById("lineChart").getContext("2d");

                                if (window.myChart) {
                                    window.myChart.destroy(); // Hapus chart lama sebelum memperbarui
                                }

                                window.myChart = new Chart(ctx, {
                                    type: "bar",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Nilai Rapor",
                                            data: data,
                                            backgroundColor: "rgba(75, 192, 192, 0.5)",
                                            borderColor: "rgb(75, 192, 192)",
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                suggestedMax: 100
                                            }
                                        }
                                    }
                                });
                            });
                            </script>

                            <!-- Data dalam elemen tersembunyi -->
                            <div id="chartLabels" style="display: none;">{!! json_encode($labels) !!}</div>
                            <div id="chartData" style="display: none;">{!! json_encode($data) !!}</div>

                            <h5 class="card-title mt-4">Kualifikasi Nilai Rapor</h5>
                            <canvas id="pieChart" style="max-height: 400px;"></canvas>

                            <!-- Tambahkan Chart.js jika belum ada -->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                console.log("Mengambil data dari API...");

                                fetch("/get-nilai-chart") // API Laravel untuk mendapatkan data dari database
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log("Data dari API:", data);

                                        let ctx = document.getElementById("pieChart").getContext("2d");

                                        // **Hapus chart lama jika ada**
                                        if (typeof window.pieChart !== "undefined" && window
                                            .pieChart instanceof Chart) {
                                            window.pieChart.destroy();
                                        }

                                        // **Buat Pie Chart dengan Data dari Database**
                                        window.pieChart = new Chart(ctx, {
                                            type: "pie",
                                            data: {
                                                labels: ["Baik Sekali (A)", "Baik (B)", "Cukup (C)",
                                                    "Kurang (D & E)"
                                                ],
                                                datasets: [{
                                                    label: "Jumlah Siswa",
                                                    data: [data.baik_sekali, data.baik, data
                                                        .cukup, data.kurang
                                                    ],
                                                    backgroundColor: ["#28a745", "#007bff",
                                                        "#ffc107", "#dc3545"
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                plugins: {
                                                    legend: {
                                                        position: "top"
                                                    }
                                                }
                                            }
                                        });

                                        console.log("Pie Chart berhasil dibuat!");
                                    })
                                    .catch(error => console.error("Gagal mengambil data:", error));
                            });
                            </script>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Pilih Siswa -->
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printModalLabel">Pilih Siswa untuk Cetak Rapor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="printForm" method="GET" action="{{ route('cetak.rapor') }}" target="_blank">
                    <div class="mb-3">
                        <label for="siswaSelect" class="form-label">Pilih Siswa</label>
                        <select class="form-select" name="nama_siswa" id="siswaSelect" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($labels as $siswa)
                                <option value="{{ $siswa }}">{{ $siswa }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        </section>

    </main><!-- End #main -->

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