<?php

require_once __DIR__ . '/../../database/database.php';

class logDAO {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function registrar(?int $idUsuario, string $accion): void {

        $sql = "INSERT INTO log (fecha, accion, id_usuario)
                VALUES (NOW(), ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $accion,
            $idUsuario
        ]);
    }
    
    public function obtenerTodos(): array {

        $sql = "SELECT 
                    l.id_log,
                    l.fecha,
                    l.accion,
                    u.nombre
                FROM log l
                LEFT JOIN usuarios u ON l.id_usuario = u.id_usuario
                ORDER BY l.fecha DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}