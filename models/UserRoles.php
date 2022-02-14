<?php

namespace Model;

class UserRoles extends ActiveRecord { 
   protected static $tabla = 'user_roles';
   protected static $columnasDB = [
      'id', 
      'role_id', 
      'user_id',
   ];

   public $id;
   public $role_id;
   public $user_id;

   public function __construct($args = []){
      $this->id = $args['id'] ?? null;
      $this->role_id = $args['role_id'] ?? null;
      $this->user_id = $args['user_id'] ?? null;
   }
}