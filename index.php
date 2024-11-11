<?php
if (isset($_POST['masuk'])) {
    header("Location: login.php");
} else if (isset($_POST['daftar'])) {
    header("Location: register.php");
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
                        <a class="nav-link active" aria-current="page" href="#">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact</a>
                    </li>
                </ul>
                <form class="d-flex mb-md-3 mb-lg-0" action="" method="POST">
                    <button class="btn btn-primary me-lg-2 me-md-2 me-sm-1 me-xs-1" type="submit" name="masuk">Masuk</button>
                    <button class="btn btn-success" type="submit" name="daftar">Daftar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- banner -->
    <section style="margin-top: 57px;">
        <div class="container-fluid">
            <div class="container">
                <div class="shadow-lg rounded px-5 py-5">
                    <div class="row h-100">
                        <div class="col">
                            <div class="h-100">
                                <!-- banner -->
                                <div class="text-center pb-4">
                                    <h4>Penuhi kebutuhan liburan anda dengan Ticket-In</h4>
                                </div>
                                <!-- search bar -->
                                <div class="justify-content-center mx-5 mt-lg-5 mb-lg-5 mt-md-4 mb-md-4">
                                    <div class="row justify-content-around rounded shadow-lg px-lg-3 py-lg-2 px-md-1 py-md-1 py-sm-2">
                                        <div class="col-lg-3 col-md-3 mb-sm-2 mb-md-0">
                                            <input type="email" class="form-control" placeholder="Kota asal">
                                        </div>
                                        <div class="col-lg-3 col-md-3 mb-sm-2 mb-md-0">
                                            <input type="email" class="form-control" placeholder="Kota tujuan">
                                        </div>
                                        <div class="col-lg-3 col-md-3 mb-sm-2 mb-md-0">
                                            <input type="date" class="form-control">
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <button class="btn btn-success w-100" type="submit" name="daftar">Cek tiket</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- catalog method -->
     <section class="mt-1">
        <div class="container-fluid">
            <div class="container">
                <div class="shadow-lg rounded px-5 py-5">
                    <div class="row">

                    </div>
                </div>  
            </div>
        </div>
     </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>