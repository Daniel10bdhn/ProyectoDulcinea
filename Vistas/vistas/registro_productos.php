
<?php

include '../M_inventario_aprendiz/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $categoria = $_POST['categoria'];
    $nombre_producto = $_POST['nombre_producto'];
    $estado_producto = $_POST['estado_producto'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha_ingreso = $_POST['fecha_ingreso'];

    $stmt = $conexion->prepare("SELECT 1 FROM productos WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('El código ya existe. Por favor, use otro código.');</script>";
    } else {
        $stmt = $conexion->prepare("INSERT INTO productos (codigo, categoria, nombre_producto, estado_producto, cantidad, precio, fecha_ingreso) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssids", $codigo, $categoria, $nombre_producto, $estado_producto, $cantidad, $precio, $fecha_ingreso);

        if ($stmt->execute()) {
            echo "<script>alert('Producto registrado correctamente');</script>";
        } else {
            echo "<script>alert('Error al registrar el producto: " . $stmt->error . "');</script>";
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/Style1.css">
    <title>Inicio Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/3b14f0d394.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <h1>DULCINEA</h1>
    <p>Aqui podrás registrar un nuevo producto.</p>
    <form action="/proyecto_inv/home.html" method="POST" style="float:right; margin-top:-50px;" onsubmit="return mostrarMensaje()">
    </form>
    <form action="/Proyecto_inv/Vistas/vistas/ingreso.php" method="POST" style="position: absolute; top: 50px; right: 90%;">
    <button type="submit" name="cerrar_sesion" 
        style="font-size: 40px; padding: 0px 20px; border-radius: 10px; color: white; border: none; cursor: pointer;">🔙</button>
</form>


</header>

<div class="container mt-5">
    <div class="container juan">
        <form method="POST">
            <h3 class="mb-4 subtitulo" >Registro de productos</h3>

            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" name="codigo" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-select" name="categoria" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <option value="Paq. Papas">Paq. Papas</option>
                    <option value="Paq. Dulces">Paq. Dulces</option>
                    <option value="Bebidas">Bebidas</option>
                    <option value="Paq. Ponques">Paq. Ponques</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre_producto" required>
            </div>

            <div class="mb-3">
                <label for="estado_producto" class="form-label">Estado del Producto</label>
                <input type="text" class="form-control" name="estado_producto" value="NUEVO" readonly>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="cantidad" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" name="precio" required>
            </div>

           <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" readonly required>
            </div>

            <center><button type="submit" class="btn btn-primary">Registrar Producto</button></center>
        </form>
    </div>
    
 <script>
    const hoy = new Date().toISOString().split("T")[0];
    const inputFecha = document.getElementById("fecha_ingreso");
    inputFecha.value = hoy;   // Fecha actual
    inputFecha.min = hoy;     // Bloquear anteriores
    inputFecha.max = hoy;     // Bloquear posteriores
</script>

    
</div><br>





