<?php
include '../config/koneksi.php';

// Ambil ID mahasiswa dari URL
$id = $_GET['id'];

// Query untuk mengambil data mahasiswa
$queryMahasiswa = "SELECT * FROM inputmhs WHERE id = $id";
$resultMahasiswa = $conn->query($queryMahasiswa);
$mahasiswa = $resultMahasiswa->fetch_assoc();

// Query untuk mengambil mata kuliah mahasiswa
$queryMatkul = "SELECT * FROM jwl_mhs WHERE mhs_id = $id";
$resultMatkul = $conn->query($queryMatkul);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak KRS</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <style>
        /* CSS untuk menyembunyikan tombol saat mencetak */
        @media print {
            .btn, .alert .btn {
                display: none; /* Sembunyikan semua tombol */
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="text-center">
        <h4>Kartu Rencana Studi</h4>
        <p>Lihat jadwal mata kuliah yang telah ditentukan di sini!</p>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            <strong>Mahasiswa:</strong> <?= $mahasiswa['namaMhs']; ?> | 
            <strong>NIM:</strong> <?= $mahasiswa['nim']; ?> | 
            <strong>IPK:</strong> <?= $mahasiswa['ipk']; ?>
        </div>
        <a href="index.php" class="btn btn-warning">Kembali ke Data Mahasiswa</a>
    </div>

    <!-- Tabel Mata Kuliah -->
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Kelompok</th>
                    <th>Ruangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $totalSKS = 0; // Variabel untuk menghitung total SKS
                while ($row = $resultMatkul->fetch_assoc()):
                    $totalSKS += $row['sks']; // Menambahkan SKS ke total
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $row['matakuliah']; ?></td>
                    <td class="text-center"><?= $row['sks']; ?></td>
                    <td class="text-center"><?= $row['kelp']; ?></td>
                    <td class="text-center"><?= $row['ruangan']; ?></td>
                </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="2" class="text-center"><strong>Total SKS</strong></td>
                    <td class="text-center"><strong><?= $totalSKS; ?></strong></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tombol Cetak PDF -->
    <div class=" mt-2">
        <button onclick="window.print()" class="btn btn-success">Cetak PDF</button>
    </div>
</div>
</body>
</html>
