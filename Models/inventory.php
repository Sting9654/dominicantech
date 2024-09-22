<?php
require_once 'Core/db.php';
require_once 'Models/product.php';
class Inventory
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getAllInventory()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM vw_movimientos_inventario");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getInventoryById($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID del movimiento debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM vw_movimientos_inventario WHERE VW_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$inventory) {
                return false;
            }

            return $inventory;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error general: " . $e->getMessage());
            return false;
        }
    }

    public function createInventory($inventory)
    {
        if (empty($inventory['operation']) || empty($inventory['product']) || empty($inventory['quantity'])) {
            throw new InvalidArgumentException("Rellenar los campos (operation, product, quantity)");
        }

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO tbl_mov_inventory (MOV_OPERATION_ID, MOV_PRODUCT_ID, MOV_QUANTITY) 
                VALUES (:operation, :product, :quantity)
            ");

            $stmt->bindParam(':operation', $inventory['operation'], PDO::PARAM_INT);
            $stmt->bindParam(':product', $inventory['product'], PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $inventory['quantity'], PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el movimiento: " . implode(", ", $stmt->errorInfo()));
            }

            $this->updateProductStock($inventory);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error al crear movimiento en inventario: " . $e->getMessage());
            return false;
        }
    }

    private function updateProductStock($inventory)
    {
        $updateQuery = "";
        if ($inventory['operation'] == 1) {
            $updateQuery = "UPDATE TBL_PRODUCT SET PROD_STOCK = PROD_STOCK + :quantity WHERE PROD_ID = :product_id";
        } elseif (in_array($inventory['operation'], [2, 3, 5, 6])) {
            $updateQuery = "UPDATE TBL_PRODUCT SET PROD_STOCK = PROD_STOCK - :quantity WHERE PROD_ID = :product_id";
        }

        if (!empty($updateQuery)) {
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindValue(':quantity', $inventory['quantity'], PDO::PARAM_INT);
            $updateStmt->bindValue(':product_id', $inventory['product'], PDO::PARAM_INT);

            if (!$updateStmt->execute()) {
                throw new Exception("Error al actualizar el stock: " . implode(", ", $updateStmt->errorInfo()));
            }
        }
    }


    public function deleteInventoryById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID del movimiento debe ser un número entero positivo.");
        }

        try {
            $this->db->beginTransaction();

            $selectQuery = "SELECT MOV_OPERATION_ID, MOV_PRODUCT_ID, MOV_QUANTITY FROM tbl_mov_inventory WHERE MOV_ID = :id";
            $selectStmt = $this->db->prepare($selectQuery);
            $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $selectStmt->execute();
            $inventory = $selectStmt->fetch(PDO::FETCH_ASSOC);

            if (!$inventory) {
                throw new Exception("Movimiento de inventario no encontrado.");
            }

            $deleteStmt = $this->db->prepare("DELETE FROM tbl_mov_inventory WHERE MOV_ID = :id");
            $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $deleteStmt->execute();

            if ($deleteStmt->rowCount() > 0) {
                $updateQuery = "";
                if ($inventory['MOV_OPERATION_ID'] === 1) {
                    $updateQuery = "UPDATE TBL_PRODUCT SET PROD_STOCK = PROD_STOCK - :quantity WHERE PROD_ID = :product_id";
                } else {
                    $updateQuery = "UPDATE TBL_PRODUCT SET PROD_STOCK = PROD_STOCK + :quantity WHERE PROD_ID = :product_id";
                }

                $updateStmt = $this->db->prepare($updateQuery);
                $updateStmt->bindParam(':quantity', $inventory['MOV_QUANTITY'], PDO::PARAM_INT);
                $updateStmt->bindParam(':product_id', $inventory['MOV_PRODUCT_ID'], PDO::PARAM_INT);
                $updateStmt->execute();

                $this->db->commit();

                return true;
            } else {
                $this->db->rollBack();
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error al eliminar movimiento: " . $e->getMessage());
            return false;
        }
    }
}
