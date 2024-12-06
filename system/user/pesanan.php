<?php

class Pesanan
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

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
                    j.jam_berangkat as berangkat
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

    public function beliTiket($user_id, $tiket_id, $jumlah) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO pesanan (user_id, tiket_id, jumlah) 
                VALUES (:user_id, :tiket_id, :jumlah)"
            );
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":tiket_id", $tiket_id);
            $stmt->bindParam(":jumlah", $jumlah);
            $stmt->execute();

            header("Location: ../../profile.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function batalkanPesanan($pesanan_id) {}
}
