<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Movimientos</title>
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
    <h1 class="p-3">Historial de Movimientos</h1>
    <div class="p-3 mt-4">
        <table class="table-sm table table-striped table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col" class="align-content-center">ID Movimiento</th>
                    <th scope="col" class="align-content-center">Fecha/Hora</th>
                    <th scope="col" class="align-content-center">ID de Operación</th>
                    <th scope="col" class="align-content-center">Nombre de Operación</th>
                    <th scope="col" class="align-content-center">ID de Producto</th>
                    <th scope="col" class="align-content-center">Nombre del Producto</th>
                    <th scope="col" class="align-content-center">Cantidad</th>
                    <th scope="col" class="align-content-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center table-group-divider">
                <?php if (isset($inventory) && count($inventory) > 0): ?>
                    <?php foreach ($inventory as $row): ?>
                        <tr>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_ID']); ?></td>
                            <td scope="row" class="align-content-center"><?php
                                                                            $fecha = new DateTime($row['VW_CREATED_AT']);
                                                                            echo htmlspecialchars($fecha->format('d-m-Y H:i')); ?></td>
                            <td scope="row"><?php echo htmlspecialchars($row['VW_OPERATION_ID']); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_OPERATION_NAME']); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_PRODUCT_ID']); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_PRODUCT_NAME']); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_QUANTITY']); ?></td>
                            <td scope="row" class="align-content-center">
                                <div class="action-buttons">
                                    <a href="index.php?controller=Inventory&action=show&id=<?php echo htmlspecialchars($row['VW_ID']); ?>" class="btn btn-outline-primary"><i class="bi bi-eye-fill"></i></a>
                                    <form action="index.php?controller=Inventory&action=delete" method="post" style="margin: 0;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['VW_ID']); ?>">
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');"><i class='bi bi-trash3-fill'></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay datos para mostrar</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>