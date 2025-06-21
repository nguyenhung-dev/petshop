<?php
require_once __DIR__ . '/../../config/connectDB.php';
require_once __DIR__ . '/../../models/User.php';

$user = new User();
$users = $user->getAllUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý tài khoản</title>
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
      <h3>Danh sách khách hàng</h3>
      <div class="button">
        <a href="add-user.php">Tạo tài khoản</a>
      </div>
      <div class="list-customer" style="margin-top: 15px;">
        <table>
          <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Quyền truy cập</th>
            <th style="
                            text-align: center;
                        ">
            </th>
          </tr>
          <?php if (empty($users)) { ?>
          <tr>
            <td colspan="7" style="text-align: center;">Chưa có khách hàng nào đăng ký.</td>
          </tr>
          <?php } else { ?>
          <?php foreach ($users as $user) { ?>
          <tr>
            <td style="text-align: center;"><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['fullname']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phonenumber']; ?></td>
            <td><?php echo $user['birthday']; ?></td>
            <td><?php echo ($user['gender'] == 'male') ? 'Nam' : 'Nữ'; ?></td>
            <td><?php echo ($user['role'] == 'admin') ? 'Quản trị viên' : 'Người dùng'; ?></td>
            <td class="actions">
              <div class="btn">
                <a href="#"
                  onclick="confirmDelete('<?php echo $user['user_id']; ?>', '<?php echo $user['fullname']; ?>')"><i
                    class="fa-solid fa-trash"></i></a>
              </div>
            </td>
          </tr>
          <?php } ?>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <script>
  function confirmDelete(id, fullname) {
    var result = confirm("Xác nhận xóa tài khoản: " + fullname);
    if (result) {
      window.location.href = "../../controllers/UserControllers.php?action=delete&user_id=" + id;
    }
  }
  </script>
</body>

</html>