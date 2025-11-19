<?php 

require_once __DIR__ . '/../model/producto.php';
require_once 'BaseDAO.php';

class ProductoDAO extends BaseDAO {
    $db = self::getConnection();
    $stmt = $db->query("SELECT * FROM productos");

    $productos = [];
    while ($row = $stmt->fetch()) {
        $productos[] = new producto(
            $row['id_producto'],
            $row['nombre'],
            $row['descripcion'],
            $row['precio'],
            $row['stock'],
            $row['id_oferta']
        );

    }

    return $productos;

    public static function find($id) {
        $db = self::getConnection();
        $stmt = $db->query("SELECT FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            return new producto(
                $row['id_producto'],
                $row['nombre'],
                $row['descripcion'],
                $row['precio'],
                $row['stock'],
                $row['id_oferta']
            );
        } 
        return null;
    
}

       public static function insert(producto $p) {
        $db = self::getConnection();
        $sql = "INSERT INTO producto (nombre, precio, stock) VALUES (?, ?, ?)";

        return $stmt->execute([
        $p->getNombre(),
        $p->getPrecio(),
        $p->getStock()
    ]);
       }
}
