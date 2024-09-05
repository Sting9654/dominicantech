<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views\Assets\Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
</head>

<body>
    <h1>Lista de Productos</h1>
    <table border="1px solid">
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>UNIT PRICE</th>
            <th>STOCK</th>
            <th>AVAILABLE</th>
            <th>CREATED AT</th>
            <th>ACTIONS</th>
        </tr>
        <?php
        if (isset($products) && count($products) > 0) {
            foreach ($products as $row) {
                $row['PROD_AVAILABLE'] = $row['PROD_AVAILABLE'] == 1 ? 'Disponible' : 'No Disponible';
                echo "
                <tr align='center'>
                <td>{$row['PROD_ID']}</td>
                <td>{$row['PROD_NAME']}</td>
                <td>{$row['PROD_UNIT_PRICE']}</td>
                <td>{$row['PROD_STOCK']}</td>
                <td>{$row['PROD_AVAILABLE']}</td>
                <td>{$row['PROD_CREATED_AT']}</td>
                <td>
                    <form action='index.php?controller=Product&action=delete' method='post'>
                        <input type='hidden' id='id' name='id' value='{$row['PROD_ID']}'>
                        <input type='submit' value='Eliminar'>
                    </form>
                    <form action='index.php?controller=Product&action=show' method='post'>
                        <input type='hidden' id='id' name='id' value='{$row['PROD_ID']}'>
                        <input type='submit' value='Editar'>
                    </form>
                </td>
                </tr>
                ";
            }
        } else {
            echo "<tr>
            <th colspan='7'>No hay datos para mostrar</th>
            </tr>";
        }
        ?>
    </table>
</body>

</html>