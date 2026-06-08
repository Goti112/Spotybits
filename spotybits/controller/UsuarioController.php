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
        // cerrar sesion y registrar logout en logs
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

    public function perfil() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // si no hay usuario logueado, fuera
    if (empty($_SESSION['id_usuario'])) {
        header("Location: index.php?accion=loginForm");
        exit;
    }

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->obtenerPorId($_SESSION['id_usuario']);

    if (!$usuario) {
        $_SESSION['error'] = 'No se pudo cargar el perfil';
        header("Location: index.php?pagina=home");
        exit;
    }

    $ruta = __DIR__ . "/../view/paginas/perfil.php";
    require __DIR__ . '/../view/main.php';
}

public function mostrarPerfil() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // si no hay sesión, fuera
    if (empty($_SESSION['id_usuario'])) {
        header("Location: index.php?accion=loginForm");
        exit;
    }

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->obtenerPorId($_SESSION['id_usuario']);

    if (!$usuario) {
        $_SESSION['error'] = 'Usuario no encontrado';
        header("Location: index.php?pagina=home");
        exit;
    }

    $ruta = __DIR__ . "/../view/paginas/perfil.php";
    require __DIR__ . '/../view/main.php';
}

public function actualizarPerfil() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    if (empty($_SESSION['id_usuario'])) {
        $_SESSION['error'] = 'Debes iniciar sesión';
        header("Location: index.php?accion=loginForm");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?pagina=perfil");
        exit;
    }

    $idUsuario = $_SESSION['id_usuario'];

    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if ($nombre === '' || $email === '') {
        $_SESSION['error'] = 'Nombre y email son obligatorios';
        header("Location: index.php?pagina=perfil");
        exit;
    }

    require_once __DIR__ . '/../model/dao/UsuarioDAO.php';
    require_once __DIR__ . '/../model/dao/LogDAO.php';

    $usuarioDAO = new UsuarioDAO();
    $logDAO = new LogDAO();

    try {
        $usuarioDAO->actualizarPerfil(
            $idUsuario,
            $nombre,
            $email,
            $telefono,
            $direccion
        );

        $_SESSION['usuario'] = $nombre; // refrescar navbar

        $logDAO->registrar($idUsuario, 'ACTUALIZAR PERFIL');

        $_SESSION['success'] = 'Perfil actualizado correctamente';
    } catch (Exception $e) {
        $_SESSION['error'] = 'No se pudo actualizar el perfil';
    }

    header("Location: index.php?pagina=perfil");
    exit;
}

public function guardarPerfil() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // usuario debe estar logueado
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    if (!$id_usuario) {
        $_SESSION['error'] = "Debes iniciar sesión para actualizar tu perfil.";
        header("Location: index.php?accion=loginForm");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?pagina=perfil");
        exit;
    }

    require_once __DIR__ . '/../model/dao/UsuarioDAO.php';
    $usuarioDAO = new UsuarioDAO();

    // obtener usuario actual
    $usuario = $usuarioDAO->obtenerPorId($id_usuario);
    if (!$usuario) {
        $_SESSION['error'] = "Usuario no encontrado.";
        header("Location: index.php?pagina=perfil");
        exit;
    }

    // recoger datos del POST
    $nombre = $_POST['nombre'] ?? $usuario->getNombre();
    $email = $_POST['email'] ?? $usuario->getEmail();
    $direccion = $_POST['direccion'] ?? $usuario->getDireccion();
    $telefono = $_POST['telefono'] ?? $usuario->getTelefono();

    // actualizar usuario en DAO
    try {
        $usuarioDAO->actualizarPerfil($id_usuario, $nombre, $email, $direccion, $telefono);

        // actualizar session
        $_SESSION['usuario'] = $nombre;

        $_SESSION['success'] = "Perfil actualizado correctamente.";
        header("Location: index.php?pagina=perfil");
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = "Error al actualizar el perfil: " . $e->getMessage();
        header("Location: index.php?pagina=perfil");
        exit;
    }
}


public function cambiarPassword() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    if (empty($_SESSION['id_usuario'])) {
        $_SESSION['error'] = 'Debes iniciar sesión';
        header("Location: index.php?accion=loginForm");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?pagina=perfil");
        exit;
    }

    $idUsuario = $_SESSION['id_usuario'];

    $actual   = $_POST['password_actual'] ?? '';
    $nueva    = $_POST['password_nueva'] ?? '';
    $repetida = $_POST['password_repetida'] ?? '';

    if ($nueva !== $repetida) {
        $_SESSION['error'] = 'Las contraseñas nuevas no coinciden';
        header("Location: index.php?pagina=perfil");
        exit;
    }

    if (strlen($nueva) < 6) {
        $_SESSION['error'] = 'La nueva contraseña debe tener al menos 6 caracteres';
        header("Location: index.php?pagina=perfil");
        exit;
    }

    require_once __DIR__ . '/../model/dao/UsuarioDAO.php';
    require_once __DIR__ . '/../model/dao/LogDAO.php';

    $usuarioDAO = new UsuarioDAO();
    $logDAO = new LogDAO();

    $usuario = $usuarioDAO->obtenerPorId($idUsuario);

    if (!$usuario || !password_verify($actual, $usuario->getContrasena())) {
        $_SESSION['error'] = 'La contraseña actual no es correcta';
        header("Location: index.php?pagina=perfil");
        exit;
    }

    try {
        $hashNueva = password_hash($nueva, PASSWORD_DEFAULT);
        $usuarioDAO->actualizarPassword($idUsuario, $hashNueva);

        $logDAO->registrar($idUsuario, 'CAMBIAR CONTRASEÑA');

        $_SESSION['success'] = 'Contraseña actualizada correctamente';
    } catch (Exception $e) {
        $_SESSION['error'] = 'No se pudo cambiar la contraseña';
    }

    header("Location: index.php?pagina=perfil");
    exit;
}



}