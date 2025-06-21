<?php
require_once __DIR__ . '/../config/connectDB.php';

class Product
{
    private $dataManager;

    public function __construct()
    {
        $this->dataManager = databaseManager::getInstance();
    }

    public function createProduct($name, $description, $price, $quantity, $category_id, $image = null)
    {
        $created_day = date('Y-m-d');
        $query = "INSERT INTO products (name, description, created_day, price, image, quantity, category_id) 
                  VALUES ('$name', '$description', '$created_day', '$price', '$image', '$quantity', '$category_id')";
        return $this->dataManager->executeQuery($query);
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getProductById($product_id)
    {
        $query = "SELECT * FROM products WHERE product_id = $product_id";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_assoc() : null;
    }

    public function updateProduct($product_id, $name, $description, $price, $quantity, $category_id, $image = null)
    {
        $query = "UPDATE products 
                  SET name = '$name', description = '$description', price = '$price', 
                      quantity = '$quantity', category_id = '$category_id', image = '$image' 
                  WHERE product_id = $product_id";
        return $this->dataManager->executeQuery($query);
    }

    public function deleteProductById($product_id)
    {
        $query = "DELETE FROM products WHERE product_id = $product_id";
        return $this->dataManager->executeQuery($query);
    }

    public function getProductsByCategoryId($category_id)
    {
        $query = "SELECT * FROM products WHERE category_id = $category_id";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateProductQuantity($product_id, $newQuantity)
    {
        $query = "UPDATE products SET quantity = '$newQuantity' WHERE product_id = $product_id";
        return $this->dataManager->executeQuery($query);
    }
    // Kiểm tra xem có sản phẩm thuộc danh mục đang được bán trong hóa đơn không
    public function isProductInCategoryInInvoice($category_id)
    {
        $query = "SELECT COUNT(*) as count FROM invoice_details 
                  INNER JOIN products ON invoice_details.product_id = products.product_id 
                  WHERE products.category_id = $category_id";
        $result = $this->dataManager->executeQuery($query);
        $data = $result->fetch_assoc();
        return $data['count'] > 0;
    }

    // Xóa sản phẩm theo danh mục
    public function deleteProductByCategory($category_id)
    {
        $query = "DELETE FROM products WHERE category_id = $category_id";
        return $this->dataManager->executeQuery($query);
    }
    // Kiểm tra xem sản phẩm có trong hóa đơn không
    public function isProductInInvoice($product_id)
    {
        $query = "SELECT COUNT(*) as count FROM invoice_details WHERE product_id = $product_id";
        $result = $this->dataManager->executeQuery($query);
        $data = $result->fetch_assoc();
        return $data['count'] > 0;
    }
    public function getValue($whereColumn, $value)
    {
        $query = "SELECT * FROM products WHERE $whereColumn = '$value'";
        $result = $this->dataManager->executeQuery($query);
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    }
    public function getValues($column, $value)
    {
        $query = "SELECT * FROM products WHERE $column = '$value'";
        $result = $this->dataManager->executeQuery($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductsByInvoiceId($invoice_id)
    {
        $query = "SELECT p.*, id.quantity FROM products p 
                              JOIN invoice_details id ON p.product_id = id.product_id 
                              WHERE id.invoice_id = '$invoice_id'";
        $result = $this->dataManager->executeQuery($query);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }
}
?>