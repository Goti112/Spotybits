<h1 class="mb-4 text-white">Explora nuestros platos</h1>

<div class="row">
    <!-- sidebar -->
    <aside class="col-md-3 mb-4">
        <div class="card sidebar p-3">
            <div class="usuario mb-4">
                <i class="bi bi-person-circle"></i>
                <span>Usuario</span>
            </div>

            <div class="filtro-titulo">Tipo de plato</div>
            <ul class="list-unstyled filtros">
                <li class="activo">Primer plato</li>
                <li>Segundo plato</li>
                <li>Postres</li>
                <li>Bebidas</li>
            </ul>
        </div>
    </aside>

    <!-- productos -->
    <section class="col-md-9">
        <?php if (empty($productos)): ?>
            <p class="text-muted">No hay productos disponibles</p>
        <?php else: ?>

            <div class="row g-4">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card producto-card h-100">
                            <img src="/Web_Spotify/SPOTYBITS/spotybits/view/img/productos/default.jpg"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars($producto->getNombre()) ?>">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($producto->getNombre()) ?>
                                </h5>

                                <p class="card-text">
                                    <?= htmlspecialchars($producto->getDescripcion()) ?>
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="precio">
                                        <?= number_format($producto->getPrecio(), 2) ?> €
                                    </span>

                                    <button class="btn btn-add" aria-label="Añadir al carrito">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </section>
</div>
