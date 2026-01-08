<?php

class producto {
    private int $id_producto;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private ?int $id_oferta;
    private ?string $imagen;
    private ?string $tipo;


    public function __construct($id_producto, $nombre, $descripcion, $precio, $stock, ?int $id_oferta, $imagen = null, $tipo = null) {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->id_oferta = $id_oferta;
        $this->imagen = $imagen;
        $this->tipo = $tipo;
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

    public function getImagen() {
        return $this->imagen;
    }

    public function getTipo() {
        return $this->tipo;
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

    public function setIdOferta(?int $id_oferta) {
        $this->id_oferta = $id_oferta;
    }

    public function setTipo(?string $tipo) {
        $this->tipo = $tipo;
    }

}
?>