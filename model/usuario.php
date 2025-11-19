<?php

class oferta_pedido {
    private int $id_usuario;
    private string $nombre;
    private string $email;
    private string $contraseña;
    private string $direccion;
    private string $telefono;

    public function __construct($id_usuario, $nombre, $email, $contraseña, $direccion, $telefono) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contraseña = $contraseña;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getContraseña() {
        return $this->contraseña;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

}
?>