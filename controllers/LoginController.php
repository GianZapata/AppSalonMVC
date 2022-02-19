<?php
namespace Controllers;

use Classes\Mail;
use Model\Role;
use Model\User;
use Model\UserRoles;
use MVC\Router;

class LoginController { 
   public static function login(Router $router) {
      $alertas = [];

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $auth = new User($_POST);
         $alertas = $auth->validateLogin();                  
         if(empty($alertas)) {
            // Comprobar que el usuario exista
            $user = User::where('email', $auth->email);
            if($user->exists()) {
               // Comprobar que la contraseña sea correcta
               if( $user->checkPassAndVerified($auth->password) ) {
                  // Guardar en la sesión el usuario
                  session_start();
                  $_SESSION['id'] = $user->id;
                  $_SESSION['name'] = $user->name . " " . $user->last_name;
                  $_SESSION['email'] = $user->email;
                  $_SESSION['login'] = true;
                  
                  $userRoles = UserRoles::where('user_id', $user->id)->atributos();                  
                  $_SESSION['role_id'] = $userRoles['role_id'];
                  $role = Role::where('id', $userRoles['role_id']);
                  
                  // Redireccionar al inicio 
                  if($role->slug === 'admin') {
                     $router->redirect('/admin');
                  } else {
                     $router->redirect('/cita');
                  }
                  
               } 
            } else {         
               User::setAlerta('error', 'El usuario no existe'); 
            }            
         }
      }      
      return $router->render('auth/login',[
         'alertas' => $alertas,
      ]);
   }

   public static function logout() {
      echo "LoginController::login";
   }

   public static function forgot(Router $router) {

      $alertas = [];

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $auth = new User($_POST);
         $alertas = $auth->validateEmail();
         if(empty( $alertas )) {
            $user = User::where('email', $auth->email);
            if($user && $user->verified){
               $user->generateToken();               
               $user->guardar();
               
               $mail = new Mail($user->email, $user->name, $user->remember_token );

               $mail->sendForgot();

               User::setAlerta('success', 'Se ha enviado un correo a tu cuenta');

            } else {
               User::setAlerta('error', 'El Usuario no existe o no esta confirmado');
            
            }
         }
      }

      $alertas = User::getAlertas();
      return $router->render('auth/forgot',[
         'alertas' => $alertas
      ]);
   }

   public static function recuperar(Router $router) {
      $alertas = [];
      $token = $router->getParam('token');
      $error = false;
      // Buscar usuario por su token
      $user = User::where('remember_token', $token);

      if(empty($user)) {
         User::setAlerta('error', 'El token no es válido');
         $error = true;
      }

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $auth = new User($_POST);
         $alertas = $auth->validatePassword();
         if(empty( $alertas )) {            
            $user->password = $auth->password;
            $user->hashPassword();
            $user->remember_token = null;
            $user->guardar();
            User::setAlerta('success', 'La contraseña se ha cambiado correctamente');
            // $router->redirect('/login');
         }
      }

      $alertas = User::getAlertas();
      $router->render('auth/recuperar-password',[
         'alertas' => $alertas,
         'error' => $error,
      ]);
   }

   public static function register(Router $router) {
      $user = new User;
      
      // Alertas vacias 
      $alertas = [];
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $user->sincronizar($_POST);
         $alertas = $user->validarNuevaCuenta();

         // Revisar que alertas este vacio
         if(empty($alertas)){
            // Verificar que el usuario no esté registrado                                    
            if($user->userExists()) { 
               $alertas = User::getAlertas();
            } else { 
               // Hash de la contraseña
               $user->hashPassword();

               // Generar un Token único
               $user->generateToken();

               $email = new Mail($user->email,$user->name,  $user->remember_token);
               $email->send();
               
               if($user->guardar()) {
                  $router->redirect('/message');
               }
               
            }      
         }
      }         

      return $router->render('auth/register', [
         'user' => $user,
         'alertas' => $alertas
      ]);
   }

   public static function confirm (Router $router) {
      $alertas = [];
      $token = $router->getParam('token');
      
      $user = User::where('remember_token', $token);

      if(empty($user)) {
         User::setAlerta('error', 'El token es inválido');
      } else {
         $user->verified = 1;
         $user->remember_token = null;
         $user->guardar();
         User::setAlerta('success', 'Tu cuenta ha sido verificada');
      }      

      // Obtener alertas
      $alertas = User::getAlertas();

      // Renderizar la vista
      return $router->render('auth/confirm', [
         'alertas' => $alertas
      ]);
   }
   
   public static function message(Router $router) {
      return $router->render('auth/message');
   }
}