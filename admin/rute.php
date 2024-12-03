<?php
session_start();

require '../system/config/db.php';
require_once '../system/admin/rute.php';

$db = Database::getConnect();

$rute = new Rute($db);

$i = 1;

// get all rute
$result = $rute->lihatRute();

// edit rute
if (isset($_POST['edit-rute'])) {
    $id = $_POST['id_rute_edit'];
    $tujuan = $_POST['tujuan'];
    $jemput = $_POST['jemput'];
    $turun = $_POST['turun'];

    $rute->ubahRute(id: $id, tujuan: $tujuan, penurunan: $turun, penjemputan: $jemput);
}

// hapus rute
if (isset($_POST['hapus-rute'])) {
    $id = $_POST['id_rute'];
    $rute->hapusRute($id);
}

// tambah rute
if (isset($_POST['tambah-rute'])) {
    $tujuan = $_POST['tujuan'];
    $turun = $_POST['turun'];
    $jemput = $_POST['jemput'];

    $rute->tambahRute(tujuan: $tujuan, penurunan: $turun, penjemputan: $jemput);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <!-- navbar -->
    <div class="container-fluid d-flex justify-content-center border shadow rounded" style="height: 3rem;">
        <div class="d-flex align-items-center px-5 w-100 justify-content-between">
            <span class="fw-bold fs-5">Halo 👋 <?= htmlspecialchars($_SESSION['email']) ?></span>
            <a class="btn btn-primary" href="../logout.php" role="button">Logout</a>
        </div>
    </div>

    <!-- form rute -->
    <div class="container mt-5">
        <div class="d-flex px-2 align-items-center justify-content-between mb-3">
            <h4>Data rute</h4>
            <div class="">
                <a class="btn btn-danger" href="./dashboard.php" role="button">Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah rute
                </button>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Penjemputan</th>
                        <th scope="col">Penurunan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['tujuan']); ?></td>
                            <td><?= htmlspecialchars($data['titik_penjemputan']); ?></td>
                            <td><?= htmlspecialchars($data['titik_penurunan']); ?></td>
                            <td>
                                <button type="button" class="btn btn-danger mb-sm-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="getRuteId(<?= $data['rute_id'] ?>)">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="getId(<?= $data['rute_id'] ?>)">
                                    <i class="material-symbols-outlined">edit</i>
                                </button>
                            </td>
                        <tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal hapus -->
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus rute</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus rute ini?</p>
                        <input type="hidden" name="id_rute" id="id_rute">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="hapus-rute" class="btn btn-danger">Ya Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah rute</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan:</label>
                            <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Masukan tujuan. Contoh: Karawang - Bandung" required>
                        </div>
                        <div class="mb-3">
                            <label for="jemput" class="form-label">Titik penjemputan:</label>
                            <textarea class="form-control" name="jemput" placeholder="Masukan titik penjemputan" required style="height: 100px"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="turun" class="form-label">Titik penurunan:</label>
                            <textarea class="form-control" name="turun" placeholder="Masukan titik penurunan" required style="height: 100px"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="tambah-rute" class="btn btn-success">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah rute</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <input type="hidden" name="id_rute_edit" id="id_rute_edit">
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan:</label>
                            <input type="text" name="tujuan" class="form-control" id="edit-tujuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jemput" class="form-label">Titik penjemputan:</label>
                            <textarea class="form-control" name="jemput" id="edit-jemput" required style="height: 100px"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="turun" class="form-label">Titik penurunan:</label>
                            <textarea class="form-control" name="turun" id="edit-turun" required style="height: 100px"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="edit-rute" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function getRuteId(id) {
            document.getElementById('id_rute').value = id;
        }

        function getId(id) {
            document.getElementById('id_rute_edit').value = id;
        }
    </script>

    <?php include '../utils/bottom.php' ?>
</body>

</html>