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

    public function actualizarEstado(int $idPedido, string $estado): void {
        $sql = "UPDATE pedido SET estado = ? WHERE id_pedido = ?";
    }
}
