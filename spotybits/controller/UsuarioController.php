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

        // iniciamos sesión para pasar mensajes flash
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $usuarioDAO = new UsuarioDAO();

        $email = $_POST['email'] ?? '';

        //si ya existe el email mostramos mensaje y redirigimos
        if ($usuarioDAO->obtenerPorEmail($email) !== null) {
            $_SESSION['error'] = 'El correo ya está registrado';
            header("Location: index.php?accion=registro");
            exit;
        }

        $nuevoUsuario = new Usuario(
            null,
            $_POST['nombre'],
            $email,
            $_POST['contrasena'],
            $_POST['direccion'],
            $_POST['telefono'],
            "cliente"   
        );

        try {
    $ok = $usuarioDAO->registrar($nuevoUsuario);
    if ($ok) {
        //redirigimos al login limpio, sin mensajes de sesión
        header("Location: index.php?accion=login");
        exit;
    } else {
        $_SESSION['error'] = 'No se pudo registrar el usuario. Intenta de nuevo.';
        header("Location: index.php?accion=registro");
        exit;
    }
} catch (Exception $e) {
    if ($e->getCode() == 1062 || $e->getMessage() === 'duplicate_email') {
        $_SESSION['error'] = 'El correo ya está registrado';
    } else {
        $_SESSION['error'] = 'Error al registrar el usuario. Inténtalo más tarde.';
        error_log('Error registrar usuario: ' . $e->getMessage());
    }  
    header("Location: index.php?accion=registro");
    exit;
}
    }

    public function login() {
    //si no hay POST, solo mostramos el formulario
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->mostrarLogin();
        return;
    }

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $usuarioDAO = new UsuarioDAO();

    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $usuario = $usuarioDAO->obtenerPorEmail($email);

    if (!$usuario) {
        $_SESSION['error'] = 'Email incorrecto. Intenta de nuevo.';
        $this->mostrarLogin();
        return;
    }

    if (!password_verify($contrasena, $usuario->getContrasena())) {
        $_SESSION['error'] = 'Contraseña incorrecta. Intenta de nuevo.';
        $this->mostrarLogin();
        return;
    }

    // login correcto
    $_SESSION['usuario'] = $usuario->getNombre();
    $_SESSION['id_usuario'] = $usuario->getIdUsuario();
    $_SESSION['tipo_usuario'] = $usuario->getTipoUsuario();

    require_once __DIR__ . '/../model/dao/LogDAO.php';
    $logDAO = new LogDAO();
    $logDAO->registrar(
        $usuario->getIdUsuario(),
        'LOGIN'
);

    header("Location: index.php?pagina=home");
}

    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        require_once __DIR__ . '/../model/dao/LogDAO.php';
        $logDAO = new LogDAO();
        $logDAO->registrar(
            $_SESSION['id_usuario'] ?? null,
            'LOGOUT'
);
        session_destroy();
        header("Location: index.php?pagina=home");
    }

}