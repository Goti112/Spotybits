<?php 

require_once __DIR__ . '/../model/dao/ProductoDAO.php';

class ProductoController {

    public function mostrarCarta() {
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->obtenerTodos();

        $ruta = __DIR__ . '/../view/paginas/carta.php';

        require __DIR__ . '/../view/main.php';
    }
}

