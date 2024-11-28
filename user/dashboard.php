<?php
session_start();

// validasi jika belum login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: ../admin/dashboard.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>halaman dashboard user</h1>
    <p><?= $_SESSION['email'] ?></p>

    <form action="../logout.php" method="post">
        <button class="btn btn-success w-100" type="submit">logout</button>
    </form>

    <!-- search bar -->
    <?php include '../utils/search_tiket.php' ?>

    <!-- bottom bootstrap -->
    <?php include '../utils/bottom.php' ?>

</body>

</html>