<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views\Assets\Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>

<body>
    <h1>Lista de Clientes</h1>
    <button onclick='window.location.href="http://localhost/Diplomado%20Back-end/dominicanatech/index.php?controller=Client&action=createForm"'>Nuevo Cliente</button>
    <table border="1px solid">
        <tr>
            <th>ID</th>
            <th>RNC</th>
            <th>NAME</th>
            <th>LAST NAME</th>
            <th>EMAIL</th>
            <th>CREATED AT</th>
            <th>ACTIONS</th>
        </tr>
        <?php
        if (isset($clients) && count($clients) > 0) {
            foreach ($clients as $row) {
                echo "
                <tr>
                <td >{$row['CLI_ID']}</td>
                <td>{$row['CLI_RNC']}</td>
                <td>{$row['CLI_NAME']}</td>
                <td>{$row['CLI_LAST_NAME']}</td>
                <td>{$row['CLI_EMAIL']}</td>
                <td>{$row['CLI_CREATED_AT']}</td>
                <td>
                    <form action='index.php?controller=Client&action=delete' method='post'>
                        <input type='hidden' id='id' name='id' value='{$row['CLI_ID']}'>
                        <input type='submit' value='Eliminar'>
                    </form>
                    <form action='index.php?controller=Client&action=show' method='post'>
                        <input type='hidden' id='id' name='id' value='{$row['CLI_ID']}'>
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