<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eis";
date_default_timezone_set("Asia/Manila");
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); 
}