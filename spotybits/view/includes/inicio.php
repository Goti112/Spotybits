<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotyBits - Inicio</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Web_Spotify/ss">
</head>
<body class="bg-dark text-white">

    <!-- BANNER PRINCIPAL -->
    <section id="banner-principal" class="banner-principal position-relative">
        <div class="banner-fondo"></div>
        <div class="container position-relative texto-banner">
            <h1 class="fw-bold titulo-banner">Descubre nuestros platos más populares</h1>
            <button class="btn btn-light mt-3 btn-banner">Ver Menú</button>
        </div>
    </section>

    <!-- SECCIÓN NOVEDADES (AHORA CON ESTILO UNIFICADO) -->
    <section class="container mt-5">
        <h2 class="fw-bold mb-4">Novedades</h2>

        <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
            
            <!-- Tarjeta Novedad 1 -->
            <div class="col">
                <div class="tarjeta-plato shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/Spagetis_V.png" 
                         class="img-novedad" alt="Tagliatelle al Pesto">
                    <div class="p-4 text-center bg-dark">
                        <h5 class="fw-bold mb-2">Tagliatelle al Pesto Genovese</h5>
                        <p class="descripcion-plato mb-0">Pasta fresca con pesto de albahaca, parmesano y piñones.</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Novedad 2 -->
            <div class="col">
                <div class="tarjeta-plato shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/Costillas.png" 
                         class="img-novedad" alt="Bacon Cheeseburger">
                    <div class="p-4 text-center bg-dark">
                        <h5 class="fw-bold mb-2">Bacon Cheeseburger Premium</h5>
                        <p class="descripcion-plato mb-0">Carne 100% vacuno a la parrilla, cheddar fundido y bacon crujiente</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- SECCIÓN TOP VENTAS (ya corregida y centrada con 5 tarjetas) -->
    <section class="container mt-5">
        <h2 class="fw-bold mb-4">Top ventas</h2>

        <div class="row row-cols-2 row-cols-md-5 g-3 g-md-4 justify-content-center">
            <div class="col">
                <div class="tarjeta-pequena shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/producto1.jpg" class="img-top" alt="Classic Burger">
                    <div class="p-3 text-center bg-dark"><h6 class="fw-bold mb-1">Classic Burger</h6><p class="precio-plato mb-0">12,99€</p></div>
                </div>
            </div>
            <div class="col">
                <div class="tarjeta-pequena shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/producto2.jpg" class="img-top" alt="Pizza Margherita">
                    <div class="p-3 text-center bg-dark"><h6 class="fw-bold mb-1">Pizza Margherita</h6><p class="precio-plato mb-0">10,90€</p></div>
                </div>
            </div>
            <div class="col">
                <div class="tarjeta-pequena shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/producto3.jpg" class="img-top" alt="Ensalada César">
                    <div class="p-3 text-center bg-dark"><h6 class="fw-bold mb-1">Ensalada César</h6><p class="precio-plato mb-0">9,50€</p></div>
                </div>
            </div>
            <div class="col">
                <div class="tarjeta-pequena shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/producto4.jpg" a class="img-top" alt="Tiramisú">
                    <div class="p-3 text-center bg-dark"><h6 class="fw-bold mb-1">Tiramisú</h6><p class="precio-plato mb-0">6,50€</p></div>
                </div>
            </div>
            <div class="col">
                <div class="tarjeta-pequena shadow rounded tarjeta-hover overflow-hidden">
                    <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/producto5.png" class="img-top" alt="Pasta Carbonara">
                    <div class="p-3 text-center bg-dark"><h6 class="fw-bold mb-1">Pasta Carbonara</h6><p class="precio-plato mb-0">11,90€</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
     SECCIÓN PROMOCIONES
========================== -->
<section class="container mt-5 mb-5">
    <h2 class="fw-bold mb-4">Promociones</h2>

    <div class="tarjeta-promocion p-4 p-lg-5 rounded shadow-lg overflow-hidden">
        <div class="row align-items-center g-4 g-lg-5">
            
            <!-- IMAGEN A LA IZQUIERDA -->
            <div class="col-lg-5 text-center text-lg-start">
                <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/promocion.png" 
                     alt="Promoción especial" 
                     class="img-promocion rounded">
            </div>

            <!-- TEXTO Y BOTÓN A LA DERECHA -->
            <div class="col-lg-7">
                <h4 class="fw-bold mb-3">
                    Tu mesa, tu música. Disfruta de una experiencia única
                </h4>
                <p class="text-white-50 mb-4">
                    Reserva ahora y elige la playlist que sonará en tu mesa. ¡Solo en SpotyBits!
                </p>
                <button class="btn btn-light btn-promocion px-4 py-2">Reservar ahora</button>
            </div>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>