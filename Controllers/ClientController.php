<?php
require_once 'Models/client.php';

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
        $id = $_GET['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>ID de cliente no proporcionado o inválido.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
            ];
            include 'Views/C_notification.php';
        }

        try {
            $client = $this->clientModel->getClientById($id);

            if ($client === false) {
                $result = [
                    "status" => false,
                    "body" => "<div class='alert'><h3>Cliente no encontrado.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                ];
                include 'Views/C_notification.php';
            } else {
                include 'views/view_client_detail.php';
            }
        } catch (Exception $e) {
            error_log("Error al mostrar cliente: " . $e->getMessage());
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Ocurrió un error al mostrar el cliente.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
            ];
            include 'Views/C_notification.php';
        }
    }

    public function createForm()
    {
        require 'Views/view_client_create.php';
    }

    public function create()
    {
        $rnc = $_POST['rnc'] ?? '';
        $name = $_POST['name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        if (empty($rnc) || empty($name) || empty($lastName) || empty($email) || empty($address)) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Todos los campos son obligatorios.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Client&action=create'>Volver a crear cliente</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        $client = [
            'rnc' =>  $rnc,
            'name' => ucwords($name),
            'last_name' => ucwords($lastName),
            'email' => $email,
            'address' => $address
        ];

        try {
            $this->clientModel->createClient($client);
            $result = [
                "status" => true,
                "body" => "<div class='alert'><h3>Cliente creado exitosamente.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Ir a la lista de clientes</a></div>"
            ];
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Error al crear el cliente: {$e->getMessage()}</h3><br>
                       <a class='btn btn-outline-primary' href='index.php?controller=Client&action=create'>Volver a crear cliente</a></div>"
            ];
        }

        include 'Views/C_notification.php';
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>ID de cliente no proporcionado o inválido.</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        try {
            $deleted = $this->clientModel->deleteClientById($id);

            if ($deleted === false) {
                $result = [
                    "status" => false,
                    "body" => "<div class='alert'><h3>Cliente no encontrado o no se pudo eliminar.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                ];
            } else {
                $result = [
                    "status" => true,
                    "body" => "<div class='alert'><h3>Cliente eliminado exitosamente.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                ];
            }
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Error al eliminar el cliente: {$e->getMessage()}</h3><br>
                       <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
            ];
        }

        include 'Views/C_notification.php';
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
                'CLI_NAME' => ucwords($name),
                'CLI_LAST_NAME' => ucwords($lastName),
                'CLI_EMAIL' => $email,
                'CLI_ADDRESS' => $address
            ];

            try {
                $result = $this->clientModel->updateClientById($id, $newValues);

                if ($result) {
                    $result = [
                        "status" => true,
                        "body" => "<div class='alert'><h3>Cliente actualizado con éxito.</h3><br>
                                   <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                    ];
                } else {
                    $result = [
                        "status" => false,
                        "body" => "<div class='alert'><h3>No se realizaron cambios en el cliente.</h3><br>
                                   <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                    ];
                }
            } catch (Exception $e) {
                error_log("Error al actualizar el cliente: " . $e->getMessage());
                $result = [
                    "status" => false,
                    "body" => "<div class='alert'><h3>Ocurrió un error al actualizar el cliente.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
                ];
            }
        } else {
            $result = [
                "status" => false,
                "body" => "<div class='alert'><h3>Datos incompletos para la actualización.</h3><br>
                       <a class='btn btn-outline-primary' href='index.php?controller=Client&action=index'>Dirigirse a la lista de clientes</a></div>"
            ];
        }

        include 'Views/C_notification.php';
    }
}
