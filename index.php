<?php
session_start();

// validasi jika sudah login langsung di direct
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
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

    <!-- jumbotron -->
    <section style="margin-top: 57px; background-color: #78B3CE;">
        <div class="jumbotron-height container-fluid-lg container-sm py-sm-2 px-sm-3 py-md-3 px-md-5 py-lg-5 px-lg-5">
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
                                        <input type="date" class="form-control" name="tanggal">
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