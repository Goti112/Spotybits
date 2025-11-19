<?php

class oferta_pedido {
    private $id_oferta;
    private $nombre;
    private $descuento;
    private $fecha_inicio;
    private $fecha_fin;

    public function __construct($id_oferta, $nombre, $descuento, $fecha_inicio, $fecha_fin) {
        $this->id_oferta = $id_oferta;
        $this->nombre = $nombre;
        $this->descuento = $descuento;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function getIdOferta() {
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

    public function setIdOferta($id_oferta) {
        $this->id_oferta = $id_oferta;
    }
}
?>
