<link rel="stylesheet" href="view/css/login.css">

<div class="contenedor-login">

    <h2 class="titulo-login">Iniciar sesión</h2>

    <form action="index.php?accion=login" method="POST" class="form-login">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Contraseña</label>
        <input type="password" name="contrasena" required>

        <button type="submit" class="boton-login">Entrar</button>
    </form>

    <p class="texto-registro">¿No tienes cuenta?  
        <a href="index.php?accion=registro">Regístrate aquí</a>
    </p>

</div>
