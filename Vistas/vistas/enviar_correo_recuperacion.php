<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_destino = $_POST['email'];

    $asunto = "Recuperación de contraseña";
    $mensaje = "Haz clic en este enlace para recuperar tu contraseña: 
    <a href='http://localhost/Proyecto_inv/Vistas/vistas/restaurar_contraseña.php?email=" . urlencode($correo_destino) . "'>Recuperar</a>";

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'inventariodulcinea@gmail.com'; // tu correo
        $mail->Password   = 'ydob umzo faqx snja';           // clave de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS moderno
        $mail->Port       = 587;

        // Remitente
        $mail->setFrom('inventariodulcinea@gmail.com', 'Soporte Dulcinea');

        // Destinatario
        $mail->addAddress($correo_destino);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        $mail->AltBody = strip_tags($mensaje);

        $mail->send();

        $response = [
            "success" => true,
            "message" => "✅ Correo enviado correctamente a $correo_destino."
        ];
    } catch (Exception $e) {
        $response = [
            "success" => false,
            "message" => "❌ Error al enviar el correo: {$mail->ErrorInfo}"
        ];
    }
} else {
    $response = [
        "success" => false,
        "message" => "Acceso no válido."
    ];
}

echo json_encode($response);
