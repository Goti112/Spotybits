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
                "imagen" => $fila["imagen"],
                "tipo" => $fila["tipo"] ?? null
            ];
        }

        return $productos;
    }

    public function crear($nombre, $descripcion, $precio, $stock) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO producto (nombre, descripcion, precio, stock, tipo)
             VALUES (?, ?, ?, ?, ?)"
        );
        // por defecto tipo vacío si no se pasa
        $tipo = func_num_args() >= 5 ? func_get_arg(4) : null;
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $tipo]);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE producto 
             SET nombre=?, descripcion=?, precio=?, stock=?, tipo=? 
             WHERE id_producto=?"
        );
        $tipo = func_num_args() >= 6 ? func_get_arg(5) : null;
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $tipo, $id]);
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
            $fila["imagen"] ?? null,
            $fila["tipo"] ?? null
        );
    }
}
