<?php
include '../config/koneksi.php';

$mhs_id = $_POST['mahasiswa_id'];
$matakuliah_id = $_POST['matakuliah_id'];

// Query untuk mengambil data mata kuliah
$queryMatkul = "SELECT * FROM jwl_matakuliah WHERE id = $matakuliah_id";
$resultMatkul = $conn->query($queryMatkul);

if ($resultMatkul->num_rows > 0) {
    $matkul = $resultMatkul->fetch_assoc();

    // Insert data ke tabel jwl_mhs
    $queryInsert = "INSERT INTO jwl_mhs (mhs_id, matakuliah, sks, kelp, ruangan)
                    VALUES ($mhs_id, '{$matkul['matakuliah']}', {$matkul['sks']}, '{$matkul['kelp']}', '{$matkul['ruangan']}')";
    if ($conn->query($queryInsert)) {
        echo "Mata kuliah berhasil ditambahkan";
    } else {
        echo "Gagal menambahkan mata kuliah: " . $conn->error;
    }
} else {
    echo "Mata kuliah tidak ditemukan";
}
?>
