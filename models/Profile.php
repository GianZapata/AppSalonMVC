<?php

namespace Model;

class Profile extends ActiveRecord { 
   
   protected static $tabla = 'profiles';

   protected static $columnasDB = [
      'id', 
      'user_id',  
      'birth_date'
   ];
}