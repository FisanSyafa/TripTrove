<?php
// koneksi.php

$link = mysqli_connect("localhost", "trip_fisan", "Databasefisan");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($link, "trip_triptrove") or die("Could not select database");
?>
