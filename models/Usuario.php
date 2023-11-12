<?php

namespace Model;

class Usuario extends ActiveRecord
{

    protected static $tabla = "Usuarios";
    protected static $columnasDB = [
        'id', 'nombre', 'apellido',
        'email', 'password', 'telefono', 'admin', 'confirmado', 'token'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['true'] ?? '';
    }

    //Metodo para mensajes de  validacion para la creacion de una cuenta

    public function  validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El nombre del cliente es obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = "El apellido del cliente es obligatorio";
        }

        if (!$this->email) {
            self::$alertas['error'][] = "El email del cliente es obligatorio";
        }

        if (!$this->password) {
            self::$alertas['error'][] = "La contraseña del cliente es obligatorio";
        }
        if (strlen($this->password) < 5) {
            self::$alertas['error'][] = "La contraseña debe tener minimo 5 caracteres";
        }

        return self::$alertas;
    }
    //Revisa si el usuairo ya exixte
    public function exixteUsuario()
    {
        $consulta = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";
        $resultado = self::$db->query($consulta);

        if ($resultado->num_rows) {
            self::$alertas['alertas'][] = "El usuario ya esta registrado";
        }
        return $resultado;
    }

    public function hashPassword()
    {
        $this->password  = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    // Metodo para validar el iniciao de sesion
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El correo es obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "La contraseña es obigatoria";
        }
        return self::$alertas;
    }

    public function comprobarPasswordAndVerificado($password)
    {
        $resultado = password_verify($password, $this->password);
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }


    // Metodo para validar recuperar contraseña
    public function validarEmailRecuperarPassword()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El correo es obligatorio";
        }
        return self::$alertas;
    }

    // Metodo para validar actualizar password
    public function validarPasswordRecuperarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = "EL contraseña es obligatoria";
        }
        if (strlen($this->password) < 5) {
            self::$alertas['error'][] = "La contraseña debe tener minimo 5 caracteres";
        }
        return self::$alertas;
    }
}
