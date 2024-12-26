<?php
session_start();

require 'system/config/db.php';
require_once 'system/admin/tiket.php';
require_once 'system/user/pesanan.php';
require_once 'system/user/topup_system.php';

// validasi jika sudah login langsung di direct
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

$db = Database::getConnect();

$rute = new Tiket($db);
$pesanan = new Pesanan($db);

$lihat_tujuan = $rute->showTiketPublic();

$message = "";

// beli tiket
if (isset($_POST['beli-tiket'])) {
    $balance = new Balance($db, $_SESSION['user_id']);
    $balance = (float) $balance->getBal();

    $user_id = $_SESSION['user_id'];
    $tiket_id = (int) $_POST['id_rute_edit'];
    $jumlah = (int) $_POST['jumlah_tiket'];

    $harga = $rute->showTiketDetail($tiket_id);

    $total = $harga['harga'] * $jumlah;

    if ($balance >= $total) {
        $pesanan->beliTiket($user_id, $tiket_id, $jumlah, $total);
    } else {
        $message = "<script>alert('Uang anda tidak cukup')</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'pelanggan') { ?>
        <title>Dashboard | Ticket-In</title>
    <?php } else { ?>
        <title>Ticket-In</title>
    <?php } ?>

    <link rel="stylesheet" href="public/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
</head>

<body>
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'pelanggan') { ?>
        <?php include 'utils/navbar_login.php' ?>
    <?php } else { ?>
        <?php include 'utils/navbar_user.php' ?>
    <?php } ?>

    <?= $message ?>

    <!-- jumbotron -->
    <section style="margin-top: 57px; background-color: #78B3CE;">
        <div class="container-fluid-lg container-sm pt-sm-2 px-sm-3 pt-md-3 px-md-5 pt-lg-5 px-lg-5">
            <div class="row align-items-center h-100 ps-sm-0">
                <!-- kata kata hari ini 🖐️😮 -->
                <div class="col-sm-12 col-md-6 d-sm-none d-md-flex">
                    <div class="px-5">
                        <h3>Penuhi kebutuhan liburan anda dengan <span class="fw-bold">Ticket-In</span></h3>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="d-flex flex-column align-items-center">
                        <img src="public/assets/bus.png" class="image-width">
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="1" d="M0,64L48,90.7C96,117,192,171,288,170.7C384,171,480,117,576,106.7C672,96,768,128,864,154.7C960,181,1056,203,1152,197.3C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>

    <section class="mb-5" style="background-color: #0099ff;">
        <div class="container py-5">
            <h1 class="text-center text-white fw-bold mb-2">Daftar Tiket</h1>
            <hr>
            <div class="row">
                <div class="overflow-x-auto">
                    <div class="d-flex">
                        <?php foreach ($lihat_tujuan as $data): ?>
                            <div class="col d-flex justify-content-around">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center pb-3"><?= $data['tujuan'] ?></h5>
                                        <p class="card-text">
                                            Harga: Rp. <?= number_format($data['harga'], 0, ",", ".") ?><br>
                                            Stok: <?= $data['stok'] ?><br>
                                            Tanggal: <?= $data['jam_berangkat'] ?>
                                        </p>
                                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#beli-tiket" onclick="getId(<?= $data['tiket_id'] ?>)">
                                            Beli tiket
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#B1F0F7" fill-opacity="1" d="M0,32L30,26.7C60,21,120,11,180,53.3C240,96,300,192,360,197.3C420,203,480,117,540,69.3C600,21,660,11,720,48C780,85,840,171,900,197.3C960,224,1020,192,1080,160C1140,128,1200,96,1260,90.7C1320,85,1380,107,1410,117.3L1440,128L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
        </svg>
    </section>

    <section style="background-color: #B1F0F7;">

    </section>

    <!-- modal beli tiket -->
    <div class="modal fade" id="beli-tiket" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Tiket</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_rute_edit" id="id_rute_edit">
                        <label for="exampleFormControlInput1" class="form-label">Jumlah tiket</label>
                        <input type="text" class="form-control mb-3" name="jumlah_tiket" id="exampleFormControlInput1">
                        <div class="modal-footer">
                            <button type="submit" name="beli-tiket" class="btn btn-success">Beli</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function getId(id) {
            document.getElementById('id_rute_edit').value = id;
        }
    </script>


    <?php include 'utils/bottom.php' ?>