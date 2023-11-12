<?php

namespace Controllers;

use MVC\Router;

class CitaController
{

    public static function  index(Router $router)
    {

        $nombre = $_SESSION['NOMBRE'];
        $id = $_SESSION['ID'];


        estaAutenticado();

        $router->render('cita/index', [
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}
