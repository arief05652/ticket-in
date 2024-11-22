<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require './system/db.php';

// buka koneksi database
$db = Database::getConnect();

class Auth
{
    public static $error = "";

    // register new user
    public static function newUser($email, $namadpn, $namablkng, $pass)
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // cek user
        if ($stmt->rowCount() > 0) {
            self::$error = "Email sudah terdaftar";
        } else {
            // hash password
            $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

            // insert user ke db
            $stmt = $db->prepare(
                "INSERT INTO users (nama_depan, nama_belakang, email, password)
                VALUES (:namadpn, :namablkng, :email, :password)"
            );
            $stmt->bindParam(':namadpn', $namadpn);
            $stmt->bindParam(':namablkng', $namablkng);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash_pass);
            $stmt->execute();

            $_SESSION['daftar-sukses'] = "Berhasil mendaftar silahkan login";

            header('Location: login.php');
        }
    }

    // login user
    public static function loginUser($email, $pass)
    {
        global $db;

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 0) {
            self::$error = "Email tidak terdaftar";
        } else {
            if ($user && password_verify($pass, $user['password'])) {
                self::$error = "login";
            } else {
                self::$error = "Password salah";
            }
        }
    }
}
