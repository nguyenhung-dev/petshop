<?php
session_start(); 
if(isset($_SESSION['login_error']) && isset($_SESSION['login_info'])) {
    $errorMessage = $_SESSION['login_error'];
    $info = $_SESSION['login_info'];
    unset($_SESSION['login_info']);
    unset($_SESSION['login_error']);
}

if(isset($_SESSION['register_success'])) {
    echo "<script>
        alert('Đăng ký tài khoản thành công.');
    </script>";
    unset($_SESSION['register_success']);
    unset($_SESSION['register_info']);
    unset($_SESSION['register_error']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/login.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-login.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Đăng nhập tài khoản</h2>
            </div>
        </div>
    </section>
    <!-- FORM -->
    <section class="login">
        <div class="container">
            <form action="../../controllers/UserControllers.php" method="post">
                <h3>
                    <p>(*) Mục không được bỏ trống.</p>
                </h3>
                <div class="input">
                    <label>Tên đăng nhập <span>*</span></label>
                    <input type="text" name="username" value="<?php echo (isset($info['username'])) ? $info['username'] : ""; ?>">
                    <p class="messageError"><?php 
                echo (isset($errorMessage['username'])) ? $errorMessage['username'] : "";
                ?></p>
                    <label>Mật khẩu <span>*</span></label>
                    <input type="password" name="password" >
                    <p class="messageError"><?php 
                echo (isset($errorMessage['password'])) ? $errorMessage['password'] : "";
                ?></p>
                </div>
                <div class="actions">
                    <button type="submit" name="submit" value="login">Đăng nhập</button>
                    <a href="forgot-pass.php">Quên mật khẩu?</a>
                </div>
            </form>
            <div class="img-login">
                <img src="../../assets/images/img-login.jpg" alt="">
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

   <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>

</html>