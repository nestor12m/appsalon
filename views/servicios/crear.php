<h1 class="nombre-pagina">Nuevo Servicio</h1>
<P class="descripcion-pagina">LLena todos los campos para añadir un nuevo serivicio</P>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div class="cont">

    <form action="/servicios/crear" method="POST" class="formulario">

        <?php include_once __DIR__ . '/formulario.php'; ?>

        <input type="submit" class="boton" id="Guardarservicio" value="Guardar Serivicio">
    </form>
</div>



<?php

$script = "<script src='/build/js/crudservicios.js'></script>";
?>