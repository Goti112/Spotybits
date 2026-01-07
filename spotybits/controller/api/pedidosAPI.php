<?php

header("Content-Type: application/json");
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once __DIR__ . "/../../model/dao/PedidoDAO.php";


//verificar si el usuario esta logeado y es admin
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

$dao = new PedidoDAO();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        echo json_encode($dao->obtenerTodos());
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        //comprobar que llegan los datos necesarios
        if (!isset($data['id'], $data['estado'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            exit;
        }
        $dao->actualizarEstado($data['id'], $data['estado']);

        require_once __DIR__ . '/../../model/dao/logDAO.php';
        $logDAO = new logDAO();
        $logDAO->registrar($_SESSION['id_usuario'] ?? null, 'CAMBIAR_ESTADO_PEDIDO #' . $data['id'] . ' -> ' . $data['estado']);

        echo json_encode(["success" => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
}
