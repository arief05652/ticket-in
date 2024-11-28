<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require './system/db.php';
require_once './system/user.php';

// buka koneksi database
$db = Database::getConnect();

class Auth extends Users {
    public $error = '';

    // login user
    public function loginUser($email, $pass) {
        global $db;

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // cek email
        if ($stmt->rowCount() === 0) {
            $this->error = "Email tidak terdaftar";
        } else {
            if ($user && password_verify($pass, $user['password'])) {
                // set session
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];

                // direct page sesuai role nya
                if ($user['role'] === 'pelanggan') {
                    header('Location: ../user/dashboard.php');
                    exit;
                } elseif ($user['role'] === 'admin') {
                    header('Location: ../admin/dashboard.php');
                    exit;
                }
            } else {
                $this->error = "Password salah";
            }
        }
    }

    // register user
    public function registUser($email, $namadpn, $namablkng, $pass) {
        global $db;

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // cek user
        if ($stmt->rowCount() > 0) {
            $this->error = "Email sudah terdaftar";
        } else {
            // hash password
            $hash_pass = password_hash($pass, PASSWORD_BCRYPT);

            // insert user ke db
            $stmt = $db->prepare(
                "INSERT INTO users (nama_dpn, nama_blkg, email, password)
                VALUES (:namadpn, :namablkng, :email, :password)"
            );
            $stmt->bindParam(':namadpn', $namadpn);
            $stmt->bindParam(':namablkng', $namablkng);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash_pass);
            $stmt->execute();

            $_SESSION['daftar-sukses'] = "Berhasil mendaftar silahkan login";

            // direct ke login.php
            header('Location: login.php');
            exit;
        }
    }
}