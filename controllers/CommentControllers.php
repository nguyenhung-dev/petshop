<?php
session_start();
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Comment.php';

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn chưa đăng nhập'); window.location.href = '../views/pages/login.php';</script>";
    exit;
}

// ADD COMMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['get_comment'])) {
    $comment = $_POST['comment'];
    $created_day = date('Y-m-d');
    $product_id = $_POST['get_comment'];
    $user_id = $_SESSION['user_id'];

    if ($comment == '') {
        header("Location: ../views/pages/detail.php?product_id=$product_id");
    } else {
        $comment = new Comment($comment, $user_id, $product_id, $created_day);
        $comment->addComment();
        header("Location: ../views/pages/detail.php?product_id=$product_id");
    }
}

// DELETE COMMENT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['cmt_id'])) {
    $comment = new Comment();
    $product_id = $_GET['product_id'];
    echo $product_id;
    $comment->deleteCmtById($_GET['cmt_id']);
    header("Location: ../views/admin/comment.php?product_id=$product_id");
}
?>
