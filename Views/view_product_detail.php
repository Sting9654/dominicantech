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
    <?php include 'C_navbar.php'; ?>
    <?php if (isset($product)) { ?>
        <div class="container mt-4">
            <h1 class="p-4">Editar Producto</h1>
            <div class="row g-0">
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <img style="object-fit: contain; max-width: 100%; height: auto;" src="<?php echo htmlspecialchars($product['PROD_IMAGE_URL'] == '' ? 'Views/Assets/no-img-found.png' : $product['PROD_IMAGE_URL']); ?>" alt="Imagen del Producto">
                </div>
                <form class="col-md-6 p-5" action="index.php?controller=Product&action=update" method="post">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="id" class="form-label">Producto ID:</label>
                            <input type="number" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($product['PROD_ID']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['PROD_NAME']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="description" name="description" rows="3" style="resize: none;" required><?php echo htmlspecialchars($product['PROD_DESCRIPTION']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Precio Unitario:</label>
                            <input type="text" class="form-control" required id="price" name="price" value=<?php
                                                                                                    $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                                                                                    echo htmlspecialchars($formatter->formatCurrency($product['PROD_UNIT_PRICE'], 'DOP'));
                                                                                                    ?>>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock:</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['PROD_STOCK']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="available" class="form-label">Disponibilidad:</label>
                            <select id="available" class="form-select" name="available" required>
                                <option value="1" <?php echo $product['PROD_AVAILABLE'] == 1 ? 'selected' : ''; ?>>Disponible</option>
                                <option value="0" <?php echo $product['PROD_AVAILABLE'] == 0 ? 'selected' : ''; ?>>No Disponible</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen URL:</label>
                            <input type="url" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($product['PROD_IMAGE_URL']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="created_at" class="form-label">Fecha de Creación:</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="<?php echo htmlspecialchars($product['PROD_CREATED_AT']); ?>" readonly>
                        </div>

                        <input type="submit" class="btn btn-outline-primary w-100" value="Actualizar">
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var inputElement = document.getElementById("price");
                var mask = new Inputmask("currency", {
                    radixPoint: ".",
                    groupSeparator: ",",
                    prefix: "RD$ ",
                    digits: 2,
                    autoGroup: true,
                    removeMaskOnSubmit: true
                });
                mask.mask(inputElement);
            });
        </script>
    <?php
    } else {
        echo "<p>No se encontró el producto.</p>";
    }
    ?>
</body>

</html>