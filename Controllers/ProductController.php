<?php
require_once 'Models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $database = Db::getInstance()->getConnection();
        $this->productModel = new Product($database);
    }

    public function index(): void
    {
        $products = $this->productModel->getAllProducts();
        include 'Views/view_product_list.php';
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $result = [
                "status" => false,
                "body" => "<h3>ID de producto no proporcionado o inválido.</h3><br>
                           <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        try {
            $product = $this->productModel->getProductById($id);

            if ($product === false) {
                $result = [
                    "status" => false,
                    "body" => "<h3>Producto no encontrado.</h3><br>
                               <a class='btn btn-outline-primary' href='index.php?controller=Product&action=index'>Ir a la lista de productos</a>"
                ];
                include 'Views/C_notification.php';
            } else {
                include 'Views/view_product_detail.php';
            }
        } catch (Exception $e) {
            error_log("Error al mostrar producto: " . $e->getMessage());
            $result = [
                "status" => false,
                "body" => "<h3>Ocurrió un error al mostrar el producto: {$e->getMessage()}</h3><br>
                           <a class='btn btn-outline-primary' href='index.php?controller=Product&action=index'>Ir a la lista de productos</a>"
            ];
            include 'Views/C_notification.php';
        }
    }

    public function createForm()
    {
        include 'Views/view_product_create.php';
    }

    public function create()
    {
        $product = [
            'name' => strtoupper($_POST['name']),
            'description' => strtoupper($_POST['description']),
            'price' => str_replace(",", "", str_replace("RD$", "", $_POST["price"])),
            'image' => $_POST['image'],
            'available' => 0
        ];

        try {
            $result = $this->productModel->createProduct($product);

            if ($result === true) {
                $result = [
                    "status" => true,
                    "body" => "<h3>Producto creado exitosamente.</h3><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=createForm'>Seguir creando productos</a><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Ir a lista de productos</a>"
                ];
            } else {
                $result = [
                    "status" => false,
                    "body" => "<h3>Error al crear el producto.</h3><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=createForm'>Volver a crear productos</a><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Ir a lista de productos</a>"
                ];
            }
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<h3>Error: {$e->getMessage()}</h3>"
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
                "body" => "<h3>ID de producto no proporcionado o inválido.</h3><br>
                           <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>"
            ];
            include 'Views/C_notification.php';
            return;
        }

        try {
            $deleted = $this->productModel->deleteProductById($id);

            if ($deleted === false) {
                $result = [
                    "status" => false,
                    "body" => "<h3>Producto no encontrado o no se pudo eliminar.</h3><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>"
                ];
            } else {
                $result = [
                    "status" => true,
                    "body" => "<h3>Producto eliminado exitosamente.</h3><br>
                               <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>"
                ];
            }
        } catch (Exception $e) {
            $result = [
                "status" => false,
                "body" => "<h3>Error al eliminar el producto: {$e->getMessage()}</h3>"
            ];
        }

        include 'Views/C_notification.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? '';
        $description = $_POST['description'] ?? '';
        $imageUrl = $_POST['image'] ?? '';
        $name = $_POST['name'] ?? '';
        $price = str_replace(",", "", str_replace("RD$", "", $_POST["price"]));
        $available = $_POST['available'] ?? '';

        if ($id !== '') {
            $newValues = [
                'PROD_NAME' => $name,
                'PROD_DESCRIPTION' => $description,
                'PROD_IMAGE_URL' => $imageUrl,
                'PROD_UNIT_PRICE' => $price,
                'PROD_AVAILABLE' => $available
            ];

            try {
                $result = $this->productModel->updateProductById($id, $newValues);

                if ($result === true) {
                    $result = [
                        "status" => true,
                        "body" => "<h3>Producto actualizado exitosamente.</h3><br>
                                   <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Ir a lista de productos</a>"
                    ];
                } else {
                    $result = [
                        "status" => false,
                        "body" => "<h3>Error al actualizar el producto.</h3><br>
                                   <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Ir a lista de productos</a>"
                    ];
                }
            } catch (Exception $e) {
                $result = [
                    "status" => false,
                    "body" => "<h3>Error: {$e->getMessage()}</h3>"
                ];
            }
        } else {
            $result = [
                "status" => false,
                "body" => "<h3>Datos incompletos para la actualización.</h3><br>
                           <a class='btn btn-outline-primary mb-2' href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>"
            ];
        }

        include 'Views/C_notification.php';
    }
}
