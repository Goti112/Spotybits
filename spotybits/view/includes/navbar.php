<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-black py-3 sticky-top">
    <div class="container-fluid px-3">

        <!-- logo y nombre -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/Logo_SpotyBits.svg" 
                 alt="Logo de SpotyBits" 
                 width="45" 
                 class="me-2">
            <span class="fw-bold">SpotyBits</span>
        </a>

        <!-- botón hamburguesa responsive -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#barraNavegacion" aria-controls="barraNavegacion" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- enlaces -->
        <div class="collapse navbar-collapse" id="barraNavegacion">
            <ul class="navbar-nav ms-auto align-items-lg-center flex-column flex-lg-row">

                <li class="nav-item mx-lg-2 my-2 my-lg-0">
                    <a class="nav-link" href="?pagina=home">Inicio</a>
                </li>

                <li class="nav-item mx-lg-2 my-2 my-lg-0">
                    <a class="nav-link" href="?pagina=carta">Carta</a>
                </li>

                <?php if (!empty($_SESSION['id_usuario'])): ?>
                <li class="nav-item mx-lg-2 my-2 my-lg-0">
                    <a class="nav-link" href="?pagina=mis_pedidos">Mis Pedidos</a>
                </li>
                <?php endif; ?>

                <li class="nav-item mx-lg-2 my-2 my-lg-0">
                    <a class="nav-link" href="?pagina=carrito">Carrito</a>
                </li>

                <!-- palo divisor -->
                <span class="palo mx-lg-3 my-2 my-lg-0 d-none d-lg-inline">|</span>

                <?php if (!empty($_SESSION['id_usuario'])): ?>

                    <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link text-success fw-bold" href="?pagina=admin">Panel Admin</a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link nav-bienvenido" href="?pagina=perfil">
                            <i class="bi bi-person-circle me-1"></i>Bienvenido, <?= htmlspecialchars($_SESSION['usuario'] ?? '') ?>
                        </a>
                    </li>

                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="index.php?accion=logout">Cerrar Sesión</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="index.php?accion=registro">Registrarse</a>
                    </li>

                    <li class="nav-item mx-lg-2 my-2 my-lg-0">
                        <a class="nav-link" href="index.php?accion=loginForm">Iniciar Sesión</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>
