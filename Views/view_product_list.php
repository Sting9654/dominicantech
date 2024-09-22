<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-image: url('Views/Assets/Background-static-list.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: bottom;
            background-attachment: fixed;
            backdrop-filter: blur(1.5px);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>
    <div id="hex-background"></div>
    <h1 class="p-3">Lista de Productos</h1>
    <div class="p-3 mt-4">
        <table class="table-sm table table-striped table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">ID Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Disponibilidad</th>
                    <th scope="col">Fecha de Creación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center table-group-divider" class="text-center align-content-center">
                <?php if (isset($products) && count($products) > 0): ?>
                    <?php foreach ($products as $row): ?>
                        <tr>
                            <td scope="row"><?php echo htmlspecialchars($row['PROD_ID']); ?></td>
                            <td scope="row"><?php echo htmlspecialchars($row['PROD_NAME']); ?></td>
                            <td scope="row">
                                <?php
                                $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                echo htmlspecialchars($formatter->formatCurrency($row['PROD_UNIT_PRICE'], 'DOP'));
                                ?>
                            </td>
                            <td scope="row"><?php echo htmlspecialchars($row['PROD_STOCK']); ?></td>
                            <td scope="row"><?php echo $row['PROD_AVAILABLE'] === 1 ? 'Disponible' : 'No Disponible' ?></td>
                            <td scope="row"><?php
                                            $fecha = new DateTime($row['PROD_CREATED_AT']);
                                            echo htmlspecialchars($fecha->format('d-m-Y')); ?></td>
                            <td scope="row">
                                <div class="action-buttons">
                                    <a href="index.php?controller=Product&action=show&id=<?php echo htmlspecialchars($row['PROD_ID']); ?>" class="btn btn-outline-primary"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="index.php?controller=Product&action=delete" method="post" style="margin: 0;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['PROD_ID']); ?>">
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');"><i class='bi bi-trash3-fill'></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay datos para mostrar</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>