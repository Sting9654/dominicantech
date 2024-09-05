<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views\Assets\Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>

<body>
    <h1>Editar Cliente</h1>
    <?php

    if (isset($clients)) {
    ?>
        <form action="index.php?controller=Client&action=update" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($clients['CLI_ID']); ?>">

            <label for="rnc">RNC:</label>
            <input type="text" id="rnc" name="rnc" value="<?php echo htmlspecialchars($clients['CLI_RNC']); ?>" required>
            <br>

            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($clients['CLI_NAME']); ?>" required>
            <br>

            <label for="last_name">Apellido:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($clients['CLI_LAST_NAME']); ?>" required>
            <br>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($clients['CLI_EMAIL']); ?>" required>
            <br>

            <label for="address">Dirección:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($clients['CLI_ADDRESS']); ?></textarea>
            <br>

            <label for="created_at">Fecha de Creación:</label>
            <input type="datetime-local" id="created_at" name="created_at" value="<?php echo htmlspecialchars($clients['CLI_CREATED_AT']); ?>" readonly>
            <br>

            <input type="submit" value="Actualizar">
        </form>
    <?php
    } else {
        echo "<p>No se encontró el cliente.</p>";
    }
    ?>
</body>

</html>