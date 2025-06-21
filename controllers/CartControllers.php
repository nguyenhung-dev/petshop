?>
<?php
session_start();
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

// ADD PRODUCT IN CART
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];
    $product = new Product();

    $productValue = $product->getProductById($product_id);
    $productName = $productValue['name'];
    $productImage = $productValue['image'];
    $productPrice = $productValue['price'];

    $cart = new Cart();

    if ($cart->productExistsInCart($user_id, $product_id)) {
        $cart->updateProductCount($user_id, $product_id);
        echo "<script>
            alert('Sản phẩm đã tồn tại trong giỏ hàng. Số lượng đã được cập nhật.');
            window.location.href = '../views/pages/shop.php';
        </script>";
    } else {
        $cart->addProductInCart($productImage, $productName, $productPrice, $user_id, $product_id);
        echo "<script>
            alert('Đã thêm: $productName vào giỏ hàng.');
            window.location.href = '../views/pages/shop.php';
        </script>";
    }
}

// DELETE PRODUCT IN CART
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['delete_product'] == 'delete_product' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];
    $cart = new Cart();

    if ($cart->deleteProductInCart($user_id, $product_id)) {
        header('Location: ../views/pages/cart.php');
    } else {
        echo "<script>
            alert('Có lỗi xảy ra.');
            window.location.href = '../views/pages/cart.php';
        </script>";
    }
}
?>