<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Ticket-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- FORM REGISTER -->
    <div class="container mt-5">
        <div class="d-flex justify-content-center px-sm-0 px-lg-5 py-5">
            <div class="w-50 rounded shadow-lg bg-light-subtle px-sm-1 px-md-2 py-sm-0 py-md-1 px-lg-5">
                <div class="d-flex flex-column">
                    <div class="lead text-center pb-2 pt-3">
                        Register | Ticket-In
                    </div>
                    <form action="" method="POST" class="was-validated">
                        <!-- email -->
                        <div class="mb-2">
                            <label for="exampleInputEmail1" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" required aria-describedby="emailHelp">
                        </div>
                        <!-- password -->
                        <div class="mb-2">
                            <label for="exampleInputPassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="exampleInputPassword" required aria-describedby="passwordHelp">
                        </div>
                        <!-- remember me -->
                        <div class="mb-4">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <!-- button -->
                        <div class="mb-4">
                            <button class="btn btn-success w-100" type="submit" name="daftar">Masuk</button>
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