<?php
    require_once __DIR__ . '/../config/connectDB.php';

    class Comment {
        private $content;
        private $user_id;
        private $product_id;
        private $created_day;
        private $dataManager;

        public function __construct(
            $content = '',
            $user_id = null,
            $product_id = null,
            $created_day = null,
            $dataManager = null
        ) {
            $this->content = $content;
            $this->user_id = $user_id;
            $this->product_id = $product_id;
            $this->created_day = $created_day;
            $this->dataManager = databaseManager::getInstance();
        }

        public function getCreatedDay() {
            return $this->created_day;
        }

        public function setCreatedDay($created_day) {
            $this->created_day = $created_day;
        }

        public function getContent() {
            return $this->content;
        }

        public function setContent($content) {
            $this->content = $content;
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

        public function addComment() {
            $query = "INSERT INTO comment_product (content, create_day, user_id, product_id) VALUES ('$this->content', '$this->created_day', '$this->user_id', '$this->product_id')";
            return $this->dataManager->executeQuery($query);
        }

        public function deleteCmtById($cmt_id) {
            $query = "DELETE FROM comment_product WHERE cmt_id = '$cmt_id'";
            return $this->dataManager->executeQuery($query);
        }

        public function deleteCmtByUser($user_id) {
            $query = "DELETE FROM comment_product WHERE user_id = '$user_id'";
            return $this->dataManager->executeQuery($query);
        }

        public function deleteCmtByProduct($product_id) {
            $query = "DELETE FROM comment_product WHERE product_id = '$product_id'";
            return $this->dataManager->executeQuery($query);
        }

        public function getCmtByProduct($product_id) {
            $query = "SELECT * FROM comment_product WHERE product_id = '$product_id'";
            $result = $this->dataManager->executeQuery($query);
            $comments = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $comments[] = $row;
                }
            }
            return $comments;
        }
    }
?>
