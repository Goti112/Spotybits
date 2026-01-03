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
</ul>
        </div>
    </aside>

    <!-- contenido principal -->
    <section class="col-md-9">
        <div class="card bg-dark text-white p-4">

            <div id="admin-contenido">
    <!-- carga todo dinamicamente -->
            </div>

        </div>
    </section>

</div>

<script src="/Web_Spotify/SPOTYBITS/spotybits/view/js/admin.js"></script>
