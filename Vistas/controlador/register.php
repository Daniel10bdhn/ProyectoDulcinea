<?php

include('../M_inventario_aprendiz/conexion.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {

    echo "El correo ya está registrado.";
} else {

    $password_hash = password_hash($password, PASSWORD_BCRYPT);


    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password_hash')";

    if ($conexion->query($sql) === TRUE) {

        echo "<script>
                alert('Registro exitoso');
                
                setTimeout(function() {
                    window.location.href = '/Proyecto_inv/home.html';
                }, 0);
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>