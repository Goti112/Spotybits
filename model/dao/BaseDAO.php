<?php

class BaseDAO {
    protected static function getConnection() {
        return database::getConnection();
    }
}