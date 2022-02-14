<?php

namespace Model;

class User extends ActiveRecord {

   protected static $tabla = 'users';

   protected static $columnasDB = [
      'id', 
      'name', 
      'last_name', 
      'email', 
      'password', 
      'phone',
      'verified',
      'remember_token', 
      'admin',
   ];

   public $id;
   public $name;
   public $last_name;
   public $email;
   public $password;
   public $phone;
   public $verified;
   public $remember_token;
   public $admin;

   public function __construct($args = []){
      $this->id = $args['id'] ?? null;
      $this->name = $args['name'] ?? "";
      $this->last_name = $args['last_name'] ?? "";
      $this->email = $args['email'] ?? "";
      $this->password = $args['password'] ?? "";
      $this->phone = $args['phone'] ?? "";
      $this->verified = $args['verified'] ?? null;
      $this->remember_token = $args['remember_token'] ?? "";
      $this->admin = $args['admin'] ?? null;   
   }

   // Mensajes de validación para la creación de una cuenta
   public function validarNuevaCuenta() {
      if(!$this->name) {
         self::$alertas['error'][] = "El nombre es obligatorio";
      }

      if(!$this->last_name) {
         self::$alertas['error'][] = "El apellido es obligatorio";
      }

      if(!$this->email) {
         self::$alertas['error'][] = "El email es obligatorio";
      }

      if(!$this->password) {
         self::$alertas['error'][] = "La contraseña es obligatoria";
      }

      if(strlen($this->password) < 6) {
         self::$alertas['error'][] = "La contraseña debe tener al menos 6 caracteres";
      }      

      if(!$this->phone) {
         self::$alertas['error'][] = "El teléfono es obligatorio";
      }
      return self::$alertas;
   }

   public function userExists() {
      $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
      $result = self::$db->query($query);

      if($result->num_rows > 0) {
         self::$alertas['error'][] = "El Usuario ya está registrado";
      } 
      return $result;
   }
}