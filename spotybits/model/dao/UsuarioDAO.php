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

        try {
            return $stmt->execute([
                $usuario->getNombre(),
                $usuario->getEmail(),
                $contrasenaHash,
                $usuario->getDireccion(),
                $usuario->getTelefono(),
                $usuario->getTipoUsuario()
            ]);
        } catch (PDOException $e) {
            // Si es un duplicate entry (MySQL 1062) lo convertimos en excepción controlada
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                throw new Exception('duplicate_email', 1062);
            }
            // Otros errores se re-lanzan
            throw $e;
        }
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

    //obtener el usuario por el id
    public function obtenerPorId($id) {
        $db = Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
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