<?php
require_once './system/user/topup_system.php';
require_once './system/config/db.php';

$db = Database::getConnect();

$balance = new Balance(db: $db, user_id: $_SESSION['user_id']);
$balance = $balance->getBalance();

?>

<!-- navbar -->
<nav class="navbar navbar-expand-lg border-bottom bg-body-secondary fixed-top">
    <div class="container-md container-fluid-sm">
        <div class="d-flex w-100">
            <!-- button menu -->
            <button class="btn btn-primary pt-2 me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                <i class="material-symbols-outlined">
                    menu
                </i>
            </button>
            <div class="d-flex align-items-center px-3">
                <a class="text-decoration-none navbar navbar-brand" href="../index.php"><span class="fw-bold fs-4">Ticket-In</span></a>
            </div>

            <div class="d-flex ms-auto align-items-center justify-content-end px-2" style="width: 250px">
                <!-- balance user -->
                <div class="d-flex align-items-center justify-content-end w-100 me-3">
                    <span class="fs-4">Rp. <?= htmlspecialchars($balance) ?></span>
                    <i class="material-symbols-outlined ms-3" style="font-size: 35px; color: black">
                        account_balance_wallet
                    </i>
                </div>
            </div>
            
        </div>
    </div>
</nav>
<!-- sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="offcanvasResponsiveLabel">Ticket-In</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- profile detail sidebar -->
        <div class="d-flex shadow-lg mb-3">
            <img src="../public/assets/profile.png" class="me-1" style="width: 80px;">
            <div class="d-flex flex-column align-items-start justify-content-center w-100">
                <span class="lead">Email: <?= $_SESSION['email'] ?></span>
                <span class="lead">Saldo: Rp. <?= htmlspecialchars($balance) ?></span>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-around" style="height: 230px;">
            <!-- button profile -->
            <a class="btn btn-primary w-100 fs-3" href="../profile.php" role="button">Lihat Profile</a>
            <!-- topup -->
            <a class="btn btn-primary w-100 fs-3" href="#" role="button">Topup saldo</a>
            <!-- logout -->
            <a class="btn btn-primary w-100 fs-3" href="../logout.php" role="button">Logout</a>
        </div>
    </div>
</div>