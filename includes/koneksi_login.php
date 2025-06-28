<?php
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";  // Ganti dengan password database Anda
$dbname = "triptrove";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
