<?php
   require_once __DIR__ . '/../config/connectDB.php';
   class Product {
        private $name;
        private $description;
        private $created_day;
        private $price;
        private $quantity;
        private $category_id;
        private $image;
        private $dataManager;

        public function __construct(
            $name = 'Uknown',
            $description = '',
            $created_day = null,
            $price = 0,
            $quantity = 0,
            $category_id = null,
            $image = null,
            $dataManager = null
        ) {
            $this->name = $name;
            $this->description = $description;
            $this->created_day = $created_day;
            $this->price = $price;
            $this->quantity = $quantity;
            $this->category_id = $category_id;
            $this->image = $image;
            $this->dataManager = databaseManager::getInstance();
        }

        public function getName() {
            return $this->name;
        }
    
        public function setName($name) {
            $this->name = $name;
        }
        public function getDescription() {
            return $this->description;
        }
    
        public function setDescription($description) {
            $this->description = $description;
        }
        public function getCreatedDay() {
            return $this->created_day;
        }
    
        public function setCreatedDay($created_day) {
            $this->created_day = $created_day;
        }
        public function getPrice() {
            return $this->price;
        }
    
        public function setPrice($price) {
            $this->price = $price;
        }
        public function getQuantity() {
            return $this->quantity;
        }
    
        public function setQuantity($quantity) {
            $this->quantity = $quantity;
        }
        public function getCategoryId() {
            return $this->category_id;
        }
    
        public function setCategoryId($category_id) {
            $this->category_id = $category_id;
        }
        public function getImage() {
            return $this->image;
        }
    
        public function setImage($image) {
            $this->image = $image;
        }
        public function getAllProduct() {
            $query = "SELECT * FROM products";
            $result = $this->dataManager->executeQuery($query);
            $products = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
            }
            return $products;
        }
        public function createProduct() {
            $query = "INSERT INTO products 
            (name, description, created_day, price, image, quantity, category_id) VALUES 
            ('$this->name', '$this->description', '$this->created_day', '$this->price', '$this->image', '$this->quantity', '$this->category_id')";
            return $this->dataManager->executeQuery($query);
        }
        public function getValue($whereColumn, $value) {
            $query = "SELECT * FROM products WHERE $whereColumn = '$value'";
            $result = $this->dataManager->executeQuery($query);
            if ($row = $result->fetch_assoc()) {
                return $row;
            }
            return null;
        }
        public function getValues($whereColumn, $value) {
            $query = "SELECT * FROM products WHERE $whereColumn = '$value'";
            $result = $this->dataManager->executeQuery($query);
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        
        public function updateProduct($product_id) {
            $query = "UPDATE products SET name = '$this->name', description = '$this->description', created_day = '$this->created_day', image = '$this->image', price = '$this->price', quantity = '$this->quantity', category_id = '$this->category_id' WHERE product_id = '$product_id'";
            return $this->dataManager->executeQuery($query);
        }
        public function deleteProductById($product_id) {
            $query = "DELETE FROM products WHERE product_id = '$product_id'";
            $result = $this->dataManager->executeQuery($query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        public function deleteProductByCategory($category_id) {
            $query = "DELETE FROM products WHERE category_id = '$category_id'";
            $result = $this->dataManager->executeQuery($query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        public function getProductsByInvoiceId($invoice_id) {
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
        public function isProductInInvoice($product_id) {
            $query = "SELECT COUNT(*) as count FROM invoice_details WHERE product_id = $product_id";
            $result = $this->dataManager->executeQuery($query);
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        }
    
        public function isProductInCategoryInInvoice($category_id) {
            $query = "SELECT COUNT(*) as count FROM invoice_details WHERE product_id IN (SELECT product_id FROM products WHERE category_id = $category_id)";
            $result = $this->dataManager->executeQuery($query);
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        }
        public function updateProductQuantity($product_id, $newQuantity) {
            $query = "UPDATE products SET quantity = '$newQuantity' WHERE product_id = '$product_id'";
            return $this->dataManager->executeQuery($query);
        }
   }
?>