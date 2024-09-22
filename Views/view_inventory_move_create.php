<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Movimiento</title>
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
            max-width: 600px;
            margin-top: 50px;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
        }

        label {
            padding: 5px;
            margin-top: 5px;
        }

        .form-group label {
            padding-top: 5px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #007bff;
        }

        .btn-submit {

            background-color: #fff;
            border: 1 px;
            border-color: #007bff;
            color: #007bff;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            color: #fff;
            background-color: #007bff;
            transform: translateY(-2px);
        }

        .btn-submit:active {
            background-color: #004085;
            transform: translateY(0);
        }

        .text-center h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #343a40;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mb-4">Registrar Movimiento</h1>
        <form action="index.php?controller=Inventory&action=create" method="post">
            <div class="form-group">
                <label for="operation" class="form-label">Operación:</label>
                <select id="operation" class="form-select" name="operation" required>
                    <?php if (isset($operation) && count($operation) > 0): ?>
                        <?php foreach ($operation as $row): ?>
                            <?php if ($row['OP_ID'] !== 2 && $row['OP_ID'] !== 3): ?>
                                <option value="<?php echo htmlspecialchars($row['OP_ID']) ?>"><?php echo htmlspecialchars($row['OP_ID'] . " : " . $row['OP_NAME']); ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product" class="form-label">Product:</label>
                <select id="product" class="form-select" name="product" required>
                    <?php if (isset($product) && count($product) > 0): ?>
                        <?php foreach ($product as $row): ?>
                            <option value="<?php echo htmlspecialchars($row['PROD_ID']) ?>"><?php echo htmlspecialchars($row['PROD_ID'] . " : " . $row['PROD_NAME']); ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Ingrese la cantidad" required>
            </div>
            <div class="form-group">
                <label for="created_at">Fecha/Hora Movimiento:</label>
                <input type="datetime-local" class="form-control" id="created_at" name="created_at">
            </div>
            <div class="text-center pt-3">
                <button type="submit" class="btn-submit">Registrar Movimiento</button>
            </div>
        </form>
    </div>
</body>

</html>