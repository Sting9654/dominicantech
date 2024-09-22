<?php
require_once 'Models/product.php';

class HomeController
{
    private $productModel;

    public function __construct()
    {
        $database = Db::getInstance()->getConnection();
        $this->productModel = new Product($database);
    }

    public function index()
    {
        $products = $this->productModel->getLastAdded();
        require 'Views/view_home.php';
    }
}
