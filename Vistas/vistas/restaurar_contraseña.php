<?php
include('../M_inventario_aprendiz/conexion.php');

// Si viene desde el correo (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $email = $_GET['email'];
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Restablecer contraseña</title>
        <link rel="stylesheet" href="../Estilos/style-recuperar-contra.css">
    </head>
    <body>
        <div class="container">
            <div class="container-form">
                <h2>Restablecer contraseña</h2>
                <form id="resetForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <div class="container-input">
                        <label>Nueva contraseña:</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <button class="boton" type="submit">Actualizar</button>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="modal">
            <div class="modal-content" id="modalContent">
                <h3 id="modalMessage"></h3>
                <button class="close-btn" id="closeBtn">Cerrar</button>
            </div>
        </div>

        <script>
        const form = document.getElementById('resetForm');
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');
        const modalMessage = document.getElementById('modalMessage');
        const closeBtn = document.getElementById('closeBtn');

        form.addEventListener('submit', async function(e){
          e.preventDefault();
          const fd = new FormData(this);

          try {
            const res = await fetch('<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>', { 
              method: 'POST', 
              body: fd 
            });
            const data = await res.json();

            modal.classList.add('open');
            modal.style.display = 'flex';
            modalMessage.textContent = data.message;

            modalContent.classList.remove('success','error');
            modalContent.classList.add(data.status === 'success' ? 'success' : 'error');

            if (data.status === 'success') {
              setTimeout(()=> window.location.href = '/Proyecto_inv/home.html', 3000);
            }
          } catch (err) {
            modal.style.display = 'flex';
            modal.classList.add('open');
            modalMessage.textContent = 'Error de conexión. Intenta de nuevo.';
            modalContent.classList.remove('success');
            modalContent.classList.add('error');
          }
        });

        closeBtn.addEventListener('click', closeModal);
        window.addEventListener('click', function(e){
          if (e.target === modal) closeModal();
        });

        function closeModal(){
          modal.classList.remove('open');
          setTimeout(()=> modal.style.display = 'none', 150);
        }
        </script>
    </body>
    </html>
    <?php
    exit;
}

// Si envía el formulario (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    header('Content-Type: application/json');

    if ($result->num_rows > 0) {
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        $update_stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $password_hash, $email);

        if ($update_stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "✅ Contraseña actualizada correctamente"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "❌ Error al actualizar la contraseña"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "❌ El correo no está registrado"
        ]);
    }

    $stmt->close();
    $conexion->close();
    exit;
}
?>

