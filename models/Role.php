<?php

namespace Model;

class Role extends ActiveRecord { 
   protected static $tabla = 'roles';
   protected static $columnasDB = [
      'id', 
      'name', 
      'slug',
   ];

   public $id;
   public $name;
   public $slug;

   public function __construct($args = []){
      $this->id = $args['id'] ?? null;
      $this->name = $args['name'] ?? null;
      $this->slug = $args['slug'] ?? null;
   }
}