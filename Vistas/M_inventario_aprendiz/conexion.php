<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "proyecto_inv";

$conexion = new mysqli($server, $user, $pass, $db);


if($conexion->connect_errno){
    die("Conexión fallida: " . $conexion->connect_errno);
}else{
    //echo "Conexión exitosa";
}
?>
