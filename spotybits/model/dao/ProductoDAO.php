<?php

require_once __DIR__ . '/../producto.php';
require_once __DIR__ . '/../../database/database.php';

class ProductoDAO {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos() {

        $sql = "SELECT * FROM producto";
        $stmt = $this->db->query($sql);

        $productos = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $productos[] = [
                "id" => $fila["id_producto"],
                "nombre" => $fila["nombre"],
                "descripcion" => $fila["descripcion"],
                "precio" => $fila["precio"],
                "stock" => $fila["stock"],
                "imagen" => $fila["imagen"]
            ];
        }

        return $productos;
    }

    public function crear($nombre, $descripcion, $precio, $stock) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO producto (nombre, descripcion, precio, stock)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nombre, $descripcion, $precio, $stock]);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE producto 
             SET nombre=?, descripcion=?, precio=?, stock=? 
             WHERE id_producto=?"
        );
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $id]);
    }

    public function eliminar($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "DELETE FROM producto WHERE id_producto=?"
        );
        $stmt->execute([$id]);
    }


    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE id_producto = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        $id_oferta = array_key_exists('id_oferta', $fila) ? $fila['id_oferta'] : null;
        return new producto(
            $fila["id_producto"],
            $fila["nombre"],
            $fila["descripcion"],
            (float) $fila["precio"],
            (int) $fila["stock"],
            $id_oferta,
            $fila["imagen"] ?? null
        );
    }
}
