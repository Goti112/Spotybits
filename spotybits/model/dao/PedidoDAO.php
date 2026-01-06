<?php

require_once __DIR__ . '/../../database/database.php';

class PedidoDAO {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getDb(): PDO {
        return $this->db;
    }

    // obtener todos los pedidos ordenados por fecha desc
    public function obtenerTodos(): array {
        $sql = "SELECT * FROM pedido ORDER BY fecha DESC";
        $stmt = $this->db->query($sql);

        $pedidos = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidos[] = [
                'id' => $fila['id_pedido'] ?? $fila['id'] ?? null,
                'fecha' => $fila['fecha'] ?? null,
                'importe_total' => $fila['importe_total'] ?? $fila['importe'] ?? 0,
                'estado' => $fila['estado'] ?? 'pendiente',
                'id_usuario' => $fila['id_usuario'] ?? null,
                'id_oferta' => $fila['id_oferta'] ?? null
            ];
        }

        return $pedidos;
    }

    public function crearPedido(float $importeTotal, int $idUsuario, string $estado, ?int $idOferta): int {
        $sql = "INSERT INTO pedido (fecha, importe_total, estado, id_usuario, id_oferta)
                VALUES (NOW(), ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$importeTotal, $estado, $idUsuario, $idOferta]);
        return (int) $this->db->lastInsertId();
    }

    public function insertarLineas(int $idPedido, array $lineas): void {
        $sql = "INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio_unidad)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        foreach ($lineas as $l) {
            $stmt->execute([
                $idPedido,
                $l['id_producto'],
                $l['cantidad'],
                $l['precio_unidad']
            ]);
        }
    }

    public function actualizarEstado(int $idPedido, string $estado): void {
        $stmt = $this->db->prepare("UPDATE pedido SET estado = ? WHERE id_pedido = ?");
        $stmt->execute([$estado, $idPedido]);
    }
}
