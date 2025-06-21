<?php
session_start();
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Comment.php';

$product = new Product(); // Tạo đối tượng Product trước

// ADD PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'add-product') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $created_day = date('Y-m-d');

    $errors = [];
    $value = [
        'name' => $name,
        'description' => $description,
        'quantity' => $quantity,
        'image' => $image,
        'price' => $price,
        'category_id' => $category_id,
    ];

    if (empty($name)) {
        $errors['name'] = 'Bạn chưa nhập tên sản phẩm!';
    }
    if (strlen($name) <= 5) {
        $errors['length'] = "Không dưới 5 kí tự";
    }
    if (empty($description)) {
        $errors['description'] = 'Bạn chưa điền mô tả sản phẩm!';
    }
    if (empty($quantity)) {
        $errors['quantity'] = 'Bạn chưa nhập số lượng sản phẩm!';
    } elseif ($quantity <= 0) {
        $errors['quantity'] = 'Số lượng không hợp lệ!';
    }
    if (empty($price)) {
        $errors['price'] = 'Bạn chưa nhập giá sản phẩm!';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = 'Giá không hợp lệ!';
    }
    if (empty($category_id)) {
        $errors['category_id'] = 'Bạn chưa chọn danh mục!';
    }
    if (empty($image)) {
        $errors['image'] = 'Bạn chưa thêm hình ảnh sản phẩm!';
    }

    if (count($errors) > 0) {
        $_SESSION['product_error'] = $errors;
        $_SESSION['product_value'] = $value;
        header('Location: ../views/admin/add-product.php');
        exit();
    } else {
        $product->createProduct($name, $description, $price, $quantity, $category_id, $image);
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $_FILES['image']['name']);
        $_SESSION['create_product_success'] = true;
        header('Location: ../views/admin/add-product.php');
        exit();
    }
}

// SHOW VALUE PRODUCT EDIT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id']) && $_GET['submit'] == 'edit') {
    $product_id = $_GET['product_id'];
    $product_value = $product->getProductById($product_id);
    $_SESSION['value_product_edit'] = $product_value;
    header('Location: ../views/admin/edit-product.php');
    exit();
}

// EDIT PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'edit-product') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $product_id = $_POST['product_id'];

    $errors = [];
    $value = [
        'name' => $name,
        'description' => $description,
        'quantity' => $quantity,
        'image' => $image,
        'price' => $price,
        'category_id' => $category_id,
    ];

    if (empty($name)) {
        $errors['name'] = 'Bạn chưa nhập tên sản phẩm!';
    }
    if (empty($description)) {
        $errors['description'] = 'Bạn chưa điền mô tả sản phẩm!';
    }
    if (empty($quantity)) {
        $errors['quantity'] = 'Bạn chưa nhập số lượng sản phẩm!';
    } elseif ($quantity <= 0) {
        $errors['quantity'] = 'Số lượng không hợp lệ!';
    }
    if (empty($price)) {
        $errors['price'] = 'Bạn chưa nhập giá sản phẩm!';
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = 'Giá không hợp lệ!';
    }
    if (empty($category_id)) {
        $errors['category_id'] = 'Bạn chưa chọn danh mục!';
    }

    if (count($errors) > 0) {
        $_SESSION['product_error'] = $errors;
        $_SESSION['product_value'] = $value;
        header('Location: ../views/admin/edit-product.php');
        exit();
    } else {
        $product->updateProduct($product_id, $name, $description, $price, $quantity, $category_id, $image);
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $_FILES['image']['name']);
        }
        $_SESSION['edit_product_success'] = true;
        header('Location: ../views/admin/edit-product.php');
        exit();
    }
}

// DELETE PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id']) && $_GET['submit'] == 'delete') {
    $product_id = $_GET['product_id'];
    $comment = new Comment();

    if ($product->isProductInInvoice($product_id)) {
        echo "<script>
            alert('Không thể xóa: sản phẩm đang được chọn.');
            window.location.href = '../views/admin/products.php';
        </script>";
    } else {
        $comment->deleteCmtByProduct($product_id);
        if ($product->deleteProductById($product_id)) {
            echo "<script>
                alert('Xóa sản phẩm thành công.');
                window.location.href = '../views/admin/products.php';
            </script>";
        } else {
            echo "<script>
                alert('Có lỗi xảy ra.');
                window.location.href = '../views/admin/products.php';
            </script>";
        }
    }
}
?>