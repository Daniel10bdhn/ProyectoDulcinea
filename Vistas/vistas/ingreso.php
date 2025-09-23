<?php
session_start();

function verificarSesion() {
    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        echo "<script>alert('Debe iniciar sesión para acceder a esta página.');</script>";
        echo "<script>location.href='/Proyecto_inv';</script>";
        exit();
    }
}

verificarSesion();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto_inv/Vistas/Estilos/style-ingreso.css">
    <title>Ingreso</title>
</head>
<body>
<form action="/Proyecto_inv/Vistas/controlador/cerrar_sesion.php" method="POST" style="position: absolute; top: 20px; right: 20px;">
    <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar sesión</button>
</form>
    <div class="container">
        <header>
            <h1>¡Bienvenido a DULCINEA!</h1>
            <h2>¿Qué harás el día de hoy?</h2>
        </header>

        <div class="actions">
            <button class="btn" onclick="window.location.href='/Proyecto_inv/Vistas/vistas/registro_productos.php'">Registrar un Producto</button>
            
            <button class="btn" onclick="window.location.href='/Proyecto_inv/Vistas/vistas/productos.php'">Ver Mis Productos</button>

            <button class="btn" onclick="window.location.href='/Proyecto_inv/Vistas/vistas/historial_ventas.php'">Historial de Ventas</button>

        </div>
    </div>
</body>
</html>