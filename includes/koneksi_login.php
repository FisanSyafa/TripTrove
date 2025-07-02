<?php
$servername = "localhost";
$username = "trip_fisan";  // Ganti dengan username database Anda
$password = "Databasefisan";  // Ganti dengan password database Anda
$dbname = "trip_triptrove";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
