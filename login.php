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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $login = new User($email, $pass);
    $login->login($db);
    $message = $login->message;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ticket-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'utils/auth_navbar.php' ?>

    <!-- FORM LOGIN -->
    <div class="container-fluid-sm container-md mt-5">
        <div class="d-flex justify-content-center px-sm-0 px-lg-5 py-5">
            <div class="w-50 border rounded shadow-lg px-sm-2 px-md-3 py-sm-0 py-md-1 px-lg-5">
                <div class="d-flex flex-column">
                    <div class="lead text-center pb-3 pt-3">
                        Login | Ticket-In
                    </div>

                    <!-- notif pesan -->
                    <div class="d-flex justify-content-center">
                        <?php if (isset($_SESSION['success'])) { ?>
                            <span class="pt-2"><?= $_SESSION['success'] ?></span>
                            <?php unset($_SESSION['success']); ?>
                        <?php } else { ?>
                            <span class="pt-2"><?= $message ?></span>
                        <?php } ?>
                    </div>

                    <form action="" method="post" class="was-validated">
                        <!-- email -->
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1" required>
                        </div>
                        <!-- password -->
                        <div class="mb-4">
                            <label for="exampleInputPassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPassword" required>
                        </div>
                        <!-- button -->
                        <div class="mb-4">
                            <button class="btn btn-success w-100" type="submit">Masuk</button>
                        </div>
                        <div class="text-center">
                            <p>Belum punya akun? <a href="register.php">klik disini</a></p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>