<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('Views/Assets/Background-static-forms.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            backdrop-filter: blur(1.5px);
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .container {
            max-width: 75%;
            background-color: #fff;
            border-radius: 20px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php' ?>

    <div class="container mt-4 p-4">
        <h1 class="pb-2">Detalles de la Orden</h1>

        <div class="order-details">
            <p><strong>Orden ID: </strong><?php echo $order['VW_ORDER_ID']; ?></p>
            <p><strong>Fecha:</strong> <?php echo $order['VW_DATE']; ?></p>
            <p><strong>Tipo de Venta:</strong> <?php echo $order['VW_SALE_TYPE']; ?></p>
            <p><strong>Cliente:</strong> <?php echo $order['VW_CLIENT_FULLNAME']; ?></p>
            <p><strong>Monto Total: </strong><?php
                                                $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                                echo htmlspecialchars($formatter->formatCurrency($order['VW_TOTAL_AMOUNT'], 'DOP'));
                                                ?></p>
        </div>

        <h3 class="p-2">Detalles de Productos</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Monto Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $row): ?>
                    <tr>
                        <td><?php echo $row['VW_PRODUCT']; ?></td>
                        <td><?php echo $row['VW_QUANTITY']; ?></td>
                        <td><?php echo number_format($row['VW_DISCOUNT'], 2); ?>%</td>
                        <td> <?php
                                $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                echo htmlspecialchars($formatter->formatCurrency($row['VW_TOTAL_AMOUNT'], 'DOP'));
                                ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

</html>