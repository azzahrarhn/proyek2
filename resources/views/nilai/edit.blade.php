<!-- resources/views/nilai/edit.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai</title>
</head>
<body>
    <h1>Edit Nilai Siswa</h1>

    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Nama Siswa -->
        <label for="biodata_siswa_id">Nama Siswa:</label>
        <select name="biodata_siswa_id" required>
            @foreach ($biodataSiswa as $siswa)
                <option value="{{ $siswa->id }}" @if ($siswa->id == $nilai->biodata_siswa_id) selected @endif>
                    {{ $siswa->nama }}
                </option>
            @endforeach
        </select><br>

        <!-- Mata Pelajaran -->
        <label for="mata_pelajaran_id">Mata Pelajaran:</label>
        <select name="mata_pelajaran_id" required>
            @foreach ($mataPelajaran as $mataPelajaran)
                <option value="{{ $mataPelajaran->id }}" @if ($mataPelajaran->id == $nilai->mata_pelajaran_id) selected @endif>
                    {{ $mataPelajaran->nama }}
                </option>
            @endforeach
        </select><br>

        <!-- Nilai UTS -->
        <label for="nilai_uts">Nilai UTS:</label>
        <input type="number" name="nilai_uts" value="{{ old('nilai_uts', $nilai->nilai_uts) }}"><br>

        <!-- Nilai UAS -->
        <label for="nilai_uas">Nilai UAS:</label>
        <input type="number" name="nilai_uas" value="{{ old('nilai_uas', $nilai->nilai_uas) }}"><br>

        <!-- Nilai Ulangan Harian -->
        <label for="nilai_ulang_harian">Nilai Ulangan Harian:</label>
        <input type="number" name="nilai_ulang_harian" value="{{ old('nilai_ulang_harian', $nilai->nilai_ulang_harian) }}"><br>

        <!-- Nilai Tugas Individu -->
        <label for="nilai_tugas_individu">Nilai Tugas Individu:</label>
        <input type="number" name="nilai_tugas_individu" value="{{ old('nilai_tugas_individu', $nilai->nilai_tugas_individu) }}"><br>

        <!-- Nilai Tugas Kelompok -->
        <label for="nilai_tugas_kelompok">Nilai Tugas Kelompok:</label>
        <input type="number" name="nilai_tugas_kelompok" value="{{ old('nilai_tugas_kelompok', $nilai->nilai_tugas_kelompok) }}"><br>

        <!-- Nilai Tes Lisan -->
        <label for="nilai_tes_lisan">Nilai Tes Lisan:</label>
        <input type="number" name="nilai_tes_lisan" value="{{ old('nilai_tes_lisan', $nilai->nilai_tes_lisan) }}"><br>

        <!-- Nilai Praktikum -->
        <label for="nilai_praktikum">Nilai Praktikum:</label>
        <input type="number" name="nilai_praktikum" value="{{ old('nilai_praktikum', $nilai->nilai_praktikum) }}"><br>

        <!-- Tombol Submit -->
        <button type="submit">Update Nilai</button>
    </form>

    <br>
    <a href="{{ route('nilai.index') }}">Kembali ke Daftar Nilai</a>
</body>
</html>
