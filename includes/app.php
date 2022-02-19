<?php 

require 'funciones.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
use Model\Connection;

$db = Connection::getInstance()->getDB();
ActiveRecord::setDB($db);