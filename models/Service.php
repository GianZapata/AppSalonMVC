<?php

namespace Model;

class Service extends ActiveRecord { 
   protected static $tabla = 'services';
   protected static $primaryKey = 'id';
   protected static $columnasDB = ['id', 'name', 'price'];
   // protected static $columnasDB = ['id', 'name', 'description', 'price', 'duration', 'created_at', 'updated_at'];

   public $id;
   public $name;
   public $price;

   public function __construct($args = []) 
   {
      $this->id = $args['id'] ?? null;
      $this->name = $args['name'] ?? '';
      $this->price = $args['price'] ?? '';
   }
}