<?php
namespace Controllers;

use Model\User;
use MVC\Router;

class LoginController { 
   public static function login(Router $router) {

      if($_SERVER['REQUEST_METHOD'] === 'POST'){
         echo 'Enviaste al formulario';
      }

      return $router->render('auth/login');
   }

   public static function logout() {
      echo "LoginController::login";
   }

   public static function forgot(Router $router) {
      return $router->render('auth/forgot', [

      ]);
   }

   public static function recuperar() {
      echo "LoginController::recuperar";
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
            $result = $user->userExists();
            
            if($result->num_rows) { 
               $alertas = User::getAlertas();
            } else { 
               
            }

            // $user->guardar();         
         }
      }         

      return $router->render('auth/register', [
         'user' => $user,
         'alertas' => $alertas
      ]);
   }
}