<?php
session_start();

require '../system/config/db.php';
require_once '../system/admin/jadwal.php';
require_once '../system/admin/rute.php';
require_once '../system/admin/bus.php';

$db = Database::getConnect();

$jadwal = new Jadwal($db);
$rute = new Rute($db);
$bus = new Bis($db);

$i = 1;

// get all jadwal
$show_all_jadwal = $jadwal->lihatJadwal();
// get rute tujuan
$tujuan = $rute->lihatRute();
// get bis
$bis = $bus->lihatMerk();

// tambah jadwal
if (isset($_POST['tambah-jadwal'])) {
    $id_rute = $_POST['tujuan'];
    $id_bis = $_POST['bis'];
    $jam_berangkat = $_POST['jam_berangkat'];

    $jadwal->tambahJadwal(id_rute: $id_rute, id_bis: $id_bis, jam_berangkat: $jam_berangkat);
}

// ubah jadwal 
if (isset($_POST['edit-jadwal'])) {
    $id = $_POST['id_rute_edit'];
    $id_rute = $_POST['tujuan'];
    $id_bis = $_POST['bis'];
    $jam_berangkat = $_POST['jam_berangkat'];

    $jadwal->ubahJadwal(id: $id, id_rute: $id_rute, id_bis: $id_bis, jam_berangkat: $jam_berangkat);
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
            <h4>Data Jadwal</h4>
            <div class="">
                <a class="btn btn-danger" href="./dashboard.php" role="button">Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah Jadwal
                </button>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Plat</th>
                        <th scope="col">Berangkat</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($show_all_jadwal as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['tujuan']); ?></td>
                            <td><?= htmlspecialchars($data['merk']); ?></td>
                            <td><?= htmlspecialchars($data['plat_nomor']); ?></td>
                            <td><?= htmlspecialchars($data['jam_berangkat']); ?></td>
                            <td><?= htmlspecialchars($data['status']) ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="getId(<?= $data['jadwal_id'] ?>)">
                                    <i class="material-symbols-outlined">edit</i>
                                </button>
                            </td>
                        <tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Jadwal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="merk" class="form-label">Tujuan:</label>
                            <select class="form-select" name="tujuan" required>
                                <option value="">Pilih rute tujuan</option>
                                <?php foreach ($tujuan as $data): ?>
                                    <option value="<?= $data['rute_id'] ?>"><?= htmlspecialchars($data['tujuan']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Bis:</label>
                            <select class="form-select" name="bis" required>
                                <option value="">Pilih bis</option>
                                <?php foreach ($bis as $data): ?>
                                    <option value="<?= $data['bis_id'] ?>"><?= htmlspecialchars($data['merk']) ?> | <?= htmlspecialchars($data['plat_nomor']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="plat" class="form-label">Jam berangkat:</label>
                            <input type="datetime-local" id="plat" name="jam_berangkat" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="tambah-jadwal" class="btn btn-success">Tambah</button>
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
                            <label for="merk" class="form-label">Tujuan:</label>
                            <select class="form-select" name="tujuan" required>
                                <option value="">Pilih rute tujuan</option>
                                <?php foreach ($tujuan as $data): ?>
                                    <option value="<?= $data['rute_id'] ?>"><?= htmlspecialchars($data['tujuan']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kapasitas" class="form-label">Bis:</label>
                            <select class="form-select" name="bis" required>
                                <option value="">Pilih bis</option>
                                <?php foreach ($bis as $data): ?>
                                    <option value="<?= $data['bis_id'] ?>"><?= htmlspecialchars($data['merk']) ?> | <?= htmlspecialchars($data['plat_nomor']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="plat" class="form-label">Jam berangkat:</label>
                            <input type="datetime-local" id="plat" name="jam_berangkat" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="edit-jadwal" class="btn btn-success">Simpan Perubahan</button>
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