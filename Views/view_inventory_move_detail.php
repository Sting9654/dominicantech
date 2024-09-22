<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Movimiento</title>
    <link href="Public/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('Views/Assets/Background-static-forms.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            backdrop-filter: blur(1.5px);
        }

        .container {
            max-width: 75%;
            background-color: #fff;
            border-radius: 20px;
            padding: 30px;
            margin-top: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .order-details p {
            font-size: 1.1rem;
        }

        table {
            background-color: #fff;
            border-radius: 12px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>

    <div class="container mt-4 p-4">
        <h1 class="pb-2">Detalles del Movimiento</h1>

        <div class="order-details">
            <p><strong>ID del Movimiento: </strong><?php echo htmlspecialchars($inventory['VW_ID']); ?></p>
            <p><strong>Fecha del Movimiento: </strong><?php echo htmlspecialchars($inventory['VW_CREATED_AT']); ?></p>
            <p><strong>Cantidad: </strong><?php echo htmlspecialchars($inventory['VW_QUANTITY']); ?></p>
            <p><strong>ID de la Operación: </strong><?php echo htmlspecialchars($inventory['VW_OPERATION_ID']); ?></p>
            <p><strong>Operación: </strong><?php echo htmlspecialchars($inventory['VW_OPERATION_NAME']); ?></p>
            <p><strong>ID del Producto: </strong><?php echo htmlspecialchars($inventory['VW_PRODUCT_ID']); ?></p>
            <p><strong>Producto: </strong><?php echo htmlspecialchars($inventory['VW_PRODUCT_NAME']); ?></p>
        </div>
    </div>
</body>

</html>