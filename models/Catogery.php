<?php
     require_once __DIR__ . '/../config/connectDB.php';

     class Category {
        private $name;
        private $title;
        private $created_day;
        private $image;
        private $dataManager;

        public function __construct(
            $name = 'Uknown',
            $title = '',
            $image = null,
            $created_day = null,
            $dataManager = null
        ) {
            $this->name = $name;
            $this->title = $title;
            $this->created_day = $created_day ?: date('Y-m-d');
            $this->image = $image;
            $this->dataManager = databaseManager::getInstance();
        }

        public function getName() {
            return $this->name;
        }
    
        public function setName($name) {
            $this->name = $name;
        }
        public function getTitle() {
            return $this->title;
        }
    
        public function setTitle($title) {
            $this->title = $title;
        }
        public function getCreatedDay() {
            return $this->created_day;
        }
    
        public function setCreatedDay($created_day) {
            $this->created_day = $created_day;
        }
        public function getimage() {
            return $this->image;
        }
    
        public function setimage($image) {
            $this->image = $image;
        }

        public function createCategory() {
            $query = "INSERT INTO categories 
            (name, title, created_day, image) VALUES 
            ('$this->name', '$this->title', '$this->created_day', '$this->image')";
            return $this->dataManager->executeQuery($query);
        }
        public function getAllCatogery() {
            $query = "SELECT * FROM categories";
            $result = $this->dataManager->executeQuery($query);
            $catogeries = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $catogeries[] = $row;
                }
            }
            return $catogeries;
        }
        public function getValue($whereColumn, $value) {
            $query = "SELECT * FROM categories WHERE $whereColumn = '$value'";
            $result = $this->dataManager->executeQuery($query);
            if ($row = $result->fetch_assoc()) {
                return $row;
            } else {
                return null;
            }
        }
        public function updateCatogery($category_id) {
            $query = "UPDATE categories SET name = '$this->name', title = '$this->title', created_day = '$this->created_day', image = '$this->image' WHERE category_id = '$category_id'";
            return $this->dataManager->executeQuery($query);
        }
        public function deleteCategoryById($category_id) {
            $query = "DELETE FROM categories WHERE category_id = '$category_id'";
            $result = $this->dataManager->executeQuery($query);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
   }
?>