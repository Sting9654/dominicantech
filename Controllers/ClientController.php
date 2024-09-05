<?php
require_once 'Models/Client.php';

class ClientController
{
    private $clientModel;

    public function __construct()
    {
        $database = Db::getInstance()->getConnection();
        $this->clientModel = new Client($database);
    }

    public function index()
    {
        $clients = $this->clientModel->getAllClients();
        require 'views/view_client_list.php';
    }

    public function show()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            echo "<h3>ID de cliente no proporcionado o inválido.</h3><br>
            <a href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a>";
            return;
        }

        try {
            $clients = $this->clientModel->getClientById($id);

            if ($clients === false) {
                echo "<h3>cliente no encontrado.</h3><br>
                <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de cliente</a>";
                return;
            }

            require 'views/view_client_detail.php';
        } catch (Exception $e) {
            error_log("Error al mostrar cliente: " . $e->getMessage());
            echo "<h3>Ocurrió un error al mostrar el cliente.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de clientes</a>";
        }
    }

    public function createForm()
    {
        require 'Views\view_client_create.php';
    }

    public function create()
    {

        $rnc = $_POST['rnc'] ?? '';
        $name = $_POST['name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        if (empty($rnc) || empty($name) || empty($lastName) || empty($email) || empty($address)) {
            throw new InvalidArgumentException("Todos los campos son obligatorios.");
        }

        $client = [
            'rnc' => $rnc,
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'address' => $address
        ];

        $result = $this->clientModel->createClient($client);

        if ($result) {
            echo "Cliente creado exitosamente con ID: " . $result;
        } else {
            echo "Error al crear el cliente.";
        }
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            echo "<h3>ID de cliente no proporcionado o inválido.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de clientes</a>";
            return;
        }

        $deleted = $this->clientModel->deleteClientById($id);

        if ($deleted === false) {
            echo "<h3>cliente no encontrado o no se pudo eliminar.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de clientes</a>";
        } else {
            echo "<h3>cliente eliminado exitosamente.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de clientes</a>";
        }
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $rnc = $_POST['rnc'] ?? '';
        $name = $_POST['name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        if ($id && $rnc && $name && $lastName && $email && $address) {
            $newValues = [
                'CLI_RNC' => $rnc,
                'CLI_NAME' => $name,
                'CLI_LAST_NAME' => $lastName,
                'CLI_EMAIL' => $email,
                'CLI_ADDRESS' => $address
            ];

            try {
                $result = $this->clientModel->updateClientById($id, $newValues);

                if ($result) {
                    echo "<h3>Cliente actualizado con éxito.</h3><br>
                    <a href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a>";
                } else {
                    echo "<h3>No se realizaron cambios en el cliente.</h3><br>
                    <a href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a>";
                }
            } catch (Exception $e) {
                error_log("Error al actualizar el cliente: " . $e->getMessage());
                echo "<h3>Ocurrió un error al actualizar el cliente.</h3><br>
                <a href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a>";
            }
        } else {
            echo "<h3>Datos incompletos para la actualización.</h3><br>
            <a href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a>";
        }
    }
}
