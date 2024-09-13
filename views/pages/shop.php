<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// echo $_SESSION['role'];
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Catogery.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../path.php';
echo "<script>var baseUrl = '$base';</script>";

$category = new Category();
$product = new Product();

$categories = $category->getAllCatogery();
$products = $product->getAllProduct();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/shop.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-shop.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Cửa hàng</h2>
            </div>
        </div>
    </section>
    <section class="main-shop">
        <div class="container">
            <div class="left">
                <?php if (isset($_GET['category_id']) && !empty($_GET['category_id'])) { ?>
                    <?php $productByCategory = $product->getValues('category_id', $_GET['category_id']); ?>
                    <?php $categoryValue = $category->getValue('category_id', $_GET['category_id']); ?>
                    <h3><?php echo $categoryValue['name']; ?></h3>
                    <div class="list-product">
                        <?php if (count($productByCategory) == 0) { ?>
                            <p style="text-align: center;">Không có sản phẩm hiển thị</p>
                        <?php } else { ?>
                            <?php foreach ($productByCategory as $product) { ?>
                                <div class="product">
                                    <div class="img">
                                        <img src="../../assets/images/<?php echo $product['image']; ?>" alt="">
                                        <div class="overlay"></div>
                                        <div class="add-cart">
                                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                                                <a href="#" onclick="messageError();"><i class="fa-solid fa-cart-plus"></i></a>
                                            <?php } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') { ?>
                                                    <a
                                                        href="../../controllers/CartControllers.php?product_id=<?php echo $product['product_id']; ?>"><i
                                                            class="fa-solid fa-cart-plus"></i></a>
                                            <?php } else { ?>
                                                    <a href="#" onclick="goToCart(event);"><i class="fa-solid fa-cart-plus"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="name">
                                        <a
                                            href="detail.php?product_id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a>
                                    </div>
                                    <div class="price">
                                        <span><?php echo $product['price']; ?></span><span>đ</span>
                                    </div>
                                    <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <span>(<?php echo random_int(10, 99) ?>)</span>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <h3>Tất cả sản phẩm</h3>
                    <div class="list-product">
                        <?php if (count($products) == 0) { ?>
                            <p style="text-align: center;">Không có sản phẩm hiển thị</p>
                        <?php } else { ?>
                            <?php foreach ($products as $product) { ?>
                                <div class="product">
                                    <div class="img">
                                        <img src="../../assets/images/<?php echo $product['image']; ?>" alt="">
                                        <div class="overlay"></div>
                                        <div class="add-cart">
                                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                                                <a href="#" onclick="messageError();"><i class="fa-solid fa-cart-plus"></i></a>
                                            <?php } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') { ?>
                                                    <a
                                                        href="../../controllers/CartControllers.php?product_id=<?php echo $product['product_id']; ?>"><i
                                                            class="fa-solid fa-cart-plus"></i></a>
                                            <?php } else { ?>
                                                    <a href="#" onclick="goToCart(event);"><i class="fa-solid fa-cart-plus"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="name">
                                        <a
                                            href="detail.php?product_id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a>
                                    </div>
                                    <div class="price">
                                        <span><?php echo number_format($product['price'], 0, ',', '.'); ?></span><span>đ</span>
                                    </div>
                                    <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <span>(<?php echo random_int(10, 99) ?>)</span>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="right">
                <div class="item">
                    <h4>Danh mục sản phẩm</h4>
                    <ul>
                        <li>
                            <i class="fa-solid fa-paw"></i>
                            <a href="shop.php?category_id=<?php echo ""; ?>">Tất cả sản phẩm</a>
                        </li>
                        <?php foreach ($categories as $category) { ?>
                            <li>
                                <i class="fa-solid fa-paw"></i>
                                <a
                                    href="shop.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="item">
                    <h4>Lọc theo giá</h4>
                    <div class="bar"></div>
                    <div class="filter">
                        <a href="">Lọc</a>
                        <p>Giá: 100đ - 2000đ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>

    <script>
        function messageError() {
            alert('Lỗi: không thể thêm sản phẩm vào giỏ hàng với quyền QUẢN TRỊ VIÊN.');
        }

        function goToCart(event) {
            event.preventDefault();
            alert('Bạn chưa đăng nhập');
            window.location.href = baseUrl + 'login.php';
        }
    </script>
</body>

</html>