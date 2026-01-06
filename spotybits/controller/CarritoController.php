<?php

class CarritoController {

    public function agregar() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (!isset($_POST['id_producto'])) {
            header("Location: index.php?pagina=carta");
            exit;
        }

        $idProducto = (int) $_POST['id_producto'];
        if ($idProducto <= 0) {
            header("Location: index.php?pagina=carta");
            exit;
        }

        $_SESSION['carrito'][$idProducto] = ($_SESSION['carrito'][$idProducto] ?? 0) + 1;

        header("Location: index.php?pagina=carta");
        exit;
    }

    public function eliminar() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $idProducto = (int) ($_POST['id_producto'] ?? 0);
        if ($idProducto > 0) {
            unset($_SESSION['carrito'][$idProducto]);
        }

        header("Location: index.php?accion=verCarrito");
        exit;
    }

    public function ver() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $carrito = $_SESSION['carrito'] ?? [];
        $ruta = __DIR__ . '/../view/paginas/carrito.php';
        require __DIR__ . '/../view/main.php';
    }

    public function confirmarPedido() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (empty($_SESSION['carrito'])) {
            $_SESSION['error'] = 'El carrito está vacío';
            header("Location: index.php?pagina=carrito");
            exit;
        }

        if (!isset($_SESSION['id_usuario'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para completar la compra';
            header("Location: index.php?accion=loginForm");
            exit;
        }

        $idUsuario = (int) $_SESSION['id_usuario'];
        if ($idUsuario <= 0) {
            session_destroy();
            session_start();
            $_SESSION['error'] = 'Sesión inválida. Inicia sesión de nuevo.';
            header("Location: index.php?accion=loginForm");
            exit;
        }

        require_once __DIR__ . '/../model/dao/UsuarioDAO.php';
        $usuarioDAO = new UsuarioDAO();
        if ($usuarioDAO->obtenerPorId($idUsuario) === null) {
            session_destroy();
            session_start();
            $_SESSION['error'] = 'Usuario no válido';
            header("Location: index.php?accion=loginForm");
            exit;
        }

        require_once __DIR__ . '/../model/dao/ProductoDAO.php';
        require_once __DIR__ . '/../model/dao/PedidoDAO.php';

        $productoDAO = new ProductoDAO();
        $pedidoDAO = new PedidoDAO();

        $total = 0;
        $lineas = [];

        foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
            $producto = $productoDAO->obtenerPorId($idProducto);
            if (!$producto) continue;

            $precio = $producto->getPrecio();
            $subtotal = $precio * (int)$cantidad;

            $total += $subtotal;
            $lineas[] = [
                'id_producto' => $idProducto,
                'cantidad' => (int)$cantidad,
                'precio_unidad' => $precio
            ];
        }

        try {
            $pedidoDAO->getDb()->beginTransaction();

            $idPedido = $pedidoDAO->crearPedido($total, $idUsuario, 'pendiente', null);
            $pedidoDAO->insertarLineas($idPedido, $lineas);

            $pedidoDAO->getDb()->commit();

            unset($_SESSION['carrito']);
            $_SESSION['success'] = 'Pedido confirmado correctamente';
            header("Location: index.php?pagina=home");
            exit;

        } catch (Exception $e) {
    if (method_exists($pedidoDAO, 'getDb')) {
        $pedidoDAO->getDb()->rollBack();
    }

    $_SESSION['error'] = 'Error al confirmar el pedido: ' . $e->getMessage();
    header("Location: index.php?pagina=carrito");
    exit;
}
    }
}
