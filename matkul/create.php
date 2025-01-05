<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matakuliah = $_POST['matakuliah'];
    $sks = $_POST['sks'];
    $kelp = $_POST['kelp'];
    $ruangan = $_POST['ruangan'];

    $query = "INSERT INTO jwl_matakuliah (matakuliah, sks, kelp, ruangan) VALUES ('$matakuliah', '$sks', '$kelp', '$ruangan')";
    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data gagal ditambahkan: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
?>
