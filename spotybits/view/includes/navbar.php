<?php
// Seguridad: si por alguna razón no se ha iniciado la sesión la iniciamos
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<link rel="stylesheet" href="/Web_Spotify/SPOTYBITS/spotybits/view/css/navbar.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
    <div class="container">

        <!-- logo y nombre -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/Logo_SpotyBits.png" 
                 alt="Logo de SpotyBits" 
                 width="45" 
                 class="me-2">
            <span class="fw-bold">SpotyBits</span>
        </a>

        <!-- enlaces -->
        <div class="collapse navbar-collapse justify-content-end" id="barraNavegacion">
            <ul class="navbar-nav align-items-center">

                <li class="nav-item mx-2">
                    <a class="nav-link" href="?pagina=home">Inicio</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="?pagina=carta">Carta</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="?pagina=carrito">Carrito</a>
                </li>

                <!-- palo que divide -->
                <span class="palo mx-3">|</span>

                <!-- los botones se muestran según si el usuario está conectado o no -->
                <?php if (!empty($_SESSION['id_usuario'])): ?>
                    
                    <!-- si el usuario está conectado -->
                    <li class="nav-item mx-2">
                        <span class="text-white">
                            Bienvenido, <?= htmlspecialchars($_SESSION['usuario'] ?? '') ?>
                        </span>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="index.php?accion=logout">Cerrar Sesión</a>
                    </li>

                <?php else: ?>

                    <!-- si el usuario NO está conectado -->
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="index.php?accion=registro">Registrarse</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="index.php?accion=loginForm">Iniciar Sesión</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>