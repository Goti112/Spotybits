
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
                    <a class="nav-link" href="?page=inicio">Inicio</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="?page=carta">Carta</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="?page=carrito">Carrito</a>
                </li>

                <!-- palo que divide -->
                <span class="palo mx-3">|</span>

                <!-- los botones se muestran según si el usuario está conectado o no -->
                <?php if (!empty($_SESSION['id_usuario'])): ?>
                    
                    <!-- si el usuario está conectado -->
                    <li class="nav-item mx-2">
                        <span class="text-white">
                            Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>
                        </span>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="?page=cerrarSesion">Cerrar Sesión</a>
                    </li>

                <?php else: ?>

                    <!-- si el usuario NO está conectado -->
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="?page=registro">Registrarse</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link btn" href="?page=iniciarSesion">Iniciar Sesión</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>
