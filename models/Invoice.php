<?php
require_once __DIR__ . '/../config/connectDB.php';

class Invoice
{
    private $fullname;
    private $phonenumber;
    private $created_day;
    private $address;
    private $payment_status;
    private $user_id;
    private $total_money;
    private $dataManager;

    public function __construct(
        $fullname = 'Uknown',
        $phonenumber = '',
        $address = '',
        $payment_status = '',
        $user_id = null,
        $total_money = 0,
        $created_day = null,
        $dataManager = null
    ) {
        $this->fullname = $fullname;
        $this->phonenumber = $phonenumber;
        $this->created_day = $created_day ?: date('Y-m-d');
        $this->address = $address;
        $this->user_id = $user_id;
        $this->total_money = $total_money;
        $this->payment_status = $payment_status;
        $this->dataManager = databaseManager::getInstance();
    }

    public function getFullName()
    {
        return $this->fullname;
    }

    public function setFullName($fullname)
    {
        $this->fullname = $fullname;
    }
    public function getphonenumber()
    {
        return $this->phonenumber;
    }

    public function setphonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }
    public function getCreatedDay()
    {
        return $this->created_day;
    }

    public function setCreatedDay($created_day)
    {
        $this->created_day = $created_day;
    }
    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getPaymentStatus()
    {
        return $this->payment_status;
    }

    public function setPaymentStatus($payment_status)
    {
        $this->payment_status = $payment_status;
    }

    public function createInvoice()
    {
        $query = "INSERT INTO invoices 
            (fullname, phonenumber, address, payment_status, created_day, total_money, user_id) VALUES 
            ('$this->fullname', '$this->phonenumber', '$this->address', '$this->payment_status', '$this->created_day', '$this->total_money', '$this->user_id')";
        return $this->dataManager->executeQuery($query);
    }
    public function getAllInvoice()
    {
        $query = "SELECT * FROM invoices";
        $result = $this->dataManager->executeQuery($query);
        $invoices = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $invoices[] = $row;
            }
        }
        return $invoices;
    }
    public function getValue($whereColumn, $value)
    {
        $query = "SELECT * FROM invoices WHERE $whereColumn = '$value'";
        $result = $this->dataManager->executeQuery($query);
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    }
    public function getValues($whereColumn, $value)
    {
        $query = "SELECT * FROM invoices WHERE $whereColumn = '$value'";
        $result = $this->dataManager->executeQuery($query);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function isPaid($invoice_id)
    {
        $query = "SELECT payment_status FROM invoices WHERE invoice_id = '$invoice_id'";
        $result = $this->dataManager->executeQuery($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['payment_status'] == 'online';
        }
        return false;
    }

    public function deleteInvoiceById($invoice_id)
    {
        // if ($this->isPaid($invoice_id)) {
        //     return false;
        // }
        $query = "DELETE FROM invoices WHERE invoice_id = '$invoice_id'";
        $result = $this->dataManager->executeQuery($query);
        return $result;
    }
    public function deleteAllInvoiceByUser($user_id)
    {
        $query = "DELETE FROM invoices WHERE user_id = '$user_id'";
        $result = $this->dataManager->executeQuery($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getInvoiceId()
    {
        $query = "SELECT LAST_INSERT_ID() AS invoice_id";
        $result = $this->dataManager->executeQuery($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['invoice_id'];
        }
        return null;
    }

    public function getInvoiceDetails($invoice_id)
    {
        $query = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
        $result = $this->dataManager->executeQuery($query);
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    }

    public function getProcessingOrders()
    {
        $sql = "SELECT * FROM invoices WHERE order_status = 'pending'";
        $result = $this->dataManager->executeQuery($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function confirmOrder($invoice_id)
    {
        $sql = "UPDATE invoices SET order_status = 'confirmed' WHERE invoice_id = $invoice_id";
        return $this->dataManager->executeQuery($sql);
    }

    public function cancelOrder($invoice_id, $cancel_reason)
    {
        $sql = "UPDATE invoices SET order_status = 'cancelled', cancel_reason = '$cancel_reason' WHERE invoice_id = $invoice_id";
        return $this->dataManager->executeQuery($sql);
    }

    public function getConfirmedOrders()
    {
        $sql = "SELECT * FROM invoices WHERE order_status = 'confirmed'";
        $result = $this->dataManager->executeQuery($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }
}
?>