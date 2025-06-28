<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

$id = $_GET['id'];

$sql = "DELETE FROM tour_guides WHERE tour_guide_id=$id";

if (mysqli_query($link, $sql)) {
    header("Location: tampil_tour_guide.php");
} else {
    echo "Error deleting record: " . mysqli_error($link);
}

mysqli_close($link);
?>