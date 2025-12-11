<?php 

require_once __DIR__ . '/../usuario.php';
require_once __DIR__ . '/../../database/database.php';

class UsuarioDAO {

    //registrar usuario
    public function registrar(Usuario $usuario) {
        $db = Database::getConnection();
        $sql = "INSERT INTO usuarios (nombre, email, contrasena, direccion, telefono, tipo_usuario)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($sql);


        //encriptar contraseña
        $contrasenaHash = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);

        return $stmt->execute([
            $usuario->getNombre(),
            $usuario->getEmail(),
            $contrasenaHash,
            $usuario->getDireccion(),
            $usuario->getTelefono(),
            $usuario->getTipoUsuario()
        ]);
    }

    //buscar usuario por email
    public function obtenerPorEmail($email) {
        $db = Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) return null;

        return new Usuario(
            $fila['id_usuario'],
            $fila['nombre'],
            $fila['email'],
            $fila['contrasena'],
            $fila['direccion'],
            $fila['telefono'],
            $fila['tipo_usuario']
        );

    }




}