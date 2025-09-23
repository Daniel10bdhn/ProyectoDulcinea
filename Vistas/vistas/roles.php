<?php
require_once("conexion.php");

if(isset($_POST['conf'])&&$_POST["conf"]=="si"){
    $id= $_POST['id'];
    $tipo_documento= $_POST['tipo_documento'];
    $nombre= $_POST['nombre'];
    $apellido= $_POST['apellido'];
    $correo= $_POST['correo'];
    $telefono= $_POST['telefono'];
    $est_usuario= $_POST['est_usuario'];
    $contraseña= $_POST['contraseña'];

    $insertarDatos = "INSERT INTO roles VALUES('','$tipo_documento','$nombre','$apellido','$correo','$telefono','$est_usuario','$contraseña')";
}



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Movimientos</title>
    </head>
    <body>
        <form action="#" name="movimientos" method="post">
            <input type="text" name="id" placeholder="id">
            <input type="text" name="tipo_documento" placeholder="tipo_documento">
            <input type="text" name="nombre" placeholder="nombre">
            <input type="text" name="apellido" placeholder="apellido">
            <input type="text" name="correo" placeholder="correo">
            <input type="text" name="telefono" placeholder="telefono">
            <input type="text" name="est_usuario" placeholder="est_usuario">
            <input type="text" name="contraseña" placeholder="contraseña">

            <input type="submit" name="registro" value="Confirmar">
            <input type="hidden" name="conf" value="si">
            <input type="reset">
        </form>
    </body>
</html>
