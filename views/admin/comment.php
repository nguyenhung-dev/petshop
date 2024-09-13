<?php
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Comment.php';


$product_id = $_GET['product_id'];
$product = new Product();
$productValue = $product->getValues('product_id', $product_id);

$comment = new Comment();
$comments = $comment->getCmtByProduct($product_id);
$listCmts = [];

$user = new User();
foreach ($comments as $comment) {
    $commentData = [];

    $commentData['cmt_id'] = $comment['cmt_id'];
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
    <title>Bình luận sản phẩm</title>
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
        <div class="main comment">
            <h3>Quản lý bình luận</h3>
            <div class="info-product" style="margin-top: 60px;">
                <div class="top">
                    <div class="img">
                        <img src="../../assets/images/<?php echo $productValue[0]['image']; ?>" alt="">
                    </div>
                    <div class="name">
                        <h6><?php echo $productValue[0]['name']; ?></h6>
                        <p class="price"><?php echo $productValue[0]['price'] . 'đ'; ?></p>
                        <p class="des"> <span>Mô tả sản phẩm: </span><?php echo $productValue[0]['description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="cmt-product">
                <?php if (count($listCmts) == 0) { ?>
                    <p>Chưa có bình luận nào.</p>
                <?php } else { ?>
                    <?php foreach ($listCmts as $listCmt) { ?>
                        <div class="item">
                            <div class="left">
                                <div class="info">
                                    <div class="avt">
                                        <img src="../../assets/images/<?php echo $listCmt['avatar']; ?>" alt="">
                                    </div>
                                    <div class="name">
                                        <p><?php echo $listCmt['fullname']; ?></p>
                                        <p><?php echo $listCmt['create_day']; ?></p>
                                    </div>

                                </div>
                                <div class="content">
                                    <?php echo $listCmt['content']; ?>
                                </div>
                            </div>
                            <div class="right">
                                <a href="../../controllers/CommentControllers.php?cmt_id=<?php echo $listCmt['cmt_id']; ?>&product_id=<?php echo $product_id; ?>">Xóa</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>