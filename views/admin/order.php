<?php
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Invoice.php';
require_once __DIR__ . '/../../models/Product.php';

$invoice = new Invoice();

$invoices = $invoice->getAllInvoice();

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
    <title>Quản lý đơn hàng</title>
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
        <div class="main">
            <h3>Danh sách đơn hàng</h3>
            <div class="list-categories" style="margin-top: 30px;">
                <table>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Người mua</th>
                        <th>Ngày tạo đơn</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Thành tiền</th>
                        <th style="text-align: center; width: 20%;"></th>
                    </tr>
                    <?php foreach ($invoices as $invoice) { ?>
                        <?php if ($invoice['order_status'] == 'confirmed') { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $invoice['invoice_id']; ?></td>
                                <td><?php echo $invoice['fullname']; ?></td>
                                <td><?php echo $invoice['created_day']; ?></td>
                                <td><?php echo ($invoice['payment_status'] == 'online') ? 'Đã thanh toán' : 'Chưa thanh toán'; ?>
                                </td>
                                <td><?php echo number_format($invoice['total_money'], 0, ',', '.') . ' đ'; ?></td>
                                <td class="actions">
                                    <div class="btn">
                                        <a href="?invoice_id=<?php echo $invoice['invoice_id']; ?>" class="view-detail"
                                            data-invoice-id="<?php echo $invoice['invoice_id']; ?>"><i
                                                class="fa-solid fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
            <div class="list-invoice-cancel" id="list-invoice-cancel">
                <p id="toggle-cancel-orders">Danh sách đơn hàng đã hủy <i class="fa-solid fa-angle-right"></i></p>
                <ul id="showlist" style="display: none;">
                    <?php foreach ($invoices as $invoice) { ?>
                        <?php if ($invoice['order_status'] == 'cancelled') { ?>
                            <div class="item">
                            <li>Đơn hàng #<?php echo $invoice['invoice_id'] . ' - ' . $invoice['fullname'] ?></li>
                            <li>Lý do hủy: <?php echo $invoice['cancel_reason'] ?></li>
                            <li class="actions">
                                <a href="?invoice_id=<?php echo $invoice['invoice_id']; ?>" class="view-detail"
                                    data-invoice-id="<?php echo $invoice['invoice_id']; ?>">Xem chi tiết</a>
                                <a href="../../controllers/InvoiceControllers.php?invoice_id=<?php echo $invoice['invoice_id']; ?>&submit=delete">Xóa</a>
                            </li>
                            </div>
                        <?php } ?>

                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php if ($invoiceDetails) { ?>
        <section class="info-invoice active" id="info-invoice">
            <div class="box-modal">
                <div class="close" id="closeModal"><i class="fa-solid fa-xmark"></i></div>
                <h3>Chi tiết đơn hàng</h3>
                <div class="show-info">
                    <div class="left">
                        <h4>Thông tin nhận hàng</h4>
                        <ul class="info-receive">
                            <li><span>Mã đơn hàng:</span><span><?php echo $invoiceDetails['invoice_id']; ?></span></li>
                            <li><span>Tên người nhận:</span><span><?php echo $invoiceDetails['fullname']; ?></span></li>
                            <li><span>Số điện thoại:</span><span><?php echo $invoiceDetails['phonenumber']; ?></span></li>
                            <li><span>Địa chỉ:</span><span><?php echo $invoiceDetails['address']; ?></span></li>
                            <li><span>Trạng thái thanh
                                    toán:</span><span><?php echo ($invoiceDetails['payment_status'] == 'online') ? 'Đã thanh toán' : 'Chưa thanh toán'; ?></span>
                            </li>
                            <li><span>Ngày tạo đơn:</span><span><?php echo $invoiceDetails['created_day']; ?></span></li>
                            <li><span>Trạng thái đơn hàng:</span><span><?php if ($invoiceDetails['order_status'] == 'pending') {
                                echo 'Chờ xử lý';
                            } else if ($invoiceDetails['order_status'] == 'confirmed') {
                                echo 'Người bán đang chuẩn bị hàng';
                            } else {
                                echo 'Hủy';
                            } ?></span></li>
                            <?php if ($invoiceDetails['order_status'] == 'cancelled') { ?>
                                <li><span>Lý do hủy:</span><span><?php echo $invoiceDetails['cancel_reason']; ?></span></li>
                            <?php } ?>
                            <li><span>Tổng
                                    tiền:</span><span><?php echo number_format($invoiceDetails['total_money'], 0, ',', '.') . ' đ'; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <h4>Sản phẩm</h4>
                        <ul class="products">
                            <?php foreach ($products as $product) { ?>
                                <li>
                                    <div class="img"><img src="../../assets/images/<?php echo $product['image']; ?>" alt="">
                                    </div>
                                    <div>
                                        <p class="name"><?php echo $product['name']; ?></p>
                                        <p class="price"><span>Số lượng:
                                                <?php echo $product['quantity']; ?></span><span><?php echo number_format($product['price'], 0, ',', '.') . ' đ'; ?></span>
                                        </p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    <script>
        function confirmDelete(id) {
            var result = confirm("Xác nhận xóa đơn hàng. \nMã đơn: " + id);
            if (result) {
                window.location.href = "../../controllers/InvoiceControllers.php?submit=delete&invoice_id=" + id;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            let toggleCancelOrders = document.getElementById('toggle-cancel-orders');
            let showList = document.getElementById('showlist');

            toggleCancelOrders.addEventListener('click', function () {
                showList.style.display = showList.style.display === 'none' ? 'block' : 'none';
                this.querySelector('i').classList.toggle('fa-angle-right');
                this.querySelector('i').classList.toggle('fa-angle-down');
            });

            let infoInvoice = document.getElementById('info-invoice');
            let viewDetailLinks = document.querySelectorAll('.view-detail');
            let closeModal = document.getElementById('closeModal');

            viewDetailLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const invoiceId = this.getAttribute('data-invoice-id');
                    window.location.href = '?invoice_id=' + invoiceId;
                });
            });

            closeModal.addEventListener('click', function () {
                infoInvoice.classList.remove('active');
                document.body.classList.remove('no-scroll');
                // window.history.pushState({}, '', window.location.pathname);
                window.location.href = window.location.pathname;
            });

            if (infoInvoice && infoInvoice.classList.contains('active')) {
                document.body.classList.add('no-scroll');
            }
        });
    </script>
</body>

</html>