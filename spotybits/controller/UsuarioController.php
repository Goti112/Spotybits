<?php

require_once __DIR__ . '/../model/dao/UsuarioDAO.php';

class UsuarioController {

    //mostrar formulario de registro
    public function mostrarRegistro() {
    $ruta = __DIR__ . "/../view/paginas/registro.php";
    require __DIR__ . '/../view/main.php';
        }


    //mostrar formulario de login
    public function mostrarLogin() {
    $ruta = __DIR__ . "/../view/paginas/login.php";
    require __DIR__ . '/../view/main.php';
        }

    public function registrar() {
        if (!isset($_POST['nombre'])) {
            header ("Location: index.php?accion=registro");
            exit;
        }

        $usuarioDAO = new UsuarioDAO();

        $nuevoUsuario = new Usuario(
            null,
            $_POST['nombre'],
            $_POST['email'],
            $_POST['contrasena'],
            $_POST['direccion'],
            $_POST['telefono'],
            "cliente"   
        );

        $usuarioDAO->registrar($nuevoUsuario);

        header("Location: index.php?accion=login&registro=1");
    }

    public function login() {
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO ->obtenerPorEmail($_POST['email']);

        if (!$usuario) {
            header("Location: index.php?accion=login&error=1");
            exit;
        }

        if (!password_verify($_POST['contrasena'], $usuario->getContrasena())) {
            header("Location: index.php?accion=login&error=1");
            exit;
        }

        session_start();
        $_SESSION['usuario'] = $usuario->getNombre();
        $_SESSION['id_usuario'] = $usuario->getIdUsuario();

        header("Location: index.php?accion=home");
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?accion=home");
    }



}











