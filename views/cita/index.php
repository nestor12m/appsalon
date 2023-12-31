<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php include_once __DIR__ . ('/../templates/barra.php') ?>

<div id="app">

    <dvi class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </dvi>


    <!-------------------------------- SECCION 1 --------------------------------->
    <div id="paso-1" class="seccion ">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continución</p>
        <div id="servicios" class="listado-servicios">

        </div>
    </div>

    <!-------------------------------- SECCION 2 --------------------------------->
    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input disabled class="input-name-cita" type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>">
            </div>

            <div class="campo">
                <label fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>


            <div class="campo">
                <label for="hora">hora</label>
                <input type="time" name="hora" id="hora">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>

    <!-------------------------------- SECCION 3 --------------------------------->
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica ue la información sea corecta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo;Anterior</button>
        <button id="siguiente" class="boton">Siguiente&raquo;</button>
    </div>


</div>

<?php $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src ='build/js/app.js'> </script>

"; ?>