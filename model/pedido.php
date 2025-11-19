<?php

class oferta_pedido {
    private int $id_pedido;
    private DateTime $fecha;
    private float $importe_total;
    private string $estado;
    private int $id_usuario;
    private int $id_oferta;

    public function __construct($id_pedido, $fecha, $importe_total, $estado, $id_usuario, $id_oferta) {
        $this->id_pedido = $id_pedido;
        $this->fecha = $fecha;
        $this->importe_total = $importe_total;
        $this->estado = $estado;
        $this->id_usuario = $id_usuario;
        $this->id_oferta = $id_oferta;
    }

    public function getIdPedido() {
        return $this->id_pedido;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getImporteTotal() {
        return $this->importe_total;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getIdOferta() {
        return $this->id_oferta;
    }

    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setImporteTotal($importe_total) {
        $this->importe_total = $importe_total;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setIdOferta($id_oferta) {
        $this->id_oferta = $id_oferta;
    }

}
?>

