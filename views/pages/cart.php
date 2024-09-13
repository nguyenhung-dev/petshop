<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Cart.php';

$cart = new Cart();
$carts = $cart->getValues('user_id', $_SESSION['user_id']);
$totalMoney = 0;
foreach($carts as $cart) { 
    $totalMoney += $cart['product_count'] * $cart['price'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/cart.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-cart.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Giỏ hàng</h2>
            </div>
        </div>
    </section>
    <!-- CART -->
    <div class="main-cart">
        <div class="container">
            <h4>Giỏ hàng của bạn</h4>
            <div class="list-product">
            <?php if(count($carts) == 0) { ?>
                    <p>Không có sản phẩm nào trong giỏ hàng.</p>
            <?php } else { ?>
                <div class="item">
                    <div class="image">
                        Ảnh sản phẩm
                    </div>
                    <div class="name">
                        Tên sản phẩm
                    </div>
                    <div class="price">
                        Đơn giá
                    </div>
                    <div class="quantity">
                        Số lượng
                    </div>
                    <div class="into-money">
                        Thành tiền
                    </div>
                    <div class="delete">
                        Xóa
                    </div>
                </div>
                <?php foreach($carts as $cart) { ?>
                <div class="item product">
                    <div class="image">
                        <img src="../../assets/images/<?php echo $cart['image']; ?>" alt="">
                    </div>
                    <div class="name">
                        <p><?php echo $cart['name']; ?></p>
                    </div>
                    <div class="price">
                        <p><?php echo number_format($cart['price'], 0, ',', '.') . 'đ'; ?></p>
                    </div>
                    <div class="quantity">
                        <p><?php echo $cart['product_count']; ?></p>
                    </div>
                    <div class="into-money">
                        <p><?php echo number_format($cart['product_count'] * $cart['price'], 0, ',', '.') . 'đ'; ?></p>
                    </div>
                    <div class="delete">
                        <a href="../../controllers/CartControllers.php?delete_product=delete_product&product_id=<?php echo $cart['product_id']; ?>">
                        <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            </div>
            <div class="cart-bottom">
                <div class="total-money">
                    <p>Tổng tiền:</p>
                    <p><?php echo number_format($totalMoney, 0, ',', '.'); ?> <span>đ</span></p>
                </div>
                <div class="cart-btn">
                    <a href="shop.php">Tiếp tục mua hàng</a>
                    <?php if(count($carts) == 0) { ?>
                        <a href="#" onclick="messageError();">Tiếp tục thanh toán</a>
                    <?php } else {?>
                        <a href="order.php">Tiếp tục thanh toán</a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
    <script>
        function messageError() {
            alert('Giỏ hàng trống !');
        }
    </script>
</body>

</html>
