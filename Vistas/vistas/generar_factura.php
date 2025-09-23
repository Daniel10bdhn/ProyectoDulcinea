<?php
include '../M_inventario_aprendiz/conexion.php'; // Conexión a la base de datos

// Obtener el nombre del comprador desde la URL
$nombre_comprador = isset($_GET['nombre_comprador']) ? $_GET['nombre_comprador'] : null;

if ($nombre_comprador) {
    // Consulta para obtener los datos del comprador
    $query_comprador = "SELECT 
                        nombre_comprador, 
                        telefono_comprador, 
                        direccion_comprador
                    FROM ventass
                    WHERE nombre_comprador = ?
                    LIMIT 1";  // Solo buscamos un comprador

    $stmt_comprador = $conexion->prepare($query_comprador);
    $stmt_comprador->bind_param("s", $nombre_comprador); // "s" indica que es un string
    $stmt_comprador->execute();
    $resultado_comprador = $stmt_comprador->get_result();
    $datos_comprador = $resultado_comprador->fetch_assoc(); // Obtener los datos del comprador

    // Verificar si se encontraron datos del comprador
    if (!$datos_comprador) {
        die("No se encontraron datos para el comprador: " . htmlspecialchars($nombre_comprador));
    }

    // Consulta para obtener los productos comprados
    $query_productos = "SELECT 
                        producto, 
                        cantidad_vendida, 
                        precio,
                        (cantidad_vendida * precio) AS total_producto
                    FROM ventass 
                    WHERE nombre_comprador = ?";

    $stmt_productos = $conexion->prepare($query_productos);
    $stmt_productos->bind_param("s", $nombre_comprador);
    $stmt_productos->execute();
    $resultado_productos = $stmt_productos->get_result();

    // Verificar si se encontraron productos
    if ($resultado_productos->num_rows === 0) {
        die("No se encontraron productos para el comprador: " . htmlspecialchars($nombre_comprador));
    }
} else {
    die("No se proporcionó un nombre de comprador.");
}

// Mostrar los datos de la factura
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Factura</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Arial', sans-serif;
    }
    .invoice-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 30px;
    }
    .invoice-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .invoice-header h1 {
        font-size: 2.5rem;
        color: #343a40;
    }
    .invoice-details th {
        width: 40%;
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .invoice-details td {
        color: #495057;
    }
    .total-row {
        font-weight: bold;
        font-size: 1.2rem;
    }
    .btn-custom {
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
        text-decoration: none;
    }
    .btn-primary-custom {
        background-color: #007bff;
        color: white;
    }
    .btn-secondary-custom {
        background-color: #6c757d;
        color: white;
    }
    </style>";
echo "</head>";
echo "<body class='container'>";

// Contenedor principal de la factura
echo "<div class='invoice-container'>";
echo "<div class='invoice-header'>";
echo "<h1>Factura de Compra</h1>";
echo "</div>";

// Datos del comprador
echo "<table class='table invoice-details table-bordered'>";
echo "<tr><th>Nombre del Comprador</th><td>" . htmlspecialchars($datos_comprador['nombre_comprador']) . "</td></tr>";
echo "<tr><th>Teléfono</th><td>" . htmlspecialchars($datos_comprador['telefono_comprador']) . "</td></tr>";
echo "<tr><th>Dirección</th><td>" . htmlspecialchars($datos_comprador['direccion_comprador']) . "</td></tr>";
echo "</table>";

// Tabla de productos comprados
echo "<h4 class='mt-4'>Productos Comprados</h4>";
echo "<table class='table table-striped table-bordered'>";
echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th></tr></thead>";
echo "<tbody>";

$total_venta = 0; // Para acumular el total general

// Mostrar los productos comprados
while ($producto = $resultado_productos->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($producto['producto']) . "</td>";
    echo "<td>" . htmlspecialchars($producto['cantidad_vendida']) . "</td>";
    echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
    echo "<td>$" . number_format($producto['total_producto'], 2) . "</td>";
    echo "</tr>";
    $total_venta += $producto['total_producto'];
}

echo "</tbody>";
echo "</table>";

// Mostrar el total general
echo "<table class='table invoice-details table-bordered'>";
echo "<tr class='total-row'><th>Total de la Venta</th><td>$" . number_format($total_venta, 2) . "</td></tr>";
echo "</table>";

// Botones de acción
echo "<div class='text-center mt-4'>";
echo "<a href='javascript:window.print()' class='btn btn-custom btn-primary-custom'>Imprimir Factura</a>";
echo " <a href='historial_ventas.php' class='btn btn-custom btn-secondary-custom'>Regresar</a>";
echo "</div>";

echo "</div>"; // Cierra el contenedor principal
echo "</body>";
echo "</html>";
?>
