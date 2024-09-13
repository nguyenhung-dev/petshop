<?php
session_start(); 
if (isset($_SESSION['register_error']) && isset($_SESSION['register_info'])) {
    $errorMessage = $_SESSION['register_error'];
    $info = $_SESSION['register_info'];
    unset($_SESSION['register_info']);
    unset($_SESSION['register_error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/register.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <!-- FORM -->
    <section class="register">
        <div class="container">
            <form action="../../controllers/UserControllers.php" method="post"  enctype="multipart/form-data">
                <h3>Đăng ký tài khoản
                    <p>(*) Mục không được bỏ trống.</p>
                </h3>
                <div class="input">
                    <div>
                        <label>Họ và tên đệm <span>*</span></label>
                        <input type="text" name="fullname"
                            value="<?php echo (isset($info['fullname'])) ? $info['fullname'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['fullname'])) ? $errorMessage['fullname'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Tên đăng nhập <span>*</span></label>
                        <input type="text" name="username"
                            value="<?php echo (isset($info['username'])) ? $info['username'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['username'])) ? $errorMessage['username'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Email <span>*</span></label>
                        <input type="email" name="email"
                            value="<?php echo (isset($info['email'])) ? $info['email'] : ""; ?>">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['email'])) ? $errorMessage['email'] : "";
                        ?></p>
                    </div>
                    <div>
                        <label>Số điện thoại <span>*</span></label>
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
                        <label>Mật khẩu <span>*</span></label>
                        <input type="password" name="password">
                        <p class="messageError"><?php
                        echo (isset($errorMessage['password'])) ? $errorMessage['password'] : "";
                        ?></p>
                    </div>
                    <div class="gender">
                        <label>Giới tính </label>
                        <input type="radio" name="gender" value="male"><span>Nam</span>
                        <input type="radio" name="gender" value="female"><span>Nữ</span>
                        <p class="error"></p>
                    </div>
                    <div class="avt">
                        <label>Ảnh đại diện </label>
                        <input type="file" name="avatar">
                        <p class="error"></p>
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" name="submit" value="register">Đăng ký</button>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>

</html>