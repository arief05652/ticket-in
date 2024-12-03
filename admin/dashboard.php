<?php
session_start();

require '../system/config/db.php';
require_once '../system/user/user.php';

// validasi jika belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'pelanggan') {
    header('Location: ../index.php');
    exit;
}

$db = Database::getConnect();

// dashboard
$view = new UserProfile($db);

// get data
$total_user = $view->getTotalUser();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/css/index.css">
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

    <!-- apps container -->
    <div class="container rounded p-3">
        <h4 class="mb-3 fw-bold">Apps menu</h4>
        <div class="row w-100 row-gap-3">
            <!-- jadwal -->
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="text-decoration-none text-dark" href="./jadwal.php">
                    <div class="d-flex flex-column align-items-center rounded shadow py-2">
                        <i class="material-symbols-outlined  mb-2" style="font-size: 50px">
                            calendar_month
                        </i>
                        <div class="text-center fw-bold">Jadwal</div>
                    </div>
                </a>
            </div>
            <!-- tiket -->
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="text-decoration-none text-dark" href="./tiket.php">
                    <div class="d-flex flex-column align-items-center rounded shadow py-2">
                        <i class="material-symbols-outlined  mb-2" style="font-size: 50px">
                            confirmation_number
                        </i>
                        <div class="text-center fw-bold">Tiket</div>
                    </div>
                </a>
            </div>
            <!-- bis -->
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="text-decoration-none text-dark" href="./bis.php">
                    <div class="d-flex flex-column align-items-center rounded shadow py-2">
                        <i class="material-symbols-outlined  mb-2" style="font-size: 50px">
                            directions_bus
                        </i>
                        <div class="text-center fw-bold">Bis</div>
                    </div>
                </a>
            </div>
            <!-- rute -->
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="text-decoration-none text-dark" href="./rute.php">
                    <div class="d-flex flex-column align-items-center rounded shadow py-2">
                        <i class="material-symbols-outlined  mb-2" style="font-size: 50px">
                            location_on
                        </i>
                        <div class="text-center fw-bold">Rute</div>
                    </div>
                </a>
            </div>
            <!-- topup -->
            <div class="col-sm-6 col-md-4 col-xl-3">
                <a class="text-decoration-none text-dark" href="./topup.php">
                    <div class="d-flex flex-column align-items-center rounded shadow py-2">
                        <i class="material-symbols-outlined  mb-2" style="font-size: 50px">
                            add_card
                        </i>
                        <div class="text-center fw-bold">Topup</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- bottom bootstrap -->
    <?php include '../utils/bottom.php' ?>
</body>

</html>