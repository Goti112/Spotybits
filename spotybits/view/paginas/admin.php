<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: index.php?pagina=home');
    exit;
}
?>

<h1 class="mb-4">Panel de Administración</h1>

<div class="row">

    <!-- menu lateral -->
    <aside class="col-md-3 mb-4">
        <div class="card bg-dark text-white p-3">
            <h5 class="mb-3">Administración</h5>

            <ul class="list-group list-group-flush">
    <button type="button"
        class="list-group-item list-group-item-action bg-dark text-white menu-item"
        data-seccion="productos">
        📦 Productos
    </button>

    <button type="button"
        class="list-group-item list-group-item-action bg-dark text-white menu-item"
        data-seccion="pedidos">
        🧾 Pedidos
    </button>

    <button type="button"
        class="list-group-item list-group-item-action bg-dark text-white menu-item"
        data-seccion="logs">
        📊 Logs
    </button>

    <button type="button"
        class="list-group-item list-group-item-action bg-dark text-white menu-item"
        data-seccion="monedas">
        💱 Monedas
    </button>
    
    <button type="button"
        class="list-group-item list-group-item-action bg-dark text-white menu-item"
        data-seccion="ofertas">
        🎯 Ofertas
    </button>
</ul>
        </div>
    </aside>

    <!-- contenido principal -->
    <section class="col-md-9">
        <div class="card bg-dark text-white p-4">

            <div id="admin-contenido">
    <!-- carga todo dinamicamente -->
            </div>

            <hr class="my-4">

            <!-- formulario para administrar una oferta (oculto por defecto, se muestra en la sección 'ofertas') -->
            <div id="oferta-form-wrapper" style="display:none">
            <?php
                require_once __DIR__ . '/../../model/dao/OfertaDAO.php';
                $ofertaDAO = new OfertaDAO();
                $ofertaActiva = $ofertaDAO->obtenerOfertaActiva();
            ?>

            <h5 class="mb-3">Oferta global (simple)</h5>
            <form method="post" action="index.php?accion=guardarOferta" class="row g-3">
                <input type="hidden" name="id_oferta" value="<?= $ofertaActiva['id_oferta'] ?? '' ?>">

                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input name="nombre" class="form-control" value="<?= htmlspecialchars($ofertaActiva['nombre'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">% Descuento</label>
                    <input name="porcentaje" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($ofertaActiva['porcentaje'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Mínimo compra</label>
                    <input name="minimo_compra" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($ofertaActiva['minimo_compra'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="activa" id="activa" <?= (!empty($ofertaActiva) && $ofertaActiva['activa']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="activa">Marcar como activa</label>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Guardar oferta</button>
                </div>
            </form>
            </div>

        </div>
    </section>

</div>

<script src="/Web_Spotify/SPOTYBITS/spotybits/view/js/admin.js"></script>
