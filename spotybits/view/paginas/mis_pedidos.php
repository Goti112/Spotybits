<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Mis Pedidos</h2>
            <?php if (!empty($usuarioNombre)): ?>
                <p class="text-muted">Hola, <?php echo htmlspecialchars($usuarioNombre); ?>. Aquí tienes el historial de tus pedidos.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($pedidos) || count($pedidos) === 0): ?>
        <div class="alert alert-info">No tienes pedidos todavía. Visita la <a href="index.php?pagina=carta">carta</a> para realizar tu primer pedido.</div>
    <?php else: ?>

        <!-- pedido mas reciente se destaca -->
        <?php if ($ultimoPedido): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-warning shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title mb-1">Último pedido</h5>
                                    <?php $dt = date_create($ultimoPedido['fecha']); ?>
                                    <p class="mb-1 text-muted">Fecha: <?php echo $dt ? date_format($dt, 'd/m/Y H:i') : htmlspecialchars($ultimoPedido['fecha']); ?></p>
                                    <p class="mb-0">Total: <strong><?php echo htmlspecialchars($ultimoPedido['importe_total_formateado']); ?> €</strong></p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-secondary">Estado: <?php echo htmlspecialchars($ultimoPedido['estado']); ?></span>
                                </div>
                            </div>

                            <hr>
                            <?php if (!empty($ultimoPedido['lineas'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio unidad</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ultimoPedido['lineas'] as $ln): ?>
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="d-flex align-items-center">
                                                            <?php if (!empty($ln['imagen'])): ?>
                                                                <img src="<?php echo htmlspecialchars($ln['imagen']); ?>" alt="" style="width:48px;height:48px;object-fit:cover;margin-right:10px;border-radius:6px;">
                                                            <?php endif; ?>
                                                            <div><?php echo htmlspecialchars($ln['nombre']); ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle"><?php echo (int)$ln['cantidad']; ?></td>
                                                    <td class="text-end align-middle"><?php echo htmlspecialchars($ln['precio_unidad']); ?> €</td>
                                                    <td class="text-end align-middle"><?php echo htmlspecialchars($ln['subtotal']); ?> €</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="mb-0">Este pedido no contiene productos.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- listado de todos los pedidos realizados -->
        <div class="row">
            <div class="col-12">
                <?php foreach ($pedidos as $idx => $pedido): ?>
                    <div class="card mb-3 <?php echo ($idx === 0) ? 'border-warning' : ''; ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h6>
                                    <?php $dtp = date_create($pedido['fecha']); ?>
                                    <small class="text-muted"><?php echo $dtp ? date_format($dtp, 'd/m/Y H:i') : htmlspecialchars($pedido['fecha']); ?></small>
                                </div>
                                <div class="text-end">
                                    <div class="mb-1">Total: <strong><?php echo htmlspecialchars($pedido['importe_total_formateado']); ?> €</strong></div>
                                    <div><span class="badge bg-info text-dark"><?php echo htmlspecialchars($pedido['estado']); ?></span></div>
                                </div>
                            </div>

                            <hr>

                            <?php if (!empty($pedido['lineas'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-dark table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                <th class="text-end">Precio unidad</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pedido['lineas'] as $ln): ?>
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="d-flex align-items-center">
                                                            <?php if (!empty($ln['imagen'])): ?>
                                                                <img src="<?php echo htmlspecialchars($ln['imagen']); ?>" alt="" style="width:40px;height:40px;object-fit:cover;margin-right:10px;border-radius:6px;">
                                                            <?php endif; ?>
                                                            <div><?php echo htmlspecialchars($ln['nombre']); ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle"><?php echo (int)$ln['cantidad']; ?></td>
                                                    <td class="text-end align-middle"><?php echo htmlspecialchars($ln['precio_unidad']); ?> €</td>
                                                    <td class="text-end align-middle"><?php echo htmlspecialchars($ln['subtotal']); ?> €</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="mb-0">Sin productos en este pedido.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endif; ?>

</div>
