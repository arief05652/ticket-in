<?php
class Database {
    private $host = 'localhost';
    private $username = 'user_db';
    private $password = 'api_services';
    private $database = 'test_db';

    public $conn;

    public function getConnect() {
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        } catch (mysqli_sql_exception) {
            return "error db";
        }
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }
}