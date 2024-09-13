<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['change_pass_error'])) {
    $errorMessage = $_SESSION['change_pass_error'];
    $info = $_SESSION['change_pass_info'];
    unset($_SESSION['change_pass_info']);
    unset($_SESSION['change_pass_error']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
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
        <img src="../../assets/images/banner-resetpass.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Đổi mật khẩu</h2>
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
                    <label>Email hoặc Số điện thoại <span>*</span></label>
                    <input type="contact" name="contact" value="<?php echo (isset($info['contact'])) ? $info['contact'] : ""; ?>">
                    <p class="messageError"><?php echo isset($errorMessage['contact']) ? $errorMessage['contact'] : ''; ?></p>
                    <label>Nhập mật khẩu mới <span>*</span></label>
                    <input type="password" name="password">
                    <p class="messageError"><?php echo isset($errorMessage['password']) ? $errorMessage['password'] : ''; ?></p>
                    <label>Nhập lại mật khẩu mới <span>*</span></label>
                    <input type="password" name="confirm_password">
                    <p class="messageError"><?php echo isset($errorMessage['confirm_password']) ? $errorMessage['confirm_password'] : ''; ?></p>
                </div>
                <div class="success"><?php 
                if (isset($_SESSION['change_pass_success'])) {
                    $successMessage = $_SESSION['change_pass_success'];
                    echo "<i class='fa-solid fa-check'></i>
                    <span>Đổi mật khẩu thành công.</span>";
                    unset($_SESSION['change_pass_success']);
                }
                ?></div>
                <div class="actions">
                    <button type="submit" name="submit" value="change-pass">Đổi mật khẩu</button>
                </div>
            </form>
            <div class="img-forgot-pass">
                <img src="../../assets/images/img-reset.jpg" alt="">
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>

</html>