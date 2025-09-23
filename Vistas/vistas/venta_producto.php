<?php
include '../M_inventario_aprendiz/conexion.php';

// Obtener productos registrados
$query = "SELECT * FROM productos";
$resultado = $conexion->query($query);
$productos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productosSeleccionados = $_POST['producto'];
    $cantidades = $_POST['cantidad_vendida'];
    $nombre_comprador = $_POST['nombre_comprador'];
    $telefono_comprador = $_POST['telefono_comprador'];
    $direccion_comprador = $_POST['direccion_comprador'];
    date_default_timezone_set('America/Bogota'); // Ajusta la zona horaria

$fecha_venta = date('Y-m-d H:i:s'); // Ahora tendrá la hora local correcta



    foreach ($productosSeleccionados as $index => $productoSeleccionado) {
        $cantidad_vendida = $cantidades[$index];

        $query_precio = "SELECT precio FROM productos WHERE nombre_producto = ?";
        $stmt_precio = $conexion->prepare($query_precio);
        $stmt_precio->bind_param("s", $productoSeleccionado);
        $stmt_precio->execute();
        $resultado_precio = $stmt_precio->get_result();

        if ($resultado_precio->num_rows > 0) {
            $row_precio = $resultado_precio->fetch_assoc();
            $precio = $row_precio['precio'];

            $query = "INSERT INTO ventass (producto, cantidad_vendida, precio, nombre_comprador, telefono_comprador, direccion_comprador, fecha_venta) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("sidsiss", $productoSeleccionado, $cantidad_vendida, $precio, $nombre_comprador, $telefono_comprador, $direccion_comprador, $fecha_venta);

            if (!$stmt->execute()) {
                echo "<script>alert('Error al registrar la venta de $productoSeleccionado.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Producto $productoSeleccionado no encontrado.'); window.history.back();</script>";
            exit();
        }
    }

    echo "<script>alert('Ventas registradas correctamente.'); window.location.href = '/Proyecto_inv/Vistas/vistas/productos.php';</script>";
    $conexion->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto_inv/Vistas/Estilos/style-Registro-venta.css">
    <title>Registrar Venta</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addProductoButton = document.getElementById('addProducto');
            const productosContainer = document.getElementById('productosContainer');

            addProductoButton.addEventListener('click', function() {
                const productoRow = document.querySelector('.productoRow');
                const newRow = productoRow.cloneNode(true);
                productosContainer.appendChild(newRow);
            });
        });
    </script>
</head>
<body>
   
<div class="container mt-5">
    <a href="/Proyecto_inv/Vistas/vistas/ingreso.php" class="btn-back">🔙</a>
</form>

    <h1 class="mb-4">Registrar Venta de Productos</h1>

    <form method="POST" action="venta_producto.php">
        <div id="productosContainer">
            <div class="productoRow">
                <label for="producto" class="form-label">Producto</label>
                <select name="producto[]" class="form-control" required>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?php echo $producto['nombre_producto']; ?>">
                            <?php echo $producto['nombre_producto']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="cantidad_vendida">Cantidad Vendida</label>
                <input type="number" name="cantidad_vendida[]" class="form-control" min="1" required>
            </div>
        </div>

        <button type="button" id="addProducto" class="btn btn-secondary mt-3">Agregar Producto</button>

        <label for="nombre_comprador">Nombre del Comprador</label>
        <input type="text" name="nombre_comprador" id="nombre_comprador" class="form-control" required>

        <label for="telefono_comprador">Teléfono del Comprador</label>
        <input type="text" name="telefono_comprador" id="telefono_comprador" class="form-control" required>

        <label for="direccion_comprador">Dirección del Comprador</label>
        <textarea name="direccion_comprador" id="direccion_comprador" class="form-control" required></textarea>

        <label for="fecha_venta">Fecha de Venta</label>
        <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" required>

        <button type="submit" class="btn btn-primary mt-3">Registrar Venta</button>
    </form>
</div>
</body>
</html>
