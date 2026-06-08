<div class="contenedor-registro">
    <h2 class="titulo-registro">Crear cuenta</h2>

    <form action="index.php?accion=registrar" method="POST" class="form-registro">

        <label>Nombre</label>
        <input type="text" name="nombre" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Contraseña</label>
        <input type="password" name="contrasena" required>

        <label>Dirección</label>
        <input type="text" name="direccion">

        <label>Teléfono</label>
        <input type="text" name="telefono">

        <button type="submit" class="boton-registrar">Registrarse</button>
    </form>
</div>
