<?php
$servername = "localhost";
$admin_name = "trip_fisan";  // Ganti dengan username database Anda
$admin_password = "Databasefisan";  // Ganti dengan password database Anda
$dbname = "trip_triptrove";

// Create connection
$conn = new mysqli($servername, $admin_name, $admin_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
