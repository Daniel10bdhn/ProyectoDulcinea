<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $nueva_contra = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

    include('conexion.php');

    // Validar token y obtener email
    $stmt = $conn->prepare("SELECT email FROM recuperacion WHERE token = ? AND expiracion > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("Token inválido o expirado.");
    }

    $email = $resultado->fetch_assoc()['email'];

    // Actualizar la contraseña
    $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE email = ?");
    $stmt->bind_param("ss", $nueva_contra, $email);
    $stmt->execute();

    // Eliminar el token
    $stmt = $conn->prepare("DELETE FROM recuperacion WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Tu contraseña ha sido actualizada correctamente.";
}
?>
