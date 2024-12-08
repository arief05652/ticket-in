<?php

class Topup
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lihatDaftar()
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    u.user_id as user_id,
                    tb.tb_id as topup_id,
                    u.email as email,
                    tb.amount as amount,
                    tb.waktu as waktu_topup
                FROM topup_balance tb
                JOIN balance b ON b.balance_id = tb.balance_id
                JOIN users u ON u.user_id = tb.user_id
                JOIN status_topup st ON st.tb_id = tb.tb_id"
            );
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function lihatTopup($id) {
        try {
            $stmt = $this->db->prepare(
                "SELECT 
                    ht.user_id as user_id,
                    ht.amount as amount,
                    ht.status as status,
                    ht.waktu as waktu_topup
                FROM history_topup ht
                WHERE ht.user_id = :user_id
                "
            );
            $stmt->bindParam(":user_id", $id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }

    public function tolakTopup($topup_id)
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE status_topup
                SET status = 'tolak'
                WHERE tb_id = :tb_id"
            );
            $stmt->bindParam(":tb_id", $topup_id);
            $stmt->execute();
            header("Location:../../admin/topup.php");
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
    public function terimaTopup($topup_id) {
        try {
            $stmt = $this->db->prepare(
                "UPDATE status_topup
                SET status = 'berhasil'
                WHERE tb_id = :tb_id"
            );
            $stmt->bindParam(":tb_id", $topup_id);
            $stmt->execute();
            header("Location:../../admin/topup.php");
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
    public function tambahTopup($amount, $user_id, $balance_id) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO topup_balance (user_id, balance_id, amount)
                VALUES (:user_id, :balance_id, :amount)"                
            );
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":balance_id", $balance_id);
            $stmt->execute();
            header("Location: ../../topup.php");
        } catch (Exception $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    }
}
