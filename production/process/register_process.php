<?php
include '../classes/autoload.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $user = new User();
    $result = $user->register($username, $email, $password);

    if ($result) {
        echo "Registration successful";
    } else {
        echo "Registration failed";
    }
}
?>
