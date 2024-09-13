<?php
    require_once __DIR__ . '/../config/connectDB.php';
class User {
    private $fullname;
    private $username;
    private $password;
    private $email;
    private $phonenumber;
    private $gender;
    private $birthday;
    private $role;
    private $avatar;
    private $dataManager;
    public function __construct($fullname = 'Unknown', $username = 'Unknown', $password = null, $email = 'Unknown', $phonenumber = 'Unknown', $gender = 'Unknown', $birthday = 'Unknown',$avatar = null, $role = "user",$dataManager = null) {
        $this->fullname = $fullname;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->role = $role;
        $this->avatar = $avatar;
        $this->dataManager = databaseManager::getInstance();
    }
    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhonenumber() {
        return $this->phonenumber;
    }

    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }
    public function getAvatar() {
        return $this->avatar;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }


    public function Login($db, $input) {
        $query = "SELECT * FROM users WHERE $db = '$input'";
        $result = $this->dataManager->executeQuery($query);
        return ($result->num_rows > 0) ? true : false;
    }
    public function register() {
        $query = "INSERT INTO users 
        (fullname, username, password, email, phonenumber, gender, birthday, avatar, role) VALUES 
        ('$this->fullname', '$this->username', '$this->password', '$this->email', '$this->phonenumber', '$this->gender', '$this->birthday', '$this->avatar', '$this->role')";
        return $this->dataManager->executeQuery($query);
    }
    public function getInfo($whereColumn, $byColumn, $inputCheck) {
        $query = "SELECT $whereColumn FROM users WHERE $byColumn = '$inputCheck'";
        $result = $this->dataManager->executeQuery($query);
        if ($row = $result->fetch_assoc()) {
            return $row[$whereColumn];
        } else {
            return null;
        }
    }
    public function isInfo($whereColumn, $inputCheck) {
        $query = "SELECT * FROM users WHERE $whereColumn = '$inputCheck'";
        $result = $this->dataManager->executeQuery($query);
        return ($result->num_rows > 0) ? true : false;
    }
    public function isInfoUpdate($whereColumn, $inputCheck, $user_id) {
        $query = "SELECT * FROM users WHERE $whereColumn = '$inputCheck' AND user_id != '$user_id'";
        $result = $this->dataManager->executeQuery($query);
        return ($result->num_rows > 0) ? true : false;
    }
    public function getUser($whereColumn, $inputCheck) {
        $query = "SELECT * FROM users WHERE $whereColumn = '$inputCheck'";
        $result = $this->dataManager->executeQuery($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    public function getAllUser() {
        $query = "SELECT * FROM users WHERE role != 'admin'";
        $result = $this->dataManager->executeQuery($query);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }
    public function updatePassword($user_id, $newPassword) {
        $query = "UPDATE users SET password = '$newPassword' WHERE user_id = '$user_id'";
        return $this->dataManager->executeQuery($query);
    }
    public function updateInfo($user_id) {
        $query = "UPDATE users SET fullname = '$this->fullname',  password = '$this->password', email = '$this->email', phonenumber = '$this->phonenumber', birthday = '$this->birthday', gender = '$this->gender', avatar = '$this->avatar' WHERE user_id = '$user_id'";
        return $this->dataManager->executeQuery($query);
    }
    public function getUserInfoByContact($contact) {
        $query = "SELECT * FROM users WHERE email = '$contact' OR phonenumber = '$contact'";
        $result = $this->dataManager->executeQuery($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return -1;
        }

    }
    public function isContactAndUserId($contact) {
        $query = "SELECT * FROM users WHERE email = '$contact' OR phonenumber = '$contact'";
        $result = $this->dataManager->executeQuery($query);
        if ($result->fetch_assoc()) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteUserById($user_id) {
        $query = "DELETE FROM users WHERE user_id = '$user_id'";
        $result = $this->dataManager->executeQuery($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function hasOrders($user_id) {
        $query = "SELECT COUNT(*) as count FROM invoices WHERE user_id = $user_id";
        $result = $this->dataManager->executeQuery($query);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
?>
