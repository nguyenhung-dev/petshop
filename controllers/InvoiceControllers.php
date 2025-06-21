<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/InvoiceDetail.php';
require_once __DIR__ . '/../models/Product.php';

// ORDER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'order') {
    $fullname = $_POST['fullname'];
    $phonenumber = $_POST['phonenumber'];
    $adress = $_POST['adress'];
    $total_money = $_GET['total_money'];
    $payment_status = $_POST['payment_status'];
    $user_id = $_SESSION['user_id'];

    $invoice = new Invoice($fullname, $phonenumber, $adress, $payment_status, $user_id, $total_money);

    $errors = [];
    $value = [
        'fullname' => $fullname,
        'phonenumber' => $phonenumber,
        'adress' => $adress,
        'payment_status' => $payment_status,
    ];

    if (empty($fullname)) {
        $errors['fullname'] = 'Bạn chưa nhập họ tên!';
    }
    if (empty($phonenumber)) {
        $errors['phonenumber'] = 'Bạn chưa nhập số điện thoại!';
    } else if (!preg_match('/^[0-9]{10,11}$/', $phonenumber)) {
        $errors['phonenumber'] = 'Số điện thoại không đúng định dạng!';
    }
    if (empty($adress)) {
        $errors['adress'] = 'Bạn chưa nhập địa chỉ!';
    }
    if (empty($payment_status)) {
        $errors['payment_status'] = 'Bạn chưa chọn phương thức thanh toán!';
    }

    if (count($errors) > 0) {
        $_SESSION['invoice_error'] = $errors;
        $_SESSION['invoice_value'] = $value;
        header('Location: ../views/pages/order.php');
        exit();
    } else {
        $invoice->createInvoice();
        $invoiceId = $invoice->getInvoiceId();

        $cart = new Cart();
        $carts = $cart->getValues('user_id', $_SESSION['user_id']);

        foreach ($carts as $cartItem) {
            $product_id = $cartItem['product_id'];
            $quantity = $cartItem['product_count'];
            $price = $cartItem['price'];
            $total_money = $quantity * $price;

            $invoiceDetail = new InvoiceDetail($quantity, $total_money, $product_id, $invoiceId);
            $invoiceDetail->addInvoiceDetail();

            $product = new Product();
            $productValue = $product->getValue('product_id', $product_id);
            $newQuantity = $productValue['quantity'] - $quantity;
            $product->updateProductQuantity($product_id, $newQuantity);
        }

        $cart->deleteProductInCartByUser($_SESSION['user_id']);
        $_SESSION['create_invoice_success'] = true;
        header('Location: ../views/pages/order.php');
        exit();
    }
}

// DELETE INVOICE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['invoice_id']) && $_GET['submit'] == 'delete') {
    $invoice_id = $_GET['invoice_id'];
    $invoice = new Invoice();
    $invoiceDetail = new InvoiceDetail();

    if ($invoiceDetail->hasInvoiceDetails($invoice_id)) {
        $invoiceDetail->deleteInvoiceDetailsByInvoiceId($invoice_id);
    }
    $invoice->deleteInvoiceById($invoice_id);
    header('Location: ../views/admin/order.php');
}

if (isset($_GET['action'])) {
    $invoice = new Invoice();

    if ($_GET['action'] == 'confirmOrder' && isset($_GET['invoice_id'])) {
        $invoice_id = intval($_GET['invoice_id']);
        $invoice->confirmOrder($invoice_id);
        header('Location: ../views/admin/order.php');
    }

    if ($_GET['action'] == 'cancelOrder' && isset($_GET['invoice_id']) && isset($_GET['reason'])) {
        $invoice_id = intval($_GET['invoice_id']);
        $reason = $_GET['reason'];
        $invoice->cancelOrder($invoice_id, $reason);
        header('Location: ../views/admin/order.php');
    }
}


?>