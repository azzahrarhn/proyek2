<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f4f4f4; 
        }
        .container { 
            width: 90%; 
            max-width: 800px; 
            margin: 20px auto; 
            padding: 20px; 
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        h2, h4 {
            color: #333;
            text-align: center;
        }
        .biodata {
            margin-bottom: 20px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            font-size: 16px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            background: #fff;
        }
        th, td { 
            border: 1px solid #ddd; 
            text-align: center; 
            padding: 12px; 
        }
        th { 
            background: #007bff; 
            color: white; 
        }
        .btn-print { 
            text-align: center; 
            margin-top: 20px; 
        }
        .btn-print button { 
            background: #007bff; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer; 
        }
        .btn-print button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Laporan Nilai Rapor</h2>
        </div>

        <!-- Biodata Siswa -->
        <div class="biodata">
            <p><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
            <p><strong>Wali Kelas:</strong> {{ $waliKelas }}</p>
        </div>

        <!-- Tabel Nilai -->
        <h4>Nilai Mata Pelajaran</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai Rapor</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nilaiSiswa as $index => $nilai)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nilai->nama_mapel }}</td> 
                    <td>{{ $nilai->nilai_rapor }}</td>
                    <td>{{ $nilai->grade }}</td>
                </tr>
                @endforeach

                <!-- Baris Total Nilai Rapor & Grade Akhir -->
                <tr>
                    <td colspan="2"><strong>Total Nilai Rapor</strong></td>
                    <td colspan="2"><strong>{{ $totalNilai }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Grade Akhir</strong></td>
                    <td colspan="2"><strong>{{ $grade }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol Cetak -->
        <div class="btn-print">
            <button onclick="window.print()"><i class="bi bi-printer"></i> Cetak Rapor</button>
        </div>
    </div>

</body>
</html>
