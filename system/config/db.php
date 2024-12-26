<?php
class Database {
    private static $host = 'db';
    private static $dbname = 'gdeuqhlz_project';
    private static $username = 'user_db';
    private static $password = 'wtunBwVrgdFMsmWf';

    public static function getConnect()
    {
        $conn = null;
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
            $conn = new PDO($dsn, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("Database connection failed: " . $exception->getMessage());
            throw new Exception("Database connection error.");
        }
        return $conn;
    }
}
