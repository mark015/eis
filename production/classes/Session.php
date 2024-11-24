<?php
class Session {
    public function __construct() {
        session_start();
    }

    public function getSessionUserId() {
        return $_SESSION['user_id'] ?? null;
    }
}
?>
