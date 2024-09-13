<?php
session_start(); 
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../path.php';

$product_id = $_GET['product_id'];
$product = new Product();
$productValue = $product->getValues('product_id', $product_id);
$productSimilars = $product->getValues('category_id', $productValue[0]['category_id']);

$comment = new Comment();
$comments = $comment->getCmtByProduct($product_id);
$listCmts = [];

$user = new User();
foreach ($comments as $comment) {
    $commentData = [];
    $commentData['create_day'] = $comment['create_day'];
    $commentData['content'] = $comment['content'];

    $info = $user->getUser('user_id', $comment['user_id']);
    $commentData['fullname'] = $info['fullname'];
    $commentData['avatar'] = $info['avatar'];
    
    $listCmts[] = $commentData;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/detail.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-detail.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Chi tiết sản phẩm</h2>
            </div>
        </div>
    </section>
    <section class="detail-product">
        <div class="container">
            <div class="left">
                <div class="img">
                    <img src="../../assets/images/<?php echo $productValue[0]['image']; ?>">
                </div>
                <div class="info-product">
                    <div class="name"><?php echo $productValue[0]['name']; ?></div>
                    <div class="price"><?php echo $productValue[0]['price'] . 'đ'; ?></div>
                    <div class="status">Trạng thái: <?php echo ($productValue[0]['quantity'] > 0) ? 'Còn hàng' : 'Hết hàng'; ?></div>
                    <div class="description"><p><?php echo $productValue[0]['description']; ?></p></div>
                    <div class="add-cart">
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'user') { ?>
                            <a href="../../controllers/CartControllers.php?product_id=<?php echo $productValue[0]['product_id']; ?>"><span>Thêm vào giỏ hàng</span></a>
                        <?php } else if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                            <a href="#" onclick="cannotAdd(event);"><span>Thêm vào giỏ hàng</span></a>
                        <?php } else { ?>
                            <a href="#" onclick="loginRequired(event);"><span>Thêm vào giỏ hàng</span></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="comment">
                    <h3>Bình luận</h3>
                    <form action="../../controllers/CommentControllers.php" method="post">
                       <textarea name="comment" cols="30" rows="2" placeholder="Bạn nghĩ gì về sản phẩm này ?"></textarea>
                       <button type="submit" name="get_comment" value="<?php echo $productValue[0]['product_id']; ?>">&#10148;</button>
                    </form>
                    <div class="list-cmt">
                        <?php if(count($listCmts) == 0) { ?>
                            <p>Chưa có bình luận nào.</p>
                        <?php } else { ?>
                        <?php foreach($listCmts as $listCmt) { ?>
                            <div class="item">
                                <div class="info">
                                   <div class="user">
                                   <img src="../../assets/images/<?php echo $listCmt['avatar']; ?>" alt="">
                                    <p><?php echo $listCmt['fullname']; ?></p>
                                   </div>
                                   <p><?php echo $listCmt['create_day']; ?></p>
                                </div>
                                <div class="content">
                                <?php echo $listCmt['content']; ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="right">
                <h3>Sản phẩm liên quan</h3>
                <div class="list-product">
                    <?php foreach($productSimilars as $product) { ?>
                    <div class="item">
                        <div class="img">
                            <img src="../../assets/images/<?php echo $product['image'];?>" alt="">
                        </div>
                        <div class="info-product">
                            <div class="name"><a href="detail.php?product_id=<?php echo $product['product_id'];?>">
                            <?php echo $product['name'];?>
                            </a></div>
                            <div class="price"><?php echo $product['price'].'đ';?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
    <script>
        function loginRequired(event) {
            event.preventDefault();
            alert('Bạn chưa đăng nhập');
            window.location.href = baseUrl + 'login.php';
        }
        function cannotAdd(event) {
            event.preventDefault();
            alert('Không thể thêm với quyền QUẢN TRỊ VIÊN');
        }
    </script>
</body>

</html>
