<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    $sql = "DELETE FROM paket_trip  WHERE id='$id'";
    if (mysqli_query($link, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
}

mysqli_close($link);
header("Location: tampil_paket.php");
exit();
?>
