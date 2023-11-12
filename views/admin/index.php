<h1>Panel de Adminstracion</h1>

<?php include_once __DIR__ . ('/../templates/barra.php') ?>
<h2>Buscar Citas</h2>

<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo $fecha ?>">
        </div>
    </form>
</div>

<?php

if (count($citas) === 0) { ?>
    <h3>No hay citas para esta fecha</h3>
<?php } ?>


<div id="citas-admin">
    <ul class="citas">

        <?php

        $idCita = 0;
        foreach ($citas as $key =>  $cita) :

            if ($idCita !== $cita->id) {
                $total = 0;
        ?>

                <li>
                    <p>Id: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                    <h3>Serivicios</h3>
                <?php
                $idCita = $cita->id;
            }
            $total  += $cita->precio;

                ?>
                <!-- //Parae if -->
                <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p>

                <?php
                // para saber que el serivio es el iltomo
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total"> Total: $ <?php echo $total ?></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                <?php  } ?>




            <?php endforeach; ?>
    </ul>
</div>


<?php

$script = "<script src='build/js/buscador.js'></script>";

?>