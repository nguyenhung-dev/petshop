<?php
// class databaseManager {
//     private static $instance = null;
//     private $connect;

//     private function __construct($host, $username, $pass, $database) {
//         $this->connect = new mysqli($host, $username, $pass, $database);
//         if($this->connect->connect_error) {
//             exit('Kết nối lỗi');
//         }

//         if (!$this->connect->set_charset("utf8mb4")) {
//             exit('Lỗi thiết lập mã hóa ký tự');
//         }
//     }

//     public static function getInstance() {
//         if (self::$instance === null) {
//             self::$instance = new self('localhost', 'root', 'lnh070601.', 'petshop');
//         }
//         return self::$instance;
//     }

//     public function executeQuery($query) {
//         $result = $this->connect->query($query);
//         return $result;
//     }

//     public function closeConnect() {
//         $this->connect->close();
//     }
// }
class databaseManager
{
    private static $instance = null;
    private $connect;

    private function __construct($host, $username, $pass, $database, $socket = null)
    {
        if ($socket) {
            $this->connect = new mysqli(null, $username, $pass, $database, null, $socket);
        } else {
            $this->connect = new mysqli($host, $username, $pass, $database);
        }

        if ($this->connect->connect_error) {
            exit('Kết nối lỗi');
        }

        if (!$this->connect->set_charset("utf8mb4")) {
            exit('Lỗi thiết lập mã hóa ký tự');
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self('localhost', 'root', 'lnh070601.', 'petshop', '/var/run/mysqld/mysqld.sock');
        }
        return self::$instance;
    }

    public function executeQuery($query)
    {
        $result = $this->connect->query($query);
        return $result;
    }

    public function closeConnect()
    {
        $this->connect->close();
    }
}
?>