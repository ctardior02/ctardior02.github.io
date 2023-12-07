<?php
    $cadena_conexion = "mysql:dbname=nube;host=127.0.0.1";
    $usuario = "root";
    $clave = "";

    $db = new PDO($cadena_conexion, $usuario, $clave);
    
?>