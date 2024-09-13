<?php
session_start(); 
if (isset($_SESSION['register_error']) && isset($_SESSION['register_info'])) {
    $errorMessage = $_SESSION['register_error'];
    $info = $_SESSION['register_info'];
    unset($_SESSION['register_info']);
    unset($_SESSION['register_error']);
}
if (isset($_SESSION['register_success'])) {
    $messageSuccess = '<i class="fa-solid fa-check check"></i> Tạo tài khoản thành công.';
    unset($_SESSION['register_success']);
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
    <style>
        .messageError {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php require_once __DIR__ . '/navbar.php';  ?>
        <div class="main">
        <div class="add-user">
                <h3>Tạo tài khoản</h3>
                <span style="color: red; font-size: 16px;">(*) Mục không được bỏ trống</span>
                <p class="mess-success"> <?php echo (isset( $messageSuccess)) ?  $messageSuccess : '' ;?></p>
                <form action="../../controllers/UserControllers.php" method="post"  enctype="multipart/form-data" class="register">
                <div class="input">
                    <div>
                        <label>Họ và tên đệm <span style="color: red; font-size: 16px;">*</span></label>
                        <input type="text" name="fullname"
                            value="<?php echo (isset($info['fullname'])) ? $info['fullname'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['fullname'])) ? $errorMessage['fullname'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Tên đăng nhập <span style="color: red; font-size: 16px;">*</span></label>
                        <input type="text" name="username"
                            value="<?php echo (isset($info['username'])) ? $info['username'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['username'])) ? $errorMessage['username'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Email <span style="color: red; font-size: 16px;">*</span></label>
                        <input type="email" name="email"
                            value="<?php echo (isset($info['email'])) ? $info['email'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['email'])) ? $errorMessage['email'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Số điện thoại <span style="color: red; font-size: 16px;">*</span></label>
                        <input type="text" name="phonenumber"
                            value="<?php echo (isset($info['phonenumber'])) ? $info['phonenumber'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['phonenumber'])) ? $errorMessage['phonenumber'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Ngày sinh </label>
                        <input type="date" name="birthday"  value="<?php echo (isset($info['birthday'])) ? $info['birthday'] : ""; ?>">
                        <p class="error"></p>
                    </div>
                    <div>
                        <label>Mật khẩu <span style="color: red; font-size: 16px; font-weight: 600">*</span></label>
                        <input type="password" name="password">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['password'])) ? $errorMessage['password'] : "";
                        ?></p>
                    </div>
                    <div class="gender">
                        <label>Giới tính </label>
                        <input type="radio" name="gender" value="male"><span>Nam</span><br/>
                        <input type="radio" name="gender" value="female"><span>Nữ</span>
                        <p class="error"></p>
                    </div>
                    <div class="avt">
                        <label>Ảnh đại diện </label>
                        <input type="file" name="avatar">
                        <p class="error"></p>
                    </div>
                    <div class="role">
                        <label>Vai trò <span style="color: red; font-size: 16px; font-weight: 600">*</span></label>
                        <input type="radio" name="role" value="admin"><span>Quản trị viên</span><br/>
                        <input type="radio" name="role" value="user"><span>Người dùng</span>
                        <p class="messageError"> <p class="messageError"><?php
                        echo (isset($errorMessage['role'])) ? $errorMessage['role'] : "";
                        ?></p></p>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" name="submit" value="add-user">Đăng ký</button>
                </div>
            </form>
            </div>
        </div>
    </div>

</body>
</html>