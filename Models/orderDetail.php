<?php
require_once 'Core/db.php';

class OrderDetail
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getDetailByOrder($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID de la orden debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM vw_order_detail WHERE VW_ORDER_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orderDetails ?: false;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error general: " . $e->getMessage());
            return false;
        }
    }

    public function createOrderDetail($orderDetail)
    {
        if (empty($orderDetail['order']) || empty($orderDetail['product']) || $orderDetail['quantity'] <= 0) {
            throw new InvalidArgumentException("El ID de la orden, el ID del producto son obligatorios y la cantidad debe ser mayor que 0.");
        }

        $orderDetail['total_amount'] = ($orderDetail['price'] * $orderDetail['quantity']) - ($orderDetail['quantity'] * ($orderDetail['price'] * $orderDetail['discount']));

        try {
            $stmt = $this->db->prepare("
                INSERT INTO tbl_order_detail 
                (ODTL_ORDER_ID, ODTL_PRODUCT_ID, ODTL_QUANTITY, ODTL_UNIT_PRICE, ODTL_DISCOUNT, ODTL_TOTAL_AMOUNT) 
                VALUES (:order, :product, :quantity, :price, :discount, :total_amount)
            ");

            $stmt->bindParam(':order', $orderDetail['order']);
            $stmt->bindParam(':product', $orderDetail['product']);
            $stmt->bindParam(':quantity', $orderDetail['quantity']);
            $stmt->bindParam(':price', $orderDetail['price']);
            $stmt->bindParam(':discount', $orderDetail['discount']);
            $stmt->bindParam(':total_amount', $orderDetail['total_amount']);

            $stmt->execute();

            return true;
        } catch (Exception $e) {
            error_log("Error al insertar detalle de la orden: " . $e->getMessage());
            return false;
        }
    }

    public function deleteDetailById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID del detalle debe ser un número entero positivo.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tbl_order_detail WHERE ODTL_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar detalle: " . $e->getMessage());
            return false;
        }
    }
}
