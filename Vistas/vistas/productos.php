<?php
include '../M_inventario_aprendiz/conexion.php';

$query = "SELECT * FROM productos";
$resultado = $conexion->query($query);
$productos = [];
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Proyecto_inv/Vistas/Estilos/style-productos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b14fd039d4.js" crossorigin="anonymous"></script>
    <title>Productos Registrados</title>
</head>
<body>

<form action="/Proyecto_inv/Vistas/vistas/ingreso.php" method="POST" style="position: absolute; top: 50px; right: 92%;">
    <button type="submit" name="cerrar_sesion" 
        style="font-size: 30px; padding: 0px 20px; border-radius: 10px; color: white; border: none; cursor: pointer;">🔙</button>
</form>
<div class="venta">
    <a href="/Proyecto_inv/Vistas/vistas/venta_producto.php"><button></button></a>
</div>

<div class="container">
    <h3 class="text-center mb-4">𝙋𝙧𝙤𝙙𝙪𝙘𝙩𝙤𝙨 𝙍𝙚𝙜𝙞𝙨𝙩𝙧𝙖𝙙𝙤𝙨</h3>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar productos por cualquier campo...">
    </div>

    <div class="row" id="productsContainer">
    </div>

    <div class="text-center mt-4" id="paginationContainer">

    </div>
</div>

<script>
    const productos = <?php echo json_encode($productos); ?>;
    const productsContainer = document.getElementById('productsContainer');
    const paginationContainer = document.getElementById('paginationContainer');
    const searchInput = document.getElementById('searchInput');

    const itemsPerPage = 9;
    let currentPage = 1;

    function renderPagination() {
        const totalPages = Math.ceil(productos.length / itemsPerPage);
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = `btn btn-secondary mx-1 ${i === currentPage ? 'active' : ''}`;
            pageButton.textContent = i;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                loadProducts();
                renderPagination();
            });
            paginationContainer.appendChild(pageButton);
        }
    }

    function loadProducts() {
        productsContainer.innerHTML = '';
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        const fragment = document.createDocumentFragment();
        for (let i = startIndex; i < endIndex && i < productos.length; i++) {
            const producto = productos[i];
            const col = document.createElement('div');
            col.className = 'col-md-4 mb-4';
            col.innerHTML = `
                <div class='card'>
                    <div class='card-body'>
                        <h5 class='card-title'>${producto.nombre_producto}</h5>
                        <p class='card-text'><strong>Categoría:</strong> ${producto.categoria}</p>
                        <p class='card-text'><strong>Estado:</strong> ${producto.estado_producto}</p>
                        <p class='card-text'><strong>Cantidad:</strong> ${producto.cantidad}</p>
                        <p class='card-text'><strong>Precio:</strong> $${parseFloat(producto.precio).toFixed(2)}</p>
                        <p class='card-text'><strong>Fecha Ingreso:</strong> ${producto.fecha_ingreso}</p>
                        <div class='d-flex justify-content-between'>
                            <a href='editar_producto.php?codigo=${producto.codigo}' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='eliminar_producto.php?codigo=${producto.codigo}' class='btn btn-danger btn-sm' onclick='return confirm("\u00bfEstás seguro de que quieres eliminar este producto?");'>Eliminar</a>
                            
                        </div>
                    </div>
                </div>
            `;
            fragment.appendChild(col);
        }
        productsContainer.appendChild(fragment);
    }

    searchInput.addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const cards = document.querySelectorAll('#productsContainer .card');

        cards.forEach(card => {
            const cardText = card.innerText.toLowerCase();
            card.parentElement.style.display = cardText.includes(searchValue) ? '' : 'none';
        });
    });

    loadProducts();
    renderPagination();
</script><br>

</body>
</html>
