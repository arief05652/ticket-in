<?php
session_start();

require 'system/config/db.php';
require_once 'system/admin/tiket.php';

// validasi jika sudah login langsung di direct
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

$db = Database::getConnect();

$rute = new Tiket($db);

$lihat_tujuan = $rute->showTiketPublic();

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
        <div class="container pb-5">
            <div class="row">
                <div class="col-xxl-12">
                    <!-- list ketersediaan ticket -->
                    <div class="rounded bg-light-subtle d-flex flex-column align-items-center mb-4">
                        <h2>Tickets Available</h2>
                    </div>
                </div>


                <div class="overflow-x-auto">
                    <div class="d-flex">
                        <?php foreach ($lihat_tujuan as $data): ?>
                            <div class="col d-flex justify-content-around">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><?= $data['tujuan'] ?></h5>
                                        <p class="card-text lead">
                                            Rp. <?= number_format($data['harga'], 0, ",", ".") ?><br>
                                            Stok: <?= $data['stok'] ?><br>
                                            <?= $data['jam_berangkat'] ?>
                                        </p>
                                        <a class="btn btn-primary w-100" href="detail.php?id=<?= $data['tiket_id'] ?>" role="button">Pesan tiket</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>



            </div>
        </div>
    </section>


    <!-- service -->
    <!-- <section>
        <div class="service-height container-fluid-sm container-md py-3">
            <div class="row">

                <div class="col-sm-12 col-md-6 mb-sm-2">
                    <div class="border shadow-lg rounded py-4">
                        <div class="d-sm-flex">
                            <div class="w-50 lead align-self-center text-center">
                                Pembelian secara online
                            </div>
                            <div class="w-50 d-flex justify-content-center">
                                <img src="public/assets/costumer-service.png" width="50%" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="border shadow-lg rounded py-4">
                        <div class="d-sm-flex">
                            <div class="w-50 lead align-self-center text-center">
                                Pembelian secara online
                            </div>
                            <div class="w-50 d-flex justify-content-center">
                                <img src="public/assets/costumer-service.png" width="50%" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> -->


    <?php include 'utils/bottom.php' ?>