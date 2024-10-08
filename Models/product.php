<?php
require_once 'Core/db.php';
class Product
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getAllProducts()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM tbl_product");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getLastAdded()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM tbl_product ORDER BY PROD_CREATED_AT DESC LIMIT 6");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getProductById($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID del producto debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM tbl_product WHERE PROD_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return false;
            }

            return $product;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error general: " . $e->getMessage());
            return false;
        }
    }

    public function createProduct($product)
    {
        if (empty($product['name']) || empty($product['description'])) {
            throw new InvalidArgumentException("El nombre del producto y la descripción son obligatorios");
        }


        try {
            $stmt = $this->db->prepare("INSERT INTO tbl_product (PROD_NAME, PROD_DESCRIPTION, PROD_IMAGE_URL, PROD_UNIT_PRICE, PROD_AVAILABLE) VALUES (:name, :description, :image, :price, :available)");

            $stmt->bindParam(':name', $product['name']);
            $stmt->bindParam(':description', $product['description']);
            $stmt->bindParam(':image', $product['image']);
            $stmt->bindParam(':price', $product['price']);
            $stmt->bindParam(':available', $product['available']);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error al insertar cliente: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProductById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID del producto debe ser un número entero positivo.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tbl_product WHERE `tbl_product`.`PROD_ID` = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return false;
        }
    }

    public function updateProductById($id, $newValues)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID del producto debe ser un número.");
        }

        $fields = [];
        foreach ($newValues as $column => $value) {
            $fields[] = "$column = :$column";
        }
        $fieldsList = implode(', ', $fields);

        try {
            $stmt = $this->db->prepare("UPDATE tbl_product SET {$fieldsList} WHERE prod_id = :id");

            foreach ($newValues as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
