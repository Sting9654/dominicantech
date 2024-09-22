<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Orden</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            max-width: 800px;
            margin-top: 50px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .text-center h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
        }

        .text-center.pt-4 form {
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>
    <div class="container">
        <?php if (isset($order)): ?>
            <div class="order-details">
                <h1>Detalles de la orden</h1>
                <p><strong>Orden ID: </strong><?php echo htmlspecialchars($order['VW_ORDER_ID'] ?? 'No disponible'); ?></p>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($order['VW_DATE'] ?? 'No disponible'); ?></p>
                <p><strong>Tipo de Venta:</strong> <?php echo htmlspecialchars($order['VW_SALE_TYPE'] ?? 'No disponible'); ?></p>
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($order['VW_CLIENT_FULLNAME'] ?? 'No disponible'); ?></p>
                <p><strong>Monto Total: </strong>
                    <?php
                    $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                    echo htmlspecialchars($formatter->formatCurrency($order['VW_TOTAL_AMOUNT'] ?? 0, 'DOP'));
                    ?>
                </p>
                <form action="index.php?controller=Order&action=delete" method="post" class="p-1">
                    <input type="hidden" class="form-control" id="order" name="order" value="<?php echo htmlspecialchars($orderId ?? ''); ?>">
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');"><i class="bi bi-x-circle-fill"></i> Cancelar Transacción</button>
                </form>
            </div>
        <?php else: ?>
            <p>No se encontraron detalles de la orden.</p>
        <?php endif; ?>
        <div class="text-center pt-4 m-4">
            <h2 class="text-center mb-4">Añadir Productos</h2>
            <form action="index.php?controller=Order&action=addProduct" method="post" class="mb-4 d-inline">
                <input type="hidden" class="form-control" id="order" name="order" value="<?php echo htmlspecialchars($orderId ?? ''); ?>">
                <input type="hidden" class="form-control" id="status" name="status" value=true>

                <div class="row mb-3">
                    <div class="col">
                        <label for="product" class="form-label">Seleccionar Producto:</label>
                        <select id="product" class="form-select" name="product" required>
                            <?php if (isset($products) && count($products) > 0): ?>
                                <?php foreach ($products as $row): ?>
                                    <option value="<?php echo htmlspecialchars($row['PROD_ID']); ?>">
                                        <?php echo htmlspecialchars($row['PROD_ID'] . " : " . $row['PROD_NAME']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay productos disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="discount" class="form-label">Descuento (%):</label>
                        <input type="number" class="form-control" name="discount" id="discount" min="0" max="100" step="0.01">
                    </div>
                    <div class="col">
                        <label for="quantity" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" min="1">
                    </div>
                </div>
                <div class="text-center pt-4">
                    <button type="submit" class="btn btn-outline-success me-2">
                        <i class="bi bi-plus-circle-fill"></i> Agregar producto
                    </button>
                </div>
            </form>

            <form action="index.php?controller=Order&action=closeOrder" method="post" class="p-1">
                <input type="hidden" class="form-control" id="order" name="order" value="<?php echo htmlspecialchars($orderId ?? ''); ?>">
                <button type="submit" class="btn btn-outline-success">
                    <i class="bi bi-cash-stack"></i> Finalizar transacción
                </button>
            </form>
        </div>
        <h3 class="mt-4">Productos Añadidos</h3>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($orderDetails) && is_array($orderDetails) && count($orderDetails) > 0): ?>
                    <?php foreach ($orderDetails as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['VW_PRODUCT']); ?></td>
                            <td><?php echo htmlspecialchars($row['VW_QUANTITY']); ?></td>
                            <td><?php echo number_format($row['VW_DISCOUNT'] * 100, 2); ?>%</td>
                            <td>
                                <?php
                                $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                echo htmlspecialchars($formatter->formatCurrency($row['VW_TOTAL_AMOUNT'], 'DOP'));
                                ?>
                            </td>
                            <td>
                                <form action="index.php?controller=Order&action=deleteDetail">
                                    <input type="hidden" class="form-control" id="order" name="order" value="<?php echo htmlspecialchars($orderId ?? ''); ?>">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['VW_ID']); ?>">
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto de la orden?');"><i class='bi bi-trash3-fill'></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No se han añadido productos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>