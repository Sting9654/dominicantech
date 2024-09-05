<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views\Assets\Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>

<body>
    <h1>Editar Producto</h1>
    <?php

    if (isset($product)) {
    ?>
        <form action="index.php?controller=Product&action=update" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['PROD_ID']); ?>">


            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['PROD_NAME']); ?>" required>
            <br>

            <label for="unit_price">Precio Unitario (RD$):</label>
            <input type="number" id="unit_price" name="unit_price" value="<?php echo htmlspecialchars($product['PROD_UNIT_PRICE']); ?>" required>
            <br>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['PROD_STOCK']); ?>" required>
            <br>

            <label for="available">Disponible:</label>
            <select id="available" name="available" required>
                <option value="1" <?php echo $product['PROD_AVAILABLE'] == 1 ? 'selected' : ''; ?>>Disponible</option>
                <option value="0" <?php echo $product['PROD_AVAILABLE'] == 0 ? 'selected' : ''; ?>>No Disponible</option>
            </select>
            <br>

            <label for="created_at">Fecha de Creación:</label>
            <input type="datetime-local" id="created_at" name="created_at" value="<?php echo htmlspecialchars($product['PROD_CREATED_AT']); ?>" readonly>
            <br>

            <input type="submit" value="Actualizar">
        </form>
    <?php
    } else {
        echo "<p>No se encontró el producto.</p>";
    }
    ?>
</body>

</html>