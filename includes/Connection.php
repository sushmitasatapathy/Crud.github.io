<?php
class Connection {
    private $conn;
    
    public function __construct() {
        $config = parse_ini_file('config.ini');
        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];
        
        $this->conn = new mysqli($host, $username, $password, $dbname);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
?>
