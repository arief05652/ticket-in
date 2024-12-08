<?php session_start();

require '../system/config/db.php';
require_once '../system/admin/topup.php';

$db = Database::getConnect();

$topup = new Topup($db);

$i = 1;

// menampilkan semua tiket
$show_all_tiket = $topup->lihatDaftar();

// accept topup
if (isset($_POST['terima-topup'])) {
    $topup_id = $_POST['id_rute'];
    $topup->terimaTopup($topup_id);
}

// reject topup
if (isset($_POST['tolak-topup'])) {
    $topup_id = $_POST['id_rute_edit'];
    $topup->tolakTopup($topup_id);
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
            <h4>Data List Topup</h4>
            <div class="">
                <a class="btn btn-warning" href="./dashboard.php" role="button">Dashboard</a>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Jam topup</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($show_all_tiket as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['email']); ?></td>
                            <td>Rp. <?= number_format($data['amount'], 0, ",", "."); ?></td>
                            <td><?= htmlspecialchars($data['waktu_topup']); ?></td>
                            <td>
                                <button type="button" class="btn btn-success mb-sm-1 mb-md-0" data-bs-toggle="modal" data-bs-target="#acceptModal" onclick="getRuteId(<?= $data['topup_id'] ?>)">
                                    <i class="material-symbols-outlined">check</i>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal" onclick="getId(<?= $data['topup_id'] ?>)">
                                    <i class="material-symbols-outlined">close</i>
                                </button>
                            </td>
                        <tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal accept -->
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Terima topup</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin terima topup ini?</p>
                        <input type="hidden" name="id_rute" id="id_rute">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="terima-topup" class="btn btn-success">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tolak topup</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin tolak topup ini?</p>
                        <input type="hidden" name="id_rute_edit" id="id_rute_edit">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tolak-topup" class="btn btn-success">Ya</button>
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