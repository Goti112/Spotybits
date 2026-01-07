<?php

header("Content-Type: application/json");
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once __DIR__ . "/../../model/dao/logDAO.php";

// solo admin puede ver logs
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

$dao = new logDAO();

echo json_encode($dao->obtenerTodos());
