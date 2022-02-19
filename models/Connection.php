<?php

namespace Model;

use PDO;

class Connection {
   private static $instance = null;

   private function __construct() {
      $this->db = new PDO("mysql:host=localhost;dbname=app_salon",'root', 'root');
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

   public static function getInstance() {
      if (self::$instance == null) {
         self::$instance = new Connection();
      }
      return self::$instance;
   }

   public function getDB() {
      return $this->db;
   }
}