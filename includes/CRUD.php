<?php
class CRUD {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    public function insertRecord($data) {
        $name = $data['name'];
        $email = $data['email'];

        $query = "INSERT INTO crud (name, email) VALUES ('$name', '$email')";
        $result = $this->conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateRecord($id, $data) {
        $name = $data['name'];
        $email = $data['email'];

        $query = "UPDATE crud SET name = '$name', email = '$email' WHERE id = $id";
        $result = $this->conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteRecord($id) {
        $query = "DELETE FROM crud  WHERE id = $id";
        $result = $this->conn->query($query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getAllRecords() {
        $query = "SELECT * FROM crud";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $records = array();
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            return $records;
        } else {
            return false;
        }
    }
}
?>
