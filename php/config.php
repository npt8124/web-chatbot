<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "admin";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM food";
$result = $conn->query($sql);
?>