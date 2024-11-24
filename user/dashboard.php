<?php
session_start();
?>

<h1>halaman dashboard user</h1>
<p><?= $_SESSION['email'] ?></p>

<form action="../logout.php" method="post">
    <button class="btn btn-success w-100" type="submit">logout</button>
</form>