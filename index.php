<?php
session_start();

// tanggal
$min_date = date('Y-m-d', strtotime('-2 days'));
$max_date = date('Y-m-d', strtotime('+3 days'));

if (isset($_POST['masuk'])) {
    header("Location: login.php");
} else if (isset($_POST['daftar'])) {
    header("Location: register.php");
} elseif (isset($_POST['cari-ticket'])) {
    header("Location: schedule.php");
}

/**
 * $_POST['kota-asal']
 * $_POST['kota-tujuan']
 * $_POST['schedule']
 */

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket-In</title>
    <link rel="stylesheet" href="public/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg border-bottom bg-body-secondary fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Ticket-In</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto me-3 mb-md-2 mb-sm-2 mb-lg-0 mt-md-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About</a>
                    </li>
                </ul>
                <form class="d-flex mb-md-3 mb-lg-0" action="" method="POST">
                    <button class="btn btn-primary me-lg-2 me-md-2 me-sm-1 me-xs-1" type="submit" name="masuk">Masuk</button>
                    <button class="btn btn-success" type="submit" name="daftar">Daftar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- jumbotron -->
    <section style="margin-top: 57px; background-color: #78B3CE;">
        <div class="jumbotron-height container-fluid-sm container-md py-sm-2 px-sm-3 py-md-3 px-md-5 py-lg-5 px-lg-5">
            <div class="row align-items-center h-100">

                <!-- slogan -->
                <div class="h-75 slogan-hidden col-sm-12 col-lg-6">
                    <div class="pt-md-4 px-5">
                        <div class="text-center">
                            <h3>Penuhi kebutuhan liburan anda dengan <span class="fw-bold">Ticket-In</span> </h3>
                        </div>
                    </div>
                </div>

                <!-- search -->
                <div class="col-sm-12 col-lg-6">
                    <div class="shadow-lg bg-light-subtle rounded border p-2">
                        <div class="d-flex flex-column">

                            <!-- text ticket -->
                            <div class="text-center pt-1 rounded mb-3" style="background-color: #B3C8CF;">
                                <h5>Cari ticket disini</h5>
                            </div>

                            <form action="" method="post">

                                <!-- input group -->
                                <div class="d-flex flex-column rounded justify-content-around mb-sm-3" style="height: 150px;">
                                    <!-- kota asal -->
                                    <div class="px-5">
                                        <input type="email" class="form-control" placeholder="Kota asal" name="asal">
                                    </div>
                                    <!-- kota tujuan -->
                                    <div class="px-5">
                                        <input type="email" class="form-control" placeholder="Kota tujuan" name="tujuan">
                                    </div>
                                    <!-- tanggal -->
                                    <div class="px-5">
                                        <input type="date" min="<?= $min_date ?>" max="<?= $max_date ?>" class="form-control" name="tanggal">
                                    </div>
                                </div>

                                <!-- button -->
                                <div class="d-flex justify-content-center rounded px-5 py-2 mb-sm-3">
                                    <button class="btn btn-success w-100" type="submit" name="cari-ticket">Cari tiket</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- service -->
    <section>
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
    </section>


    <?php include 'utils/bottom.php' ?>