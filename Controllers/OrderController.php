<?php
require_once 'Models/Order.php';
require_once 'Models/OrderDetail.php';
require_once 'Models/Client.php';
require_once 'Models/Operation.php';
require_once 'Models/Product.php';

class OrderController
{
    private $orderModel;
    private $orderDetailModel;
    private $clientModel;
    private $operationModel;
    private $productModel;

    public function __construct()
    {
        $database = Db::getInstance()->getConnection();
        $this->orderModel = new Order($database);
        $this->orderDetailModel = new OrderDetail($database);
        $this->clientModel = new Client($database);
        $this->operationModel = new Operation($database);
        $this->productModel = new Product($database);
    }

    public function index(): void
    {
        $orders = $this->orderModel->getAllOrder();
        include 'Views/view_order_list.php';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            return $this->handleError("ID de la orden no proporcionado o inválido.", "index.php?controller=Order&action=index");
        }

        try {
            $order = $this->orderModel->getOrderById($id);
            $orderDetails = $this->orderDetailModel->getDetailByOrder($id);
            if ($order === false) {
                return $this->handleError("Orden no encontrada.", "index.php?controller=Order&action=index");
            }
            include 'Views/view_order_detail.php';
        } catch (Exception $e) {
            return $this->handleError("Ocurrió un error al mostrar la orden: {$e->getMessage()}", "index.php?controller=Order&action=index");
        }
    }

    public function createForm()
    {
        $clients = $this->clientModel->getAllClients();
        $products = $this->productModel->getAllProducts();
        $operations = $this->operationModel->getAllOperation();
        include 'Views/view_order_create.php';
    }

    public function create()
    {
        if (empty($_POST['cliente']) || empty($_POST['tipo_venta'])) {
            return $this->handleError("Error: Todos los campos son obligatorios.", "index.php?controller=Order&action=createForm");
        }

        $orderData = [
            'cliente' => $_POST['cliente'],
            'tipo_venta' => $_POST['tipo_venta']
        ];

        try {
            $result = $this->orderModel->createOrder($orderData);
            $lastId = $result['lastId'] ?? null;

            if ($result && $lastId) {
                $body = "<h3>Orden creada exitosamente.</h3><br>
                         <a class='mb-2 btn btn-outline-primary' href='index.php?controller=Order&action=detailForm&id={$lastId}'>Seleccionar productos</a><br>
                         <a class='mb-2 btn btn-outline-primary' href='index.php?controller=Order&action=index'>Cancelar Orden</a>";
                return $this->handleSuccess($body);
            }
            return $this->handleError("Error al crear la orden.", "index.php?controller=Order&action=createForm");
        } catch (Exception $e) {
            return $this->handleError("Error: {$e->getMessage()}", "index.php?controller=Order&action=createForm");
        }
    }

    public function detailForm()
    {
        $orderId = $_GET['id'] ?? null;
        if ($orderId === null || !filter_var($orderId, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            return $this->handleError("ID de la orden no proporcionado o inválido.", "index.php?controller=Order&action=index");
        }

        $order = $this->orderModel->getOrderById($orderId);
        $orderDetails = $this->orderDetailModel->getDetailByOrder($orderId);
        $products = $this->productModel->getAllProducts();
        include 'Views/view_order_detail_create.php';
    }

    public function addProduct()
    {
        $productDetail = [
            'order' => intval($_POST['order']),
            'product' => intval($_POST['product']),
            'quantity' => intval($_POST['quantity'] ?? 0),
            'discount' => floatval($_POST['discount'] ?? 0) / 100
        ];
    
        if (is_null($productDetail['order']) || is_null($productDetail['product'])) {
            return $this->handleError("'order' o 'product' no están definidos.", "index.php?controller=Order&action=detailForm&id=" . $productDetail['order']);
        }
    
        try {
            $product = $this->productModel->getProductById($productDetail['product']);
            if (!$product) {
                return $this->handleError("Error: Producto no encontrado.", "index.php?controller=Order&action=detailForm&id=" . $productDetail['order']);
            }
    
            $productDetail['price'] = floatval($product['PROD_UNIT_PRICE']);
            
            $this->orderDetailModel->createOrderDetail($productDetail);
            
            header("Location: index.php?controller=Order&action=detailForm&id=" . $productDetail['order']);
            exit;
        } catch (Exception $e) {
            return $this->handleError("Error: {$e->getMessage()}", "index.php?controller=Order&action=detailForm&id=" . $productDetail['order']);
        }
    }

    public function closeOrder (){
        $orderDetail = $_POST['order'];
        $this->orderModel->closeOrder($orderDetail);
        include 'Views/view_order_create.php';
    }
    

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            return $this->handleError("ID de la orden no proporcionado o inválido.", "index.php?controller=Order&action=index");
        }

        try {
            $deleted = $this->orderModel->deleteOrderById($id);
            $body = $deleted === false
                ? "<h3>Producto no encontrado o no se pudo eliminar.</h3>"
                : "<h3>Producto eliminado exitosamente.</h3>";
            return $this->handleSuccess($body);
        } catch (Exception $e) {
            return $this->handleError("Error al eliminar la orden: {$e->getMessage()}", "index.php?controller=Order&action=index");
        }
    }

    public function deleteDetail()
    {
        $id = $_POST['id'] ?? null;
        $orderId = $_POST['order'] ?? null;
    
        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            return $this->handleError("ID de producto no proporcionado o inválido.", "index.php?controller=Order&action=index");
        }
    
        try {
            $deleted = $this->orderDetailModel->deleteDetailById($id);
            if ($deleted === false) {
                return $this->handleError("Producto no encontrado o no se pudo eliminar.", "index.php?controller=Order&action=detailForm&id=" . $orderId);
            }
    
            return $this->handleSuccess("Producto eliminado exitosamente.");
        } catch (Exception $e) {
            return $this->handleError("Error al eliminar el producto: {$e->getMessage()}", "index.php?controller=Order&action=detailForm&id=" . $orderId);
        }
    }
    

    private function handleError($message, $redirectUrl)
    {
        $result = [
            "status" => false,
            "body" => "<h3>{$message}</h3><br>
                       <a class='btn btn-outline-primary' href='{$redirectUrl}'>Volver</a>"
        ];
        include 'Views/C_notification.php';
    }

    private function handleSuccess($body)
    {
        $result = [
            "status" => true,
            "body" => $body
        ];
        include 'Views/C_notification.php';
    }
}
