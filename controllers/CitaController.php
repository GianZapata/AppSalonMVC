<?php

namespace Controllers;

use MVC\Router;

class CitaController { 
   public static function index (Router $router){
      if(!isset($_SESSION)) {
         session_start();
      }
      
      $router->render('cita/index',[
         'name' => $_SESSION['name'],
      ]);
   }
}