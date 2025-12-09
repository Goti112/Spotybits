<?php
require_once "config/config.php";

$pagina = $_GET['p'] ?? 'inicio';

switch ($pagina) {
    case 'productos':
        require "controller/api/ProductoController.php";
        (new ProductoController())->listar();
        break;

    default:
        require "view/main.php";
        break;
}

?>
