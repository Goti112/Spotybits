<?php 

class Usuario {
    private ?int $id_usuario;
    private string $nombre;
    private string $email;
    private string $contrasena;
    private ?string $direccion;
    private ?string $telefono;
    private string $tipo_usuario;


    public function __construct($id_usuario, $nombre, $email, $contrasena, ?string $direccion, ?string $telefono, $tipo_usuario) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->tipo_usuario = $tipo_usuario;
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

    public function getContrasena() {
        return $this->contrasena;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getTipoUsuario() {
        return $this->tipo_usuario;
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

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setTipoUsuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

}
?>