<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
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
        <h1 class="text-center mb-4">Registrar Cliente</h1>
        <form action="index.php?controller=Client&action=create" method="post">
            <div class="form-group">
                <label for="rnc">RNC:</label>
                <input type="text" maxlength="10" class="form-control" id="rnc" name="rnc" placeholder="Ingrese el RNC" required>
            </div>

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" maxlength="64" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" required>
            </div>

            <div class="form-group">
                <label for="last_name">Apellido:</label>
                <input type="text" maxlength="64" class="form-control" id="last_name" name="last_name" placeholder="Ingrese el apellido" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" maxlength="255" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico" required>
            </div>

            <div class="form-group">
                <label for="address">Dirección:</label>
                <input type="text" maxlength="255" class="form-control" id="address" name="address" placeholder="Ingrese la dirección" required>
            </div>

            <div class="text-center pt-3">
                <button type="submit" class="btn-submit">Registrar Cliente</button>
            </div>
        </form>
    </div>
</body>

</html>