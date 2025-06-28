<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $driver_id = $_POST['driver_id'];
    $driver_name = $_POST['driver_name'];
    $driver_address = $_POST['driver_address'];
    $driver_no_telp = $_POST['driver_no_telp'];

    $sql = "UPDATE drivers SET driver_name='$driver_name', driver_address='$driver_address', driver_no_telp='$driver_no_telp' WHERE driver_id=$driver_id";

    if (mysqli_query($link, $sql)) {
        header("Location: tampil_driver.php");
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>