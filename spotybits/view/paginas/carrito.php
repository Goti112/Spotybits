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

    <?php
    require_once __DIR__ . '/../../model/dao/OfertaDAO.php';
    $ofertaDAO = new OfertaDAO();
    $ofertaActiva = $ofertaDAO->obtenerOfertaActiva();

    $totalAntesDescuento = round($total, 2);
    $descuento = 0.0;
    $totalFinal = $totalAntesDescuento;
    if ($ofertaActiva) {
        $minimo = (float)$ofertaActiva['minimo_compra'];
        $porcentaje = (float)$ofertaActiva['porcentaje'];
        if ($totalAntesDescuento >= $minimo) {
            $descuento = round($totalAntesDescuento * ($porcentaje / 100.0), 2);
            $totalFinal = round($totalAntesDescuento - $descuento, 2);
        }
    }
    ?>

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

              <div class="mb-2 d-flex justify-content-between">
                  <span>Total sin descuento</span>
                  <span><?= number_format($totalAntesDescuento, 2) ?> €</span>
              </div>

              <?php if ($descuento > 0): ?>
                  <div class="mb-2 d-flex justify-content-between text-warning">
                      <span>Descuento aplicado</span>
                      <span>- <?= number_format($descuento, 2) ?> €</span>
                  </div>
                  <div class="d-flex justify-content-between fw-bold">
                      <span>Total final</span>
                      <span><?= number_format($totalFinal, 2) ?> €</span>
                  </div>
              <?php else: ?>
                  <div class="d-flex justify-content-between fw-bold">
                      <span>Total ahora</span>
                      <span><?= number_format($totalAntesDescuento, 2) ?> €</span>
                  </div>
              <?php endif; ?>
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
