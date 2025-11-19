<?php

class log {
    private $id_log;
    private $fecha;
    private $accion;
    private $id_usuario;

    public function __construct($id_log, $fecha, $accion, $id_usuario) {
        $this->id_log = $id_log;
        $this->fecha = $fecha;
        $this->accion = $accion;
        $this->id_usuario = $id_usuario;
    }

    public function getIdLog() {
        return $this->id_log;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getAccion() {
        return $this->accion;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdLog($id_log) {
        $this->id_log = $id_log;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setAccion($accion) {
        $this->accion = $accion;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
}