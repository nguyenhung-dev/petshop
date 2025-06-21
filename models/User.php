?>
<?php
require_once __DIR__ . '/../config/connectDB.php';

class User
{
    private $db;
    private $errors = [];

    public function __construct()
    {
        $this->db = databaseManager::getInstance();
    }

    public function getAllUser()
    {
        $sql = "SELECT * FROM users";
        $result = $this->db->executeQuery($sql);

        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // Lấy thông tin người dùng bằng username
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->db->executeQuery($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    public function getInfo($whereColumn, $byColumn, $inputCheck)
    {
        $query = "SELECT $whereColumn FROM users WHERE $byColumn = '$inputCheck'";
        $result = $this->db->executeQuery($query);
        if ($row = $result->fetch_assoc()) {
            return $row[$whereColumn];
        } else {
            return null;
        }
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        return $this->db->executeQuery($sql);
    }

    public function isInfo($column, $value)
    {
        $sql = "SELECT * FROM users WHERE $column = '$value'";
        return $this->db->executeQuery($sql) ? true : false;
    }

    public function loginUser($db, $input)
    {
        $query = "SELECT * FROM users WHERE $db = '$input'";
        $result = $this->db->executeQuery($query);
        return ($result->num_rows > 0) ? true : false;
    }

    public function isInfoExists($column, $value)
    {
        $query = "SELECT * FROM users WHERE $column = '$value'";
        $result = $this->db->executeQuery($query);
        return $result && $result->num_rows > 0;
    }

    public function registerUser($fullname, $username, $password, $email, $phonenumber, $gender, $birthday, $avatar)
    {
        $password = md5($password); // Mã hóa mật khẩu
        $query = "INSERT INTO users (fullname, username, password, email, phonenumber, gender, birthday, avatar) 
                  VALUES ('$fullname', '$username', '$password', '$email', '$phonenumber', '$gender', '$birthday', '$avatar')";
        return $this->db->executeQuery($query);
    }
    public function getErrors()
    {
        return $this->errors;
    }

    public function updatePasswordByEmail($email, $newPassword)
    {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$newPasswordHash' WHERE email = '$email'";
        return $this->db->executeQuery($sql);
    }

    public function updatePassword($userId, $newPassword)
    {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$newPasswordHash' WHERE user_id = $userId";
        return $this->db->executeQuery($sql);
    }

    public function deleteUser($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = $userId";
        return $this->db->executeQuery($sql);
    }
    public function hasOrders($user_id)
    {
        $query = "SELECT COUNT(*) as count FROM invoices WHERE user_id = $user_id";
        $result = $this->db->executeQuery($query);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    public function getUser($whereColumn, $inputCheck)
    {
        $query = "SELECT * FROM users WHERE $whereColumn = '$inputCheck'";
        $result = $this->db->executeQuery($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}