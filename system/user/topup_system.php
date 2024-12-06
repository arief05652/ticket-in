<?php
class Balance {
    public $balance;

    public function __construct($db, $user_id) {
        try {
            $stmt = $db->prepare("SELECT balance FROM cek_balance_user WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            $this->balance = $data['balance'];

        } catch (\PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }

    public function getBalance() {
        $balance = $this->balance;
        return number_format($balance, 0, ",", ".");
    }
}