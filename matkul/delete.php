<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM jwl_matakuliah WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data gagal dihapus: ' . $conn->error]);
    }
}
?>
