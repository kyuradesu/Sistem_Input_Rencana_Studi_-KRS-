<?php
include '../config/koneksi.php';

// Query untuk menampilkan mahasiswa dan satu mata kuliah
$query = "
    SELECT 
        inputmhs.id, 
        inputmhs.namaMhs, 
        inputmhs.nim, 
        inputmhs.ipk, 
        inputmhs.sks,
        (
            SELECT jwl_mhs.matakuliah 
            FROM jwl_mhs 
            WHERE jwl_mhs.mhs_id = inputmhs.id 
            LIMIT 1
        ) AS matakuliah
    FROM inputmhs
";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Mahasiswa</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<div class="container mt-5">

    <!-- Form Tambah Mahasiswa -->
    <div class="text-center mt-5">
        <h4 class="mt-5">Sistem Input Rencana Studi (KRS)</h4>
        <p>Input data mahasiswa disini</p>
    </div>
    
    <form id="formTambahMahasiswa" class="mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="namaMhs">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="namaMhs" id="namaMhs" placeholder="Masukkan Nama Mahasiswa" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" placeholder="Masukkan NIM" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group ">
                    <label for="ipk">IPK</label>
                    <input type="number" step="0.01" class="form-control" name="ipk" id="ipk" placeholder="Masukkan IPK" required>
                </div>
            </div>
            
        </div>
        <button type="button" class="btn btn-primary btn-block btn-create w-100 mt-2">Input Mahasiswa</button>
    </form>


    <div class="table-responsive">
        <table id="mahasiswaTable" class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">IPK</th>
                    <th class="text-center">SKS Maksimal</th>
                    <th class="text-center">Matkul yang Diambil</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody >
                <?php $no = 1; // Variabel untuk nomor urut
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= $row['namaMhs']; ?></td>
                        <td class="text-center"><?= $row['ipk']; ?></td>
                        <td class="text-center"><?= $row['sks']; ?></td>
                        <td class="text-center"><?= !empty($row['matakuliah']) ? $row['matakuliah'] : '-'; ?></td>
                        <td class="text-center">
                            <a href="krs.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id']; ?>">Hapus</button>
                            <a href="cetak_krs.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">Lihat</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
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
        $('#mahasiswaTable').DataTable();

        // Event listener untuk tombol tambah mahasiswa
        $('.btn-create').on('click', function (e) {
            e.preventDefault();

            // Ambil data dari form
            let formData = {
                namaMhs: $('#namaMhs').val(),
                nim: $('#nim').val(),
                ipk: $('#ipk').val(),
            };

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: 'create.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Pastikan response adalah JSON
                success: function (response) {
                    if (response.status === 'success') {
                        // Jika sukses, tampilkan pesan berhasil
                        Swal.fire({
                            title: 'Sukses',
                            text: response.message,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload(); // Reload halaman setelah sukses
                        });
                    } else if (response.status === 'error') {
                        // Jika gagal (NIM duplikat atau kesalahan lainnya), tampilkan pesan error
                        Swal.fire({
                            title: 'Gagal',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function () {
                    // Jika ada kesalahan pada request AJAX
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                        icon: 'error'
                    });
                }
            });
        });



        // Event listener untuk tombol hapus
        $('.btn-delete').on('click', function () {
            let id = $(this).data('id'); // Ambil ID mahasiswa dari atribut data-id

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data mahasiswa ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request DELETE ke server menggunakan AJAX
                    $.ajax({
                        url: 'delete.php',
                        type: 'GET',
                        data: { id: id }, // Kirim ID ke delete.php
                        success: function (response) {
                            // Tampilkan SweetAlert sukses jika berhasil
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Data mahasiswa berhasil dihapus',
                                icon: 'success'
                            }).then(() => {
                                // Reload halaman setelah sukses
                                window.location.reload();
                            });
                        },
                        error: function () {
                            // Tampilkan SweetAlert error jika gagal
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Data mahasiswa gagal dihapus',
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
