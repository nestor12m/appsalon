<h1 class="nombre-pagina">Actualizar Servicios</h1>
<P class="descripcion-pagina">Modifica los valores del formulario</P>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form method="POST" class="formulario">

    <?php include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" id="actualizarservicio" value="Actualizar Serivicio">
</form>