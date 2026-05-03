<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'online_course_platform';
    private $port = '8889'; // Cổng MAMP của bạn
    
    private $dbh;
    private $stmt;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ));
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    // Hàm chuẩn bị câu lệnh SQL
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Hàm gán giá trị (Đã được nâng cấp để tự nhận diện kiểu dữ liệu)
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT; // Nếu là số nguyên, bind kiểu INT (giải quyết lỗi LIMIT)
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR; // Mặc định là chuỗi
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Hàm thực thi
    public function execute() {
        return $this->stmt->execute();
    }

    // Hàm lấy nhiều dòng dữ liệu (SELECT)
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Hàm lấy 1 dòng dữ liệu (SELECT single row)
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }
}