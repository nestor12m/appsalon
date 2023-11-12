<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //Crear el objeto de Email
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];

        $email->setFrom('cuentas@appsalon.com');
        $email->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $email->Subject = "Confirma Tu Cuenta";

        //contenido  
        $email->isHTML(true);
        $email->CharSet = 'UTF-8';


        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong>Has creado tu cuenta en App Salon,solo debes  confirmarla presionando el siguiente enlace </p>";
        $contenido .= "<p>Presiona Aqui:  <a href='" . $_ENV['APP_URL'] . "/confirmarcuenta?token=" . $this->token . "' >Confirmar Cuenta </a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $email->Body = $contenido;

        //Enviar email
        $email->send();
    }


    public function enviarInstrucciones()
    {

        //Crear el objeto de Email
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];

        $email->setFrom('cuentas@appsalon.com');
        $email->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $email->Subject = "Reestablece tu password";

        //contenido  
        $email->isHTML(true);
        $email->CharSet = 'UTF-8';


        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong> Has Solicitado restablecer tu password. <br> <br> sigue el siguiente enlace para restablecerlo </p>";
        $contenido .= "<p>Presiona Aqui:  <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "' >Restablecer Password </a> </p>";
        $contenido .= "<p>Si tu no solicitaste restablecer tu password ignora el mensaje </p>";
        $contenido .= "</html>";

        $email->Body = $contenido;

        //Enviar email
        $email->send();
    }
}
