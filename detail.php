<?php
session_start();

require 'system/config/db.php';
require_once 'system/admin/tiket.php';
require_once 'system/user/topup_system.php';
require_once 'system/user/pesanan.php';

$db = Database::getConnect();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

$id = $_GET['id'];

$detail = new Tiket($db);
$balance = new Balance($db, $_SESSION['user_id']);
$pesanan = new Pesanan($db);

$tiket = $detail->showTiketUser($id);
$bal = (int) $balance->balance;

$harga = $tiket['harga'];

$message = "";

if (isset($_POST['pesan_tiket'])) {
    $id_tiket = $id;
    $id_user = $_SESSION['user_id'];
    $jumlah = (int) $_POST['jumlah_tiket'];

    $total = $harga * $jumlah;

    if ($bal >= $total) {
        $pesanan->beliTiket($id_user, $id_tiket, $jumlah);
    } else {
        $message = "<script>alert('Saldo anda tidak cukup')</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
</head>

<body>
    <?php include 'utils/navbar_login.php' ?>

    <?= $message ?>

    <section style="margin-top: 100px;">
        <div class="container p-5 rounded shadow">
            <div class="d-flex flex-column">
                <h4>
                    Tiket id: <?= $id ?> <br>
                    Tujuan: <?= $tiket["tujuan"] ?> <br>
                    Jam berangkat: <?= $tiket["jam_berangkat"] ?> <br>
                    Harga: Rp. <?= number_format($tiket["harga"], 0, ",", ".") ?> <br>
                    Penjemputan: <?= $tiket["titik_penjemputan"] ?> <br>
                    Penurunan: <?= $tiket["titik_penurunan"] ?> <br>
                    Merk: <?= $tiket["merk"] ?> <br>
                    Plat nomor: <?= $tiket["plat_nomor"] ?> <br>
                    Stok tiket: <?= $tiket["stok"] ?> <br>
                </h4>

                <form action="" method="post">
                    <label for="exampleFormControlInput1" class="form-label">Jumlah tiket</label>
                    <input type="text" class="form-control mb-3" name="jumlah_tiket" id="exampleFormControlInput1">
                    <button type="submit" class="btn btn-success" name="pesan_tiket">
                        Pesan tiket
                    </button>
                </form>

            </div>
        </div>
    </section>

    <?php include 'utils/bottom.php' ?>
</body>


</html>