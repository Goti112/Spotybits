<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- TARJETA PERFIL -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-black text-white text-center py-4 rounded-top-4">
                    <i class="bi bi-person-circle fs-1"></i>
                    <h4 class="mt-2 mb-0">Mi perfil</h4>
                </div>

                <div class="card-body p-4">

                    <!-- DATOS USUARIO -->
                    <form method="post" action="index.php?accion=actualizarPerfil">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text"
                                   name="nombre"
                                   class="form-control"
                                   value="<?= htmlspecialchars($usuario->getNombre()) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="<?= htmlspecialchars($usuario->getEmail()) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Teléfono</label>
                            <input type="text"
                                   name="telefono"
                                   class="form-control"
                                   value="<?= htmlspecialchars($usuario->getTelefono() ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Dirección</label>
                            <input type="text"
                                   name="direccion"
                                   class="form-control"
                                   value="<?= htmlspecialchars($usuario->getDireccion() ?? '') ?>">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-save"></i> Guardar cambios
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- CAMBIAR CONTRASEÑA -->
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-shield-lock"></i> Cambiar contraseña
                    </h5>

                    <form method="post" action="index.php?accion=cambiarPassword">

                        <div class="mb-3">
                            <label class="form-label">Contraseña actual</label>
                            <input type="password"
                                   name="password_actual"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password"
                                   name="password_nueva"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Repetir nueva contraseña</label>
                            <input type="password"
                                   name="password_repetida"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="bi bi-key"></i> Cambiar contraseña
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
