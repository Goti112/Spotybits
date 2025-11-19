<?php

class oferta_pedido {
    private int $id_producto;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private int $id_oferta;

    public function __construct($id_producto, $nombre, $descripcion, $precio, $stock, $id_oferta) {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->id_oferta = $id_oferta;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getIdOferta() {
        return $this->id_oferta;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function setIdOferta($id_oferta) {
        $this->id_oferta = $id_oferta;
    }

}
?>