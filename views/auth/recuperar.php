<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo pasword a continuacion</p>

<?php include_once __DIR__  . '/../templates/alertas.php'; ?>

<?php if ($error) return ?>

<form action="" class="formulario" method="POST">

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Nuevo Password" name="password">
    </div>

    <!-- <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Nuevo Password" name="password">
    </div> -->

    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>

<div class="acciones">
    <a href="/crearcuenta">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/">¿Ya tienes cuenta? Iniciar sesion</a>
</div>