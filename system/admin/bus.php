<?php
class Bis {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function lihatBis() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM bis");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function tambahBis($merk, $kapasitas, $plat) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO bis (merk, kapasitas, plat_nomor) VALUES (:merk, :kapasitas, :plat_nomor)"
            );
            $stmt->bindParam(":merk", $merk);
            $stmt->bindParam(":kapasitas", $kapasitas);
            $stmt->bindParam(":plat_nomor", $plat);
            $stmt->execute();
            header("Location:../../admin/bis.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function ubahBis($id, string $merk, int $kapasitas, string $plat) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE bis SET merk = :merk, kapasitas = :kapasitas, plat_nomor = :plat WHERE bis_id = :bis_id"
            );
            $stmt->bindParam(":merk", $merk);
            $stmt->bindParam(":kapasitas", $kapasitas);
            $stmt->bindParam(":plat", $plat);
            $stmt->bindParam(":bis_id", $id);
            $stmt->execute();
            header("Location:../../admin/bis.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function hapusBis($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM bis WHERE bis_id = :bis_id");
            $stmt->bindParam(":bis_id", $id);
            $stmt->execute();
            header("Location:../../admin/bis.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function lihatMerk()
    {
        try {
            $stmt = $this->db->prepare("SELECT bis_id, merk, plat_nomor FROM bis");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
}