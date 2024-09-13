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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
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
        <?php require_once __DIR__ . '/navbar.php'; ?>
        <div class="main">
            <h3>Danh sách sản phẩm</h3>
            <div class="button">
                <a href="add-product.php">Thêm mới</a>
            </div>
            <div class="list-categories" style="margin-top: 15px;">
                <table>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Ngày tạo</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Danh mục</th>
                        <th style="
                            text-align: center;
                        ">Hành động</th>
                    </tr>
                    <?php if (empty($allProducts)) { ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Không có sản phẩm nào được thêm.
                        </td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($allProducts as $product) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $product['product_id']; ?></td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['created_day']; ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo $product['price'] . ' VND'; ?></td>
                                <td><?php
                                foreach ($categories as $category) {
                                    if ($category['category_id'] == $product['category_id']) {
                                        echo $category['name'];
                                        break;
                                    }
                                }
                                ?></td>
                                <td class="actions">
                                <div class="btn">
                                        <a
                                            href="comment.php?product_id=<?php echo $product['product_id']; ?>"><i class="fa-solid fa-comment"></i></a>
                                    </div>
                                    <div class="btn">
                                        <a
                                            href="../../controllers/ProductControllers.php?submit=edit&product_id=<?php echo $product['product_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </div>
                                    <div class="btn">
                                        <a href="#"
                                            onclick="confirmDelete('<?php echo $product['product_id']; ?>', '<?php echo $product['name']; ?>')"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(id, name) {
            var result = confirm("Xác nhận xóa sản phẩm:  " + name);
            if (result) {
                window.location.href = "../../controllers/ProductControllers.php?submit=delete&product_id=" + id;
            }
        }
    </script>
</body>

</html>