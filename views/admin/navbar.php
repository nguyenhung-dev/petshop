<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Invoice.php';
require_once __DIR__ . '/../../models/Product.php';

$current_page = basename($_SERVER['PHP_SELF']);
$fullname = $_SESSION['fullname'];

$invoice = new Invoice();
$orders = $invoice->getProcessingOrders();
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

<div class="nav-top">
    <div class="logo">
        <img src="../../assets/images/LOGO.png" alt="">
    </div>
    <ul>
        <li><a href="../pages/index.php">Trang chủ</a></li>
        <li><a href="index.php">Trang quản trị</a></li>
        <li><a href="">Tài khoản</a></li>
        <li><a href="">Cài đặt</a></li>
    </ul>
    <div class="search">
        <input type="text" name="" placeholder="Tìm kiếm">
        <div class="notifi">
            <i class="fa-solid fa-bell" id="notificationIcon">
                <span class="number"><?php echo count($orders); ?></span>
            </i>
        </div>
    </div>
    <div class="dropdow" id="dropdownMenu">
        <p>Bạn có <?php echo count($orders); ?> đơn hàng mới</p>
        <div class="list-new-invoice">
            <?php foreach ($orders as $order): ?>
                <?php if($order['order_status'] == 'pending') { ?>
                    <div class="invoice-item">
                        <p>Đơn hàng #<?php echo $order['invoice_id']; ?> - <?php echo $order['fullname']; ?></p>
                        <button><a href="?invoice_id=<?php echo $order['invoice_id']; ?>" class="view-detail" data-invoice-id="<?php echo $order['invoice_id']; ?>">Xem chi tiết</a></button>
                        <button onclick="confirmOrder(<?php echo $order['invoice_id']; ?>)">Xác nhận</button>
                        <button onclick="cancelOrder(<?php echo $order['invoice_id']; ?>)">Hủy</button>
                    </div>
                <?php } ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="nav-left">
    <div class="info">
        <div class="avt">
            <img src="../../assets/images/avt-admin.png" alt="">
        </div>
        <div class="name">
            <p>Xin chào</p>
            <p><?php echo $fullname; ?></p>
        </div>
    </div>
    <div class="dashboard">
        <ul>
            <li><a href="index.php" class="<?php echo $current_page == 'index.php' ? 'nl-active' : ''; ?>"><span><i class="fas fa-chart-line"></i>Thông số chung</span></a></li>
            <li><a href="customer.php" class="<?php echo $current_page == 'customer.php' ? 'nl-active' : ''; ?>"><span><i class="fa-solid fa-user"></i>Quản lý tài khoản</span></a></li>
            <li><a href="categories.php" class="<?php echo $current_page == 'categories.php' ? 'nl-active' : ''; ?>"><span><i class="fas fa-paw"></i>Quản lý danh mục</span></a></li>
            <li><a href="products.php" class="<?php echo $current_page == 'products.php' ? 'nl-active' : ''; ?>"><span><i class="fa-solid fa-carrot"></i>Quản lý sản phẩm</span></a></li>
            <li><a href="order.php" class="<?php echo $current_page == 'order.php' ? 'nl-active' : ''; ?>"><span><i class="fas fa-clipboard-list"></i> Quản lý đơn hàng</span></a></li>
        </ul>
    </div>  
    <div class="actions">
        <a href="#"  onclick="confirmLogout()">Đăng xuất</a>
    </div>
</div>

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
                        <span><?php if($invoiceDetails['order_status'] == 'pending') {
                            echo 'Chờ xử lý';
                        } else if($invoiceDetails['order_status'] == 'confirmed') {
                            echo 'Người bán đang chuẩn bị hàng';
                        } else {
                            echo 'Hủy';
                        }?></span>
                    </li>
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
<script>
        function confirmLogout() {
            var confirmed = confirm('Bạn chắc chắn muốn đăng xuất không?');
            if (confirmed) {
                window.location.href = '../../controllers/UserControllers.php?logout=logout';
            }
        }
</script>

<script>
    function confirmLogout() {
        var confirmed = confirm('Bạn chắc chắn muốn đăng xuất không?');
        if (confirmed) {
            window.location.href = '../../controllers/UserControllers.php?logout=logout';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var notificationIcon = document.getElementById('notificationIcon');
        var dropdownMenu = document.getElementById('dropdownMenu');

        // Function to toggle dropdown visibility
        function toggleDropdown() {
            dropdownMenu.classList.toggle('show');
        }

        // Hide dropdown
        function hideDropdown() {
            dropdownMenu.classList.remove('show');
        }

        // Toggle dropdown on icon click
        notificationIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            toggleDropdown();
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(event) {
            var isClickInside = dropdownMenu.contains(event.target) || notificationIcon.contains(event.target);
            if (!isClickInside) {
                hideDropdown();
            }
        });
    });
</script>

<script>
        let infoInvoice = document.getElementById('info-invoice');
        let viewDetailLinks = document.querySelectorAll('.view-detail');
        let closeModal = document.getElementById('close');

        viewDetailLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const invoiceId = this.getAttribute('data-invoice-id');
                window.location.href = '?invoice_id=' + invoiceId;
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

<script>
    function confirmOrder(invoice_id) {
        window.location.href = '../../controllers/InvoiceControllers.php?action=confirmOrder&invoice_id=' + invoice_id;
    }

    function cancelOrder(invoice_id) {
        var reason = prompt('Nhập lý do hủy:');
        if (reason) {
            window.location.href = '../../controllers/InvoiceControllers.php?action=cancelOrder&invoice_id=' + invoice_id + '&reason=' + encodeURIComponent(reason);
        }
    }
 </script>