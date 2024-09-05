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

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        require 'views/view_product_list.php';
    }

    public function show()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            echo "<h3>ID de producto no proporcionado o inválido.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
            return;
        }

        try {
            $product = $this->productModel->getProductById($id);

            if ($product === false) {
                echo "<h3>Producto no encontrado.</h3><br>
                <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
                return;
            }

            require 'views/view_product_detail.php';
        } catch (Exception $e) {
            error_log("Error al mostrar producto: " . $e->getMessage());
            echo "<h3>Ocurrió un error al mostrar el producto.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
        }
    }

    public function delete()
    {
        $id = $_POST['id'] ?? null;

        if ($id === null || !filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            echo "<h3>ID de producto no proporcionado o inválido.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
            return;
        }

        $deleted = $this->productModel->deleteProductById($id);

        if ($deleted === false) {
            echo "<h3>Producto no encontrado o no se pudo eliminar.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
        } else {
            echo "<h3>Producto eliminado exitosamente.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
        }
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $unitPrice = $_POST['unit_price'] ?? '';
        $stock = $_POST['stock'] ?? '';
        $available = $_POST['available'] ?? '';

        if ($id && $name && $unitPrice && $stock !== '' && $available !== '') {
            $newValues = [
                'PROD_NAME' => $name,
                'PROD_UNIT_PRICE' => $unitPrice,
                'PROD_STOCK' => $stock,
                'PROD_AVAILABLE' => $available
            ];

            try {
                $result = $this->productModel->updateProductById($id, $newValues);

                if ($result) {
                    echo "<h3>Producto actualizado con éxito.</h3><br>
                    <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
                } else {
                    echo "<h3>No se realizaron cambios en el producto.</h3><br>
                    <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
                }
            } catch (Exception $e) {
                error_log("Error al actualizar el producto: " . $e->getMessage());
                echo "<h3>Ocurrió un error al actualizar el producto.</h3><br>
                <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
            }
        } else {
            echo "<h3>Datos incompletos para la actualización.</h3><br>
            <a href='index.php?controller=Product&action=index'>Dirigirse a la lista de productos</a>";
        }
    }
}
