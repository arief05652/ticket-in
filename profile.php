<?php
session_start();

require 'system/user/user.php';
require 'system/user/pesanan.php';
require_once 'system/config/db.php';

$db = Database::getConnect();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

$profile = new UserProfile($db);
$pesanan = new Pesanan($db);

$result = $pesanan->lihatPesananProfile($_SESSION['user_id']);

$i = 1;

// update profile
if (isset($_POST['save-update'])) {
    $email = $_POST['email'];
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];

    $profile->ubahProfile($email, $nama_depan, $nama_belakang);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="public/css/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
</head>

<body>
    <?php include './utils/navbar_login.php' ?>

    <!-- show profile -->
    <section style="margin-top: 60px;">
        <div class="jumbotron-height container shadow rounded p-sm-2 p-md-3">
            <div class="d-flex flex-column">
                <div class="d-flex flex-column align-items-center">
                    <img src="public/assets/profile.png" alt="user" class="rounded-circle img-fluid" width="100px;">
                </div>
                <div class="px-5" style="height: 150px;">
                    <div class="d-flex flex-column justify-content-center align-items-start shadow border p-2 px-3 h-100 mb-2">
                        <span class="fs-5">Email: <?= $_SESSION['email'] ?></span>
                        <span class="fs-5">Nama depan: <?= $_SESSION['nama_dpn'] ?></span>
                        <span class="fs-5">Nama belakang: <?= $_SESSION['nama_blkg'] ?></span>
                    </div>
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Ubah informasi
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah informasi pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="was-validated">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="<?= $_SESSION['email'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_dpn" class="form-label">Nama depan:</label>
                            <input type="text" name="nama_depan" class="form-control" id="nama_dpn" placeholder="<?= $_SESSION['nama_dpn'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_blkg" class="form-label">Nama belakang:</label>
                            <input type="text" name="nama_belakang" class="form-control" id="nama_blkg" placeholder="<?= $_SESSION['nama_blkg'] ?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="save-update" data-bs-dismiss="modal" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- pesanan & order -->
    <section style="margin-top: 60px;">
        <div class="container-fluid-sm container-md shadow rounded p-sm-2 p-md-3">
            <h2 class="text-center mb-4">Tiket anda</h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tujuan</th>
                        <th scope="col">Plat</th>
                        <th scope="col">Harga satuan</th>
                        <th scope="col">Jumlah tiket</th>
                        <th scope="col">Total harga</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $data): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data['tujuan'] ?></td>
                            <td><?= $data['plat'] ?></td>
                            <td>Rp. <?= number_format($data['harga'], 0, ",", ".") ?></td>
                            <td><?= $data['jumlah_tiket'] ?></td>
                            <td>Rp. <?= number_format($data['total_harga'], 0, ",", ".") ?></td>
                            <td><?= $data['berangkat'] ?></td>
                            <td>
                                <a href="detail_tiket.php?id=<?= $data['pesanan_id']?>" class="btn btn-danger">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include 'utils/bottom.php' ?>
</body>

</html>