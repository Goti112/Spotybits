<?php

require_once __DIR__ . '/../producto.php';
require_once __DIR__ . '/../../database/database.php';

class ProductoDAO {

    public function obtenerTodos() {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM producto";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $productos = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = new Producto(
                $fila['id_producto'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['stock'],
                $fila['id_oferta'],
                $fila['imagen'] ?? null
            );
        }

        return $productos;
    }
}

