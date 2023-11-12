<?php



foreach ($alertas as $key => $mensaje) :

    foreach ($mensaje as $mensaje) :
?>

        <div class="alertas <?php echo $key; ?>"><?php echo $mensaje; ?></div>
<?php
    endforeach;
endforeach;
