<link rel="stylesheet" href="Public/css/bootstrap.min.css">
<link rel="stylesheet" href="Public/css/custom.css">
<header>
    <nav class="navbar shadow navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="txt-bold navbar-brand" href="index.php">
                <img height="35px" width="35px" class="figure-img rounded" src="Views/Assets/Logo.png" alt="Logo">Dominicana Tech
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="txt-light nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            Productos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Product&action=index">Lista de Productos</a></li>
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Product&action=createForm">Registrar Producto</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="txt-light nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            Inventario
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Inventory&action=index">Historial de Movimientos</a></li>
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Inventory&action=createForm">Registrar Movimiento</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="txt-light nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Client&action=index">Lista de Clientes</a></li>
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Client&action=createForm">Registrar Cliente</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="txt-light nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            Ventas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Order&action=index">Lista de Ordenes</a></li>
                            <li><a class="dropdown-item txt-li" href="index.php?controller=Order&action=createForm">Nueva Orden</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="Public/js/bootstrap.bundle.min.js"></script>