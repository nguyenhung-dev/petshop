<?php
require_once __DIR__ . '/../config/connectDB.php';

class Cart
{
    private $dataManager;

    public function __construct()
    {
        $this->dataManager = databaseManager::getInstance();
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addProductInCart($image, $name, $price, $user_id, $product_id, $product_count = 1)
    {
        $query = "INSERT INTO carts (image, name, price, user_id, product_id, product_count) VALUES ('$image', '$name', '$price', '$user_id', '$product_id', '$product_count')";
        return $this->dataManager->executeQuery($query);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateProductCount($user_id, $product_id, $count = 1)
    {
        $query = "UPDATE carts SET product_count = product_count + $count WHERE user_id = '$user_id' AND product_id = '$product_id'";
        return $this->dataManager->executeQuery($query);
    }

    // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
    public function productExistsInCart($user_id, $product_id)
    {
        $query = "SELECT COUNT(*) as count FROM carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result = $this->dataManager->executeQuery($query);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getAllProductsInCart($user_id)
    {
        $query = "SELECT * FROM carts WHERE user_id = '$user_id'";
        $result = $this->dataManager->executeQuery($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Tính tổng giá của giỏ hàng
    public function getTotalCartPrice($user_id)
    {
        $query = "SELECT SUM(price * product_count) as total FROM carts WHERE user_id = '$user_id'";
        $result = $this->dataManager->executeQuery($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Xóa sản phẩm khỏi giỏ hàng theo product_id
    public function deleteProductInCart($user_id, $product_id)
    {
        $query = "DELETE FROM carts WHERE user_id = '$user_id' AND product_id = '$product_id'";
        return $this->dataManager->executeQuery($query);
    }

    public function deleteProductInCartByUser($user_id)
    {
        $query = "DELETE FROM carts WHERE user_id = '$user_id'";
        return $this->dataManager->executeQuery($query);
    }
    // Xóa toàn bộ sản phẩm trong giỏ hàng của người dùng
    public function clearCart($user_id)
    {
        $query = "DELETE FROM carts WHERE user_id = '$user_id'";
        return $this->dataManager->executeQuery($query);
    }
    public function getValues($whereColumn, $value)
    {
        $query = "SELECT * FROM carts WHERE $whereColumn = '$value'";
        $result = $this->dataManager->executeQuery($query);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

}
?>