<?php

$db = mysqli_connect('localhost', 'root', 'root', 'app_salon');


if (!$db) {
    echo 'Error: No se pudo conectar a MySQL.' . PHP_EOL;
    echo 'errno de depuraci�n: ' . mysqli_connect_errno() . PHP_EOL;    
    exit;
}
