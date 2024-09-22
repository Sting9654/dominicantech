<?php
require_once 'Models/inventory.php';
require_once 'Models/operation.php';
require_once 'Models/product.php';

class InventoryController
{
    private $inventoryModel;
    private $operationModel;
    private $productModel;

    public function __construct()
    {
        $database = Db::getInstance()->getConnection();
        $this->productModel = new Product($database);
        $this->inventoryModel = new Inventory($database);
        $this->operationModel = new Operation($database);
    }

    public function index (){
        $inventory = $this->inventoryModel->getAllInventory();
        include 'Views/view_inventory_move_list.php';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>ID del movimiento no proporcionado o inválido.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        try {
            $inventory = $this->inventoryModel->getInventoryById($id);

            if ($inventory === false) {
                $result = [
                    "status" => false,
                    "body" => "<div class='alert'><h3>Movimiento de inventario no encontrado.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
                ];
                include 'Views/C_notification.php';
                return;
            }

            include 'views/view_inventory_move_detail.php';
        } catch (Exception $e) {
            error_log("Error al mostrar movimiento: " . $e->getMessage());
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Ocurrió un error al mostrar el movimiento: {$e->getMessage()}</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
            ];
            include 'Views/C_notification.php';
        }
    }

    public function createForm(){
        $operation = $this->operationModel->getAllOperation();
        $product = $this->productModel->getAllProducts();
        include 'Views/view_inventory_move_create.php';
    }

    public function create()
    {
        $operation = $_POST['operation'] ?? '';
        $product = $_POST['product'] ?? '';
        $quantity = $_POST['quantity'] ?? '';
        $createdAt = $_POST['created_at'] ?? '';

        if (empty($operation) || empty($product) || empty($quantity)) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Los campos Operación, Producto y Cantidad son obligatorios.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=create'>Volver a crear movimiento</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        if (!is_numeric($quantity) || $quantity <= 0) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>La cantidad debe ser un número positivo.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=create'>Volver a crear movimiento</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        if (!empty($createdAt) && !DateTime::createFromFormat('Y-m-d\TH:i', $createdAt)) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>La fecha/hora no es válida.</h3><br>
                       <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=create'>Volver a crear movimiento</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        $inventory = [
            'operation' => $operation,
            'product' => $product,
            'quantity' => $quantity,
            'created_at' => $createdAt
        ];

        try {
            $this->inventoryModel->createInventory($inventory);
            $result = [
                "status" => true,
                "body" => "<div class='alert'><h3>Movimiento de inventario creado exitosamente.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Ir al historial de movimientos</a></div>"
            ];
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Error al registrar el movimiento: {$e->getMessage()}</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=create'>Volver a crear movimiento</a></div>"
            ];
        }

        include 'Views/C_notification.php';
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>ID del movimiento no proporcionado o inválido.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        try {
            $deleted = $this->inventoryModel->deleteInventoryById($id);

            if ($deleted === false) {
                $result = [
                    "status" => false,
                    "body" => "<div class='alert'><h3>Movimiento de inventario no encontrado o no se pudo eliminar.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
                ];
            } else {
                $result = [
                    "status" => true,
                    "body" => "<div class='alert'><h3>Movimiento de inventario eliminado exitosamente.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
                ];
            }
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Error al eliminar el movimiento: {$e->getMessage()}</h3><br>
                       <a class='btn btn-outline-primary' href='index.php?controller=Inventory&action=index'>Dirigirse al historial de movimientos</a></div>"
            ];
        }

        include 'Views/C_notification.php';
    }
}
