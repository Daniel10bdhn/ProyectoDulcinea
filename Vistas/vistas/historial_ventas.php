<?php
include '../M_inventario_aprendiz/conexion.php';

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$cancelMessage = ''; // Mensaje de éxito de cancelación

if (isset($_GET['cancelar']) && isset($_GET['id_venta'])) {
    $id_venta = $_GET['id_venta'];

    // Actualizamos el estado de la venta a 'Cancelada'
    $updateQuery = "UPDATE ventass SET estado = 'Cancelada' WHERE id_venta = ?";
    $updateStmt = $conexion->prepare($updateQuery);
    $updateStmt->bind_param("i", $id_venta);
    $updateStmt->execute();

    $cancelMessage = "La venta ha sido cancelada con éxito."; // Mensaje de éxito

    header("Location: historial_ventas.php?cancelMessage=" . urlencode($cancelMessage));
    exit;
}

if (isset($_GET['cancelMessage'])) {
    $cancelMessage = $_GET['cancelMessage']; // Mostrar mensaje después de la cancelación
}

$query = "SELECT 
            id_venta,
            nombre_comprador,
            GROUP_CONCAT(CONCAT(producto, ' (', cantidad_vendida, ')') ORDER BY fecha_venta) AS productos_comprados,
            GROUP_CONCAT(precio ORDER BY fecha_venta) AS precios,
            SUM(cantidad_vendida) AS cantidad_total_vendida,
            SUM(cantidad_vendida * precio) AS total_venta,
            MAX(fecha_venta) AS fecha_venta,
            telefono_comprador,
            direccion_comprador,
            COALESCE(estado, 'Activa') AS estado
          FROM ventass
          WHERE producto LIKE ? OR nombre_comprador LIKE ? OR fecha_venta LIKE ?
          GROUP BY nombre_comprador
          ORDER BY fecha_venta DESC
          LIMIT 7";

$stmt = $conexion->prepare($query);
$searchTermWildcard = "%" . $searchTerm . "%";
$stmt->bind_param("sss", $searchTermWildcard, $searchTermWildcard, $searchTermWildcard);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas</title>
    <link rel="stylesheet" href="../Estilos/style-historial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3b14f0d394.js" crossorigin="anonymous"></script>
    <script>
        // Mostrar alerta si la venta ha sido cancelada
        <?php if ($cancelMessage) { ?>
            alert("<?php echo $cancelMessage; ?>");
        <?php } ?>
    </script>
</head>
<body>
<div class="container mt-5">
    <form action="/Proyecto_inv/Vistas/vistas/ingreso.php" method="POST" style="position: absolute; top: 50px; right: 92%;">
        <button type="submit" name="cerrar_sesion" 
            style="font-size: 30px; padding: 0px 20px; border-radius: 10px; color: white; border: none; cursor: pointer;">🔙</button>
    </form>
    <h1 class="text-center">Historial de Ventas</h1><br>
    
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por producto, comprador o fecha" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <div>
        <table class="table1 table-responsive">
            <thead class="bg-light">
                <tr>
                    <th>Producto(s)</th>
                    <th>Cantidad Vendida</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Nombre del Comprador</th>
                    <th>Teléfono del Comprador</th>
                    <th>Dirección del Comprador</th>
                    <th>Fecha de Venta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $productos_comprados = explode(",", $row['productos_comprados']);
                $precios = explode(",", $row['precios']);
                $totalVenta = $row['total_venta'];

                $productosHTML = '';
                $preciosHTML = '';
                foreach ($productos_comprados as $index => $producto) {
                    $productosHTML .= $producto . " ";
                    $preciosHTML .= "$" . number_format($precios[$index], 2) . " ";
                }

                echo "<tr>
        <td>" . htmlspecialchars($productosHTML) . "</td>
        <td>" . htmlspecialchars($row['cantidad_total_vendida']) . "</td>
        <td>" . htmlspecialchars($preciosHTML) . "</td>
        <td>$" . number_format($totalVenta, 2) . "</td>
        <td class='" . ($row['estado'] === 'Cancelada' ? 'text-danger' : 'text-success') . "'>
            " . htmlspecialchars($row['estado']) . "
        </td>
        <td>" . htmlspecialchars($row['nombre_comprador']) . "</td>
        <td>" . htmlspecialchars($row['telefono_comprador']) . "</td>
        <td>" . htmlspecialchars($row['direccion_comprador']) . "</td>
        <td>" . date("d/m/Y H:i:s", strtotime($row['fecha_venta'])) . "</td>

        <td>";

                if ($row['estado'] === 'Cancelada') {
                    echo "<a href='#' class='btn btn-secondary btn-sm' disabled>Generar Factura</a>";
                } else {
                    echo "<a href='generar_factura.php?nombre_comprador=" . urlencode($row['nombre_comprador']) . "' class='btn btn-info btn-sm'>Generar Factura</a>";
                }

                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='10' class='text-center'>No se encontraron ventas para ese término.</td></tr>";
        }
        ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
