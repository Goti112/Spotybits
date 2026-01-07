<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once __DIR__ . '/../model/dao/OfertaDAO.php';

class OfertaController {

    private OfertaDAO $ofertaDao;

    public function __construct() {
        $this->ofertaDao = new OfertaDAO();
    }

    // se guarda o actualiza la oferta desde el panel admin
    public function guardar() {
        if (empty($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
            header('Location: index.php?pagina=home');
            exit;
        }

        $id = $_POST['id_oferta'] ?? null;
        $nombre = trim($_POST['nombre'] ?? '');
        $porcentaje = floatval($_POST['porcentaje'] ?? 0);
        $minimo = floatval($_POST['minimo_compra'] ?? 0);
        $activa = isset($_POST['activa']) ? 1 : 0;

        $data = [
            'id_oferta' => $id,
            'nombre' => $nombre,
            'porcentaje' => $porcentaje,
            'minimo_compra' => $minimo,
            'activa' => $activa
        ];

        try {
            $this->ofertaDao->guardarOferta($data);
            $_SESSION['success'] = 'Oferta guardada correctamente.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error guardando la oferta: ' . $e->getMessage();
        }

        header('Location: index.php?pagina=admin');
        exit;
    }
}
