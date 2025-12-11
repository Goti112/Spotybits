<?php
session_start();

// Si viene ACCIÓN (login, registrar, logout...)
if (isset($_GET['accion'])) {

    require_once __DIR__ . "/controller/UsuarioController.php";
    $controller = new UsuarioController();

    switch ($_GET['accion']) {

        case 'registro':
            $controller->mostrarRegistro();
            break;

        case 'registrar':
            $controller->registrar();
            break;

        case 'login':
            $controller->login();
            break;

        case 'loginForm':
            $controller->mostrarLogin();
            break;

        case 'logout':
            $controller->logout();
            break;

        default:
            echo "Acción no válida.";
    }

    exit; // Evita que cargue main.php debajo
}



// -------------------------
// SI NO VIENE ACCION → CARGAR PAGINAS
// -------------------------

$pagina = $_GET['pagina'] ?? 'home';

$ruta = __DIR__ . "/view/paginas/" . $pagina . ".php";

if (!file_exists($ruta)) {
    $ruta = __DIR__ . "/view/paginas/404.php";
}

require __DIR__ . '/view/main.php';
