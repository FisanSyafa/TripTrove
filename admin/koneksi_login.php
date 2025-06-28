<?php
$servername = "localhost";
$admin_name = "root";  // Ganti dengan username database Anda
$admin_password = "";  // Ganti dengan password database Anda
$dbname = "triptrove";

// Create connection
$conn = new mysqli($servername, $admin_name, $admin_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
