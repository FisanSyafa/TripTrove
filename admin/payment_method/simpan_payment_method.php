<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method_name = $_POST['payment_method_name'];
    $payment_method_code = $_POST['payment_method_code'];
    $super_admin_password = $_POST['super_admin_password'];

    if ($super_admin_password === 'superadmin') {
        $sql = "INSERT INTO payment_methods (payment_method_name, payment_method_code) VALUES (?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $payment_method_name, $payment_method_code);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: tampil_payment_method.php");
        } else {
            echo "Error: " . mysqli_error($link);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Incorrect Super Admin password!";
    }
}

mysqli_close($link);
?>