<?php
session_start();

require 'system/config/db.php';
require_once 'system/admin/topup.php';

$i = 1;

$db = Database::getConnect();

$topup = new Topup($db);

$result = $topup->lihatTopup($_SESSION['user_id']);

if (isset($_POST['submit-topup'])) {
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];
    $balance_id = $_SESSION['user_id'];

    $topup->tambahTopup($amount, $user_id, $balance_id);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topup</title>
    <link rel="stylesheet" href="public/css/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined">
</head>

<body>
    <?php include './utils/navbar_login.php' ?>

    <!-- topup -->
    <div class="container mt-5" style="margin-top: 6rem !important;">
        <div class="d-flex px-2 align-items-center justify-content-between mb-3">
            <h4>Data topup</h4>
            <div class="">
                <a class="btn btn-danger" href="./dashboard.php" role="button">Dashboard</a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#topupModal">
                    Topup
                </button>
            </div>
        </div>
        <div class="rounded border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Waktu topup</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $data): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>Rp. <?= number_format($data['amount'], 0, ",", "."); ?></td>
                            <td><?= htmlspecialchars($data['waktu_topup']); ?></td>
                            <td><?= htmlspecialchars($data['status']); ?></td>
                        <tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal topup -->
    <div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Topup</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_rute_edit" id="id_rute_edit">
                        <label for="exampleFormControlInput1" class="form-label">Jumlah topup</label>
                        <input type="text" class="form-control mb-3" name="amount" id="exampleFormControlInput1" placeholder="Contoh: 10000">
                        <div class="modal-footer">
                            <button type="submit" name="submit-topup" class="btn btn-success">Sumbit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function getRuteId(id) {
            document.getElementById("id_rute_edit").value = id;
        }
    </script>

    <?php include 'utils/bottom.php' ?>