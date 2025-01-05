<?php
include '../config/koneksi.php';

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Query data mahasiswa berdasarkan ID
$queryMahasiswa = "SELECT * FROM inputmhs WHERE id = $id";
$resultMahasiswa = $conn->query($queryMahasiswa);
$mahasiswa = $resultMahasiswa->fetch_assoc();

// Query semua mata kuliah
$queryMatkul = "SELECT * FROM jwl_matakuliah";
$resultMatkul = $conn->query($queryMatkul);

// Query mata kuliah yang sudah diambil oleh mahasiswa
$queryKRS = "SELECT * FROM jwl_mhs WHERE mhs_id = $id";
$resultKRS = $conn->query($queryKRS);

// Periksa apakah query berhasil
if (!$resultKRS) {
    die("Query gagal: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Krs Mahasiswa</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<div class="container mt-5">
    <h4 class="text-center">Sistem Input Kartu Rencana Studi (KRS)</h4>
    <p class="text-center">Input data krs disini</p>
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            <strong>Mahasiswa:</strong> <?= $mahasiswa['namaMhs']; ?> | 
            <strong>NIM:</strong> <?= $mahasiswa['nim']; ?> | 
            <strong>IPK:</strong> <?= $mahasiswa['ipk']; ?>
        </div>
        <a href="index.php" class="btn btn-warning">Kembali ke Data Mahasiswa</a>
    </div>

    <form id="formTambahMatkul" class="mt-3">
        <div class="form-group">
            <label for="matakuliah">Mata Kuliah</label>
            <select name="matakuliah" id="matakuliah" class="form-control" required>
                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                <?php while ($matkul = $resultMatkul->fetch_assoc()): ?>
                    <option value="<?= $matkul['id']; ?>">
                        <?= $matkul['matakuliah']; ?> (<?= $matkul['sks']; ?> SKS)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="button" class="btn btn-primary btn-block btn-tambah mt-2 w-100">Tambah Mata Kuliah</button>
    </form>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Kelompok</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultKRS->num_rows > 0): ?>
                    <?php $no = 1; while ($krs = $resultKRS->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $krs['matakuliah']; ?></td>
                            <td><?= $krs['sks']; ?></td>
                            <td><?= $krs['kelp']; ?></td>
                            <td><?= $krs['ruangan']; ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-hapus" data-id="<?= $krs['id']; ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada mata kuliah yang diambil</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>



</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/datatables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Tambah Mata Kuliah
    $('.btn-tambah').on('click', function() {
        let formData = {
            mahasiswa_id: <?= $id; ?>,
            matakuliah_id: $('#matakuliah').val()
        };

        $.ajax({
            url: 'tambah_krs.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Sukses',
                    text: response,
                    icon: 'success'
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Mata kuliah gagal ditambahkan',
                    icon: 'error'
                });
            }
        });
    });

    // Hapus Mata Kuliah
    $('.btn-hapus').on('click', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus mata kuliah ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'hapus_krs.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        Swal.fire({
                            title: 'Sukses',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Mata kuliah gagal dihapus',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

</script>

</body>
</html>

