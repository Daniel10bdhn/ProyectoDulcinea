<?php
include('../M_inventario_aprendiz/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inicio del HTML mínimo
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Login</title>
    </head>
    <body>";

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            session_start();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre_completo'] = $usuario['nombre'];

            echo "<script>
                    alert('Bienvenido Admin');
                    window.location.href = '/Proyecto_inv/Vistas/vistas/ingreso.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Contraseña incorrecta.');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('El correo no está registrado.');
                window.history.back();
              </script>";
    }

    // Cierre del HTML
    echo "</body></html>";

    $stmt->close();
    $conexion->close();
}
?>
