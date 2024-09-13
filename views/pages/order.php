<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Invoice.php';
require_once __DIR__ . '/../../models/Cart.php';

$cart = new Cart();
$carts = $cart->getValues('user_id', $_SESSION['user_id']);
$totalMoney = 0;
foreach($carts as $cart) { 
    $totalMoney += $cart['product_count'] * $cart['price'];
}

if (isset($_SESSION['invoice_error']) && isset($_SESSION['invoice_value'])) {
    $errors = $_SESSION['invoice_error'];
    $value = $_SESSION['invoice_value'];
    unset($_SESSION['invoice_error']);
    unset($_SESSION['invoice_value']);
}

if(isset($_SESSION['create_invoice_success'])) {
    $messageSuccess = "<i class='fa-solid fa-check'></i>
    <span>Đặt hàng thành công</span>";
    unset($_SESSION['create_invoice_success']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/order.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-order.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Đặt hàng</h2>
            </div>
        </div>
    </section>
    <!-- ORDER -->
    <section class="order">
        <div class="container">
            <div class="left">
                <h3>Đơn hàng</h3>
                <div class="list-product">
                    <?php foreach($carts as $cart) { ?>
                        <div class="item">
                            <div class="img">
                                <img src="../../assets/images/<?php echo $cart['image']; ?>" alt="">
                            </div>
                            <div class="name">
                                <p><?php echo $cart['name']; ?></p>
                                <p><span>x</span><?php echo $cart['product_count']; ?></p>
                            </div>
                            <div class="price">
                            <p><?php echo number_format($cart['price'], 0, ',', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="total-money">
                    <p>Tổng tiền:</p>
                    <p><?php echo number_format($totalMoney, 0, ',', '.'); ?> <span>đ</span></p>
                </div>
            </div>
            <div class="right">
                <h3>Thông tin nhận hàng</h3>
                <form action="../../controllers/InvoiceControllers.php?total_money=<?php echo $totalMoney; ?>" method="post">
                    <label>Họ và tên</label>
                    <input type="text" name="fullname" value="<?php echo (isset($value['fullname'])) ? $value['fullname'] : "";?>">
                    <p class="messageError"><?php echo (isset($errors['fullname'])) ? $errors['fullname'] : ""; ?></p>
                    <label>Số điện thoại</label>
                    <input type="text" name="phonenumber" value="<?php echo (isset($value['phonenumber'])) ? $value['phonenumber'] : "";?>">
                    <p class="messageError"><?php echo (isset($errors['phonenumber'])) ? $errors['phonenumber'] : ""; ?></p>
                    <label>Địa chỉ</label>
                    <input type="text" name="adress" value="<?php echo (isset($value['adress'])) ? $value['adress'] : "";?>">
                    <p class="messageError"><?php echo (isset($errors['adress'])) ? $errors['adress'] : ""; ?></p>
                    <label>Phương thức thanh toán</label>
                    <input type="radio" name="payment_status" value="online">
                    <span>Chuyển khoản ngân hàng</span>
                    <br/>
                    <input type="radio" name="payment_status" value="offline">
                    <span>Thanh toán khi nhận hàng</span>
                    <p class="messageError"><?php echo (isset($errors['payment_status'])) ? $errors['payment_status'] : ""; ?></p>
                    
                    <div class="messageSuccess">
                        <?php  
                            if(isset($messageSuccess)) {
                                echo $messageSuccess;
                            }
                        ?>
                    </div>
                    <div class="order-btn">
                        <button type="submit" name="submit" value="order"><span>Đặt hàng</span></button>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>
</html>
