<?php
session_start();

require 'system/user/user.php';
require_once 'system/config/db.php';

$db = Database::getConnect();

// validasi jika sudah login langsung di direct
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'pelanggan') {
    header('Location: index.php');
    exit;
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil dari form
    $email = $_POST['email'];
    $nama_depan = $_POST['nama-depan'];
    $nama_belakang = $_POST['nama-belakang'];
    $password = $_POST['password'];
    $re_type = $_POST['re-type'];

    if ($password !== $re_type) {
        $message = "Harap masukan password dengan benar";
    } else {
        $register = new User(
                email: $email, 
                password: $password, 
                nama_depan: $nama_depan, 
                nama_belakang: $nama_belakang
            );
        $register->register($db);
        $message = $register->message;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Ticket-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'utils/auth_navbar.php'; ?>

    <!-- FORM REGISTER -->
    <div class="container-fluid-sm container-md mt-5">
        <div class="d-flex justify-content-center px-sm-0 px-lg-5 py-5">
            <div class="w-75 border rounded shadow-lg px-sm-2 px-md-3 py-sm-0 py-md-1 px-lg-5">
                <div class="d-flex flex-column">
                    <div class="lead text-center mb-2 pt-3">
                        Register | Ticket-In
                    </div>

                    <!-- notif pesan -->
                    <div class="d-flex justify-content-center">
                        <span class="pt-2"><?= $message ?></span>
                    </div>

                    <form action="" method="post" class="was-validated">
                        <!-- email -->
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <!-- nama depan -->
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Nama depan:</label>
                            <input type="text" name="nama-depan" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <!-- nama belakang -->
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Nama belakang:</label>
                            <input type="text" name="nama-belakang" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <!-- password -->
                        <div class="mb-2">
                            <label for="exampleInputPassword" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword" required>
                        </div>
                        <!-- re-type password -->
                        <div class="mb-4">
                            <label for="exampleInputPassword" class="form-label">Re-type password:</label>
                            <input type="password" name="re-type" class="form-control" id="exampleInputPassword" required>
                        </div>
                        <!-- button -->
                        <div class="mb-4">
                            <button class="btn btn-success w-100" type="submit" name="daftar">Daftar</button>
                        </div>
                        <div class="text-center">
                            <p>Sudah punya akun? <a href="login.php">klik disini</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>