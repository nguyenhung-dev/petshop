<?php
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/Cart.php';
require_once __DIR__ . '/../../path.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['role'])) {
  $fullname = $_SESSION['fullname'];

  $cart = new Cart();
  $carts = $cart->getValues('user_id', $_SESSION['user_id']);
}

$page = "";
$currentFile = basename($_SERVER['PHP_SELF']);
if ($currentFile == 'index.php') {
  $page = "index";
} else if ($currentFile == 'about.php') {
  $page = "about";
} else if ($currentFile == "shop.php") {
  $page = "shop";
} else if ($currentFile == "news.php") {
  $page = "news";
} else if ($currentFile == "contact.php") {
  $page = "contact";
}

echo "<script>var baseUrl = '$base';</script>";

?>
<header class="scroll">
  <div id="nav-reponsive">
    <ul>
      <div class="img">
        <img src="<?php echo $base . '../../assets/images/LOGO.png' ?>" alt="">
      </div>
      <div id="close-navbar">&#x00D7;</div>
      <li class="<?php echo ($page == "index") ? "menu-active" : ""; ?>"><a href="/home">Trang chủ</a></li>
      <li class="<?php echo ($page == "about") ? "menu-active" : ""; ?>"><a href="/about">Giới thiệu</a></li>
      <li class="<?php echo ($page == "shop") ? "menu-active" : ""; ?>"><a href="/shop">Cửa hàng</a></li>
      <li class="<?php echo ($page == "news") ? "menu-active" : ""; ?>"><a href="/news">Tin tức</a></li>
      <li class="<?php echo ($page == "contact") ? "menu-active" : ""; ?>"><a href="/contact">Liên hệ</a></li>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
      <li class="<?php echo ($page == "administration") ? "menu-active" : ""; ?>"><a href="/admin">Quản trị</a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="container">
    <nav>
      <div class="hd-logo">
        <div class="nav-icon" id="icon-navbar">&#9776;</div>
        <a href="<?php echo $base . 'index.php'; ?>">
          <img src="<?php echo $base . '../../assets/images/LOGO.png' ?>" alt="">
        </a>
      </div>
      <div class="hd-menu" id="menu-navbar">
        <ul>
          <li class="<?php echo ($page == "index") ? "menu-active" : ""; ?>"><a
              href="<?php echo $base . 'index.php'; ?>">Trang chủ</a></li>
          <li class="<?php echo ($page == "about") ? "menu-active" : ""; ?>"><a
              href="<?php echo $base . 'about.php'; ?>">Giới thiệu</a></li>
          <li class="<?php echo ($page == "shop") ? "menu-active" : ""; ?>"><a
              href="<?php echo $base . 'shop.php'; ?>">Cửa hàng</a></li>
          <li class="<?php echo ($page == "news") ? "menu-active" : ""; ?>"><a
              href="<?php echo $base . 'news.php'; ?>">Tin tức</a></li>
          <li class="<?php echo ($page == "contact") ? "menu-active" : ""; ?>"><a
              href="<?php echo $base . 'contact.php'; ?>">Liên hệ</a></li>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
          <li class="<?php echo ($page == "administration") ? "menu-active" : ""; ?>"><a
              href=" <?php echo $base . '../admin/index.php'; ?>">Quản trị</a></li>
          <?php } ?>
        </ul>
      </div>
      <div class="hd-tools">
        <div class="name">
          <p><?php echo isset($_SESSION['role']) ? $fullname : ''; ?></p>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
        <?php } else { ?>
        <div class="search">
          <a href=""><i class="fa-solid fa-magnifying-glass"></i></a>
        </div>
        <div class="cart">
          <span class="number">
            <?php echo (isset($carts)) ? count($carts) : '0' ?>
          </span>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') { ?>
          <a href="<?php echo $base . 'cart.php'; ?>"> <i class="fa-solid fa-cart-shopping"></i></a>
          <?php } else { ?>
          <a href="#" onclick="goToCart(event)"> <i class="fa-solid fa-cart-shopping"></i></a>
          <?php } ?>

        </div>
        <?php } ?>

        <div class="account">
          <i class="fa-solid fa-user" id="account-btn"></i>
          <div class="dropdown" id="account-dropdown">
            <?php if (isset($_SESSION['role'])) { ?>
            <a href="<?php echo $base . 'my-account.php'; ?>">Tài khoản</a>
            <a href="#" onclick="confirmLogout()">Đăng xuất</a>
            <?php } else { ?>
            <a href="<?php echo $base . 'login.php'; ?>">Đăng nhập</a>
            <a href="<?php echo $base . 'register.php'; ?>">Đăng ký</a>
            <?php } ?>
          </div>
        </div>
      </div>
    </nav>

  </div>
</header>
<script>
function confirmLogout() {
  var confirmed = confirm('Bạn chắc chắn muốn đăng xuất không?');
  if (confirmed) {
    window.location.href = '../../controllers/UserControllers.php?logout=logout';
  }
}

function goToCart(event) {
  event.preventDefault();
  alert('Bạn chưa đăng nhập');
  window.location.href = baseUrl + 'login.php';
}

let navbarRepon = document.getElementById('nav-reponsive');
let openNavbar = document.getElementById('icon-navbar');
let closeNavbar = document.getElementById('close-navbar');

openNavbar.onclick = function openNavbar() {
  navbarRepon.style.transform = 'translateX(0)';
}

closeNavbar.onclick = function closeNavbar() {
  navbarRepon.style.transform = 'translateX(-100%)';
}
</script>