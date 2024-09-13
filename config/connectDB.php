<?php
class databaseManager {
    private static $instance = null;
    private $connect;

    private function __construct($host, $username, $pass, $database) {
        $this->connect = new mysqli($host, $username, $pass, $database);
        if($this->connect->connect_error) {
            exit('Kết nối lỗi');
        }

        if (!$this->connect->set_charset("utf8mb4")) {
            exit('Lỗi thiết lập mã hóa ký tự');
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self('localhost', 'root', 'lnh070601.', 'petshop');
            // self::$instance = new self('localhost', 'fz958rq7o3hc_petshop', 'Lnh070601.', 'fz958rq7o3hc_petshop');
        }
        return self::$instance;
    }

    public function executeQuery($query) {
        $result = $this->connect->query($query);
        return $result;
    }

    public function closeConnect() {
        $this->connect->close();
    }
}
?>
