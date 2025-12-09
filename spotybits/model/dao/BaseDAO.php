<?php
// filepath: c:\xampp\htdocs\Web_Spotify\SPOTYBITS\spotybits\model\dao\BaseDAO.php

require_once __DIR__ . '/../../database/database.php';

class BaseDAO {
    protected static function getConnection() {
        return database::getConnection();
    }
}
?>
