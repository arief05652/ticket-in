<?php

class Pesanan
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // 2024-12-08 09:12:32
    public function lihatPesananProfile($user_id)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    p.pesanan_id as pesanan_id,
                    r.tujuan as tujuan,
                    b.plat_nomor as plat,
                    t.harga as harga,
                    p.jumlah as jumlah_tiket,
                    t.harga * p.jumlah as total_harga,
                    j.jam_berangkat as berangkat,
                    p.waktu_pesanan as pemesanan
                FROM pesanan p
                JOIN tiket t ON t.tiket_id = p.tiket_id
                JOIN jadwal j ON j.jadwal_id = t.jadwal_id
                JOIN bis b ON b.bis_id = j.bis_id
                JOIN rute r ON r.rute_id = j.rute_id
                WHERE p.user_id = :user_id"
            );
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function beliTiket($user_id, $tiket_id, $jumlah, $total) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO pesanan (user_id, tiket_id, jumlah) 
                VALUES (:user_id, :tiket_id, :jumlah)"
            );
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":tiket_id", $tiket_id);
            $stmt->bindParam(":jumlah", $jumlah);
            $stmt->execute();

            $stmt = $this->db->prepare(
                "UPDATE tiket 
                SET stok = stok - :jumlah 
                WHERE tiket_id = :tiket_id"
            );
            $stmt->bindParam(":jumlah", $jumlah);
            $stmt->bindParam(":tiket_id", $tiket_id);
            $stmt->execute();

            $stmt = $this->db->prepare(
                "UPDATE balance
                SET balance = balance - :total
                WHERE user_id = :user_id"
            );
            $stmt->bindParam(":total", $total);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            header("Location: ../../profile.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function batalkanPesanan($pesanan_id,  $tiket_id,  $user_id, $jumlah, $total) {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM pesanan 
                WHERE pesanan_id = :pesanan_id"
            );
            $stmt->bindParam(":pesanan_id", $pesanan_id);
            $stmt->execute();

            $stmt = $this->db->prepare(
                "UPDATE tiket 
                SET stok = stok + :jumlah 
                WHERE tiket_id = :tiket_id"
            );
            $stmt->bindParam(":jumlah", $jumlah);
            $stmt->bindParam(":tiket_id", $tiket_id);
            $stmt->execute();

            $stmt = $this->db->prepare(
                "UPDATE balance
                SET balance = balance + :total
                WHERE user_id = :user_id"
            );
            $stmt->bindParam(":total", $total);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            header("Location: ../../profile.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function lihatPesananById($pesanan_id) {
        /**
         * show pesanan by pesanan id
         */
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    p.tiket_id as tiket_id,
                    p.jumlah as jumlah_tiket,
                    t.harga * p.jumlah as total_harga,
                    j.jam_berangkat as berangkat,
                    p.waktu_pesanan as pemesanan
                FROM pesanan p
                JOIN tiket t ON t.tiket_id = p.tiket_id
                JOIN jadwal j ON j.jadwal_id = t.jadwal_id
                WHERE p.pesanan_id = :pesanan_id"
            );
            $stmt->bindParam(":pesanan_id", $pesanan_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
}
