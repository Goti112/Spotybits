<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../model/dao/PedidoDAO.php';
require_once __DIR__ . '/../model/dao/ProductoDAO.php';
require_once __DIR__ . '/../database/database.php';

class UsuarioPedidosController {

    private PedidoDAO $pedidoDao;
    private ProductoDAO $productoDao;

    public function __construct() {
        $this->pedidoDao = new PedidoDAO();
        $this->productoDao = new ProductoDAO();
    }

    // funcion para mostrar la lista de pedidos al usuario que esta logeado
    public function listar() {
        // si no hay ningun usuario logeado se redirige directamente al login
        if (empty($_SESSION['id_usuario'])) {
            header('Location: index.php?accion=loginForm');
            exit;
        }

        $idUsuario = (int)($_SESSION['id_usuario'] ?? 0);
        $usuarioNombre = $_SESSION['usuario'] ?? '';

        // obtiene todos los pedidos
        $todos = $this->pedidoDao->obtenerTodos();

        // filtra los pedidos del usuario logeado
        $pedidosUsuario = array_values(array_filter($todos, function($p) use ($idUsuario) {
            return isset($p['id_usuario']) && (int)$p['id_usuario'] === (int)$idUsuario;
        }));
        //por cada pedido uqe hay se obtienen sus lineas de pedido
        $db = Database::getConnection();
        $stmtLineas = $db->prepare("SELECT * FROM linea_pedido WHERE id_pedido = ?");

        foreach ($pedidosUsuario as &$pedido) {
            $pedidoId = $pedido['id'];
            $stmtLineas->execute([$pedidoId]);
            $lineas = [];
            while ($fila = $stmtLineas->fetch(PDO::FETCH_ASSOC)) {
                $idProd = $fila['id_producto'];
                $cantidad = (int)$fila['cantidad'];
                $precioUnidad = (float)$fila['precio_unidad'];

                // obtener los datos del producto
                $productoObj = $this->productoDao->obtenerPorId($idProd);
                if ($productoObj !== null) {
                    $nombre = $productoObj->getNombre() ?? $productoObj->nombre ?? '';
                    $imagen = method_exists($productoObj, 'getImagen') ? $productoObj->getImagen() : ($productoObj->imagen ?? null);
                } else {
                    $nombre = $fila['nombre'] ?? 'Producto no disponible';
                    $imagen = null;
                }

                $subtotal = round($cantidad * $precioUnidad, 2);

                $lineas[] = [
                    'id_producto' => $idProd,
                    'nombre' => $nombre,
                    'imagen' => $imagen,
                    'cantidad' => $cantidad,
                    'precio_unidad' => number_format($precioUnidad, 2, '.', ','),
                    'subtotal' => number_format($subtotal, 2, '.', ',')
                ];
            }

            $pedido['lineas'] = $lineas;
            //formatear importe final
            $pedido['importe_total_formateado'] = number_format((float)$pedido['importe_total'], 2, '.', ',');
        }
        unset($pedido);

        $ultimoPedido = count($pedidosUsuario) > 0 ? $pedidosUsuario[0] : null;

        $pedidos = $pedidosUsuario;

        $ruta = __DIR__ . '/../view/paginas/mis_pedidos.php';
        require __DIR__ . '/../view/main.php';
    }
}

?>