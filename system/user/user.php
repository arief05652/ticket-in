<?php
class User {
    protected
        $user_id,
        $email,
        $password,
        $nama_depan,
        $nama_belakang,
        $no_hp;

    public $message = "";

    public function __construct($email = '', $password = '', $nama_depan = '', $nama_belakang = '') {
        $this->email = $email;
        $this->password = $password;
        $this->nama_depan = $nama_depan;
        $this->nama_belakang = $nama_belakang;
    }

    public function login($db) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() === 0) {
                $this->message = "Email tidak terdaftar";
            } else {
                if (password_verify($this->password, $data['password'])) {
                    // set session
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['nama_dpn'] = $data['nama_dpn'];
                    $_SESSION['nama_blkg'] = $data['nama_blkg'];
                    $_SESSION['no_hp'] = $data['no_hp'];
                    $_SESSION['role'] = $data['role'];

                    // direct page sesuai role nya
                    if ($data['role'] === 'pelanggan') {
                        header('Location: ../index.php');
                        exit;
                    } elseif ($data['role'] === 'admin') {
                        header('Location: ../admin/dashboard.php');
                        exit;
                    }
                } else {
                    $this->message = "Password salah";
                }
            }
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function register($db) {
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->message = "Email sudah terdaftar";
            } else {
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

                $stmt = $db->prepare(
                    "INSERT INTO users (email, password, nama_dpn, nama_blkg) 
                    VALUES (:email, :password, :nama_dpn, :nama_blkg)"
                );
                $stmt->bindParam(":email", $this->email);
                $stmt->bindParam(":password", $password_hash);
                $stmt->bindParam(":nama_dpn", $this->nama_depan);
                $stmt->bindParam(":nama_blkg", $this->nama_belakang);
                $stmt->execute();

                $_SESSION['success'] = "Silahkan login";

                header("Location: login.php");
                exit;
            }
        } catch (\PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
}

class UserProfile extends User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function lihatProfile() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $_SESSION['user_id']);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function ubahProfile($email, $nama_depan, $nama_belakang) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE users SET email = :email, nama_dpn = :nama_dpn, 
                nama_blkg = :nama_blkg WHERE user_id = :user_id"
            );
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":nama_dpn", $nama_depan);
            $stmt->bindParam(":nama_blkg", $nama_belakang);
            $stmt->bindParam(":user_id", $_SESSION['user_id']);

            if ($stmt->execute()) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
                $stmt->bindParam(":user_id", $_SESSION['user_id']);
                if ($stmt->execute()) {
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['nama_dpn'] = $data['nama_dpn'];
                    $_SESSION['nama_blkg'] = $data['nama_blkg'];
                }
                $this->message = "Profile berhasil diubah.";
                header("Location: ../profile.php");
            }
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function lihatPesanan() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pesanan WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $_SESSION['user_id']);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function getTotalUser() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total_user FROM users");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['total_user'];
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }
}
