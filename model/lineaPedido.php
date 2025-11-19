<?php

class lineaPedido {
    private $id_linea;
    private $id_pedido;
    private $id_producto;
    private $cantidad;
    private $precio_unidad;

    public function __construct($id_linea, $id_pedido, $id_producto, $cantidad, $precio_unidad) {
        $this->id_linea = $id_linea;
        $this->id_pedido = $id_pedido;
        $this->id_producto = $id_producto;
        $this->cantidad = $cantidad;
        $this->precio_unidad = $precio_unidad;
    }

    public function getIdLinea() {
        return $this->id_linea;
    }

    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getPrecioUnidad() {
        return $this->precio_unidad;
    }

    public function setIdLinea($id_linea) {
        $this->id_linea = $id_linea;
    }

}
?>