<?php
// koneksi.php

$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($link, "triptrove") or die("Could not select database");
?>
