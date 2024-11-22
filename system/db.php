<?php
class Database
{
    private static $host = 'localhost';
    private static $username = 'user_db';
    private static $password = 'wtunBwVrgdFMsmWf';
    private static $database = 'final_project';

    public static function getConnect()
    {
        $conn = null;

        try {
            $conn = new PDO("mysql:host=". self::$host .";dbname=". self::$database, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            return "Koneksi gagal: " . $exception->getMessage();
        }

        return $conn;
    }
}

// kkjkj