<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="Public/css/bootstrap.min.css" rel="stylesheet">
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

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
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'C_navbar.php'; ?>
    <div class="container mt-4">
        <h1 class="pb-4 pt-4">Editar Cliente</h1>
        <?php
        if (isset($client)) {
        ?>
            <form action="index.php?controller=Client&action=update" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['CLI_ID']); ?>">

                <div class="mb-3">
                    <label for="rnc" class="form-label">RNC:</label>
                    <input type="text" maxlength="10" id="rnc" name="rnc" class="form-control" value="<?php echo htmlspecialchars($client['CLI_RNC']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" maxlength="64" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($client['CLI_NAME']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido:</label>
                    <input type="text" maxlength="64" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($client['CLI_LAST_NAME']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" maxlength="255" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($client['CLI_EMAIL']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Dirección:</label>
                    <textarea id="address" maxlength="255" name="address" class="form-control" rows="3" style="resize: none;" required><?php echo htmlspecialchars($client['CLI_ADDRESS']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="created_at" class="form-label">Fecha de Creación:</label>
                    <input type="datetime-local" id="created_at" name="created_at" class="form-control" value="<?php echo htmlspecialchars($client['CLI_CREATED_AT']); ?>" readonly>
                </div>

                <div class="w-100">
                    <input type="submit" class="btn btn-outline-primary" value="Actualizar">
                </div>
            </form>
        <?php
        } else {
            echo "<p>No se encontró el cliente.</p>";
        }
        ?>
    </div>
</body>

</html>