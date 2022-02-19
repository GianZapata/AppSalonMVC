<?php

namespace Model;

use PDO;

class User extends ActiveRecord {

   protected static $tabla = 'users';
   protected static $primaryKey = 'id';

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
      $this->verified = $args['verified'] ?? 0;
      $this->remember_token = $args['remember_token'] ?? "";
      $this->admin = $args['admin'] ?? 0;  
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

   public function validateLogin() {
      if(!$this->email) {
         self::$alertas['error'][] = "El email es obligatorio";
      }

      if(!$this->password) {
         self::$alertas['error'][] = "La contraseña es obligatoria";
      }

      return self::$alertas;
   }

   public function validatePassword() {
      if(!$this->password) {
         self::$alertas['error'][] = "La contraseña es obligatoria";
      }

      if(strlen($this->password) < 6) {
         self::$alertas['error'][] = "La contraseña debe tener al menos 6 caracteres";
      }      

      return self::$alertas;
   }

   public function validateEmail() {
      if(!$this->email) {
         self::$alertas['error'][] = "El email es obligatorio";
      }

      return self::$alertas;
   }

   public function userExists() {
      $query = "SELECT * FROM " . self::$tabla . " WHERE email = :email LIMIT 1";
      $statement = self::$db->prepare($query);
      $statement->execute([':email' => $this->email]);
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      
      if(count($result) > 0 ) {
         self::$alertas['error'][] = "El Usuario ya está registrado";
      } 

      return $result;
      // $result = self::$db->query($query);

      // if($result->num_rows > 0) {
      //    self::$alertas['error'][] = "El Usuario ya está registrado";
      // } 
      // return $result;
   }

   public function hashPassword() {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
   }

   public function generateToken() {
      $this->remember_token = bin2hex(openssl_random_pseudo_bytes(15));
   }

   public function checkPassAndVerified($password) {      
      if(!password_verify($password, $this->password) || !$this->verified) {
         // Comprobar que el usuario esté verificado
         self::$alertas['error'][] = "El usuario no está verificado o la contraseña es incorrecta";
      } else {
         return true;
      }
         
   }

}