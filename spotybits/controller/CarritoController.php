<?php

class CarritoController {

    public function agregar() {
        // añadir 1 unidad del producto al carrito de la sesión
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
        // eliminar producto del carrito por id si existe
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $idProducto = (int) ($_POST['id_producto'] ?? 0);
        if ($idProducto > 0) {
            unset($_SESSION['carrito'][$idProducto]);
        }

        header("Location: index.php?accion=verCarrito");
        exit;
    }

    public function ver() {
        // muestra la vista del carrito
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $carrito = $_SESSION['carrito'] ?? [];
        $ruta = __DIR__ . '/../view/paginas/carrito.php';
        require __DIR__ . '/../view/main.php';
    }

    public function confirmarPedido() {
        // valida sesion, calcula totales, aplica oferta
        // crea pedido en la base de datos y registra log
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
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['error'] = 'Sesión inválida. Inicia sesión de nuevo.';
            header("Location: index.php?accion=loginForm");
            exit;
        }

        require_once __DIR__ . '/../model/dao/UsuarioDAO.php';
        $usuarioDAO = new UsuarioDAO();
        if ($usuarioDAO->obtenerPorId($idUsuario) === null) {
            session_destroy();
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
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

        // obtener oferta activa para aplicar descuento si se cumple el minimo
        require_once __DIR__ . '/../model/dao/OfertaDAO.php';
        $ofertaDAO = new OfertaDAO();
        $ofertaActiva = $ofertaDAO->obtenerOfertaActiva();

        $totalAntesDescuento = round($total, 2);
        $descuento = 0.0;
        $idOfertaAplicada = null;

        if ($ofertaActiva) {
            $minimo = (float)$ofertaActiva['minimo_compra'];
            $porcentaje = (float)$ofertaActiva['porcentaje'];
            if ($totalAntesDescuento >= $minimo) {
                $descuento = round($totalAntesDescuento * ($porcentaje / 100.0), 2);
                $idOfertaAplicada = $ofertaActiva['id_oferta'];
            }
        }

        $importeFinal = round($totalAntesDescuento - $descuento, 2);

        try {
            $pedidoDAO->getDb()->beginTransaction();

            //creacion del pedido
            // se inserta la cabecera y luego las lineas de pedido en la bd
            $idPedido = $pedidoDAO->crearPedido($importeFinal, $idUsuario, 'pendiente', $idOfertaAplicada);
            $pedidoDAO->insertarLineas($idPedido, $lineas);

            $pedidoDAO->getDb()->commit();

            require_once __DIR__ . '/../model/dao/LogDAO.php';
            $logDAO = new LogDAO();
            $logDAO->registrar(
                $idUsuario,
                'CREAR_PEDIDO #' . $idPedido
            );  
            // guardar info del ultimo pedido en sesión para mostrar confirmación
            $_SESSION['ultimo_pedido'] = [
                'id' => $idPedido,
                'fecha' => date('Y-m-d H:i:s'),
                'importe_final' => number_format($importeFinal, 2, '.', ''),
                'importe_antes_descuento' => number_format($totalAntesDescuento, 2, '.', ''),
                'descuento' => number_format($descuento, 2, '.', ''),
                'id_oferta' => $idOfertaAplicada,
                'lineas' => $lineas,
                'id_usuario' => $idUsuario
            ];

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
