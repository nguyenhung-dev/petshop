<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Catogery.php';
require_once __DIR__ . '/../../models/Product.php';

$category = new Category();
$categories = $category->getAllCategories();

if (isset($_SESSION['category_error']) && isset($_SESSION['category_value'])) {
    $errors = $_SESSION['category_error'];
    $value = $_SESSION['category_value'];
    unset($_SESSION['category_error']);
    unset($_SESSION['category_value']);
}

if (isset($_SESSION['edit_category_success'])) {
    $messageSuccess = '<i class="fa-solid fa-check check"></i> Cập nhật danh mục thành công.';
    unset($_SESSION['edit_category_success']);
}

if (isset($_SESSION['value_category_edit'])) {
    $category_value = $_SESSION['value_category_edit'];
    unset($_SESSION['value_category_edit']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chỉnh sửa danh mục</title>
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
      <h3>Chỉnh sửa danh mục</h3>
      <p class="mess-success"> <?php echo (isset($messageSuccess)) ? $messageSuccess : ''; ?></p>
      <div class="add-category">
        <form action="../../controllers/CategoryControllers.php" method="post" enctype="multipart/form-data">
          <label>Mã danh mục (tự động)</label>
          <input type="text" name="category_id" value="<?php echo (isset($value['category_id'])) ? $value['category_id'] : "";
                    echo (isset($category_value['category_id'])) ? $category_value['category_id'] : ""; ?>" readonly>
          <div class="error"></div>
          <label>Tên danh mục</label>
          <input type="text" name="name" value="<?php echo (isset($value['name'])) ? $value['name'] : "";
                    echo (isset($category_value['name'])) ? $category_value['name'] : ""; ?>">
          <div class="error"><?php echo (isset($errors['name'])) ? $errors['name'] : ""; ?></div>
          <label>Mô tả</label>
          <textarea name="title" cols="30" rows="5"><?php echo (isset($value['title'])) ? $value['title'] : "";
                    echo (isset($category_value['title'])) ? $category_value['title'] : ""; ?></textarea>
          <div class="error"><?php echo (isset($errors['title'])) ? $errors['title'] : ""; ?></div>
          <label>Hình ảnh</label>
          <input type="file" name="image">
          <div class="error"><?php echo (isset($errors['image'])) ? $errors['image'] : ""; ?></div>
          <div class="button">
            <button type="submit" name="submit" value="edit-category">Chỉnh sửa</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>