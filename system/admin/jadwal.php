<?php

class Jadwal
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lihatTujuan()
    {
        try {
            $stmt = $this->db->prepare("SELECT rute_id, tujuan FROM rute");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function lihatMerk()
    {
        try {
            $stmt = $this->db->prepare("SELECT bis_id, merk, plat_nomor FROM bis WHERE status = 'tidak'");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function lihatJadwal()
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                j.jadwal_id as jadwal_id,
                b.merk as merk,
                r.tujuan as tujuan,
                b.plat_nomor as plat_nomor,
                j.jam_berangkat as jam_berangkat,
                j.status as status
                FROM jadwal j
                JOIN rute r ON r.rute_id = j.rute_id
                JOIN bis b ON b.bis_id = j.bis_id"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function tambahJadwal($id_rute, $id_bis, $jam_berangkat)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO jadwal (rute_id, bis_id, jam_berangkat)
                VALUES (:rute_id, :bis_id, :jam_berangkat)"
            );
            $stmt->bindParam(":rute_id", $id_rute);
            $stmt->bindParam(":bis_id", $id_bis);
            $stmt->bindParam(":jam_berangkat", $jam_berangkat);
            $stmt->execute();
            header("Location:../../admin/jadwal.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function ubahJadwal($id, $id_rute, $id_bis, $jam_berangkat)
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE jadwal SET rute_id = :rute_id, 
                bis_id = :bis_id, jam_berangkat = :jam_berangkat 
                WHERE jadwal_id = :jadwal_id"
            );
            $stmt->bindParam(":rute_id", $id_rute);
            $stmt->bindParam(":bis_id", $id_bis);
            $stmt->bindParam(":jam_berangkat", $jam_berangkat);
            $stmt->bindParam(":jadwal_id", $id);
            $stmt->execute();
            header("Location:../../admin/jadwal.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function hapusJadwal($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM jadwal WHERE jadwal_id = :jadwal_id");
            $stmt->bindParam(":jadwal_id", $id);
            $stmt->execute();
            header("Location:../../admin/jadwal.php");
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
}
