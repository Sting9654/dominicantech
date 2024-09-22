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
                    <th scope="col" class="align-content-center">ID Transacción</th>
                    <th scope="col" class="align-content-center">Fecha/Hora</th>
                    <th scope="col" class="align-content-center">Tipo de Venta</th>
                    <th scope="col" class="align-content-center">Cliente</th>
                    <th scope="col" class="align-content-center">Monto Total</th>
                    <th scope="col" class="align-content-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center table-group-divider">
                <?php if (isset($orders) && count($orders) > 0): ?>
                    <?php foreach ($orders as $row): ?>
                        <tr>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_ORDER_ID']); ?></td>
                            <td scope="row" class="align-content-center"><?php
                                                                            $fecha = new DateTime($row['VW_DATE']);
                                                                            echo htmlspecialchars($fecha->format('d-m-Y H:i')); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_SALE_TYPE']); ?></td>
                            <td scope="row" class="align-content-center"><?php echo htmlspecialchars($row['VW_CLIENT_FULLNAME']); ?></td>
                            <td scope="row" class="align-content-center"><?php $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                                                            echo htmlspecialchars($formatter->formatCurrency($row['VW_TOTAL_AMOUNT'], 'DOP')); ?></td>
                            <td scope="row" class="align-content-center">
                                <div class="action-buttons">
                                    <a href="index.php?controller=Order&action=show&id=<?php echo htmlspecialchars($row['VW_ORDER_ID']); ?>" class="btn btn-outline-primary"><i class="bi bi-eye-fill"></i></a>
                                    <form action="index.php?controller=Order&action=delete" method="post" style="margin: 0;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['VW_ORDER_ID']); ?>">
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta orden?');"><i class='bi bi-trash3-fill'></i></button>
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