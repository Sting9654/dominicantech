<?php
require 'Controllers/ProductController.php';
require 'Controllers/ClientController.php';
require 'Controllers/HomeController.php';


$controllerName = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';
$id = $_POST['id'] ?? $_GET['id'] ?? null;

$controllerClass = ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    
    if (method_exists($controller, $action)) {
        if ($id !== null) {
            $controller->{$action}($id);
        } else {
            $controller->{$action}();
        }
    } else {
        echo "La acción '$action' no existe en el controlador '$controllerClass'.";
    }
} else {
    echo "El controlador '$controllerClass' no existe.";
}
