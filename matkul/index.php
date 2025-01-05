<?php
include '../config/koneksi.php';
$query = "SELECT * FROM jwl_matakuliah";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Mata Kuliah</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<div class="container mt-5">
    <!-- Form Tambah Matkul -->
    <div class="text-center mt-5">
        <h4 class="mt-5">Sistem Input Rencana Studi (KRS)</h4>
        <p>Input data matkul disini</p>
    </div>
    <form id="formMatkul" class="mt-4">
        <div class="form-group">
            <label for="matakuliah">Mata Kuliah</label>
            <input type="text" class="form-control" name="matakuliah" id="matakuliah" required>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sks">SKS</label>
                    <input type="number" class="form-control" name="sks" id="sks" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="kelp">Kelompok</label>
                    <input type="text" class="form-control" name="kelp" id="kelp" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ruangan">Ruangan</label>
                    <input type="text" class="form-control" name="ruangan" id="ruangan" required>
                </div>
            </div>
        </div>
        
        <button type="button" class="btn btn-primary btn-block btn-create w-100 mt-2">Input Matkul</button>
    </form>

    <div class="table-responsive">
        <table id="matakuliahTable" class="table table-striped">
            <thead>
                <tr >
                    <th class="text-center" style="width: 5%;">No</th>
                    <th class="text-center">Mata Kuliah</th>
                    <th class="text-center">SKS</th>
                    <th class="text-center">Kelompok</th>
                    <th class="text-center">Ruangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $row['matakuliah']; ?></td>
                        <td class="text-center"><?= $row['sks']; ?></td>
                        <td><?= $row['kelp']; ?></td>
                        <td><?= $row['ruangan']; ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id']; ?>">Hapus</button>
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
        $('#matakuliahTable').DataTable();

        // Event listener untuk tombol tambah mahasiswa
        $('.btn-create').on('click', function (e) {
            e.preventDefault();

            // Ambil data dari form
            let formData = {
                matakuliah: $('#matakuliah').val(),
                sks: $('#sks').val(),
                kelp: $('#kelp').val(),
                ruangan: $('#ruangan').val(),
            };

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: 'create.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Data matkul berhasil ditambahkan',
                        icon: 'success'
                    }).then(() => {
                        window.location.reload(); // Reload halaman setelah sukses
                    });
                },
                error: function () {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Data matkul gagal ditambahkan',
                        icon: 'error'
                    });
                }
            });
        });


        // Event listener untuk hapus
        $('.btn-delete').on('click', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete.php',
                        type: 'GET',
                        data: { id: id },
                        success: function(response) {
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Data berhasil dihapus',
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Gagal',
                                text: 'Data gagal dihapus',
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
