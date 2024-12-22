<?php
session_start();

require '../system/config/db.php';
require_once '../system/admin/bus.php';

$db = Database::getConnect();

$bis = new Bis($db);
$i = 1;
// get all bis
$result = $bis->lihatBis();

// edit bis
if (isset($_POST['edit-bis'])) {
    $id = $_POST['id_rute_edit'];
    $merk = $_POST['merk'];
    $plat = $_POST['plat'];
    $kapasitas = $_POST['kapasitas'];
    $bis->ubahBis(id: $id, merk: $merk, kapasitas: $kapasitas, plat: $plat);
}

// tambah bis
if (isset($_POST['tambah-bis'])) {
    $merk = $_POST['merk'];
    $plat = $_POST['plat'];
    $kapasitas = $_POST['kapasitas'];
    $bis->tambahBis(merk: $merk, kapasitas: $kapasitas, plat: $plat);
}

// hapus bis
if (isset($_POST['hapus-bis'])) {
    $id = $_POST['id_rute'];
    $bis->hapusBis($id);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <!-- navbar -->
    <div class="container-fluid d-flex justify-content-center border shadow rounded" style="height: 3rem;">
        <div class="d-flex align-items-center px-5 w-100 justify-content-between">
            <span class="fw-bold fs-5">Halo 👋 <?= $_SESSION['email'] ?></span>
            <a class="btn btn-primary" href="../logout.php" role="button">Logout</a>
        </div>
    </div>
    
    <!-- form rute -->
    <div class="container mt-5">
        <div class="d-flex px-2 align-items-center justify-content-between mb-3">
            <h4>Data Bis</h4>
            <div class="">
                <a class="btn btn-danger" href="./dashboard.php" role="button">Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah bis
                </button>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Kapasitas</th>
                        <th scope="col">Plat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['merk']); ?></td>
                            <td><?= htmlspecialchars($data['kapasitas']); ?></td>
                            <td><?= htmlspecialchars($data['plat_nomor']); ?></td>
                            <td>
                                <button type="button" class="btn btn-danger mb-sm-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="getRuteId(<?= $data['bis_id'] ?>)">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="getId(<?= $data['bis_id'] ?>)">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus bis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus bis ini?</p>
                        <input type="hidden" name="id_rute" id="id_rute">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="hapus-bis" class="btn btn-danger">Ya Hapus</button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah bis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk:</label>
                            <input type="text" name="merk" class="form-control" id="merk" placeholder="Contoh: Hyundai" required>
                        </div>
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas:</label>
                            <input type="text" name="kapasitas" class="form-control" id="kapasitas" placeholder="Contoh: 20" required>
                        </div>
                        <div class="mb-3">
                            <label for="plat" class="form-label">Plat nomor:</label>
                            <input type="text" name="plat" class="form-control" id="plat" placeholder="Contoh: AB 2241 C" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="tambah-bis" class="btn btn-success">Tambah</button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah bis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <input type="hidden" name="id_rute_edit" id="id_rute_edit">
                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk:</label>
                            <input type="text" name="merk" class="form-control" id="merk" placeholder="Contoh: Hyundai" required>
                        </div>
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas:</label>
                            <input type="text" name="kapasitas" class="form-control" id="kapasitas" placeholder="Contoh: 20" required>
                        </div>
                        <div class="mb-3">
                            <label for="plat" class="form-label">Plat nomor:</label>
                            <input type="text" name="plat" class="form-control" id="plat" placeholder="Contoh: AB 2241 C" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="edit-bis" class="btn btn-primary">Simpan Perubahan</button>
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