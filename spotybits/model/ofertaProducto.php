<?php

class pedido {
    private int $id_oferta;
    private string $nombre;
    private float $descuento;
    private DateTime $fecha_inicio;
    private DateTime $fecha_fin;
    
    public function __construct($id_oferta, $nombre, $descuento, $fecha_inicio, $fecha_fin) {
        $this->id_oferta = $id_oferta;
        $this->nombre = $nombre;
        $this->descuento = $descuento;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function getIdProducto() {
        return $this->id_oferta;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescuento() {
        return $this->descuento;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function setIdProducto($id_oferta) {
        $this->id_oferta = $id_oferta;
    }

}
?>