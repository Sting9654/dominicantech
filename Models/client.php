<?php
require_once 'Core/db.php';
class client
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        if ($this->db === null) {
            throw new Exception("No se pudo establecer la conexión a la base de datos.");
        }
    }

    public function getAllClients()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM tbl_client");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getClientById($id)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID del cliente debe ser un número.");
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM tbl_client WHERE CLI_ID = :id");
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

    public function createClient($client)
    {
        if (empty($client['email']) || empty($client['rnc'])) {
            throw new InvalidArgumentException("El RNC, el nombre y el correo electrónico del cliente son obligatorios.");
        }
    
        try {
            $stmt = $this->db->prepare("INSERT INTO tbl_client (CLI_NAME, CLI_LAST_NAME, CLI_RNC, CLI_EMAIL, CLI_ADDRESS) VALUES (:name, :last_name, :rnc, :email, :address)");
    
            $stmt->bindParam(':name', $client['name']);
            $stmt->bindParam(':last_name', $client['last_name']);
            $stmt->bindParam(':rnc', $client['rnc']);
            $stmt->bindParam(':email', $client['email']);
            $stmt->bindParam(':address', $client['address']);
    
            $stmt->execute();
    
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar cliente: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteClientById($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            throw new InvalidArgumentException("El ID del cliente debe ser un número entero positivo.");
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tbl_client WHERE `tbl_client`.`CLI_ID` = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al eliminar cliente: " . $e->getMessage());
            return false;
        }
    }

    public function updateClientById($id, $newValues)
    {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("El ID del cliente debe ser un número.");
        }

        $fields = [];
        foreach ($newValues as $column => $value) {
            $fields[] = "$column = :$column";
        }
        $fieldsList = implode(', ', $fields);

        try {
            $stmt = $this->db->prepare("UPDATE tbl_client SET {$fieldsList} WHERE CLI_ID = :id");

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
