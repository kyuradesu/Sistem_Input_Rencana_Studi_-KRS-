<?php
include '../config/koneksi.php';

$id = $_POST['id']; // Ambil ID dari request

// Hapus data dari tabel jwl_mhs
$queryDelete = "DELETE FROM jwl_mhs WHERE id = $id";
if ($conn->query($queryDelete)) {
    echo "Mata kuliah berhasil dihapus";
} else {
    echo "Gagal menghapus mata kuliah: " . $conn->error;
}
?>
