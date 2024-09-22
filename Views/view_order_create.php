<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Orden</title>
    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('Views/Assets/Background-static-forms.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            backdrop-filter: blur(1.5px);
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
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mb-4">Nueva Orden</h1>
        <form action="index.php?controller=Order&action=create" method="post">
            <div class="form-group">
                <label for="cliente" class="form-label">Cliente:</label>
                <select id="cliente" class="form-select" name="cliente" required>
                    <?php if (isset($clients) && count($clients) > 0): ?>
                        <?php foreach ($clients as $row): ?>
                            <option value="<?php echo htmlspecialchars($row['CLI_ID']) ?>"><?php echo htmlspecialchars($row['CLI_ID'] . " : " . $row['CLI_RNC'] . " : " . $row['CLI_NAME'] . " " . $row['CLI_LAST_NAME']); ?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_venta" class="form-label">Tipo de Venta:</label>
                <select id="tipo_venta" class="form-select" name="tipo_venta" required>
                    <?php if (isset($operations) && count($operations) > 0): ?>
                        <?php foreach ($operations as $row): ?>
                            <?php if ($row['OP_ID'] === 2 || $row['OP_ID'] === 3): ?>
                                <option value="<?php echo htmlspecialchars($row['OP_ID']) ?>"><?php echo htmlspecialchars($row['OP_ID'] . " : " . $row['OP_NAME']); ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
            </div>
            <div class="text-center pt-4">
                <button type="submit" class="btn btn-outline-primary">Crear Orden</button>
            </div>
        </form>
    </div>
</body>

</html>