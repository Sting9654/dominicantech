<?php
require_once 'Core/db.php';
class Operation
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getAllOperation()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM tbl_operation");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getOperationById($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID de la operación debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM tbl_operation WHERE OP_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $operation = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$operation) {
                return false;
            }

            return $operation;
        } catch (PDOException $e) {
            error_log("Error en la consulta: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error general: " . $e->getMessage());
            return false;
        }
    }

    public function createOperation($operation)
    {
        if (empty($operation['name']) || empty($operation['description'])) {
            throw new InvalidArgumentException("El nombre de la operación y la descripción debe ser obligatorio.");
        }

        if (empty($operation['created_at'])) {
            try {
                $stmt = $this->db->prepare("INSERT INTO tbl_operation (OP_NAME, OP_DESCRIPTION, OP_CREATED_AT) VALUES (:name, :description)");
                $stmt->bindParam(':name', $operation['name']);
                $stmt->bindParam(':description', $operation['description']);
                $stmt->execute();
                return $this->db->lastInsertId();
            } catch (Exception $e) {
                error_log("Error al crear operación:" . $e->getMessage());
                return false;
            }
        } else {
            try {
                $stmt = $this->db->prepare("INSERT INTO tbl_operation (OP_NAME, OP_DESCRIPTION, OP_CREATED_AT) VALUES (:name, :description, :created_at)");
                $stmt->bindParam(':name', $operation['name']);
                $stmt->bindParam(':description', $operation['description']);
                $stmt->bindParam(':created_at', $operation['created_at']);
                $stmt->execute();
                return $this->db->lastInsertId();
            } catch (Exception $e) {
                error_log("Error al crear operación:" . $e->getMessage());
                return false;
            }
        }
    }

    public function deleteOperationById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID del la operación debe ser un número entero positivo.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tbl_product WHERE `tbl_operation`.`OP_ID` = :id");
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

    public function updateOperationById($id, $newValues)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID de la operación debe ser un número.");
        }

        $fields = [];
        foreach ($newValues as $column => $value) {
            $fields[] = "$column = :$column";
        }
        $fieldsList = implode(', ', $fields);

        try {
            $stmt = $this->db->prepare("UPDATE tbl_operation SET {$fieldsList} WHERE OP_ID = :id");

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
