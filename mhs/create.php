<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaMhs = $_POST['namaMhs'];
    $nim = $_POST['nim'];
    $ipk = $_POST['ipk'];

    // Logika otomatis untuk menentukan SKS berdasarkan IPK
    $sks = ($ipk < 3) ? 20 : 24;

    // Periksa apakah NIM sudah ada di database
    $queryCheckNIM = "SELECT * FROM inputmhs WHERE nim = '$nim'";
    $resultCheckNIM = $conn->query($queryCheckNIM);

    if ($resultCheckNIM->num_rows > 0) {
        // Jika NIM sudah ada, kirimkan respon error
        echo json_encode(['status' => 'error', 'message' => 'NIM sudah terdaftar. Silakan gunakan NIM lain.']);
        exit; // Hentikan eksekusi kode
    }

    // Jika NIM belum ada, masukkan data ke database
    $query = "INSERT INTO inputmhs (namaMhs, nim, ipk, sks, matakuliah) VALUES ('$namaMhs', '$nim', '$ipk', '$sks', NULL)";
    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
?>
