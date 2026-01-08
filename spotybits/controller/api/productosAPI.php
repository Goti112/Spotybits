<?php

header("Content-Type: application/json");
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once __DIR__ . '/../../database/database.php';
require_once __DIR__ . '/../../model/dao/ProductoDAO.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

$dao = new ProductoDAO();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    
    case 'GET':
        $productos = $dao->obtenerTodos();
        echo json_encode($productos);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "Datos invalidos"]);
            exit;
        }
        
        $dao->crear(
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['tipo'] ?? null
        );

        // registrar log
        require_once __DIR__ . '/../../model/dao/logDAO.php';
        $logDAO = new logDAO();
        $idUsuario = $_SESSION['id_usuario'] ?? null;
        // obtener id del producto insertado
        $lastId = Database::getConnection()->lastInsertId();
        $logDAO->registrar($idUsuario, 'CREAR_PRODUCTO #' . $lastId . ' ' . ($data['nombre'] ?? ''));

        echo json_encode(["success" => true]);
        break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            $dao->actualizar(
                $data['id'],
                $data['nombre'],
                $data['descripcion'],
                $data['precio'],
                $data['stock'],
                $data['tipo'] ?? null
            );

            require_once __DIR__ . '/../../model/dao/logDAO.php';
            $logDAO = new logDAO();
            $logDAO->registrar($_SESSION['id_usuario'] ?? null, 'EDITAR_PRODUCTO #' . $data['id']);

            echo json_encode(["success" => true]);
            break;

        case 'DELETE':
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(["error" => "ID requerido"]);
        exit;
    }

    $dao->eliminar($data['id']);

    require_once __DIR__ . '/../../model/dao/logDAO.php';
    $logDAO = new logDAO();
    $logDAO->registrar($_SESSION['id_usuario'] ?? null, 'ELIMINAR_PRODUCTO #' . $data['id']);

    echo json_encode(["success" => true]);
    break;


        default:
            http_response_code(405);
            echo json_encode(["error" => "Metodo no permitido"]);
}
