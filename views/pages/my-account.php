<?php
session_start(); 
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Invoice.php';
require_once __DIR__ . '/../../models/Product.php';

$user_id = $_SESSION['user_id'];
$user = new User();
$info = $user->getUser('user_id', $user_id);

$invoice = new Invoice();
$invoices = $invoice->getValues('user_id', $user_id);

$product = new Product();
$invoiceDetails = null;
$products = [];
if (isset($_GET['invoice_id'])) {
    $invoice_id = intval($_GET['invoice_id']);
    $invoiceDetails = $invoice->getInvoiceDetails($invoice_id);
    $products = $product->getProductsByInvoiceId($invoice_id);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/icon-title.png">

    <!-- CSS LINK -->
    <?php require_once __DIR__ . '/../components/link-css.php'; ?>
    <link rel="stylesheet" href="../../assets/css/pages/my-account.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- HEADER -->
    <?php require_once __DIR__ . '/../components/header.php'; ?>
    <!-- BANNER -->
    <section class="banner-page">
        <img src="../../assets/images/banner-account.webp" alt="">
        <div class="overlay"></div>
        <div class="title">
            <div class="container">
                <h2>Tài khoản</h2>
            </div>
        </div>
    </section>
    <section class="my-account">
        <div class="container">
            <div class="left">
                <div class="img">
                    <img src="../../assets/images/<?php echo $info['avatar']; ?>" alt="">
                </div>
            </div>
            <div class="right">
                <h3>Thông tin cá nhân</h3>
                <div class="item">
                    <span>Họ và tên:</span>
                    <span><?php echo $info['fullname']; ?></span>
                </div>
                <div class="item">
                    <span>Tên đăng nhập:</span>
                    <span><?php echo $info['username']; ?></span>
                </div>
                <div class="item">
                    <span>Email:</span>
                    <span><?php echo $info['email']; ?></span>
                </div>
                <div class="item">
                    <span>Số điện thoại:</span>
                    <span><?php echo $info['phonenumber']; ?></span>
                </div>
                <div class="item">
                    <span>Sinh nhật:</span>
                    <span><?php echo $info['birthday']; ?></span>
                </div>
                <div class="item">
                    <span>Giới tính: </span>
                    <span><?php echo ($info['gender'] == 'male') ? 'Nam' : 'Nữ'; ?></span>
                </div>
                <div class="item actions">
                    <a href="update-account.php">Cập nhật</a>
                    <a href="change-pass.php">Đổi mật khẩu</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="my-invoice">
        <div class="container">
            <h3>Đơn hàng của bạn</h3>
            <?php if(count($invoices) == 0) { ?>
                <p style="margin-bottom: 100px;">Không có đơn hàng nào.</p>
            <?php } else { ?>
                <table>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày tạo đơn</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                        <?php foreach($invoices as $invoice) { ?>
                            <tr>
                                <td><?php echo $invoice['invoice_id']; ?></td>
                                <td><?php echo $invoice['created_day']; ?></td>
                                <td><?php 
                                    if($invoice['order_status'] == 'pending') {
                                        echo 'Chờ xử lý';
                                    } else if($invoice['order_status'] == 'cancelled') {
                                        echo '<p style="color: red;">Bị hủy</p>';
                                    } else {
                                        echo '<p style="color: blue;">Chờ giao hàng</p>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo  number_format($invoice['total_money'], 0, ',', '.') . ' đ'; ?></td>
                                <td class="actions">
                                    <div class="btn">
                                    <a href="my-account.php?invoice_id=<?php echo $invoice['invoice_id']; ?>" class="view-detail" data-invoice-id="<?php echo $invoice['invoice_id']; ?>">Xem chi tiết</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                </table>
                <div class="my-invoice-repon">
                <?php foreach($invoices as $invoice) { ?>
                    <div class="item">
                        <div>
                         <p>Đơn hàng#<?php  echo $invoice['invoice_id'] . ' - ' . $invoice['fullname'] ?> - </p> <?php if($invoice['order_status'] == 'pending') {
                                            echo 'Chờ xử lý';
                                        } else if($invoice['order_status'] == 'cancelled') {
                                            echo '<p style="color: red;">Bị hủy</p>';
                                        } else {
                                            echo '<p style="color: blue;">Chờ giao hàng</p>';
                                        }
                                        ?>
                        </div>
                        <a href="my-account.php?invoice_id=<?php echo $invoice['invoice_id']; ?>" class="view-detail" data-invoice-id="<?php echo $invoice['invoice_id']; ?>">Xem chi tiết</a>
                    </div>
                   <?php } ?>  
                </div>
            <?php } ?>
        </div>
    </section>

    <?php if($invoiceDetails) { ?>
    <section class="info-invoice active" id="info-invoice">
        <div class="box-modal">
            <div class="close" id="close"><i class="fa-solid fa-xmark"></i></div>
            <h3>Chi tiết đơn hàng</h3>
            <div class="show-info">
              <div class="left">
                <h4>Thông tin nhận hàng</h4>
                <ul class="info-receive">
                    <li>
                        <span>Mã đơn hàng:</span>
                        <span><?php echo $invoiceDetails['invoice_id']; ?></span>
                    </li>
                    <li>
                        <span>Tên người nhận:</span>
                        <span><?php echo $invoiceDetails['fullname']; ?></span>
                    </li>
                    <li>
                        <span>Số điện thoại:</span>
                        <span><?php echo $invoiceDetails['phonenumber']; ?></span>
                    </li>
                    <li>
                        <span>Địa chỉ:</span>
                        <span><?php echo $invoiceDetails['address']; ?></span>
                    </li>
                    <li>
                        <span>Trạng thái thanh toán:</span>
                        <span><?php echo ($invoiceDetails['payment_status'] == 'online') ? 'Đã thanh toán' : 'Chưa thanh toán'; ?></span>
                    </li>
                    <li>
                        <span>Ngày tạo đơn:</span>
                        <span><?php echo $invoiceDetails['created_day']; ?></span>
                    </li>
                    <li>
                        <span>Trạng thái đơn hàng:</span>
                        <span><?php 
                            if($invoiceDetails['order_status'] == 'pending') {
                                echo 'Chờ xử lý';
                            } else if($invoiceDetails['order_status'] == 'cancelled') {
                                echo 'Bị hủy';
                            } else {
                                echo 'Chờ giao hàng';
                            }
                        ?></span>
                    </li>

                    <?php if($invoiceDetails['order_status'] == 'cancelled') { ?>
                        <li>
                            <span>Lý do hủy:</span>
                            <span><?php echo $invoiceDetails['cancel_reason']; ?></span>
                        </li>
                    <?php } ?>

                    <li>
                        <span>Tổng tiền:</span>
                        <span><?php echo number_format($invoiceDetails['total_money'], 0, ',', '.') . ' đ'; ?></span>
                    </li>
                </ul>
              </div>
              <div class="right">
                <h4>Sản phẩm</h4>
                <ul class="products">
                <?php foreach ($products as $product) { ?>
                    <li>
                        <div class="img">
                            <img src="../../assets/images/<?php echo $product['image']; ?>" alt="">
                        </div>
                        <div>
                            <p class="name"><?php echo $product['name']; ?></p>
                            <p class="price"><span>Số lượng: <?php echo $product['quantity']; ?></span><span><?php echo number_format($product['price'], 0, ',', '.') . ' đ'; ?></span></p>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
              </div>
            </div>
        </div>
    </section>
    <?php } ?>

    <!-- FOOTER -->
    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <!-- JS LINK -->
    <?php require_once __DIR__ . '/../components/link-js.php'; ?>
    <script>
        let infoInvoice = document.getElementById('info-invoice');
        let viewDetailLinks = document.querySelectorAll('.view-detail');
        let closeModal = document.getElementById('close');

        viewDetailLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const invoiceId = this.getAttribute('data-invoice-id');
                window.location.href = 'my-account.php?invoice_id=' + invoiceId;
            });
        });

        closeModal.addEventListener('click', function() {
            infoInvoice.classList.remove('active');
            document.body.classList.remove('no-scroll');
            window.history.pushState({}, '', window.location.pathname);
        });

        if (infoInvoice && infoInvoice.classList.contains('active')) {
            document.body.classList.add('no-scroll');
        }
    </script>

</body>

</html>
