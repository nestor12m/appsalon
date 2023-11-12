<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class ApiController
{
    public static function index()
    {
        //Consultar todos los registros de la base de datos
        $iservicio = Servicio::all();
        //Pasar de un objeto a json
        echo json_encode($iservicio);
        // debuguear($iservicio);
    }

    public static function guardar()
    {
        //Almacena la cita y  devuelve el id
        $icita = new Cita($_POST);
        $respuesta =  $icita->guardar();


        // Almacena la cita y el servicio ****INICIO******
        // Para extraer el id de la cita 
        $id = $respuesta['id'];


        $idServicios = explode(",", $_POST['servicios']);

        foreach ($idServicios as $idServicio) {
            $args = [
                'citaid' => $id,
                'servicioid' => $idServicio
            ];
            $icitaservicios = new CitaServicio($args);
            $icitaservicios->guardar();
        }
        // Almacena la cita y el servicio ****FIN******
        $resultadoinsert = [
            'servicios' => $respuesta
        ];

        echo json_encode($resultadoinsert);
    }

    public static function eliminar()
    {
        echo "elimnando cita....";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Encontrar id
            $id = $_POST['id'];
            // traer la cita de la bd
            $icita = Cita::find($id);

            //Eliminar cita
            $icita->eliminar();
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
