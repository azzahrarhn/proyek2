<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tables / Data - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
            <h1>Student Grades Table</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Student Grades</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card"
                        style="overflow-x: auto; padding: 20px; max-height: 100%; width: 100%; min-width: 1500px;">
                        <div class="card-body"
                            style="overflow-x: auto; padding: 40px; max-height: 100%; width: 100%; min-width: 1500px;">
                            <h5 class="card-title">Mata Pelajaran: {{ $mataPelajaran->name }}</h5>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No</th>
                                        <th rowspan="2" class="text-center">Nama Siswa</th>
                                        <th colspan="5" class="text-center">ASESMEN FORMATIF</th>
                                        <th colspan="5" class="text-center">ASESMEN SUMATIF AKHIR LINGKUP MATERI</th>
                                        <th colspan="5" class="text-center">ASESMEN SUMATIF AKHIR SEMESTER *</th>
                                        <th rowspan="2" class="text-center">Nilai Rapor</th>
                                        <th rowspan="2" class="text-center">Grade</th>
                                        <th rowspan="2" class="text-center">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">TP 1</th>
                                        <th class="text-center">TP 2</th>
                                        <th class="text-center">TP 3</th>
                                        <th class="text-center">TP 4</th>
                                        <th class="text-center">TP 5</th>
                                        <th class="text-center">TP 1</th>
                                        <th class="text-center">TP 2</th>
                                        <th class="text-center">TP 3</th>
                                        <th class="text-center">TP 4</th>
                                        <th class="text-center">TP 5</th>
                                        <th class="text-center">TP 1</th>
                                        <th class="text-center">TP 2</th>
                                        <th class="text-center">TP 3</th>
                                        <th class="text-center">TP 4</th>
                                        <th class="text-center">TP 5</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSiswaNilai as $index => $nilai)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $nilai->nama_siswa }}</td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="formatif_tp1">
                                            {{ $nilai->formatif_tp1 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="formatif_tp2">
                                            {{ $nilai->formatif_tp2 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="formatif_tp3">
                                            {{ $nilai->formatif_tp3 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="formatif_tp4">
                                            {{ $nilai->formatif_tp4 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="formatif_tp5">
                                            {{ $nilai->formatif_tp5 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_lingkup_tp1">
                                            {{ $nilai->sumatif_lingkup_tp1 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_lingkup_tp2">
                                            {{ $nilai->sumatif_lingkup_tp2 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_lingkup_tp3">
                                            {{ $nilai->sumatif_lingkup_tp3 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_lingkup_tp4">
                                            {{ $nilai->sumatif_lingkup_tp4 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_lingkup_tp5">
                                            {{ $nilai->sumatif_lingkup_tp5 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_akhir_tp1">
                                            {{ $nilai->sumatif_akhir_tp1 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_akhir_tp2">
                                            {{ $nilai->sumatif_akhir_tp2 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_akhir_tp3">
                                            {{ $nilai->sumatif_akhir_tp3 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_akhir_tp4">
                                            {{ $nilai->sumatif_akhir_tp4 }}
                                        </td>
                                        <td class="edit-nilai" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="sumatif_akhir_tp5">
                                            {{ $nilai->sumatif_akhir_tp5 }}
                                        </td>
                                        <td class="not-editable" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="nilai_rapor">
                                            {{ $nilai->nilai_rapor }}
                                        </td>
                                        <td class="not-editable" data-id="{{ $nilai->id_nilai ?? '' }}"
                                            data-nama="{{ $nilai->nama_siswa }}" data-id_siswa="{{ $nilai->id_siswa }}"
                                            data-field="grade">
                                            {{ $nilai->grade }}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm show-graph"
                                                data-id="{{ $nilai->id_nilai }}">
                                                <i class="bi bi-graph-up"></i> Graph
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Edit Nilai -->
        <div class="modal fade" id="addValueModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Nilai untuk <b id="siswaNamanew"></b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tpValueForm">
                            <input type="hidden" id="nilaiId">
                            <input type="hidden" id="siswaId">
                            <input type="hidden" id="tpField">
                            @foreach ($dataSiswaNilai as $siswa)
                            <input type="hidden" id="namaSiswa-{{ $siswa->id_siswa }}" value="{{ $siswa->nama_siswa }}">
                            @endforeach
                            <input type="hidden" id="idMapel" value="{{ request()->query('id_mapel') }}">
                            <div class="mb-3">
                                <label for="siswaNama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="siswaNama" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tpValue" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="tpValue" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="saveTpValue">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Line Chart -->
        <div class="modal fade" id="graphModal" tabindex="-1" aria-labelledby="graphModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="graphModalLabel">Grafik Nilai Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <canvas id="lineChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".edit-nilai").forEach(function(cell) {
                cell.addEventListener("click", function() {
                    let nilaiId = this.getAttribute("data-id") || '';
                    let siswaNama = this.getAttribute("data-nama");
                    let siswaId = this.getAttribute("data-id_siswa");
                    let field = this.getAttribute("data-field");
                    let nilai = this.innerText.trim();

                    document.getElementById("nilaiId").value = nilaiId;
                    document.getElementById("siswaNama").value =
                        siswaNama; // Pastikan nama siswa diinput
                    document.getElementById("siswaId").value = siswaId;
                    document.getElementById("tpField").value = field;
                    document.getElementById("tpValue").value = nilai;

                    let modal = new bootstrap.Modal(document.getElementById("addValueModal"));
                    modal.show();
                });
            });

            document.getElementById("saveTpValue").addEventListener("click", function() {
                let siswaId = document.getElementById("siswaId")?.value;
                let namaSiswa = document.getElementById("siswaNama")
                    ?.value; // Ambil nama_siswa dari input modal

                let field = document.getElementById("tpField")?.value;
                let nilai = document.getElementById("tpValue")?.value;
                let idMapel = document.getElementById("idMapel")?.value;

                if (!idMapel) {
                    alert("ID Mapel tidak ditemukan! Pilih mata pelajaran terlebih dahulu.");
                    return;
                }

                if (!namaSiswa) {
                    alert("Nama siswa tidak ditemukan! Pastikan nama siswa tersedia.");
                    return;
                }

                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content");

                fetch("/update-nilai", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            id_siswa: siswaId,
                            nama_siswa: namaSiswa, // Kirim nama_siswa ke backend
                            id_mapel: idMapel,
                            field: field,
                            nilai: nilai
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Data berhasil disimpan!");

                            let nilaiCell = document.querySelector(
                                `td[data-id_siswa="${siswaId}"][data-field="${field}"]`);
                            if (nilaiCell) nilaiCell.innerText = nilai;

                            // Perbarui nilai_rapor dan grade secara otomatis
                            let nilaiRaporCell = document.querySelector(
                                `td[data-id_siswa="${siswaId}"][data-field="nilai_rapor"]`);
                            let gradeCell = document.querySelector(
                                `td[data-id_siswa="${siswaId}"][data-field="grade"]`);

                            if (nilaiRaporCell) nilaiRaporCell.innerText = data
                            .nilai_rapor; // Update nilai rapor
                            if (gradeCell) gradeCell.innerText = data.grade; // Update grade

                            let modal = bootstrap.Modal.getInstance(document.getElementById(
                                "addValueModal"));
                            if (modal) modal.hide();
                        } else {
                            alert("Gagal menyimpan data: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan: " + error.message);
                    });
            });
        });
        </script>


        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-nilai").forEach(button => {
                button.addEventListener("click", function() {
                    const nilaiId = this.getAttribute("data-id");

                    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                        fetch(`/nilai/${nilaiId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert(data.message);
                                    location.reload();
                                }
                            })
                            .catch(error => console.error("Error:", error));
                    }
                });
            });
        });
        </script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".show-graph").forEach(button => {
                button.addEventListener("click", function() {
                    const nilaiId = this.getAttribute("data-id");

                    fetch(`/nilai/get-nilai/${nilaiId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateGraph(data.nilai);
                            } else {
                                alert("Gagal mengambil data nilai.");
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });
            });
        });

        function updateGraph(nilai) {
            let labels = [];
            let scores = [];

            for (let i = 1; i <= 5; i++) {
                labels.push(`Formatif TP ${i}`);
                scores.push(nilai[`formatif_tp${i}`] || 0);
            }

            for (let i = 1; i <= 5; i++) {
                labels.push(`Sumatif Lingkup TP ${i}`);
                scores.push(nilai[`sumatif_lingkup_tp${i}`] || 0);
            }

            for (let i = 1; i <= 5; i++) {
                labels.push(`Sumatif Akhir TP ${i}`);
                scores.push(nilai[`sumatif_akhir_tp${i}`] || 0);
            }

            if (window.myChart) {
                window.myChart.destroy();
            }

            const ctx = document.getElementById('lineChart').getContext('2d');
            window.myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nilai Siswa',
                        data: scores,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                }
            });

            new bootstrap.Modal(document.getElementById('graphModal')).show();
        }
        </script>

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
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