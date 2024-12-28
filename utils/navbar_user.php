<?php
// Pastikan tidak ada output sebelum kode PHP
// if (isset($_POST['masuk'])) {
//     header("Location: login.php");
//     exit;
// } elseif (isset($_POST['daftar'])) {
//     header("Location: register.php");
//     exit;
// } elseif (isset($_POST['cari-ticket'])) {
//     header("Location: schedule.php");
//     exit;
// }
?>
<nav class="navbar navbar-expand-lg border-bottom bg-body-secondary fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Ticket-In</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex mt-sm-5 mt-lg-0 ms-lg-auto" action="" method="POST">
                <a class="btn btn-success  me-lg-2 me-md-2 me-sm-1 me-xs-1" href="../login.php" role="button">Masuk</a>
                <a class="btn btn-primary" href="../register.php" role="button">Daftar</a>
            </form>
        </div>
    </div>
</nav>