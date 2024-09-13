<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/Comment.php';

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
    } else if ($user->Login('username', $username) == false) {
        $errorMessage['username'] = 'Tên đăng nhập không tồn tại!';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    } else if ($user->Login('username', $username)) {
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

    $user = new User($fullname, $username, $password, $email, $phonenumber, $gender, $birthday, $avatar);

    if (empty($fullname)) {
        $errorMessage['fullname'] = 'Bạn chưa nhập họ và tên!';
    }
    if (empty($username)) {
        $errorMessage['username'] = 'Bạn chưa nhập tên đăng nhập!';
    } else if ($user->isInfo('username', $username)) {
        $errorMessage['username'] = 'Tên đăng nhập đã tồn tại!';
    }
    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    }
    if (empty($email)) {
        $errorMessage['email'] = 'Bạn chưa nhập email!';
    } else if ($user->isInfo('email', $email)) {
        $errorMessage['email'] = 'Email đã tồn tại!';
    }
    if (empty($phonenumber)) {
        $errorMessage['phonenumber'] = 'Bạn chưa nhập số điện thoại!';
    } else if (!preg_match('/^[0-9]{10,11}$/', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại không đúng định dạng!';
    } else if ($user->isInfo('phonenumber', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại đã được đăng ký!';
    }

    if (count($errorMessage) > 0) {
        $_SESSION['register_error'] = $errorMessage;
        $_SESSION['register_info'] = $info;
        header('Location: ../views/pages/register.php');
        exit();
    } else {
        $user->register();
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../assets/images/' . $_FILES['avatar']['name']);
        $_SESSION['register_success'] = true;
        header('Location: ../views/pages/login.php');
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'add-user') {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $avatar = $_FILES['avatar']['name'];
    $role = $_POST['role'];

    $errorMessage = [];
    $info = [
        'fullname' => $fullname,
        'username' => $username,
        'password' => $password,
        'email' => $email,
        'phonenumber' => $phonenumber,
        'gender' => $gender,
        'birthday' => $birthday,
    ];

    $user = new User($fullname, $username, $password, $email, $phonenumber, $gender, $birthday, $avatar, $role);

    if (empty($fullname)) {
        $errorMessage['fullname'] = 'Bạn chưa nhập họ và tên!';
    }
    if (empty($role)) {
        $errorMessage['role'] = 'Bạn chưa chọn vai trò !';
    }
    if (empty($username)) {
        $errorMessage['username'] = 'Bạn chưa nhập tên đăng nhập!';
    } else if ($user->isInfo('username', $username)) {
        $errorMessage['username'] = 'Tên đăng nhập đã tồn tại!';
    }
    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    }
    if (empty($email)) {
        $errorMessage['email'] = 'Bạn chưa nhập email!';
    } else if ($user->isInfo('email', $email)) {
        $errorMessage['email'] = 'Email đã tồn tại!';
    }
    if (empty($phonenumber)) {
        $errorMessage['phonenumber'] = 'Bạn chưa nhập số điện thoại!';
    } else if (!preg_match('/^[0-9]{10,11}$/', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại không đúng định dạng!';
    } else if ($user->isInfo('phonenumber', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại đã được đăng ký!';
    }

    if (count($errorMessage) > 0) {
        $_SESSION['register_error'] = $errorMessage;
        $_SESSION['register_info'] = $info;
        header('Location: ../views/admin/add-user.php');
        exit();
    } else {
        $user->register();
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../assets/images/' . $_FILES['avatar']['name']);
        $_SESSION['register_success'] = true;
        header('Location: ../views/admin/add-user.php');
        exit();
    }
}
// UPDATE INFO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'update') {

    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $birthday = $_POST['birthday'];
    $avatar = $_FILES['avatar']['name'];

    $errorMessage = [];
    $info = [
        'fullname' => $fullname,
        'password' => $password,
        'email' => $email,
        'phonenumber' => $phonenumber,
        // 'gender' => $gender,
        'birthday' => $birthday
    ];
    $user = new User();
    $user->setFullname($fullname);
    $user->setEmail($email);
    $user->setPhonenumber($phonenumber);
    $user->setBirthday($birthday);
    $user->setPassword($password);
    $user->setGender($gender);
    $user->setAvatar($avatar);

    if (empty($fullname)) { 
        $errorMessage['fullname'] = 'Bạn chưa nhập họ và tên!';
    }
    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu!';
    }
    if (empty($email)) {
        $errorMessage['email'] = 'Bạn chưa nhập email!';
    } else if ($user->isInfoUpdate('email', $email, $_SESSION['user_id'])) {
        $errorMessage['email'] = 'Email đã tồn tại!';
    }
    if (empty($phonenumber)) {
        $errorMessage['phonenumber'] = 'Bạn chưa nhập số điện thoại!';
    } else if (!preg_match('/^[0-9]{10,11}$/', $phonenumber)) {
        $errorMessage['phonenumber'] = 'Số điện thoại không đúng định dạng!';
    } else if ($user->isInfoUpdate('phonenumber', $phonenumber, $_SESSION['user_id'])) {
        $errorMessage['phonenumber'] = 'Số điện thoại đã được đăng ký!';
    }

    if (count($errorMessage) > 0) {
        $_SESSION['update_error'] = $errorMessage;
        $_SESSION['update_info'] = $info;
        header('Location: ../views/pages/update-account.php');
        exit();
    } else {
        $user->updateInfo($_SESSION['user_id']);
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../assets/images/' . $_FILES['avatar']['name']);
        $_SESSION['update_success'] = true;
        header('Location: ../views/pages/update-account.php');
        exit();
    }
}

// FORGOT PASS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'forgot-pass') {
    $username = $_POST['username'];
    $contact = $_POST['contact'];

    $errorMessage = [];
    $info = [
        'username' => $username,
        'contact' => $contact,
    ];
    $user = new User();

    if (empty($username)) {
        $errorMessage['username'] = 'Bạn chưa nhập tên đăng nhập!';
    }

    if (empty($contact)) {
        $errorMessage['contact'] = 'Bạn chưa nhập email hoặc số điện thoại!';
    }

    if (count($errorMessage) > 0) {
        $_SESSION['forgot_pass_info'] = $info;
        $_SESSION['forgot_pass_error'] = $errorMessage;
        header('Location: ../views/pages/forgot-pass.php');
        exit();
    } else {
        $userInfo = $user->getUser('username', $username);

        if ($userInfo) {
            if ($userInfo['email'] === $contact || $userInfo['phonenumber'] === $contact) {
                // Hiển thị mật khẩu
                $_SESSION['forgot_pass_success'] = $userInfo['password'];
                header('Location: ../views/pages/forgot-pass.php');
                exit();
            } else {
                $errorMessage['contact'] = 'Email hoặc số điện thoại không đúng!';
            }
        } else {
            $errorMessage['username'] = 'Tên đăng nhập không tồn tại!';
        }

        $_SESSION['forgot_pass_error'] = $errorMessage;
        $_SESSION['forgot_pass_info'] = $info;
        header('Location: ../views/pages/forgot-pass.php');
        exit();
    }
}

// CHANGE PASS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] == 'change-pass') {
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errorMessage = [];
    $info = [
        'contact' => $contact,
    ];
    $user = new User();

    if (empty($contact)) {
        $errorMessage['contact'] = 'Bạn chưa nhập email hoặc số điện thoại!';
    }

    if (empty($password)) {
        $errorMessage['password'] = 'Bạn chưa nhập mật khẩu mới!';
    }

    if ($password !== $confirmPassword) {
        $errorMessage['confirm_password'] = 'Mật khẩu xác nhận không khớp!';
    }

    $infoUer = $user->getInfo('role', 'user_id', $_SESSION['user_id']);
    echo $infoUer;

if (count($errorMessage) > 0) {
    $_SESSION['change_pass_error'] = $errorMessage;
    $_SESSION['change_pass_info'] = $info;
    if($infoUer == 'admin') {
        header("Location: ../views/pages/change-pass.php");
        exit();
    } else {
        header("Location: ../views/pages/change-pass.php");
        exit();
    }
}

$currentId = $user->getUserInfoByContact($contact);
$isContact = $user->isContactAndUserId($contact);
$idLogin = $_SESSION['user_id'];

if ($isContact && ($currentId['user_id'] == $idLogin)) {
    $user->updatePassword($_SESSION['user_id'], $password);
    $_SESSION['change_pass_success'] = 'Mật khẩu đã được thay đổi thành công!';
} else {
    $errorMessage['contact'] = 'Email hoặc số điện thoại không đúng!';
    $_SESSION['change_pass_info'] = $info;
    $_SESSION['change_pass_error'] = $errorMessage;
}

if($infoUer == 'admin') {
    header("Location: ../views/pages/change-pass.php");
    exit();
} else {
    header("Location: ../views/pages/change-pass.php");
    exit();
}

}

// DELETE USER
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id'])) {
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
        if ($user->deleteUserById($_GET['user_id'])) {
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

// LOGOUT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout']) && $_GET['logout'] == 'logout') {

    $_SESSION = array();
    
    session_destroy();
    
    header('Location: ../views/pages/index.php'); 
    exit;
}
?>