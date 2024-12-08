<?php
session_start();

require '../system/config/db.php';
require_once '../system/admin/tiket.php';
require_once '../system/admin/jadwal.php';
require_once '../system/admin/bus.php';

$db = Database::getConnect();

$tiket = new Tiket($db);
$jadwal = new Jadwal($db);

$i = 1;

// get all tiket
$show_all_tiket = $tiket->lihatTiket();
// get jadwal
$jadwal = $jadwal->lihatJadwal();

// tambah jadwal
if (isset($_POST['tambah-tiket'])) {
    $jadwal_id = $_POST['tujuan'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $tiket->tambahTiket($jadwal_id, $harga, $stok);
}

// update jadwal
if (isset($_POST['ubah-visibility'])) {
    $id = $_POST['id_rute'];
    $status = $_POST['status'];

    $tiket->updateStatus($id, $status);
}

// ubah tiket 
if (isset($_POST['edit-tiket'])) {
    $id = $_POST['id_rute_edit'];
    $jadwal_id = $_POST['jadwal'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $tiket->updateTiket($id, $jadwal_id, $harga, $stok);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
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
            <h4>Data Tiket</h4>
            <div class="">
                <a class="btn btn-danger" href="./dashboard.php" role="button">Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah Tiket
                </button>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Plat</th>
                        <th scope="col">Jam berangkat</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($show_all_tiket as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['tujuan']); ?></td>
                            <td><?= htmlspecialchars($data['plat']); ?></td>
                            <td><?= htmlspecialchars($data['jam_berangkat']); ?></td>
                            <td>Rp. <?= number_format($data['harga'], 0, ",", "."); ?></td>
                            <td><?= htmlspecialchars($data['stok']); ?></td>
                            <td><?= htmlspecialchars($data['status']) ?></td>
                            <td>
                                <button type="button" class="btn btn-success mb-sm-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#statusModal" onclick="getRuteId(<?= $data['tiket_id'] ?>)">
                                    <i class="material-symbols-outlined">visibility</i>
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="getId(<?= $data['tiket_id'] ?>)">
                                    <i class="material-symbols-outlined">edit</i>
                                </button>
                            </td>
                        <tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal visibility -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Tiket</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_rute" id="id_rute">
                        <div class="mb-3">
                            <label class="form-label">Status:</label>
                            <select class="form-select" name="status" required>
                                <option value="draft">Draft</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="ubah-visibility" class="btn btn-success">Update status</button>
                        </div>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Tiket</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="merk" class="form-label">Jadwal:</label>
                            <select class="form-select" name="tujuan" required>
                                <option value="">Pilih jadwal</option>
                                <?php foreach ($jadwal as $data): ?>
                                    <option value="<?= $data['jadwal_id'] ?>"><?= htmlspecialchars($data['tujuan']) ?> | <?= htmlspecialchars($data['plat_nomor']) ?> | <?= htmlspecialchars($data['jam_berangkat']) ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga:</label>
                            <input type="text" name="harga" class="form-control" id="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok:</label>
                            <input type="text" name="stok" class="form-control" id="stok" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="tambah-tiket" class="btn btn-success">Tambah</button>
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
                            <label for="merk" class="form-label">Jadwal:</label>
                            <select class="form-select" name="jadwal" required>
                                <option value="">Pilih jadwal</option>
                                <?php foreach ($jadwal as $data): ?>
                                    <option value="<?= $data['jadwal_id'] ?>"><?= htmlspecialchars($data['tujuan']) ?> | <?= htmlspecialchars($data['plat_nomor']) ?> | <?= htmlspecialchars($data['jam_berangkat']) ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga:</label>
                            <input type="text" name="harga" class="form-control" id="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok:</label>
                            <input type="text" name="stok" class="form-control" id="stok" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="edit-tiket" class="btn btn-success">Ubah tiket</button>
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