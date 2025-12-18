<?php
session_start();

// si llega "accion" empezamos login, registrar etc.
if (isset($_GET['accion'])) {

    require_once __DIR__ . "/controller/ProductoController.php";
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

    exit; 
}



//si no viene ningun "accion" se cargan las paginas con otro switch

$pagina = $_GET['pagina'] ?? 'home';

switch ($pagina) {

    case 'carta':
        require_once __DIR__ . '/controller/ProductoController.php';
        $controller = new ProductoController();
        $controller->mostrarCarta();
        exit;

    default:
        $ruta = __DIR__ . "/view/paginas/$pagina.php";

        if (!file_exists($ruta)) {
            $ruta = __DIR__ . "/view/paginas/404.php";
        }

        require __DIR__ . '/view/main.php';
}

