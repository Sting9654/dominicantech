<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views\Assets\Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
</head>

<body>
    <h1>Registrar Cliente</h1>

    <form action="index.php?controller=Client&action=create" method="post">

        <label for="rnc">RNC:</label>
        <input type="text" id="rnc" name="rnc" placeholder="Ingrese el RNC" required>
        <br>

        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" placeholder="Ingrese el nombre" required>
        <br>

        <label for="last_name">Apellido:</label>
        <input type="text" id="last_name" name="last_name" placeholder="Ingrese el apellido" required>
        <br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" placeholder="Ingrese el correo electrónico" required>
        <br>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" placeholder="Ingrese la dirección" required>
        <br>

        <input type="submit" value="Registrar Cliente">
    </form>

</body>

</html>