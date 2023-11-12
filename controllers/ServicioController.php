<?php

namespace Controllers;

use MVC\Router;
use  Model\Servicio;

class ServicioController
{


    public static function index(Router $router)
    {


        //Consultar todos los registros de la base de datos
        $iservicios = Servicio::all();
        //Pasar de un objeto a json
        // echo json_encode($iservicio);
        // debuguear($iservicio);
        esAdmin();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['NOMBRE'],
            'iservicios' => $iservicios
        ]);
    }




    public static function crear(Router $router)
    {


        esAdmin();
        $iservicio = new Servicio();
        //Pasar datos y variables a la vista 
        $router->render('servicios/crear', [
            'nombre' => $_SESSION['NOMBRE'],
            'iservicio' => $iservicio
            // 'alertas' => $alertas
        ]);
    }



    public static function guardar()
    {
        $iservicios = new Servicio($_POST);
        $respuesta = $iservicios->crear();


        // $respuesta = [
        //     'datos' => $_POST
        // ];
        echo json_encode($respuesta);
    }





    public static function actualizar(Router $router)
    {
        esAdmin();
        $id = $_GET['id'];

        if (is_numeric($id)) {
            $iservicio =  Servicio::find($id);
        }
        // debuguear($id);
        // if (!$id) return;




        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $iservicio->sincronizar($_POST);

            $alertas = $iservicio->validar();

            //Guardar
            if (empty($alertas)) {
                $iservicio->guardar();
                header('location: /servicios');
            }
        }
        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['NOMBRE'],
            'iservicio' => $iservicio,
            'alertas' => $alertas
        ]);
    }
    public static function eliminar()
    {
        esAdmin();
        $iservicio = new Servicio();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            //Buscar servicio
            $iservicio = Servicio::find($id);


            $iservicio->eliminar($id);
            header('location:/servicios');
        }
    }
}
