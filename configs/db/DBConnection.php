<?php
class DBConnection
{
    protected static $instance = null;

    public static function getInstance()
    {
        $host = env('DB_HOST');
        $db = env('DB_NAME');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');

        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=$host; dbname=$db", $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }
}
