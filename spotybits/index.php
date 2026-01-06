<?php
session_start();
// si llega "accion" empezamos login, registrar etc.
if (isset($_GET['accion'])) {

    require_once __DIR__ . "/controller/UsuarioController.php";
    require_once __DIR__ . "/controller/ProductoController.php";
    require_once __DIR__ . "/controller/CarritoController.php";

    $usuarioController = new UsuarioController();
    $carritoController = new CarritoController();

    switch ($_GET['accion']) {

        // ---------- usuarios ----------
        case 'registro':
            $usuarioController->mostrarRegistro();
            break;

        case 'registrar':
            $usuarioController->registrar();
            break;

        case 'login':
            $usuarioController->login();
            break;

        case 'loginForm':
            $usuarioController->mostrarLogin();
            break;

        case 'logout':
            $usuarioController->logout();
            break;

        // ---------- carrito ----------
        case 'agregarCarrito':
            $carritoController->agregar();
            break;

        case 'verCarrito':
            $carritoController->ver();
            break;

        case 'eliminarCarrito':
            $carritoController->eliminar();
            break;

        case 'confirmarPedido':
            $carritoController->confirmarPedido();
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

    case 'admin':
        $ruta = __DIR__ . '/view/paginas/admin.php';
        require __DIR__ . '/view/main.php';
        exit;

    case 'carrito':
        require_once __DIR__ . '/controller/CarritoController.php';
        $controller = new CarritoController();
        $controller->ver();
        exit;

    case 'mis_pedidos':
        require_once __DIR__ . '/controller/UsuarioPedidosController.php';
        $controller = new UsuarioPedidosController();
        $controller->listar();
        exit;

    default:
        $ruta = __DIR__ . "/view/paginas/$pagina.php";

        if (!file_exists($ruta)) {
            $ruta = __DIR__ . "/view/paginas/404.php";
        }

        require __DIR__ . '/view/main.php';
}
