<div class="carrito-page p-4">

    <div class="carrito-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Carrito</h1>
        <a href="#" class="text-muted small cambiar-link">Cambiar</a>
    </div>

    <?php if (empty($carrito)): ?>
            <p class="text-muted text-center">El carrito está vacío</p>
    <?php else: ?>

<?php
require_once __DIR__ . '/../../model/dao/ProductoDAO.php';
$productoDAO = new ProductoDAO();
$total = 0;
?>

<!-- productos del carrito -->
<div class="row justify-content-center mb-5 productos-carrito">
    <?php foreach ($carrito as $idProducto => $cantidad): ?>
        <?php
            $producto = $productoDAO->obtenerPorId($idProducto);
            if (!$producto) continue;

            $cantidadNum = (int)$cantidad;
            $precio = $producto->getPrecio();
            $subtotal = $precio * $cantidadNum;
            $total += $subtotal;
        ?>

        <div class="col-md-4 mb-3">
            <div class="product-card compact h-100 shadow-sm">
                <div class="product-body p-3 d-flex flex-column">
                    <h5 class="product-name mb-1"><?= htmlspecialchars($producto->getNombre()) ?></h5>
                    <div class="product-desc small "><?= htmlspecialchars($producto->getDescripcion()) ?></div>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div>
                            <div class="precio fw-bold"><?= number_format($precio, 2) ?> €</div>
                            <div class="product-type small">Primer plato</div>
                        </div>

                        <div class="text-end">
                            <div class="text-muted small">x<?= $cantidadNum ?></div>
                            <div class="subtotal text-success fw-bold mt-1"><?= number_format($subtotal, 2) ?> €</div>
                            <form method="post" action="index.php?accion=eliminarCarrito" class="d-inline">
                                <input type="hidden" name="id_producto" value="<?= $idProducto ?>">
                                <button type="submit" class="btn btn-remove mt-2" aria-label="Eliminar">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

    <hr class="mb-5">


<!-- direccion -->

    <div class="row justify-content-center mb-5">
            <div class="col-md-6">
        <h4 class="mb-3">Dirección</h4>
        <p class="text-muted">Los impuestos se calculan en función de tu dirección.</p>

        <form id="direccion-form">
            <div class="mb-3">
                <label class="form-label">Calle</label>
                <input type="text" id="direccion_calle" name="calle" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Localidad</label>
                <input type="text" id="direccion_localidad" name="localidad" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <input type="text" id="direccion_estado" name="estado" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Código Postal</label>
                <input type="text" id="direccion_cp" name="codigo_postal" class="form-control">
            </div>

            <div class="d-flex gap-2 address-actions">
                <button type="button" class="btn btn-outline-light">
                    Guardar dirección
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
  <hr class="mb-5">

  <!-- resumen -->
  <div class="row justify-content-center mb-5">
      <div class="col-md-4">
          <h4 class="mb-3">Resumen</h4>

          <div class="summary-card p-3">
              <div class="summary-items mb-3">
                  <div class="fw-bold mb-2">Artículos</div>

                  <?php foreach ($carrito as $idProducto => $cantidad): ?>
                      <?php
                          $producto = $productoDAO->obtenerPorId($idProducto);
                          if (!$producto) continue;
                      ?>
                      <div class="d-flex justify-content-between mb-1 small">
                          <div class="text-truncate"><?= htmlspecialchars($producto->getNombre()) ?> x<?= (int)$cantidad ?></div>
                          <div class="text-muted"><?= number_format($producto->getPrecio(), 2) ?> €</div>
                      </div>
                  <?php endforeach; ?>
              </div>

              <hr>

              <div class="d-flex justify-content-between fw-bold">
                  <span>Total ahora</span>
                  <span><?= number_format($total, 2) ?> €</span>
              </div>
          </div>

          <form id="confirmar-pedido-form" method="post" action="index.php?accion=confirmarPedido" class="mt-4 text-center">
              <button type="submit" class="btn btn-complete px-5">
                  Completar compra
              </button>
          </form>
      </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const confirmForm = document.getElementById('confirmar-pedido-form');
    if(!confirmForm) return;

    confirmForm.addEventListener('submit', function(e){
        const fields = [
            ['calle','direccion_calle'],
            ['localidad','direccion_localidad'],
            ['estado','direccion_estado'],
            ['codigo_postal','direccion_cp']
        ];

        fields.forEach(pair => {
            const name = pair[0];
            const id = pair[1];
            const input = document.getElementById(id);
            const existing = confirmForm.querySelector('input[name="'+name+'"]');
            if (existing) existing.remove();
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = name;
            hidden.value = input ? input.value : '';
            confirmForm.appendChild(hidden);
        });
    });
});
</script>

  <?php endif; ?>

</div>
