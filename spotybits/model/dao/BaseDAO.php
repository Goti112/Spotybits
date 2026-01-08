<?php

require_once __DIR__ . '/../../database/database.php';

class BaseDAO {
    protected static function getConnection() {
        return Database::getConnection();
    }
}
?>