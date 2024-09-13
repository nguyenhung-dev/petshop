<?php
     require_once __DIR__ . '/../config/connectDB.php';

     class InvoiceDetail {
        private $quantity;
        private $total_money;
        private $dataManager;
        private $invoice_id;
        private $product_id;

        public function __construct(
            $quantity = 0,
            $total_money = 0,
            $product_id = null,
            $invoice_id = null,
            $dataManager = null
        ) {
            $this->product_id = $product_id;
            $this->invoice_id = $invoice_id;
            $this->quantity = $quantity;
            $this->total_money = $total_money;
            $this->dataManager = databaseManager::getInstance();
        }


        public function getQuantity() {
            return $this->quantity;
        }
    
        public function setQuantity($quantity) {
            $this->quantity = $quantity;
        }
        public function getTotalMoney() {
            return $this->total_money;
        }
    
        public function setTotalMoney($total_money) {
            $this->total_money = $total_money;
        }
        public function getProductId() {
            return $this->product_id;
        }
    
        public function setProductId($product_id) {
            $this->product_id = $product_id;
        }
        public function getInvoiceId() {
            return $this->invoice_id;
        }
    
        public function setInvoiceId($invoice_id) {
            $this->invoice_id = $invoice_id;
        }

        public function addInvoiceDetail() {
            $query = "INSERT INTO invoice_details (product_id, invoice_id, quantity, total_money) VALUES ('$this->product_id', '$this->invoice_id', '$this->quantity', '$this->total_money')";
            return $this->dataManager->executeQuery($query);
        }
        public function hasInvoiceDetails($invoice_id) {
            $query = "SELECT COUNT(*) as count FROM invoice_details WHERE invoice_id = $invoice_id";
            $result = $this->dataManager->executeQuery($query);
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        }
    
        public function deleteInvoiceDetailsByInvoiceId($invoice_id) {
            $query = "DELETE FROM invoice_details WHERE invoice_id = $invoice_id";
            return $this->dataManager->executeQuery($query);
        }

     }
?>