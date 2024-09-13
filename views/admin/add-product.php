<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Catogery.php';
require_once __DIR__ . '/../../models/Product.php';

$category = new Category();
$categories = $category->getAllCatogery();

$product = new Product();
$products = $product->getAllProduct();
$allProducts = $products;

if (isset($_SESSION['product_error']) && isset($_SESSION['product_value'])) {
    $errors = $_SESSION['product_error'];
    $value = $_SESSION['product_value'];
    unset($_SESSION['product_error']);
    unset($_SESSION['product_value']);
}

if (isset($_SESSION['create_product_success'])) {
    $messageSuccess = '<i class="fa-solid fa-check check"></i> Thêm sản phẩm mới thành công.';
    unset($_SESSION['create_product_success']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới sản phẩm</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">
    <!-- LINK FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
        integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/base/reset.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/management pages/navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/management pages/table.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="wrapper">
        <?php require_once __DIR__ . '/navbar.php';  ?>
        <div class="main">
        <div class="add-category">
                <h3>Thêm sản phẩm</h3>
                <p class="mess-success"> <?php echo (isset( $messageSuccess)) ?  $messageSuccess : '' ;?></p>
                <form action="../../controllers/ProductControllers.php" method="post" enctype="multipart/form-data">
                    <div class="error"></div>
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" value="<?php echo (isset($value['name'])) ? $value['name'] : "";
                    echo (isset($product_value['name'])) ? $product_value['name'] : ""; ?>">
                    <div class="error"><?php echo (isset($errors['name'])) ? $errors['name'] : ""; ?></div>
                    <label>Mô tả</label>
                    <textarea name="description" cols="30" rows="5"><?php echo (isset($value['description'])) ? $value['description'] : "";
                    echo (isset($product_value['description'])) ? $product_value['description'] : ""; ?></textarea>
                    <div class="error"><?php echo (isset($errors['description'])) ? $errors['description'] : ""; ?>
                    </div>
                    <label>Số lượng</label>
                    <input type="number" name="quantity" value="<?php echo (isset($value['quantity'])) ? $value['quantity'] : "";
                    echo (isset($product_value['quantity'])) ? $product_value['quantity'] : ""; ?>">
                    <div class="error"><?php echo (isset($errors['quantity'])) ? $errors['quantity'] : ""; ?></div>
                    <label>Giá</label>
                    <input type="text" name="price" value="<?php echo (isset($value['price'])) ? $value['price'] : "";
                    echo (isset($product_value['price'])) ? $product_value['price'] : ""; ?>">
                    <div class="error"><?php echo (isset($errors['price'])) ? $errors['price'] : ""; ?></div>
                    <label>Thuộc danh mục</label>
                    <select name="category_id">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['category_id'] ?>"><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="error"><?php echo (isset($errors['category_id'])) ? $errors['category_id'] : ""; ?>
                    </div>
                    <label>Hình ảnh</label>
                    <input type="file" name="image">
                    <div class="error"><?php echo (isset($errors['image'])) ? $errors['image'] : ""; ?></div>
                    <div class="button">
                        <button type="submit" name="submit" value="add-product">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
