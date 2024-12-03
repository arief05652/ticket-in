<?php
class Rute {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function lihatRute() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM rute");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function ubahRute($id, $tujuan, $penjemputan, $penurunan) {
        try {
            $stmt = $this->db->prepare(
                    "UPDATE rute SET tujuan = :tujuan, 
                    titik_penjemputan = :titik_penjemputan, titik_penurunan = :titik_penurunan 
                    WHERE rute_id = :rute_id"
                );
            $stmt->bindParam(":tujuan", $tujuan);
            $stmt->bindParam(":titik_penjemputan", $penjemputan);
            $stmt->bindParam(":titik_penurunan", $penurunan);
            $stmt->bindParam(":rute_id", $id);
            $stmt->execute();
            header("Location: ../../admin/rute.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }
    
    public function tambahRute($tujuan, $penjemputan, $penurunan) {
        try {
            $stmt = $this->db->prepare(
                    "INSERT INTO rute (tujuan, titik_penjemputan, titik_penurunan)
                    VALUES (:tujuan, :titik_penjemputan, :titik_penurunan)"
                );
            $stmt->bindParam(":tujuan", $tujuan);
            $stmt->bindParam(":titik_penjemputan", $penjemputan);
            $stmt->bindParam(":titik_penurunan", $penurunan);
            $stmt->execute();
            header("Location:../../admin/rute.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function hapusRute($id) {
            try {
                $stmt = $this->db->prepare("DELETE FROM rute WHERE rute_id = :rute_id");
                $stmt->bindParam(":rute_id", $id);
                $stmt->execute();
                header("Location:../../admin/rute.php");
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }
}