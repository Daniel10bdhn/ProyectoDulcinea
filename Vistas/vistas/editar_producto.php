
<?php
include '../M_inventario_aprendiz/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $nombre_producto = $_POST['nombre_producto'];
    $categoria = $_POST['categoria'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];


    $stmt = $conexion->prepare("UPDATE productos SET nombre_producto = ?, categoria = ?, cantidad = ?, precio = ? WHERE codigo = ?");
    $stmt->bind_param("ssdis", $nombre_producto, $categoria, $cantidad, $precio, $codigo);

    if ($stmt->execute()) {
        echo "<script>alert('Producto actualizado correctamente');</script>";
        echo "<script>window.location.href = '/Proyecto_inv/Vistas/vistas/productos.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el producto');</script>";
    }

    $stmt->close();
    $conexion->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];


    $stmt = $conexion->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    if (!$producto) {
        echo "<script>alert('Producto no encontrado'); window.location.href='registro_productos.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/style-editar.css">
    <title>Editar Producto</title>
</head>
<body>
    <form action="/Proyecto_inv/Vistas/vistas/ingreso.php" method="POST" style="position: absolute; top: 50px; right: 92%;">
    <button type="submit" name="cerrar_sesion" 
        style="font-size: 30px; padding: 0px 20px; border-radius: 10px; color: white; border: none; cursor: pointer;">🔙</button>
</form>

<div class="container mt-5">
    <h3 class="mb-4">Editar Producto</h3>

    <?php if (isset($producto)) { ?>
        <form method="POST" action="editar_producto.php">
            <input type="hidden" name="codigo" value="<?php echo $producto['codigo']; ?>">

            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-select" name="categoria" required>
                <option value="" disabled>Seleccione una categoría</option>
                <option value="Paq. Papas" <?php echo ($producto['categoria'] == 'Paq. Papas') ? 'selected' : ''; ?>>Paq. Papas</option>
                <option value="Paq. Dulces" <?php echo ($producto['categoria'] == 'Paq. Dulces') ? 'selected' : ''; ?>>Paq. Dulces</option>
                <option value="Bebidas" <?php echo ($producto['categoria'] == 'Bebidas') ? 'selected' : ''; ?>>Bebidas</option>
                <option value="Paq. Ponques" <?php echo ($producto['categoria'] == 'Paq. Ponques') ? 'selected' : ''; ?>>Paq. Ponques</option>
            </select>

            <label for="nombre_producto">Nombre del producto</label>
            <input type="text" name="nombre_producto" id="nombre_producto" value="<?php echo $producto['nombre_producto']; ?>" required>

            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" value="<?php echo $producto['precio']; ?>" required>

            <button type="submit">Actualizar Producto</button>
        </form>
    <?php } else { ?>
        <p>Producto no encontrado. <a href="registro_productos.php">Volver al registro de productos.</a></p>
    <?php } ?>
</div>

</body>
</html>
