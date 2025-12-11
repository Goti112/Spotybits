<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>

<h2>Crear cuenta</h2>

<form action="index.php?accion=registrar" method="POST">

    <label>Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Contraseña:</label>
    <input type="password" name="contrasena" required><br>

    <label>Dirección:</label>
    <input type="text" name="direccion"><br>

    <label>Teléfono:</label>
    <input type="text" name="telefono"><br>

    <button type="submit">Registrarse</button>
</form>

</body>
</html>
