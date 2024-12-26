<?php 
// Pastikan tidak ada output sebelum kode PHP
if (isset($_POST['masuk'])) {
    header("Location: login.php");
    exit;
} elseif (isset($_POST['daftar'])) {
    header("Location: register.php");
    exit;
} elseif (isset($_POST['cari-ticket'])) {
    header("Location: schedule.php");
    exit;
}
?>
<nav class="navbar navbar-expand-lg border-bottom bg-body-secondary fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Ticket-In</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex mt-sm-5 mt-lg-0 ms-lg-auto" action="" method="POST">
                <button class="btn btn-primary me-lg-2 me-md-2 me-sm-1 me-xs-1" type="submit" name="masuk">Masuk</button>
                <button class="btn btn-success" type="submit" name="daftar">Daftar</button>
            </form>
        </div>
    </div>
</nav>
