<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" href="Views/Assets/Logo.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Inicio</title>
    <style>
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body h5 {
            flex-grow: 0;
        }

        .card-body p {
            flex-grow: 1;
        }

        .card-body a {
            margin-top: auto;
        }

        .card-img-top {
            object-fit: contain;
            height: 250px;
            width: 100%;
        }

        .btn-outline-primary {
            background-color: #fff;
            border: 2px;
            border-color: #007bff;
            color: #007bff;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-outline-primary:hover {
            color: #fff;
            background-color: #007bff;
            transform: translateY(-2px);
        }

        .btn-outline-primary:active {
            background-color: #004085;
            transform: translateY(0);
        }

        #hex-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .hexagon-icon {
            position: absolute;
            font-size: 60px;
            color: rgba(0, 123, 255, 0.6);
            opacity: 0;
            transition: transform 2s ease-in-out, opacity 1s ease-in-out;
        }

        @media screen and (max-width: 990px) {
            .carousel-img {
                width: 80%;
                height: 60%;
            }

        }
    </style>
</head>

<body>
    <div id="hex-background"></div>
    <?php include 'C_navbar.php' ?>
    <main class="pt-3">
        <section class="d-flex justify-content-center w-50 mx-auto" aria-label="banner">
            <div id="carouselIndicators" class="carousel slide w-100" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="Views/Assets/Banners/Banner_1.png" class="d-block" width="1000px" height="400" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="Views/Assets/Banners/Banner_2.png" class="d-block" width="1000px" height="400" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="Views/Assets/Banners/Banner_3.png" class="d-block" width="1000px" height="400" alt="...">
                    </div>
                </div>
            </div>
        </section>

        <section aria-label="news-products" class="m-5 p-4">
            <h2 class="pb-5">Novedades</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php if (isset($products) && is_array($products) && count($products) > 0): ?>
                    <?php foreach ($products as $row): ?>
                        <div class="col">
                            <div class="card h-100 shadow">
                                <img style="object-fit:contain;" height="250px" width="100%" src="<?php echo $row['PROD_IMAGE_URL'] === "" ? 'Views/Assets/no-img-found.png' : $row['PROD_IMAGE_URL']; ?>" class="card-img-top p-3">
                                <div class="card-body p-3">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['PROD_NAME']); ?></h5><br>
                                    <p class="card-text"><?php echo ucfirst(htmlspecialchars($row['PROD_DESCRIPTION'])); ?></p>
                                    <p class="card-text">Precio: <?php
                                                                    $formatter = new NumberFormatter('es_DO', NumberFormatter::CURRENCY);
                                                                    echo htmlspecialchars($formatter->formatCurrency($row['PROD_UNIT_PRICE'], 'DOP'));
                                                                    ?></p>
                                    <a href="index.php?controller=Product&action=show&id=<?php echo htmlspecialchars($row['PROD_ID']); ?>" class="btn btn-outline-primary">Ver producto</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Pronto se añadirán nuevos productos</p>
                <?php endif; ?>
            </div>
        </section>
        <script src="Public/js/script.js"></script>
    </main>
</body>

</html>