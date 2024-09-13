<?php
session_start();
if (isset($_SESSION['forgot_pass_error'])) {
    $errorMessage = $_SESSION['forgot_pass_error'];
    $info = $_SESSION['forgot_pass_info'];
    unset($_SESSION['forgot_pass_info']);
    unset($_SESSION['forgot_pass_error']);
}

if (isset($_SESSION['forgot_pass_success'])) {
    $successMessage = $_SESSION['forgot_pass_success'];
    echo "<script>
        if (confirm('Mật khẩu của bạn là: {$successMessage}  .Bạn có muốn đổi mật khẩu không?')) {
            window.location.href = 'change-pass.php';
        }
    </script>";
    unset($_SESSION['forgot_pass_success']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/forgot-pass.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-forgot-pass.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Quên mật khẩu</h2>
            </div>
        </div>
    </section>
    <!-- FORM -->
    <section class="forgot-pass">
        <div class="container">
            <form action="../../controllers/UserControllers.php" method="post">
                <h3>
                    <p>(*) Mục không được bỏ trống.</p>
                </h3>
                <div class="input">
                    <label>Tên đăng nhập <span>*</span></label>
                    <input type="text" name="username"  value="<?php echo (isset($info['username'])) ? $info['username'] : ""; ?>">
                    <p class="messageError"><?php echo isset($errorMessage['username']) ? $errorMessage['username'] : ''; ?></p>
                    
                    <label>Email hoặc Số điện thoại <span>*</span></label>
                    <input type="text" name="contact"  value="<?php echo (isset($info['contact'])) ? $info['contact'] : ""; ?>">
                    <p class="messageError"><?php echo isset($errorMessage['contact']) ? $errorMessage['contact'] : ''; ?></p>
                </div>
                <div class="actions">
                    <button type="submit" name="submit" value="forgot-pass">Lấy lại mật khẩu</button>
                </div>
            </form>
            <div class="img-forgot-pass">
                <img src="../../assets/images/img-forgot-pass.jpg" alt="">
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>

</html>
