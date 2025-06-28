<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method_id = $_POST['payment_method_id'];
    $payment_method_name = $_POST['payment_method_name'];
    $payment_method_code = $_POST['payment_method_code'];
    $super_admin_password = $_POST['super_admin_password'];

    // Verifikasi password super admin
    $super_admin_username = "superadmin"; // Sesuaikan dengan username super admin Anda
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $super_admin_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if (password_verify($super_admin_password, $admin['password'])) {
        // Update payment method
        $sql = "UPDATE payment_methods SET payment_method_name = ?, payment_method_code = ? WHERE payment_method_id = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $payment_method_name, $payment_method_code, $payment_method_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: tampil_payment_method.php?status=success");
        } else {
            header("Location: edit_payment_method.php?id=$payment_method_id&status=error");
        }
    } else {
        header("Location: edit_payment_method.php?id=$payment_method_id&status=invalid_password");
    }
} else {
    header("Location: tampil_payment_method.php");
}
?>
