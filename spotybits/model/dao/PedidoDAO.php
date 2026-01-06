<?php

require_once __DIR__ . '/../../database/database.php';

class PedidoDAO {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos() {

        $sql = "SELECT * FROM pedido ORDER BY fecha DESC";
        $stmt = $this->db->query($sql);

        $pedidos = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidos[] = [
                "id" => $fila["id_pedido"],
                "fecha" => $fila["fecha"],
                "importe_total" => $fila["importe_total"],
                "estado" => $fila["estado"] ?? "pendiente",
                "id_usuario" => $fila["id_usuario"],
                "id_oferta" => $fila["id_oferta"]
            ];
        }

        return $pedidos;
    }

    public function crearPedido(?int $idUsuario, float $importeTotal, string $estado = 'pendiente', ?int $idOferta = null): int {
        $sql = "INSERT INTO pedido (fecha, importe_total, estado, id_usuario, id_oferta) VALUES (NOW(), ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$importeTotal, $estado, $idUsuario, $idOferta]);
        return (int)$this->db->lastInsertId();
    }

    public function insertarLineas(int $idPedido, array $lineas): void {
        $sql = "INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio_unidad) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        foreach ($lineas as $ln) {
            $stmt->execute([$idPedido, $ln['id_producto'], $ln['cantidad'], $ln['precio_unidad']]);
        }
    }

    public function actualizarEstado(int $idPedido, string $estado): void {
        $sql = "UPDATE pedido SET estado = ? WHERE id_pedido = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$estado, $idPedido]);
    }
}
