<?php
include '../M_inventario_aprendiz/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $stmt = $conexion->prepare("DELETE FROM productos WHERE codigo = ?");
    $stmt->bind_param("s", $codigo);
    if ($stmt->execute()) {
        echo "<script>alert('Producto eliminado correctamente');</script>";
        echo "<script>window.location.href = '/Proyecto_inv/Vistas/vistas/productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto');</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>
