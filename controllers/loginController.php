<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // Crear nuevo instancia de Usuario
            $auth = new Usuario($_POST);
            // debuguear($auth);
            //valdacion de errores con un metode desde usuario
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //Comprobr si exixte el usuario
                $iusuario = Usuario::where('email', $auth->email);
                if ($iusuario) {
                    //Verificar el password

                    if ($iusuario->comprobarPasswordAndVerificado($auth->password)) {
                        // si esta el usuario confirmado y la contraseña es correcta
                        //Autenticar al usaurio con variables de sesion
                        session_start();
                        $_SESSION['ID'] = $iusuario->id;
                        $_SESSION['NOMBRE'] = $iusuario->nombre . " " . $iusuario->apellido;
                        $_SESSION['EMAIL'] = $iusuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento O tipo usuario
                        if ($iusuario->admin === "1") {
                            $_SESSION['admin'] = $iusuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                        // debuguear($_SESSION);
                    }
                } else { // si no exixte el usuario
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas(); //Imprimir las alertas
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }


    public static function logout()
    {
        // session_start();

        $_SESSION = [];

        header("location: /");
    }


    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST); //para ver lo que lleva el post instanciando el modelo de usuario

            //Validar que el input no vaya vacio , creando un metodo de validar
            $alertas = $auth->validarEmailRecuperarPassword();
            //si el arreglo de errores esta vacio
            if (empty($alertas)) {
                //Verificar si email exixte
                $iusuario = Usuario::where('email', $auth->email);

                if ($iusuario && $iusuario->confirmado == "1") {
                    //Generar un token 
                    $iusuario->crearToken(); //inserta el token en el usuario
                    //luego se guarda en la base de datos o mjor se actualiza
                    $iusuario->guardar();

                    //TODO: enviar email

                    $iemail = new Email($iusuario->email, $iusuario->nombre . " " . $iusuario->apellido, $iusuario->token);
                    $iemail->enviarInstrucciones();
                    Usuario::setAlerta('exito', 'Revisa tu email');
                    $alertas  = Usuario::getAlertas();
                } else {
                    Usuario::setAlerta('error', 'correo no existe o no esta confirmado');
                    $alertas = Usuario::getAlertas(); //Imprimir las alertas
                }
            }
        }



        $router->render('auth/olvidepassword', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        // recuperar token de la url
        $token = S($_GET['token']);


        // Consultar la base de datos 
        $iusuario = Usuario::where('token', $token);

        if (empty($iusuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $alertas = Usuario::getAlertas();
            $error = true;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);

            // traer metodo de validar campor vacios
            $alertas = $password->validarPasswordRecuperarPassword();

            if (empty($alertas)) {

                $iusuario->password = null;
                $iusuario->password = $password->password;
                $iusuario->hashPassword();
                $iusuario->token = null;

                $resultado = $iusuario->guardar();
                // $resultado = true;

                if ($resultado) {
                    $alertas = Usuario::setAlerta('exito', 'Password Actualizado Correctamente');
                    $alertas = Usuario::getAlertas();
                    header('Refresh: 3 ; url=/');
                }
            }
            // debuguear($password);
        }

        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        //Alertas vacias
        $alertas = [];
        $iusuario = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $iusuario->sincronizar($_POST);  //Te  prerellena los input
            $alertas = $iusuario->validarNuevaCuenta(); //llena el arreglo de errores si no llenas un input

            //REVISAR SI ALERTAS ESTA VACIO
            if (empty($alertas)) {
                //Verificar que el usuario no este regisrado
                $resultado = $iusuario->exixteUsuario();


                //si el resultado de la base de datos es true muestra alerta de uasuario ya existe
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //si el usuario no esta registrado
                    //Hashear password
                    $iusuario->hashPassword();
                    //Generar token unico
                    $iusuario->crearToken();
                    //Enviar email
                    $iemail = new Email($iusuario->email, $iusuario->nombre, $iusuario->token);
                    $iemail->enviarConfirmacion();

                    // Crear usuario
                    $resultado = $iusuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        $router->render('auth/crearcuenta', [
            'iusuario' => $iusuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        //Sanitizar la entrada del token
        $token = s($_GET['token']);

        //Consultar registro donde token es igual a el token de la bd, 
        //eso devuelve un obeto usuario vacio o lleno
        $iusuario = Usuario::where('token', $token);

        // si usuario esta vacio o no
        if (empty($iusuario)) {
            //Mostrar error
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //Modificar a usuario confirmado
            // echo "Token valido";
            $iusuario->confirmado = "1";
            $iusuario->token = null;
            $iusuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamentes');
        }
        //llamar metodo de alertas desde activerecord
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmarcuenta', [
            'alertas' => $alertas
        ]);
    }
}
