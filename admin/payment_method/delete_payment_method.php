<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM payment_methods WHERE payment_method_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: tampil_payment_method.php");
    } else {
        echo "Error deleting record: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request";
}