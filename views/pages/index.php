<?php
session_start();
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Catogery.php';

$category = new Category();
$categories = $category->getAllCatogery();

if(isset($_SESSION['login_success'])) {
    if($_SESSION['login_success'] == 'user') {
        echo "<script>
        alert('Đăng nhập thành công.');
        </script>";
    } 
    unset($_SESSION['login_success']);

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PET SHOP</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- LINK CSS -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/index.css?v=<?php echo time(); ?>">
    
</head>
<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner">
        <div class="list-slide">
            <div class="slide-item">
                <div class="bn-overlay"></div>
                <img src="../../assets/images/slide1.jpg" alt="">
                <div class="title">
                    <div class="container">
                        <h3 class="flipInX">Devoted to proper animal healthcare.</h3>
                        <p class="fadeInUp">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod sunt excepturi laborum! Repudiandae, ab. Omnis enim neque sit a, deserunt voluptate dolorem optio, beatae corrupti cumque voluptatem ipsam quidem vitae!</p>
                        <a href="" class="btn fadeInDown">Xem thêm</a>
                    </div>
                </div>
            </div>
            <div class="slide-item">
                <div class="bn-overlay"></div>
                <img src="../../assets/images/slide2.jpg" alt="">
                <div class="title">
                    <div class="container">
                        <h3 class="fadeInDown">Refining the world one pet at a time.</h3>
                        <p class="fadeInUp">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod sunt excepturi laborum! Repudiandae, ab. Omnis enim neque sit a, deserunt voluptate dolorem optio, beatae corrupti cumque voluptatem ipsam quidem vitae!    
                    </p>
                        <a href="" class="btn fadeInDown">Xem thêm</a>
                    </div>
                </div>
            </div>
            <div class="slide-item">
                <div class="bn-overlay"></div>
                <img src="../../assets/images/slide3.jpg" alt="">
                <div class="title">
                    <div class="container">
                        <h3 class="fadeInUp">Giving all our pets a better life quality.</h3>
                        <p class="fadeInRight">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod sunt excepturi laborum! Repudiandae, ab. Omnis enim neque sit a, deserunt voluptate dolorem optio, beatae corrupti cumque voluptatem ipsam quidem vitae!    
                    </p>
                        <a href="" class="btn fadeInDown" >Xem thêm</a>
                    </div>
                </div>
            </div>  
        </div>
    </section>
    <!-- FEATURE -->
    <section class="feature">
        <div class="container">
            <div class="fea-list">
                <div class="fea-item">
                    <div class="img">
                        <img src="../../assets/images/fea1.svg" alt="">
                    </div>
                    <h4>Miễn phí vận chuyển</h4>
                    <p>Pet Shop miễn phí vận chuyển với đơn hàng trên 350.000đ</p>
                </div>
                <div class="fea-item">
                    <div class="img">
                        <img src="../../assets/images/fea2.svg" alt="">
                    </div>
                    <h4>Đổi trả trong vòng 7 ngày</h4>
                    <p>Lỗi là đổi mới trong 1 tháng tận nhà.</p>
                </div>
                <div class="fea-item">
                    <div class="img">
                        <img src="../../assets/images/fea3.svg" alt="">
                    </div>
                    <h4>Bảo hành chính hãng</h4>
                    <p>Bảo hành chính hãng sản phẩm, có người đến tận nhà</p>
                </div>
                <div class="fea-item">
                    <div class="img">
                        <img src="../../assets/images/fea4.svg" alt="">
                    </div>
                    <h4>Phương thức thanh toán</h4>
                    <p>Hỗ trợ thanh toán qua thẻ: Vietcombank, Techcombank, BIDV,…</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ABOUT US -->
    <section class="about">
        <div class="ab-left">
            <img src="../../assets/images/about.jpg" alt="">
            <img src="../../assets/images/footprint.png" class="footprint" alt="">
        </div>
        <div class="ab-right">
            <div class="ab-content">
                <h3>Làm thế nào bạn tìm thấy <span>chúng tôi?</span></h3>
                <p>Lo rem ipsum dolor sit amet, est vide volu ptaria ex, nec in hinc solum indo ctum. Est ad veri sonet
                    soluta, vim eu esse accusamus. In eam solum impetus.</p>
                <div>
                    <a href="" class="btn">Đọc thêm</a>

                </div>
            </div>
        </div>
    </section>
    <!-- CATEGORIES -->
    <section class="categories">
        <div class="container">
            <h2>Danh mục sản phẩm</h2>
            <div class="cate-list">
                <?php foreach($categories as $category) { ?>
                <div class="item">
                    <div class="img">
                        <a href="shop.php?category_id=<?php echo $category['category_id']; ?>">
                            <img src="../../assets/images/<?php echo $category['image']; ?>" alt="">

                        </a>
                    </div>
                    <p><?php echo $category['name']; ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- PARAMETER -->
    <section class="parameter">
        <div class="container">
            <div class="para-left">
                <div class="content">
                    <h3>Thực hiện thay đổi từng bàn chân đáng yêu</h3>
                    <p>Lorem ipsum dolor sit amet, est vide voluptaria exnibh vel velit auctor aliquet. Aenean
                        sollicitudin lorem. Quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id
                        elit.</p>
                    <a href="">Đọc thêm</a>
                </div>
            </div>
            <div class="para-rigth">
                <div class="box">
                    <div>
                        <p><span>Thống kê</span><span>58%</span></p>
                        <div class="full"></div>
                        <div class="percent"></div>
                    </div>
                    <div>
                        <p><span>Thống kê</span><span>76%</span></p>
                        <div class="full"></div>
                        <div class="percent"></div>
                    </div>
                    <div>
                        <p><span>Thống kê</span><span>64%</span></p>
                        <div class="full"></div>
                        <div class="percent"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TEAM -->
    <section class="team">
        <div class="container">
            <div class="title">
                <h3>Đội ngũ chuyên gia tuyệt vời</h3>
                <p>Lorem ipsum dolor sit amet, est vide voluptaria ex, nec in hinc solum sat. Neceessitatibus sonet
                    soluta, vim eu esse accusamus.
                </p>
            </div>
            <div class="team-list">
                <div class="item">
                    <img src="../../assets/images/h6-team-1.jpg" alt="">
                    <div class="name">
                        <span>Quốc Tuấn</span>
                    </div>
                    <div class="icon">
                        <div class="info">
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="../../assets/images/h6-team-2.jpg" alt="">
                    <div class="name">
                        <span>Nguyên Hùng</span>
                    </div>
                    <div class="icon">
                        <div class="info">
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="../../assets/images/h6-team-3.jpg" alt="">
                    <div class="name">
                        <span>Trọng Quân</span>
                    </div>
                    <div class="icon">
                        <div class="info">
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
</body>

</html>