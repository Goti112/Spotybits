<?php

require_once __DIR__ . '/../../database/database.php';

class OfertaDAO {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // devuelve la oferta que esta activa y si no devuelve null
    public function obtenerOfertaActiva(): ?array {
        $sql = "SELECT id_oferta, nombre, porcentaje, minimo_compra, activa FROM oferta WHERE activa = 1 LIMIT 1";
        $stmt = $this->db->query($sql);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;

        return [
            'id_oferta' => (int)$fila['id_oferta'],
            'nombre' => $fila['nombre'],
            'porcentaje' => (float)$fila['porcentaje'],
            'minimo_compra' => (float)$fila['minimo_compra'],
            'activa' => (int)$fila['activa']
        ];
    }

    //guarda o actualiza la oferta
    public function guardarOferta(array $data): int {
        $this->db->beginTransaction();
        try {
            $activa = isset($data['activa']) && ($data['activa'] == 1 || $data['activa'] === '1');
            if ($activa) {
                // desactiva otras ofertas
                $this->db->exec("UPDATE oferta SET activa = 0");
            }

            if (!empty($data['id_oferta'])) {
                $sql = "UPDATE oferta SET nombre = ?, porcentaje = ?, minimo_compra = ?, activa = ? WHERE id_oferta = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $data['nombre'],
                    $data['porcentaje'],
                    $data['minimo_compra'],
                    $activa ? 1 : 0,
                    $data['id_oferta']
                ]);
                $id = (int)$data['id_oferta'];
            } else {
                $sql = "INSERT INTO oferta (nombre, porcentaje, minimo_compra, activa) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $data['nombre'],
                    $data['porcentaje'],
                    $data['minimo_compra'],
                    $activa ? 1 : 0
                ]);
                $id = (int)$this->db->lastInsertId();
            }

            $this->db->commit();
            return $id;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
