<?php

class Database {
    public static function getConnection() {
        try {
            return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}

?>