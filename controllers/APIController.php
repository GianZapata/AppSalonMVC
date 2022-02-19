<?php
namespace Controllers;

use Model\Service;

class APIController  {
   public static function index () {
      // $servicios = Service::find(1);     
      // $servicios->name = "Corte de Cabello Mujer" . rand(1, 100) ; 
      // $servicios->price = $servicios->price + 1;
      $servicios = new Service([
         'name' => 'Corte de Cabello' . rand(1, 100),
         'price' => rand(1, 100)      
      ]);      
      $servicios->guardar();
      echo json_encode($servicios);
   }
}