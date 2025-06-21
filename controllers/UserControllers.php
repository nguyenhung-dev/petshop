<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/Comment.php';

$user = new User();

// LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();

    $errorMessage = [];
    $info = [
        'username' => $username,
        'password' => $password
    ];

    if (empty($username)) {
        $errorMessage['username'] = 'Bạn chưa nhập tên đăng nhập!';
    } else if ($user->loginUser('username', $username) == false) {
        $errorMessage['username'] = 'Tên đăng nhập không tồn tại!';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    } else if ($user->loginUser('username', $username)) {
        $storedPassword = $user->getInfo('password', 'username', $username);
        if ($storedPassword !== $password) {
            $errorMessage['password'] = 'Mật khẩu không đúng!';
        }
    }

    if (count($errorMessage) > 0) {
        $_SESSION['login_error'] = $errorMessage;
        $_SESSION['login_info'] = $info;
        header('Location: ../views/pages/login.php');
    } else {
        $_SESSION['fullname'] = $user->getInfo('fullname', 'username', $username);
        $_SESSION['user_id'] = $user->getInfo('user_id', 'username', $username);
        $user_id = $_SESSION['user_id'];
        $_SESSION['login_success'] = ($user->getInfo('role', 'username', $username) == 'admin') ? 'admin' : 'user';
        if ($user->getInfo('role', 'username', $username) == 'admin') {
            $_SESSION['role'] = 'admin';
            header("Location: ../views/pages/index.php?user_id=$user_id");
            exit;
        } else {
            $_SESSION['role'] = 'user';
            header("Location: ../views/pages/index.php?user_id=$user_id");
            exit;
        }
    }
}

// REGISTER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'register') {
    require_once __DIR__ . '/../models/User.php';

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $avatar = $_FILES['avatar']['name'];

    $errorMessage = [];
    $info = [
        'fullname' => $fullname,
        'username' => $username,
        'password' => $password,
        'email' => $email,
        'phonenumber' => $phonenumber,
        'gender' => $gender,
        'birthday' => $birthday
    ];

    $user = new User();

    // Kiểm tra dữ liệu đầu vào
    if (empty($fullname)) {
        $errorMessage['fullname'] = 'Bạn chưa nhập họ và tên!';
    }
    if (empty($username)) {
        $errorMessage['username'] = 'Bạn chưa nhập tên đăng nhập!';
    } else if ($user->isInfoExists('username', $username)) {
        $errorMessage['username'] = 'Tên đăng nhập đã tồn tại!';
    }
    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    }
    if (empty($email)) {
        $errorMessage['email'] = 'Bạn chưa nhập email!';
    } else if ($user->isInfoExists('email', $email)) {
        $errorMessage['email'] = 'Email đã tồn tại!';
    }
    if (empty($phonenumber)) {
        $errorMessage['phonenumber'] = 'Bạn chưa nhập số điện thoại!';
    } else if (!preg_match('/^[0-9]{10,11}$/', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại không đúng định dạng!';
    } else if ($user->isInfoExists('phonenumber', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại đã được đăng ký!';
    }

    if (count($errorMessage) > 0) {
        $_SESSION['register_error'] = $errorMessage;
        $_SESSION['register_info'] = $info;
        header('Location: ../views/pages/register.php');
        exit();
    } else {
        // Đăng ký tài khoản
        $user->registerUser($fullname, $username, $password, $email, $phonenumber, $gender, $birthday, $avatar);
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../assets/images/' . $avatar);
        $_SESSION['register_success'] = true;
        header('Location: ../views/pages/login.php');
        exit();
    }
}

// FORGOT PASSWORD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'forgot-pass') {
    $email = $_POST['email'];
    if (!$user->isInfo('email', $email)) {
        $_SESSION['forgot_error'] = 'Email không tồn tại!';
        header('Location: ../views/pages/forgot-password.php');
        exit();
    } else {
        // Giả sử gửi email thành công với mật khẩu mới là '123456'
        $user->updatePasswordByEmail($email, '123456');
        $_SESSION['forgot_success'] = 'Mật khẩu mới đã được gửi tới email của bạn!';
        header('Location: ../views/pages/login.php');
        exit();
    }
}

// CHANGE PASSWORD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'change-pass') {
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];
    $userId = $_SESSION['user_id'];

    if (!$user->login($_SESSION['username'], $currentPass)) {
        $_SESSION['change_error'] = 'Mật khẩu hiện tại không đúng!';
    } elseif ($newPass !== $confirmPass) {
        $_SESSION['change_error'] = 'Mật khẩu mới không khớp!';
    } else {
        $user->updatePassword($userId, $newPass);
        $_SESSION['change_success'] = 'Đổi mật khẩu thành công!';
    }
    header('Location: ../views/pages/change-password.php');
    exit();
}

// LOGOUT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout']) && $_GET['logout'] == 'logout') {
    $_SESSION = array();

    session_destroy();

    header('Location: ../views/pages/index.php');
    exit;
}

// DELETE ACCOUNT
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $user = new User();
    $cart = new Cart();
    $invoice = new Invoice();
    $comment = new Comment();

    // Kiểm tra nếu người dùng có đơn hàng
    if ($user->hasOrders($_GET['user_id'])) {
        echo "<script>
                alert('Không thể xóa, tài khoản này có đơn hàng đang được xử lý!');
                window.location.href = '../views/admin/customer.php';
            </script>";
    } else {
        $invoice->deleteAllInvoiceByUser($_GET['user_id']);
        $cart->deleteProductInCartByUser($_GET['user_id']);
        $comment->deleteCmtByUser($_GET['user_id']);
        if ($user->deleteUser($_GET['user_id'])) {
            echo "<script>
                    alert('Xóa tài khoản thành công.');
                    window.location.href = '../views/admin/customer.php';
                </script>";
        } else {
            echo "<script>
                    alert('Không thể xóa, có lỗi xảy ra!');
                    window.location.href = '../views/admin/customer.php';
                </script>";
        }
    }
}