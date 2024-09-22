<?php
require 'Controllers/ProductController.php';
require 'Controllers/ClientController.php';
require 'Controllers/InventoryController.php';
require 'Controllers/HomeController.php';
require 'Controllers/OrderController.php';

$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $action)) {
        $controller->{$action}();
    } else {
        echo "La acción '$action' no existe en el controlador '$controllerClass'.";
    }
} else {
    echo "El controlador '$controllerClass' no existe.";
}
