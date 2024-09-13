<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Catogery.php';
require_once __DIR__ . '/../../models/Product.php';

$category = new Category();
$categories = $category->getAllCatogery();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
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

    <style>
        .add-category h3 {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php require_once __DIR__ . '/navbar.php'; ?>
        <div class="main">
            <h3>Danh sách danh mục</h3>
            <div class="button">
                <a href="add-category.php">Thêm mới</a>
            </div>
            <div class="list-categories"  style="margin-top: 15px;">
                <table>
                    <tr>
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Ngày tạo</th>
                        <th style="
                            width: 15%;
                        ">Số lượng sản phẩm</th>
                        <th style="
                            width: 15%;text-align: center;
                        ">Hành động</th>
                    </tr>
                    <?php if (empty($categories)) { ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Danh mục trống.</td>
                        </tr>
                    <?php } else { ?>
                    <?php foreach ($categories as $category) { ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $category['category_id']; ?></td>
                            <td><?php echo $category['name']; ?></td>
                            <td><?php echo $category['created_day']; ?></td>
                            <td><?php 
                                $productQuantity = $product->getValues('category_id', $category['category_id']);
                                $count = 0;
                                foreach($productQuantity as $quantity) {
                                    $count += $quantity['quantity'];    
                                }
                                echo $count;
                            ?></td>
                            <td class="actions">
                                <div class="btn">
                                    <a
                                        href="../../controllers/CategoryControllers.php?submit=editValue&category_id=<?php echo $category['category_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div class="btn">
                                    <a href="#" onclick="confirmDelete('<?php echo $category['category_id']; ?>', '<?php echo $category['name']; ?>')"><i class="fa-solid fa-trash"></i></a>
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
        var result = confirm("Xác nhận xóa danh mục:  " + name + "\nTất cả sản phẩm trong danh mục sẽ bị xóa");
        if (result) {
            window.location.href = "../../controllers/CategoryControllers.php?submit=delete&category_id=" + id;
        }
    }
    </script>
</body>

</html>