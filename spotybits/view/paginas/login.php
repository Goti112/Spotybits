<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>
<body>

<h2>Iniciar sesión</h2>

<?php if (isset($_GET['error'])): ?>
<p style="color:red;">Email o contraseña incorrectos</p>
<?php endif; ?>

<form action="index.php?pagina=login" method="POST">

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Contraseña:</label>
    <input type="password" name="contrasena" required><br>

    <button type="submit">Entrar</button>
</form>

</body>
</html>
