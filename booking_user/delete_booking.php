<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    echo "Anda harus login untuk menghapus booking.";
    exit();
}

// Pastikan booking_id diberikan melalui GET parameter
if (!isset($_GET['booking_id'])) {
    echo "Booking ID tidak diberikan.";
    exit();
}

$booking_id = $_GET['booking_id'];
$username = $_SESSION['username'];

// Query untuk memastikan booking ID tersebut milik user yang login
$query_check = "SELECT * FROM bookings WHERE booking_id = ? AND username = ?";
$stmt_check = mysqli_prepare($link, $query_check);
mysqli_stmt_bind_param($stmt_check, "is", $booking_id, $username);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if ($result_check && mysqli_num_rows($result_check) > 0) {
    // Jika booking ditemukan, hapus booking tersebut
    $query_delete = "DELETE FROM bookings WHERE booking_id = ?";
    $stmt_delete = mysqli_prepare($link, $query_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $booking_id);

    if (mysqli_stmt_execute($stmt_delete)) {
        echo "Booking berhasil dihapus.";
        // Redirect ke halaman tampil_booking.php
        header("Location: tampil_booking.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }
} else {
    echo "Error: Booking tidak ditemukan atau Anda tidak memiliki izin untuk menghapus booking ini.";
}
?>
