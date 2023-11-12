<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\LoginController;
use  Controllers\CitaController;
use Controllers\PruebaController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//Iniciar Sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);


//Recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//crear cuenta
$router->get('/crearcuenta', [LoginController::class, 'crear']);
$router->post('/crearcuenta', [LoginController::class, 'crear']);

//Confirmar cuenta
$router->get('/confirmarcuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);


//Area privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API Servicios
$router->get('/api/servicios', [ApiController::class, 'index']);
$router->post('/api/citas', [ApiController::class, 'guardar']);
$router->post('/api/eliminar', [ApiController::class, 'eliminar']);

// Crud de los servicios
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/guardar', [ServicioController::class, 'guardar']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
