<?php
require_once 'Core/db.php';
require_once 'Models/Inventory.php';
require_once 'Models/OrderDetail.php';

class Order
{
    private $db;
    private $inventoryModel;
    private $orderDetailModel;

    public function __construct($database)
    {
        $this->db = $database;
        $this->inventoryModel = new Inventory($database);
        $this->orderDetailModel = new OrderDetail($database);
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getAllOrder()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM VW_SALES");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getOrderById($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID de la orden debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM VW_SALES WHERE VW_ORDER_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            return $order ?: false;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        }
    }

    public function closeOrder($id)
    {
        $orderDetails = $this->orderDetailModel->getDetailByOrder($id);
    
        if ($orderDetails === false || empty($orderDetails)) {
            error_log("No se encontraron detalles para la orden ID: " . $id);
            return false;
        }
    
        try {
            $order = $this->getOrderById($id);
            foreach ($orderDetails as $row) {
                if (isset($row['VW_PRODUCT_ID']) && isset($row['VW_QUANTITY'])) {
                    $orderDetail = [
                        'operation' => $order['VW_SALE_TYPE_ID'],
                        'product' => $row['VW_PRODUCT_ID'],
                        'quantity' => $row['VW_QUANTITY']
                    ];
                    if (!$this->inventoryModel->createInventory($orderDetail)) {
                        throw new Exception("Error al registrar el movimiento en el inventario para el producto ID: " . $row['VW_PRODUCT_ID']);
                    }
                } else {
                    error_log("Datos de detalle de orden faltantes para el producto ID: " . ($row['VW_PRODUCT_ID'] ?? 'desconocido'));
                }
            }
    
            return true;
        } catch (Exception $e) {
            error_log("Error cerrando la orden: " . $e->getMessage());
            return false;
        }
    }    

    public function createOrder($order)
    {
        if (empty($order['cliente']) || empty($order['tipo_venta'])) {
            throw new InvalidArgumentException("El cliente y el tipo de venta de la orden son obligatorios");
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO tbl_order (ORD_CLIENT_ID, ORD_SALE_TYPE) VALUES (:cliente, :tipo_venta)");
            $stmt->bindParam(':tipo_venta', $order['tipo_venta']);
            $stmt->bindParam(':cliente', $order['cliente']);
            $stmt->execute();
            return [
                'status' => true,
                'lastId' => $this->db->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error al insertar orden: " . $e->getMessage());
            return false;
        }
    }

    public function deleteOrderById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID de la orden debe ser un número entero positivo.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tbl_order WHERE `tbl_order`.`ORD_ID` = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar orden: " . $e->getMessage());
            return false;
        }
    }
}
