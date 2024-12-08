<?php

class Tiket
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function showTiketDetail($tiket_id) {
        /**
         * fetch informasi tiket by tiket_id
         */
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    t.tiket_id as tiket_id,
                    r.tujuan as tujuan,
                    j.jam_berangkat as jam_berangkat,
                    t.harga as harga,
                    t.stok as stok,
                    r.titik_penjemputan as titik_penjemputan,
                    r.titik_penurunan as titik_penurunan,
                    b.merk as merk,
                    b.plat_nomor as plat_nomor
                FROM tiket t
                JOIN jadwal j ON j.jadwal_id = t.jadwal_id
                JOIN rute r ON r.rute_id = j.rute_id
                JOIN bis b ON b.bis_id = j.bis_id
                WHERE t.tiket_id = :tiket_id"
            );
            $stmt->bindParam(":tiket_id", $tiket_id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function lihatTiket()
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
	                t.tiket_id as tiket_id,
                    r.tujuan as tujuan,
                    b.plat_nomor as plat,
                    j.jam_berangkat as jam_berangkat,
	                t.harga as harga,
                    t.stok as stok,
                    t.status as status
                FROM tiket t
                JOIN jadwal j ON j.jadwal_id = t.jadwal_id
                JOIN bis b ON b.bis_id = j.bis_id
                JOIN rute r ON r.rute_id = j.rute_id"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function showTiketPublic() {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    t.tiket_id as tiket_id,
                    r.tujuan as tujuan,
                    j.jam_berangkat as jam_berangkat,
                    t.harga as harga,
                    t.stok as stok
                FROM tiket t
                JOIN jadwal j ON j.jadwal_id = t.jadwal_id
                JOIN rute r ON r.rute_id = j.rute_id
                WHERE t.status = 'public' AND stok > 0
                LIMIT 3"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function tambahTiket($id, $harga, $stok) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO tiket (jadwal_id, harga, stok)
                VALUES (:jadwal_id, :harga, :stok)"
            );
            $stmt->bindParam(':jadwal_id', $id);
            $stmt->bindParam(':harga', $harga); 
            $stmt->bindParam(':stok', $stok);
            $stmt->execute();
            header('Location:../admin/tiket.php');
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function updateStatus($tiket_id, $status) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE tiket
                SET status = :status
                WHERE tiket_id = :tiket_id"
            );
            $stmt->bindParam(':tiket_id', $tiket_id);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            header('Location:../admin/tiket.php');
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    public function updateTiket($id, $jadwal_id, $harga, $stok) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE tiket
                SET jadwal_id = :jadwal_id, harga = :harga, stok = :stok
                WHERE tiket_id = :tiket_id"
            );
            $stmt->bindParam(':tiket_id', $id);
            $stmt->bindParam(':jadwal_id', $jadwal_id);
            $stmt->bindParam(':harga', $harga);
            $stmt->bindParam(':stok', $stok);
            $stmt->execute();
            header('Location:../admin/tiket.php');
        } catch (PDOException $e) {
            echo "Kesalahan: ". $e->getMessage();
        }
    }

    
}
