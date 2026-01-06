<?php

class CarritoController {

    // funcion para agregar productos al carrito
    public function agregar() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_POST['id_producto'])) {
            header("Location: index.php?pagina=carta");
            exit;
        }

        $idProducto = (int) $_POST['id_producto'];

        if ($idProducto <= 0) {
            header("Location: index.php?pagina=carta");
            exit;
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto]++;
        } else {
            $_SESSION['carrito'][$idProducto] = 1;
        }

        header("Location: index.php?pagina=carta");
        exit;
    }

    // funcion para eliminar productos del carrito
    public function eliminar() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_POST['id_producto'])) {
            header("Location: index.php?accion=verCarrito");
            exit;
        }

        $idProducto = (int) $_POST['id_producto'];

        if (isset($_SESSION['carrito'][$idProducto])) {
            unset($_SESSION['carrito'][$idProducto]);
        }

        header("Location: index.php?accion=verCarrito");
        exit;
    }

   //funcion para ver el carrito
    public function ver() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $carrito = $_SESSION['carrito'] ?? [];

        $ruta = __DIR__ . '/../view/paginas/carrito.php';
        require __DIR__ . '/../view/main.php';
    }

    //funcion para confirmar el pedido
    public function confirmarPedido() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $carrito = $_SESSION['carrito'] ?? [];

        if (empty($carrito)) {
            $_SESSION['mensaje'] = 'El carrito está vacío';
            header("Location: index.php?pagina=carrito");
            exit;
        }

        // recogge los datos de la direccion si existen
        $calle = trim($_POST['calle'] ?? '');
        $localidad = trim($_POST['localidad'] ?? '');
        $estado = trim($_POST['estado'] ?? '');
        $codigo_postal = trim($_POST['codigo_postal'] ?? '');

        // calcula el total y prepara las lineas del pedido
        require_once __DIR__ . '/../model/dao/ProductoDAO.php';
        $productoDAO = new ProductoDAO();
        $total = 0;
        $lineas = [];

        foreach ($carrito as $idProducto => $cantidad) {
            $producto = $productoDAO->obtenerPorId($idProducto);
            if (!$producto) continue;
            $precio = $producto->getPrecio();
            $subtotal = $precio * (int)$cantidad;
            $total += $subtotal;
            $lineas[] = [
                'id_producto' => $idProducto,
                'cantidad' => (int)$cantidad,
                'precio_unidad' => $precio,
                'subtotal' => $subtotal
            ];
        }

        // inserta el pedido en la base de datos
        require_once __DIR__ . '/../model/dao/PedidoDAO.php';

        $pedidoDAO = new PedidoDAO();

        try {
            $this->beginTransactionIfPossible($pedidoDAO);

            $idUsuario = $_SESSION['id_usuario'] ?? null;
            $importe = floatval(number_format($total, 2, '.', ''));

            $idPedido = $pedidoDAO->crearPedido($idUsuario, $importe, 'pendiente', null);
            if (!empty($lineas)) {
                $pedidoDAO->insertarLineas($idPedido, $lineas);
            }

            $this->commitIfPossible($pedidoDAO);

            $_SESSION['ultimo_pedido'] = [
                'id' => $idPedido,
                'fecha' => date('Y-m-d H:i:s'),
                'importe_total' => number_format($importe, 2, '.', ''),
                'direccion' => [
                    'calle' => $calle,
                    'localidad' => $localidad,
                    'estado' => $estado,
                    'codigo_postal' => $codigo_postal
                ],
                'lineas' => $lineas,
                'id_usuario' => $idUsuario
            ];

            // vaciar carrito
            unset($_SESSION['carrito']);

            $_SESSION['mensaje'] = 'Pedido confirmado correctamente';
            header("Location: index.php?pagina=home");
            exit;

        } catch (Exception $e) {
            // intentar rollback si es posible
            $this->rollbackIfPossible($pedidoDAO);
            $_SESSION['mensaje'] = 'Error al confirmar el pedido: ' . $e->getMessage();
            header("Location: index.php?pagina=carrito");
            exit;
        }
    }

    private function beginTransactionIfPossible($pedidoDAO) {
        try {
            $ref = new ReflectionClass($pedidoDAO);
            $dbProp = $ref->getProperty('db');
            $dbProp->setAccessible(true);
            $db = $dbProp->getValue($pedidoDAO);
            if ($db && $db instanceof PDO) $db->beginTransaction();
        } catch (Exception $e) {
        }
    }

    private function commitIfPossible($pedidoDAO) {
        try {
            $ref = new ReflectionClass($pedidoDAO);
            $dbProp = $ref->getProperty('db');
            $dbProp->setAccessible(true);
            $db = $dbProp->getValue($pedidoDAO);
            if ($db && $db instanceof PDO) $db->commit();
        } catch (Exception $e) {
        }
    }

    private function rollbackIfPossible($pedidoDAO) {
        try {
            $ref = new ReflectionClass($pedidoDAO);
            $dbProp = $ref->getProperty('db');
            $dbProp->setAccessible(true);
            $db = $dbProp->getValue($pedidoDAO);
            if ($db && $db instanceof PDO) $db->rollBack();
        } catch (Exception $e) {
        }
    }
}
