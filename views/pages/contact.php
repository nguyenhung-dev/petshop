<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/contact.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-contact.jpg" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Liên hệ</h2>
            </div>
        </div>
    </section>
    <!-- MAIN CONTACT -->
    <section>
        <div class="container">
            <div class="main-contact">
                <div class="ct-left">
                    <h3>Liên hệ với chúng tôi</h3>
                    <div class="ct-intro-top">
                    Chào mừng bạn đến với cửa hàng thú cưng đáng yêu của chúng tôi! Chúng tôi rất vui khi được giúp đỡ bạn và những người bạn bốn chân của bạn. Nếu bạn có bất kỳ câu hỏi nào về sản phẩm, dịch vụ, hoặc cần tư vấn chăm sóc cho thú cưng, đừng ngần ngại liên hệ với chúng tôi. Đội ngũ nhân viên nhiệt tình và yêu động vật của chúng tôi luôn sẵn sàng hỗ trợ bạn.
                    </div>
                    <div class="info">
                        <div>
                         <i class="fa-solid fa-phone"></i>
                            <span>1900 1000</span>
                        </div>
                        <div>
                        <i class="fa-solid fa-envelope"></i>
                            <span>petshop_fpt@gmail.com</span>
                        </div>
                        <div>
                        <i class="fa-solid fa-location-dot"></i>
                            <span>137 Nguyễn Thị Thập, quận Liên Chiểu, Tp.Đà Nẵng.</span>
                        </div>
                    </div>
                    <div class="ct-intro-bottom">
                    Chúng tôi luôn mong muốn mang đến những sản phẩm tốt nhất và dịch vụ tuyệt vời nhất cho thú cưng của bạn. Cảm ơn bạn đã tin tưởng và ủng hộ cửa hàng của chúng tôi. Chúc bạn và thú cưng có một ngày thật vui vẻ và hạnh phúc!
                    </div>
                </div>
                <div class="ct-right">
                    <h3>Thông tin của bạn</h3>
                    <form action="">
                        <label>Họ và tên</label>
                        <input type="text">
                        <label>Số điện thoại</label>
                        <input type="text">
                        <label>Email liên hệ</label>
                        <input type="text">
                        <label>Lời nhắn</label>
                        <textarea cols="30" rows="7"></textarea>
                        <button><span>Gửi</span></button>
                    </form>
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