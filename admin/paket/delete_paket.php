<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

// Tangkap nama paket dari parameter URL
$nama = isset($_GET['nama_paket_trip']) ? urldecode($_GET['nama_paket_trip']) : '';

if ($nama) {
    // Hindari SQL injection dengan prepared statement
    $stmt = mysqli_prepare($link, "DELETE FROM paket_trip WHERE nama_paket_trip = ?");
    mysqli_stmt_bind_param($stmt, "s", $nama);

    if (mysqli_stmt_execute($stmt)) {
        // Sukses
    } else {
        echo "Error: " . mysqli_error($link);
        exit();
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
header("Location: tampil_paket.php");
exit();
?>

