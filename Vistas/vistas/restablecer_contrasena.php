<?php
// Validar si hay token en la URL
if (!isset($_GET['token'])) {
    die("Token no proporcionado.");
}

$token = $_GET['token'];

// Aquí deberías consultar tu base de datos para validar que el token existe
// y no ha expirado. Suponiendo que la conexión a la BD ya está hecha:
include('conexion.php'); // tu archivo de conexión

$stmt = $conn->prepare("SELECT email FROM recuperacion WHERE token = ? AND expiracion > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Token inválido o expirado.");
}

$email = $result->fetch_assoc()['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h2>Ingresa tu nueva contraseña</h2>
    <form action="procesar_nueva_contra.php" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
        <button type="submit">Guardar nueva contraseña</button>
    </form>
</body>

<p>
    ¿Olvidaste tu contraseña?  
    <a href="#" onclick="document.getElementById('modal').style.display='flex'">Restaurar aquí</a>
</p>

</html>
