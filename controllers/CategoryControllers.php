<?php
session_start();
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/Catogery.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Comment.php';


// ADD CATEGORY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'add-category') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
     
    $errors = [];
    $value = [
        'name' => $name,
        'title' => $title,
        'image' => $image,
    ];

    $category = new Category($name, $title, $image);

    if (empty($name)) {
        $errors['name'] = 'Bạn chưa nhập tên danh mục!';
    }
    if (empty($title)) {
        $errors['title'] = 'Bạn chưa thêm mô tả!';
    }
    if (empty($image)) {
        $errors['image'] = 'Bạn chưa thêm hình ảnh!';
    }

    if(count($errors) > 0) {
        $_SESSION['category_error'] = $errors;
        $_SESSION['category_value'] = $value;
        header('Location: ../views/admin/add-category.php');
        exit();
    } elseif(!empty($_POST['category_id'])) {
        echo "<script>
            alert('Không thể thêm danh mục này !');
            window.location.href = '../views/admin/add-category.php';
        </script>";
    } else {
        $category->createCategory();
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $_FILES['image']['name']);
        $_SESSION['create_category_success'] = true;
        header('Location: ../views/admin/add-category.php');
        exit();
    }
}

// SHOW VALUE CATEGORY EDIT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id']) && $_GET['submit'] == 'editValue') {
    $category = new Category();
    $category_id = $_GET['category_id'];
    $category_value = $category->getValue('category_id', $category_id);
    $_SESSION['value_category_edit'] = $category_value;
    header('Location: ../views/admin/edit-category.php');
    exit();
}

// EDIT CATEGORY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'edit-category') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $category_id = $_POST['category_id'];
     
    $errors = [];
    $value = [
        'category_id' => $category_id,
        'name' => $name,
        'title' => $title,
        'image' => $image,
    ];

    $category = new Category($name, $title, $image);

    if (empty($name)) {
        $errors['name'] = 'Bạn chưa nhập tên danh mục!';
    }
    if (empty($title)) {
        $errors['title'] = 'Bạn chưa thêm mô tả!';
    }
    if (empty($image)) {
        $errors['image'] = 'Bạn chưa thêm hình ảnh!';
    }

    if(count($errors) > 0) {
        $_SESSION['category_error'] = $errors;
        $_SESSION['category_value'] = $value;
        header('Location: ../views/admin/edit-category.php');
        exit();
    } elseif(empty($_POST['category_id'])) {
        echo "<script>
        alert('Danh mục cập nhật không tồn tại.');
        window.location.href = '../views/admin/edit-category.php';
    </script>";
    } else {
        $category->updateCatogery($category_id);
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $_FILES['image']['name']);
        $_SESSION['edit_category_success'] = true;
        header('Location: ../views/admin/edit-category.php');
        exit();
    }
}

// DELETE CATEGORY

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id']) && $_GET['submit'] == 'delete') {
    $category_id = $_GET['category_id'];
    $category = new Category();
    $product = new Product();
    $comment = new Comment();

    $productsByCategory = $product->getValues('category_id', $_GET['category_id']);


    if ($product->isProductInCategoryInInvoice($category_id)) {
        echo "<script>
            alert('không thể xóa: Danh mục có sản phẩm đang được bán.');
            window.location.href = '../views/admin/categories.php';
        </script>";
    } else {
        foreach($productsByCategory as $prod) {
            $comment->deleteCmtByProduct($prod['product_id']);
        }
        if($product->deleteProductByCategory($category_id) && $category->deleteCategoryById($category_id))  {
            echo "<script>
                alert('Xóa danh mục thành công.');
                window.location.href = '../views/admin/categories.php';
            </script>";
        } else {
            echo "<script>
                alert('Có lỗi xảy ra.');
                window.location.href = '../views/dmin/categories.php';
            </script>";
        }
    }
}
?>