<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $email, $password) {
        $conn = $this->db->getConnection();
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        $result = $stmt->execute();
        
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function login($username, $password) {
        $conn = $this->db->getConnection();

        $sql = "SELECT id, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $id;
            return true;
        } else {
            return false;
        }

        $stmt->close();
        $conn->close();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();
    }
}
?>
