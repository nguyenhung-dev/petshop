<?php
     require_once __DIR__ . '/../config/connectDB.php';

     class Cart {
        private $name;
        private $product_count;
        private $price;
        private $image;
        private $user_id;
        private $product_id;
        private $dataManager;

        public function __construct(
            $name = 'Uknown',
            $price = null,
            $image = null,
            $user_id = null,
            $product_id = null,
            $product_count = 1,
            $dataManager = null
        ) {
            $this->name = $name;
            $this->product_count = $product_count;
            $this->price = $price;
            $this->image = $image;
            $this->user_id = $user_id;
            $this->product_id = $product_id;
            // $this->dataManager = $dataManager ?: new databaseManager('localhost', 'root', 'lnh070601.', 'petshop');
            $this->dataManager = databaseManager::getInstance();
        }

        public function getName() {
            return $this->name;
        }
    
        public function setName($name) {
            $this->name = $name;
        }
        public function getProductCount() {
            return $this->product_count;
        }
    
        public function setProductCount($product_count) {
            $this->product_count = $product_count;
        }
        public function getImage() {
            return $this->price;
        }
    
        public function setImage($image) {
            $this->image = $image;
        }
        public function getPrice() {
            return $this->price;
        }
    
        public function setPrice($price) {
            $this->price = $price;
        }
        public function getUserId() {
            return $this->user_id;
        }
    
        public function setUserId($user_id) {
            $this->user_id = $user_id;
        }
        public function getProductId() {
            return $this->product_id;
        }
    
        public function setProductId($product_id) {
            $this->product_id = $product_id;
        }

        public function addProductInCart() {
            $query = "INSERT INTO carts 
            (image, name, price, user_id, product_id, product_count) VALUES 
            ('$this->image', '$this->name', '$this->price', '$this->user_id', '$this->product_id', '$this->product_count')";
            return $this->dataManager->executeQuery($query);
        }
        public function updateProductCount($user_id, $product_id) {
            $query = "UPDATE carts SET product_count = product_count + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
            return $this->dataManager->executeQuery($query);
        }
        public function productExistsInCart($user_id, $product_id) {
            $query = "SELECT * FROM carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $result = $this->dataManager->executeQuery($query);
            return mysqli_num_rows($result) > 0;
        }
        public function getValues($whereColumn, $value) {
            $query = "SELECT * FROM carts WHERE $whereColumn = '$value'";
            $result = $this->dataManager->executeQuery($query);
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        public function deleteProductInCart($product_id) {
            $query = "DELETE FROM carts WHERE product_id = '$product_id'";
            $result = $this->dataManager->executeQuery($query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        public function deleteProductInCartByUser($user_id) {
            $query = "DELETE FROM carts WHERE user_id = '$user_id'";
            $result = $this->dataManager->executeQuery($query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
     }
?>