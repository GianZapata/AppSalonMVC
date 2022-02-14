<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Mail {

   public $email;
   public $name;
   public $token;

   public function __construct($email, $name, $token)
   {
      $this->email = $email;
      $this->name = $name;
      $this->token = $token;
   }

   public function send() {
      // Crear el objeto de email
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Port = 2525;
      $mail->Username = '9d4405f03f68d9';
      $mail->Password = '86af6c50990e6d';

      $mail->setFrom('cuentas@appsalon.com', 'AppSalon');
      $mail->addAddress('cuentas@appsalon.com', 'AppSalon');
      $mail->Subject = 'Confirmar cuenta';

      $body = "<html>";
      $body .= "
         <p>
            <strong>Hola {$this->name}</strong>
            Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace            
         </p>
      ";
      $body .= "<a href='http://localhost/confirm?token={$this->token}'>Confirmar cuenta</a>";
      $body .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
      $body .= "</html>";

      $mail->Body = $body;
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';

      // Enviar el correo
      $mail->send();   
   }

   public function sendForgot() {
       // Crear el objeto de email
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Port = 2525;
      $mail->Username = '9d4405f03f68d9';
      $mail->Password = '86af6c50990e6d';

      $mail->setFrom('cuentas@appsalon.com', 'AppSalon');
      $mail->addAddress('cuentas@appsalon.com', 'AppSalon');
      $mail->Subject = 'Restablece tu password';

      $body = "<html>";
      $body .= "
         <p>
            <strong>Hola {$this->name}</strong>
            Has solicitado un cambio de password, solo debes confirmarlo presionando el siguiente enlace         
         </p>
      ";
      $body .= "<a href='http://localhost/recuperar?token={$this->token}'>Restablecer cuenta</a>";
      $body .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
      $body .= "</html>";

      $mail->Body = $body;
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';

      // Enviar el correo
      $mail->send();   
   }

}