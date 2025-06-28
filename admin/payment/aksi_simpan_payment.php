<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses upload bukti pembayaran
    $upload_dir = 'uploads/';
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['payment_proof']['name'];
    $file_tmp = $_FILES['payment_proof']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_extensions)) {
        echo "Error: Format file tidak didukung. Silakan upload file gambar (jpg, jpeg, png, gif).";
        exit();
    }

    if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
        $username = $_SESSION['username'];
        $payment_proof = $upload_dir . $file_name;
        $status = 'PENDING'; // Status bisa disesuaikan, misalnya 'PENDING' atau 'CONFIRMED'
        $created_date = date('Y-m-d H:i:s');

        $query_payment = "INSERT INTO payment (username, payment_proof, status, created_date) VALUES (?, ?, ?, ?)";
        $stmt_payment = mysqli_prepare($link, $query_payment);
        mysqli_stmt_bind_param($stmt_payment, "ssss", $username, $payment_proof, $status, $created_date);

        if (mysqli_stmt_execute($stmt_payment)) {
            echo "Pembayaran berhasil disimpan. Menunggu konfirmasi dari admin.";
        } else {
            echo "Error: " . mysqli_error($link);
        }
    } else {
        echo "Error: Gagal mengupload file.";
    }
} else {
    echo "Akses tidak sah.";
}
?>
