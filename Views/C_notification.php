<?php isset($result); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="Public/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>
        <?php
        if ($result['status'] === true) {
            echo "Éxito";
        } else {
            echo "Error!";
        }
        ?>
    </title>
    <style>
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
    </style>
</head>

<body>
    <div id="hex-background"></div>
    <script src="Public/js/script.js"></script>
    <?php include 'C_navbar.php' ?>
    <div class='d-flex justify-content-center align-items-center' style='height: 100vh;'>
        <div class='card text-center justify-content-center align-items-center shadow' style='width: 22rem; border: none;'>
            <?php if ($result['status'] === true): ?>
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player src="https://lottie.host/0d61c1d9-ed6f-45ea-bd36-3c488407bd4e/qxuwPcN9It.json" background="transparent" speed="1" style="width: 300px; height: 300px;" autoplay></dotlottie-player>
            <?php else: ?>
                <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player src="https://lottie.host/4eb83e45-4787-4aa7-b3c4-1ba040d3ef99/mwn1oet7r7.json" background="transparent" speed="1" style="width: 300px; height: 300px;" autoplay></dotlottie-player>
            <?php endif; ?>
            <div class='card-body align-items-center justify-content-center'>
                <?= $result['body']; ?>
            </div>
        </div>
    </div>

</body>

</html>