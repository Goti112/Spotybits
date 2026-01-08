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
                <li>Primer plato</li>
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
                    <div class="col-md-6 col-lg-4 producto-col" data-tipo="<?= htmlspecialchars($producto['tipo'] ?? '') ?>">
                        <form method="post" action="index.php?accion=agregarCarrito" class="h-100 d-flex">
                            <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto['id']) ?>">
                            <div class="card producto-card h-100 w-100">
                                <img src="/Web_Spotify/SPOTYBITS/spotybits/view/assets/productos/<?= htmlspecialchars($producto['imagen'] ?: 'default.jpg') ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <?= htmlspecialchars($producto['nombre']) ?>
                                    </h5>

                                    <p class="card-text">
                                        <?= htmlspecialchars($producto['descripcion']) ?>
                                    </p>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="precio">
                                            <?= number_format($producto['precio'], 2) ?> €
                                        </span>

                                        <button type="submit" class="btn btn-success btn-sm" aria-label="Añadir al carrito">Añadir al carrito</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <script>
                (function(){
                    const filtros = document.querySelectorAll('.filtros li');
                    const productos = document.querySelectorAll('.producto-col');

                    if (!filtros || filtros.length === 0) return;

                    filtros.forEach(li => li.addEventListener('click', function(){
                        filtros.forEach(x => x.classList.remove('activo'));
                        this.classList.add('activo');

                        const texto = this.textContent.trim().toLowerCase();
                        const map = {
                            'primer plato': 'primer',
                            'segundo plato': 'segundo',
                            'postres': 'postre',
                            'postre': 'postre',
                            'bebidas': 'bebida',
                            'bebida': 'bebida'
                        };

                        const tipo = map[texto] || null;

                        productos.forEach(col => {
                            const t = (col.dataset.tipo || '').toLowerCase();
                            if (!tipo) { col.style.display = ''; return; }
                            col.style.display = (t === tipo) ? '' : 'none';
                        });
                    }));
                })();
            </script>

        <?php endif; ?>
    </section>
</div>
