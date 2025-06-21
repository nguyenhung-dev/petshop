<?php
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Invoice.php';


$user = new User();
$product = new Product();
$invoice = new Invoice();

$users = $user->getAllUser();
$totalCustomer = count($users);

$products = $product->getAllProducts();
$productQuantity = 0;
foreach ($products as $product) {
    $productQuantity += $product['quantity'];
}

$invoices = $invoice->getAllInvoice();
$totalRevenue = 0;
$numberOrder = 0;
foreach ($invoices as $invoice) {
    if ($invoice['order_status'] == 'confirmed') {
        $numberOrder++;
        $totalRevenue += $invoice['total_money'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang quản trị</title>
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
  <link rel="stylesheet" href="../../assets/css/management pages/index.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="wrapper">
    <?php require_once __DIR__ . '/navbar.php'; ?>
    <div class="main">
      <h3 style="margin-bottom: 35px;">Thông số</h3>
      <div class="parameter">
        <div class="item">
          <div class="total">
            <p>Số lượng sản phẩm</p>
            <p><?php echo $productQuantity; ?></p>
            <p>+3 sản phẩm so với tuần trước</p>
          </div>
          <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
        </div>
        <div class="item">
          <div class="total">
            <p>Tổng doanh thu</p>
            <p><?php echo number_format($totalRevenue, 0, ',', '.') . ' VND'; ?></p>
            <p>+7% so với tuần trước</p>
          </div>
          <div class="icon"><i class="fa-solid fa-wallet"></i></div>
        </div>
        <div class="item">
          <div class="total">
            <p>Tổng số đơn hàng</p>
            <p><?php echo $numberOrder; ?></p>
            <p>+8 đơn hàng so với tuần trước</p>
          </div>
          <div class="icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        </div>
        <div class="item">
          <div class="total">
            <p>Tổng số khách hàng</p>
            <p><?php echo $totalCustomer; ?></p>
            <p>+16 khách hàng so với tuần trước</p>
          </div>
          <div class="icon"><i class="fa-solid fa-users"></i></div>
        </div>
      </div>
      <div class="overview">
        <div class="left">
          <div class="left-top">
            <div class="title">
              <span>Tổng quan</span>
              <span>...</span>
            </div>
            <div class="notes">
              <p><span></span>Sales</p>
              <p><span></span>Visits</p>
            </div>
            <div class="region"></div>
            <div class="left-bt">
              <div class="item">
                <p>24.15M</p>
                <span>Tổng lượng khách truy cập <i class="fa-solid fa-arrow-up"></i> 2,43%</span>
              </div>
              <div class="item">
                <p>12:38</p>
                <span>Thời lượng khách truy cập <i class="fa-solid fa-arrow-up"></i> 12,65%</span>
              </div>
              <div class="item">
                <p>639.82</p>
                <span>Số trang/Lượt truy cập <i class="fa-solid fa-arrow-up"></i> 5,62%</span>
              </div>

            </div>
          </div>
        </div>
        <div class="right">
          <div class="title">
            <span>Thịnh hành</span>
            <span>...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>